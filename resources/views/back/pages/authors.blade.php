@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Tác giả')
@section('content')

    @livewire('authors')

@endsection

{{-- push:  đưa mã JavaScript vào stack JavaScript của trang web --}}
@push('scripts')
    <script>
        // khi modal window được đóng lại, hàm xử lý này sẽ gọi phương thức "resetForms" thông qua đối tượng "livewire"
        $(window).on('hidden.bs.modal', function() {
            livewire.emit('resetForms');
        });

        window.addEventListener('hide_and_author_modal', function(event) {
            $('#add_author_modal').modal('hide');
        });

        window.addEventListener('showEditAuthorModal', function(event) {
            $('#edit_author_modal').modal('show');
        });

        window.addEventListener('hide_edit_author_modal', function(event) {
            $('#edit_author_modal').modal('hide');
        });

        window.addEventListener('deleteAuthor', function(event) {
            swal.fire({
                title: event.detail.title,
                imageWidth: 48,
                imageHeight: 48,
                html: event.detail.html,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Không',
                confirmButtonText: 'Xóa',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                width: 300,
                allowOutsideClick: false
            }).then(function(result) {
                if (result.value) {
                    livewire.emit('deleteAuthorAction', event.detail.id);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
