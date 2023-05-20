@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Thêm bài viết')
@section('content')

<div class="page-header d-print-none mb-2">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          Thêm mới bài viết
        </h2>
      </div>
    </div>
  </div>
</div>


<form action="{{ route('author.posts.create') }}" method="post" id="addPostForm" enctype="multipart/form-data">
  @csrf
  <div class="card">
    <div class="card-body row">
        <div class="col-md-9">

          <div class="mb-3">
            <label class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" name="post_title" placeholder="Nhập tiêu đề bài viết">
            <span class="text-danger error-text post_title_error"></span>
          </div>

          <div class="mb-3">
            <label class="form-label">Nội dung</label>
            <textarea class="ckeditor form-control" name="post_content" rows="6" placeholder="Content.." id="post_content"></textarea>
            <span class="text-danger error-text post_content_error"></span>
          </div>

        </div>
        <div class="col-md-3">

          <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <div>
              <select class="form-select" name="post_category">
                 <option value="">-- Chọn --</option>
                  @foreach (\App\Models\SubCategory::all() as $category)
                  <option value="{{ $category->id }}">{{ $category->subcategory_name }}</option>
                  @endforeach
              </select>
            </div>
            <span class="text-danger error-text post_category_error"></span>
          </div>
          <div class="mb-3">
            <div class="form-label">Hình ảnh</div>
            <input type="file" name="featured_image" class="form-control">
            <span class="text-danger error-text featured_image_error"></span>
          </div>
          <div class="image_holder mb-2" style="max-width: 100%">
            <img src="" alt="" class="img-thumbnail" id="image-previewer" data-ijabo-default-img="">
          </div>
          <div class="mb-3">
            <div class="form-label">Từ khóa bài viết</div>
            <input type="text" name="post_tags" placeholder="Nhập từ khóa bài viết" class="form-control">
          </div>
        </div>
        <div class="mb-3">
          <button style="float: right" class="btn btn-primary" type="submit">Lưu bài viết</button>
        </div>
    </div>
  </div>
</form>

@endsection
{{-- C:\xampp\htdocs\bloglarvel\public\ckeditor\ckeditor.js --}}
@push('scripts')
  <script src="/ckeditor/ckeditor.js"></script>
  <Script>
    $(function(){
      $('input[type="file"][name="featured_image"]').ijaboViewer({
        preview : '#image-previewer', //xác định vị trí hiển thị ảnh trước khi cắt
        imageShape:'rectangular', //xác định tỷ lệ khung hình cho công cụ cắt ảnh (1:1)
        allowedExtensions: ['jpg', 'jpeg','png'],
        onErrorShape:function(message, element){
          toastr.error('Hình ảnh phải có hình dạng hình chữ nhật');
        },
        onInvalidType:function(message, element){
          toastr.error('Loại tệp không hợp lệ');
        }
      });


      $('#addPostForm').on('submit',function(e){
        e.preventDefault();
        toastr.remove();
        var post_content = CKEDITOR.instances.post_content.getData();
        var form = this;
        var formdata = new FormData(form);
            formdata.append('post_content',post_content);
        $.ajax({  
          url:$(form).attr('action'),
          method:$(form).attr('method'),
          data:formdata,
          processData:false,
          dataType:'json',
          contentType:false,
          beforeSend:function(){
            $(form).find('span.error-text').text('');
          },
          success:function(response){
            toastr.remove();
            if(response.code == 1){
              $(form)[0].reset();
              $('div.image_holder').find('img').attr('src','');
              CKEDITOR.instances.post_content.setData('');
              $('input[name="post_tags"]').amsifySuggestags();//sử dụng plugin amsifySuggestags của jQuery để tạo ra một trình đề xuất từ khóa cho trường post_tags
              toastr.success(response.msg);
            }else{
              toastr.error(response.msg);
            }
            
          },
          error:function(response){
              toastr.remove();
              $.each(response.responseJSON.errors, function(prefix, val){
                $(form).find('span.'+prefix+'_error').text(val[0]);
              });
          }

        });
      });
    });


  </Script>

@endpush