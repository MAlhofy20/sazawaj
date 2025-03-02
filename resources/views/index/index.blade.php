<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>كساء</title>
    <link rel="stylesheet" href="{{ site_path() }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ site_path() }}/assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ site_path() }}/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ site_path() }}/assets/css/jquery.fancybox.css">
    <link rel="stylesheet" href="{{ site_path() }}/assets/css/style.css">
</head>
<body>

<main class="wrap">

    <section class="nav-overlay"></section>

    <section class="mobile-nav-list">
        <a class="mobile-logo text-center"
           href="#">
            <img src="{{ url('' . settings('logo')) }}">
        </a>
        <ul class="mobile-list list-unstyled">
            <li class="menu-item"><a href="#header">الرئيسية</a></li>
            <li class="menu-item"><a href="#about">من نحن</a></li>
            <li class="menu-item"><a href="#services">خدماتنا</a></li>
            <li class="menu-item"><a href="#statics">المشاريع</a></li>
            <li class="menu-item"><a href="#partners">شركاء النجاح</a></li>
            <li class="menu-item"><a href="#videos">المعرض</a></li>
            <li class="menu-item"><a href="#screens">سكرينات</a></li>
            <li class="menu-item"><a href="#downloads>التطبيق</a></li>
            <li class="menu-item"><a href="#contacts">تواصل معنا</a></li>
        </ul>
    </section>

    <header class="head-home">
        <div class="head-menu">
            <div class="container">
                <div class="main-nav">
                    <a class="menu-logo"
                       href="#">
                        <img src="{{ url('' . settings('logo')) }}">
                    </a>
                    <ul class="nav-list">
                        <li class="menu-item active"><a href="#header">الرئيسية</a></li>
                        <li class="menu-item"><a href="#about">من نحن</a></li>
                        <li class="menu-item"><a href="#services">خدماتنا</a></li>
                        <li class="menu-item"><a href="#statics">المشاريع</a></li>
                        <li class="menu-item"><a href="#partners">شركاء النجاح</a></li>
                        <li class="menu-item"><a href="#videos">المعرض</a></li>
                        <li class="menu-item"><a href="#screens">سكرينات</a></li>
                        <li class="menu-item"><a href="#downloads">التطبيق</a></li>
                        <li class="menu-item"><a href="#contacts">تواصل معنا</a></li>
                    </ul>
                    <div class="menu-icons d-flex align-items-center">
                        <div class="menu-btns">
                            {{--<a class="lang"
                               href="#">
                                EN
                            </a>--}}
                            <a class="nav-btn"
                               href="javascript:void(0)">
                                <i class="fal fa-bars"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-banner">
            <div class="container">
                <div class="row">
                    <div class="col-5">
                        <div class="banner-data text-center">
                            <div class="banner-data-main">
                                <img class="img-fluid" src="{{ site_path() }}/assets/images/demo/full-logo.png">
                            </div>
                            <div class="banner-data-vision">
                                <img class="img-fluid" src="{{ site_path() }}/assets/images/demo/vision.png">
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="banner-thumb">
                            <img class="img-fluid" src="{{ site_path() }}/assets/images/demo/banner-thumb.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <section id="header" class="donation text-center">
      <div class="container">

            <div class="sec-head text-center">
                <h3 class="sec-tit">
                 مرحبا بكم في منصة كساء
                </h3>
                <div class="sec-slogan">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <p>
                            مشروع جمع فائض الملابس والورق من المنازل وإعادة تدويرها لصالح جمعية حياتنا
                            </p>

                        </div>
                    </div>
                </div>
            </div>


          <a class="main-btn" target="_blank" href="https://wa.me/{{settings('whatsapp')}}">
              لطلب استلام التبرع
          </a>

      </div>
</section>

    <section id="about" class="about">
        <div class="container">
            <div class="sec-head text-center">
                <h3 class="sec-tit">
                    من نحن
                </h3>
                <div class="sec-slogan">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <p>
                                <?php $page = App\Models\Page::whereUrl('about')->first();
                                ?>
                                {!!  isset($page) ? $page->desc :  '' !!}
                            </p>
                            {{--<p>
                                على منصة واحدة تهدف لخدمة المجتمع والحفاظ على البيئه والصحة العامة
                            </p>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-data">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-6">
                        <div class="about-data-thumb text-center">
                            <img src="{{ site_path() }}/assets/images/demo/about-thumb.png">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="about-items">
                            <div class="about-item">
                                <div class="about-item-head d-flex align-items-center">
                                    <div class="about-item-icon">
                                        <img class="img-fluid" src="{{ site_path() }}/assets/images/demo/about-icon-01.png">
                                    </div>
                                    <h4 class="about-item-tit">رؤيتنا</h4>
                                </div>
                                <div class="about-item-body">
                                    <?php $page = App\Models\Page::whereUrl('vission')->first();
                                    ?>
                                    {!!  isset($page) ? $page->desc : '' !!}
                                </div>
                            </div>
                            <div class="about-item">
                                <div class="about-item-head d-flex align-items-center">
                                    <div class="about-item-icon">
                                        <img class="img-fluid" src="{{ site_path() }}/assets/images/demo/about-icon-02.png">
                                    </div>
                                    <h4 class="about-item-tit">رسالتنا</h4>
                                </div>
                                <div class="about-item-body">
                                    <?php $page = App\Models\Page::whereUrl('message')->first();
                                    ?>
                                    {!!  isset($page) ? $page->desc : '' !!}
                                </div>
                            </div>
                            <div class="about-item">
                                <div class="about-item-head d-flex align-items-center">
                                    <div class="about-item-icon">
                                        <img class="img-fluid" src="{{ site_path() }}/assets/images/demo/about-icon-03.png">
                                    </div>
                                    <h4 class="about-item-tit">اهدافنا</h4>
                                </div>
                                <div class="about-item-body">
                                    <?php $page = App\Models\Page::whereUrl('goals')->first();
                                    ?>
                                    {!!  isset($page) ? $page->desc : '' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="app-categories">
        <div class="container">
            <div class="row">
                @foreach(App\Models\Media_file::whereType('services')->get() as $item)
                    <div class="col-md-6">
                        <div class="app-cat-item d-flex align-items-center">
                            <div class="app-cat-item-icon">
                                <img class="img-fluid" src="{{ url('' . $item->image) }}">
                            </div>
                            <h4 class="app-cat-item-tit">
                                {{ $item->title }}
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="app-data">
        <div id="statics" class="app-lines">
            <div class="container">
                <div class="sec-head text-center">
                    <h3 class="sec-tit">
                        كساء في سطور
                    </h3>
                </div>
                <div class="app-statics">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="app-static-item text-center">
                                        <div class="app-static-item-num" data-count="{{settings('volunteers_count')}}">{{settings('volunteers_count')}}</div>
                                        <h4 class="app-static-item-tit">عدد المتطوعين</h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="app-static-item text-center">
                                        <div class="app-static-item-num" data-count="{{settings('beneficiaries_count')}}">{{settings('beneficiaries_count')}}</div>
                                        <h4 class="app-static-item-tit">عدد المستفيدين</h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="app-static-item text-center">
                                        <div class="app-static-item-num" data-count="{{settings('satisfaction_masure')}}">{{settings('satisfaction_masure')}}</div>
                                        <h4 class="app-static-item-tit">قياس الرضا</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="partners" class="app-partners">
            <div class="container">
                <div class="sec-head text-center">
                    <h3 class="sec-tit">
                        شركاء النجاح
                    </h3>
                </div>
                <div class="partners">
                    <div class="row justify-content-center">
                        @foreach(App\Models\Slider::whereType('partner')->get() as $item)
                            <div class="col-md-3 col-6">
                                <div class="partner-item">
                                    <img class="img-fluid" src="{{ url('' . $item->image) }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="videos" class="video">
          <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-8">
                  <iframe
                  src="{{ get_embed_link(settings('home_video')) }}?controls=0"
                  title="YouTube video player"
                  frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
          </div>
    </section>

    <section id="screens" class="app-screen">
        <div class="container">
            <div class="screenCarousel owl-carousel">
                @foreach (App\Models\Slider::whereType('static')->get() as $item)
                    <div class="screen-item">
                        <img src="{{ url('') . $item->image }}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="app-download">
        <div class="container">
            <div class="row align-items-center">
                <div id="downloads" class="col-md-6">
                    <div class="app-download-data">
                        <div class="app-download-logo">
                            <img class="img-fluid" src="{{ site_path() }}/assets/images/demo/full-logo.png">
                        </div>
                        <div class="app-download-urls">
                            <h4 class="app-download-urls-tit">حمل التطبيق الأن</h4>
                            <div class="app-download-urls-items">
                                <a href="{{ settings('android_link') }}">
                                    <img class="img-fluid" src="{{ site_path() }}/assets/images/googleplay.png">
                                </a>
                                <a href="{{ settings('ios_link') }}">
                                    <img class="img-fluid" src="{{ site_path() }}/assets/images/appstore.png">
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="app-download-screen">
                        <img class="img-fluid" src="{{ site_path() }}/assets/images/demo/app-download-screen.png">
                    </div>
                </div>
                <div id="contacts" class="col-md-12">
                    <div class="app-contact">
                          <div class="app-download-contact">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="app-download-contact-item d-flex align-items-center">
                                <div class="app-download-contact-item-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="app-download-contact-item-data">
                                    {{settings('address')}} {{-- الرياض - المملكة العربية السعودية --}}
                                </div>
                            </div>
                            </div>
                             <div class="col-md-4">
                                  <a class="app-download-contact-item d-flex align-items-center"
                               href="mailto:{{settings('email')}}">
                                <div class="app-download-contact-item-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="app-download-contact-item-data">
                                    {{settings('email')}} {{-- Kesaa.ksa@gmail.com --}}
                                </div>
                            </a>
                            </div>
                             <div class="col-md-4">
                                 <a class="app-download-contact-item d-flex align-items-center"
                               href="tel:{{settings('phone')}}">
                                <div class="app-download-contact-item-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="app-download-contact-item-data">
                                    {{settings('phone')}} {{-- 966550017660 --}}
                                </div>
                            </a>
                            </div>
                          <div class="col-md-4">
                                 <a class="app-download-contact-item d-flex align-items-center"
                               href="tel:{{settings('telephone')}}">
                                <div class="app-download-contact-item-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="app-download-contact-item-data">
                                    {{settings('telephone')}} {{-- 0112317343 --}}
                                </div>
                            </a>
                            </div>
                        </div>


                    </div>
                       <div class="social-media text-center">
                            <a href="{{ settings('facebook') }}"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ settings('twitter') }}"><i class="fab fa-twitter"></i></a>
                            <a href="{{ settings('instagram') }}"><i class="fab fa-instagram"></i></a>
                            <a href="{{ settings('linkedin') }}"><i class="fab fa-linkedin-in"></i></a>
                       </div>

                                 <div class="maroof text-center">
                            <a target="_blank"
                               href="{{ settings('maroof') }}">
                                <img class="img-fluid" src="{{ site_path() }}/assets/images/maroof.png">
                            </a>
                        </div>

                        </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="foot-copyright text-center">
               جميع الحقوق محفوظة
               |
                <a href="/">
                منصة كساء
                </a>
                |
                2022
                |
                تصميم شركة
                <a href="https://efadh.com">
                    إفادة لتقنية المعلومات
                </a>
            </div>
        </div>
    </footer>

</main>

<script src="{{ site_path() }}/assets/js/jquery-3.5.1.min.js"></script>
<script src="{{ site_path() }}/assets/js/popper.min.js"></script>
<script src="{{ site_path() }}/assets/js/bootstrap.min.js"></script>
<script src="{{ site_path() }}/assets/js/scrollreveal.min.js"></script>
<script src="{{ site_path() }}/assets/js/owl.carousel.min.js"></script>
<script src="{{ site_path() }}/assets/js/jquery.fancybox.js"></script>
<script src="{{ site_path() }}/assets/js/plugin.js"></script>
</body>
</html>
