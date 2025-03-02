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
                        <form action="{{ route('static_post_forget_password') }}" id="formRegister" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ Translate('البريد الإلكتروني') }}</label>
                                <input id="email" class="form-control" name="email" type="email"
                                       placeholder="{{ Translate('البريد الإلكتروني') }}" required>
                            </div>
                            <button type="submit" class="main-btn w-100">{{ Translate('ارسال') }}</button>
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
