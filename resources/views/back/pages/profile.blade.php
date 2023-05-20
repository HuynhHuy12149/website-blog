@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Thông tin cá nhân')
@section('content')

  @livewire('author-profile-header')  
  <hr>
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
        <li class="nav-item">
          <a href="#tabs-details" class="nav-link active" data-bs-toggle="tab">Thông tin cá nhân</a>
        </li>
        <li class="nav-item">
          <a href="#tabs-password" class="nav-link" data-bs-toggle="tab">Thay đổi mật khẩu</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane active show" id="tabs-details">
          <div>
            @livewire('author-personal-details')
          </div>
        </div>
        <div class="tab-pane" id="tabs-password">
          <div>
            @livewire('author-change-password-form')
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
    <!-- sử dụng thư viện ijaboCropTool để cắt và tải ảnh lên máy chủ. -->
    <script>
      $('#changeAuthorPictureFile').ijaboCropTool({
        preview : '', //xác định vị trí hiển thị ảnh trước khi cắt
        setRatio:1, //xác định tỷ lệ khung hình cho công cụ cắt ảnh (1:1)
        allowedExtensions: ['jpg', 'jpeg','png'],
        buttonsText:['CROP','QUIT'],
        buttonsColor:['#30bf7d','#ee5155', -15],
        processUrl:'{{ route("author.change-profile-picture") }}', //xác định đường dẫn đến phương thức xử lý yêu cầu tải ảnh lên máy chủ.
        withCSRF:['_token','{{ csrf_token() }}'], //thêm mã CSRF token vào yêu cầu gửi đến máy chủ để đảm bảo an toàn tránh bị tấn công bởi mã độc Cross-Site Request Forgery (CSRF)
          onSuccess:function(message, element, status){
          livewire.emit('updateAuthorProfileHeader');
          livewire.emit('updateTopHeader');
          toastr.success(message);
        },
        onError:function(message, element, status){
          toastr.error(message);
        }
      });
    </script>
@endpush