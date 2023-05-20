<div>

    @if (Session::get('fail'))
        <div class="alert alert-danger">
            {{Session::get('fail')}}
        </div>
    @endif
    @if (Session::get('success'))
        <div class="alert alert-success">
          {!! Session::get('success') !!}
        </div>
    @endif

    <form wire:submit.prevent="LoginHandler" method="post" autocomplete="off" novalidate="">
        <div class="mb-3">
          <label class="form-label">Email or Username</label>
          <input type="text" class="form-control" placeholder="Nhập email hoặc username" wire:model="login_id" autocomplete="off">
            @error('login_id')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-2">
          <label class="form-label">
            Password
            <span class="form-label-description">
              <a href="{{ route('author.forgot-password') }}">Quên mật khẩu</a>
            </span>
          </label>
          <div class="input-group input-group-flat">
            <input type="password" class="form-control" placeholder="Nhập mật khẩu" wire:model="password" autocomplete="off">
            {{-- <span class="input-group-text">
              <a href="#" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Show password"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path></svg>
              </a>
            </span> --}}
        </div>
        @error('password')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="mb-2">
          <label class="form-check">
            <input type="checkbox" class="form-check-input">
            <span class="form-check-label text-secondary">Ghi nhớ đăng nhập trên thiết bị này</span>
          </label>
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </div>
    </form>
</div>
