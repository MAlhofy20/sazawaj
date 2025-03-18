@extends('site.master')

@section('title') {{Translate('الرئيسية')}} @endsection

@section('meta')
    @include('meta::manager', [
        'title' => settings('site_name'),
        'description' => settings('description'),
        'image' => url('' . settings('logo')),
        'keywords' => settings('key_words')
    ])
@endsection

@section('style')

    <style>
        /*.marquee {*/
        /*    width: 100%; !* عرض العنصر *!*/
        /*    overflow: hidden; !* إخفاء النص الزائد *!*/
        /*    white-space: nowrap; !* منع التفاف النص *!*/
        /*    position: relative; !* لجعل المحتوى قابل للتحكم *!*/
        /*}*/

        /*.marquee span {*/
        /*    display: inline-block; !* لجعل النص في خط واحد *!*/
        /*    animation: marquee 10s linear infinite; !* حركة مستمرة وسرعتها محددة *!*/
        /*}*/

        /*@keyframes marquee {*/
        /*    from {*/
        /*        transform: translateX(-100%); !* يبدأ النص من خارج الشاشة على اليمين *!*/
        /*    }*/
        /*    to {*/
        /*        transform: translateX(100%); !* ينتهي النص بخروجه من الشاشة على اليسار *!*/
        /*    }*/
        /*}*/
        /* General styles for the cards */
.static-card {

    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    height: 100%; /* Ensures the card takes full height */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

/* Ensure all cards are the same height on tablets */
@media (min-width: 768px) and (max-width: 991px) {
    .statics .row {
        display: flex; /* Use flexbox for row layout */
        flex-wrap: wrap; /* Allow wrapping */
    }

    .statics .col-md-4 {
        display: flex;
        flex-direction: column;
    }

    .static-card {
        flex-grow: 1; /* Cards grow evenly */
        height: auto; /* Ensure height adjusts dynamically */
    }
}

    </style>
@endsection

@section('content')
    <!-- main slider  -->
    <section class="slider">
        <div class="swiper main-slider">
            <div class="swiper-wrapper ">
                @foreach (App\Models\Slider::whereType('app')->get() as $item)
                    <div class="swiper-slide">
                        <div class="slid-thumb">
                            <img src="{{ url('' . $item->image) }}" class="img-fluid slid-thumb" alt="">
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mainArrow swiper-button-prev">
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <style>.cls-1 {
                                fill: none;
                                stroke: #b62cd2;
                                stroke-linecap: round;
                                stroke-linejoin: round;
                                stroke-width: 2px;
                            }</style>
                    </defs>
                    <title/>
                    <g id="arrow-left">
                        <line class="cls-1" x1="3" x2="29" y1="16" y2="16"/>
                        <line class="cls-1" x1="3" x2="7" y1="16" y2="11"/>
                        <line class="cls-1" x1="3" x2="7" y1="16" y2="21"/>
                    </g>
                </svg>
            </div>
            <div class="mainArrow swiper-button-next">
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <style>.cls-1 {
                                fill: none;
                                stroke: #b62cd2;
                                stroke-linecap: round;
                                stroke-linejoin: round;
                                stroke-width: 2px;
                            }</style>
                    </defs>
                    <title/>
                    <g id="arrow-right">
                        <line class="cls-1" x1="29.08" x2="3.08" y1="16" y2="16"/>
                        <line class="cls-1" x1="29.08" x2="25.08" y1="16" y2="21"/>
                        <line class="cls-1" x1="29.08" x2="25.08" y1="16" y2="11"/>
                    </g>
                </svg>
            </div>
        </div>
    </section>
    <!-- //main slider   -->

    <div class="tip-content">
        <div class="container">
            <div class="tip">

                <div class="news-bar">


                    <div class="slick marquee">
                        <div class="slick-slide">
                            <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' ❤️ ')}}
    </span>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' ❤️ ')}}
    </span>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' ❤️ ')}}
    </span>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' ❤️ ')}}
    </span>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' ❤️ ')}}
    </span>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' ❤️ ')}}
    </span>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' ❤️ ')}}
    </span>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' ❤️ ')}}
    </span>
                            </div>
                        </div>
                        <div class="slick-slide">
                            <div class="inner">
<span>
                        {{App\Models\Media_file::whereType('news_bar')->pluck('title_ar')->implode(' ❤️ ')}}
    </span>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- static  -->
   <section class="statics">
    <div class="container">
        <div class="row">
            @foreach (App\Models\Media_file::whereType('statics')->get() as $item)
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="static-card">
                        <div class="row align-items-center no-gutters">
                            <div class="col-auto">
                                <div class="static-icon">
                                    <img loading="lazy" src="{{ url('' . $item->image) }}" alt="">
                                </div>
                            </div>
                            <div class="col-auto">
                                <span class="static-num">{!! $item->desc_ar !!}</span>
                                <p class="static-tit">{!! $item->title_ar !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


    <!-- //static -->

    <!-- Hero -->
    <section class="about py-5" style="background-color: #ede2ab;">
        <div class="container">
            @php
                $page = App\Models\Page::whereUrl('about')->first();
            @endphp

            <div class="row align-items-center">
                <!-- النص والزر -->
                <div class="col-lg-12 text-center text-lg-center">
                    <h2 class="sec-tit">
                        {!! $page->title_ar !!}
                    </h2>
                    <p class="about-content animated fadeIn" >
                        {!! $page->desc_ar !!}
                    </p>
                    <a href="{{ ENV('URL') }}/register" class="main-btn2 mt-4" style="background-color: #b72dd2; color: white; font-size: 18px; padding: 12px 30px; border-radius: 30px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; display: inline-block;">
                        <h5 class="m-0">سجل معنا الآن وابدأ البحث عن شريك العمر</h5>
                    </a>
                </div>

                <!-- الصورة -->
               {{-- <div class="about-img" style="width: 350px; height: 350px; overflow: hidden; border-radius: 50%; border: 5px solid #2492a8;">
                    <img class="rounded-circle img-fluid shadow-lg" loading="lazy" src="{{ site_path() }}/assets/img/about.png" alt="About Us" style="width: 100%; height: 100%; object-fit: contain; object-position: center;">
                </div> --}}


            </div>
        </div>
    </section>


    <!-- //Hero -->

        <!-- about -->
        {{-- <section class="about py-5">
            <div class="container">


                <div class="row align-items-center">
                    <!-- النص والزر -->
                    <div class="container text-center">
                        <h2 class="sec-tit mb-2" style="color:#2492a8">
                            منصة سعودية برؤية محلية تُسهّل رحلة البحث عن شريك الحياة
                        </h2>
                        <!--
                        <p class="about-content animated fadeIn" >
                            <p class="lead mb-2" style="color: #000000;">
                              سعودي زواج منصة سعودية متخصصة تجمع الباحثين عن شريك حياتهم في بيئة آمنة وسهلة.
                            </p>
                            <p class="lead mb-1" style="color: #000000;">
                                نوفر لك الأدوات اللي تحتاجها للعثور على شريك حياتك المناسب في السعودية، مع ضمان الخصوصية والثقة.
                            </p>
                            <p class="lead mb-2" style="color: #000000;">
                                في سعودي زواج، نؤمن بأن السعادة تبدأ بقرار صغير!
                            </p>
                            <p class="lead mb-1" style="color: #000000;">
                                انضم لنا وابدأ رحلة البحث عن شريك حياتك
                            </p>

                        </p>
                        -->
                        <div class="content-container mt-4">
    <div class="content-box">
        <div class="icon-des">
           <img src="{{ site_path() }}/assets/img/icons/wedding.png" alt="icon">
        </div>
        <p>سعودي زواج منصة سعودية متخصصة تجمع الباحثين عن شريك حياتهم في بيئة آمنة وسهلة.</p>
    </div>

    <div class="content-box">
        <div class="icon-des">
             <img src="{{ site_path() }}/assets/img/icons/computer.png" alt="icon">
        </div>
        <p>نوفر لك الأدوات اللي تحتاجها للعثور على شريك حياتك المناسب في السعودية، مع ضمان الخصوصية والثقة.</p>
    </div>

    <div class="content-box">
        <div class="icon-des">
            <img src="{{ site_path() }}/assets/img/icons/love.png" alt="icon">
        </div>
        <p>في سعودي زواج، نؤمن بأن السعادة تبدأ بقرار صغير!</p>
    </div>

    <div class="content-box">
        <div class="icon-des">
           <img src="{{ site_path() }}/assets/img/icons/wedding2.png" alt="icon">
        </div>
        <p>انضم لنا وابدأ رحلة البحث عن شريك حياتك.</p>
    </div>
</div>


                    </div>

                </div>
            </div>
        </section> --}}

        <!-- //about -->



           <!-- advanced search-->
           <section class="about" >
            <div class="container">
                {{-- Banner --}}

<!--
                <section class="banner">
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="about-img col-12">

                                    <img loading="lazy" src="{{ site_path() }}/assets/img/advanced-search.webp" alt="البحث المتقدم لموقع سعودي زواج" class="img-fluid w-100 rounded shadow-lg banner-image">

                            </div>
                        </div>
                    </div>
                </section>
                -->

                <div class="row align-items-center ">
                    <!-- النص والعنوان -->
                    <div class="container text-center">
                        <h2 class="sec-tit" style="color:#b72dd2">
                            ابحث عن شريك حياتك بخطوات بسيطة
                        </h2>
                        <p class="about-content wow bounceInRight" data-wow-delay="0.2s">
                            <p class="lead mb-5" style="color: #2c2c2c; font-size:18px; font-weight:bold">
                                حدد المواصفات باستخدام البحث السريع لتصل إلى شريك حياتك
                            </p>
                        </p>

                    </div>

                </div>
                <section class="statics mt-0 mb-5">
                    <div class="container text-center">
                        <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12 wow bounceInRight" data-wow-delay="0.2s">
                                    <div class="static-card text-center">
                                                <p class="static-tit">المنطقة</p>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12 wow bounceIndown" data-wow-delay="0.2s">

                                        <div class="static-card text-center">
                                            <p class="static-tit">الحالة الإجتماعية</p>
                                        </div>

                                </div>

                                <div class="col-lg-4 col-sm-6 col-12 wow bounceInLeft" data-wow-delay="0.2s">
                                    <div class="static-card text-center">
                                        <p class="static-tit">العمر</p>
                                    </div>
                                </div>
                        </div>
    {{--
                                <a href="{{ ENV('URL') }}/register" class="main-btn2 mt-5 wow fadeInUp" data-wow-delay="0.2s" style="background-color: #b72dd2; color: white; font-size: 25px; padding: 12px 30px; border-radius: 30px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; display: inline-block;">
                                    <h5 class="m-0">عرض النتائج 🔍</h5>
                                </a>
                                --}}

                    </div>
                </section>
            </div>
        </section>


        <!-- //advanced search -->

        <section class="new-members py-5" style="background-color: #ede2ab;">
            <div class="container">

                <div class="row justify-content-center p-3">
                    @php
                        $new_users = App\Models\User::where('user_type', 'client')->where('blocked', '0')->where('avatar_seen', '1')->latest()->paginate(6);
                    @endphp

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
            {{-- <div class="container text-center mt-5">
                <h2 class="sec-tit" style="color:#b72dd2">
                    جاهز لبداية جديدة؟
                </h2>
                <p class="about-content wow bounceInRight" data-wow-delay="0.2s">
                    <p class="lead mb-4" style="color: #2c2c2c;">
                        ما بينك وبين النصيب إلا خطوة بسيطة، ابحث بكل أمان وخصوصية
                    </p>
                </p>

                <a href="{{ ENV('URL') }}/register" class="main-btn2 mt-4 wow fadeInUp" data-wow-delay="0.2s" style="background-color: #2492a8; color: white; font-size: 25px; padding: 12px 30px; border-radius: 30px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; display: inline-block;">
                    <h5 class="m-0">سجل الآن 💕</h5>
                </a>

            </div> --}}
        </section>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select all elements with the class 'static-num'
        const counterElements = document.querySelectorAll('.static-num');

        counterElements.forEach(element => {
            const targetNumber = parseFloat(element.innerText);  // Use parseFloat instead of parseInt to preserve decimals
            if (!isNaN(targetNumber)) {
                let currentNumber = 0;
                const increment = targetNumber / 50;  // Increment control
                const speed = 50;  // Time interval (smaller value = faster)

                const counterInterval = setInterval(() => {
                    if (currentNumber >= targetNumber) {
                        clearInterval(counterInterval);  // Stop the interval once the target is reached
                        element.innerText = targetNumber.toFixed(3);  // Show the exact number, with 3 decimal places (you can adjust this)
                    } else {
                        currentNumber += increment;
                        element.innerText = currentNumber.toFixed(3);  // Update the number with 3 decimal places
                    }
                }, speed); // Interval speed
            }
        });
    });
</script>





@endsection

