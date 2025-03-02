@extends('master')
@section('title') {{Translate('الرئيسية')}} @endsection
@section('style')
@endsection

@section('content')
    <!-- main slider  -->
    <section class="slider">
        <div class="swiper main-slider">
            <div class="swiper-wrapper ">
                <div class="swiper-slide">
                    <div class="slid-thumb">
                        <img src="{{ site_path() }}/assets/img/slider.png" class="img-fluid slid-thumb" alt="">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="slid-thumb">
                        <img src="{{ site_path() }}/assets/img/slider.png" class="img-fluid slid-thumb" alt="">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="slid-thumb">
                        <img src="{{ site_path() }}/assets/img/slider.png" class="img-fluid slid-thumb" alt="">
                    </div>
                </div>
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

    <!-- static  -->
    <section class="statics">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-12 wow bounceInRight" data-wow-delay="0.2s">
                    <div class="static-card">
                        <div class="row align-items-center no-gutters">
                            <div class="col-auto">
                                <div class="static-icon">
                                    <img src="{{ site_path() }}/assets/img/check.png" alt="">
                                </div>
                            </div>
                            <div class="col-auto">
                                <span class="static-num" data-number="500000"></span>
                                <p class="static-tit">مشترك مسجل</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12 wow bounceInRight" data-wow-delay="0.4s">
                    <div class="static-card">
                        <div class="row align-items-center no-gutters">
                            <div class="col-auto">
                                <div class="static-icon">
                                    <img src="{{ site_path() }}/assets/img/plus.png" alt="">
                                </div>
                            </div>
                            <div class="col-auto">
                                <span class="static-num" data-number="1500"></span>
                                <p class="static-tit">مشترك جديد كل يوم</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12 wow bounceInRight" data-wow-delay="0.6s">
                    <div class="static-card">
                        <div class="row align-items-center no-gutters">
                            <div class="col-auto">
                                <div class="static-icon">
                                    <img src="{{ site_path() }}/assets/img/couple.png" alt="">
                                </div>
                            </div>
                            <div class="col-auto">
                                <span class="static-num" data-number="2024"></span>
                                <p class="static-tit">نجات متتالية</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //static -->

    <!-- about -->
    <section class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1 class="sec-tit">
                        أهلاُ بكم في موقع زواج تبوك
                    </h1>
                    <div class="about-content">
                        هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على
                        الشكل
                        الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم
                        لأنها
                        تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى
                        نصي"
                        فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات
                        الويب
                        تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال "lorem ipsum" في أي محرك
                        بحث ستظهر
                        العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص
                        لوريم
                        إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.
                    </div>
                    <div class="about-url">
                        <a href="#" class="main-btn">
                            <span>تعرّف علينا أكثر</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about-img">
                        <img src="{{ site_path() }}/assets/img/about.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //about -->

    <div class="tip">
        <div class="container">
            <p>نحن نؤمن بأن الحياة تصبح أكثر سعادة عندما تبدأ بالحب وتنتهي بالطموح. لمساعدتك في العثور على شريك
                حياتك المثالي، استخدم خاصية البحث المتقدم
                لمساعدتك في العثور على شريك
            </p>
        </div>
    </div>

    <section class="new-members">
        <div class="container">
            <h2 class="sec-tit text-center">
                أعضاء جدد
            </h2>
            <div class="row justify-content-center">
                <div class="col-lg-auto col-md-3 col-6 wow bounceInRight" data-wow-delay="0.2s">
                    <div class="member-img">
                        <img src="{{ site_path() }}/assets/img/member1.png" alt="">
                    </div>
                </div>
                <div class="col-lg-auto col-md-3 col-6 wow bounceInRight" data-wow-delay="0.4s">
                    <div class="member-img">
                        <img src="{{ site_path() }}/assets/img/member2.png" alt="">
                    </div>
                </div>
                <div class="col-lg-auto col-md-3 col-6 wow bounceInRight" data-wow-delay="0.6s">
                    <div class="member-img">
                        <img src="{{ site_path() }}/assets/img/member3.png" alt="">
                    </div>
                </div>
                <div class="col-lg-auto col-md-3 col-6 wow bounceInRight" data-wow-delay="0.8s">
                    <div class="member-img">
                        <img src="{{ site_path() }}/assets/img/member4.png" alt="">
                    </div>
                </div>
                <div class="col-lg-auto col-md-3 col-6 wow bounceInRight" data-wow-delay="1s">
                    <div class="member-img">
                        <img src="{{ site_path() }}/assets/img/member5.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection