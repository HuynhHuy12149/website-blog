@extends('front.layouts.pages-layout')
@section('pageTitle', @isset($pageTitle) ? $pageTitle : 'Đăng Ký Tài Khoản')
@section('content')

    @if (session()->has('user'))
        <script>
            window.location.href = "{{ route('home') }}";
        </script>
    @else
        @if (Session::get('fail'))
            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
        @endif

        @if (Session::get('success'))
            <div class="alert ">{{ Session::get('success') }}</div>
        @endif


        <div style="margin: 0 auto" class="card col-lg-7 md-8 card-md">
            <div class="card-body widget-body">
                <h2 class="h2 text-center mb-4">Đăng Ký</h2>
                <form action="{{ route('register') }}" method="POST" autocomplete="off" novalidate="">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Fullname</label>
                        <input type="text" class="form-control" placeholder="Nhập họ và tên người dùng "
                            value="{{ old('fullname') }}" id="email" name="fullname" autocomplete="off">
                        @error('fullname')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email </label>
                        <input type="text" class="form-control" placeholder="Nhập Email " value="{{ old('email') }}"
                            id="email" name="email" autocomplete="off">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username </label>
                        <input type="text" class="form-control" placeholder="Nhập Username " name="username"
                            value="{{ old('username') }}" autocomplete="off">
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off"
                                name="password" value="{{ old('password') }}">
                           

                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Confirm Password
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" autocomplete="off"
                                value="{{ old('confirm_password') }}" name="confirm_password">
                      

                        </div>
                        @error('confirm_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <p></p>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                    </div>
                </form>

            </div>

        </div>
    @endif


@endsection
