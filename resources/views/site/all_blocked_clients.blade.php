@extends('site.master')
@section('title') قائمة التجاهل @endsection
@section('style')
<style>
.custom-col {
    width: 33.3333%; /* Same as col-lg-4 */
    padding: 15px;
}

@media (max-width: 992px) {
    .custom-col {
        width: 50%; /* Behaves like col-md-6 */
    }
}

@media (max-width: 768px) {
    .custom-col {
        width: 100%; /* Full width on mobile */
    }
}
    /* حاوية التبويبات */
    .tabs-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px;
    }

    /* تصميم شريط التبويبات */
    .custom-tabs {
        display: flex;
        background: #fff;
        border: none;
        border-bottom: 4px solid #b72dd2;
        border-radius: 10px;
        padding: 0;
        width: 100%;
        max-width: 700px;
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* تصميم التبويبات */
    .custom-tabs .nav-item {
        flex: 1;
        text-align: center;
    }

    .custom-tabs .nav-link {
        font-size: 18px;
        font-weight: bold;
        padding: 14px 20px;
        color: #555;
        background: #f8f9fa;
        border-radius: 10px 10px 0 0;
        text-align: center;
        width: 100%;
        border: none;
        transition: all 0.4s ease-in-out;
        position: relative;
        text-transform: uppercase;
    }

    /* التأثير عند تمرير الماوس */
    .custom-tabs .nav-link:hover {
        background-color: #eee;
        color: #b72dd2;
    }

    /* التبويب النشط */
    .custom-tabs .nav-link.active {
        background: linear-gradient(to right, #b72dd2, #2492a8);
        color: white !important;
        border-bottom: 4px solid #b72dd2;
    }

    /* أيقونات التبويبات */
    .custom-tabs .nav-link i {
        margin-left: 10px;
        font-size: 22px;
    }

    /* تأثير أسفل التبويب النشط */
    .custom-tabs .nav-link.active::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: -4px;
        width: 60%;
        height: 4px;
        background: white;
        border-radius: 5px;
        transform: translateX(-50%);
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

    <section class="new-members">
       <div class="tabs-container">
    <ul class="nav nav-tabs custom-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="general-members-tab" data-toggle="tab" href="#general-members" role="tab" aria-controls="general-members" aria-selected="true">
                <i class="fas fa-user-slash"></i> أفراد أضافوك في قائمة التجاهل
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="premium-members-tab" data-toggle="tab" href="#premium-members" role="tab" aria-controls="premium-members" aria-selected="false">
                <i class="fas fa-user-times"></i> أفراد أضفتهم في قائمة التجاهل
            </a>
        </li>
    </ul>
</div>
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
                        <div class="tab-pane show active" id="general-members" role="tabpanel" aria-labelledby="general-members-tab">



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

                        </div>

                        <!-- Premium members content -->
                        <div class="tab-pane" id="premium-members" role="tabpanel" aria-labelledby="premium-members-tab">

                                <div class="container mt-4">
                                    <div class="row justify-content-center">
                                        @forelse($data as $item)
                                            <div class="custom-col">
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


                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
