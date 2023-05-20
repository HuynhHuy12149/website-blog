@extends('back.layouts.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'register')
@section('content')

<div class="page page-center">
  <div class="container container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ \App\Models\Setting::find(1)->blog_logo }}" height="36" alt=""></a>
    </div>

    <div class="card card-md">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">Đăng kí vào tài khoản của bạn</h2>
        @livewire('register-author')
      </div>
    </div>
    <div class="text-center text-muted mt-3">
      Đã có tài khoản ? <a href="{{ route('author.login')}}" tabindex="-1">Đăng nhập</a>
    </div>
  </div>
</div>

@endsection