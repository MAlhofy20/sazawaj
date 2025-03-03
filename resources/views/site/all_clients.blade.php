@extends('site.master')
@section('title') الأعضاء @endsection
@section('style')
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
        <div class="container">
            <h2 class="sec-tit text-center">
                <!--الأعضاء-->
            </h2>
            <div class="new-members-items">
                <div class="container mt-4">
                    <div class="mt-4">
                        <div class="mt-4">
                            <div class="row justify-content-center">
                                @forelse($data as $item)
                                    <div class="col-lg-4">
                                        <a href="{{url('show_client/' . $item->id)}}">
                                            <div class="register-sidebar-content {{$item->gender == 'male' ? 'male' : ''}} mb-3">
                                                <div class="register-sidebar-head">
                                                    <h2 class="text-center {{$item->is_still_online == '1' ? 'online' : 'offline'}}">{{$item->name}}</h2>
                                                </div>
                                                <div class="register-sidebar-body">
                                                    <div class="image">
                                                        <img src="{{url('' . $item->avatar)}}" alt="{{$item->full_name}}">
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
                                                                {{$item->age}}
                                                            </div>
                                                        </div>
                                                        <div class="desc-content-register mb-2">
                                                            <div class="icon-text">
                                                                <div class="icon">
                                                                    <i class="fa-solid fa-location-dot"></i></div>
                                                                <div class="text">
                                                                    المدينة
                                                                </div>
                                                            </div>
                                                            <div class="value">
                                                                {{$item->city?->title_ar}}
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
                                                                {{$item->goals}}
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
    </section>
@endsection
