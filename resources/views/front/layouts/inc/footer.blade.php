<footer class="bg-dark mt-5">


    <div class="copyright bg-dark content">
        <div class="col-lg-10 mx-auto text-center">
            <a class="d-inline-block mb-4 pb-2" href="{{route('login')}}">
                <img loading="prelaod" decoding="async" class="img-fluid" src="{{ blogInfo()->blog_logo }}"
                    alt="{{ blogInfo()->blog_name }}" style="max-width: 150px;">
            </a>

        </div>
        <script>
            document.write(new Date().getFullYear())
        </script> Designed &amp; Developed By <a href="/">{{ blogInfo()->blog_name }}</a>
    </div>
</footer>
