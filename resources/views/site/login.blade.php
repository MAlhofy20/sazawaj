@extends('site.master')
@section('title') تسجيل الدخول @endsection
@section('style')

    <style>
    #login,#password{
        height: 60px;
    }
     .login .container{
        max-width: 90%;
        background-color: #ede2ab;
        padding: 30px 15px;
        border-radius: 20px;
    }
    .password-container {
        position: relative;
        width: 100%;
    }

    .password-container input {
        width: 100%;
        padding-right: 40px; /* Space for the icon */
    }

    .password-container i {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
       
    }

    .password-container i:hover {
        color: #333;
    }
        .errorDiv{
            color: white;
            background-color: #d94552;
            font-size: 15px;
            font-weight: bold;
            border-color: #df3648;
            display: block;
            margin-top: 15px;
            text-align: -webkit-auto;
            width: 750px;
            margin-left: 20%;
        }
        
        /* Container for the links */
.auth-links {
    display: flex;                /* Enable flexbox */
    justify-content: center;      /* Horizontally center the links */
    align-items: center;          /* Vertically center the links (if needed) */
    gap: 15px;                    /* Space between the links */
    margin-top: 20px;             /* Space above the links */
}

/* Style for the individual links */
.auth-links .auth-link {
    display: inline-block;
    font-size: 16px;
    color: #fff; /* Using your website's primary color */
    font-weight: 600;
    text-decoration: none;
    padding: 10px;
    border-radius: 30px;
    background-color: #2492a8; /* Light background for the link */
    transition: background-color 0.3s, color 0.3s, box-shadow 0.3s ease-in-out;
}

/* Hover effect for the links */
.auth-links .auth-link:hover {
    background-color: var(--main); /* Change to primary color */
    color: white; /* Text color change on hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
}

/* Focus effect for accessibility */
.auth-link:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(37, 194, 217, 0.5); /* Custom focus outline */
}

/* Responsive Design */
@media (max-width: 768px) {
    .auth-link {
        font-size: 14px; /* Slightly smaller text on mobile */
        padding: 8px 16px;
    }
}

@media (max-width: 480px) {
    .auth-link {
        font-size: 12px; /* Smaller text for very small screens */
        padding: 6px 12px;
    }
}


       
    </style>
@endsection

@section('content')
    <!--  welcome  -->
    <section class="welcome">
        <div class="welcome-img">
            <img src="{{ site_path() }}/assets/img/welcome.png" alt="">
        </div>
    
    
<p class="welcome-tit"> حياك الله معنا فى مجتمع  <span class='text-center' style="color:#2492a8"> {{ settings('site_name') }} </span></p>


    </section>
    <!--  //welcome  -->

    @if ($errors->any())
        <div class="alert alert-danger errorDiv">
                    <span onclick="this.parentElement.style.display='none'"
                          class="w3-button w3-green w3-large w3-display-topright">&times;</span>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="margin-right: 15px">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!--  login  -->
    <section class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">
                    <div class="sec-tit inside ">
                        <div class="img">
                            <img src="{{ site_path() }}/assets/img/icons/user.png" alt="Login Image" class="img-fluid" style="max-width: 35px">
                        </div>
                        <span class="tit">تسجيل الدخول</span>
                    </div>
                <form action="{{route('site_post_login')}}" method="POST">
                    @csrf
                    <input type="hidden" name="device_id" id="device_id">
                    
                    <div class="form-group">
                        <label for="login">اسم المستخدم / البريد الإلكتروني</label>
                        <input type="text" class="form-control" id="login" name="login" placeholder="أدخل البريد الإلكتروني أو اسم المستخدم" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">ادخل كلمة المرور</label>
                        <div class="password-container">
                            <input type="password" class="form-control" id="password" name="password" placeholder="أدخل كلمة المرور" required>
                            <i id="eye-icon" class="fas fa-eye" onclick="togglePassword()"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="main-btn custom_form">
                        دخول
                        <img src="{{ site_path() }}/assets/img/left-arrow.png" alt="Login Image" class="img-fluid">
                    </button>
                    
                    <div class="auth-links">
                        <a href="{{ route('site_forget_password') }}" class="auth-link">هل نسيت كلمة المرور؟</a>
                        <a href="{{ route('site_register') }}" class="auth-link">ليس لديك حساب معنا؟</a>
                    </div>
                </form>

                </div>
{{--                <div class="col-lg-6 col-12">--}}
{{--                    <div class="login-img">--}}
{{--                        <img src="{{ site_path() }}/assets/img/login-img.png" alt="Login Image" class="img-fluid">--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </section>

    <!-- //login -->
@endsection

@section('script')
<script>
    function togglePassword() {
        let passwordInput = document.getElementById("password");
        let eyeIcon = document.getElementById("eye-icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>


@endsection
