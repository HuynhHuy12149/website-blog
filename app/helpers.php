<?php
use App\Models\Setting;
use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Carbon\Carbon;


//blogInfo() Hàm trả về thông tin cấu hình của trang web (được lưu trong bảng settings của cơ sở dữ liệu).
if(!function_exists('blogInfo')){
    function blogInfo(){
        return Setting::find(1);
    }
}

//chuyển đổi một chuỗi ngày tháng (định dạng Y-m-d H:i:s) thành định dạng chuẩn của ngôn ngữ hiện tại.
if(!function_exists('date_formatter')){
    function date_formatter($date){
        return Carbon::createFromFormat('Y-m-d H:i:s',$date)->isoFormat('LL');

    }
}

// trips word
if(!function_exists('words')){
    function words($value, $words=15,$end="..."){
        $value = html_entity_decode(strip_tags($value), ENT_QUOTES, 'UTF-8');
        return Str::words($value,$words,$end);
        
    }
}


//  kiểm tra coi user có online không
if(!function_exists('isOnline')){
    function isOnline($site="https://youtube.com"){
        if(@fopen($site,"r")){
            return true;
        }else{
            return false;
        }
    }
}

//readDuration Hàm tính toán thời gian đọc bài báo dựa trên số từ trong đoạn văn bản đầu vào ($text). 
if(!function_exists('readDuration')){
    function readDuration(...$text){
        Str::macro('timeCounter',function($text){
            $totalWords = str_word_count(implode("",$text));
            $minuteToRead = round($totalWords/200);
            return (int)max(1,$minuteToRead);
        });
        return Str::timeCounter($text);    
    }

}

// Hàm trả về bài viết mới nhất (được đăng trong thời gian gần đây nhất) của trang web.
if(!function_exists('single_latest_post')){
    function single_latest_post(){
        
        return Post::with('author')    
                    ->with('subcategory')
                    ->where('status','!=',0)
                    ->limit(1)
                    ->orderBy('created_at','desc')
                    ->first();
    
    }               
    

}


// Hàm trả về 6 bài viết mới nhất (sau bài viết mới nhất đã trả về bởi hàm single_latest_post()) để hiển thị trên trang chủ của trang web
if(!function_exists('latest_home_6posts')){
    function latest_home_6posts(){

        $firstPost = Post::where('status','=',1)->orderBy('created_at', 'desc')->first();
        $except = $firstPost->id;
        $status = 0;

        return Post::with('author')
                    ->with('subcategory')
                    ->where('id', '!=', $except)
                    ->where('status','!=',$status)
                    // ->skip(1) //bỏ qua $value bản ghi đầu tiên trong kết quả truy vấn.
                    ->limit(6)
                    ->orderBy('created_at','desc')
                    ->paginate(6)
                    // ->get();
                    ->appends(request()->input());
    }

}

// Hàm trả về một số bài viết được chọn ngẫu nhiên 
if(!function_exists('recommended_posts')){
    function recommended_posts(){
        
        return Post::with('author')
                    ->with('subcategory')
                    ->where('status','!=',0)
                    ->limit(4)
                    ->inRandomOrder()
                    ->get();  
    }
}


if(!function_exists('recommended_one_posts')){
    function recommended_one_posts(){
        
        return Post::with('author')    
                    ->with('subcategory')
                    ->where('status','!=',0)
                    ->limit(1)
                    ->inRandomOrder()
                    ->first();
    
    }               
    

}

// so bai báo trong các danh mục

if(!function_exists('categories')){
    function categories(){
        
        return SubCategory::whereHas('posts')
                    ->with('posts')
                    ->orderBy('subcategory_name','asc')
                    ->get();  
    }




}

//bai iet mới nhất

if(!function_exists('topview_sidebar_posts')){
    function topview_sidebar_posts($except = null,$limit = 4){
        
        return  Post::where('id','!=',$except)
                    ->where('status','!=',0)
                    ->limit($limit)
                    ->orderBy('views','desc') // Sắp xếp theo views giảm dần
                    ->get();
    }




}


//  lấy tất cả thẻ tag
if(!function_exists('all_tags')){
    function all_tags(){
        
        return  Post::where('post_tags','!=',null)->distinct()->pluck('post_tags')->join(','); 
    }




}
?>