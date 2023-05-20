@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Trang chủ')
@section('content')
    @livewire('home')
@endsection