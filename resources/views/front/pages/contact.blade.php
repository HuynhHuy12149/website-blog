@extends('front.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Welcome to larablog')
@section('content')

    <section class="section">
        <div class="container">
            <div class="row">

                <div class="col-lg-4">
                    <h2 class="section-title">Liên Hệ</h2>
                    <div class="pr-0 pr-lg-4">

                        <div class="content">Mong các bạn đóng góp ý kiến về trang web của chúng tôi. Tôi chân thành cảm ơn
                            !!!
                            <div class="mt-5">
                                <p class="h3 mb-3 font-weight-normal"><a class="text-dark"
                                        href="mailto:hvhuy_20th@student.agu.edu.vn">hvhuy_20th@student.agu.edu.vn</a>
                                </p>
                                {{-- <p class="h3 mb-3 font-weight-normal"><a class="text-dark" href="mailto:tykhoa_20th@student.agu.edu.vn">tykhoa_20th@student.agu.edu.vn</a>
                            </p> --}}
                                <p class="mb-3"><a class="text-dark" href="tel:+84 794904292">+84 794904292</a>
                                </p>
                                <p class="mb-2">Long Xuyên - An Giang</p>
                                <div class="mb-2">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3924.516019189708!2d105.44623399999999!3d10.3805281!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310a72fb8a915555%3A0xe44b8cd3861a27ad!2zMTkzIEzDvSBUaMOhaSBU4buVLCBN4bu5IExvbmcsIFRow6BuaCBwaOG7kSBMb25nIFh1ecOqbiwgQW4gR2lhbmcsIFZpZXRuYW0!5e0!3m2!1sen!2s!4v1682045107448!5m2!1sen!2s"
                                        width="250" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 mt-4 mt-lg-0">
                    @if (Session::get('fail'))
                        <div class="col-lg-6 mt-4 mt-lg-0 alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                    @endif
                    @if (Session::get('success'))
                        <div class=" mt-4 mt-lg-0 alert alert-success">
                            {!! Session::get('success') !!}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('contact') }}" class="row">
                        @csrf
                        @if (session()->has('user'))
                        <div class="col-md-6 mb-4">
                            <input type="text" class="form-control" value="{{session('user')['name']}}" placeholder="Nhập họ và tên" name="name"
                                id="name">
                            @error('name')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        
                            </div>
                        <div class="col-md-6 mb-4">
                            <input type="email" class="form-control " value="{{session('user')['email']}}" placeholder="Nhập Email" name="email"
                                id="email">
                            @error('email')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        @else
                        <div class="col-md-6 mb-4">
                            <input type="text" class="form-control" placeholder="Nhập họ và tên" name="name"
                                id="name">
                            @error('name')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="email" class="form-control " placeholder="Nhập Email" name="email"
                                id="email">
                            @error('email')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        @endif
                        
                        
                        <div class="col-12 mb-4">
                            <input type="text" class="form-control " placeholder="Nhập Chủ đề" name="subject"
                                id="subject">
                            @error('subject')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mb-4">
                            <textarea name="messages" class="form-control" placeholder="Nhập nội dung........" rows="5"></textarea>
                            @error('messages')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button class="btn btn-outline-primary" type="submit">Gửi Tin Nhắn</button>
                        </div>
                    </form>
                </div>
                <br>

            </div>
        </div>


    </section>
@endsection
