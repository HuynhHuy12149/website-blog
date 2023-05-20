@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'cập nhật bài viết')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Thông tin bài viết
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('author.posts.update-post-active', ['post_id' => Request('post_id')]) }}" method="Post"
        id="editPostForm" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" name="post_title" placeholder="Tiêu đề bài viết"
                                value="{{ $post->post_title }}">
                            <span class="text-danger error-text post_title_error"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea class="ckeditor form-control" id="post_content" name="post_content" rows="6" placeholder="Nội dung bài viết..">{{ $post->post_content }}</textarea>
                            <span class="text-danger error-text post_content_error"></span>
                        </div>
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

                        <div class="mb-3">
                            <div class="form-label">Hình ảnh</div>
                            <input type="file" class="form-control" name="featured_image">
                            <span class="text-danger error-text featured_image_error"></span>
                        </div>

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
                            @if (auth()->user()->type == 1)
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                                <form role="form" action="post">
                                    @csrf
                                    <button class="btn btn-primary" id="activepost" name="activepost">Duyệt Bài</button>
                                    
                                </form>
                                <a href="#" class="btn btn-primary" data-bs-target='#feedback_post' data-bs-toggle='modal'>
            
                                    Phản hồi
                                  </a>
                            @endif
                            @if (auth()->user()->type == 4)
                                <button class="btn btn-primary" type="submit">Duyệt Bài</button>
                                <a href="#" class="btn btn-primary" data-bs-target='#feedback_post' data-bs-toggle='modal'>
                                    Phản hồi
                                  </a>
                            @endif
                            @if (auth()->user()->type == 2)
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                                {{-- <button class="btn btn-primary" type="submit">Phản Hồi</button>  --}}
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </form>
    
    {{-- <div class="col-auto ms-auto d-print-none">
        <div class="d-flex">
         
          <!-- data-bs-target: thuộc tính này định Modal, data-bs-toggle : thuộc tính này được sử dụng để kích hoạt hiển thị Modal khi sự kiện được xảy ra-->
          <a href="#" class="btn btn-primary" data-bs-target='#feedback_post' data-bs-toggle='modal'>
            
            Thêm mới
          </a>
        </div>
      </div> --}}

    <div wire:ignore.self class="modal modal-blur fade" id="feedback_post" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Phản hồi chỉnh sửa bài viết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" role="form" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tên Bài viết</label>
                            <input type="text" class="form-control" disabled value="{{App\Models\Post::find(Request('post_id'))->post_title}}" name="example-text-input"
                                placeholder="Nhập tên bài viết" id="name_post">
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                       

                        <div class="mb-3">
                            <label class="form-label">Nội dung phản hồi </label>
                            <textarea class="form-control"  name="content_feedback" id="content_feedback" cols="30" rows="10"></textarea>
                            <span class="text-danger">
                                @error('content_feedback')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                      

                      

                        <div style="float: right">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>&nbsp;
                            <button type="button" class="btn btn-primary" name="btn-feedback-post" id="btn-feedback-post" data-bs-dismiss="modal">Lưu</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



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
    {{--  duyệt bài cho admin --}}


    <script>
        let _Url = '{{ route('author.posts.update-status-post-actives', ['post_id' => Request('post_id')]) }}';



        var _csrf = '{{ csrf_token() }}';
        $('#activepost').click(function(ev) {
            ev.preventDefault();

            $.ajax({
                url: _Url,
                type: 'POST',
                data: {
                    _token: _csrf,

                },
                success: function(response) {
                    toastr.remove();
                    if (response.status == 1) {

                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }

                },


            });

        });
    </script>
{{--  phản hồi bài viết của tác giả --}}
<script>
    let _UrlFeedback = '{{ route('author.posts.feedback-post',['post_id' => Request('post_id')]) }}';



    var _csrf = '{{ csrf_token() }}';
    $('#btn-feedback-post').click(function(ev) {
        ev.preventDefault();
        var content_feedback = $('#content_feedback').val();
        var name_post = $('#name_post').val();
        console.log(name_post,content_feedback);
        $.ajax({
            url: _UrlFeedback,
            type: 'POST',
            data: {
                _token: _csrf,
                content_feedback,
                name_post,

            },
            success: function(response) {
                toastr.remove();
                if (response.status == 1) {
                    
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);
                }

            },


        });

    });
</script>
@endpush
