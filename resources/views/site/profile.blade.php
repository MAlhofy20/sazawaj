@extends('site.master')
@section('title') حسابي @endsection
@section('style')
    <style>
.page-title {
    position: relative;
    color: #b72dd2; /* Main color */
    font-size: 1.8rem;
    font-weight: bold;
    font-family: 'Tajawal', sans-serif;
    text-align: center;
    display: inline-block;
    padding: 10px 20px;

    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(50, 142, 164, 0.19);
}

/* Icon Styling */
.icon {
    font-size: 1.8rem;
    color: #2492a8; /* Secondary color */
    margin-left: 12px; /* Space for RTL */
}

/* Super Stylish Underline */
.underline {
    width: 100px;
    height: 6px;
    background: linear-gradient(to right, #b72dd2, #2492a8);
    margin: 8px auto 0;
    border-radius: 30px;
    position: relative;
    overflow: hidden;
}

/* ✨ Stylish Animation Effect */
.underline::before {
    content: "";
    position: absolute;
    width: 50%;
    height: 100%;
    background: rgba(255, 255, 255, 0.4);
    left: -50%;
    border-radius: 30px;
    animation: underlineGlow 1.8s infinite ease-in-out;
}

/* Keyframe for a glowing sliding effect */
@keyframes underlineGlow {
    0% {
        left: -50%;
        opacity: 0.6;
    }
    50% {
        left: 50%;
        opacity: 1;
    }
    100% {
        left: 150%;
        opacity: 0.6;
    }
}



        .errorDiv {
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

        .hideDiv {
            display: none;
        }

        .prof-li i {
            display: inline-block;
        }

        .prof-li span {
            width: 85%;
            padding: 15px 0;
            display: inline-block;
        }

        .main-tit {
            position: relative;

        }
        .tab-content-profile-edite .form-group{
            min-height: 100px;

        }
        .tab-content-profile-edite .form-group.gender .in-gender {
            justify-content: space-between;
            display: flex;
            width: 100%;
            position: relative;
            z-index: 99;
        }
        .tab-content-profile-edite .form-group.gender .form-check .form-check-label{

            min-width: 180px;
            margin-inline-end: 10px;
            color: var(--sec) !important;
        }
        .tab-content-profile-edite .form-group.gender  .form-check-input:checked + .form-check-label{
            color: var(--white) !important;
        }

        .tab-content-profile-edite .main-btn.custom_form{
            width: 100%;
            margin-top: 30px;
        }
        .tab-content-profile-edite .form-group #goalsGroup{
            display: flex;
            flex-direction: column;
        }
        .tab-content-profile-edite .form-group #goalsGroup input[type=checkbox]{
            display: inline-block;
            margin-inline-end: 10px;
            height: 15px;
        }
        @media (max-width: 768px) {
            .tab-content-profile-edite .form-group.gender .form-check .form-check-label {
                min-width: 125px;
                margin-inline-end: 10px;
            }
        }
        .alert-container {
          max-width: 500px;
          margin: 0 auto;
          padding: 20px;
          text-align: center;
        }
        .alert-box {
          background-color: #e74c3c;
          color: white;
          padding: 15px 20px;
          border-radius: 5px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 16px;
          font-weight: bold;
          box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
          position: relative;
        }
        .alert-box::before {
          content: "";
          display: inline-block;
          margin-left: 10px;
          width: 40px;
          height: 40px;
          vertical-align: bottom;
          background-image: url("{{site_path()}}/assets/img/icon-page.png");
          background-repeat: no-repeat;
          background-position: 0px -120px;
          position: relative;
        }
        .alert-link {
          color: #f1c40f;
          text-decoration: underline;
          margin-left: 10px;
        }
        .alert-link:hover {
          color: #f39c12;
        }

    </style>
@endsection

@section('content')
    <!--  welcome  -->
    @if(!auth()->check())
        <section class="welcome">
            <div class="welcome-img">
                <img src="{{ site_path() }}/assets/img/welcome.png" alt="">
            </div>
            <p class="welcome-tit">أهلاً بكم في موقع {{ settings('site_name') }}</p>
        </section>
    @endif
    <!--  //welcome  -->

    <!--  login  -->
    <section class="register prof">
        <div class="container">
        @if(auth()->user()->active != '1' && !session()->has('resend_active_email_submitted'))
            <div class="alert-container" style="  max-width: fit-content;">
              <div class="alert-box">
                يجب تأكيد صحة عنوان بريدك الإلكتروني، لاعادة ارسال بريد التفعيل&nbsp;
                <form action="{{route('resend_active_email')}}" method="POST">
                    @csrf

                    <button type="submit" class="bg-light px-2 rounded" style="cursor: pointer;">اضغط هنا</button>
                </form>
              </div>
            </div>
        @elseif(session()->has('success') || session()->has('resend_active_email_submitted'))
            <div class="alert-container" style="  max-width: fit-content;">
              <div class="alert-box bg-info">
                برجاء قم بمراجعة بريدك الالكتروني {{ auth()->user()->email }} واضغط على زر التفعيل
              </div>
            </div>
        @endif

<div class="d-flex justify-content-center my-4">
    <div class="page-title">
        <i class="fas fa-user-edit icon"></i>
        <span class="title-text">حسابي</span>
        <div class="underline"></div>
    </div>
</div>




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

            <style>
                .tab ul {
                    list-style: none;
                    padding: 0;
                }

                .tab li {
                    background-color: #f4f4f4;
                    padding: 10px;
                    margin: 5px 0;
                    cursor: pointer;
                    border-radius: 5px;
                    transition: background-color 0.3s ease;
                }

                .tab li:hover {
                    background-color: #e0e0e0;
                }

                .tab-content {
                    display: none;
                    padding: 10px;
                    background-color: white !important;
                    color: black !important;
                    margin: 5px 0;
                }

                .tab-content.active {
                    display: block;
                }

            </style>
            <div class="tab">
                <div class="row">

                    {{--     انا عدلت ال if لو فيها حاجه غلط معلش ظبطها --}}
                    @if(auth()->user()->gender == 'male')
                        <div class="{{ checkUserPackage() ? 'checkUserPackag' : 'notcheckUserPackag' }} col-lg-6">
                            <a href="{{checkUserPackage() ? url('package_info') : url('all_packages')}}" class="gold-prof prof-gold">
                                <span class="toggle-text" onclick="toggleCollapse(this)">
                                    {{auth()->user()->package_id != null ? 'تفاصيل العضوية' : 'ترقيه العضوية'}}
                                </span>
                            </a>
                        </div>
                    @endif

                    <div class="col-lg-6">
                        <a href="{{url('show_client/' . auth()->id())}}" class="gold-prof prof-prof">
                            <span class="toggle-text" onclick="toggleCollapse(this)">صفحتي الشخصية</span>
                        </a>
                    </div>


                    <div class="col-lg-6">
                        <li class="prof-li prof-mail">
                             <span id="emailSpanUpdate" class="toggle-text" style="margin-inline-start: 10px"
                                   onclick="toggleCollapse(this)">تعديل البريد الالكتروني</span>

                            <div class="tab-content">
                                <form action="{{ route('site_post_update_email') }}" id="formEmail" method="POST" autocomplete="off"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="email" class="hideDiv">تعديل البريد الإلكتروني</label>
                                                <input type="text" class="form-control" disabled=""
                                                       value="{{auth()->user()->email}}"
                                                       placeholder="أدخل البريد الإلكتروني الجديد" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="email" >أدخل البريد الإلكتروني الجديد</label>
                                                <input type="email" class="form-control" id="emailEmail" name="email"

                                                       placeholder="أدخل البريد الإلكتروني الجديد" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="password" >أدخل كلمة المرور</label>
                                                <input type="password" class="form-control" id="emailPassword" name="password"
                                                       value="" autocomplete="off"
                                                       placeholder="أدخل كلمة المرور" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <button type="submit" class="main-btn2 custom_form saveEmail" onclick="update_email()">حفظ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </div>
                    <div class="col-lg-6">
                        <li class="prof-li prof-acc">
                             <span id="profileSpanUpdate" class="toggle-text" onclick="toggleCollapse(this);"
                                   style="margin-inline-start: 10px">معلومات الحساب</span>

                            <div class="tab-content tab-content-profile-edite">
                                <form action="{{ route('site_post_profile') }}" id="formRegister" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="username">الاسم</label>
                                                <input type="text" class="form-control" id="first_name"
                                                       name="first_name" value="{{auth()->user()->first_name}}"
                                                       placeholder="الاسم" required>
                                            </div>
                                            <div class="form-group">
                                                <label>العمر:</label>
                                                <select class="form-control" name="age">
                                                    <option value="">اختر</option>
                                                    <option value="22 - 18" {{auth()->user()->age == '22 - 18' ? 'selected' : ''}}>
                                                        22 - 18
                                                    </option>
                                                    <option value="27 - 23" {{auth()->user()->age == '27 - 23' ? 'selected' : ''}}>
                                                        27 - 23
                                                    </option>
                                                    <option value="32 - 28" {{auth()->user()->age == '32 - 28' ? 'selected' : ''}}>
                                                        32 - 28
                                                    </option>
                                                    <option value="37 - 33" {{auth()->user()->age == '37 - 33' ? 'selected' : ''}}>
                                                        37 - 33
                                                    </option>
                                                    <option value="42 - 38" {{auth()->user()->age == '42 - 38' ? 'selected' : ''}}>
                                                        42 - 38
                                                    </option>
                                                    <option value="47 - 43" {{auth()->user()->age == '47 - 43' ? 'selected' : ''}}>
                                                        47 - 43
                                                    </option>
                                                    <option value="52 - 48" {{auth()->user()->age == '52 - 48' ? 'selected' : ''}}>
                                                        52 - 48
                                                    </option>
                                                    <option value="53+" {{auth()->user()->age == '53+' ? 'checked' : ''}}>
                                                        53+
                                                    </option>
                                                {{--@for($age = 10; $age <= 100; $age++)
                                                    <option value="{{$age}}">{{$age}}</option>
                                                @endfor--}}
                                                <!-- المزيد من الأعمار -->
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="job">المهنة</label>
                                                <select class="form-control" id="job" name="job" required>
                                                    <option value="">اختر</option>
                                                    @foreach(App\Models\Media_file::where('type', 'jobs')->orderBy('id')->get() as $item)
                                                        <option value="{{$item->title_ar}}" {{auth()->user()->job == $item->title_ar ? 'selected' : ''}}>{{$item->title_ar}}</option>
                                                    @endforeach

                                                </select>



                                            </div>
                                            <div class="form-group">
                                                <label for="eye_color">لون العين</label>
                                                <select class="form-control" name="eye_color" required>
                                                    <option value="">اختر</option>
                                                    <option value="أسود" {{auth()->user()->eye_color == 'أسود' ? 'selected' : ''}}>
                                                        أسود
                                                    </option>
                                                    <option value="بني" {{auth()->user()->eye_color == 'بني' ? 'selected' : ''}}>
                                                        بني
                                                    </option>
                                                    <option value="عسلي" {{auth()->user()->eye_color == 'عسلي' ? 'selected' : ''}}>
                                                        عسلي
                                                    </option>
                                                    <option value="أزرق" {{auth()->user()->eye_color == 'أزرق' ? 'selected' : ''}}>
                                                        أزرق
                                                    </option>
                                                    <option value="اخضر" {{auth()->user()->eye_color == 'اخضر' ? 'selected' : ''}}>
                                                        اخضر
                                                    </option>
                                                    <option value="رمادي" {{auth()->user()->eye_color == 'رمادي' ? 'selected' : ''}}>
                                                        رمادي
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="hair_color">لون الشعر</label>
                                                <select class="form-control" name="hair_color" required>
                                                    <option value="">اختر</option>
                                                    <option value="أسود" {{auth()->user()->hair_color == 'أسود' ? 'selected' : ''}}>
                                                        أسود
                                                    </option>
                                                    <option value="بني" {{auth()->user()->hair_color == 'بني' ? 'selected' : ''}}>
                                                        بني
                                                    </option>
                                                    <option value="اشقر" {{auth()->user()->hair_color == 'اشقر' ? 'selected' : ''}}>
                                                        اشقر
                                                    </option>
                                                    <option value="احمر" {{auth()->user()->hair_color == 'احمر' ? 'selected' : ''}}>
                                                        احمر
                                                    </option>
                                                    <option value="رمادي" {{auth()->user()->hair_color == 'رمادي' ? 'selected' : ''}}>
                                                        رمادي
                                                    </option>
                                                    <option value="ابيض" {{auth()->user()->hair_color == 'ابيض' ? 'selected' : ''}}>
                                                        ابيض
                                                    </option>
                                                    <option value="اصلع" {{auth()->user()->hair_color == 'اصلع' ? 'selected' : ''}}>
                                                        اصلع
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="skin_color">لون البشرة</label>
                                                <select class="form-control" name="skin_color" required>
                                                    <option value="">اختر</option>
                                                    <option value="ابيض" {{auth()->user()->skin_color == 'ابيض' ? 'selected' : ''}}>
                                                        ابيض
                                                    </option>
                                                    <option value="يميل الى البياض" {{auth()->user()->skin_color == 'يميل الى البياض' ? 'selected' : ''}}>
                                                        يميل الى البياض
                                                    </option>
                                                    <option value="أسود" {{auth()->user()->skin_color == 'أسود' ? 'selected' : ''}}>
                                                        أسود
                                                    </option>
                                                    <option value="يميل الى السواد" {{auth()->user()->skin_color == 'يميل الى السواد' ? 'selected' : ''}}>
                                                        يميل الى السواد
                                                    </option>
                                                    <option value="أسمر" {{auth()->user()->skin_color == 'أسمر' ? 'selected' : ''}}>
                                                        أسمر
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="height">الطول</label>
                                                <select class="form-control" name="height" required>
                                                    <option value="">اختر</option>
                                                    <option value="قصير" {{auth()->user()->height == 'قصير' ? 'selected' : ''}}>
                                                        قصير
                                                    </option>
                                                    <option value="متوسط" {{auth()->user()->height == 'متوسط' ? 'selected' : ''}}>
                                                        متوسط
                                                    </option>
                                                    <option value="طويل" {{auth()->user()->height == 'طويل' ? 'selected' : ''}}>
                                                        طويل
                                                    </option>
                                                {{--@for($height = 100; $height <= 200; $height++)
                                                    <option value="{{$height}}">{{$height}}</option>
                                                @endfor--}}
                                                <!-- المزيد من الأطوال -->
                                                </select>
                                            </div>
                                            <div class="form-group gender" style="display:none;">
                                                <label>حدد النوع</label>
                                                <div class=" in-gender">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="male"
                                                               name="gender"
                                                               value="male"
                                                               {{auth()->user()->gender == 'male' ? 'checked' : ''}} required>
                                                        <label class="form-check-label" for="male">
                                                            <img src="{{ site_path() }}/assets/img/mael.png" alt="">
                                                            انا ذكر
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="female"
                                                               name="gender"
                                                               value="female"
                                                               {{auth()->user()->gender == 'female' ? 'checked' : ''}} required>
                                                        <label class="form-check-label" for="female">
                                                            <img src="{{ site_path() }}/assets/img/female.png" alt="">
                                                            انا انثى
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<div class="form-group">
                                                <label for="password">كلمة المرور</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                       placeholder="أدخل كلمة المرور" required>
                                            </div>--}}
                                        </div>
                                        <!-- Second Column -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>الهدف من الموقع:</label>
                                                <div class="checkbox-group" id="goalsGroup">
                                                    @foreach(App\Models\Media_file::where('type', 'goals')->orderBy('title_ar')->get() as $item)
                                                        <label>
                                                            <input type="checkbox" name="goals[]"
                                                                   value="{{$item->title}}"
                                                                    {{in_array($item->title_ar, explode(',', auth()->user()->goals)) ? 'checked' : ''}}>{{$item->title}}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nationality">المدينة</label>
                                                <select class="form-control" id="city" name="city_id">
                                                    <option value="">اختر</option>
                                                    @foreach(App\Models\City::get() as $item)
                                                        <option value="{{$item->id}}" {{auth()->user()->city_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nationality">الجنسية</label>
                                                <select class="form-control" id="nationality" name="nationality"
                                                        required>
                                                    <option value="" disabled selected>اختر الجنسية</option>
                                                    @foreach(App\Models\Media_file::where('type', 'nationality')->get() as $item)
                                                        <option value="{{$item->title_ar}}" {{auth()->user()->nationality == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="levels">المؤهل الدراسي</label>
                                                <select class="form-control" id="level" name="level" required>
                                                    <option value="" disabled selected>اختر المؤهل الدراسي</option>
                                                    @foreach(App\Models\Media_file::where('type', 'levels')->orderBy('id')->get() as $item)
                                                        <option value="{{$item->title_ar}}" {{auth()->user()->level == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="levels">الحالة الاجتماعية</label>
                                                <select class="form-control" id="social_level" name="social_level"
                                                        required>
                                                    <option value="" disabled selected>اختر الحالة الاجتماعية</option>
                                                    @foreach(App\Models\Media_file::where('type', 'social_levels')->orderBy('title_ar')->get() as $item)
                                                        <option value="{{$item->title_ar}}" {{auth()->user()->social_level == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="levels">لديك ابناء</label>
                                                <select class="form-control" id="has_sons" name="has_sons" required>
                                                    <option value="0" {{auth()->user()->has_sons == '0' ? 'selected' : ''}}>
                                                        لا
                                                    </option>
                                                    <option value="1" {{auth()->user()->has_sons == '1' ? 'selected' : ''}}>
                                                        نعم
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="width">الوزن</label>
                                                <select class="form-control" name="width" required>
                                                    <option value="">اختر</option>
                                                    <option value="ضعيف" {{auth()->user()->width == 'ضعيف' ? 'selected' : ''}}>
                                                        ضعيف
                                                    </option>
                                                    <option value="عادي" {{auth()->user()->width == 'عادي' ? 'selected' : ''}}>
                                                        عادي
                                                    </option>
                                                    <option value="سمين" {{auth()->user()->width == 'سمين' ? 'selected' : ''}}>
                                                        سمين
                                                    </option>
                                                {{--@for($height = 100; $height <= 200; $height++)
                                                    <option value="{{$height}}">{{$height}}</option>
                                                @endfor--}}
                                                <!-- المزيد من الأطوال -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-center" style="margin-top: 10px">
                                            <button type="submit" class="main-btn2 custom_form">حفظ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </div>

                    <div class="col-lg-6">
                        <li class="prof-li prof-mod">

                            <span id="passwordSpanUpdate" onclick="toggleCollapse(this);" class="toggle-text"
                                  style="margin-inline-start: 10px">تعديل كلمة السر</span>

                            <div class="tab-content">
                                <form action="{{ route('site_post_update_password') }}" id="formPassword" method="POST" autocomplete="off"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="old_password" class="hideDiv">كلمة المرور القديمة</label>
                                                <input autocomplete="off" type="password" class="form-control" id="old_password" name="old_password"
                                                       value=""
                                                       placeholder="أدخل كلمة المرور القديمة" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="password" class="hideDiv">كلمة المرور الجديدة</label>
                                                <input autocomplete="off" type="password" class="form-control" id="emailPassword" name="password"
                                                       value=""
                                                       placeholder="أدخل كلمة المرور الجديدة" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="password_confirmation" class="hideDiv">تأكيد كلمة المرور الجديدة</label>
                                                <input autocomplete="off" type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                                       value=""
                                                       placeholder="أدخل تأكيد كلمة المرور الجديدة" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <button type="submit" class="main-btn2 custom_form savePassword" onclick="update_password()">حفظ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                    </div>
                    <div class="col-lg-6">
                        <li class="prof-li prof-des">

                            <span id="descSpanUpdate" onclick="toggleCollapse(this);" class="toggle-text"
                                  style="margin-inline-start: 10px">تعديل الوصف</span>

                            <div class="tab-content">
                                <form action="{{ route('site_post_profile') }}" id="formRegister" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="desc_ar">تحدث عن نفسك</label>
                                                <textarea class="form-control" id="desc_ar" name="desc_ar" rows="6"
                                                          required>{{auth()->user()->desc_ar}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="goal_desc_ar">صف الشخص الذي تبحث عنه</label>
                                                <textarea class="form-control" id="goal_desc_ar" name="goal_desc_ar"
                                                          rows="6" required>{{auth()->user()->goal_desc_ar}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <button type="submit" class="main-btn2 custom_form">حفظ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                    </div>
                    <div class="col-lg-6">
                        <li class="prof-li prof-down">

                            <span id="avatarSpanUpdate" onclick="toggleCollapse(this);" class="toggle-text"
                                  style="margin-inline-start: 10px">تحميل وتغير الصورة</span>

                          <div class="tab-content">

                    <!-- إشعار مراجعة الصورة -->
                    @if(!empty(auth()->user()->avatar_edit))
                        <p class="text-danger text-center mt-3">
                            الصورة قيد المراجعة وسيتم نشرها بعد موافقة الإدارة
                        </p>
                    @else
                    <form action="{{ route('site_post_profile') }}" id="formRegister" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- رفع الصورة الشخصية -->
                            <div class="col-lg-6 text-center">
                                <label for="photo" class="font-weight-bold mb-2">الصورة الشخصية</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="photo" name="photo" onchange="updateFileLabel(event); previewImage(event)">
                                    <label class="custom-file-label" for="photo" id="fileLabel">تحميل</label>
                                </div>
                                <div class="mt-3">
                                <img id="imagePreview"
                    src="{{ auth()->user()->avatar ?? 'https://via.placeholder.com/200' }}"
                    class="img-thumbnail rounded shadow-sm"
                    alt="صورة المعاينة"
                    style="width: 200px; height: 200px; max-width: 100%; max-height: 200px; object-fit: contain; border: 2px solid #ddd; padding: 5px;">
                                </div>
                            </div>

                            <!-- زر الحفظ -->
                            <div class="col-lg-6 text-center d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn main-btn2 btn-lg px-5 shadow-sm">حفظ</button>
                            </div>
                        </div>
                    </form>

                    @endif
</div>


                        </li>
                    </div>


                    <div class="col-lg-6">
                        <a href="{{url('all_blocked_clients')}}" class="gold-prof prof-prof">
                            <span class="toggle-text" onclick="toggleCollapse(this)">قائمة التجاهل</span>
                        </a>
                    </div>
                </div>

                <ul>
                    {{--<li class="prof-li" >
                        <img src="{{ site_path() }}/assets/img/ring.png" alt="">
                         <span class="toggle-text" onclick="toggleCollapse(this)">ترقيه العضوية</span>

                        <div class="tab-content">
                            <form action="{{ route('site_post_profile') }}" id="formRegister" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-1">
                                        <div class="client-img">
                                            <img src="{{ url('' . auth()->user()->avatar) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-11">
                                        <div class="form-group">
                                            <label for="username">الصورة الشخصية</label>
                                            <input type="file" class="form-control" id="photo" name="photo">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="username">اسم المستخدم</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{auth()->user()->first_name}}"
                                                   placeholder="أدخل اسم المستخدم" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">البريد الالكتروني</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{auth()->user()->email}}"
                                                   placeholder="أدخل البريد الالكتروني" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="age">حدد العمر</label>
                                            <input type="number" class="form-control" id="age" name="age" value="{{auth()->user()->age}}" placeholder="أدخل عمرك"
                                                   required max="100" min="1">
                                        </div>
                                        <div class="form-group">
                                            <label for="job">المهنة</label>
                                            <input type="text" class="form-control" id="job" name="job" value="{{auth()->user()->job}}" placeholder="أدخل الوظيفة"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="eye_color">لون العين</label>
                                            <input type="text" class="form-control" id="eye_color" name="eye_color" value="{{auth()->user()->eye_color}}" placeholder="أدخل لون العين"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="hair_color">لون الشعر</label>
                                            <input type="text" class="form-control" id="hair_color" name="hair_color" value="{{auth()->user()->hair_color}}" placeholder="أدخل لون الشعر"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="skin_color">لون البشرة</label>
                                            <input type="text" class="form-control" id="skin_color" name="skin_color" value="{{auth()->user()->skin_color}}" placeholder="أدخل لون البشرة"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="height">الطول</label>
                                            <input type="text" class="form-control" id="height" name="height" value="{{auth()->user()->height}}" placeholder="أدخل الطول"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="width">الوزن</label>
                                            <input type="text" class="form-control" id="width" name="width" value="{{auth()->user()->width}}" placeholder="أدخل الوزن"
                                                   required>
                                        </div>
                                        <div class="form-group gender">
                                            <label>حدد النوع</label>
                                            <div class="d-flex align-items-center in-gender">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="male" name="gender"
                                                           value="male" {{auth()->user()->gender == 'male' ? 'checked' : ''}} required>
                                                    <label class="form-check-label" for="male">
                                                        <img src="{{ site_path() }}/assets/img/mael.png" alt="">
                                                        انا ذكر
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="female" name="gender"
                                                           value="female" {{auth()->user()->gender == 'female' ? 'checked' : ''}} required>
                                                    <label class="form-check-label" for="female">
                                                        <img src="{{ site_path() }}/assets/img/female.png" alt="">
                                                        انا انثى
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        --}}{{--<div class="form-group">
                                            <label for="password">كلمة المرور</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   placeholder="أدخل كلمة المرور" required>
                                        </div>--}}{{--
                                    </div>
                                    <!-- Second Column -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="goal">اختر الهدف من التسجيل</label>
                                            <select class="form-control" id="goal" name="goal_id" required>
                                                <option value="" disabled selected>اختر الهدف</option>
                                                @foreach(App\Models\Media_file::where('type', 'goals')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->id}}" {{auth()->user()->goal_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="city">اختر المدينة</label>
                                            <select class="form-control" id="city" name="city_id" required>
                                                <option value="" disabled selected>اختر المدينة</option>
                                                @foreach(App\Models\City::orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->id}}" {{auth()->user()->city_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nationality">الجنسية</label>
                                            <select class="form-control" id="nationality" name="nationality" required>
                                                <option value="" disabled selected>اختر الجنسية</option>
                                                @foreach(App\Models\Media_file::where('type', 'nationality')->orderBy('id')->get() as $item)
                                                    <option value="{{$item->title_ar}}" {{auth()->user()->nationality == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">المؤهل الدراسي</label>
                                            <select class="form-control" id="level" name="level" required>
                                                <option value="" disabled selected>اختر المؤهل الدراسي</option>
                                                @foreach(App\Models\Media_file::where('type', 'levels')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->title_ar}}" {{auth()->user()->level == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">الحالة الاجتماعية</label>
                                            <select class="form-control" id="social_level" name="social_level" required>
                                                <option value="" disabled selected>اختر الحالة الاجتماعية</option>
                                                @foreach(App\Models\Media_file::where('type', 'social_levels')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->title_ar}}" {{auth()->user()->social_level == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">لديك ابناء</label>
                                            <select class="form-control" id="has_sons" name="has_sons" required>
                                                <option value="0" {{auth()->user()->has_sons == '0' ? 'selected' : ''}}>لا</option>
                                                <option value="1" {{auth()->user()->has_sons == '1' ? 'selected' : ''}}>نعم</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">تحدث عن نفسك</label>
                                            <textarea class="form-control" id="desc_ar" name="desc_ar" rows="6" required>{{auth()->user()->desc_ar}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">صف الشخص الذي تبحث عنه</label>
                                            <textarea class="form-control" id="goal_desc_ar" name="goal_desc_ar" rows="6" required>{{auth()->user()->goal_desc_ar}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="main-btn custom_form">حفظ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>--}}





                    {{--<li class="prof-li">
                        <img src="{{ site_path() }}/assets/img/ring.png" alt="">

                        <span class="toggle-text" onclick="toggleCollapse(this)">تعديل البيانات</span>

                        <div class="tab-content">
                            <form action="{{ route('site_post_profile') }}" id="formRegister" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-1">
                                        <div class="client-img">
                                            <img src="{{ url('' . auth()->user()->avatar) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-11">
                                        <div class="form-group">
                                            <label for="username">الصورة الشخصية</label>
                                            <input type="file" class="form-control" id="photo" name="photo">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="username">اسم المستخدم</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{auth()->user()->first_name}}"
                                                   placeholder="أدخل اسم المستخدم" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">البريد الالكتروني</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{auth()->user()->email}}"
                                                   placeholder="أدخل البريد الالكتروني" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="age">حدد العمر</label>
                                            <input type="number" class="form-control" id="age" name="age" value="{{auth()->user()->age}}" placeholder="أدخل عمرك"
                                                   required max="100" min="1">
                                        </div>
                                        <div class="form-group">
                                            <label for="job">المهنة</label>
                                            <input type="text" class="form-control" id="job" name="job" value="{{auth()->user()->job}}" placeholder="أدخل الوظيفة"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="eye_color">لون العين</label>
                                            <input type="text" class="form-control" id="eye_color" name="eye_color" value="{{auth()->user()->eye_color}}" placeholder="أدخل لون العين"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="hair_color">لون الشعر</label>
                                            <input type="text" class="form-control" id="hair_color" name="hair_color" value="{{auth()->user()->hair_color}}" placeholder="أدخل لون الشعر"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="skin_color">لون البشرة</label>
                                            <input type="text" class="form-control" id="skin_color" name="skin_color" value="{{auth()->user()->skin_color}}" placeholder="أدخل لون البشرة"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="height">الطول</label>
                                            <input type="text" class="form-control" id="height" name="height" value="{{auth()->user()->height}}" placeholder="أدخل الطول"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="width">الوزن</label>
                                            <input type="text" class="form-control" id="width" name="width" value="{{auth()->user()->width}}" placeholder="أدخل الوزن"
                                                   required>
                                        </div>
                                        <div class="form-group gender">
                                            <label>حدد النوع</label>
                                            <div class="d-flex align-items-center in-gender">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="male" name="gender"
                                                           value="male" {{auth()->user()->gender == 'male' ? 'checked' : ''}} required>
                                                    <label class="form-check-label" for="male">
                                                        <img src="{{ site_path() }}/assets/img/mael.png" alt="">
                                                        انا ذكر
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="female" name="gender"
                                                           value="female" {{auth()->user()->gender == 'female' ? 'checked' : ''}} required>
                                                    <label class="form-check-label" for="female">
                                                        <img src="{{ site_path() }}/assets/img/female.png" alt="">
                                                        انا انثى
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        --}}{{--<div class="form-group">
                                            <label for="password">كلمة المرور</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   placeholder="أدخل كلمة المرور" required>
                                        </div>--}}{{--
                                    </div>
                                    <!-- Second Column -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="goal">اختر الهدف من التسجيل</label>
                                            <select class="form-control" id="goal" name="goal_id" required>
                                                <option value="" disabled selected>اختر الهدف</option>
                                                @foreach(App\Models\Media_file::where('type', 'goals')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->id}}" {{auth()->user()->goal_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="city">اختر المدينة</label>
                                            <select class="form-control" id="city" name="city_id" required>
                                                <option value="" disabled selected>اختر المدينة</option>
                                                @foreach(App\Models\City::orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->id}}" {{auth()->user()->city_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nationality">الجنسية</label>
                                            <select class="form-control" id="nationality" name="nationality" required>
                                                <option value="" disabled selected>اختر الجنسية</option>
                                                @foreach(App\Models\Media_file::where('type', 'nationality'))->get() as $item)
                                                    <option value="{{$item->title_ar}}" {{auth()->user()->nationality == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">المؤهل الدراسي</label>
                                            <select class="form-control" id="level" name="level" required>
                                                <option value="" disabled selected>اختر المؤهل الدراسي</option>
                                                @foreach(App\Models\Media_file::where('type', 'levels')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->title_ar}}" {{auth()->user()->level == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">الحالة الاجتماعية</label>
                                            <select class="form-control" id="social_level" name="social_level" required>
                                                <option value="" disabled selected>اختر الحالة الاجتماعية</option>
                                                @foreach(App\Models\Media_file::where('type', 'social_levels')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->title_ar}}" {{auth()->user()->social_level == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">لديك ابناء</label>
                                            <select class="form-control" id="has_sons" name="has_sons" required>
                                                <option value="0" {{auth()->user()->has_sons == '0' ? 'selected' : ''}}>لا</option>
                                                <option value="1" {{auth()->user()->has_sons == '1' ? 'selected' : ''}}>نعم</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">تحدث عن نفسك</label>
                                            <textarea class="form-control" id="desc_ar" name="desc_ar" rows="6" required>{{auth()->user()->desc_ar}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">صف الشخص الذي تبحث عنه</label>
                                            <textarea class="form-control" id="goal_desc_ar" name="goal_desc_ar" rows="6" required>{{auth()->user()->goal_desc_ar}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="main-btn custom_form">حفظ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>--}}


                    {{--<li class="prof-li">
                        <img src="{{ site_path() }}/assets/img/ring.png" alt="">

                        <span class="toggle-text" onclick="toggleCollapse(this)">اختيار التنبيهات</span>

                        <div class="tab-content">
                            <form action="{{ route('site_post_profile') }}" id="formRegister" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-1">
                                        <div class="client-img">
                                            <img src="{{ url('' . auth()->user()->avatar) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-11">
                                        <div class="form-group">
                                            <label for="username">الصورة الشخصية</label>
                                            <input type="file" class="form-control" id="photo" name="photo">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="username">اسم المستخدم</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{auth()->user()->first_name}}"
                                                   placeholder="أدخل اسم المستخدم" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">البريد الالكتروني</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{auth()->user()->email}}"
                                                   placeholder="أدخل البريد الالكتروني" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="age">حدد العمر</label>
                                            <input type="number" class="form-control" id="age" name="age" value="{{auth()->user()->age}}" placeholder="أدخل عمرك"
                                                   required max="100" min="1">
                                        </div>
                                        <div class="form-group">
                                            <label for="job">المهنة</label>
                                            <input type="text" class="form-control" id="job" name="job" value="{{auth()->user()->job}}" placeholder="أدخل الوظيفة"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="eye_color">لون العين</label>
                                            <input type="text" class="form-control" id="eye_color" name="eye_color" value="{{auth()->user()->eye_color}}" placeholder="أدخل لون العين"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="hair_color">لون الشعر</label>
                                            <input type="text" class="form-control" id="hair_color" name="hair_color" value="{{auth()->user()->hair_color}}" placeholder="أدخل لون الشعر"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="skin_color">لون البشرة</label>
                                            <input type="text" class="form-control" id="skin_color" name="skin_color" value="{{auth()->user()->skin_color}}" placeholder="أدخل لون البشرة"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="height">الطول</label>
                                            <input type="text" class="form-control" id="height" name="height" value="{{auth()->user()->height}}" placeholder="أدخل الطول"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="width">الوزن</label>
                                            <input type="text" class="form-control" id="width" name="width" value="{{auth()->user()->width}}" placeholder="أدخل الوزن"
                                                   required>
                                        </div>
                                        <div class="form-group gender">
                                            <label>حدد النوع</label>
                                            <div class="d-flex align-items-center in-gender">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="male" name="gender"
                                                           value="male" {{auth()->user()->gender == 'male' ? 'checked' : ''}} required>
                                                    <label class="form-check-label" for="male">
                                                        <img src="{{ site_path() }}/assets/img/mael.png" alt="">
                                                        انا ذكر
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="female" name="gender"
                                                           value="female" {{auth()->user()->gender == 'female' ? 'checked' : ''}} required>
                                                    <label class="form-check-label" for="female">
                                                        <img src="{{ site_path() }}/assets/img/female.png" alt="">
                                                        انا انثى
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        --}}{{--<div class="form-group">
                                            <label for="password">كلمة المرور</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   placeholder="أدخل كلمة المرور" required>
                                        </div>--}}{{--
                                    </div>
                                    <!-- Second Column -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="goal">اختر الهدف من التسجيل</label>
                                            <select class="form-control" id="goal" name="goal_id" required>
                                                <option value="" disabled selected>اختر الهدف</option>
                                                @foreach(App\Models\Media_file::where('type', 'goals')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->id}}" {{auth()->user()->goal_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="city">اختر المدينة</label>
                                            <select class="form-control" id="city" name="city_id" required>
                                                <option value="" disabled selected>اختر المدينة</option>
                                                @foreach(App\Models\City::orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->id}}" {{auth()->user()->city_id == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nationality">الجنسية</label>
                                            <select class="form-control" id="nationality" name="nationality" required>
                                                <option value="" disabled selected>اختر الجنسية</option>
                                                @foreach(App\Models\Media_file::where('type', 'nationality')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->title_ar}}" {{auth()->user()->nationality == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">المؤهل الدراسي</label>
                                            <select class="form-control" id="level" name="level" required>
                                                <option value="" disabled selected>اختر المؤهل الدراسي</option>
                                                @foreach(App\Models\Media_file::where('type', 'levels')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->title_ar}}" {{auth()->user()->level == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">الحالة الاجتماعية</label>
                                            <select class="form-control" id="social_level" name="social_level" required>
                                                <option value="" disabled selected>اختر الحالة الاجتماعية</option>
                                                @foreach(App\Models\Media_file::where('type', 'social_levels')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->title_ar}}" {{auth()->user()->social_level == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">لديك ابناء</label>
                                            <select class="form-control" id="has_sons" name="has_sons" required>
                                                <option value="0" {{auth()->user()->has_sons == '0' ? 'selected' : ''}}>لا</option>
                                                <option value="1" {{auth()->user()->has_sons == '1' ? 'selected' : ''}}>نعم</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">تحدث عن نفسك</label>
                                            <textarea class="form-control" id="desc_ar" name="desc_ar" rows="6" required>{{auth()->user()->desc_ar}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="levels">صف الشخص الذي تبحث عنه</label>
                                            <textarea class="form-control" id="goal_desc_ar" name="goal_desc_ar" rows="6" required>{{auth()->user()->goal_desc_ar}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="main-btn custom_form">حفظ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>--}}


                </ul>
            </div>

            <!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                function toggleCollapse(element) {
                    const content = element.closest('.prof-li').querySelector('.tab-content');
                    const isActive = content.classList.contains('active');

                    // Close all other contents
                    const allContents = document.querySelectorAll('.tab-content');
                    allContents.forEach(item => {
                        item.classList.remove('active');
                    });

                    // Toggle current content
                    if (!isActive) {
                        content.classList.add('active');
                    }
                }

function update_email() {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: '{{ route('site_post_update_email') }}',
        datatype: 'json',
        async: false,
        processData: false,
        contentType: false,
        data: new FormData($("#formEmail")[0]),
        success: function(msg) {
            if (msg.value == '0') {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ!',
                    text: msg.msg,
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#d33'
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'تم التحديث!',
                    text: 'تم تحديث البريد الإلكتروني بنجاح',
                    confirmButtonText: 'موافق',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    location.reload(); // Reloads the page after clicking "موافق"
                });
            }
        }
    });
}




               function update_password() {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: '{{ route('site_post_update_password') }}',
        datatype: 'json',
        async: false,
        processData: false,
        contentType: false,
        data: new FormData($("#formPassword")[0]),
        success: function(msg) {
            if (msg.value == '0') {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ!',
                    text: msg.msg,
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#d33'
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'تم التحديث!',
                    text: 'تم تحديث كلمة المرور بنجاح',
                    confirmButtonText: 'موافق',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    location.reload(); // Reloads the page after clicking "موافق"
                });
            }
        }
    });
}


            </script>


        </div>
    </section>


    <!-- //login -->
@endsection

@section('script')

<!-- سكريبت لمعاينة الصورة -->
<script>
    function updateFileLabel(event) {
        var fileName = event.target.files[0] ? event.target.files[0].name : "تحميل";
        document.getElementById('fileLabel').textContent = fileName;
    }

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
