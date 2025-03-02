@extends('site.master')
@section('title')المدونة@endsection
@section('style')
    <style>
        .main-btn a {
            position: relative;
            color: var(--white) !important;
            border: 1px solid var(--primary);
            background-color: var(--primary);
            border-radius: 35px;
            padding: 8px 36px;
            text-align: center;
            overflow: hidden;
            cursor: pointer;
            display: inline-block;
            transition: all .35s ease-in-out;
        }

        .news {
            padding: 50px 0;
        }

        .news-item {
            position: relative;
            margin-bottom: 20px;
        }
        .news-item:before{
            content: " ";
            width: 100%;
            height: 0;
            background: rgba(0,0,0,.4);
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: 0;

        }
        .news-item:hover:before{
            transition: all .35s ease-in-out;
            height: 100%;
        }
        .news-item .img {
            border-radius: 15px;
            border: 1px solid var(--main);
            transition: all .35s ease-in-out;
        }

        .news-item:hover .img {
            box-shadow: 3px 0 13px rgba(0, 0, 0, .19);
        }

        .news-item .img img {
            border-radius: 15px;
            width: 100%;
            height: 300px;
            object-fit: none;
        }

        .news-item {

            position: relative;
            overflow: hidden;
        }

        .news-content {
            background: var(--white);
            border-radius: 15px;
            text-align: center;
            padding: 15px;

            width: 95%;
            position: absolute;
            top: -50%;
            left: 50%;
            transform: translate(-50%, -50%);
opacity: 0;
            transition: all .35s ease-in-out;
        }
        .news-item:hover .news-content{
            top: 50%;
            opacity: 1;
        }

        .news-item:hover .news-content {
            box-shadow: 3px 0 13px rgba(0, 0, 0, .19);
        }

        .news-content .desc {
            margin: 20px 0;
        }

        .news-content .url .main-btn a {
            color: var(--secondary) !important;
            border: 1px solid var(--secondary);
            background-color: transparent;
            transition: all .35s ease-in-out;
        }

        .news-item:hover .news-content .url .main-btn a {
            color: var(--white) !important;
            border: 1px solid var(--primary);
            background-color: var(--primary);
        }

        @media (max-width: 768px) {
            .news-content {
                padding: 10px;
            }

            .news-content .desc {
                margin: 10px 0;
            }
        }
    </style>
@endsection

@section('content')
    <!--  welcome  -->
    @if(!auth()->check())
        <section class="welcome">
            <div class="welcome-img">
                <img src="{{ site_path() }}/assets/img/welcome.png" alt="">
            </div>
            <p class="welcome-tit">أهلاً بكم في موقع {{ settings('site_name') }}</p>
        </section>
    @endif
    <!--  //welcome  -->

    <section class="news">
        <div class="container">
            {{--<div class="main-title text-center">

                <h2>
                    الأخبار

                </h2>
            </div>--}}
            <div class="row">
                @foreach($data as $item)
                    <div class="col-lg-4 col-md-4 col-12 wow fadeInDown" data-wow-delay=".2s">
                        <div class="news-item">
                            <div class="img">
                                <img loading="lazy" src="{{url(''.$item->image)}}" class="img-fluid" alt="" width="100%"
                                     height="100px">
                            </div>
                            <div class="news-content">
                                <div class="tit">
                                    {{is_null($item->section) ? '' : $item->section->title_ar}}
                                </div>
                                <div class="tit">
                                    {{$item->title}}
                                </div>
                                {{--                                <div class="desc">--}}
                                {{--                                    {{$item->short_desc}}--}}
                                {{--                                </div>--}}
                                <div class="url">

                                    <a href="{{url('show-media/' . $item->id)}}" class=main-btn"">
                                        تعرف اكثر
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('script')
@endsection