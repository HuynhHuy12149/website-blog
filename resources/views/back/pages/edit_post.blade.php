@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Add-post')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Sửa bài viết
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('author.posts.update-post', ['post_id' => Request('post_id')]) }}" method="Post" id="editPostForm"
        enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" name="post_title" placeholder="Tiêu đè bài viết"
                                value="{{ $post->post_title }}">
                            <span class="text-danger error-text post_title_error"></span>
                        </div>
                        @if (auth()->user()->type == 4)
                            <div class="mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea disabled class="ckeditor form-control" id="post_content" name="post_content" rows="6"
                                    placeholder="Nội dung bài viết..">{{ $post->post_content }}</textarea>
                                <span class="text-danger error-text post_content_error"></span>
                            </div>
                        @endif
                        @if ( auth()->user()->type == 2||auth()->user()->type == 1)
                            <div class="mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea class="ckeditor form-control" id="post_content" name="post_content" rows="6" placeholder="Nội dung bài viết..">{{ $post->post_content }}</textarea>
                                <span class="text-danger error-text post_content_error"></span>
                            </div>
                        @endif

                    </div>


                    <div class="col-md-3">

                        <div class="mb-3">
                            <div class="form-label">Danh mục</div>
                            <select class="form-select" value name="post_category">
                                <option value="1">None</option>
                                @foreach (\App\Models\SubCategory::all() as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->subcategory_name }}</option>
                                @endforeach

                            </select>
                            <span class="text-danger error-text post_category_error"></span>
                        </div>


                        
                        @if (auth()->user()->type == 2 || auth()->user()->type == 1)
                            <div class="mb-3">
                                <div class="form-label">Hình ảnh</div>
                                <input type="file" class="form-control" name="featured_image">
                                <span class="text-danger error-text featured_image_error"></span>
                            </div>
                        @endif
                        @if (auth()->user()->type == 4 )
                            <div class="image_holder mb-2" style="max-width:100%;">
                                <div class="form-label">Hình ảnh</div>
                                
                            </div>
                        @endif

                        <div class="image_holder mb-2" style="max-width:100%;">
                            <img src="" alt="" class="img-thumbnail" id="image-previewer"
                                data-ijabo-default-img='/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }}'>
                        </div>
                        <div class="mb-3">
                            <div class="form-label">Từ khóa bài viết</div>
                            <input type="text" value="{{ $post->post_tags }}" name="post_tags"
                                placeholder="Nhập từ khóa bài viết" class="form-control">
                        </div>



                        <div style="mb-3">
                            <a class="text-decoration-none" href="{{ route('author.posts.all_posts') }}"><button
                                    class="btn btn-danger" type="button">Trở về</button>&nbsp; </a>
                            @if ( auth()->user()->type == 2 || auth()->user()->type == 1)
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                            @endif

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="/ckeditor/ckeditor.js"></script>
    <Script>
        $(function() {
            $('input[type="file"][name="featured_image"]').ijaboViewer({
                preview: '#image-previewer',
                imageShape: 'rectangular',
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                onErrorShape: function(message, element) {
                    // toastr.error(message);
                    alert('Hình ảnh phải có hình dạng hình chữ nhật');
                },
                onInvalidType: function(message, element) {
                    // toastr.error(message);
                    alert('Loại tệp không hợp lệ');
                }

            });


            $('#editPostForm').on('submit', function(e) {
                e.preventDefault();
                toastr.remove();
                var post_content = CKEDITOR.instances.post_content.getData();
                var form = this;
                var fromdata = new FormData(form);
                fromdata.append('post_content', post_content);
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: fromdata,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(response) {
                        toastr.remove();
                        if (response.status == 1) {

                            toastr.success(response.msg);
                        } else {
                            toastr.error(response.msg);
                        }
                    },
                    error: function(response) {
                        toastr.remove();

                        $.each(response.responseJSON.errors, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                });
            });
        });
    </Script>
@endpush
