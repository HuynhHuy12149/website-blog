@extends('front.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Welcome to larablog')
@section('content')

    <div class="row">

        <div class="col-lg-8 mb-5 mb-lg-0">
            <h2 class="section-title">{{ $category->subcategory_name }}</h2>
            <div class="row">
                @forelse ($posts as $post)
                    <div class="col-md-6 mb-4">
                        <article class="card article-card article-card-sm h-100">
                            <a href="{{ route('read_post', $post->post_slug) }}">
                                <div class="card-image">
                                    <div class="post-info"> <span
                                            class="text-uppercase">{{ $post->created_at->format('d/m/Y') }}</span>
                                        <span
                                            class="text-uppercase">{{ readDuration($post->post_title, $post->post_content) }}
                                            @choice('phút', readDuration($post->post_title, $post->post_content)) Đọc</span>
                                    </div>
                                    <img loading="lazy" decoding="async"
                                        src="/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }}"
                                        alt="Post Thumbnail" class="w-100" width="420" height="280">
                                </div>
                            </a>
                            <div class="card-body px-0 pb-0">
                                {{-- <ul class="post-meta mb-2">
                          <li> <a href="{{ route('category_posts', optional($post->subcategory)->slug) }}">{{ $post->subcategory->subcategory_name }}</a>
                          </li>
                      </ul> --}}
                                <h2><a class="post-title"
                                        href="{{ route('read_post', $post->post_slug) }}">{{ $post->post_title }}</a></h2>
                                <p class="card-text">{{ Str::ucfirst(words($post->post_content, 25)) }}</p>
                                <div class="content"> <a class="read-more-btn"
                                        href="{{ route('read_post', $post->post_slug) }}">Xem thêm</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <span class="text-danger">No Post(s) found for this category</span>
                @endforelse

                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            {{ $posts->appends(request()->input())->links('custom_pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="widget-blocks">
                <div class="row">
                    <div class="col-lg-12 col-md-6">
                        <div class="widget">
                            <h2 class="section-title mb-3">Đề Xuất</h2>
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

@endsection
    