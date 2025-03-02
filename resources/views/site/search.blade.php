@extends('site.master')
@section('title') البحث @endsection
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

@keyframes underlineGlow {
    0% { left: -50%; opacity: 0.6; }
    50% { left: 50%; opacity: 1; }
    100% { left: 150%; opacity: 0.6; }
}

    @media (min-width: 992px) {
    .quickSearch .form-check-label {
        min-width: 175px;
        margin-inline-start: 5px;
    }
}

  @media (min-width: 600px) {
    .quickSearch .form-check-label {
        min-width: 100px;
        margin-inline-start: 5px;
    }
}
  
    
    
</style>
@endsection

@section('content')
    <section class="register quickSearch" id="search">
        <div class="container">
            <div class="in_quickSearch">
<div class="d-flex justify-content-center my-4">
    <div class="page-title">
        <i class="fas fa-search icon"></i>
        <span class="title-text">البحث</span>
        <div class="underline"></div>
    </div>
</div>

                <form action="{{url('all_clients')}}" method="get">
                    @csrf
                    <div class="row">
                        <!-- First Column -->
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-head">
                                    <div class="buttons rounded-btn  mb-3" onclick="event.preventDefault();">
                                        
                                        <button class="search-head-collapse mb-3"">
                                            <h2 class="h2 mb-2 font-weight-bold" style="color:#fff;">
                                                 الأساسية
                                            </h2>

                                        </button>
                                    </div>
                                </div>


                                <div class="card-body">
                                    <div class="form-group gender">
                                        <div class="labelform-content">
                                            <label class="labelform">حدد النوع</label>
                                            <div class="d-flex align-items-center in-gender">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="male" name="gender"
                                                           value="male">
                                                    <label class="form-check-label" for="male">
                                                        <img src="{{ site_path() }}/assets/img/mael.png" alt="">
                                                        ذكر
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="female"
                                                           name="gender"
                                                           value="female">
                                                    <label class="form-check-label" for="female">
                                                        <img src="{{ site_path() }}/assets/img/female.png" alt="">
                                                        انثى
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label class="labelform">التواجد</label>
                                        <label >
                                            <input type="checkbox" name="login" id="login" value="1" style="display: inline-block !important; margin-inline-end: 20px">
                                           <space style="color:#2492a8"> المتواجدون الآن فى الموقع
                                         </space>
                                        </label>
                                </div>







                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="logout_at">اخر تواجد</label>
                                            <select class="form-control" id="logout_at" name="logout_at">
                                                <option value="" selected>اختر</option>
                                                <option value="0">اليوم</option>
                                                <option value="1">امس</option>
                                                <option value="7">منذ اسبوع</option>
                                                <option value="30">منذ شهر</option>
                                                <option value="365">منذ سنة</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="created_at">تاريخ التسجيل</label>
                                            <select class="form-control" id="created_at" name="created_at">
                                                <option value="" selected>اختر</option>
                                                <option value="0">اليوم</option>
                                                <option value="1">امس</option>
                                                <option value="7">منذ اسبوع</option>
                                                <option value="30">منذ شهر</option>
                                                <option value="365">منذ سنة</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="main-btn2 custom_form mb-3" style="background-color: #b72dd2;"  
                                        <h5 class="m-0">🔍 بحث</h5>
                                       
                                    </button>
                                </div>
                            </div>

                        </div>

                        <!-- Second Column -->
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-head">
                                    <div class="buttons rounded-btn  mb-3" onclick="event.preventDefault();">
                                        
                                        <button class="search-head-collapse mb-3"">
                                            <h2 class="h2 mb-2 font-weight-bold" style="color:#fff;">
                                            التفاصيل
                                        </h2>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="goals">الهدف من التسجيل</label>
                                            <select class="form-control" id="goals" name="goals">
                                                <option value="" selected>اختر</option>
                                                @foreach(App\Models\Media_file::where('type', 'goals')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->title_ar}}">{{$item->title_ar}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="age">العمر</label>
                                            <select class="form-control" name="age" id="age">
                                                <option value="">اختر</option>
                                                <option value="22 - 18">
                                                    22 - 18
                                                </option>
                                                <option value="27 - 23">
                                                    27 - 23
                                                </option>
                                                <option value="32 - 28">
                                                    32 - 28
                                                </option>
                                                <option value="37 - 33">
                                                    37 - 33
                                                </option>
                                                <option value="42 - 38">
                                                    42 - 38
                                                </option>
                                                <option value="47 - 43">
                                                    47 - 43
                                                </option>
                                                <option value="52 - 48">
                                                    52 - 48
                                                </option>
                                                <option value="53+">
                                                    53+
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="social_level">الحالة الاجتماعية</label>
                                            <select class="form-control" name="social_level" id="social_level">
                                                <option value="">اختر</option>
                                                @foreach(App\Models\Media_file::where('type', 'social_levels')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->title_ar}}">{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- third Column -->
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-head">
                                     <div class="buttons rounded-btn  mb-3" onclick="event.preventDefault();">
                                        
                                        <button class="search-head-collapse mb-3"">
                                            <h2 class="h2 mb-2 font-weight-bold" style="color:#fff;">
                                            التفاصيل المتقدمة
                                            </h2>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    @if(!checkUserPackage()) <h3 style="color: red;text-align: center">هذه الخدمة متوفرة بعد ترقية الاشتراك</h3> @endif
                                    <div class="form-group">

                                        <div class="labelform-content">
                                            <label class="labelform">الاسم</label>
                                            <input  placeholder = "الاسم" class="form-control" type="text" name="first_name" id="first_name" {{checkUserPackage() ? '' : 'disabled'}}>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="has_sons">لديه ابناء</label>
                                            <select class="form-control" id="has_sons" name="has_sons" {{checkUserPackage() ? '' : 'disabled'}}>
                                                <option value="">اختر</option>
                                                <option value="0">
                                                    لا
                                                </option>
                                                <option value="1">
                                                    نعم
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="level">التحصيل العلمي</label>
                                            <select class="form-control" id="level" name="level" {{checkUserPackage() ? '' : 'disabled'}}>
                                                <option value="">اختر</option>
                                                @foreach(App\Models\Media_file::where('type', 'levels')->orderBy('id')->get() as $item)
                                                    <option value="{{$item->title_ar}}">{{$item->title_ar}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- fourth Column -->
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-head">
                                    <div class="buttons rounded-btn  mb-3" onclick="event.preventDefault();">
                                        
                                        <button class="search-head-collapse mb-3"">
                                            <h2 class="h2 mb-2 font-weight-bold" style="color:#fff;">
                                            المظهر
                                        </h2>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    @if(!checkUserPackage()) <h3 style="color: red;text-align: center">هذه الخدمة متوفرة بعد ترقية الاشتراك</h3> @endif
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="eye_color">لون العيون</label>
                                            <select class="form-control" name="eye_color" id="eye_color" {{checkUserPackage() ? '' : 'disabled'}}>
                                                <option value="">اختر</option>
                                                <option value="أسود">
                                                    أسود
                                                </option>
                                                <option value="بني">
                                                    بني
                                                </option>
                                                <option value="عسلي">
                                                    عسلي
                                                </option>
                                                <option value="أزرق">
                                                    أزرق
                                                </option>
                                                <option value="اخضر">
                                                    اخضر
                                                </option>
                                                <option value="رمادي">
                                                    رمادي
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="hair_color">لون الشعر:</label>
                                            <select class="form-control" name="hair_color" id="hair_color" {{checkUserPackage() ? '' : 'disabled'}}>
                                                <option value="">اختر</option>
                                                <option value="أسود">
                                                    أسود
                                                </option>
                                                <option value="بني">
                                                    بني
                                                </option>
                                                <option value="اشقر">
                                                    اشقر
                                                </option>
                                                <option value="احمر">
                                                    احمر
                                                </option>
                                                <option value="رمادي">
                                                    رمادي
                                                </option>
                                                <option value="ابيض">
                                                    ابيض
                                                </option>
                                                <option value="اصلع">
                                                    اصلع
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="skin_color">لون البشرة:</label>
                                            <select class="form-control" name="skin_color" id="skin_color" {{checkUserPackage() ? '' : 'disabled'}}>
                                                <option value="">اختر</option>
                                                <option value="ابيض">
                                                    ابيض
                                                </option>
                                                <option value="يميل الى البياض">
                                                    يميل الى البياض
                                                </option>
                                                <option value="أسود">
                                                    أسود
                                                </option>
                                                <option value="يميل الى السواد">
                                                    يميل الى السواد
                                                </option>
                                                <option value="أسمر">
                                                    أسمر
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label class="labelform" for="height">الطول:</label>
                                            <select class="form-control" name="height" id="height" {{checkUserPackage() ? '' : 'disabled'}}>
                                                <option value="">اختر</option>
                                                <option value="قصير" {{isset($user) && $user->height == 'قصير' ? 'selected' : ''}}>
                                                    قصير
                                                </option>
                                                <option value="متوسط" {{isset($user) && $user->height == 'متوسط' ? 'selected' : ''}}>
                                                    متوسط
                                                </option>
                                                <option value="طويل" {{isset($user) && $user->height == 'طويل' ? 'selected' : ''}}>
                                                    طويل
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="labelform-content">
                                            <label  class="labelform" for="width">الوزن:</label>
                                            <select class="form-control" name="width" id="width" {{checkUserPackage() ? '' : 'disabled'}}>
                                                <option value="">اختر</option>
                                                <option value="ضعيف">
                                                    ضعيف
                                                </option>
                                                <option value="عادي">
                                                    عادي
                                                </option>
                                                <option value="سمين">
                                                    سمين
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="col-md-12">
                            <div class="mt-3">
                            
                                <button type="submit" class="main-btn2 custom_form mb-3" style="background-color: #b72dd2; "  
                                        <h5 class="m-0">🔍 بحث</h5>
                                       
                                    </button>
                            </div>
                        </div>
                    </div>
                </form>
                {{--                <form action="{{url('all_clients')}}" method="get">--}}
                {{--                    @csrf--}}
                {{--                    <div class="row">--}}
                {{--                        <div class="col-lg-6">--}}

                {{--                        </div>--}}
                {{--                        <!-- Second Column -->--}}
                {{--                        <div class="col-lg-6">--}}

                {{--                        </div>--}}
                {{--                        <div class="col-lg-12">--}}
                {{--                        --}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </form>--}}
            </div>
        </div>
    </section>
@endsection
