<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="page-header d-print-none mb-2">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">
              Quản lý bình luận
            </h2>
          </div>
          <!-- Page title actions -->
          <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
              <input type="search" class="form-control d-inline-block w-9 me-3" wire:model="search" placeholder="Tìm kiếm ">
              <!-- data-bs-target: thuộc tính này định Modal, data-bs-toggle : thuộc tính này được sử dụng để kích hoạt hiển thị Modal khi sự kiện được xảy ra-->
             
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-2">
          <div class="card">
            <div class="card-header">
              <ul class="nav nav-pills card-header-pills">
                <h4>bình luận</h4>
                <li class="nav-item ms-auto">
                  {{-- <a href="#" class="btn btn-sm btn-primary" data-bs-target='#categories_modal' data-bs-toggle='modal'>
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M12 5l0 14"></path>
                      <path d="M5 12l14 0"></path>
                   </svg> --}}
                    
                  {{-- </a> --}} 
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                  <thead>
                    <tr>
                      <th>Tên người bình luận</th>
                      <th>Bài Post</th>
                      <th>Nội dung</th>
                      <th>Trạng thái</th>
                      <th class="w-1"></th>
                    </tr>
                  </thead>
                  <tbody id="sortable_category">
                    
                    @forelse ($comments as $comment)
                        
                    <tr data-index="{{ $comment->id }}" >
                      <td>{{ $comment->user->name }}</td>
                      <td>{!! Str::ucfirst(words($comment->post->post_title,2 )) !!}</td> 
                      <td>{!! $this->highlight($comment->content ) !!}</td>
                      @if ($comment->status != 0)
                       <td class="text-danger">Bình luận vi phạm cộng đồng</td>
                      @else
                        <td > <a href="" class="btn btn-sm btn-warning" wire:click.prevent="editComment({{ $comment->id }})">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                            <path d="M16 5l3 3"></path>
                         </svg>
                          Đã Đăng
                        </a> </td>
                      @endif
                      
                      <td>
                        <div class="btn-group">
                          
                          <a href="" wire:click.prevent="deleteComment({{ $comment->id }}, {{ $comment->post_id }}, {{ $comment->user_id }},{{$comment->reply_id}})" class="btn btn-sm btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M4 7l16 0"></path>
                              <path d="M10 11l0 6"></path>
                              <path d="M14 11l0 6"></path>
                              <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                              <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                           </svg>
                            Xóa
                          </a>
                        </div>
                      </td>
                    </tr>
                    @empty
                    
                      <td colspan="4" style="text-align: center"><span class="text-danger">Không có bình luận nào!</span></td>
                    @endforelse
                  </tbody>
                </table>
                <div class="d-block mt-4">
                  {{ $comments->links('livewire::bootstrap') }}
                </div>
              </div>
            </div>
          </div>    
        </div>
        
</div>

