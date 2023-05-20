<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        return view('back.pages.home');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('author.login');
    }

    public function ResetForm(Request $request, $token = null)
    {
        $data = [
            'pageTitle' => 'Đặt lại mật khẩu'
        ];
        return view('back.pages.auth.reset', $data)->with(['token' => $token, 'email' => $request->email]);
    }

    public function active_account_author($email, $token)
    {
        // dd($email, $token);
        $check = User::where('email', $email)
            ->where('remember_token', $token)
            ->first();
        if ($check->remember_token == $token && $check->email == $email) {
            if ($check->update(['remember_token' => null, 'blocked' => 0])) {
                session()->flash('success', 'Tài khoản của bạn đã được kích hoạt thành công.');
                return redirect()->route('author.login');
            } else {
                session()->flash('fail', 'Tài khoản của bạn chưa được kích hoạt.');

            }

        }
    }

    public function changeProfilePicture(Request $request)
    {
        $user = User::find(auth('web')->id());
        $path = 'back/dist/img/authors/';
        $file = $request->file('file');
        $old_picture = $user->getAttributes()['picture'];
        $file_path = $path . $old_picture;
        $new_picture_name = 'AIMG' . $user->id . time() . rand(1, 100000) . '.jpg';

        if ($old_picture != null && File::exists(public_path($file_path))) {
            File::delete(public_path($file_path));
        }
        $upload = $file->move(public_path($path), $new_picture_name);
        if ($upload) {
            $user->update([
                'picture' => $new_picture_name
            ]);
            return response()->json(['status' => 1, 'msg' => 'Hình ảnh của bạn đã được cập nhật.']);
        } else {
            return response()->json(['status' => 0, 'Cập nhật hình ảnh thất bại']);
        }
    }

    public function changeBlogLogo(Request $request)
    {
        $settings = Setting::find(1);
        $logo_path = 'back/dist/img/logo-favicon';
        $old_logo = $settings->getAttributes()['blog_logo'];
        $file = $request->file('blog_logo');
        $filename = time() . '_' . rand(1, 100000) . '_blog_logo.png';
        if ($request->hasFile('blog_logo')) {
            if ($old_logo != null && File::exists(public_path($logo_path . $old_logo))) {
                File::delete(public_path($logo_path . $old_logo));
            }
            $upload = $file->move(public_path($logo_path), $filename);

            if ($upload) {
                $settings->update([
                    'blog_logo' => $filename
                ]);
                return response()->json(['status' => 1, 'msg' => 'Logo cập nhật thành công.']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Có gì đó sai, cập nhật logo thất bại']);
            }
        }
    }
    // changeBlogFavicon
    public function changeBlogFavicon(Request $request)
    {
        $settings = Setting::find(1);
        $favicon_path = 'back/dist/img/logo-favicon';
        $old_favicon = $settings->getAttributes()['blog_favicon'];
        $file = $request->file('blog_favicon');
        $filename = time() . '_' . rand(1, 10000) . '_blog_favicon.ico';
        if ($request->hasFile('blog_favicon')) {
            if ($old_favicon != null && File::exists(public_path($favicon_path . $old_favicon))) {
                File::delete(public_path($favicon_path . $old_favicon));
            }
            $upload = $file->move(public_path($favicon_path), $filename);

            if ($upload) {
                $settings->update([
                    'blog_favicon' => $filename
                ]);
                return response()->json(['status' => 1, 'msg' => 'favicon cập nhật thành công.']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Có gì đó sai, cập nhật favicon thất bại']);
            }
        }
    }

    // add post
    public function createPost(Request $request)
    {
        $request->validate([
            'post_title' => 'required|unique:posts,post_title',
            'post_content' => 'required',
            'post_category' => 'required|exists:sub_categories,id',
            'featured_image' => 'required|mimes:jpeg,jpg,png|max:1024',
        ],[
            'post_title.required'=>'Tiêu đề không được để trống.',
            'post_title.unique'=>'Tiêu đề đã tồn tại.',
            'post_content.required'=>'Nội dung bài viết không được để trống.',
            'post_category.required'=>'Phải chọn danh mục bài viết.',
            'post_category.exists'=>'Tiêu đề không hợp lệ.',
            'featured_image.required'=>'Hình ảnh không được để trống.',
            'featured_image.mines'=>'Định dạng hình ảnh pahir là jpeg,jpg,png.',
            'featured_image.max'=>'Tối đa là 1024.'
        ]);

        if ($request->hasFile('featured_image')) {
            $path = "images/post_images/";
            $file = $request->file('featured_image');
            $filename = $file->getClientOriginalName();
            $new_filename = time() . '_' . $filename;

            $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));

            $post_thumbnails_path = $path . 'thumbnails';
            if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
            }

            // tao mot square thumbnails
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(200, 200)
                ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));

            // tao kich thuoc resize image
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(500, 300)
                ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'resized_' . $new_filename));

            if ($upload) {
                $post = new Post();
                $post->author_id = auth()->id();
                $post->category_id = $request->post_category;
                $post->post_title = $request->post_title;
                // $post->post_slug = Str::slug($request->post_title);
                $post->post_content = $request->post_content;
                $post->featured_image = $new_filename;
                $post->post_tags = $request->post_tags;
                $post->status = 0;
                $saved = $post->save();

                if ($saved) {
                    return response()->json(['code' => 1, 'msg' => 'Thêm bài viết thành công.']);
                } else {
                    return response()->json(['code' => 3, 'msg' => 'Có lỗi xảy ra, thêm thất bại.']);
                }

            } else {
                return response()->json(['code' => 3, 'msg' => 'Có lỗi xảy ra khi tải hình ảnh lên máy chủ']);
            }
        }
    }


    // post
    public function editPost(Request $request)
    {
        if (!request()->post_id) {
            return abort(404);

        } else {
            $post = Post::find(request()->post_id);
            $data = [
                'post' => $post,
                'pageTitle' => 'Edit Post'
            ];
            return view('back.pages.edit_post', $data);
        }
    }

    public function updatePost(Request $request)
    {
        if(auth()->user()->type == 1){
            if ($request->hasFile('featured_image')) {
                $request->validate([
                    'post_title' => 'required|unique:posts,post_title',
                    'post_content' => 'required',
                    'post_category' => 'required|exists:sub_categories,id',
                    'featured_image' => 'required|mimes:jpeg,jpg,png|max:1024',
                ],[
                    'post_title.required'=>'Tiêu đề không được để trống.',
                    'post_title.unique'=>'Tiêu đề đã tồn tại.',
                    'post_content.required'=>'Nội dung bài viết không được để trống.',
                    'post_category.required'=>'Phải chọn danh mục bài viết.',
                    'post_category.exists'=>'Tiêu đề không hợp lệ.',
                    'featured_image.required'=>'Hình ảnh không được để trống.',
                    'featured_image.mines'=>'Định dạng hình ảnh pahir là jpeg,jpg,png.',
                    'featured_image.max'=>'Tối đa là 1024.'
                ]);
    
                $path = "images/post_images/";
                $file = $request->file('featured_image');
                // $filename = $file->getClientOriginalName();
                $filename = $file->getClientOriginalName();
                $new_filename = time() . '_' . $filename;
                $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));
                $post_thumbnails_path = $path . 'thumbnails';
                if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                    Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
                }
    
                // tao mot square thumbnails
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(200, 200)
                    ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));
    
                // tao kich thuoc resize image
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(500, 300)
                    ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'resized_' . $new_filename));
    
                if ($upload) {
                    $old_post_image = Post::find($request->post_id)->featured_image;
                    if ($old_post_image != null && Storage::disk('public')->exists($path . $old_post_image)) {
                        Storage::disk('public')->delete($path . $old_post_image);
                        if (Storage::disk('public')->exists($path . 'thumnails/resized_' . $old_post_image)) {
                            Storage::disk('public')->delete($path . 'thumnails/resized_' . $old_post_image);
                        }
    
                        if (Storage::disk('public')->exists($path . 'thumnails/thumb_' . $old_post_image)) {
                            Storage::disk('public')->delete($path . 'thumnails/thumb_' . $old_post_image);
                        }
                    }
    
                    $post = Post::find($request->post_id);
    
                    $post->category_id = $request->post_category;
                    $post->post_slug = null;
                    $post->post_content = $request->post_content;
                    $post->post_title = $request->post_title;
                    $post->featured_image = $new_filename;
                    $post->post_tags = $request->post_tags;
                    // $post->status = 0;
                    $save = $post->save();
                    if ($save) {
                        return response()->json(['status' => 1, 'msg' => 'Bài viết được cập nhật thành công.']);
                    } else {
                        return response()->json(['status' => 3, 'msg' => 'Bài viết cập nhật thất bại.']);
                    }
                } else {
                    return response()->json(['status' => 3, 'msg' => 'Upload ảnh lỗi']);
                }
            } else {
                $request->validate([
                    'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
                    'post_content' => 'required',
                    'post_category' => 'required|exists:sub_categories,id'
                ]);
                $post = Post::find($request->post_id);
                $post->category_id = $request->post_category;
                $post->post_slug = null;
                $post->post_content = $request->post_content;
                $post->post_title = $request->post_title;
                $post->post_tags = $request->post_tags;
                // $post->status = 0;
    
                $save = $post->save();
                if ($save) {
                    return response()->json(['status' => 1, 'msg' => 'Bài viết được cập nhật thành công.']);
                } else { 
                    return response()->json(['status' => 3, 'msg' => 'Bài viết cập nhật thất bại.']);
                }
    
            }
        }
        if(auth()->user()->type == 2){
            if ($request->hasFile('featured_image')) {
                $request->validate([
                    'post_title' => 'required|unique:posts,post_title',
                    'post_content' => 'required',
                    'post_category' => 'required|exists:sub_categories,id',
                    'featured_image' => 'required|mimes:jpeg,jpg,png|max:1024',
                ],[
                    'post_title.required'=>'Tiêu đề không được để trống.',
                    'post_title.unique'=>'Tiêu đề đã tồn tại.',
                    'post_content.required'=>'Nội dung bài viết không được để trống.',
                    'post_category.required'=>'Phải chọn danh mục bài viết.',
                    'post_category.exists'=>'Tiêu đề không hợp lệ.',
                    'featured_image.required'=>'Hình ảnh không được để trống.',
                    'featured_image.mines'=>'Định dạng hình ảnh pahir là jpeg,jpg,png.',
                    'featured_image.max'=>'Tối đa là 1024.'
                ]);
    
                $path = "images/post_images/";
                $file = $request->file('featured_image');
                // $filename = $file->getClientOriginalName();
                $filename = $file->getClientOriginalName();
                $new_filename = time() . '_' . $filename;
                $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));
                $post_thumbnails_path = $path . 'thumbnails';
                if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                    Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
                }
    
                // tao mot square thumbnails
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(200, 200)
                    ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));
    
                // tao kich thuoc resize image
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(500, 300)
                    ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'resized_' . $new_filename));
    
                if ($upload) {
                    $old_post_image = Post::find($request->post_id)->featured_image;
                    if ($old_post_image != null && Storage::disk('public')->exists($path . $old_post_image)) {
                        Storage::disk('public')->delete($path . $old_post_image);
                        if (Storage::disk('public')->exists($path . 'thumnails/resized_' . $old_post_image)) {
                            Storage::disk('public')->delete($path . 'thumnails/resized_' . $old_post_image);
                        }
    
                        if (Storage::disk('public')->exists($path . 'thumnails/thumb_' . $old_post_image)) {
                            Storage::disk('public')->delete($path . 'thumnails/thumb_' . $old_post_image);
                        }
                    }
    
                    $post = Post::find($request->post_id);
    
                    $post->category_id = $request->post_category;
                    $post->post_slug = null;
                    $post->post_content = $request->post_content;
                    $post->post_title = $request->post_title;
                    $post->featured_image = $new_filename;
                    $post->post_tags = $request->post_tags;
                    $post->status = 0;
                    $save = $post->save();
                    if ($save) {
                        return response()->json(['status' => 1, 'msg' => 'Bài viết được cập nhật thành công.']);
                    } else {
                        return response()->json(['status' => 3, 'msg' => 'Bài viết cập nhật thất bại.']);
                    }
                } else {
                    return response()->json(['status' => 3, 'msg' => 'Upload ảnh lỗi']);
                }
            } else {
                $request->validate([
                    'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
                    'post_content' => 'required',
                    'post_category' => 'required|exists:sub_categories,id'
                ],[
                    'post_title.required'=>'Tiêu đề không được để trống.',
                    'post_title.unique'=>'Tiêu đề đã tồn tại.',
                    'post_content.required'=>'Nội dung bài viết không được để trống.',
                    'post_category.required'=>'Phải chọn danh mục bài viết.',
                    'post_category.exists'=>'Tiêu đề không hợp lệ.',
                    'featured_image.required'=>'Hình ảnh không được để trống.',
                    'featured_image.mines'=>'Định dạng hình ảnh pahir là jpeg,jpg,png.',
                    'featured_image.max'=>'Tối đa là 1024.'
                ]);
                $post = Post::find($request->post_id);
                $post->category_id = $request->post_category;
                $post->post_slug = null;
                $post->post_content = $request->post_content;
                $post->post_title = $request->post_title;
                $post->post_tags = $request->post_tags;
                $post->status = 0;
    
                $save = $post->save();
                if ($save) {
                    return response()->json(['status' => 1, 'msg' => 'Bài viết được cập nhật thành công và đang chờ xét duyệt lại.']);
                } else { 
                    return response()->json(['status' => 3, 'msg' => 'Bài viết cập nhật thất bại.']);
                }
    
            }
        }
       
    }


    // duyệt baig post
    public function activePost(Request $request)
    {
        if (!request()->post_id) {
            return abort(404);

        } else {
            $post = Post::find(request()->post_id);
            $data = [
                'post' => $post,
                'pageTitle' => 'Cập nhật bài viết'
            ];
            return view('back.pages.active_post', $data);
        }
    }

    // cập nhật duyệt bài cho admin hàm riêng
     public function updateStatusPostActive(Request $request){
        $post = Post::find($request->post_id);

                $post->status = 1;

                $save = $post->save();
                if ($save) {

                    return response()->json(['status' => 1, 'msg' => 'Bài báo đã được duyệt thành công']);
                } else {
                    return response()->json(['status' => 3, 'msg' => 'Bài báo duyệt không thành công.']);
                }
     }
    public function updatePostActive(Request $request)
    {
        if(auth()->user()->type == 1){
            if ($request->hasFile('featured_image')) {
                $request->validate([
                    'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
                    'post_content' => 'required',
                    'post_category' => 'required|exists:sub_categories,id',
                    'featured_image' => 'mimes:jpeg,jpg,png|max:1024'
                ],[
                    'post_title.required'=>'Tiêu đề không được để trống.',
                    'post_title.unique'=>'Tiêu đề đã tồn tại.',
                    'post_content.required'=>'Nội dung bài viết không được để trống.',
                    'post_category.required'=>'Phải chọn danh mục bài viết.',
                    'post_category.exists'=>'Tiêu đề không hợp lệ.',
                    'featured_image.required'=>'Hình ảnh không được để trống.',
                    'featured_image.mines'=>'Định dạng hình ảnh pahir là jpeg,jpg,png.',
                    'featured_image.max'=>'Tối đa là 1024.'
                ]);
    
                $path = "images/post_images/";
                $file = $request->file('featured_image');
                // $filename = $file->getClientOriginalName();
                $filename = $file->getClientOriginalName();
                $new_filename = time() . '_' . $filename;
                $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));
                $post_thumbnails_path = $path . 'thumbnails';
                if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                    Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
                }
    
                // tao mot square thumbnails
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(200, 200)
                    ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));
    
                // tao kich thuoc resize image
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(500, 300)
                    ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'resized_' . $new_filename));
    
                if ($upload) {
                    $old_post_image = Post::find($request->post_id)->featured_image;
                    if ($old_post_image != null && Storage::disk('public')->exists($path . $old_post_image)) {
                        Storage::disk('public')->delete($path . $old_post_image);
                        if (Storage::disk('public')->exists($path . 'thumnails/resized_' . $old_post_image)) {
                            Storage::disk('public')->delete($path . 'thumnails/resized_' . $old_post_image);
                        }
    
                        if (Storage::disk('public')->exists($path . 'thumnails/thumb_' . $old_post_image)) {
                            Storage::disk('public')->delete($path . 'thumnails/thumb_' . $old_post_image);
                        }
                    }
    
                    $post = Post::find($request->post_id);
    
                    $post->category_id = $request->post_category;
                    $post->post_slug = null;
                    $post->post_content = $request->post_content;
                    $post->post_title = $request->post_title;
                    $post->featured_image = $new_filename;
                    $post->post_tags = $request->post_tags;
                    // $post->status = 0;
                    $save = $post->save();
                    if ($save) {
                        return response()->json(['status' => 1, 'msg' => 'Bài viết được cập nhật thành công.']);
                    } else {
                        return response()->json(['status' => 3, 'msg' => 'Bài viết cập nhật thất bại.']);
                    }
                } else {
                    return response()->json(['status' => 3, 'msg' => 'Upload ảnh lỗi']);
                }
            } else {
                $request->validate([
                    'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
                    'post_content' => 'required',
                    'post_category' => 'required|exists:sub_categories,id'
                ],[
                    'post_title.required'=>'Tiêu đề không được để trống.',
                    'post_title.unique'=>'Tiêu đề đã tồn tại.',
                    'post_content.required'=>'Nội dung bài viết không được để trống.',
                    'post_category.required'=>'Phải chọn danh mục bài viết.',
                    'post_category.exists'=>'Tiêu đề không hợp lệ.',
                    'featured_image.required'=>'Hình ảnh không được để trống.',
                    'featured_image.mines'=>'Định dạng hình ảnh pahir là jpeg,jpg,png.',
                    'featured_image.max'=>'Tối đa là 1024.'
                ]);
                $post = Post::find($request->post_id);
                $post->category_id = $request->post_category;
                $post->post_slug = null;
                $post->post_content = $request->post_content;
                $post->post_title = $request->post_title;
                $post->post_tags = $request->post_tags;
                // $post->status = 0;
    
                $save = $post->save();
                if ($save) {
                    return response()->json(['status' => 1, 'msg' => 'Bài viết được cập nhật thành công.']);
                } else { 
                    return response()->json(['status' => 3, 'msg' => 'Bài viết cập nhật thất bại.']);
                }
    
            }
        }
        if ( auth()->user()->type == 4) {
            
                $post = Post::find($request->post_id);

                $post->status = 1;

                $save = $post->save();
                if ($save) {

                    return response()->json(['status' => 1, 'msg' => 'Bài báo đã được duyệt thành công']);
                } else {
                    return response()->json(['status' => 3, 'msg' => 'Bài báo duyệt không thành công.']);
                }

            
        }


        if (auth()->user()->type == 2) {
            if ($request->hasFile('featured_image')) {
                $request->validate([
                    'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
                    'post_content' => 'required',
                    'post_category' => 'required|exists:sub_categories,id',
                    'featured_image' => 'mimes:jpeg,jpg,png|max:1024'
                ],[
                    'post_title.required'=>'Tiêu đề không được để trống.',
                    'post_title.unique'=>'Tiêu đề đã tồn tại.',
                    'post_content.required'=>'Nội dung bài viết không được để trống.',
                    'post_category.required'=>'Phải chọn danh mục bài viết.',
                    'post_category.exists'=>'Tiêu đề không hợp lệ.',
                    'featured_image.required'=>'Hình ảnh không được để trống.',
                    'featured_image.mines'=>'Định dạng hình ảnh pahir là jpeg,jpg,png.',
                    'featured_image.max'=>'Tối đa là 1024.'
                ]);

                $path = "images/post_images/";
                $file = $request->file('featured_image');
                // $filename = $file->getClientOriginalName();
                $filename = $file->getClientOriginalName();
                $new_filename = time() . '_' . $filename;
                $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));
                $post_thumbnails_path = $path . 'thumbnails';
                if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                    Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
                }

                // tao mot square thumbnails
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(200, 200)
                    ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));

                // tao kich thuoc resize image
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(500, 300)
                    ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'resized_' . $new_filename));

                if ($upload) {
                    $old_post_image = Post::find($request->post_id)->featured_image;
                    if ($old_post_image != null && Storage::disk('public')->exists($path . $old_post_image)) {
                        Storage::disk('public')->delete($path . $old_post_image);
                        if (Storage::disk('public')->exists($path . 'thumnails/resized_' . $old_post_image)) {
                            Storage::disk('public')->delete($path . 'thumnails/resized_' . $old_post_image);
                        }

                        if (Storage::disk('public')->exists($path . 'thumnails/thumb_' . $old_post_image)) {
                            Storage::disk('public')->delete($path . 'thumnails/thumb_' . $old_post_image);
                        }
                    }

                    $post = Post::find($request->post_id);
                    $post->status = 0;
                    $post->category_id = $request->post_category;
                    $post->post_slug = null;
                    $post->post_content = $request->post_content;
                    $post->post_title = $request->post_title;
                    $post->featured_image = $new_filename;
                    $post->post_tags = $request->post_tags;

                    $save = $post->save();
                    if ($save) {
                        return response()->json(['status' => 1, 'msg' => 'Bài viết được cập nhật thành công.']);
                    } else {
                        return response()->json(['status' => 3, 'msg' => 'Bài viết cập nhật thất bại.']);
                    }
                } else {
                    return response()->json(['status' => 3, 'msg' => 'Upload ảnh lỗi']);
                }
            } else {
                $request->validate([
                    'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
                    'post_content' => 'required',
                    'post_category' => 'required|exists:sub_categories,id'
                ],[
                    'post_title.required'=>'Tiêu đề không được để trống.',
                    'post_title.unique'=>'Tiêu đề đã tồn tại.',
                    'post_content.required'=>'Nội dung bài viết không được để trống.',
                    'post_category.required'=>'Phải chọn danh mục bài viết.',
                    'post_category.exists'=>'Tiêu đề không hợp lệ.',
                    'featured_image.required'=>'Hình ảnh không được để trống.',
                    'featured_image.mines'=>'Định dạng hình ảnh pahir là jpeg,jpg,png.',
                    'featured_image.max'=>'Tối đa là 1024.'
                ]);
                $post = Post::find($request->post_id);
                $post->category_id = $request->post_category;
                $post->post_slug = null;
                $post->post_content = $request->post_content;
                $post->post_title = $request->post_title;
                $post->post_tags = $request->post_tags;
                $post->status = 0;

                $save = $post->save();
                if ($save) {
                    return response()->json(['status' => 1, 'msg' => 'Bài viết được cập nhật thành công.']);
                } else {
                    return response()->json(['status' => 3, 'msg' => 'Bài viết cập nhật thất bại.']);
                }

            }
        }
    }
    // phản hồi bài viết
    public function feedbackPost(Request $request){
        $post = Post::find($request->post_id);
        $user = User::where('id',$post->author_id)->first();
                $post->status = 2;

                $save = $post->save();
                if ($save) {
                    $data = [
                        'post_title'=> $request->name_post,
                        'content_feedback'=>$request->content_feedback,
                        'name_author'=>$user->name,
                    ];
                    Mail::send('template-feedback', $data, function($message) use($user){
                        $message->from('huynhhuy12149@gmail.com','larablog');
                        $message->to($user->email, $user->name)
                                ->subject('Phản hồi bài viết');
                    });
                    return response()->json(['status' => 1, 'msg' =>'Phản hồi của bạn đã gửi thành công tới tác giả']);
                } else {
                    return response()->json(['status' => 3, 'msg' => 'Phản hồi của bạn không thành công.']);
                }
    }

    public function refusePost(Request $request)
    {
        if (!request()->post_id) {
            return abort(404);

        } else {
            $post = Post::find(request()->post_id);
            $data = [
                'post' => $post,
                'pageTitle' => 'Cập nhật bài viết'
            ];
            return view('back.pages.edit_refuse_post', $data);
        }
    }

    public function updatePostRefuse(Request $request)
    {

        $request->validate([
            'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
            'post_content' => 'required',
            'post_category' => 'required|exists:sub_categories,id'
        ],[
            'post_title.required'=>'Tiêu đề không được để trống.',
            'post_title.unique'=>'Tiêu đề đã tồn tại.',
            'post_content.required'=>'Nội dung bài viết không được để trống.',
            'post_category.required'=>'Phải chọn danh mục bài viết.',
            'post_category.exists'=>'Tiêu đề không hợp lệ.',
            'featured_image.required'=>'Hình ảnh không được để trống.',
            'featured_image.mines'=>'Định dạng hình ảnh pahir là jpeg,jpg,png.',
            'featured_image.max'=>'Tối đa là 1024.'
        ]);
                $post = Post::find($request->post_id);

                $post->status = 0;

                $save = $post->save();
                if ($save) {

                    return response()->json(['status' => 1, 'msg' => 'Bài viết đã gửi vui lòng chờ xét duyệt']);
                } else {
                    return response()->json(['status' => 3, 'msg' => 'Bài viết chưa được gửi, thử lại.']);
                }

            
        
            }



}