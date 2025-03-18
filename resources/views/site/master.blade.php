<!DOCTYPE html>
@php
    $lang = App::getLocale() == 'en' ? 'en' : 'ar';
@endphp
<html lang="{{ $lang }}" @if ($lang == 'en') dir="ltr" @else dir="rtl" @endif>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
        content="width=device-width, initial-scale=1,, shrink-to-fit=no, maximum-scale=1, user-scalable=no">
    <meta name="HandheldFriendly" content="true">

    @yield('meta')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="/site/assets/normal-favicon.png" />
    <title>{{ settings('site_name') }} | @yield('title')</title>
    <!-- Animate File Css Template -->
    <link rel="stylesheet" href="{{ site_path() }}/assets/css/animate.css" />

    <!-- owl carousel Css File Template  -->
    <link rel="stylesheet" href="{{ site_path() }}/assets/css/owl.carousel.min.css" />
    <!-- select2 css   -->
    <link rel="stylesheet" href="{{ site_path() }}/assets/css/select2.min.css" />
    <!-- FontAwesome Css File Template  -->


    <link rel="stylesheet" href="{{ site_path() }}/assets/css/all.min.css" />



    <!-- Bootstrap Css File Template  -->
    <link rel="stylesheet" href="{{ site_path() }}/assets/css/bootstrap.css" />
    <!-- swiper Css File Template  -->
    <link rel="stylesheet" href="{{ site_path() }}/assets/css/swiper.css">
    <!-- Main Css File Template -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css">

    <link rel="stylesheet" href="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick-theme.css">

    <link rel="stylesheet" href="{{ site_path() }}/assets/css/style.css" />


    {{-- DatePicker --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- sweetalert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        /* Position the sidebar absolutely to overlay the body content */
        /* Position the sidebar absolutely to overlay the body content */
        /* Ensure the sidebar is positioned fixed and doesn't affect the layout */
        /* Sidebar Style */
        .sidebar {
            position: fixed;
            top: 0;
            right: -250px;
            /* Sidebar is off-screen initially */
            height: 100%;
            width: 250px;
            /* Width of the sidebar */
            /* Sidebar color */
            z-index: 1050;
            /* Ensure sidebar is above the page */
            transition: right 0.3s ease;
            /* Smooth transition */
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            /* Optional sidebar shadow */
        }

        /* When the sidebar is open, move it into view */
        .sidebar.open {
            right: 0;
            /* Move sidebar to the right side */
        }

        /* Prevent the body from shifting when the sidebar opens */
        body.menu-open {
            overflow: hidden;
            /* Disable body scroll */
        }

        /* Optional: You can apply a dark overlay when the menu is open */
        body.menu-open::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent overlay */
            z-index: 1049;
            /* Background overlay below the sidebar */
        }

        /* Ensure the sidebar toggle doesn't affect the body layout */
        body {
            margin-right: 0 !important;
            /* Reset any margin change */
            overflow-x: hidden;
            /* Prevent horizontal scrolling */
        }

        /* Optional: Ensure that the page content cannot be clicked when the menu is open */
        body.menu-open .content {
            pointer-events: none;
        }



        /* You may need to add styles to your menu button if needed */
        .menu-icons label {
            cursor: pointer;
        }

        #search {
            scroll-margin-top: 100px;
            /* تعديل هذه القيمة للتحكم بالمسافة */
        }

        .modal-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-body a {
            width: 100%;
            padding: 10px;
            background-color: var(--main);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }

        .modal-body a:hover {
            background-color: var(--sec);
        }

        .modal-body img {
            width: 75px;
            height: auto;
            margin-right: 10px;
        }

        .modal-body p {
            font-size: 18px;
            font-weight: bold;
            color: #000;
        }

        .modal-footer {
            justify-content: center;
        }

        .modal-header,
        .modal-footer {
            border: none;
        }

        .modal-backdrop {
            z-index: 0 !important;
        }
        .red-dot {
            position: absolute;
            top: 5px; /* Adjust to your preference */
            right: 5px; /* Adjust to your preference */
            width: 10px;
            height: 10px;
            background-color: red;
            border-radius: 50%;
            z-index: 10; /* Ensure it appears in front */
        }
        .has-unread {
            display: block !important;
        }


.footer-links {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end; /* Align to the right (RTL) */
    gap: 15px;
    padding: 10px;
    text-align: right;
}

.footer-links a {
    display: flex;
    align-items: center;
    justify-content: right;
    gap: 0px;
    font-size: 16px;
    color: white;
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    width: 220px; /* Fixed width for proper alignment */
}

.footer-links a img {
    width: 24px;
    height: 24px;
    flex-shrink: 0; /* Prevents icons from resizing */
}

.footer-links a span {
    flex-grow: 1; /* Ensures text aligns in one line */
    white-space: nowrap; /* Prevents text from wrapping */
}

/* Hover Effects */
.footer-links a:hover {
    color: #b72dd2;
    transform: scale(1.05);
}

.footer-links a:hover img {
    transform: rotate(10deg);
}

/* 📱 Mobile Responsive: Keep alignment & two columns */
@media (max-width: 768px) {
    .footer-links {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .footer-links a {
        width: 100%; /* Make it responsive inside grid */
        justify-content: flex-start;
        gap: 0px;
    }

    .footer-links a img {
        width: 20px; /* Slightly smaller icons for mobile */
        height: 20px;
    }

    .footer-links a span {
        text-align: right; /* Ensure text is aligned properly */
        width: 100%;
    }
}

/* Paination */
    .page-link {
        color: #c930e8
    }
    .page-item.active .page-link{
        background-color: #c930e8;
        border-color: #c930e8
    }
    .disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    </style>
    @yield('style')

    {!! settings('google_search') !!}

    {!! settings('google_tags') !!}
    {!! settings('google_ads') !!}
    @vite(['resources/js/app.js'])

    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-39TXG0SLE4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-39TXG0SLE4');
</script>
</head>

<body>
    {{-- phone sidebar --}}
    <div class="sidebar_pagebody">
        <div class="sidebar d-xl-none">
            <div class="menu-icons close-me">
                <label for="check-close">
                    <input type="checkbox" id="check-close" />
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>

            <ul class="nav-list list-unstyled">
                <li class="linkMenu menu-item linkMenuHome">
                    <a href="{{ route('site_home') }}">الرئيسية</a>
                </li>

                @if (auth()->check() && auth()->user()->user_type == 'client')
                    <li class="linkMenu menu-item linkMenuSearch">
                        <a href="{{ auth()->check() ? url('search') : url('log-in') }}">البحث</a>
                    </li>
                    <li class="linkMenu menu-item linkMenuVisitor">
                        <a href="{{ url('all_visitor_clients') }}">الزيارات</a>
                    </li>
                    <li class="linkMenu menu-item linkMenuFav">
                        <a href="{{ url('all_fav_clients') }}">الاعجاب</a>
                    </li>
                    <!---
                <li class="linkMenu menu-item linkMenuBlocked">
                    <a href="{{ url('all_blocked_clients') }}">
                        <i class="fa-solid fa-list"></i>
                        قائمة التجاهل
                    </a>
                </li>
                -->
                    <li class="linkMenu menu-item menu-item-border linkMenuEnvelope">
                        <a href="{{ url('all_rooms') }}">الرسائل</a>
                    </li>
                    <li class="linkMenu menu-item menu-item-border linkMenuNotification">
                        <a href="{{ url('notifications') }}">
                            الاشعارات
                            <span id="notification-icon" class="red-dot" style="display: none;"></span>
                        </a>
                    </li>
                    <li class="linkMenu menu-item linkMenuProfile">
                        <a href="{{ route('site_profile') }}">حسابي</a>
                    </li>
                @endif

                @if (!auth()->check())
                    <li class="linkMenu menu-item linkContactUs">
                        <a href="{{ route('page', 'about') }}">من نحن</a>
                    </li>
                @endif
                <li class="linkMenu menu-item linkContactUs">
                    <a href="{{ route('contact_us', 'contact') }}">راسل الإدارة</a>
                </li>
                @if (!auth()->check())
                    <li class="linkMenu menu-item linkContactUs">
                        <a href="{{ url('questions') }}">الاسئلة المتداولة</a>
                    </li>
                @endif

                @if (auth()->check())
                    <li class="linkMenu menu-item linkMenuLogout">
                        <a href="{{ route('site_logout') }}" class="linkMenuLogout">
                            الخروج
                        </a>
                    </li>
                @endif
            </ul>

            <div class="hold-register-btns">
                @if (!auth()->check())
                    <div class="register-btn">
                        <a href="{{ route('site_login') }}" class="btn btn-secondary">
                            <img src="{{ site_path() }}/assets/img/ring.png" alt="">
                            تسجيل دخول
                        </a>
                    </div>
                    <!-- <div class="register-btn">
                        <a href="{{ route('site_register') }}" class="btn btn-secondary">
                            <img src="{{ site_path() }}/assets/img/ring.png" alt="">
                            مستخدم جديد
                        </a>
                    </div> -->
                @else
                    <!--
                <div class="register-btn">
                    <a href="{{ route('site_logout') }}" class="btn linkMenuLogout btn-secondary">
                        الخروج
                    </a>
                </div>
                -->
                @endif

            </div>
        </div>
    </div>

    <main id="bodyWrap">

        <!-- header -->
        <header class="header-home">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('site_home') }}" class="menu-logo text-center">
                        <div>
                            <img   src="{{ url('' . settings('logo')) }}" alt="الشعار" />
                        </div>
                    </a>
                    <nav>
                        <ul class="nav-list d-flex align-items-center">
                            <li class="linkMenu <!--active--> d-flex align-items-center flex-column">
                                <a href="{{ route('site_home') }}">
                                    <i class="fa-solid fa-house"></i>

                                    الرئيسية

                                </a>

                            </li>

                            @if (auth()->check() && auth()->user()->user_type == 'client')
                                <li class="linkMenu d-flex align-items-center flex-column">

                                    <a href="{{ auth()->check() ? url('search') : url('log-in') }}">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        البحث
                                    </a>
                                </li>

                                <li class="linkMenu  d-flex align-items-center flex-column">

                                    <a href="{{ url('all_visitor_clients') }}">
                                        <i class="fa-solid fa-eye"></i>
                                        الزيارات
                                    </a>
                                </li>
                                <li class="linkMenu d-flex align-items-center flex-column">
                                    <a href="{{ url('all_fav_clients') }}">
                                        <i class="fa-solid fa-heart"></i>
                                        الإعجابات
                                    </a>
                                </li>

                                <li class="linkMenu d-flex align-items-center flex-column">

                                    <a href="{{ url('all_rooms') }}">
                                        <i class="fa-solid fa-envelope"></i>
                                        الرسايل

                                    </a>
                                </li>
                                <li class="linkMenu d-flex align-items-center flex-column">
                                    <a href="{{ url('notifications') }}">
                                        <i class="fa-solid fa-bell"></i>
                                        الاشعارات
                                        <span id="notification-icon" class="red-dot" style="display: none;"></span>
                                    </a>
                                </li>
                            @endif

                            {{-- @if (auth()->check()) --}}
                            {{-- <li class="linkMenu">
                                <a href="{{url('all_visitor_clients')}}">الزيارات</a>
                            </li>
                            <li class="linkMenu">
                                <a href="{{url('all_fav_clients')}}">الإعجابات</a>
                            </li>
                            <li class="linkMenu">
                                <a href="{{url('all_blocked_clients')}}">قائمة التجاهل</a>
                            </li>

                            <li class="linkMenu">
                                <a href="{{url('all_rooms')}}">الرسائل</a>
                            </li> --}}
                            {{-- <li class="linkMenu">
                                <a href="/">الدردشة</a>
                            </li> --}}
                            {{-- @endif --}}
                            {{-- <li class="linkMenu menu-item-has-children">
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
                            </li> --}}

                            @if (!auth()->check())
                                <li class="linkMenu d-flex align-items-center flex-column">

                                    <a href="{{ route('page', 'about') }}">
                                        <i class="fa-solid fa-address-card"></i>
                                        من نحن

                                    </a>
                                </li>
                                <li class="linkMenu  d-flex align-items-center flex-column">

                                    <a href="{{ route('contact_us', 'contact') }}">
                                        <i class="fa-solid fa-phone"></i>
                                        راسل الإدارة
                                    </a>
                                </li>
                                <li class="linkMenu  d-flex align-items-center flex-column">

                                    <a href="{{ url('questions') }}">
                                        <i class="fa-solid fa-question"></i>
                                        الاسئلة المتداولة
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                    <div class="hold-register-btns">
                        @if (!auth()->check())
                            <div class="row pl-2">
                                <div class="register-btn d-xl-block d-sm-block pl-1">

                                    <a href="{{ route('site_login') }}" class="btn btn-secondary">

                                        <space style="font-size:15px;"> تسجيل دخول </space>
                                    </a>

                                </div>

                                <div class="register-btn d-xl-block d-sm-block">

                                    <a href="{{ route('site_register') }}" class="btn btn-secondary">

                                        <space style="font-size:15px;"> تسجيل جديد </space>
                                    </a>

                                </div>
                            </div>
                        @else
                            <div class="dropdown register-btn d-xl-block d-sm-none pl-3">
                                <a href="#" class="btn btn-secondary p-2" type="button" id="dropdownMenu2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ site_path() }}/assets/img/arrow2.png" style="width:18px"
                                        alt="">
                                    <space style="font-size:18px;"> {{ auth()->user()->first_name }} </space>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <a href="{{ route('site_profile') }}" class="dropdown-item"
                                        type="button">حسابي</a>
                                    <a href="{{ url('show_client/' . auth()->id()) }}" class="dropdown-item"
                                        type="button">صفحتي الشخصية</a>
                                    <a href="{{ route('site_logout') }}" class="dropdown-item" type="button">تسجيل
                                        الخروج</a>
                                </div>
                            </div>
                        @endif

                        @if (auth()->check())
                            <div class="menu-icons open-me">
                                <label for="check">
                                    <input type="checkbox" id="check" />
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </label>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </header>
        <!-- /header -->

        @include('msg')
        @yield('content')

        <!-- Modal -->
        <input type="hidden" id="show_package"
            value="{{ Session::has('package_alert') ? Session::get('package_alert') : '0' }}">
        <div class="modal-prem">
            <div class="container">
                <!-- Button trigger modal -->

                <div class="buttons">
                    <button type="button" class="" id="myModalBtn" style="display: none" data-toggle="modal"
                        data-target="#myModal">
                        ﺗﺮﻗﻴﺔ اﻟﻌﻀﻮﻳﺔ
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <button type="button" class="close text-right" style="opacity: 1" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="modal-header     justify-content-center">
                                <h2 class="modal-title sec-tit text-center" id="exampleModalLabel">ﺗﺮﻗﻴﺔ اﻟﻌﻀﻮﻳﺔ</h2>
                            </div>
                            <div class="modal-body text-center">

                                <!-- Description -->
                                <p> ﻟﻜﻲ ﺗﺘﻤﻜﻦ ﻣﻦ اﻻﺳﺘﻔﺎدة ﻣﻦ ﺟﻤﻴﻊ ﺧﺪﻣﺎت اﻟﻤﻮﻗﻊ</p>
                                <!-- Image -->
                                <img src="{{ site_path() }}/assets/img/gold.png" alt="">

                                <!-- Button -->
                            </div>
                            <a href="{{ url('all_packages') }}" class="next-btn">
                                <span>ترقيه</span>
                                <i class="fa-solid fa-left-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer  -->
        <footer>
            <div class="container-footer">
                <div class="footer-logo">
                    <img src="{{ url('' . settings('logo_footer')) }}" alt="Logo">
                </div>
                <div class="footer-content">
          <p>تأسست منصة سعودي زواج لتسهيل عملية البحث عن شريك الحياة مع توفير بيئة تجمع بين الأمان والثقة، هدفنا هو تمكين الأفراد من بناء حياة زوجية سعيدة ومستقرة بخطوات بسيطة وخدمة متخصصة.</p>
                </div>

<div class="container-footer2">
<div class="footer-links">
<a href="{{ route('contact_us', 'contact') }}">
<img src="{{ site_path() }}/assets/img/icons/footer/contact.png" alt="Contact">
راسل الإدارة
</a>
<a href="{{ url('questions') }}">
<img src="{{ site_path() }}/assets/img/icons/footer/qa.png" alt="FAQ">
الأسئلة المتداولة
</a>
<a href="{{ route('page', 'advices') }}">
<img src="{{ site_path() }}/assets/img/icons/footer/advices.png" alt="Advices">
نصائح واقتراحات
</a>
<a href="{{ url('pages/security-en') }}">
<img src="{{ site_path() }}/assets/img/icons/footer/warnnings.png" alt="Security Warnings">
إرشادات الأمان
</a>
<a href="{{ url('pages/condition-en') }}">
<img src="{{ site_path() }}/assets/img/icons/footer/contract.png" alt="Terms of Use">
شروط الاستخدام
</a>
<a href="{{ url('pages/privacy-en') }}">
<img src="{{ site_path() }}/assets/img/icons/footer/privacy.png" alt="Privacy Policy">
Privacy Policy
</a>
<a href="{{ url('media-center/news') }}">
<img src="{{ site_path() }}/assets/img/icons/footer/blog.png" alt="Blog">
المدونة
</a>
<a href="{{ route('page','about') }}">
<img src="{{ site_path() }}/assets/img/icons/footer/about.png" alt="About">
من نحن
</a>

</div>
</div>

            </div>

            <!-- Social Media Links Section -->
            <div class="social-media">
                <a href="https://x.com/sazawaj" target="_blank" class="social-icon twitter"></a>
                <a href="https://www.tiktok.com/@sazawaj" target="_blank" class="social-icon tiktok"></a>
                <a href="https://www.snapchat.com/add/sazawaj" target="_blank" class="social-icon snapchat"></a>
                <a href="https://www.facebook.com/sazawaj/" target="_blank" class="social-icon facebook"></a>
            </div>


            <div class="copyWrite">
                جميع الحقوق محفوظة 2025
                <a href="{{ route('site_home') }}">
                    {{ settings('site_name') }}
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- owl carousel plugin -->
<script src="{{ site_path() }}/assets/js/owl.carousel.min.js"></script>
<!-- Bootstrap File Template  -->
<script src="{{ site_path() }}/assets/js/bootstrap.js"></script>
<!-- Swiper JS File Template -->
<script src="{{ site_path() }}/assets/js/swiper.js"></script>
<script >
    // Store original favicon
    let originalFavicon = document.querySelector("link[rel='shortcut icon']").getAttribute("href");
    let notificationFavicon = '{{ url('' . settings('notification-logo')) }}'; // Change to favicon with a red dot
    //check whether the user having an unread notification
    $.ajax({
                type: 'get',
                url: '{{ route('notificationsCount') }}',
                datatype: 'json',
                async: true,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(msg) {
                    if (msg.count > '0') {
                        document.querySelectorAll("#notification-icon").forEach(item => {
                            console.log(item);
                            item.classList.add("has-unread");
                        });
                    }
                }
            });
    window.onload = function() {
        @if(Auth::check())

            const user = JSON.parse('{!! json_encode(auth()->user()) !!}');
            Echo.private(`App.Models.User.${user.id}`)
                .listen('.notification', (data) => {
                    notificationSound.play(); // Play sound
                    handleNotification(data.type);
                    changeFavicon(notificationFavicon); // change fav icon
                });
        @endif
    };
    let notificationSound = new Audio("{{ site_path() }}/assets/sound/notification-sound.mp3");

    // handleNotification: function used to handle different types of notifications.
    function handleNotification(type) {

        switch (type) {
            case "App\\Notifications\\NewMessageNotification":
                document.getElementById("message-icon").classList.add("has-unread");
                let messageCounter = parseInt(document.getElementById("messageCounter").innerText);
                messageCounter = messageCounter + 1;
                document.getElementById("messageCounter").innerText = messageCounter ;
                break;
            case "App\\Notifications\\ProfileSeenNotification":
                document.getElementById("visitor-icon").classList.add("has-unread");
                let visitorCounter = parseInt(document.getElementById("visitorCounter").innerText);
                visitorCounter = visitorCounter + 1;
                document.getElementById("visitorCounter").innerText = visitorCounter ;
                break;
            case"App\\Notifications\\AddToFavouriteNotification":
                document.getElementById("liker-icon").classList.add("has-unread");
                let likerCounter = parseInt(document.getElementById("likerCounter").innerText);
                likerCounter = likerCounter + 1;
                document.getElementById("likerCounter").innerText = likerCounter ;
                break;
            default:
                document.querySelectorAll("#notification-icon").forEach(item => {
                    console.log(item);
                    item.classList.add("has-unread");
                });
                break;
        }
    }
    // Function to change the favicon
    function changeFavicon(iconURL) {
        let link = document.querySelector("link[rel='shortcut icon']");
        if (!link) {
            link = document.createElement("link");
            link.rel = "icon";
            document.head.appendChild(link);
        }
        link.href = iconURL;
    }

    // Remove red dot when the tab is focused again
    document.addEventListener("visibilitychange", function () {
        if (!document.hidden) {
            changeFavicon(originalFavicon);
        }
    });
</script>



<script src="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js"></script>
<!-- Scroll Reveal JS File Template -->
<script src="{{ site_path() }}/assets/js/scrollreveal.js"></script>
<!-- WOW js -->
<script src="{{ site_path() }}/assets/js/wow.js"></script>
<!-- Main JS File Template -->
<script src="{{ site_path() }}/assets/js/plugin.js"></script>

<!-- Notify Js -->
<script src="{{asset('notify.js')}}"></script>
<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>

{{-- FireBase --}}
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js"></script>
{{-- <script src="{{url('/')}}/firebase-messaging-sw.js"></script> --}}

<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-firestore.js"></script>
{{-- <script src="https://www.gstatic.com/firebasejs/4.9.1/firebase.js"></script> --}}

<!-- <script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyD5Zel3IFe5N-47GYIQ_eykOZDvyYqJPnU",
        authDomain: "sazawaj-5dd68.firebaseapp.com",
        projectId: "sazawaj-5dd68",
        storageBucket: "sazawaj-5dd68.firebasestorage.app",
        messagingSenderId: "992228798032",
        appId: "1:992228798032:web:553b8f0450680239ddab55",
        measurementId: "G-TXBC6CQPME"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();

    // Retrieve Firebase Messaging object.
    const messaging = firebase.messaging();
    window.fcmMessageing = messaging;
    // Add the public key generated from the console here.
    messaging.usePublicVapidKey(
        "BGidWSpMQiKt_YpwqD9gX97VRbckOHAAv1zPWK5gyCUKe_tPHNGvDUU8itf8QK2kkiJP1uWWJy36Hfqtuca48yg");

    Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {
            console.log('Notification permission granted.');
        } else {
            console.log('Unable to get permission to notify.');
        }
    });

    messaging.getToken().then((currentToken) => {
        if (currentToken) {
            console.log(currentToken);
            $('#device_id').val(currentToken);
            localStorage.setItem('device_id', currentToken);
        } else {
            console.log('No Instance ID token available. Request permission to generate one.');
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
    });


    // Callback fired if Instance ID token is updated.
    // messaging.onTokenRefresh(() => {
    //     messaging.getToken().then((refreshedToken) => {
    //         console.log('Token refreshed.');
    //     }).catch((err) => {
    //         console.log('Unable to retrieve refreshed token ', err);
    //     });
    // });

    messaging.onMessage((payload) => {
        let title = payload.notification.title;
        let body = payload.notification.body;

        // عرض التنبيه مع زرارين
        Swal.fire({
            title: title,
            text: body,
            icon: 'info',
            showCancelButton: true, // عرض زر الإلغاء
            confirmButtonText: 'اذهب الآن',
            cancelButtonText: 'ليس الآن',
        }).then((result) => {
            // إذا ضغط المستخدم "اذهب الآن"
            if (result.isConfirmed) {
                const actionUrl = payload.data.action_url || '/';
                window.location.href = actionUrl; // الانتقال إلى الرابط المحدد
            } else {
                // إذا ضغط "ليس الآن" فقط يغلق التنبيه
                Swal.close(); // إغلاق الـ SweetAlert
            }
        });

        // فحص قيمة click_action في بيانات الإشعار
        const clickAction = payload.data.click_action;
        if (clickAction === 'TOP_STORY_ACTIVITY') {
            // إجراء إضافي إذا كان click_action يعادل 'TOP_STORY_ACTIVITY'
            console.log('إجراء خاص ب TOP_STORY_ACTIVITY');
        }
    });
</script> -->

<link rel="manifest" href="{{ url('/') }}/manifest.json">

<!-- datepickerscript.js -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script>
    $(function() {
        $(".datepicker").datepicker({
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

    $(function() {
        $(".date").datepicker({
            minDate: 0,
            startDate: new Date(),
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });
    });

    $(function() {
        $(".old-date").datepicker({
            maxDate: 0,
            startDate: new Date(),
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
            type: 'POST',
            url: '{{ route('site_sendcontact') }}',
            datatype: 'json',
            async: false,
            processData: false,
            contentType: false,
            data: new FormData($("#addServiceForm")[0]),
            success: function(msg) {
                if (msg.value == '0') {
                    $('.save').notify(
                        msg.msg, {
                            position: "top"
                        }
                    );
                } else {
                    // $.notify(msg.msg, 'success');
                    alert(msg.msg);
                    $('.inputs').val('');
                }
            }
        });
    }

    $(document).ready(function() {
        // Notify Js
        let show_package = $('#show_package').val();
        // alert(show_package);
        if (show_package == '1') {
            $('#myModalBtn').trigger('click');
        }

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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.querySelector('.menu-icons label');
        const sidebar = document.querySelector('.sidebar');
        const body = document.body;

        menuButton.addEventListener('click', function() {
            // Toggle the 'open' class to slide in/out the sidebar
            sidebar.classList.toggle('open');

            // Toggle the 'menu-open' class to disable body scrolling
            body.classList.toggle('menu-open');
        });
    });
</script>



@yield('script')

</html>
