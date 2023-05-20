<div>
    <form wire:submit.prevent="updateBlogSocialMedia" method="post">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="" class="form-label">Facebook</label>
              <input type="text" class="form-control" placeholder="Facebook page Url" wire:model="facebook_url">
              <span class="text-danger">
                @error('facebook_url')
                    {{ $message }}
                @enderror
              </span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="" class="form-label">Instagram</label>
              <input type="text" class="form-control" placeholder="Instagram Url" wire:model="instagram_url">
              <span class="text-danger">
                @error('instagram_url')
                    {{ $message }}
                @enderror
              </span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="" class="form-label">YouTube</label>
              <input type="text" class="form-control" placeholder="Youtube Change Url" wire:model="youtube_url">
              <span class="text-danger">
                @error('youtube_url')
                    {{ $message }}
                @enderror
              </span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="" class="form-label">Zalo</label>
              <input type="text" class="form-control" placeholder="Zalo url" wire:model="zalo_url">
              <span class="text-danger">
                @error('zalo_url')
                    {{ $message }}
                @enderror
              </span>
            </div>
          </div>
        </div>
        <button class="btn btn-primary" type="submit">Cập nhật</button>
      </form>
</div>
