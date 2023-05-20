@extends('back.layouts.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'login')
@section('content')

<div class="page page-center">
  <div class="container container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ \App\Models\Setting::find(1)->blog_logo }}" height="36" alt=""></a>
    </div>
    <div class="card card-md">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">Đặt lại mật khẩu</h2>
        @livewire('author-reset-form')
      </div>
    </div>
    <div class="text-center text-muted mt-3">
      Chưa có tài khoản? <a href="./sign-up.html" tabindex="-1">Đăng ký</a>
    </div>
  </div>
</div>

@endsection