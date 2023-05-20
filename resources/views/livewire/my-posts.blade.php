<div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">&nbsp;</label>
            <input type="text" icon  wire:model='search' class="form-control" placeholder="Nhập bài viết cần tìm kiếm">
        </div>
        <div class="col-md-2 mb-3">
            <label for="" class="form-label">Danh mục</label>
            <select name="" class="form-select" id="" wire:model='category'> 
                <option value="">None</option>
                @foreach (\App\Models\SubCategory::whereHas('posts')->get() as $category)
                <option value="{{ $category->id }}">{{ $category->subcategory_name }}</option>
                @endforeach
                
            </select>
        </div>

      

       
        

        <div class="col-md-2 mb-3">
            <label for="" class="form-label">Sắp xếp</label>
            <select name="" class="form-select" id="" wire:model='orderBy'>
                <option value="">None</option>
                <option value="asc">Cũ nhất</option>
                <option value="desc">Mới nhất</option>
            </select>
        </div>

    </div>
    
    <div class="row row-cards">
        @forelse ($posts as $post)
        <div class="col-md-6 col-lg-3">
            <div class="card">
                
                <img data-toggle="tooltip" title="{{$post->post_title}}" src="/storage/images/post_images/thumbnails/resized_{{ $post->featured_image }}" alt="" class="img-show-activepost card-img-top">
                <div class="card-body p-2">
                    <h3 class="m-0 mb-1">
                        {{-- {{ $post->post_title }} --}}
                        {!! $this->highlight($post->post_title) !!}
                    </h3>
                    {{-- name tác giả --}}
                    <div class="mt-3">
                        <span class="badge bg-purple-lt" data-toggle="tooltip" title="Đã viết:{{$post->created_at->format('d/m/Y')}}"> {{ $post->author_name }}</span>
                    </div>
                </div>
                <div class="d-flex">
                    <a href="{{ route('author.posts.edit-post',['post_id'=>$post->id]) }}" class="card-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit text-warning" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                            <path d="M16 5l3 3"></path>
                         </svg>
                        Sửa
                    </a>
                    <a href="" wire:click.prevent='deletePost({{ $post->id }})'  class="card-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
            <span class="text-danger">No post(s) found</span>
        @endforelse
    </div>

    <div class="d-block mt-2">
        {{ $posts->links('livewire::bootstrap') }}
    </div>

    {{-- <div class="row mt-4">
        {{ $posts->links('livewire::simple-bootstrap') }}
    </div> --}}