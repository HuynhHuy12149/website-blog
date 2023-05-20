@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Danh mục')
@section('content')
  
<div class="page-header d-print-none mb-2">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          Danh mục & Danh mục con
        </h2>
      </div>
    </div>
  </div>
</div>

@livewire('categories')

@endsection

@push('scripts')
  <script>
    window.addEventListener('hideCategoriesModel', function(event){
        $('#categories_modal').modal('hide');
      });
      
      window.addEventListener('showCategoriesModal', function(event){
        $('#categories_modal').modal('show');
      });

      // danh mục con
      window.addEventListener('hideSubCategoriesModel', function(event){
        $('#subcategories_modal').modal('hide');
      });

      window.addEventListener('showSubCategoriesModal', function(event){
        $('#subcategories_modal').modal('show');
      });

      $('#categories_modal,#subcategories_modal').on('hidden.bs.modal',function(e){
        livewire.emit('resetModalForm');
      });

      // gọi bên xóa category
      window.addEventListener('deleteCategory',function(e){
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
                Livewire.emit('deleteCategoryAction',e.detail.id);
              }
            });
        });

       // gọi form thông báo xóa subcategory
       window.addEventListener('deleteSubCategory',function(e){
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
                    Livewire.emit('deleteSubCategoryAction',e.detail.id);
                }
            });
        });

        //sử dụng plugin "sortable" của jQuery UI để kích hoạt tính năng sắp xếp cho bảng
        // Plugin "sortable" này cho phép người dùng kéo và thả các hàng (rows) của bảng để thay đổi thứ tự hiển thị của chúng
        $('table tbody#sortable_category').sortable({
          // sự kiện "update" để lắng nghe và xử lý sự kiện khi danh sách đã được sắp xếp lại
            update:function(event, ui){
              // mỗi hàng trong bảng được kiểm tra để xác định nó đã được di chuyển hay chưa
                $(this).children().each(function(index){
                    if($(this).attr("data-ordering")!=(index+1)){
                        $(this).attr("data-ordering",(index+1)).addClass("updated");
                    }
                });
                var positions = [];
                $(".updated").each(function(){
                    positions.push([$(this).attr("data-index"),$(this).attr("data-ordering")]);
                    $(this).removeClass("updated");
                });
                // alert(positions)

                window.livewire.emit("updateCategoryOrdering",positions);
            }
        });

        $('table tbody#sortable_subcategory').sortable({
            update:function(event, ui){
                $(this).children().each(function(index){
                    if($(this).attr("data-ordering")!=(index+1)){
                        $(this).attr("data-ordering",(index+1)).addClass("updated");
                    }
                });
                var positions = [];
                $(".updated").each(function(){
                    positions.push([$(this).attr("data-index"),$(this).attr("data-ordering")]);
                    $(this).removeClass("updated");
                });

                window.livewire.emit("updateSubCategoryOrdering",positions);
            }
        });
  </script>
@endpush