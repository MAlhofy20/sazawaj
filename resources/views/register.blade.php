@extends('master')
@section('title') {{ Translate('تسجيل جديد') }} @endsection
@section('style')

@endsection

@section('content')
    <!-- services  -->
    <section id="services-section" class="services">
        <div class="container">
            <h2 class="section-tit">
                {{ Translate('تسجيل جديد') }}
            </h2>
            <div class="section-child">

            </div>
            <div class="hold-servicesForm">
                <div class="servicesForm-tabs-content" data-serv="1">
                    <div class="in-servicesForm">
                        <form action="{{ route('static_post_register') }}" id="formRegister" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ Translate('الاسم') }}</label>
                                <input id="name" class="form-control" name="first_name" type="text"
                                       placeholder="{{ Translate('الاسم') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ Translate('البريد الإلكتروني') }}</label>
                                <input id="email" class="form-control" name="email" type="email"
                                       placeholder="{{ Translate('البريد الإلكتروني') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tel">{{ Translate('الجوال') }}</label>
                                <input id="tel" class="form-control phone" name="phone" type="tel"
                                       placeholder="{{ Translate('الجوال') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ Translate('كلمة المرور') }}</label>
                                <input id="password" class="form-control" name="password" type="password"
                                       placeholder="{{ Translate('كلمة المرور') }}" required>
                            </div>
                            <button type="submit" class="main-btn w-100 login" onclick="login()">{{ Translate('تسجيل جديد') }}</button>
                        </form>
                        <div class="reg-urls d-flex flex-wrap align-items-center justify-content-between">
                            <a class="reg-url" href="{{ route('static_login') }}">
                                {{ Translate('هل لديك حساب ؟') }}
                            </a>
                            {{-- <a class="forget-url" href="#">Forget Your Password</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  services  -->
@endsection

@section('script')
    <script>


        function login() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('static_post_register') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#formRegister")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.login').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        //alert(msg.msg);
                        window.location.assign('{{url('/')}}');
                    }
                }
            });
        }
    </script>
@endsection
