<div>
    <form wire:submit.prevent="UpdateDetails" method="post">
        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" wire:model="name" name="example-text-input" placeholder="Tên của bạn">
              <span class="text-danger">
                @error('name')
                    {{ $message }}    
                 @enderror
             </span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" wire:model="username" name="example-text-input" placeholder="Tên đăng nhập">
              <span class="text-danger">
                @error('username')
                    {{ $message }}    
                 @enderror
             </span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Email" disabled wire:model="email">
              <span class="text-danger">
                @error('email')
                    {{ $message }}    
                 @enderror
             </span>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Tiểu sử</label>
          <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Content.." wire:model="biography"></textarea>
        </div>
        <button style="float: right" type="submit" class="btn btn-primary">Lưu thay đổi</button>
      </form>
</div>
