@extends('master')
@section('title') {{$provider->full_name}} @endsection
@section('style')
    <style>
        /* تنسيق زر التبويب */
        .tablinks {
            background-color: #f0f0f0;
            padding: 10px 20px;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        .form-tel-inp{
            display: flex;
            align-items: center;
        }
        .num-tel{
            width: 25% !important;
            text-align: center;
            margin-inline-start: 10px;
            color: red !important;
            font-size: 20px;
            font-weight: bold;
        }
        /* تحديد الزر النشط */
        .tablinks.active {
            background-color: #ddd;
        }

        /* إخفاء جميع عناصر النماذج في البداية */
        .tabcontent {
            display: none;
        }
        #booking_later01Div input , #booking_later01Div select ,#booking_later02Div input ,#booking_later02Div select {
            margin-bottom : 10px;
               height: 50px !important;

            padding-inline-start: 10px;
        }
        .form-btn a{
    /* width: 180px; */
    height: 50px;
    line-height: 50px;
    text-align: center;
    background-color: var(--para);
    color: #fff;
    border-radius: 10px;
    /* margin-inline-end: 15px; */
    display: block;
    padding: 0 15px;
    font-size: 24px;
    margin-bottom: 30px;
    transition: all .35s ease-in-out;
        }


        .form-btn a:hover {
            background-color: var(--sec);

        }

    </style>
@endsection

@section('content')
    @php $year = (int) Carbon\Carbon::now()->format('Y'); @endphp
    <!-- services  -->
    <section id="services-section" class="services">
        <div class="container">
            <h4 class="section-tit">
                {{$provider->full_name}}
            </h4>
            <div class="section-child">
                {{Translate('ما نستطيع ان نقدمه لك')}}
            </div>
            <div class="section-child-r">
                {{Translate('الخدمات المقدمة')}}
            </div>
            <div class="tabs">
                <button class="tablinks"
                        onclick="$('.tabcontent').hide();$('#form1').show();"
                        {{--onclick="toggleForm('form1')"--}}>
                    {{Translate('إصدار')}}
                </button>
                <button class="tablinks"
                        onclick="$('.tabcontent').hide();$('#form2').show();"
                        {{--onclick="toggleForm('form2')"--}}>
                    {{Translate('تجديد')}}
                </button>

                <form action="{{route('site_store_order')}}" id="form1" class="tabcontent" method="post" enctype="multipart/form-data"
                      onsubmit="stop_form()">
                    @csrf
                    <input type="hidden" name="type" value="issuance">
                    <input type="hidden" name="user_id" value="{{auth()->check() ? auth()->id() : null}}">
                    <input type="hidden" name="user_name" value="{{auth()->check() ? auth()->user()->name : null}}">
                    <input type="hidden" name="provider_id" value="{{$provider->id}}">
                    <input type="hidden" name="provider_name" value="{{$provider->full_name_ar}}">
                    <input type="hidden" name="sub_total" value="{{$provider->price}}">
                    <input type="hidden" name="total_before_promo" value="{{$provider->price}}">
                    <input type="hidden" name="total_after_promo" value="{{$provider->price}}">

                    <fieldset>
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="form-focused form-group cu-input">
                                    <label for="name">{{Translate('الاسم بالكامل')}}</label>
                                    <input id="name" type="text" name="name" value="{{old('name')}}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-focused form-tel form-group cu-input">
                                    <label for="tel">{{Translate('رقم الجوال')}} <span style="color: red">({{Translate('يجب ان يبدأ رقم الجوال بـ 05')}})</span></label>
                                  <div class="form-tel-inp">
                                      <input id="tel" type="tel" name="phone" value="{{old('phone')}}" class="phone" required>

                                      <input class="num-tel" value="966" disabled >
                                  </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-focused form-group cu-input">
                                    <label for="id">{{Translate('رقم الهوية')}} <span style="color: red">({{Translate('يجب ان يبدأ رقم الهوية بالرقم 1 او 2')}})</span></label>
                                    {{--<input id="id" type="number" minlength="10" maxlength="10" name="id_number" value="{{old('id_number)}}" class="" required>--}}
                                    <input type="number" name="id_number" dir="ltr" value="{{old('id_number')}}" minlength="10" maxlength="10" required>
                                </div>
                            </div>
                            {{--<div class="col-lg-4">
                                <div class="form-focused form-group cu-input">
                                    <label for="date">{{Translate('تاريخ الميلاد')}}</label>
                                    <input type="text" name="birthdate" value="{{old('birthdate')}}" class="datepicker" required>
                                </div>
                            </div>--}}
                            <div class="col-lg-4">
                                <span style="text-align: start ; display: block ; font-size: 22px; font-weight: bold"  >
                                    {{Translate('تاريخ الميلاد')}}

                                </span>
                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <div class="form-focused form-group  cu-input cu-input-cl-4">
                                            <label for="date">{{Translate('يوم')}}</label>
                                            <select name="day" class="form-control" required>
                                                @for($i=1; $i <= 31; $i++)
                                                    <option value="{{$i}}" {{old('day') == $i ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-4">
                                        <div class="form-focused form-group cu-input cu-input-cl-4">
                                            <label for="date">{{Translate('شهر')}}</label>
                                            <select name="month" class="form-control" required>
                                                @for($i=1; $i <= 12; $i++)
                                                    <option value="{{$i}}" {{old('month') == $i ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-4">
                                        <div class="form-focused form-group cu-input cu-input-cl-4">
                                            <label for="date">{{Translate('سنة')}}</label>
                                            <select name="year" class="form-control" required>
                                                @for($i = $year; $i >= 1900; $i--)
                                                    <option value="{{$i}}" {{old('year') == $i ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-lg-4">
                                <div class="form-focused form-group cu-input">
                                    <label for="img">{{Translate('الهوية')}}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="img" name="photo" value="{{old('photo')}}"
                                               accept="image/*">
                                        <label class="custom-file-label" for="img">{{Translate('ارفق صورة الهوية')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-focused form-group cu-input">
                                    <p>{{Translate('طريقة الحجز')}}</p>
                                    <div class="servicesInput radioInput">
                                        <div class="hold-radio">
                                            <input type="radio" id="booking_now01" name="booking_method"
                                                   value="now" {{old('booking_method') == 'now' ? 'checked' : ''}} checked>
                                            <label onclick="$('#booking_later01Div').hide()" for="booking_now01" class="checkmark"></label>
                                            <label onclick="$('#booking_later01Div').hide()" for="booking_now01">{{Translate('حجز الآن')}}</label>
                                        </div>
                                        <div class="hold-radio">
                                            <input type="radio" id="booking_later01" name="booking_method"
                                                   value="later" {{old('booking_method') == 'later' ? 'checked' : ''}}>
                                            <label onclick="$('#booking_later01Div').show()" for="booking_later01" class="checkmark"></label>
                                            <label onclick="$('#booking_later01Div').show()" for="booking_later01">{{Translate('حجز في وقت لاحق')}}</label>
                                        </div>
                                    </div>

                                    <div class="form-group" id="booking_later01Div" style="display: none">
                                        <label for="date">{{Translate('موعد الحجز')}}</label>
                                        <input type="text" name="booking_later_date" value="{{old('booking_later_date')}}" class="datepicker" placeholder="{{Translate('التاريخ')}}">
                                        {{-- <input type="text" name="booking_later_date" value="{{old('booking_later_date')}}" class="datepicker"> --}}
                                        <select name="booking_later_time" id="">
                                            <option value="">{{Translate('الوقت')}}</option>
                                            @foreach (generateTimeArray(date('H:i', strtotime($provider->start_time)), date('H:i', strtotime($provider->end_time)), '30 minutes') as $time)
                                                <option value="{{$time}}">{{$time}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-focused form-group cu-input">
                                    <p>{{Translate('طريقة الدفع')}}</p>
                                    <div class="servicesInput radioInput">
                                        <div class="hold-radio">
                                            <input type="radio" id="booking_cash01" name="payment_method"
                                                   value="cash" {{old('payment_method') == 'cash' ? 'checked' : ''}} checked>
                                            <label for="booking_cash01" class="checkmark"></label>
                                            <label for="booking_cash01">{{Translate('الدفع كاش')}}</label>
                                        </div>
                                        <div class="hold-radio">
                                            <input type="radio" id="booking_point01" name="payment_method"
                                                   value="point" {{old('payment_method') == 'point' ? 'checked' : ''}}>
                                            <label for="booking_point01" class="checkmark"></label>
                                            <label for="booking_point01">{{Translate('نقاط بيع')}}</label>
                                        </div>
                                        <div class="hold-radio">
                                            <input type="radio" id="booking_online01" name="payment_method"
                                                   value="online" {{old('payment_method') == 'online' ? 'checked' : ''}}>
                                            <label for="booking_online01" class="checkmark"></label>
                                            <label for="booking_online01">{{Translate('الدفع اونلاين')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-btn" style="display: table; margin: 0 auto">
                                    <a href="https://www.google.com/maps/?q={{$provider->lat}},{{$provider->lng}}"
                                       target="_blanck"><i class="fa-solid fa-map"></i> {{Translate('عرض موقع الكشف')}}</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-btn" style="display: table; margin: 0 auto">
                                    <button type="submit" id="submitButton1" class="with-arrow main-btn submitBtn">
                                        <p class="submitSpan" id="submitSpan1">
                                            <span>{{Translate('ارسل')}}</span>
                                            {{--<i class="fa-solid fa-arrow-left-long"></i>--}}
                                        </p>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>

                <form action="{{route('site_store_order')}}" id="form2" class="tabcontent" method="post" enctype="multipart/form-data"
                      onsubmit="stop_form()">
                    @csrf
                    <input type="hidden" name="type" value="renewal">
                    <input type="hidden" name="user_id" value="{{auth()->check() ? auth()->id() : null}}">
                    <input type="hidden" name="user_name" value="{{auth()->check() ? auth()->user()->name : null}}">
                    <input type="hidden" name="provider_id" value="{{$provider->id}}">
                    <input type="hidden" name="provider_name" value="{{$provider->full_name_ar}}">
                    <input type="hidden" name="sub_total" value="{{$provider->renewal_price}}">
                    <input type="hidden" name="total_before_promo" value="{{$provider->renewal_price}}">
                    <input type="hidden" name="total_after_promo" value="{{$provider->renewal_price}}">

                    <fieldset>
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="form-focused form-group cu-input">
                                    <label for="name">{{Translate('الاسم بالكامل')}}</label>
                                    <input id="name" type="text" name="name" value="{{old('name')}}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-focused form-tel form-group cu-input">
                                    <label for="tel">{{Translate('رقم الجوال')}} <span style="color: red">({{Translate('يجب ان يبدأ رقم الجوال بـ 05')}})</span></label>
                                 <div class="form-tel-inp">
                                     <input id="tel" type="tel" name="phone" value="{{old('phone')}}" class="phone" required>

                                     <input class="num-tel" value="966" disabled >

                                 </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-focused form-group cu-input">
                                    <label for="id">{{Translate('رقم الهوية')}} <span style="color: red">({{Translate('يجب ان يبدأ رقم الهوية بالرقم 1 او 2')}})</span></label>
                                    {{--<input id="id" type="number" minlength="10" maxlength="10" name="id_number" class="" required>--}}
                                    <input type="number" name="id_number" dir="ltr" value="{{old('id_number')}}" minlength="10" maxlength="10" required>
                                </div>
                            </div>
                            {{--<div class="col-lg-4">
                                <div class="form-focused form-group cu-input">
                                    <label for="date">{{Translate('تاريخ الميلاد')}}</label>
                                    <input type="text" name="birthdate" value="{{old('birthdate')}}" class="datepicker" required>
                                </div>
                            </div>--}}
                            <div class="col-lg-4">
                                <span style="text-align: start ; display: block ; font-size: 22px; font-weight: bold"  >
                                    {{Translate('تاريخ الميلاد')}}

                                </span>
                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <div class="form-focused form-group  cu-input cu-input-cl-4">
                                            <label for="date">{{Translate('يوم')}}</label>
                                            <select name="day" class="form-control" required>
                                                @for($i=1; $i <= 31; $i++)
                                                    <option value="{{$i}}" {{old('day') == $i ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-4">
                                        <div class="form-focused form-group cu-input cu-input-cl-4">
                                            <label for="date">{{Translate('شهر')}}</label>
                                            <select name="month" class="form-control" required>
                                                @for($i=1; $i <= 12; $i++)
                                                    <option value="{{$i}}" {{old('month') == $i ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-4">
                                        <div class="form-focused form-group cu-input cu-input-cl-4">
                                            <label for="date">{{Translate('سنة')}}</label>
                                            <select name="year" class="form-control" required>
                                                @for($i = $year; $i >= 1900; $i--)
                                                    <option value="{{$i}}" {{old('year') == $i ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="form-focused form-group cu-input">
                                    <label for="img">{{Translate('الرخصة')}}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="img" name="photo" value="{{old('photo')}}"
                                               accept="image/*">
                                        <label class="custom-file-label" for="img">{{Translate('ارفق صورة الرخصة')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-focused form-group cu-input">
                                    <p>{{Translate('طريقة الحجز')}}</p>
                                    <div class="servicesInput radioInput">
                                        <div class="hold-radio">
                                            <input type="radio" id="booking_now02" name="booking_method"
                                                   value="now" {{old('booking_method') == 'now' ? 'checked' : ''}} checked>
                                            <label onclick="$('#booking_later02Div').hide()" for="booking_now02" class="checkmark"></label>
                                            <label onclick="$('#booking_later02Div').hide()" for="booking_now02">{{Translate('حجز الآن')}}</label>
                                        </div>
                                        <div class="hold-radio">
                                            <input type="radio" id="booking_later02" name="booking_method"
                                                   value="later" {{old('booking_method') == 'later' ? 'checked' : ''}}>
                                            <label onclick="$('#booking_later02Div').show()" for="booking_later02" class="checkmark"></label>
                                            <label onclick="$('#booking_later02Div').show()" for="booking_later02">{{Translate('حجز في وقت لاحق')}}</label>
                                        </div>
                                    </div>

                                    <div class="form-group" id="booking_later02Div" style="display: none">
                                        <label for="date">{{Translate('موعد الحجز')}}</label>
                                        <input type="text" name="booking_later_date" value="{{old('booking_later_date')}}" class="datepicker" placeholder="{{Translate('التاريخ')}}">
                                        <select name="booking_later_time" id="">
                                            <option value="">{{Translate('الوقت')}}</option>
                                            @foreach (generateTimeArray(date('H:i', strtotime($provider->start_time)), date('H:i', strtotime($provider->end_time)), '30 minutes') as $time)
                                                <option value="{{$time}}">{{$time}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-focused form-group cu-input">
                                    <p>{{Translate('طريقة الدفع')}}</p>
                                    <div class="servicesInput radioInput">
                                        <div class="hold-radio">
                                            <input type="radio" id="booking_cash02" name="payment_method"
                                                   value="cash" {{old('payment_method') == 'cash' ? 'checked' : ''}} checked>
                                            <label for="booking_cash02" class="checkmark"></label>
                                            <label for="booking_cash02">{{Translate('الدفع كاش')}}</label>
                                        </div>
                                        <div class="hold-radio">
                                            <input type="radio" id="booking_point02" name="payment_method"
                                                   value="point" {{old('payment_method') == 'point' ? 'checked' : ''}}>
                                            <label for="booking_point02" class="checkmark"></label>
                                            <label for="booking_point02">{{Translate('نقاط بيع')}}</label>
                                        </div>
                                        <div class="hold-radio">
                                            <input type="radio" id="booking_online02" name="payment_method"
                                                   value="online" {{old('payment_method') == 'online' ? 'checked' : ''}}>
                                            <label for="booking_online02" class="checkmark"></label>
                                            <label for="booking_online02">{{Translate('الدفع اونلاين')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-lg-4">
                                <div class="form-focused form-group cu-input">
                                    <label for="promo_code">{{Translate('كود الخصم')}} ({{Translate('ان وجد')}})</label>
                                    <input type="text" name="promo_code" value="{{old('promo_code')}}" class="search-input">
                                    --}}{{--<button type="button" class="search-button">{{Translate('تطبيق')}}</button>--}}{{--
                                </div>
                            </div>--}}
                            <div class="col-12">
                                <div class="form-btn" style="display: table; margin: 0 auto">
                                    <a href="https://www.google.com/maps/?q={{$provider->lat}},{{$provider->lng}}"
                                       target="_blanck"><i class="fa-solid fa-map"></i> {{Translate('عرض موقع الكشف')}}</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-btn" style="display: table; margin: 0 auto">
                                    <button type="submit" id="submitButton2" class="with-arrow main-btn submitBtn">
                                        <p class="submitSpan" id="submitSpan2">
                                            <span>{{Translate('ارسل')}}</span>
                                            {{--<i class="fa-solid fa-arrow-left-long"></i>--}}
                                        </p>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>




            {{--<div class="section-child">
                {{Translate('ما نستطيع ان نقدمه لك')}}
            </div>
            <div class="hold-vision-tabs">
                <ul id="servicesForm-tabs">
                    <li data-serv="1">{{Translate('إصدار')}}</li>
                    <li data-serv="2">{{Translate('تجديد')}}</li>
                </ul>
            </div>
            <div class="hold-servicesForm">
                <div class="servicesForm-tabs-content" data-serv="1">
                    <div class="in-servicesForm">
                        <form action="{{route('site_store_order')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="issuance">
                            <input type="hidden" name="user_id" value="{{auth()->check() ? auth()->id() : null}}">
                            <input type="hidden" name="user_name" value="{{auth()->check() ? auth()->user()->name : null}}">
                            <input type="hidden" name="provider_id" value="{{$provider->id}}">
                            <input type="hidden" name="provider_name" value="{{$provider->full_name_ar}}">
                            <input type="hidden" name="sub_total" value="{{$provider->price}}">
                            <input type="hidden" name="total_before_promo" value="{{$provider->price}}">
                            <input type="hidden" name="total_after_promo" value="{{$provider->price}}">

                            <fieldset>
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="form-focused form-group cu-input">
                                            <label for="name">{{Translate('الاسم بالكامل')}}</label>
                                            <input id="name" type="text" name="name" value="{{old('name')}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-focused form-group cu-input">
                                            <label for="tel">{{Translate('رقم الجوال')}} <span style="color: red">({{Translate('يجب ان يبدأ رقم الجوال بـ 05')}})</span></label>
                                            <input id="tel" type="tel" name="phone" value="{{old('phone')}}" class="phone" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-focused form-group cu-input">
                                            <label for="id">{{Translate('رقم الهوية')}} <span style="color: red">({{Translate('يجب ان يبدأ رقم الهوية بالرقم 1 او 2')}})</span></label>
                                            --}}{{--<input id="id" type="number" minlength="10" maxlength="10" name="id_number" value="{{old('id_number)}}" class="" required>--}}{{--
                                            <input type="number" name="id_number" value="{{old('id_number')}}" minlength="10" maxlength="10" required>
                                        </div>
                                    </div>
                                    --}}{{--<div class="col-lg-4">
                                        <div class="form-focused form-group cu-input">
                                            <label for="date">{{Translate('تاريخ الميلاد')}}</label>
                                            <input type="text" name="birthdate" value="{{old('birthdate')}}" class="datepicker" required>
                                        </div>
                                    </div>--}}{{--
                                    <div class="col-lg-1">
                                        <div class="form-focused form-group cu-input">
                                            <label for="date">{{Translate('يوم')}}</label>
                                            <select name="day" value="{{old('day')}}" class="form-control" required>
                                                @for($i=1; $i <= 31; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-focused form-group cu-input">
                                            <label for="date">{{Translate('شهر')}}</label>
                                            <select name="month" value="{{old('month')}}" class="form-control" required>
                                                @for($i=1; $i <= 12; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-focused form-group cu-input">
                                            <label for="date">{{Translate('سنة')}}</label>
                                            <select name="year" value="{{old('year')}}" class="form-control" required>
                                                @for($i = $year; $i >= 1900; $i--)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-focused form-group cu-input">
                                            <label for="img">{{Translate('الهوية')}}</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="img" name="photo" value="{{old('photo')}}"
                                                       accept="image/*">
                                                <label class="custom-file-label" for="img">{{Translate('ارفق صورة الهوية')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-focused form-group cu-input">
                                            <p>{{Translate('طريقة الحجز')}}</p>
                                            <div class="servicesInput radioInput">
                                                <div class="hold-radio">
                                                    <input type="radio" id="booking_now01" name="booking_method"
                                                           value="now" {{old('booking_method') == 'now' ? 'checked' : ''}} checked>
                                                    <label onclick="$('#booking_later01Div').hide()" for="booking_now01" class="checkmark"></label>
                                                    <label onclick="$('#booking_later01Div').hide()" for="booking_now01">{{Translate('حجز الآن')}}</label>
                                                </div>
                                                <div class="hold-radio">
                                                    <input type="radio" id="booking_later01" name="booking_method"
                                                           value="later" {{old('booking_method') == 'later' ? 'checked' : ''}}>
                                                    <label onclick="$('#booking_later01Div').show()" for="booking_later01" class="checkmark"></label>
                                                    <label onclick="$('#booking_later01Div').show()" for="booking_later01">{{Translate('حجز في وقت لاحق')}}</label>
                                                </div>
                                            </div>

                                            <div class="form-group" id="booking_later01Div" style="display: none">
                                                <label for="date">{{Translate('موعد الحجز')}}</label>
                                                <input type="text" name="booking_later_date" value="{{old('booking_later_date')}}" class="datepicker">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-focused form-group cu-input">
                                            <p>{{Translate('طريقة الدفع')}}</p>
                                            <div class="servicesInput radioInput">
                                                <div class="hold-radio">
                                                    <input type="radio" id="booking_cash01" name="payment_method"
                                                           value="cash" {{old('payment_method') == 'cash' ? 'checked' : ''}} checked>
                                                    <label for="booking_cash01" class="checkmark"></label>
                                                    <label for="booking_cash01">{{Translate('الدفع كاش')}}</label>
                                                </div>
                                                <div class="hold-radio">
                                                    <input type="radio" id="booking_point01" name="payment_method"
                                                           value="point" {{old('payment_method') == 'point' ? 'checked' : ''}}>
                                                    <label for="booking_point01" class="checkmark"></label>
                                                    <label for="booking_point01">{{Translate('نقاط بيع')}}</label>
                                                </div>
                                                <div class="hold-radio">
                                                    <input type="radio" id="booking_online01" name="payment_method"
                                                           value="online" {{old('payment_method') == 'online' ? 'checked' : ''}}>
                                                    <label for="booking_online01" class="checkmark"></label>
                                                    <label for="booking_online01">{{Translate('الدفع اونلاين')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
--}}{{--                                    <div class="col-lg-4">--}}{{--
--}}{{--                                        <div class="form-focused form-group cu-input">--}}{{--
--}}{{--                                            <label for="promo_code">{{Translate('كود الخصم')}} ({{Translate('ان وجد')}})</label>--}}{{--
--}}{{--                                            <input type="text" name="promo_code" value="{{old('promo_code')}}" class="search-input">--}}{{--
--}}{{--                                            --}}{{----}}{{--<button type="button" class="search-button">{{Translate('تطبيق')}}</button>--}}{{--
--}}{{--                                        </div>--}}{{--
--}}{{--                                    </div>--}}{{--
                                    <div class="col-12">
                                        <div class="form-btn" style="display: table; margin: 0 auto">
                                            <a href="https://www.google.com/maps/?q={{$provider->lat}},{{$provider->lng}}"
                                               target="_blanck"><i class="fa-solid fa-map"></i> {{Translate('عرض موقع الكشف')}}</a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-btn" style="display: table; margin: 0 auto">
                                            <button type="submit" class="with-arrow main-btn">
                                                <span>{{Translate('ارسل')}}</span>
                                                <i class="fa-solid fa-arrow-left-long"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="servicesForm-tabs-content" data-serv="2">
                    <div class="in-servicesForm">
                        <form action="{{route('site_store_order')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="renewal">
                            <input type="hidden" name="user_id" value="{{auth()->check() ? auth()->id() : null}}">
                            <input type="hidden" name="user_name" value="{{auth()->check() ? auth()->user()->name : null}}">
                            <input type="hidden" name="provider_id" value="{{$provider->id}}">
                            <input type="hidden" name="provider_name" value="{{$provider->full_name_ar}}">
                            <input type="hidden" name="sub_total" value="{{$provider->renewal_price}}">
                            <input type="hidden" name="total_before_promo" value="{{$provider->renewal_price}}">
                            <input type="hidden" name="total_after_promo" value="{{$provider->renewal_price}}">

                            <fieldset>
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="form-focused form-group cu-input">
                                            <label for="name">{{Translate('الاسم بالكامل')}}</label>
                                            <input id="name" type="text" name="name" value="{{old('name')}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-focused form-group cu-input">
                                            <label for="tel">{{Translate('رقم الجوال')}} <span style="color: red">({{Translate('يجب ان يبدأ رقم الجوال بـ 05')}})</span></label>
                                            <input id="tel" type="tel" name="phone" value="{{old('phone')}}" class="phone" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-focused form-group cu-input">
                                            <label for="id">{{Translate('رقم الهوية')}} <span style="color: red">({{Translate('يجب ان يبدأ رقم الهوية بالرقم 1 او 2')}})</span></label>
                                            --}}{{--<input id="id" type="number" minlength="10" maxlength="10" name="id_number" class="" required>--}}{{--
                                            <input type="number" name="id_number" value="{{old('id_number')}}" minlength="10" maxlength="10" required>
                                        </div>
                                    </div>
                                    --}}{{--<div class="col-lg-4">
                                        <div class="form-focused form-group cu-input">
                                            <label for="date">{{Translate('تاريخ الميلاد')}}</label>
                                            <input type="text" name="birthdate" value="{{old('birthdate')}}" class="datepicker" required>
                                        </div>
                                    </div>--}}{{--
                                    <div class="col-lg-1">
                                        <div class="form-focused form-group cu-input">
                                            <label for="date">{{Translate('يوم')}}</label>
                                            <select name="day" value="{{old('day')}}" class="form-control" required>
                                                @for($i=1; $i <= 31; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-focused form-group cu-input">
                                            <label for="date">{{Translate('شهر')}}</label>
                                            <select name="month" value="{{old('month')}}" class="form-control" required>
                                                @for($i=1; $i <= 12; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-focused form-group cu-input">
                                            <label for="date">{{Translate('سنة')}}</label>
                                            <select name="year" value="{{old('year')}}" class="form-control" required>
                                                @for($i = $year; $i >= 1900; $i--)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-focused form-group cu-input">
                                            <label for="img">{{Translate('الرخصة')}}</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="img" name="photo" value="{{old('photo')}}"
                                                       accept="image/*">
                                                <label class="custom-file-label" for="img">{{Translate('ارفق صورة الرخصة')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-focused form-group cu-input">
                                            <p>{{Translate('طريقة الحجز')}}</p>
                                            <div class="servicesInput radioInput">
                                                <div class="hold-radio">
                                                    <input type="radio" id="booking_now02" name="booking_method"
                                                           value="now" {{old('booking_method') == 'now' ? 'checked' : ''}} checked>
                                                    <label onclick="$('#booking_later02Div').hide()" for="booking_now02" class="checkmark"></label>
                                                    <label onclick="$('#booking_later02Div').hide()" for="booking_now02">{{Translate('حجز الآن')}}</label>
                                                </div>
                                                <div class="hold-radio">
                                                    <input type="radio" id="booking_later02" name="booking_method"
                                                           value="later" {{old('booking_method') == 'later' ? 'checked' : ''}}>
                                                    <label onclick="$('#booking_later02Div').show()" for="booking_later02" class="checkmark"></label>
                                                    <label onclick="$('#booking_later02Div').show()" for="booking_later02">{{Translate('حجز في وقت لاحق')}}</label>
                                                </div>
                                            </div>

                                            <div class="form-group" id="booking_later02Div" style="display: none">
                                                <label for="date">{{Translate('موعد الحجز')}}</label>
                                                <input type="text" name="booking_later_date" value="{{old('booking_later_date')}}" class="datepicker">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-focused form-group cu-input">
                                            <p>{{Translate('طريقة الدفع')}}</p>
                                            <div class="servicesInput radioInput">
                                                <div class="hold-radio">
                                                    <input type="radio" id="booking_cash02" name="payment_method"
                                                           value="cash" {{old('payment_method') == 'cash' ? 'checked' : ''}} checked>
                                                    <label for="booking_cash02" class="checkmark"></label>
                                                    <label for="booking_cash02">{{Translate('الدفع كاش')}}</label>
                                                </div>
                                                <div class="hold-radio">
                                                    <input type="radio" id="booking_point02" name="payment_method"
                                                           value="point" {{old('payment_method') == 'point' ? 'checked' : ''}}>
                                                    <label for="booking_point02" class="checkmark"></label>
                                                    <label for="booking_point02">{{Translate('نقاط بيع')}}</label>
                                                </div>
                                                <div class="hold-radio">
                                                    <input type="radio" id="booking_online02" name="payment_method"
                                                           value="online" {{old('payment_method') == 'online' ? 'checked' : ''}}>
                                                    <label for="booking_online02" class="checkmark"></label>
                                                    <label for="booking_online02">{{Translate('الدفع اونلاين')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    --}}{{--<div class="col-lg-4">
                                        <div class="form-focused form-group cu-input">
                                            <label for="promo_code">{{Translate('كود الخصم')}} ({{Translate('ان وجد')}})</label>
                                            <input type="text" name="promo_code" value="{{old('promo_code')}}" class="search-input">
                                            --}}{{----}}{{--<button type="button" class="search-button">{{Translate('تطبيق')}}</button>--}}{{----}}{{--
                                        </div>
                                    </div>--}}{{--
                                    <div class="col-12">
                                        <div class="form-btn" style="display: table; margin: 0 auto">
                                            <a href="https://www.google.com/maps/?q={{$provider->lat}},{{$provider->lng}}"
                                               target="_blanck"><i class="fa-solid fa-map"></i> {{Translate('عرض موقع الكشف')}}</a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-btn" style="display: table; margin: 0 auto">
                                            <button type="submit" class="with-arrow main-btn">
                                                <span>{{Translate('ارسل')}}</span>
                                                <i class="fa-solid fa-arrow-left-long"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>--}}
        </div>
    </section>
    <!--  services  -->
@endsection

@section('script')
    <script>
        function toggleForm(formId) {
            var form = document.getElementById(formId);

            // إذا كانت النموذج مخفيًا، قم بإظهاره، وإلغاء إظهار أي نموذج آخر
            if (form.style.display === 'none') {
                // إخفاء جميع النماذج
                var allForms = document.getElementsByClassName("tabcontent");
                for (var i = 0; i < allForms.length; i++) {
                    allForms[i].style.display = 'none';
                }

                // إظهار النموذج المراد
                form.style.display = 'block';

                // إلغاء نشاط جميع زر التبويبات
                var allTabs = document.getElementsByClassName("tablinks");
                for (var i = 0; i < allTabs.length; i++) {
                    allTabs[i].classList.remove("active");
                }

                // جعل الزر النشط
                event.currentTarget.classList.add("active");
            } else {
                // إذا كان النموذج مرئيًا، قم بإخفائه
                form.style.display = 'none';
                event.currentTarget.classList.remove("active");
            }
        }

        // عرض النموذج الأول عند تحميل الصفحة
        // document.getElementById("form1").style.display = "block"; // يمكن إزالة هذا لعدم عرض أي نموذج افتراضيًا

    </script>
    <script>
        function stop_form() {
            //$('.submitSpan').html('<i class="fas fa-spinner fa-spin"></i>');
            //$('.submitBtn').attr('disabled');
        }

        $(document).ready(function() {
            $('#form1').on('submit', function(event) {
                var $submitButton = $('#submitButton1');

                if ($submitButton.data('submitted') === true) {
                    // إذا تم إرسال النموذج بالفعل، نمنع إعادة الإرسال
                    event.preventDefault();
                } else {
                    // وضع علامة بأن النموذج قد تم إرساله
                    $('#submitSpan1').html('<i class="fas fa-spinner fa-spin"></i>');
                    $submitButton.data('submitted', true);
                    $submitButton.prop('disabled', true);
                }
            });

            $('#form2').on('submit', function(event) {
                var $submitButton = $('#submitButton2');

                if ($submitButton.data('submitted') === true) {
                    // إذا تم إرسال النموذج بالفعل، نمنع إعادة الإرسال
                    event.preventDefault();
                } else {
                    // وضع علامة بأن النموذج قد تم إرساله
                    $('#submitSpan2').html('<i class="fas fa-spinner fa-spin"></i>');
                    $submitButton.data('submitted', true);
                    $submitButton.prop('disabled', true);
                }
            });
        });
        /*$(document).ready(function() {
            // Replace 'section2' with the ID of the section you want to scroll to
            var targetSection = $('#services-section');

            // Animate scrolling to the target section
            $('html, body').animate({
                scrollTop: targetSection.offset().top
            }, 1000); // Adjust the duration as needed
        });*/
    </script>
@endsection