<!DOCTYPE html>
@php
    $lang = App::getLocale() == 'en' ? 'en' : 'ar';
@endphp
<html lang="{{$lang}}"  @if ($lang == 'en') dir="ltr" @else dir="rtl"  @endif>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta name="description" content="{{ settings('description') }}">
        <meta name="keywords" content="{{ settings('key_words') }}">
        <meta name="author" content="Abdelrahman">
        <meta name="robots" content="index/follow">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport"
              content="width=device-width, initial-scale=1,, shrink-to-fit=no, maximum-scale=1, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <meta property="og:title" content="{{ settings('site_name') }}" />
        <meta property="og:image" content="{{ url('' . settings('logo')) }}" />
        <meta property="og:description" content="{{ settings('site_name') }}" />
        <meta property="og:site_name" content="{{ settings('site_name') }}" />
        <link rel="shortcut icon" type="image/png" href="{{ site_path() }}/images/favicon.jpg" />
        <title>{{ settings('site_name') }} | @yield('title')</title>
        <!-- Animate File Css Template -->
        <link rel="stylesheet" href="{{ site_path() }}/assets/css/animate.css"/>
        <!-- owl carousel Css File Template  -->
        <link rel="stylesheet" href="{{ site_path() }}/assets/css/owl.carousel.min.css"/>
        <!-- select2 css   -->

        <link rel="stylesheet" href="{{ site_path() }}/assets/css/select2.min.css"/>
        <!-- FontAwesome Css File Template  -->
        <link rel="stylesheet" href="{{ site_path() }}/assets/css/all.min.css"/>
{{--        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">--}}

        <!-- Bootstrap Css File Template  -->
        <link rel="stylesheet" href="{{ site_path() }}/assets/css/bootstrap.css"/>
        <!-- swiper Css File Template  -->
        <link rel="stylesheet" href="{{ site_path() }}/assets/css/swiper.css">
        <!-- Main Css File Template -->
        <link rel="stylesheet" href="{{ site_path() }}/assets/css/style.css"/>
        <link rel="stylesheet" href="{{ site_path() }}/assets/css/mainAhmed.css"/>
        <link rel="stylesheet" href="{{ asset('mainAhmed.css') }}"/>


        {{-- DatePicker --}}
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        @yield('style')

    </head>
    <body>
        <div class="sidebar_pagebody">
        <div class="sidebar d-xl-none">
            <div class="menu-icons close-me">
                <label for="check-close">
                    <input type="checkbox" id="check-close"/>
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>
            <ul class="nav-list list-unstyled">
                <li class="linkMenu menu-item active">
                    <a href="index.html">الرئيسية </a>
                </li>
                <li class="linkMenu menu-item">
                    <a href="/">البحث</a>
                </li>
                <li class="linkMenu menu-item">
                    <a href="/">الزيارات</a>
                </li>
                <li class="linkMenu menu-item menu-item-has-children">
                    <a href="/">الإعجاب</a>
                    <i class="fa-solid fa-plus dd-trigger"></i>
                    <ul class="sub-menu">
                        <li>
                            <a href="#" class="">عنصر</a>
                        </li>
                        <li>
                            <a href="#" class="">عنصر</a>
                        </li>
                        <li>
                            <a href="#" class="">عنصر</a>
                        </li>
                    </ul>
                </li>
                <li class="linkMenu menu-item">
                    <a href="/">الرسائل</a>
                </li>
                <li class="linkMenu menu-item">
                    <a href="/">الدردشة</a>
                </li>
                <li class="linkMenu menu-item">
                    <a href="/">راسل الإدارة</a>
                </li>
            </ul>
            <div class="hold-register-btns">
                <div class="register-btn">
                    <a href="#" class="btn btn-secondary">
                        <img src="{{ site_path() }}/assets/img/ring.png" alt="">
                        تسجيل دخول
                    </a>
                </div>
                <div class="register-btn">
                    <a href="#" class="btn btn-secondary">
                        <img src="{{ site_path() }}/assets/img/ring.png" alt="">
                        مستخدم جديد
                    </a>
                </div>
            </div>
        </div>
        <main id="bodyWrap">
            <!-- header -->
            <header class="header-home">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="index.html" class="menu-logo text-center">
                            <div>
                                <img src="{{ site_path() }}/assets/img/logo.png" alt="الشعار" class="img-fluid logo"
                                />
                            </div>
                        </a>
                        <nav>
                            <ul class="nav-list d-flex align-items-center">
                                <li class="linkMenu active">
                                    <a href="index.html">الرئيسية</a>
                                </li>
                                <li class="linkMenu">
                                    <a href="/">البحث</a>
                                </li>
                                <li class="linkMenu">
                                    <a href="/">الزيارات</a>
                                </li>
                                <li class="linkMenu menu-item-has-children">
                                    <a href="/">الإعجاب</a>
                                    <i class="fa-solid fa-angle-down dd-trigger"></i>
                                    <ul class="sub-menu">
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="#" class="">عنصر</a>
                                            </li>
                                            <li>
                                                <a href="#" class="">عنصر</a>
                                            </li>
                                            <li>
                                                <a href="#" class="">عنصر</a>
                                            </li>
                                        </ul>
                                    </ul>
                                </li>
                                <li class="linkMenu">
                                    <a href="/">الرسائل</a>
                                </li>
                                <li class="linkMenu">
                                    <a href="/">الدردشة</a>
                                </li>
                                <li class="linkMenu">
                                    <a href="/">راسل الإدارة</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="hold-register-btns">
                            <div class="register-btn d-xl-block d-sm-none">
                                <a href="#" class="btn btn-secondary">
                                    <img src="{{ site_path() }}/assets/img/ring.png" alt="">
                                    تسجيل دخول
                                </a>
                            </div>
                            <div class="dropdown register-btn d-xl-block d-sm-none">
                                <a href="#" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ site_path() }}/assets/img/ring.png" alt="">
                                    مستخدم جديد
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <a href="#" class="dropdown-item" type="button">حسابي</a>
                                    <a href="#" class="dropdown-item" type="button">بياناتي</a>
                                    <a href="#" class="dropdown-item" type="button">تسجيل دخول</a>
                                </div>
                            </div>
                            <div class="menu-icons open-me">
                                <label for="check">
                                    <input type="checkbox" id="check"/>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- /header -->

            @include('msg')
            @yield('content')

            <!-- footer  -->
            <footer>
                <div class="container">
                    <div class="footer-logo">
                        <img src="{{ site_path() }}/assets/img/footerlogo.png" alt="">
                    </div>
                    <div class="footer-content">
                        <p>
                            هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                            الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم
                            لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد
                            محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء.
                        </p>
                    </div>
                    <div class="footer-links">
                        <span>
                            <a href="#">
                                <img src="{{ site_path() }}/assets/img/footer1.png" alt="">
                                راسل الإدارة
                            </a>
                        </span>
                        <span>
                            <a href="#">
                                <img src="{{ site_path() }}/assets/img/footer2.png" alt="">
                                الأسئلة المتداولة
                            </a>
                        </span>
                        <span>
                            <a href="#">
                                <img src="{{ site_path() }}/assets/img/footer3.png" alt="">
                                نصائح واقتراحات
                            </a>
                        </span>
                        <span>
                            <a href="#">
                                <img src="{{ site_path() }}/assets/img/footer4.png" alt="">
                                تحذيرات الأمان
                            </a>
                        </span>
                        <span>
                            <a href="#">
                                <img src="{{ site_path() }}/assets/img/footer5.png" alt="">
                                شروط الاستخدام
                            </a>
                        </span>
                        <span>
                            <a href="#">
                                <img src="{{ site_path() }}/assets/img/footer6.png" alt="">
                                سياسة الخصوصية
                            </a>
                        </span>
                    </div>
                    <div class="copyWrite">
                        جميع الحقوق محفوظة 2024
                        <a href="#">
                            زواج تبوك
                        </a>
                    </div>
                </div>
            </footer>
            <!-- //footer  -->
        </main>
    </div>
    </body>

    <!-- JQuery JS File Template -->
    <script src="{{ site_path() }}/assets/js/jquery-3.6.0.min.js"></script>
    <!-- Popper JS File Template -->
    <script src="{{ site_path() }}/assets/js/popper.min.js"></script>
    <!-- waypoints for counter plugin  -->
    <script src="{{ site_path() }}/assets/js/jquery.waypoints.min.js"></script>
    <!-- owl carousel plugin -->
    <script src="{{ site_path() }}/assets/js/owl.carousel.min.js"></script>
    <!-- Bootstrap File Template  -->
    <script src="{{ site_path() }}/assets/js/bootstrap.js"></script>
    <!-- Swiper JS File Template -->
    <script src="{{ site_path() }}/assets/js/swiper.js"></script>
    <!-- Scroll Reveal JS File Template -->
    <script src="{{ site_path() }}/assets/js/scrollReveal.js"></script>
    <!-- WOW js -->
    <script src="{{ site_path() }}/assets/js/wow.js"></script>
    <!-- Main JS File Template -->
    <script src="{{ site_path() }}/assets/js/plugin.js"></script>

    <!-- Notify Js -->
    <script src="{{ url('/') }}/public/notify.js"></script>

    <!-- datepickerscript.js -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                //minDate:0,
                //startDate:new Date(),
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: '1950:' + (new Date().getFullYear() + 100)
            });
        });

        $( function() {
            $( ".date" ).datepicker({
                minDate:0,
                startDate:new Date(),
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true
            });
        });

        $( function() {
            $( ".old-date" ).datepicker({
                maxDate:0,
                startDate:new Date(),
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true
            });
        });
    </script>

    <script>
        function addService() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('site_sendcontact') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addServiceForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "top"
                            }
                        );
                    }else{
                        // $.notify(msg.msg, 'success');
                        alert(msg.msg);
                        $('.inputs').val('');
                    }
                }
            });
        }

        $(document).ready(function() {
            // Notify Js
            var type = $('#alertType').val();
            if (type != '0') {
                var theme = $('#alertTheme').val();
                var message = $('#alertMessage').val();
                $.notify(message, theme);
            }

            // allow number only in inputs has class phone
            $(".phone").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode >
                    105)) {
                    e.preventDefault();
                }
            });
        });
    </script>

    @yield('script')
</html>

