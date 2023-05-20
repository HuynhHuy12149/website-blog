<div>
    <form wire:submit.prevent="updateGeneralSettings" method="post">
        <div class="row">
          {{-- <div class="col-md-6"> --}}
            <div class="mb-3">
              <label for="" class="form-label">Tên trang web/blog</label>
              <input type="text" class="form-control" placeholder="Nhập tên trang web/blog" wire:model="blog_name">
              <span class="text-danger">
                @error('blog_name')
                    {{ $message }}
                @enderror
              </span>
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Email liên hệ</label>
              <input type="text" class="form-control"wire:model="blog_email" placeholder="Nhập email liên hệ">
              <span class="text-danger">
                @error('blog_email')
                {{ $message }}
                @enderror
              </span>
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Mô tả trang web</label>
              <textarea class="form-control" id="" cols="3" rows="3" wire:model="blog_description" placeholder="content..."></textarea>
              <span class="text-danger">
                @error('blog_description')
                {{ $message }}
                @enderror
              </span>
            </div>
            {{-- </div> --}}
          </div>
          <button style="float: right" class="btn btn-primary">Lưu thay đổi</button>
      </form>
</div>
