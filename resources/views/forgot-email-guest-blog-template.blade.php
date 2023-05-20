<div style="width: 600px; margin: 0 auto; " >
    <div style="text-align: center">
        <h2> hi, {{ $name }}</h2>
        <p>Bạn muốn thay đổi mật khẩu</p>
        <p>Để có thể thay thế mật khẩu bạn vui lòng click vào nút bên dưới </p>
   
        <p>
            <a href="{{ route('reset-form',['token'=>$token,'email'=>$email ]) }}" style="display: inline-block; background: green;color: #fff;padding: 7px 25px; font-weight: bold">Thay đổi mật khẩu</a>
        </p>
    </div>

</div>