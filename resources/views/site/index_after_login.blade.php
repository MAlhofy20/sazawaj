    @extends('site.master')
@section('title') {{Translate('الرئيسية')}} @endsection
@section('style')
    <style>
        .quickSearch-gold-content{
            background: #ede2ab;
             border-radius: 15px;
            padding: 30px 0;
        }
        .quickSearch-gold-content-items {
            padding: 0 20px ;
        }



        @media (min-width: 992px) {
            .quickSearch-gold-content{
                 margin: 0 auto;

            }
        }
    </style>
    <style>

        .form-container {
            width: 100%;
            max-width: 500px;
            padding: 30px 0 ;
            background-color: #2492a8;

            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #fff;
            margin: 0 auto;
        }
        .form-container h2 {
            margin-bottom: 20px;
            font-size: 22px;
            text-align: center;
            color: #fff;
            position: relative;
        }

        .form-group label {
            font-weight: bold;
            color: #fff;
            display: inline-block;
            margin-bottom: 8px;
            margin-right: 10px;
        }
        .form-group input[type="checkbox"] {
            margin-right: 5px;
        }
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            color: #555;
        }
        .form-group select:focus {
            border-color: #e500a4;
            outline: none;
        }
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 15px;
        }
        .radio-group {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 15px;
        }
        .form-group input[type="radio"] {
            margin-right: 5px;
        }
        button {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            position: relative;
        }
        button:hover {
            background-color: #218838;
        }
        button:active {
            background-color: #1e7e34;
        }

        .form-search-cont input[type=checkbox], .form-search-cont input[type=radio] {
               width: 15px;
    height: 15px;
    vertical-align: middle;
    border-radius: 100%;
    display: inline-block !important;
    position: relative;
    background-color: #fff;
    border: 2px solid #d9d9d9;
    transition: border-color .3s ease-in-out;
        }
        .form-search-cont input[type=checkbox], .form-search-cont input[type=radio]:hover {

border-color: #701782 !important;
}

input[type="radio"], input[type="checkbox"]{
    box-sizing: border-box;
    padding: 0;
    margin: 5px;
}
.form-search-cont-addition .checkbox-group label input {
    margin-inline-end: 16px !important;
}


label, select, input[type=radio], input[type=checkbox], input[type=file], input[type=button], input[type=submit], input[type=reset], button {
    cursor: pointer;
}

        .form-search-cont-group{
            background-color: #58b6cb;
            padding: 20px ;
             color: #fff;
        }
        .form-search-cont-addition{
            padding: 20px ;
        }
        .form-search-select{.form-search-cont .main-butn.custom_form
            background-color: #ecb8f8;
             color: #fff;
             margin-bottom: 20px;
            border-bottom: 1px solid #d67de8;
            font-size: 110%;
        }
        .form-search-cont .main-butn.custom_form::before{
            left: 5px;
        }
        .form-search-cont .form-search-cont-group{
            padding: 20px 5px;
        }
        .form-search-cont-addition .checkbox-group label{
            display: flex;
        }
        .form-search-cont-addition .checkbox-group label input{
            margin-inline-end: 5px;
        }
  

    </style>
 @endsection

@section('content')
    <!--  welcome  -->
    {{--<section class="welcome">
        <div class="welcome-img">
            <img src="{{ site_path() }}/assets/img/welcome.png" alt="">
        </div>
        <p class="welcome-tit">أهلاً بكم في موقع {{ settings('site_name') }}</p>
    </section>--}}
    <!--  //welcome  -->

    <!-- //quick search -->
    <div class="tip-content" style="margin-bottom: 10px">
        <div class="container">
            <div class="tip">

                <div class="slick marquee">
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                    <div class="slick-slide">
                        <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' | ')}}
    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  home  -->
    <section class="homepage">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="welcome-home">
                        <div class="container">
                            <div class="welcome-home-items-content">
                                <div class="welcome-info d-flex ">
                                    <div class="client-img">
                                        <img loading="lazy" src="{{ url('' . auth()->user()->avatar) }}" alt="">
                                    </div>
                                    <div class="welcome-head">
                                        <span class="welcome-static ">
                                            أهلاُ وسهلاُ بك:
                                        </span>
                                        <span class="welcome-name">{{auth()->user()->first_name}}</span>
                                    </div>
                                </div>
                                <div class="welcome-url">
                                    <a href="{{route('site_profile')}}" class="main-btn">
                                        تعديل الحساب
                                    </a>
                                </div>
                            </div>


                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="hold-welcome-notification wow bounceInRight position-relative" data-wow-delay="0.2s">
                                            @if ($messageCounter > 0)
                                                <span id="message-icon" class="red-dot"></span>
                                            @else
                                                <span id="message-icon" class="red-dot" style="display: none;"></span>
                                            @endif
                                            
                                            <a href="{{url('all_rooms')}}">
                                                <div class="welcome-icon">
                                                    <img loading="lazy" src="{{ site_path() }}/assets/img/emails.png" alt="">
                                                </div>
                                                <p class="welcome-notice">
                                                    الرسائل
                                                </p>
                                                <p class="welcome-static">
                                                    <span id="messageCounter">{{$messageCounter}}</span>
                                                    <span>رسالة</span>
                                                </p>
                                            </a>
                                        </div>
                                        <div class="hold-welcome-notification wow bounceInRight position-relative" data-wow-delay="0.4s">
                                            @if ($visitorCounter > 0)
                                                <span id="visitor-icon" class="red-dot"></span>  
                                            @else
                                                <span id="visitor-icon" class="red-dot" style="display: none;"></span>  
                                            @endif    
                                          
                                            <a href="{{url('all_visitor_clients')}}">
                                                <div class="welcome-icon">
                                                    <img loading="lazy" src="{{ site_path() }}/assets/img/visitor.png" alt="">
                                                </div>
                                                <p class="welcome-notice">
                                                    الزائرين
                                                </p>
                                                <p class="welcome-static">
                                                    <span id="visitorCounter">{{$visitorCounter}}</span>
                                                    <span>زائر</span>
                                                </p>
                                            </a>
                                        </div>
                                        <div class="hold-welcome-notification wow bounceInRight position-relative" data-wow-delay="0.6s">
                                            @if ($likerCounter > 0)
                                                <span id="liker-icon" class="red-dot"></span>
                                            @else
                                                <span id="liker-icon" class="red-dot" style="display: none;"></span> 
                                            @endif    
                                            <a href="{{url('all_fav_clients')}}">
                                                <div class="welcome-icon">
                                                    <img loading="lazy" src="{{ site_path() }}/assets/img/heart.png" alt="">
                                                </div>
                                                <p class="welcome-notice">
                                                    المعجبين
                                                </p>
                                                <p class="welcome-static">
                                                    <span id="likerCounter">{{$likerCounter}}</span>
                                                    <span>إعجاب</span>
                                                </p>
                                            </a>
                                        </div>
                                        {{--<div class="hold-welcome-notification wow bounceInRight" data-wow-delay="0.8s">
                                            <a href="{{url('all_blocked_clients')}}">
                                                <div class="welcome-icon">
                                                    <img loading="lazy" src="{{ site_path() }}/assets/img/visitor.png" alt="">
                                                </div>
                                                <p class="welcome-notice">
                                                    التجاهل
                                                </p>
                                                <p class="welcome-static">
                                                    <span>{{App\Models\User_block_list::where('to_id', '!=', auth()->id())->where('user_id', auth()->id())->count()}}</span>
                                                    <span>تجاهل</span>
                                                </p>
                                            </a>
                                        </div>--}}
                                    </div>


                        </div>
                    </div>
                    <!-- new member -->
                    <section class="new-members new-members-like">
                        <div class="container">
                            <h2 class="sec-tit text-center sec-tit-bg">
                                أعضاء مناسبين لك
                            </h2>
                            <div class="row justify-content-center">
                                @foreach($random_users as $item)
                                    <div class="col-lg-2 col-md-3 col-4 mb-4 wow bounceInRight" data-wow-delay="0.2s">
                                        <a href="{{url('show_client/' . $item->id)}}">
                                            <div class="member-img">
                                                <img loading="lazy" src="{{url('' . $item->avatar)}}" alt="" class="img-fluid" style="border: 4px solid #2492a8; border-radius: 15px; width: 100%; height: 100%;">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    @if(!checkUserPackage())
                        <section class="register quickSearch checkUserPackage">
                            <div class="container">
                                <div class="quickSearch-gold-content">
                                    <h2 class="main-tit text-center">ﺗﺮﻗﻴﺔ اﻟﻌﻀﻮﻳﺔ</h2>


                                    <div class="quickSearch-gold-content-items">
                                        <p class="text-center for-cont" style="    color: var(--main);font-size:24px;margin: 5px 0; "> ﻟﻜﻲ ﺗﺘﻤﻜﻦ ﻣﻦ اﻻﺳﺘﻔﺎدة ﻣﻦ ﺟﻤﻴﻊ ﺧﺪﻣﺎت اﻟﻤﻮﻗﻊ</p>
                                        <div class="card-qick">
                                            <img src="{{ site_path() }}/assets/img/card.png" alt="" width="100px" height="100px">

                                        </div>
                                        <a href="{{url('all_packages')}}" class="next-btn main-btn">
                                            <span>ترقيه</span>
                                            <i class="fa-solid fa-left-long"></i>
                                        </a>
                                    </div>



                                </div>
                            </div>
                        </section>
                @endif
                <!-- //new member -->
                    <!-- new member -->
                    <section class="new-members">
                        <div class="container">
                            <h2 class="sec-tit text-center sec-tit-bg">
                                أعضاء جدد
                            </h2>
                            <div class="row justify-content-center">
                                @foreach($new_users as $item)
                                    <div class="col-lg-2 col-md-3 col-4 mb-4 wow bounceInRight" data-wow-delay="0.2s">
                                        <a href="{{url('show_client/' . $item->id)}}">
                                            <div class="member-img">
                                                
                                                  <img loading="lazy" src="{{url('' . $item->avatar)}}" alt="" class="img-fluid" style="border: 4px solid #2492a8; border-radius: 15px; width: 100%; height: 100%;">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    <!-- new member -->
                    
                    <!-- title and des -->
                    <div class="container text-center mt-5">
                        <h2 class="sec-tit" style="color:#2492a8">
                            لم تجد الشخص المناسب
                        </h2>
                        <p class="about-content wow bounceInRight" data-wow-delay="0.2s">
                            <p class="lead mb-4" style="color: #2c2c2c;">
                                حدد المواصفات باستخدام البحث السريع لتصل إلى شريك حياتك
                            </p>
                        </p>

                    </div>

                </div>
                <div class="col-lg-4">
                    <!-- quick search -->

                    <div class="form-container form-search-cont ">
                        <h2 class="main-tit">البحث السريع</h2>
                        <form action="{{url('all_clients')}}" method="get">
                            @csrf
                            <div class="form-search-cont-gender">
                                <div class="form-group form-search-cont-group">

                                    <label class="labelform-search">الجنس</label>
                                    <div class="radio-group">
                                        <label><input type="radio" name="gender" value="male"> ذكر</label>
                                        <label><input type="radio" name="gender" value="female"> أنثى</label>
                                    </div>
                                </div>
                            </div>
                            <!-- اختيار الجنس -->


                            <div class="form-search-cont-addition">
                                <div class="checkbox-group">
                                    {{--<label><input type="checkbox" name="has_portrait">بيانات مع صور</label>--}}
                                    <label><input type="checkbox" name="login" id="login" value="1">المتواجدون الآن في الموقع</label>
                                    <label><input type="checkbox" name="logout_at" id="logout_at" value="0">زوار الموقع اليوم</label>
                                </div>
                            </div>
                            <!-- خيارات إضافية -->


                            <div class="form-search-select">
                                <!-- الهدف -->
                                <div class="form-group form-search-cont-group">
                                    <label class="labelform-search" for="seekings">الهدف</label>
                                    <select id="goals" name="goals">
                                        <option value="" selected>(اختار)</option>
                                        @foreach(App\Models\Media_file::where('type', 'goals')->orderBy('title_ar')->get() as $item)
                                            <option value="{{$item->title_ar}}">{{$item->title_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- الدولة -->
                                <div class="form-group form-search-cont-group">
                                    <label class="labelform-search" for="country">المدينة</label>
                                    <select id="city" name="city">
                                        <option value="" selected>(اختار)</option>
                                        @foreach(App\Models\City::orderBy('title_ar')->get() as $item)
                                            <option value="{{$item->title_ar}}" {{isset($user) && $user->city == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                    @endforeach
                                    <!-- أضف المزيد من الدول هنا -->
                                    </select>
                                </div>

                                <!-- العمر -->
                                <div class="form-group form-search-cont-group">
                                    <label class="labelform-search" for="age">العمر</label>
                                    <select id="age" name="age">
                                        <option value="" selected>(اختار)</option>
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


                            <button class="main-butn custom_form" type="submit">ابحث</button>
                        </form>
                    </div>


                </div>
            </div>

        </div>
    </section>
    <!--  //home -->





@endsection