@extends('back.layouts.auth-layout')
@section('pageTile', isset($pageTitle) ? $pageTile : 'login')
@section('content')
<div class="page page-center">
  <div class="container container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ \App\Models\Setting::find(1)->blog_logo }}" height="36" alt=""></a>
    </div>
    @livewire('author-forgot-form')
    <div class="text-center text-muted mt-3">
      Không cần rồi, <a href="{{ route('author.login', ['id'=>1]) }}"> Đưa tôi trở lại</a> màn hình đăng nhập.
    </div>
  </div>
</div>
@endsection