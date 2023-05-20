<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title>@yield('pageTitle')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">

    @yield('meta_tags')
    <link rel="shortcut icon" href="{{ blogInfo()->blog_favicon }}" type="image/x-icon">
    <link rel="icon" href="{{ blogInfo()->blog_favicon }}" type="image/x-icon">

    <!-- theme meta -->
    <meta name="theme-name" content="reporter" />

    <!-- # Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link --}}
    {{-- href="https://fonts.googleapis.com/css2?family=Neuton:wght@700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Arial:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- # CSS Plugins -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/front/plugins/bootstrap/bootstrap.min.css">
    <link href="/front/emoji/css/emoji.css" rel="stylesheet">
    @stack('stylesheets')

    <!-- # Main Style Sheet -->
    <link rel="stylesheet" href="/front/css/style.css">
    
</head>

<body>
   
    @include('front.layouts.inc.header')

    <main>
        <section class="section">
            <div class="container">
                @yield('content')
            </div>
        </section>
    </main>

    @include('front.layouts.inc.footer')


    <!-- # JS Plugins -->
    <script src="/front/emoji/js/config.min.js"></script>
    <script src="/front/emoji/js/util.min.js"></script>
    <script src="/front/emoji//js/jquery.emojiarea.min.js"></script>
    <script src="/front/emoji//js/emoji-picker.min.js"></script>
    <script src="/front/plugins/jquery/jquery.min.js"></script>
    <script src="/front/plugins/bootstrap/bootstrap.min.js"></script>

    @stack('scripts')
    <!-- Main Script -->
   

</body>

</html>
