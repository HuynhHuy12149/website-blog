
@extends('back.layouts.pages-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle:'Tất cả bài viết')
    
@section('content')
<div class="page-header d-print-none mb-2">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Tất cả bài viết của tôi
          </h2>
        </div>
      </div>
    </div>
  </div>

  @livewire('my-posts')

@endsection
@push('scripts')
    <script>
      window.addEventListener('deletePost',function(e){
            swal.fire({
                title:e.detail.title,
                imageWidth:48,
                imageHeight:48,
                html:e.detail.html,
                showCloseButton:true,
                showCancelButton:true,
                cancelButtonText:'Không',
                confirmButtonText:'Xóa',
                cancelButtonColor:'#d33',
                confirmButonColor:'#3085d6',
                width:300,
                allowOutsideClick:false
            }).then(function(result){
                if(result.value){
                    Livewire.emit('deletePostAction',e.detail.id);
                }
            });
        });
      
    </script>
    <script>
      $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip(); 
      });
      </script>
@endpush