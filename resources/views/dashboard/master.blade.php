<!DOCTYPE html>
<html @if (App::getLocale() == 'en') lang="en" @else lang="ar" @endif>

<head>
    <meta charset="UTF-8">
    {{-- <meta name="description" content="{{settings('description')}}"> --}}
    {{-- <meta name="keywords" content="{{settings('key_words')}}"> --}}
    <meta name="author" content="Abdelrahman">
    <meta name="robots" content="index/follow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
        content="width=device-width, initial-scale=1,, shrink-to-fit=no, maximum-scale=1, user-scalable=no">
    <meta name="HandheldFriendly" content="true">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta property="og:title" content="{{settings('site_name')}}" /> --}}
    {{-- <meta property="og:image" content="{{ url('' . settings('logo')) }}" /> --}}
    {{-- <meta property="og:description" content="{{settings('site_name')}}" /> --}}
    {{-- <meta property="og:site_name" content="{{settings('site_name')}}" /> --}}
    {{-- <link rel="shortcut icon" type="image/png" href="{{site_path()}}/images/favicon.jpg" /> --}}

    <title>{{ settings('site_name') }} | @yield('title')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ dashboard_path() }}/plugins/fontawesome-free/css/all.min.css">
    <!-- drop -->
    <link rel="stylesheet" href="{{ dashboard_path() }}/plugins/dropify/css/dropify.min.css">
    <link rel="stylesheet" href="{{ dashboard_path() }}/plugins/summernote/summernote-bs4.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ dashboard_path() }}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- DataTables buttons-->
    <link rel="stylesheet" href="{{ dashboard_path() }}/plugins/datatables-buttons/css/buttons.bootstrap4.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ dashboard_path() }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ dashboard_path() }}/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ dashboard_path() }}/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ dashboard_path() }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ dashboard_path() }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="{{ dashboard_path() }}/dist/css/style.css">

    <link href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
    {{--<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css">--}}
    <!-- sweetalert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.min.css" rel="stylesheet">
    @vite(['resources/js/app.js'])
    @yield('style')
    <style>
        #notification-dropdown-menu {
            word-wrap: break-word; /* Ensure words wrap properly */
            overflow: hidden;
        }

        /* Ensure each notification wraps correctly */
        .notification-item {
            white-space: normal; /* Allow wrapping */
            word-break: break-word; /* Break long words */
            display: block; /* Make sure it behaves like a block */
            padding-right: 10px; /* Add padding to avoid touching edges */
            max-width: 100%; /* Prevent exceeding dropdown width */
        }

        /* Ensure the text wraps to the next line if it's too long */
        .notification-text {
            white-space: normal; /* Allows wrapping */
            word-break: break-word; /* Ensures words break if necessary */
            max-width: 100%; /* Prevents overflow */
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-sm-inline-block">
                    <a href="{{ route('admin_logout') }}" class="nav-link">تسجيل الخروج</a>
                </li> 
            </ul>

            <!-- SEARCH FORM -->
            {{-- <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="{{Translate('بحث')}}" aria-label="Search">
                    <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    </div>
                </div>
                </form> --}}

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                        <img src="{{dashboard_path()}}/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                            Brad Diesel
                            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                        <img src="{{dashboard_path()}}/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                            John Pierce
                            <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                        <img src="{{dashboard_path()}}/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                            Nora Silvester
                            <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li> --}}
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    @if (App\Models\Notification::where('to_id', auth()->id())->where('seen', 0)->count() > 0 )
                        <span id="notificationCounter" class="badge badge-warning navbar-badge">{{App\Models\Notification::where('to_id', auth()->id())->where('seen', 0)->count()}}</span>
                    @else
                        <span id="notificationCounter" class="badge navbar-badge"></span>
                    @endif
                    
                    </a>
                    <div id="notification-dropdown-menu" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">{{App\Models\Notification::where('to_id', auth()->id())->where('seen', 0)->count()}}  إشعار غير مقروء</span>
                    <div id="notification-list" class="notification-content">
                    @forelse(App\Models\Notification::where('to_id', auth()->id())->orderBy('id', 'desc')->paginate(4) as $notification)
                               
                            <div class="dropdown-divider"></div>
                                <a href="{{$notification->url}}" class="dropdown-item notification-item">
                                    <i class="fas {{$notification->seen ? 'fa-envelope-open' : 'fa-envelope' }} mr-2 notification-text"></i> {{$notification->message_ar}}
                                    <span class="float-right text-muted text-sm">{{$notification->created_at->diffForHumans()}}</span>
                                </a>
                            <div class="dropdown-divider"></div>
                        
                    @empty
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> لا يوجد نتائج
                            <span class="float-right text-muted text-sm"></span>
                        </a>
                        <div class="dropdown-divider"></div>
                    @endforelse
                    </div>
                    <a href="{{route('adminAllNotifications')}}" class="dropdown-item dropdown-footer">{{Translate('مشاهدة الكل')}}</a>
                    
                    </div>
                </li> 
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                        class="fas fa-th-large"></i></a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin_home') }}" class="brand-link">
                <img src="{{ dashboard_path() }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ settings('site_name') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    {{-- <div class="image">
                        <img src="{{ url('') }}/{{ Auth::user()->avatar }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div> --}}
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('admin_home') }}"
                                class="nav-link {{ Route::currentRouteName() == 'admin_home' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    الرئيسية
                                </p>
                            </a>
                        </li>
                        @if (Auth::id() == 1 || hasPermission('settings'))
                            <li class="nav-item">
                                <a href="{{ url('settings') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'settings' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>
                                        الإعدادات
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::id() == 1 || hasPermission('permissions'))
                            <li class="nav-item">
                                <a href="{{ url('permissions') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'permissions' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-poll"></i>
                                    <p>
                                        الصلاحيات
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::id() == 1 || hasPermission('admins'))
                            <li class="nav-item">
                                <a href="{{ url('admins') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'admins' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-tie"></i>
                                    <p>
                                        المديرين
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::id() == 1 || hasPermission('users'))
                            <li class="nav-item">
                                <a href="{{ url('users') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'users' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        الأعضاء
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::id() == 1 || hasPermission('packages'))
                            <li class="nav-item">
                                <a href="{{ url('packages') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'packages' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        الباقات
                                    </p>
                                </a>
                            </li>
                        @endif
                        {{-- @if(Auth::id() == 1 || hasPermission('rates'))
                            <li class="nav-item">
                                <a href="{{url('rates')}}" class="nav-link {{Route::currentRouteName() == 'rates' ? 'active' : ''}}">
                                    <i class="nav-icon fas fa-star"></i>
                                    <p>
                                        {{Translate('التقييمات')}}
                                    </p>
                                </a>
                            </li>
                        @endif --}}
                        @if (Auth::id() == 1 || hasPermission('pages'))
                            <li class="nav-item">
                                <a href="{{ url('pages') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'pages' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-medical-alt"></i>
                                    <p>
                                        الصفحات الاساسية
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::id() == 1 || hasPermission('common_questions'))
                            <li class="nav-item">
                                <a href="{{ url('common_questions') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'common_questions' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-medical-alt"></i>
                                    <p>
                                        الاسئلة المتداولة
                                    </p>
                                </a>
                            </li>
                        @endif


                        @if (Auth::id() == 1 || hasPermission('sliders'))
                            <li class="nav-item">
                                <a href="{{ url('sliders/app') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'sliders' && $type == 'app' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-image"></i>
                                    <p>
                                        الاعلانات
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::id() == 1 || hasPermission('sections'))
                            <li class="nav-item">
                                <a href="{{ url('sections') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'sections' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        اقسام المدونة
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (Auth::id() == 1 || hasPermission('media_files'))
                            <li class="nav-item">
                                <a href="{{ url('media_files/news') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'media_files' && $type == 'news' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        المدونة
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('media_files/news_bar') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'media_files' && $type == 'news_bar' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        شريط الاخبار
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('media_files/statics') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'media_files' && $type == 'statics' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        الاحصائيات
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('media_files/goals') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'media_files' && $type == 'goals' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        اهداف التسجيل
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('media_files/nationality') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'media_files' && $type == 'nationality' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        الجنسيات
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('media_files/levels') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'media_files' && $type == 'levels' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        المؤهلات العلمية
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('media_files/social_levels') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'media_files' && $type == 'social_levels' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        الحالات الاجتماعية
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('media_files/jobs') }}"
                                   class="nav-link {{ Route::currentRouteName() == 'media_files' && $type == 'jobs' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        المهن
                                    </p>
                                </a>
                            </li>
                        @endif
                        {{--@if (Auth::id() == 1 || hasPermission('countrys'))
                            <li class="nav-item">
                                <a href="{{ url('countrys') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'countrys' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-globe"></i>
                                    <p>
                                        الدول
                                    </p>
                                </a>
                            </li>
                        @endif--}}
                        @if (Auth::id() == 1 || hasPermission('citys'))
                            <li class="nav-item">
                                <a href="{{ url('citys') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'citys' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-globe"></i>
                                    <p>
                                        المدن
                                    </p>
                                </a>
                            </li>
                        @endif
                        {{-- @if (Auth::id() == 1 || hasPermission('neighborhoods'))
                            <li class="nav-item">
                                <a href="{{url('neighborhoods')}}" class="nav-link {{Route::currentRouteName() == 'neighborhoods' ? 'active' : ''}}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    الأحياء
                                </p>
                                </a>
                            </li>
                        @endif --}}
                         {{-- @if (Auth::id() == 1 || hasPermission('shipping_types'))
                            <li class="nav-item">
                                <a href="{{ url('shipping_types') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'shipping_types' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        طرق الشحن
                                    </p>
                                </a>
                            </li>
                        @endif --}}
                        {{--@if (Auth::id() == 1 || hasPermission('promo_codes'))
                            <li class="nav-item">
                                <a href="{{ url('promo_codes') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'promo_codes' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-percent"></i>
                                    <p>
                                        اكواد الخصم
                                    </p>
                                </a>
                            </li>
                        @endif--}}

                         {{-- @if (Auth::id() == 1 || hasPermission('bank_accounts'))
                            <li class="nav-item">
                                <a href="{{ url('bank_accounts') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'bank_accounts' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-dollar-sign"></i>
                                    <p>
                                        الحسابات البنكية
                                    </p>
                                </a>
                            </li>
                        @endif
                         @if (Auth::id() == 1 || hasPermission('bank_transfers'))
                            <li class="nav-item">
                                <a href="{{ url('bank_transfers') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'bank_transfers' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-dollar-sign"></i>
                                    <p>
                                        التحويلات البنكية
                                    </p>
                                </a>
                            </li>
                        @endif --}}
                        @if (Auth::id() == 1 || hasPermission('contacts'))
                            <li class="nav-item">
                                <a href="{{ url('contacts/contact') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'contacts' && isset($type) && $type == 'contact'  ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-envelope"></i>
                                    <p>
                                        تواصل معنا
                                    </p>
                                </a>
                            </li>
                        @endif
                        {{-- @if (Auth::id() == 1 || hasPermission('adminReports'))
                            <li class="nav-item">
                                <a href="{{url('adminReports')}}" class="nav-link {{Route::currentRouteName() == 'adminReports' ? 'active' : ''}}">
                                <i class="nav-icon fas fa-flag"></i>
                                <p>
                                    {{Translate('تقارير لوحة التحكم')}}
                                </p>
                                </a>
                            </li>
                        @endif --}}
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            {{-- <h1 class="m-0 text-dark">Dashboard v2</h1> --}}
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
                                {{-- <li class="breadcrumb-item active">Dashboard v2</li> --}}
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            @include('msg')
            @yield('content')

        </div>
        <!-- /.content-wrapper -->

        @yield('modal')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            {{-- <strong>Copyright &copy; 2020 <a href="#"></a> </strong>
                {{Translate('جميع الحقوق محفوظة')}} --}}
            <div class="float-right d-none d-sm-inline-block">
                {{-- <b>Version</b> 1.0.0 Beta --}}
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ dashboard_path() }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ dashboard_path() }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ dashboard_path() }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ dashboard_path() }}/dist/js/adminlte.js"></script>
    <!-- Select2 -->
    <script src="{{ dashboard_path() }}/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ dashboard_path() }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- DataTables -->
    <script src="{{ dashboard_path() }}/plugins/datatables/jquery.dataTables.js"></script>
    <script src="{{ dashboard_path() }}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- DataTables buttons-->
    {{--<script src="{{ dashboard_path() }}/plugins/datatables-buttons/js/buttons.bootstrap4.js"></script>--}}
    <script src="{{ dashboard_path() }}/plugins/datatables-buttons/js/dataTables.buttons.js"></script>
    <script src="{{ dashboard_path() }}/plugins/datatables-buttons/js/buttons.print.js"></script>
    <script src="{{ dashboard_path() }}/plugins/datatables-buttons/js/buttons.colVis.js"></script>
    <script src="{{ dashboard_path() }}/plugins/datatables-buttons/js/buttons.flash.js"></script>
    <script src="{{ dashboard_path() }}/plugins/datatables-buttons/js/buttons.html5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ dashboard_path() }}/plugins/summernote/summernote-bs4.min.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ dashboard_path() }}/dist/js/demo.js"></script>
    <!-- drop -->
    <script src="{{ dashboard_path() }}/plugins/dropify/js/dropify.min.js"></script>
    <script src="{{ dashboard_path() }}/plugins/dropify/js/jquery.form-upload.init.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{ dashboard_path() }}/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="{{ dashboard_path() }}/plugins/raphael/raphael.min.js"></script>
    <script src="{{ dashboard_path() }}/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="{{ dashboard_path() }}/plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="{{ dashboard_path() }}/plugins/chart.js/Chart.min.js"></script>

    <!-- PAGE SCRIPTS -->
    <script src="{{ dashboard_path() }}/dist/js/pages/dashboard2.js"></script>

    <!-- Notify Js -->
    <script src="{{ asset('notify.js') }}"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>

    {{-- FireBase --}}
    <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js"></script>
    {{--<script src="{{url('/')}}/firebase-messaging-sw.js"></script>--}}

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
        window.fcmMessageing  = messaging;
        // Add the public key generated from the console here.
        messaging.usePublicVapidKey("BGidWSpMQiKt_YpwqD9gX97VRbckOHAAv1zPWK5gyCUKe_tPHNGvDUU8itf8QK2kkiJP1uWWJy36Hfqtuca48yg");

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

    <link rel="manifest" href="{{url('/')}}/manifest.json">

    {{-- DatePicker --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $(".date-picker").datepicker({
                //minDate: 0,
                //startDate: new Date(),
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'yy-mm-dd',
            });
        });

        $( ".datepicker" ).datepicker({
            //minDate:0,
            //startDate:new Date(),
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd',
        });

        $( ".old_datepicker" ).datepicker({
            //maxDate:0,
            //endDate:new Date(),
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd',
        });

        $(function() {
            $(".date").datepicker({
                //minDate: 0,
                //startDate: new Date(),
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>

    <!-- ckEditor -->
    {{--<script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>--}}
    <script src="https://cdn.ckeditor.com/4.4.5/full/ckeditor.js"></script>

    {{-- Maps --}}
    {{--<script>
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
        function initialize() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    lat = position.coords.latitude;
                    lng = position.coords.longitude;
                    $("#lat").val(lat);
                    $("#lng").val(lng);
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            }
            var myLatlng = new google.maps.LatLng(lat, lng);

            var myOptions = {
                zoom: 12,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            };

            var map = new google.maps.Map(
                document.getElementById("add_map"),
                myOptions
            );

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                draggable: true,
            });

            map.addListener("click", (mapsMouseEvent) => {
                marker.setPosition(mapsMouseEvent.latLng);
            });

            var searchBox = new google.maps.places.SearchBox(
                document.getElementById("pac-input")
            );
            google.maps.event.addListener(searchBox, "places_changed", function() {
                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();
                var i, place;
                for (i = 0;
                    (place = places[i]); i++) {
                    bounds.extend(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                }
                map.fitBounds(bounds);
                map.setZoom(12);
            });

            google.maps.event.addListener(marker, "position_changed", function() {
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();
                $("#lat").val(lat);
                $("#lng").val(lng);
            });
        }

        function showPosition(position) {
            lat = position.coords.latitude;
            lng = position.coords.longitude;
            initialize();
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl02ktqMdvzEwH-_oa7RREoI8Gr-6c9eQ&libraries=places&callback=initialize"
        async defer></script>

    <script>
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
        function edit_initialize() {
            var lat = parseFloat($('#edit_lat').val());
            var lng = parseFloat($('#edit_lng').val());
            var myLatlng = new google.maps.LatLng(lat, lng);

            var myOptions = {
                zoom: 12,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            };

            var map = new google.maps.Map(
                document.getElementById("edit_add_map"),
                myOptions
            );

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                draggable: true,
            });

            map.addListener("click", (mapsMouseEvent) => {
                marker.setPosition(mapsMouseEvent.latLng);
            });

            var searchBox = new google.maps.places.SearchBox(
                document.getElementById("edit_pac-input")
            );
            google.maps.event.addListener(searchBox, "places_changed", function() {
                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();
                var i, place;
                for (i = 0;
                    (place = places[i]); i++) {
                    bounds.extend(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                }
                map.fitBounds(bounds);
                map.setZoom(12);
            });

            google.maps.event.addListener(marker, "position_changed", function() {
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();
                $("#edit_lat").val(lat);
                $("#edit_lng").val(lng);
            });
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl02ktqMdvzEwH-_oa7RREoI8Gr-6c9eQ&libraries=places&callback=edit_initialize"
        async defer></script>--}}

    <script>
        $(document).ready(function() {
            // Notify Js
            var type = $('#alertType').val();
            if (type != '0') {
                var theme = $('#alertTheme').val();
                var message = $('#alertMessage').val();
                $.notify(message, theme);
                //alert(message);
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

            // Google Maps
            //if (navigator.geolocation) navigator.geolocation.getCurrentPosition(showPosition);

            $('.select2').select2();
        });

        function start_loader() {
            $('.save').attr('disabled', '');
            $('.save').html('<i class="fas fa-spinner fa-spin"></i>');
        }

        function stop_loader() {
            $('.save').removeAttr('disabled');
            $('.save').html('حفظ');
        }

        $(function() {
            // Summernote
            $('.textarea').summernote()
        });

        $(function() {
            //change lang
            $('.ch-lang').click(function() {
                event.preventDefault();
                if (document.documentElement.lang.toLowerCase() === 'ar') {
                    $("html").removeAttr('lang');
                } else {
                    $("html").attr('lang', 'ar');
                }
            });

            $('#datatable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "dom": "Bfrtip",
                "responsive": true,
                "fixedColumns": true,
                "lengthMenu": [
                    [-1],
                    ['all']
                ],
                "buttons": [{
                        extend: "excel",
                        text: "Excel"
                    },
                    //{ extend: "pdfHtml5"  , text: "PDF" },
                    {
                        extend: "print",
                        text: "Print",
                        autoPrint: true,
                        customize: function (win) {
                            $(win.document.body).css('direction', 'rtl');
                        }
                    }
                ],
            });

            $('#datatable2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "lengthMenu": [
                    [-1],
                    ['all']
                ],
            });

            $("#datatable-button").DataTable({
                "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "dom": "Bfrtip",
                    "responsive": true,
                    "fixedColumns": true,
                    "lengthMenu": [
                        [-1],
                        ['all']
                    ],
                    "buttons": [{
                            extend: "excel",
                            text: "Excel"
                        },
                        //{ extend: "pdfHtml5"  , text: "PDF" },
                        {
                            extend: "print",
                            text: "Print",
                            autoPrint: true,
                            customize: function (win) {
                                $(win.document.body).css('direction', 'rtl');
                            }
                        }
                    ],
            });
        });

    </script>
    <script >
    //check whether the user having an unread notification 
    // $.ajax({
    //             type: 'get',
    //             url: '{{ route('notificationsCount') }}',
    //             datatype: 'json',
    //             async: true,
    //             processData: false,
    //             contentType: false,
    //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //             success: function(msg) {
    //                 if (msg.count > '0') {
    //                     document.getElementById("notification-icon").classList.add("has-unread");
    //                 }
    //             }
    //         });
    window.onload = function() {
        
        
        
            const user = JSON.parse('{!! json_encode(auth()->user()) !!}');
            Echo.private(`App.Models.User.${user.id}`)
                .listen('.adminNotification', (data) => {
                    notificationSound.play(); // Play sound
                    handleNotification(data);
                });
    };
    let notificationSound = new Audio("{{ site_path() }}/assets/sound/notification-sound.mp3");

    // handleNotification: function used to handle different types of notifications.
    function handleNotification(notification) {

        //notification counter update//
        document.getElementById("notificationCounter").classList.add("badge-warning");
        let notificationCounter = parseInt(document.getElementById("notificationCounter").innerText);
        console.log(notificationCounter);
        if(notificationCounter > 0 )
        {
            notificationCounter = notificationCounter + 1;
        }else{
            notificationCounter = 1;
        }
        
        document.getElementById("notificationCounter").innerText = notificationCounter ;

       // Get the notification list container
        let notificationList = document.getElementById('notification-list');

        // Create the new notification HTML structure
        let newNotification = `
            <div class="dropdown-divider"></div>
            <a href="${notification.targetId}" class="dropdown-item notification-item">
                <i class="fas fa-envelope mr-2 notification-text"></i> 
                ${notification.message}
                <span class="float-right text-muted text-sm">منذ 20 ثانية</span>
            </a>
            <div class="dropdown-divider"></div>
        `;

        // Insert the new notification at the **beginning** of the list
        notificationList.insertAdjacentHTML('afterbegin', newNotification);

        // Ensure we only keep the last 4 notifications (excluding the footer)
        let notifications = notificationList.querySelectorAll('.notification-item');
        if (notifications.length > 4) {
            notifications[notifications.length - 1].nextElementSibling.remove(); // Remove the divider
            notifications[notifications.length - 1].remove(); // Remove the last notification
        }


        
    }
</script>

    @yield('script')

    <script>
        CKEDITOR.replace( 'desc_ar' );
    </script>

    {{--<script>
        const {
            ClassicEditor,
            Essentials,
            Bold,
            Italic,
            Font,
            Paragraph
        } = CKEDITOR;

        ClassicEditor
            .create( document.querySelector( '#desc_ar' ), {
                licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3MzYyMDc5OTksImp0aSI6IjI4MGNhMmMxLTA5OTctNDRlYi04NjE1LWM5MDNmZmRjNmY4MSIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6IjRlZTFlMDQwIn0.3eF4kHbZb6p6B7whAbKkSdOPmRm__gi7e6jjJML2lIwY6pLDueHfkTaN6aLn9fyhMp7UMc0gjQRyXLb0EW4P3Q', // Create a free account on https://portal.ckeditor.com/checkout?plan=free
                plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
                toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor'
                    // , 'fontBackgroundColor'
                ]
            } )
            .then( editor => {
                window.editor = editor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>--}}
</body>

</html>
