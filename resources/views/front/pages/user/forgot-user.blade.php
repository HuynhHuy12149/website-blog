@extends('front.layouts.pages-layout')
@section('pageTitle', @isset($pageTitle) ? $pageTitle : 'Quên Mật Khẩu')
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
            <div class="alert alert-danger">{{ Session::get('success') }}</div>
        @endif
        <div style="margin: 0 auto" class="card col-lg-7 md-8 card-md">
            <div class="container container-tight py-4">


                <form class="card card-md" action="{{ route('forgot-user') }}" method="POST" autocomplete="off" novalidate="">
                    @csrf
                    <div class="card-body widget-body">
                        <h2 class="card-title text-center mb-4">Quên Mật Khẩu</h2>
                        <p class="text-muted mb-4">Nhập địa chỉ email và mật khẩu sẽ được đặt lại và gửi đến email cho bạn.</p>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" class="form-control" value="{{ old('email') }}" name="email"
                                placeholder="Enter email">
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror


                            </span>
                        </div>
                        <div class="form-footer">
                            <button type="submit" href="#" class="btn btn-primary w-100">
                                <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z">
                                    </path>
                                    <path d="M3 7l9 6l9 -6"></path>
                                </svg>
                                Gửi tôi liên kết mật khẩu
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Livewire Component wire-end:OlW1uX8vNcqQ3aR5pBPK -->
            {{-- <div class="text-center text-muted mt-3">
                Forget it, <a href="{{ route('login') }}"></a> to the sign in screen.
            </div> --}}
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
