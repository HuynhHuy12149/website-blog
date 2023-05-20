<div>
    <form wire:submit.prevent="changePassword" method="post">
        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Mật khẩu hiện tại</label>
              <input type="password" class="form-control" wire:model="current_password" name="example-text-input" placeholder="Nhập mật khẩu hiện tại">
              <span class="text-danger">
                @error('current_password')
                    {{ $message }}    
                 @enderror
             </span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Mật khẩu mới</label>
              <input type="password" class="form-control" wire:model="new_password" name="example-text-input" placeholder="Nhập mật khẩu mới">
              <span class="text-danger">
                @error('new_password')
                    {{ $message }}    
                 @enderror
             </span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Xác nhận mật khẩu mới </label>
              <input type="password" class="form-control" name="example-text-input" placeholder="Xác nhận lại mật khẩu mới" wire:model="confirm_new_password">
              <span class="text-danger">
                @error('confirm_new_password')
                    {{ $message }}    
                 @enderror
             </span>
            </div>
          </div>
        </div>
        <button style="float: right" type="submit" class="btn btn-primary">Lưu thay đổi</button>
      </form>
</div>
