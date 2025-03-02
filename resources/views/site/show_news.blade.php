@extends('site.master')
@section('title'){{$data->title}}@endsection
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
        .news{
            padding: 50px 0 ;
        }
        .news-item{
            position: relative;
            margin-bottom: 20px;
        }
        .news-item .img{
            border-radius: 15px;
            transition: all .35s ease-in-out;
        }
        .news-item:hover .img{
            box-shadow: 3px 0 13px rgba(0,0,0,.19);
        }
        .news-item .img img{
            border-radius: 15px;
            width: 100%;
            height: 350px;
        }
        .news-content{
            background: var(--white);
            border-radius: 15px;
            text-align: center;
            width: 90%;
            margin: -40px auto 0;
            position: relative;
            padding: 15px ;
            transition: all .35s ease-in-out;
        }
        .news-item:hover .news-content{
            box-shadow: 3px 0 13px rgba(0,0,0,.19);
        }
        .news-content .desc{
            margin : 20px 0 ;
        }
        .news-content .url .main-btn a{
            color: var(--secondary) !important;
            border: 1px solid var(--secondary);
            background-color: transparent;
            transition: all .35s ease-in-out;
        }
        .news-item:hover  .news-content .url .main-btn a{
            color: var(--white) !important;
            border: 1px solid var(--primary);
            background-color: var(--primary);
        }

        @media (max-width: 768px) {
            .news-content{
                padding: 10px;
            }
            .news-content .desc{
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
                    تفاصيل الأخبار

                </h2>
            </div>--}}
            <div class="news-item">
                <div class="img">
                    <img loading="lazy" src="{{url(''.$data->image)}}" class="img-fluid" alt="">
                </div>
                <div class="news-content">
                    <div class="tit">
                        {{is_null($data->section) ? '' : $data->section->title_ar}}
                    </div>
                    <div class="tit">
                        {{$data->title}}
                    </div>
                    <div class="desc">
                        {!! $data->desc !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
@endsection