@extends('front.layouts.pages-layout')
@section('pageTitle', @isset($pageTitle) ? $pageTitle : 'Thay đổi mật khẩu')
@section('content')


    @if (Session::get('fail'))
        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
    @endif
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    {{-- The Master doesn't talk, he acts. --}}
    <div style="margin: 0 auto" class="card col-lg-7 md-8 card-md">
        <div class="card-body widget-body">
            <h2 class="h2 text-center mb-4">Thay Đổi Mật Khẩu </h2>
            <form method="post" action="{{ route('change-password', ['token' => $token, 'email' => $email]) }}" autocomplete="off" novalidate="">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" readonly placeholder="Enter email " value={{ $email }} name="email" autocomplete="off">
                    <span class="text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-2">
                    <label class="form-label">
                        New Password
                    </label>
                    <div class="input-group input-group-flat">
                        <input type="password" name="new_password" value="{{ old('new_password') }}" class="form-control" placeholder="Nhập mật khẩu mới"
                            autocomplete="off" >
                        <span class="input-group-text">
                            <a href="#" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password"
                                data-bs-original-title="Show password">
                                <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                    <path
                                        d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7">
                                    </path>
                                </svg>
                            </a>
                        </span>
        
                    </div>
        
                </div>
        
                <span class="text-danger">
                    @error('new_password')
                        {{ $message }}
                    @enderror
                </span>
                <div class="mb-2">
                    <label class="form-label">
                        Confirm Password
                    </label>
                    <div class="input-group input-group-flat">
                        <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" wire:model='confirm_password'
                            autocomplete="off" name="confirm_password">
                        <span class="input-group-text">
                            <a href="#" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password"
                                data-bs-original-title="Show password">
                                <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                    <path
                                        d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7">
                                    </path>
                                </svg>
                            </a>
                        </span>
        
                    </div>
        
                </div>
                <span class="text-danger">
                    @error('confirm_password')
                        {{ $message }}
                    @enderror
                </span>
        
                <div class="mb-2">
                    {{-- <label class="form-check">
                        <a href="{{ route('login') }}">Back to login page</a>
                    </label> --}}
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Thay đổi mật khẩu</button>
                </div>
            </form>
        </div>

    </div>
    



@endsection
@push('scripts')
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
@endpush
