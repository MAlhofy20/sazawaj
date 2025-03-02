@extends('master')
@section('title') {{ Translate('نسيت كلمة المرور') }} @endsection
@section('style')

@endsection

@section('content')
    <!-- services  -->
    <section id="services-section" class="services">
        <div class="container">
            <h2 class="section-tit">
                {{ Translate('نسيت كلمة المرور') }}
            </h2>
            <div class="section-child">

            </div>
            <div class="hold-servicesForm">
                <div class="servicesForm-tabs-content" data-serv="1">
                    <div class="in-servicesForm">
                        <form action="{{ route('static_post_reset_password') }}" id="formRegister" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                            <div class="form-group">
                                <label for="tel">{{ Translate('الكود المرسل اليك') }}</label>
                                <input id="tel" class="form-control phone" name="code" type="tel"
                                       placeholder="{{ Translate('الكود المرسل اليك') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ Translate('كلمة المرور') }}</label>
                                <input id="password" class="form-control" name="password" type="password"
                                       placeholder="{{ Translate('كلمة المرور') }}" required>
                            </div>
                            <button type="submit" class="main-btn w-100">{{ Translate('حفظ') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  services  -->
@endsection

@section('script')

@endsection
