<div>
<!-- Danh mục -->
<div class="row">
    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header">
          <ul class="nav nav-pills card-header-pills">
            <h4>Danh mục</h4>
            <li class="nav-item ms-auto">
              <a href="#" class="btn btn-sm btn-primary" data-bs-target='#categories_modal' data-bs-toggle='modal'>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M12 5l0 14"></path>
                  <path d="M5 12l14 0"></path>
               </svg>
                Thêm mới
              </a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
              <thead>
                <tr>
                  <th>Tên danh mục</th>
                  <th>Số lượng danh mục con</th>
                  <th class="w-1"></th>
                </tr>
              </thead>
              <tbody id="sortable_category">
                @forelse ($categories as $category)
                    
                <tr data-index="{{ $category->id }}" data-ordering="{{ $category->ordering }}">
                  <td>{{ $category->category_name }}</td>
                  <td>{{ $category->subcategories->count() }}</td>
                  <td>
                    <div class="btn-group">
                      <a href="" class="btn btn-sm btn-warning" wire:click.prevent="editCategory({{ $category->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                          <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                          <path d="M16 5l3 3"></path>
                       </svg>
                        Sửa
                      </a> &nbsp;&nbsp;
                      <a href="" wire:click.prevent="deleteCategory({{ $category->id }})" class="btn btn-sm btn-danger">
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
                <span class="text-danger">Không có danh mục nào!</span>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>    
    </div>
    
    <!--Danh mục con -->
    <div class="col-md-6 mb-2">
      <div class="card">
        <div class="card-header">
          <ul class="nav nav-pills card-header-pills">
            <h4>Danh mục con</h4>
            <li class="nav-item ms-auto">
              <a href="#" class="btn btn-sm btn-primary" data-bs-target='#subcategories_modal' data-bs-toggle='modal'>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M12 5l0 14"></path>
                  <path d="M5 12l14 0"></path>
               </svg>
                Thêm mới
              </a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
              <thead>
                <tr>
                  <th>Tên danh mục</th>
                  <th>Danh mục cha</th>
                  <th>Số lượng bài viết</th>
                  <th class="w-1"></th>
                </tr>
              </thead>
              <tbody id="sortable_subcategory">
                @forelse ($subcategories as $subcategory)
                <tr data-index="{{ $subcategory->id }}" data-ordering="{{ $subcategory->ordering }}">
                  <td>{{ $subcategory->subcategory_name }}</td>
                  <td>{{ $subcategory->parent_category !=0 ? $subcategory->parentcategory->category_name :  ' - ' }}</td>
                  <td>
                    {{ $subcategory->posts()->where('status', 1)->count() }}
                  </td>
                  <td>
                    <div class="btn-group">
                      <a href="" class="btn btn-sm btn-warning" wire:click.prevent="editSubCategory({{ $subcategory->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                          <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                          <path d="M16 5l3 3"></path>
                       </svg>
                        Sửa
                      </a> &nbsp;&nbsp;
                      <a href=""  wire:click.prevent="deleteSubCategory({{ $subcategory->id }})" class="btn btn-sm btn-danger">
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
                <span class="text-danger">Không có danh mục con nào!</span>
                @endforelse
              </tbody>
            </table>
            <div class="d-block mt-4">
              {{ $subcategories->links('livewire::bootstrap') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  {{-- modal danh mục --}}
  <div wire:ignore.self class="modal modal-blur fade" id="categories_modal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $updateCategoryMode ? 'Sửa danh mục' : 'Thêm danh mục' }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <form method="post"
         @if ($updateCategoryMode)
             wire:submit.prevent="updateCategory()"
         @else
            wire:submit.prevent="addCategory()"
         @endif 
         >
            @if ($updateCategoryMode)
            <input type="hidden" wire:model="selected_category_id">
            @endif
            <div class="mb-3">
                <label class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" name="example-text-input" placeholder="Nhập tên danh mục" wire:model="category_name">
                <span class="text-danger">
                    @error('category_name')
                        {{ $message }}
                    @enderror
                </span>
            </div>
  
            <div style="float: right">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>&nbsp;
                <button type="submit" class="btn btn-primary" >{{ $updateCategoryMode ? 'Cập nhật' : 'Lưu'  }}</button>
              </div>
         </form>
        </div>
        
      </div>
    </div>
  </div>
  
  {{-- modal danh mục con--}}
  <div wire:ignore.self class="modal modal-blur fade" id="subcategories_modal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $updateSubCategoryMode ? 'Sửa danh mục con' : 'Thêm danh mục con' }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <form method="post"
         @if ($updateSubCategoryMode)
             wire:submit.prevent="updateSubCategory()"
         @else
            wire:submit.prevent="addSubCategory()"
         @endif
         >
            @if ($updateSubCategoryMode)
            <input type="hidden" wire:model="selected_subcategory_id">
            @endif
            <div class="mb-3">
              <label class="form-label">Danh mục cha</label>
              <div>
                <select class="form-select" wire:model="parent_category">
                   <option value="0">-- Không có danh mục cha --</option>
                @foreach (\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
                </select>
              </div>
              <span class="text-danger">
                  @error('parent_category')
                      {{ $message }}
                  @enderror
              </span>
            </div>
  
            <div class="mb-3">
              <label class="form-label">Tên danh mục</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Nhập tên danh mục" wire:model="subcategory_name">
              <span class="text-danger">
                  @error('subcategory_name')
                      {{ $message }}
                  @enderror
              </span>
          </div>
  
            <div style="float: right">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>&nbsp;
                <button type="submit" class="btn btn-primary" >{{ $updateSubCategoryMode ? 'Cập nhật' : 'Lưu'  }}</button>
            </div>
         </form>
        </div>
        
      </div>
    </div>
  </div>
</div>
