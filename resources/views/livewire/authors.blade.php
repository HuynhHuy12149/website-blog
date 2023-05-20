<div>
    <div class="page-header d-print-none mb-2">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Tác giả
                    </h2>
                </div>


                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <select name="" class="form-select" id="" wire:model='type'>
                            <option value="">None</option>
                            @foreach (App\Models\Type::all() as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        &nbsp;&nbsp;
                        <input type="search" class="form-control d-inline-block w-9 me-3" wire:model="search"
                            placeholder="Tìm kiếm tác giả">
                        <!-- data-bs-target: thuộc tính này định Modal, data-bs-toggle : thuộc tính này được sử dụng để kích hoạt hiển thị Modal khi sự kiện được xảy ra-->
                        <a href="#" class="btn btn-primary" data-bs-target='#add_author_modal'
                            data-bs-toggle='modal'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                <path d="M16 19h6"></path>
                                <path d="M19 16v6"></path>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                            </svg>
                            Thêm mới
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cards">

        @forelse ($authors as $author)
            <div data-toggle="tooltip"
                title="Tạo: {{ $author->created_at->format('d/m/Y') }} - Cập nhật:  {{ $author->updated_at->format('d/m/Y') }} "
                class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            style="background-image: url({{ $author->picture }})"></span>
                        {{-- <h3 class="m-0 mb-1"><a href="#">{{ $author->name }}</a></h3> --}}
                        <h3 class="m-0 mb-1"><a href="#"> {!! $this->highlight($author->name) !!}</a></h3>
                        <div class="text-muted">{{ $author->email }}</div>
                        <div class="mt-3">
                            <span class="badge bg-purple-lt">{{ $author->authorType->name }}</span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="#" class="card-btn" wire:click.prevent="editAuthor({{ $author }})">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-edit text-warning" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                <path d="M16 5l3 3"></path>
                            </svg>
                            Sửa</a>
                        <a href="#" class="card-btn" wire:click.prevent='deleteAuthor({{ $author }})'>
                            <!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-trash text-danger" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
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
                </div>
            </div>

        @empty
            <span class="text-danger">Không có tác giả nào trong danh sách!</span>
        @endforelse

    </div>

    <div class="row mt-4">
        {{ $authors->links('livewire::simple-bootstrap') }}
    </div>
    {{-- <div class="d-block mt-2">
        {{ $authors->links('livewire::bootstrap') }}
    </div> --}}


    <!--Modal -->
    <!--wire:ignore.self được sử dụng để bỏ qua component hiện tại khi tạo ra các sự kiện-->
    <div wire:ignore.self class="modal modal-blur fade" id="add_author_modal" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm tác giả</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="addAuthor()" method="post">
                        <div class="mb-3">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Nhập tên tác giả" wire:model="name">
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Nhập email" wire:model="email">
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Nhập username" wire:model="username">
                            <span class="text-danger">
                                @error('username')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Loại tài khoản</label>
                            <div>
                                <select class="form-select" wire:model="author_type">
                                    <option>-- Chọn --</option>
                                    @foreach (\App\Models\Type::all() as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger">
                                @error('author_type')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        {{-- <div class="mb-3">
                    <div class="form-label">Kích hoạt ?</div>
                    <div>
                      <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="direct_publisher" value="0" wire:model="direct_publisher" checked>
                        <span class="form-check-label">Không</span>
                      </label>
                      <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="direct_publisher" value="1" wire:model="direct_publisher">
                        <span class="form-check-label">Có</span>
                      </label>
                    </div>
                    <span class="text-danger">
                        @error('direct_publisher')
                            {{ $message }}
                        @enderror
                    </span>
                </div> --}}

                        <div style="float: right">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>&nbsp;
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- modal edit --}}
    <div wire:ignore.self class="modal modal-blur fade" id="edit_author_modal" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa tác giả</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateAuthor()" method="post">
                        <input type="hidden" wire:model="selected_author_id">
                        <div class="mb-3">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Nhập tên tác giả" wire:model="name">
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Nhập email" wire:model="email">
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="example-text-input"
                                placeholder="Nhập username" wire:model="username">
                            <span class="text-danger">
                                @error('username')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Loại tài khoản</label>
                            <div>
                                <select class="form-select" wire:model="author_type">
                                    @foreach (\App\Models\Type::all() as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger">
                                @error('author_type')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        {{-- <div class="mb-3">
                    <div class="form-label">Kích hoạt ?</div>
                    <div>
                      <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="direct_publisher" value="0" wire:model="direct_publisher" checked>
                        <span class="form-check-label">Không</span>
                      </label>
                      <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="direct_publisher" value="1" wire:model="direct_publisher">
                        <span class="form-check-label">Có</span>
                      </label>
                    </div>
                    <span class="text-danger">
                        @error('direct_publisher')
                            {{ $message }}
                        @enderror
                    </span>
                </div> --}}

                        <div class="mb-3">
                            <div class="form-label">Blocked</div>
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model="blocked">
                                <span class="form-check-label"></span>
                            </label>
                        </div>

                        <div style="float: right">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>&nbsp;
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
