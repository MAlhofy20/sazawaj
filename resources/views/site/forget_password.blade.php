@extends('site.master')
@section('title')
    نسيت كلمة المرور
@endsection
@section('style')
    <style>
    .sec-tit2{
        font-size:30px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #b72dd2;
    }
    .inform{
        color:#b72dd2;
    }
    #email{
        height: 60px;
        font-size: 17px;
    }
    
     #email::placeholder{
        font-size: 17px;
    }
    .register .container{
        max-width: 90%;
        background-color: #ede2ab;
        padding: 30px 15px;
        border-radius: 20px;
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
    @if(!auth()->check())
        <section class="welcome">
            <div class="welcome-img">
                <img src="{{ site_path() }}/assets/img/welcome.png" alt="">
            </div>
            <p class="welcome-tit">أهلاً بكم في موقع {{ settings('site_name') }}</p>
        </section>
    @endif

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
                نسيت كلمة المرور
            </div>
            <form action="{{route('site_post_forget_password')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        
                         <label class="inform" for="email">البريد الإلكتروني</label>
                        <div class="form-group" style="display: none">
                            <label for="email"></label>
                            <select name="type" id="type" onchange="showData()" class="form-control">
                                <option value="email" selected>{{Translate('البريد الإلكتروني')}}</option>
                                <option value="phone">{{Translate('الجوال')}}</option>
                            </select>
                        </div>

                        <div class="flex-container" id="dataDiv" style="margin-bottom: 10px">

                        </div>
                        <div class="text-center">
                        <button type="submit" class="main-btn2 custom_form">أرسل</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- //login -->
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            showData();
        });

        function showData() {
            let type = $('#type').val();
            //<label for="email">{{Translate('البريد الإلكتروني')}}</label>
            let data = `<div class="form-group"><input id="email" class="form-control" name="email" type="email"
                        placeholder="{{Translate('أدخل بريدك الإلكتروني')}}" required></div>`;

            if(type == 'phone') {
                data = ` <div class="form-group" style="display:flex;">
                 {{--   <label for="phone">{{Translate('الجوال')}}</label> --}}
                <input id="phone" class="form-control phone" style="border-radius:0" name="email" type="number" placeholder="{{Translate('الجوال')}}" required>
                                </div>`;
            }

            $('#dataDiv').html(data);
        }
    </script>
@endsection
