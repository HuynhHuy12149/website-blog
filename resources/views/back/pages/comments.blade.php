@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Danh mục')
@section('content')
  


@livewire('comments')

@endsection

@push('scripts')
    <script>
      window.addEventListener('deleteComment',function(e){
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
                Livewire.emit('deleteCommentAction', e.detail.id);

              }
            });
        });
      
    </script>

<script>
  window.addEventListener('editComment',function(e){
      swal.fire({
          title:e.detail.title,
          imageWidth:48,
          imageHeight:48,
          html:e.detail.html,
          showCloseButton:true,
          showCancelButton:true,
          cancelButtonText:'Không',
          confirmButtonText:'Cập nhật',
          cancelButtonColor:'#d33',
          confirmButonColor:'#3085d6',
          width:300,
          allowOutsideClick:false
        }).then(function(result){
          if(result.value){
            Livewire.emit('editCommentAction', e.detail.id);

          }
        });
    });
  
</script>
@endpush
