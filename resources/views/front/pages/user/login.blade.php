@extends('front.layouts.pages-layout')
@section('pageTitle', @isset($pageTitle) ? $pageTitle : 'Đăng Nhập')
@section('content')
    @if (session()->has('user'))
        
         <script>window.location.href = "{{ route('home') }}";</script>
         {{-- @section('pageTitle', @isset($pageTitle) ? $pageTitle : 'Welcome to Larablog') --}}
    
    @else
        @if (Session::get('fail'))
            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
        @endif

        @if (Session::get('success'))
            <div class="alert alert-danger">{{ Session::get('success') }}</div>
        @endif


        <div style="margin: 0 auto" class=" card  col-lg-7 md-8 card-md">
            <div class="card-body widget-body">
                <h2 class="h2 text-center mb-4">Đăng Nhập</h2>
                <form action="{{ route('login') }}" method="POST" autocomplete="off" novalidate="">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email & Username</label>
                        <input type="text" class="form-control" placeholder="Nhập email hoặc username" name="login_id"
                            autocomplete="off">
                        @error('login_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label " >
                            Password
                            <span class="form-label-description">
                                <a href="{{ route('forgot-user') }}">Quên mật khẩu</a>
                            </span>
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off"
                                name="password">
                          

                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input">
                            <span class="form-check-label">Ghi nhớ mật khẩu trên thiết bị này</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    </div>
                    <hr>

                </form>
                <div class="form-footer ">
                    <div class="form-footer    ">

                        <a href="{{ route('logingoogle') }}"> <button class="btn btn-primary w-100">Google</button></a>
                    </div>
                    {{-- <div class="form-footer ">

                        <a href="{{ route('loginfacebook') }}"> <button class="btn btn-primary w-100">Facebook</button></a>
                    </div> --}}

                </div>

            </div>

        </div>
    @endif


@endsection
@push('scripts')
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
@endpush
