<header class="navigation">
     

    <div class="container">

        <nav class="navbar navbar-expand-lg navbar-light px-0">
            <a class="navbar-brand order-1 py-0" href="/">
                <img loading="prelaod" decoding="async" class="img-fluid" src="{{ blogInfo()->blog_logo }}"
                    alt="{{ blogInfo()->blog_name }}" style="max-width: 150px;">
                    
            </a>
            <div class="navbar-actions order-3 ml-0 ml-md-4">
                <button aria-label="navbar toggler" class="navbar-toggler border-0" type="button"
                    data-toggle="collapse" data-target="#navigation"> <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <form action="{{ route('search_posts') }}" class="search order-lg-3 order-md-2 order-3 ml-auto">
                <input id="search-query" name="query" value="{{ Request('query') }}" type="search"
                    placeholder="Tìm kiếm bài viết" autocomplete="off">

                    
            </form>
            <div class="collapse navbar-collapse text-center order-lg-2 order-4" id="navigation">
                <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                    </li>

                    @foreach (App\Models\Category::whereHas('subcategories', function ($query) {
        $query->whereHas('posts');
    })->orderBy('ordering', 'asc')->get() as $category)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ $category->category_name }}
                            </a>
                            <div class="dropdown-menu">
                                @foreach (App\Models\SubCategory::where('parent_category', $category->id)->whereHas('posts')->orderBy('ordering', 'asc')->get() as $subcategory)
                                    <a class="dropdown-item"
                                        href="{{ route('category_posts', $subcategory->slug) }}">{{ $subcategory->subcategory_name }}</a>
                                @endforeach
                            </div>
                        </li>
                    @endforeach

                    {{-- nếu danh mục con không có danh mục cha --}}
                    @foreach (App\Models\SubCategory::where('parent_category', 0)->whereHas('posts')->get() as $subcategory)
                        <li class="nav-item"> <a class="nav-link"
                                href="{{ route('category_posts', $subcategory->slug) }}">{{ $subcategory->subcategory_name }}</a>
                        </li>
                    @endforeach

                    <li class="nav-item"> <a class="nav-link" href="{{route('introduce')}}">Giới thiệu</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('contact')}}">Liên hệ</a>
                    </li>
                    @if (session()->has('user'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-user"></i>

                                {{ session('user')['name'] }}
                            </a>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('watcht-post-follow-guest', session('user')['id']) }}">Bài viết xem sau </a>

                                <a class="dropdown-item" href="{{ route('logout') }}">Đăng Xuất</a>
                                
                            </div>
                        </li>
                    @else
                        {{-- <li class="nav-item"> <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li> --}}
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Tài khoản
                            </a>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('login') }}">Đăng Nhập</a>
                                <a class="dropdown-item" href="{{ route('register') }}">Đăng Ký</a>
                                <a class="dropdown-item" href="{{ route('forgot-user') }}">Quên mật khẩu</a>

                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>

