@extends('front.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Welcome to larablog')
@section('content')

    <div class="row">
        
        <div class="col-lg-8 mb-5 mb-lg-0">
            <h2 class="section-title">Bài viết xem sau: {{ session('user')['name'] }}</h2>
            
                    <span class="text-danger">Không có dữ liệu vui lòng xem lại </span>
            
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
