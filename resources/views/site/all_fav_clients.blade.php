@extends('site.master')
@section('title') الاعجاب @endsection
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

        .visitors-table-container {
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .visitors-table {
            width: 100%;
            border-collapse: collapse;
        }
        .visitors-table-header {
            background-color: #c930e8;
            color: #ffffff;
        }
        .visitors-header-cell, .visitor-cell {
            padding: 12px;
                display: flex;
            font-size: 18px;
            font-weight: bold;
            text-align: start;
                align-items: center;
            flex: 1;
        }
        .visitors-table-body .visitor-row:nth-child(even) {
            background-color: #fff;
        }
        .visitors-table-body .visitor-row:hover {
            background-color: #ede2ab;
        }
        @media (max-width: 768px) {
            .visitors-table .visitor-cell img{
                width: 50px;
                height: 50px;
            }
            .visitors-table-body tr{
                padding: 10px 0;
            }
            .visitors-header-cell, .visitor-cell{
                flex-direction: column;
                justify-content: center;
                align-items: center;
                font-size: 14px;
                width: 25%;
                padding: 0;
            }
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
    <style>
.u-hover--sparkle:hover::before, .u-hover--sparkle:hover::after {
    transform: scale3d(1, 1, 1);
    transition: transform 0.6s;
}

.u-hover--sparkle::before {
    border-top: 0.2em solid #54b3d6;
    border-bottom: 0.2em solid #54b3d6;
    transform: scale3d(0, 1, 1);
}
.u-hover--sparkle::before, .u-hover--sparkle::after {
    content: "";
    box-sizing: border-box;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    transform-origin: center;
    cursor: pointer;
    z-index: 1;
}
.u-hover--sparkle:hover::before, .u-hover--sparkle:hover::after {
    transform: scale3d(1, 1, 1);
    transition: transform 0.6s;
}
.u-hover--sparkle::after {
    border-left: 0.2em solid #54b3d6;
    border-right: 0.2em solid #54b3d6;
    transform: scale3d(1, 0, 1);
}

</style>
    <section class="new-members container">
        <ul style=" margin: 20px auto; border-radius: 10px !important;"   class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a style="border:none !important; z-index: 2;" class="u-hover--sparkle position-relative nav-link active" id="general-members-tab" data-toggle="tab" href="#general-members" role="tab" aria-controls="general-members" aria-selected="true">المعجبون بك</a>
            </li>
            <li class="nav-item">
                <a style="border:none !important; z-index: 2;" class="u-hover--sparkle position-relative nav-link" id="premium-members-tab" data-toggle="tab" href="#premium-members" role="tab" aria-controls="premium-members" aria-selected="false">المعجب بهم</a>
            </li>
        </ul>
        <div class="container">
            <h2 class="sec-tit text-center">
                <!--الأعضاء-->
            </h2>
            <div class="new-members-items">
                <div class="container mt-4">
                    <!-- Tabs navigation -->


                    <!-- Tabs content -->
                    <div class="tab-content" id="myTabContent">
                        <!-- General members content -->
                        <div class="tab-pane fade show active" id="general-members" role="tabpanel" aria-labelledby="general-members-tab">
                            <div class="d-flex justify-content-center my-4">
    <div class="page-title">
        <i class="fas fa-heart icon"></i>
        <span class="title-text">المعجبون بك</span>
        <div class="underline"></div>
    </div>
</div>
                            {{--@if(!checkUserPackage())
                                <div class="prim-visitor mt-5">
                                    <span>ﻫﺬه اﻟﺨﺪﻣﺔ ﻣﺘﻮﻓﺮة ﻟﻠﻤﺴﺘﺨﺪﻣﻴﻦ اﻟﺒﺮو</span>
                                </div>
                                <div class="buttons">
                                    <a href="{{url('all_packages')}}" class="next-btn">
                                        <span style="margin: 5px">ترقيه</span>
                                        <i class="fa-solid fa-left-long"></i>
                                    </a>
                                </div>
                            @else
                            @endif--}}
                            <div class="visitors-table-container">
                                <table class="visitors-table">
                                    <thead class="visitors-table-header">
                                    <tr>
                                        <th class="visitors-header-cell">الاسم</th>
                                        <th class="visitors-header-cell">العمر</th>
                                        <th class="visitors-header-cell">المدينة</th>
                                        <th class="visitors-header-cell">تاريخ الزيارة</th>
                                    </tr>
                                    </thead>
                                    <tbody class="visitors-table-body">
                                    @forelse($to_data as $item)
                                        <tr class="visitor-row">
                                            <td class="visitor-cell">
                                                <img src="{{url('' . $item->user->avatar)}}" alt="" class="visitor-image" width="100px" height="75px">
                                                <a href="{{url('show_client/' . $item->user_id)}}">{{$item->user->name}}</a>
                                            </td>
                                            <td class="visitor-cell">{{$item->user->age}}</td>
                                            <td class="visitor-cell">{{$item->user->city?->title_ar}}</td>
                                            <td class="visitor-cell">{{date('Y-m-d', strtotime($item->updated_at))}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"> لا يوجد نتائج</td>
                                        </tr>
                                    @endforelse
                                    <!-- أضف المزيد من الصفوف هنا -->
                                    </tbody>
                                </table>
                            </div>

                            {{--<div class="mt-4">
                                <div class="mt-4">
                                    <div class="row justify-content-center">
                                        @forelse($to_data as $item)
                                            <div class="col-lg-4">
                                                <a href="{{url('show_client/' . $item->user_id)}}">
                                                    <div class="register-sidebar-content {{$item->user->gender == 'male' ? 'male' : ''}} mb-3">
                                                        <div class="register-sidebar-head">
                                                            <h2 class="text-center">{{$item->user->name}}</h2>
                                                        </div>
                                                        <div class="register-sidebar-body">
                                                            <div class="image">
                                                                <img src="{{url('' . $item->user->avatar)}}" alt="{{$item->user->full_name}}">
                                                            </div>
                                                            <div class="desc">
                                                                <div class="desc-content-register mb-2">
                                                                    <div class="icon-text">
                                                                        <div class="icon">
                                                                            <i class="fa-solid fa-user"></i>
                                                                        </div>
                                                                        <div class="text">
                                                                            العمر
                                                                        </div>
                                                                    </div>
                                                                    <div class="value">
                                                                        {{$item->user->age}}
                                                                    </div>
                                                                </div>
                                                                <div class="desc-content-register mb-2">
                                                                    <div class="icon-text">
                                                                        <div class="icon">
                                                                            <i class="fa-solid fa-location-dot"></i></div>
                                                                        <div class="text">
                                                                            الدولة
                                                                        </div>
                                                                    </div>
                                                                    <div class="value">
                                                                        {{$item->user->country}}
                                                                    </div>
                                                                </div>
                                                                <div class="desc-content-register mb-2">
                                                                    <div class="icon-text">
                                                                        <div class="icon">
                                                                            <i class="fa-solid fa-heart"></i>
                                                                        </div>
                                                                        <div class="text">
                                                                            الهدف
                                                                        </div>
                                                                    </div>
                                                                    <div class="value">
                                                                        {{$item->user->goals}}
                                                                    </div>
                                                                </div>
                                                                <div class="desc-content-register mb-2">
                                                                    <div class="icon-text">
                                                                        <div class="icon">
                                                                            <i class="fa-solid fa-calendar-days"></i>
                                                                        </div>
                                                                        <div class="text">
                                                                        </div>
                                                                    </div>
                                                                    <div class="value">
                                                                        {{date('Y-m-d', strtotime($item->updated_at))}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @empty
                                            <div class="col-lg-auto col-md-12 col-12 wow bounceInRight" data-wow-delay="0.2s">
                                                <h4 style="color: red"> لا يوجد نتائج </h4>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>--}}
                        </div>

                        <!-- Premium members content -->
                        <div class="tab-pane fade" id="premium-members" role="tabpanel" aria-labelledby="premium-members-tab">
                            <div class="d-flex justify-content-center my-4">
                                <div class="page-title">
                                    <i class="fas fa-heartbeat icon"></i>
                                    <span class="title-text">المعجب بهم</span>
                                    <div class="underline"></div>
                                </div>
                            </div>
                            <div class="visitors-table-container">
                                <table class="visitors-table">
                                    <thead class="visitors-table-header">
                                    <tr>
                                        <th class="visitors-header-cell">الاسم</th>
                                        <th class="visitors-header-cell">العمر</th>
                                        <th class="visitors-header-cell">المدينة</th>
                                        <th class="visitors-header-cell">تاريخ الزيارة</th>
                                    </tr>
                                    </thead>
                                    <tbody class="visitors-table-body">
                                    @forelse($data as $item)
                                        <tr class="visitor-row">
                                            <td class="visitor-cell">
                                                <img src="{{url('' . $item->to->avatar)}}" alt="" class="visitor-image" width="100px" height="75px">
                                                <a href="{{url('show_client/' . $item->to_id)}}">{{$item->to->name}}</a>
                                            </td>
                                            <td class="visitor-cell">{{$item->to->age}}</td>
                                            <td class="visitor-cell">{{$item->to->city?->title_ar}}</td>
                                            <td class="visitor-cell">{{date('Y-m-d', strtotime($item->updated_at))}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"> لا يوجد نتائج</td>
                                        </tr>
                                    @endforelse
                                    <!-- أضف المزيد من الصفوف هنا -->
                                    </tbody>
                                </table>
                            </div>

                            {{--<div class="mt-4">
                                <div class="mt-4">
                                    <div class="row justify-content-center">
                                        @forelse($data as $item)
                                            <div class="col-lg-4">
                                                <a href="{{url('show_client/' . $item->to_id)}}">
                                                    <div class="register-sidebar-content {{$item->to->gender == 'male' ? 'male' : ''}} mb-3">
                                                        <div class="register-sidebar-head">
                                                            <h2 class="text-center">{{$item->to->name}}</h2>
                                                        </div>
                                                        <div class="register-sidebar-body">
                                                            <div class="image">
                                                                <img src="{{url('' . $item->to->avatar)}}" alt="{{$item->to->full_name}}">
                                                            </div>
                                                            <div class="desc">
                                                                <div class="desc-content-register mb-2">
                                                                    <div class="icon-text">
                                                                        <div class="icon">
                                                                            <i class="fa-solid fa-user"></i>
                                                                        </div>
                                                                        <div class="text">
                                                                            العمر
                                                                        </div>
                                                                    </div>
                                                                    <div class="value">
                                                                        {{$item->to->age}}
                                                                    </div>
                                                                </div>
                                                                <div class="desc-content-register mb-2">
                                                                    <div class="icon-text">
                                                                        <div class="icon">
                                                                            <i class="fa-solid fa-location-dot"></i></div>
                                                                        <div class="text">
                                                                            الدولة
                                                                        </div>
                                                                    </div>
                                                                    <div class="value">
                                                                        {{$item->to->country}}
                                                                    </div>
                                                                </div>
                                                                <div class="desc-content-register mb-2">
                                                                    <div class="icon-text">
                                                                        <div class="icon">
                                                                            <i class="fa-solid fa-heart"></i>
                                                                        </div>
                                                                        <div class="text">
                                                                            الهدف
                                                                        </div>
                                                                    </div>
                                                                    <div class="value">
                                                                        {{$item->to->goals}}
                                                                    </div>
                                                                </div>
                                                                <div class="desc-content-register mb-2">
                                                                    <div class="icon-text">
                                                                        <div class="icon">
                                                                            <i class="fa-solid fa-calendar-days"></i>
                                                                        </div>
                                                                        <div class="text">
                                                                        </div>
                                                                    </div>
                                                                    <div class="value">
                                                                        {{date('Y-m-d', strtotime($item->updated_at))}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @empty
                                            <div class="col-lg-auto col-md-12 col-12 wow bounceInRight" data-wow-delay="0.2s">
                                                <h4 style="color: red"> لا يوجد نتائج </h4>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>--}}

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $(".visitor-row").click(function() {
            let link = $(this).find("a").attr("href");
            if (link) {
                window.location.href = link;
            }
        });

        // Prevent row click when clicking directly on a link
        $(".visitor-row a").click(function(event) {
            event.stopPropagation();
        });
    });
</script>
@endsection
