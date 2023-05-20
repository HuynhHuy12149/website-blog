<div style="width: 600px; margin: 0 auto; " >
    <div style="text-align: center">
        <h2> hi, {{ $name }}</h2>
        <p>Cảm ơn bạn đã đăng ký tài khoản tại website LaraBlog</p>
        <p>Để tiếp tục sử dụng dịch vụ bên website laraBlog. Bạn vui lòng click vào nút bên dưới để kích hoạt tài khoản</p>
   
        <p>
            <a href="{{ route('author.active-account-author',['token'=>$token,'email'=>$email ]) }}" style="display: inline-block; background: green;color: #fff;padding: 7px 25px; font-weight: bold">Kích Hoạt Tài Khoản</a>
        </p>
    </div>

</div>