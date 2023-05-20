<div>
    <header class="navbar navbar-expand-md navbar-light d-print-none sticky-top">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href="{{route('author.login')}}">
                    <img src="{{ \App\Models\Setting::find(1)->blog_logo }}" width="110" height="32"
                        alt="Tabler" class="navbar-brand-image">
                </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <div class="d-none d-md-flex">
                    <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                        data-bs-toggle="tooltip" data-bs-placement="bottom">
                        <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                        </svg>
                    </a>
                    <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                        data-bs-toggle="tooltip" data-bs-placement="bottom">
                        <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                            <path
                                d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                        </svg>
                    </a>
                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                            aria-label="Show notifications">
                            <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                            </svg>
                            <span class="badge bg-red"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Last updates</h3>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span
                                                    class="status-dot status-dot-animated bg-red d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 1</a>
                                                <div class="d-block text-muted text-truncate mt-n1">
                                                    Change deprecated html tags to text decoration classes (#29604)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 2</a>
                                                <div class="d-block text-muted text-truncate mt-n1">
                                                    justify-content:between ⇒ justify-content:space-between (#29734)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions show">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 3</a>
                                                <div class="d-block text-muted text-truncate mt-n1">
                                                    Update change-version.js (#29736)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span
                                                    class="status-dot status-dot-animated bg-green d-block"></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 4</a>
                                                <div class="d-block text-muted text-truncate mt-n1">
                                                    Regenerate package-lock.json (#29730)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                        aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url({{ $author->picture }})"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>{{ $author->name }}</div>
                            <div class="mt-1 small text-muted">{{ $author->username }}</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="{{ route('author.profile') }}" class="dropdown-item">Thông tin cá nhân</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('author.logout') }}" class="dropdown-item"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Đăng
                            xuất</a>
                        <form action="{{ route('author.logout') }}" id="logout-form" method="get">@csrf</form>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('author.home') }}">
                                <span class="nav-link-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                                    </svg>
                                    Trang chủ
                                </span>
                            </a>
                        </li>
                        @if (auth()->user()->type == 1 || auth()->user()->type == 4)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('author.categories') }}">
                                    <span class="nav-link-title">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-category" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 4h6v6h-6z"></path>
                                            <path d="M14 4h6v6h-6z"></path>
                                            <path d="M4 14h6v6h-6z"></path>
                                            <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                        </svg>
                                        Danh mục
                                    </span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->type == 1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('author.authors') }}">
                                    <span class="nav-link-title">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-user" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg>
                                        Tài khoản
                                    </span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-news"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11">
                                        </path>
                                        <path d="M8 8l4 0"></path>
                                        <path d="M8 12l4 0"></path>
                                        <path d="M8 16l4 0"></path>
                                    </svg>
                                    Bài viết
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        @if (auth()->user()->type == 1)
                                            <a class="dropdown-item" href="{{ route('author.posts.add-post') }}">
                                                Thêm mới
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('author.posts.my_posts') }}">
                                                Bài viết của tôi
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('author.posts.all_posts_refuse') }}">
                                                Bài viết cần chỉnh sửa
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('author.posts.all_posts_active') }}">
                                                Bài viết đang chờ duyệt     
                                            </a>
                                            <a class="dropdown-item" href="{{ route('author.posts.all_posts') }}">
                                                Tất cả bài viết
                                            </a>
                                        @endif
                                        @if (auth()->user()->type == 2)
                                            <a class="dropdown-item" href="{{ route('author.posts.add-post') }}">
                                                Thêm mới
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('author.posts.all_posts_active') }}">
                                                Bài viết đang chờ duyệt
                                            </a>

                                            <a class="dropdown-item"
                                                href="{{ route('author.posts.all_posts_refuse') }}">
                                                Bài viết cần chỉnh sửa
                                            </a>
                                            <a class="dropdown-item" href="{{ route('author.posts.all_posts') }}">
                                                Tất cả bài viết
                                            </a>
                                        @endif
                                        @if (auth()->user()->type == 4)
                                            <a class="dropdown-item"
                                                href="{{ route('author.posts.all_posts_active') }}">
                                                Bài viết đang chờ duyệt
                                            </a>
                                            <a class="dropdown-item" href="{{ route('author.posts.all_posts') }}">
                                                Tất cả bài viết
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </li>

                        @if (auth()->user()->type == 1 )
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('author.comments') }}">
                                    <span class="nav-link-title">
                                        <svg class="icon icon-tabler icon-tabler-news"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7zM21.2 431.9c1.8-2.7 3.5-5.4 5.1-8.1c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208s-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6c-15.1 6.6-32.3 12.6-50.1 16.1c-.8 .2-1.6 .3-2.4 .5c-4.4 .8-8.7 1.5-13.2 1.9c-.2 0-.5 .1-.7 .1c-5.1 .5-10.2 .8-15.3 .8c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c4.1-4.2 7.8-8.7 11.3-13.5c1.7-2.3 3.3-4.6 4.8-6.9c.1-.2 .2-.3 .3-.5z" />
                                        </svg>
                                        Bình luận
                                    </span>
                                </a>
                            </li>
                        @endif
                        
                        @if (auth()->user()->type == 4 )
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('author.comments') }}">
                                    <span class="nav-link-title">
                                        <svg class="icon icon-tabler icon-tabler-news"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7zM21.2 431.9c1.8-2.7 3.5-5.4 5.1-8.1c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208s-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6c-15.1 6.6-32.3 12.6-50.1 16.1c-.8 .2-1.6 .3-2.4 .5c-4.4 .8-8.7 1.5-13.2 1.9c-.2 0-.5 .1-.7 .1c-5.1 .5-10.2 .8-15.3 .8c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c4.1-4.2 7.8-8.7 11.3-13.5c1.7-2.3 3.3-4.6 4.8-6.9c.1-.2 .2-.3 .3-.5z" />
                                        </svg>
                                        Bình luận
                                    </span>
                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->type == 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-title">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-settings" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                                            </path>
                                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                        </svg>
                                        Thiết lập
                                    </span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item" href="{{ route('author.settings') }}">
                                                Cài đặt chung
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif


                    </ul>
                </div>
            </div>
        </div>
    </header>
</div>
