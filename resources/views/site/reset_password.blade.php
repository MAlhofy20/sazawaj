@extends('site.master')
@section('title')
    استعادة كلمة المرور
@endsection
@section('style')
    <style>
     .register .container{
        max-width: 90%;
        background-color: #ede2ab;
        padding: 30px 15px;
        border-radius: 20px;
    }
    .sec-tit2{
        font-size:30px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #b72dd2;
    }
    .inform{
        height: 60px;
        width: 100%;
        
    }
    .inform::placeholder{
        font-size: 17px;
        
    }
        .errorDiv{
            color: white !important;
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

        .flex-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-content: center;
        }

        .form-group {
            padding: 5px;
            width: 100%;
        }

        /* Responsive layout - makes a one column layout instead of a two-column layout */
        @media (max-width: 1150px) {
            .flex-container {
                flex-direction: column;
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
        <p class="welcome-tit">أهلاً بكم في موقع {{ settings('site_name') }}</p>
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

    <section class="register">
        <div class="container">
            <div class="sec-tit2 inside text-center">
                استعادة كلمة المرور
            </div>
            <div class="alert alert-danger" role="alert">
 تم إرسال كود التحقق إلى بريدك الإلكتروني
</div>
            <form action="{{route('site_post_reset_password')}}" id="formRegister" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="code">الكود المرسل</label>
                         <input type="text" class="form-control inform" id="code" placeholder="أدخل الكود الذي وصلك على بريدك الإلكتروني" name="code" value="" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="password">ادخل كلمة المرور الجديدة</label>
                            <input type="password" class="form-control inform" id="password" placeholder="يرجي إدخال كلمة المرور الجديد" value="" name="password" required autocomplete="off">
                        </div>
                        <div class="text-center">
                        <button type="submit" class="main-btn2 custom_form">حفظ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- //login -->
@endsection

@section('script')
@endsection
