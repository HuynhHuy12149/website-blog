@extends('front.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Welcome to larablog')
@section('meta_tags')

  <meta name="robots" content="index,follow" />
  <meta name="title" content="{{ blogInfo()->blog_name }}" />
  <meta name="description" content="{{ blogInfo()->blog_description }}"/>
  <meta name="author" content="{{ blogInfo()->blog_name }}">
  <link rel="canonical" href="{{ Request::root() }}">
  <meta property="og:title" content="{{ blogInfo()->blog_name }}" />
  <meta property="og:type" content="website" />
  <meta property="og:description" content="{{ blogInfo()->blog_description }}" />
  <meta property="og:url" content="{{ Request::root() }}" />
  <meta property="og:image" content="{{ blogInfo()->blog_logo }}" />
  <meta property="twitter:domain" content="{{ Request::root() }}" />
  <meta property="twitter:card" content="summary" />
  <meta property="twitter:title" property="og:title" itemprop="name" content="{{ blogInfo()->blog_name }}" />
  <meta property="twitter:description" property="og:description" itemprop="description" content="{{ blogInfo()->blog_description }}" />
  <meta  property="twitter:image"  content="{{ blogInfo()->blog_logo }}" />
@endsection
@section('content')

<div class="row no-gutters-lg">
  <div class="col-12">
  </div>
  <div class="col-lg-8 mb-5 mb-lg-0">
    <div class="row">
      <div class="col-12 mb-4">
        <h2 class="section-title">Bài Viết Mới Nhất</h2>

        {{-- hiển thị bài viết mới nhất --}}
        @if (single_latest_post())
          <article class="card article-card">
            <a href="{{ route('read_post', single_latest_post()->post_slug) }}">
              <div class="card-image">
                {{-- date_formatter(single_latest_post()->created_at) --}}
                <div class="post-info"> <span class="text-uppercase">{{ single_latest_post()->created_at->format('d/m/Y') }}</span>
                  {{-- Gọi hàm ở helper để tính thời gian đọc bài viết --}}
                  <span class="text-uppercase"> 
                    {{ readDuration(single_latest_post()->post_title, single_latest_post()->post_content) }}
                    @choice('phút', readDuration(single_latest_post()->post_title, single_latest_post()->post_content)) đọc
                  </span>
                </div>
                <img loading="lazy" decoding="async" src="/storage/images/post_images/{{ single_latest_post()->featured_image }}" alt="Post Thumbnail" class="w-100">
              </div>
            </a>
            <div class="card-body px-0 pb-1">
              <ul class="post-meta mb-2">
                <li> <a href="{{ route('category_posts', optional(single_latest_post()->subcategory)->slug) }}">{{ single_latest_post()->subcategory->subcategory_name }}</a>
                </li>
                {{-- subcategory->subcategory_name --}}
              </ul>
              
              <h2 class="h1"><a class="post-title" href="{{ route('read_post', single_latest_post()->post_slug) }}">{{ single_latest_post()->post_title }}</a></h2>
              {{--Str::ucfirst được sử dụng để chuyển đổi ký tự đầu tiên của một chuỗi thành chữ in hoa. --}}
              <p class="card-text"> {!! Str::ucfirst(words(single_latest_post()->post_content, 45)) !!} </p>
              <div class="content">
                <a class="read-more-btn" href="{{ route('read_post', single_latest_post()->post_slug) }}">
                  Xem thêm
                </a>
              </div>
            </div>
          </article>  
        @endif 

      </div>

      {{-- hiển thị 6 blog mới nhất --}}
      @foreach (latest_home_6posts() as $post)
      <div class="col-md-6 mb-4">
        <article class="card article-card article-card-sm h-100">
          <a href="{{ route('read_post', $post->post_slug) }}">
            <div class="card-image">
              <div class="post-info"> <span class="text-uppercase">{{ $post->created_at->format('d/m/Y') }}</span>
                <span class="text-uppercase">{{ readDuration($post->post_title, $post->post_content) }}
                  @choice('phút', readDuration($post->post_title, $post->post_content)) đọc</span>
              </div>
              <img loading="lazy" decoding="async" src="/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }}" alt="Post Thumbnail" class="w-100">
            </div>
          </a>
          <div class="card-body px-0 pb-0">
            <ul class="post-meta mb-2">
              <li> <a href="{{ route('category_posts', optional($post->subcategory)->slug) }}">{{ $post->subcategory->subcategory_name }}</a>
              </li>
            </ul>
            <h2><a class="post-title" href="{{ route('read_post', $post->post_slug) }}">{{ $post->post_title }}</a></h2>
            <p class="card-text">{!! Str::ucfirst(words($post->post_content, 25)) !!}</p>
            <div class="content"> <a class="read-more-btn" href="{{ route('read_post', $post->post_slug) }}">Xem thêm</a>
            </div>
          </div>
        </article>
      </div>
      @endforeach

      <div class="col-12">
        <div class="row">
          <div class="col-12">
            {{ latest_home_6posts()->links('custom_pagination') }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="widget-blocks">
      <div class="row">

      {{-- hiển thị các posts ngẫu nhiên --}}
      @if (recommended_posts())
        <div class="col-lg-12 col-md-6">
          <div class="widget">
            <h2 class="section-title mb-3">Đề Xuất</h2>
            @include('front.layouts.inc.recommended_list') 
          </div>
        </div>
      @endif

      {{-- hiển thị các post xem nhiều --}}
      @if (topview_sidebar_posts())
      <div class="col-lg-12 col-md-6">
        <div class="widget">
          <h2 class="section-title mb-3">Xem Nhiều</h2>
          @include('front.layouts.inc.topview_list')
        </div>
      </div>
      @endif

      {{-- danh mục --}}
      @if (categories())
        <div class="col-lg-12 col-md-6">
          <div class="widget">
            <h2 class="section-title mb-3">Danh Mục</h2>
            <div class="widget-body">
            @include('front.layouts.inc.categories_list') 
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Messenger Plugin chat Code -->
 <div id="fb-root"></div>

 <!-- Your Plugin chat code -->
 <div id="fb-customer-chat" class="fb-customerchat">
 </div>

 

@endsection

@push('scripts')
<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "106046435805869");
  chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v16.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
@endpush