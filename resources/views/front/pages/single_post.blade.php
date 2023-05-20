@extends('front.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Welcome to larablog')
@section('meta_tags')
    <meta name="title" content="{{ Str::ucfirst($post->post_title) }}" />
    <meta name="robots" content="index, follow, max-snippet:-1,max-image-preview:large, max-video-preview:-1" />
    <meta name="description" content="{{ Str::ucfirst(words($post->post_content, 120)) }}" />
    <meta name="author" content="{{ $post->author->username }}" />
    <link rel="canonical" href="{{ route('read_post', $post->post_slug) }}">
    <meta property="og:title" content="{{ Str::ucfirst($post->post_title) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:description" content="{{ Str::ucfirst(words($post->post_content, 120)) }}" />
    <meta property="og:url" content="{{ route('read_post', $post->post_slug) }}" />
    <meta property="og:image" content="asset(/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }})" />
    <meta property="twitter:domain" content="{{ Request::getHost() }}" />
    <meta property="twitter:card" content="summary" />
    <meta property="twitter:title" content="{{ Str::ucfirst($post->post_title) }}" />
    <meta property="twitter:description" content="{{ Str::ucfirst(words($post->post_content, 120)) }}" />
    <meta property="twitter:image" content="/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }}" />

@endsection
@section('content')

    <div class="row">
        <div class="col-lg-8 mb-5 mb-lg-0">
            <article>
                <img loading="lazy" decoding="async"
                    src="/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }}" alt="Post Thumbnail"
                    class="w-100">
                <ul class="post-meta mb-2 mt-4">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            style="margin-right:5px;margin-top:-4px" class="text-dark" viewBox="0 0 16 16">
                            <path d="M5.5 10.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"></path>
                            <path
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z">
                            </path>
                            <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z">
                            </path>
                        </svg> <span>{{ $post->created_at->format('d/m/Y') }}</span>
                    </li>
                    &nbsp;
                    <li>
                        <form role="form" action="" method="post">
                            @csrf


                            @if (session()->has('user'))
                                @php
                                    $check = App\Models\FollowPost::where('post_id', $post->id)->exists();
                                @endphp
                                @if (
                                    $check &&
                                        App\Models\FollowPost::where('post_id', $post->id)->where('user_id', session('user')['id'])->exists())
                                    <span style="cursor: pointer" class="btn-deletepost">
                                        <i class="fa-solid fa-bookmark "></i>
                                        <span style="margin-left:5px;" style="cursor: pointer;">Đã Lưu bài viết</span>
                                    </span>
                                @else
                                    <span class="btn-savepost" style="cursor: pointer">
                                        <i class="fa-sharp fa-regular fa-bookmark "></i>
                                        <span class="textsave" style="cursor: pointer;margin-left:5px;">Lưu bài viết</span>
                                    </span>
                                @endif
                            @else
                            <a style="color: #888888; background-color: white" href="{{route('login')}}"> <span>
                                <i class="fa-sharp fa-regular fa-bookmark"></i>
                                <span  style="  cursor: pointer;margin-left:5px;">Lưu bài viết</span>
                            </span>
                            </a>
                            
                               

                            @endif


                        </form>
                        

                    </li>
                    &nbsp;
                    <li>
                        <svg class="icon icon-tabler icon-tabler-trash "
                                        xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6">
                                        </path>
                                    </svg> <span>{{ $post->views }} <span>lượt xem</span></span>
                    </li>
                    
                </ul>
                
                <h1 class="my-3">{{ $post->post_title }}</h1>
                <ul class="post-meta mb-4">
                    <li> <a
                            href="{{ route('category_posts', $post->subcategory->slug) }}">{{ $post->subcategory->subcategory_name }}</a>
                    </li>
                </ul>
                <div class="content text-left">
                    <p>{!! $post->post_content !!}</p>
                </div>
            </article>


            {{-- phần bình luận bài post --}}
            <div class="mt-5">

                <h2>Bình Luận</h3>
                    <div class="widget-body">
                        <form role="form" action="" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="">Nội dung bình luận</label>
                                <input type="hidden" value="{{ $post->id }}" name="post_id">
                                <textarea id="comment-content" name="content" class="form-control" placeholder="Nhập nội dung bình luận...."></textarea>

                                <span id="charCount">0 ký tự</span> / <span id="maxChars">2000 ký tự</span>
                                <span class="text-danger" id="text-danger"></span>
                            </div>
                            @if (session()->has('user'))
                            
                                <button type="submit" id="btn-comment" class="btn btn-primary">Gửi bình luận</button>
                            @else
                               <a class="btn btn-primary" href="{{route('login')}}">Gửi bình
                                luận</a> 
                            @endif

                        </form>
                        <br>
                        <h3>Các bình luận</h3>
                        <div id="comment">



                            @include('front.pages.list_comment', ['comments' => $post->comments])


                        </div>
                    </div>
            </div>


            @if (count($related_posts) > 0)
                <div class="mt-5">
                    <h2 class="section-title mb-3">Bài viết liên quan</h2>
                    <div class="widget-body">
                        <div class="widget-list">
                            {{-- 4 random --}}
                            @foreach ($related_posts as $item)
                                <a class="media align-items-center" href="{{ route('read_post', $item->post_slug) }}">
                                    <img loading="lazy" decoding="async"
                                        src="/storage/images/post_images/{{ $item->featured_image }}"
                                        alt="Post Thumbnail" class="w-100">
                                    <div class="media-body ml-3">
                                        <h3 style="margin-top:-5px">{{ $item->post_title }}</h3>
                                        <p class="mb-0 small">{!! Str::ucfirst(words($item->post_content, 7)) !!}</p>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="widget-blocks">
                <div class="row">

                    {{-- thông tin tác giả của bài post --}}
                    <div class="col-lg-12">
                        <div class="widget">

                            <div class="widget-body">

                                <img loading="lazy" decoding="async" src="{{ $post->author->picture }}" alt="About Me"
                                    class="w-100 author-thumb-sm d-block">
                                <a href="{{ route('author_posts', $post->author->id) }}">
                                    <h2 class="widget-title my-3">{{ $post->author->name }}</h2>
                                </a>

                                @if ($post->author->biography == null)
                                    <p class="mb-3 pb-2">Xin chào, Tôi là {{ $post->author->name }}. Tôi là một người viết
                                        về những bài Blog....</p>
                                @else
                                    <p class="mb-3 pb-2">Xin chào, Tôi là {{ $post->author->name }}.
                                        {!! Str::ucfirst(words($post->author->biography, 25)) !!}</p>
                                @endif

                                {{-- < a href="about.html" class="btn btn-sm btn-outline-primary">Know --}}
                                <a href="{{ route('author_posts', $post->author->id) }}"
                                    class="btn btn-sm btn-outline-primary">Xem thêm các bài viết</a>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="widget">
                            <h2 class="section-title mb-3">Đề xuất</h2>
                            @include('front.layouts.inc.recommended_list')
                        </div>
                    </div>

                    {{-- hiển thị các post xem nhiều --}}
                    @if (topview_sidebar_posts())
                        <div class="col-lg-12 col-md-6">
                            <div class="widget">
                                <h2 class="section-title mb-3">Xem Nhiều</h2>
                                @include('front.layouts.inc.topview_list')
                            </div>
                        </div>
                    @endif

                    <div class="col-lg-12 col-md-6">
                        <div class="widget">
                            <h2 class="section-title mb-3">Danh mục</h2>
                            <div class="widget-body">
                                @include('front.layouts.inc.categories_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('stylesheets')
    <link rel="stylesheet" href="/share_post/jquery.floating-social-share.min.css">
@endpush
@php
    $user_id = optional(session('user'))['id'] ?? 0;
@endphp
@push('scripts')
    <script>
        console.log('{{ $post->id }}');
    </script>
    <script src="/share_post/jquery.floating-social-share.min.js"></script>
    <script>
        $("body").floatingSocialShare({
            buttons: [
                "facebook", "linkedin", "telegram", "twitter"
            ],
            text: "Share with: ",
            url: "{{ route('read_post', $post->post_slug) }}"
        });
    </script>



    <script>
        let _commentUrl = '{{ route('comment', [$user_id, $post->id]) }}';



        var _csrf = '{{ csrf_token() }}';
        $('#btn-comment').click(function(ev) {
            ev.preventDefault();
            let content = $('#comment-content').val();



            $.ajax({
                url: _commentUrl,
                type: 'POST',
                data: {
                    content: content,

                    _token: _csrf,

                },
                success: function(response) {

                    $('#comment-content').val('');
                    $('#comment').html(response);
                },
                error: function(response) {
                    $('#text-danger').html(response.responseJSON.errors.content[0]);

                }

            });
        });

        // bắt sự kiện hiện form trả lời bình luận
        $(document).on('click', '.btn-show-reply-form', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var content_reply_id = '#content-reply-' + id;
            var contentReply = $(content_reply_id).val();
            var form_reply = '.form-reply-' + id;
            $('.formReply').slideUp();
            $(form_reply).slideDown();
            // alert(form_reply);
        });

        $(document).on('click', '.btn-send-comment-reply', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var content_reply_id = '#content-reply-' + id;
            var contentReply = $(content_reply_id).val();
            var form_reply = '.form-reply-' + id;


            // alert(contentReply);
            $.ajax({
                url: _commentUrl,
                type: 'POST',
                data: {
                    content: contentReply,
                    reply_id: id,

                    _token: _csrf,

                },
                success: function(response) {

                    $('#comment-content').val('');
                    $('#comment').html(response);
                },
                error: function(response) {
                    $('#text-danger').html(response.responseJSON.errors.content[0]);

                }

            });
        });
    </script>
    {{-- lưu bài viết --}}
    <script>
        let _FollowUrl = '{{ route('save-Post-Guest', [$user_id, $post->id]) }}';



        var _csrf = '{{ csrf_token() }}';
        $(document).on('click', '.btn-savepost', function(ev) {
            ev.preventDefault();
            // let content = $('#comment-content').val();



            $.ajax({
                url: _FollowUrl,
                type: 'POST',
                data: {


                    _token: _csrf,

                },
                success: function(response) {


                    $('.btn-savepost').removeClass('btn-savepost').addClass('btn-deletepost').html(
                        '<i class="fa-solid fa-bookmark "></i><span style="margin-left: 10px;" class="textsave">Đã lưu bài viết</span>'
                    );
                    $('.btn-deletepost i').removeClass(' fa-sharp fa-regular fa-bookmark').addClass(
                        'fa-solid fa-bookmark');
                    $('.textsave').html('Đã Lưu bài viết');
                },



            });
        });
    </script>
    {{-- xóa xem sau bài viết --}}
    <script>
        let _UnFollowUrl = '{{ route('delete-follow-Post-Guest', [$user_id, $post->id]) }}';



        var _csrf = '{{ csrf_token() }}';
        $(document).on('click', '.btn-deletepost', function(ev) {
            ev.preventDefault();
            // let content = $('#comment-content').val();

            // console.log('tét');

            $.ajax({
                url: _UnFollowUrl,
                type: 'POST',
                data: {


                    _token: _csrf,

                },
                success: function(response) {


                    $('.btn-deletepost').removeClass('btn-deletepost').addClass('btn-savepost').html(
                        '<i class="fa-sharp fa-regular fa-bookmark "></i><span style="margin-left: 10px;" class="textsave">lưu bài viết</span>'
                    );
                    $('.btn-savepost i').removeClass('fa-solid fa-bookmark').addClass(
                        'fa-sharp fa-regular fa-bookmark');
                    $('.textsave').html('Lưu bài viết');
                },



            });
        });
    </script>

    <!-- Đoạn mã JavaScript -->
    <script>
        var myTextarea = document.getElementById("comment-content");
        var charCount = document.getElementById("charCount");
        var maxChars = document.getElementById("maxChars");
        var maxCount = 2000; // Số ký tự tối đa

        myTextarea.addEventListener("input", function() {
            // Đếm số ký tự từ nội dung của trường textarea
            var count = myTextarea.value.length;

            // Hiển thị số ký tự và số ký tự còn lại
            charCount.innerHTML = count + " ký tự";
            maxChars.innerHTML = (maxCount - count) + " ký tự còn lại";

            // Nếu số ký tự vượt quá giới hạn, loại bỏ các ký tự vượt quá giới hạn
            if (count > maxCount) {
                myTextarea.value = myTextarea.value.substring(0, maxCount);
                count = maxCount;
                charCount.innerHTML = count + " ký tự";
                maxChars.innerHTML = "0 ký tự còn lại";
            }
        });
    </script>
@endpush
