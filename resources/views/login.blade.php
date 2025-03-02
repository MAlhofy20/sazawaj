@extends('master')
@section('title') {{ Translate('تسجيل الدخول') }} @endsection
@section('style')

@endsection

@section('content')
    <!-- services  -->
    <section id="services-section" class="services">
        <div class="container">
            <h2 class="section-tit">
                {{ Translate('تسجيل الدخول') }}
            </h2>
            <div class="section-child">

            </div>
            <div class="hold-servicesForm">
                <div class="servicesForm-tabs-content" data-serv="1">
                    <div class="in-servicesForm">
                        <form action="{{route('static_post_login')}}" id="formRegister" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{Translate('البريد الإلكتروني')}}</label>
                                <input id="email" class="form-control" name="email" type="email" placeholder="{{Translate('البريد الإلكتروني')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">{{Translate('كلمة المرور')}}</label>
                                <input id="password" class="form-control" name="password" type="password"
                                       placeholder="{{Translate('كلمة المرور')}}" required>
                            </div>
                            <button type="submit" class="main-btn w-100">{{Translate('تسجيل الدخول')}}</button>
                        </form>
                        <div class="reg-urls d-flex flex-wrap align-items-center justify-content-between">
                            <a class="reg-url" href="{{ route('static_register') }}">{{Translate('تسجيل جديد')}}</a>
                            <a class="forget-url" href="{{route('static_forget_password')}}">{{Translate('هل نسيت كلمة المرور ؟')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  services  -->
@endsection

@section('script')

@endsection
