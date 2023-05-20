<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\FollowPost;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function categoryPosts(Request $request, $slug)
    {
        if (!$slug) {
            return abort(404);
        } else {
            $subcategory = SubCategory::where('slug', $slug)->first();
            if (!$subcategory) {
                return abort(404);
            } else {
                $posts = Post::where('category_id', $subcategory->id)
                    ->where('status','!=',0)
                    ->orderBy('created_at', 'desc')
                    ->paginate(8);
                //  truyền qua trang danh mục cuat blog 
                $data = [
                    'pageTitle' => 'Category - ' . $subcategory->subcategory_name,
                    'category' => $subcategory,
                    'posts' => $posts
                ];
                return view('front.pages.category_posts', $data);
            }
        }

    }

    public function searchBlog(Request $request)
    {
        $query = request()->query('query');
        if ($query && strlen($query) >= 1) {
            $searchValues = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY);
            $posts = Post::query();
            $posts->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->orWhere('post_title', 'LIKE', "%{$value}%");
                    $q->orWhere('post_tags', 'LIKE', "%{$value}%");
                    $q->orWhereHas('author', function ($query) use ($value) {
                        $query->where('name', 'LIKE', "%{$value}%");
                    });
                }

            });
            $posts = $posts->with('subcategory')
                ->with('author')
                ->where('status','!=',0)
                ->orderBy('created_at', 'desc')
                ->paginate(8);
            $count = $posts->total();
            $data = [
                'pageTitle' => 'Tìm thấy ' . $count . ' kết quả cho : ' . request()->query('query'),
                'posts' => $posts
            ];
            return view('front.pages.search_posts', $data);
        } else {
            return redirect()->route('home');
        }
    }

    public function readPost($slug)
    {
        if (!$slug) {
            return abort(404);
        } else {
            $post = Post::where('post_slug', $slug)
                ->where('status','!=',0)
                ->with('subcategory')
                ->with('author')
                ->first();

            // Increment view count
            $post->views += 1;
            $post->save();

            $post_tags = explode(',', $post->post_tags);
            $related_posts = Post::where('id', '!=', $post->id)
                ->where('status','=',1)
                ->where(function ($query) use ($post_tags, $post) {
                    foreach ($post_tags as $item) {
                        $query->orWhere('post_tags', 'like', "%$item%")
                            ->orWhere('post_title', 'like', $post->post_title);
                    }
                })
                ->inRandomOrder()
                ->take(5)
                ->get();

            $data = [
                'pageTitle' => Str::ucfirst($post->post_title),
                'post' => $post,
                'related_posts' => $related_posts
            ];
            return view('front.pages.single_post', $data);
        }
    }

    public function tagPosts(Request $request, $tag)
    {
        $posts = Post::where('post_tags', 'like', '%' . $tag . '%')
            ->with('subcategory')
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        if (!$posts)
            return abort(404);

        $data = [
            'pageTitle' => '#' . $tag,
            'posts' => $posts
        ];

        return view('front.pages.tag_posts', $data);
    }


    //  hiển thị form đăng nhập
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        if (session()->has('login_success')) {
            session()->forget('login_success');
            return redirect('/');
        }

        return view('front.pages.user.login');
    }

    // đăng nhập user
    public function login(Request $request)
    {


        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ($fieldType == 'email') {
            $request->validate([
                'login_id' => 'Required|email|exists:users,email',
                'password' => 'Required|min:5'
            ], [
                    'login_id.required' => 'Email hoặc Username không được để trống',
                    'login_id.email' => 'Địa chỉ email không hợp lệ',
                    'login_id.exists' => 'Email không tồn tại',
                    'password.required' => 'Password không được để trống'
                ]);
        } else {
            $request->validate([
                'login_id' => 'Required|exists:users,username',
                'password' => 'Required|min:5'
            ], [
                    'login_id.required' => 'Email hoặc Username không được để trống',
                    'login_id.exists' => 'Username không tồn tại',
                    'login_id.password' => 'Password không được để trống'
                ]);

        }

        $user = User::where($fieldType, $request->login_id)->first();
        if (password_verify($request->password, $user->password)) {
            if ($user->blocked == 0) {

                $request->session()->put('user', [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'picture' => $user->picture,
                    'biography' => $user->biography
                ]);
                session()->put('login_success', true);


                return redirect('/');
            } else {
                session()->forget('login_success');
                session()->forget('user');

                session()->flash('fail', 'Tài khoản của bạn đã bị khóa.');
                return redirect()->route('login');
            }


        } else {
            session()->flash('fail', 'Mật khẩu của bạn không đúng.');

            return redirect()->route('login');

        }


    }

    // đăng xuất tài khoản
    public function logout()
    {

        session()->forget('login_success');
        session()->forget('user');
        return redirect('/');


    }

    // hiển thị form đăng kí tài khoản
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        if (session()->has('login_success')) {
            session()->forget('login_success');
            return redirect('/');
        }

        return view('front.pages.user.register');
    }

    // đăng ký tài khoản
    public function register(Request $request)
    {
        // dd($request);
        $request->validate([
            'username' => 'required|unique:users,username|min:10',
            'email' => 'Required|email|unique:users,email',
            'password' => 'required|min:5',
            'confirm_password' => 'same:password',
            'fullname' => 'required'

        ], [
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có từ 5 ký tự trở lên',
                'confirm_password.same' => 'Mật khẩu xác nhập không trùng',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không hợp lệ',
                'email.unique' => 'Email đã tồn tại',
                'fullname.required' => "Họ và tên không được để trống",
                'username.required' => 'username không được để trống',
                'username.unique' => 'Username đã tồn tại',
                'username.min' => 'Username phải từ 10 kí tự trở lên'
            ]);





        $token = Str::random(10);
        $userregis = new User();
        $userregis->name = $request->fullname;
        $userregis->email = $request->email;
        $userregis->username = $request->username;
        $userregis->password = bcrypt($request->confirm_password);
        $userregis->blocked = 1;
        $userregis->type = 3;
        $userregis->remember_token = $token;
        $save = $userregis->save();
        $data = array(
            'name' => $request->fullname,
            'email' => $request->email,
            'token' => $token,
            'url' => route('login'),

        );

        $author_email = $request->email;
        $author_name = $request->fullname;
        if ($save) {
            Mail::send('new-user-blog', $data, function ($message) use ($author_email, $author_name) {
                $message->from('huynhhuy12149@gmail.com', 'LaraBlog');
                $message->to($author_email, $author_name)
                    ->subject('Account Creation');
            });

        }
        session()->flash('success', 'Tài khoản của bạn đã được tạo thành công vui lòng kích hoạt.');
        return redirect()->route('login');

    }

    // khi đăng kí mặc định tài khoản sẽ khóa thì hàm này active tài khoản đăng nhập
    public function active_account($email, $token)
    {
        // dd($email, $token);
        $check = User::where('email', $email)
            ->where('remember_token', $token)
            ->first();
        if ($check->remember_token == $token && $check->email == $email) {
            if ($check->update(['remember_token' => null, 'blocked' => 0])) {
                session()->flash('success', 'Tài khoản của bạn đã được kích hoạt thành công.');
                return redirect()->route('login');
            } else {
                session()->flash('fail', 'Tài khoản của bạn chưa được kích hoạt.');

            }

        }
    }


    // quên mật khẩu đăng nhập

    public function showforgotuser()
    {
        return view('front.pages.user.forgot-user');
    }

    public function forgot_user(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
                'email.required' => 'Email không được để trống ',
                'email.email' => 'Email không hợp lệ',
                'email.exists' => 'Email chưa được đăng ký'
            ]);

        $token = Str::random(10);
        $user = User::where('email', $request->email)->first();
        if($user->type == 3){
            if (DB::table('password_resets')->where('email', $user->email)->exists()) {
                DB::table('password_resets')->where('email', $user->email)->update([
                    'token' => $token,
                ]);
            } else {
                DB::table('password_resets')->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]);
            }
            $data = array(
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token
            );
    
            Mail::send('forgot-email-guest-blog-template', $data, function ($message) use ($user) {
                $message->from('huynhhuy12149@gmail.com', 'Larablog');
                $message->to($user->email, $user->name)->subject('Reset Password');
    
                
            });
    
    
    
            session()->flash('success', 'Chúng tôi đã gửi đến email của bạn link để lấy lại mật khẩu');
        }else{
            session()->flash('fail', 'Không thể đổi mật khẩu tài khoản này');
        }
            
        
        
        

        return redirect()->route('forgot-user');

    }

    public function ResetForm($token, $email)
    {
        $checktoken = DB::table('password_resets')->where(
            [
                'email' => $email,
                'token' => $token,
            ]
        )->first();

        if ($checktoken) {
            return view('front.pages.user.reset-form')->with([
                'token' => $token,
                'email' => $email,
            ]);

        }
        return abort(404);
    }

    public function changepassword($token, $email, Request $request)
    {
        $request->validate([
            'email' => 'Required|email|exists:users,email',
            'new_password' => 'required|min:5',
            'confirm_password' => 'same:new_password'

        ], [
                'new_password.required' => 'Mẩu khẩu không được để trống',
                'new_password.min' => 'Mật khẩu pahir từ 5 kí tự trở lên',
                'confirm_password' => 'Mật khẩu không trùng',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không hợp lệ',
                'email.exists' => 'Email chưa đăng ký',
            ]);

        $checktoken = DB::table('password_resets')->where(
            [
                'email' => $request->email,
                'token' => $token,
            ]
        )->first();
        if (!$checktoken) {
            session()->flash('fail', 'Link thay đổi mật khẩu sai vui lòng kiểm tra lại.');

        } else {
            User::where('email', $request->email)->update([
                'password' => bcrypt($request->new_password)
            ]);
            DB::table('password_resets')->where([
                'email' => $request->email
            ])->delete();

            session()->flash('success', 'Mật khẩu đã được cập nhật thành công.');
            return redirect()->route('login');
        }
        return redirect()->route('login');

    }


    // phần bình luận
    public function comment($user_id,$post_id,Request $request){
        $request->validate([
            'content'=>'required',
        ],[
            'content.required'=>'Bình luận không được để trống',
        ]);

        $data =[
            'user_id'=>$user_id,
            'post_id'=>$post_id,
            'content'=>$request->content,
            'reply_id'=>$request->reply_id ? $request->reply_id : 0,
        ];
        if ($comment = Comment::create($data)) {
            // return response()->json(['status'=>1,'msg'=>'Bình luận thành công']);
            $comments = Comment::where(['post_id'=>$post_id,'reply_id'=>0])->orderBy('created_at','DESC')->get();
            return view('front.pages.list_comment',compact('comments'));
        } else{
            return response()->json(['status'=>2,'msg'=>'Bình luận thất bại']);
        }

        
    }


    // lọc tất cả bài post của một tác giả

    public function authorPosts(Request $request,$id){
        if (!$id) {
            return abort(404);
        } else {
            // $subcategory = SubCategory::where('slug', $slug)->first();
            $check = Post::where('author_id',$id)->first();
            
            if(!$check){
                return abort(404);
            }else{
                $posts = Post::where('author_id', $id)
                        ->where('status',1)
                        ->orderBy('created_at', 'desc')
                        ->paginate(8);
                    //  truyền qua trang danh mục cuat blog 
                    $data = [
                        'pageTitle' => 'Tác giả - ' . $check->author->name,
                        'name'=> $check->author->name,
                        'posts' => $posts
                    ];
                    
                    return view('front.pages.author_posts', $data);
            }
            // if (!$subcategory) {
            //     return abort(404);
            // } else {
            //     $posts = Post::where('category_id', $subcategory->id)
            //         ->orderBy('created_at', 'desc')
            //         ->paginate(8);
            //     //  truyền qua trang danh mục cuat blog 
            //     $data = [
            //         'pageTitle' => 'Category - ' . $subcategory->subcategory_name,
            //         'category' => $subcategory,
            //         'posts' => $posts
            //     ];
            //     return view('front.pages.category_posts', $data);
            // }
        }
        
        
    }


    // follow bài viết nữa để xem sau
    public function savePostGuest($user_id,$post_id,Request $request){
        $data = [
            'user_id'=>$user_id,
            'post_id'=>$post_id,
            
        ];
        $followpost =FollowPost::create($data);
        
    }

    public function deteleFollowPostGuest($user_id,$post_id,Request $request){
       
        $check =FollowPost::where('post_id', $post_id)->where('user_id', $user_id)->exists();
        if($check){
            FollowPost::where('post_id', $post_id)->where('user_id', $user_id)->delete();
        }
    }

    // hiển thị tất cả các  bài viết xem sau khi follow 
    public function watchtPostFollowGuest(Request $request,$user_id){
        $check = FollowPost::where('user_id',$user_id)->first();
        
        if(!$check){
            return view('front.pages.no-data');
        }else{
             
            $datapost = FollowPost::where('user_id', $user_id)->pluck('post_id')->toArray();
            $posts = Post::whereIn('id', $datapost)
                            ->orderBy('created_at', 'desc')
                            ->paginate(8);

                $data = [
                    'pageTitle' => 'Bài viết xem sau - ' . $check->user->name,
                    'name'=> $check->user->name,
                    'posts' => $posts
                ];
                
                return view('front.pages.follow_post_user', $data);
        }
    }


    public function contacthandle(Request $request){
        $request -> validate([
            'email' => 'Required|email:email',
            'name' => 'Required',
            'subject'=> 'Required',
            'messages'=>'Required'
        ],[
            'email.required'=>'Email không được để trống',
            'email.email'=>'Email không hợp lệ',
            'subject.required'=>'Chủ đề không được để trống',
            'messages.required'=>'Nội dung không được để trống',
            'name.required'=>'Họ tên không được để trống'
        ]); 

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'subject'=>$request->subject,
            'messages'=>$request->messages
            

        );
        $mail = 'huynhhuy12149@gmail.com';
        $namemail = 'LaraBlog';
        
        $mail = Mail::send('template-contact', $data, function ($message) use ($mail, $namemail) {
            $message->from('huynhhuy12149@gmail.com', 'LaraBlog');
            $message->to($mail, $namemail)
                ->subject('Account Creation');
        });
        if($mail){
            session()->flash('success', 'Bạn đã gửi phản hồi thành công. Cảm ơn bạn đã sử dụng LaraBlog');
            return redirect()->route('contact');
        }else{
            session()->flash('fail', 'Bạn gửi không thành công. Cảm ơn bạn đã sử dụng LaraBlog');
            return redirect()->route('contact');
        }
    }

}