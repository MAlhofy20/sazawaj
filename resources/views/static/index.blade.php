@extends('site.master')
@section('title') {{Translate('الرئيسية')}} @endsection
@section('style')
    <style>
        .main-input {
            height: 100%;
            line-height: 40px;
            border: 1px solid #C6C6C6;
            padding: 0 15px;
            position: relative;
            overflow: hidden;
            height: 40px;
        }

        .main-input .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            right: 0;
            height: 100%;
        }

        .main-input i {
            position: absolute;
            width: 40px;
            text-align: center;
            height: 40px;
            line-height: 40px;
            z-index: 3;
            right: 0;
            left: auto;
            font-size: 20px;
        }

        .file-name {
            font-size: 14px;
            color: #928d8d;
            white-space: nowrap;
        }

        .main-input .uploaded-image {
            position: absolute;
            top: 50%;
            height: auto;
            right: 0;
            z-index: 9;
            transform: translate(0, -50%);
            cursor: pointer;
            transition: all .3s;
        }

        .main-input .uploaded-image img {
            max-height: 40px;
            min-width: 40px;
            display: block;
            border-radius: 8px;
            transition: all .3s;
            height: 100%;
        }

        .main-input .uploaded-image.active img {
            max-height: 240px;
            min-width: auto;
            max-width: calc(100vw - 20px);
            margin: auto;
            height: auto;
        }

        .main-input .uploaded-image.active {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999999;
            width: auto;
            height: auto;
            box-shadow: none;
        }

        .btns {
            padding: 15px 0;
        }

        #confirm-del form {
            justify-content: center;
        }
        .card-footer a i{
            margin:  0 5px;
        }
        #confirm-del form button ,
        #add-user form button,
        #edit-user form button {
            margin: 5px;
        }

        .modal .modal-header .close {
            margin: 0;
            padding: 0;
            color: #fff
        }

        .modal .modal-header {
            align-items: center;
            padding: 10px;
            background-color: #343a40;
            color: #fff
        }

        .search-div form .form-in:not(:last-child),
        .search-div form .form-in:not(:last-child)+span {
            margin-right: 10px;
        }

        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
        }

        .bootstrap-switch {
            position: absolute;
            right: 16px;
            top: 6px;
            z-index: 99;
        }

        .mark-user .custom-control-label::before,
        .mark-user .custom-control-label::after {
            top: 8px;
            left: 0;
            width: 20px;
            height: 20px;
        }

        .showIndexData{
            height: 275px;
        }

    </style>
@endsection

@section('content')
    <!-- Main content -->
    @php
        $provider_id = auth()->user()->user_type == 'provider' ? auth()->id() : auth()->user()->provider_id;
    @endphp
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                @if(auth()->user()->user_type == 'market')
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="{{url('site-orders/new/'.auth()->id())}}?booking_method=now">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">الحجوزات قيد الانتظار (الان)</span>
                                    <span class="info-box-number">
                                        {{ App\Models\Order::where('booking_method', 'now')->where('provider_id', $provider_id)->where('status' , 'new')->count() }}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                @endif
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{url('site-orders/current/'.auth()->id())}}?booking_method=now">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">الحجوزات الحالية (الان)</span>
                                <span class="info-box-number">
                                    {{ App\Models\Order::where('booking_method', 'now')->where('provider_id', $provider_id)->where('status' , 'current')->count() }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{url('site-orders/finish/'.auth()->id())}}?booking_method=now">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">الحجوزات المنتهية (الان)</span>
                                <span class="info-box-number">
                                    {{ App\Models\Order::where('booking_method', 'now')->where('provider_id', $provider_id)->where('status' , 'finish')->count() }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{url('site-orders/refused/'.auth()->id())}}?booking_method=now">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">الحجوزات الملغية (الان)</span>
                                <span class="info-box-number">
                                    {{ App\Models\Order::where('booking_method', 'now')->where('provider_id', $provider_id)->where('status' , 'refused')->count() }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                @if(auth()->user()->user_type == 'market')
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="{{url('site-orders/new/'.auth()->id())}}?booking_method=later">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">الحجوزات قيد الانتظار (اللاحقة)</span>
                                    <span class="info-box-number">
                                        {{ App\Models\Order::where('booking_method', 'later')->where('provider_id', $provider_id)->where('status' , 'new')->count() }}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                @endif
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{url('site-orders/current/'.auth()->id())}}?booking_method=later">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">الحجوزات الحالية (اللاحقة)</span>
                                <span class="info-box-number">
                                    {{ App\Models\Order::where('booking_method', 'later')->where('provider_id', $provider_id)->where('status' , 'current')->count() }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{url('site-orders/finish/'.auth()->id())}}?booking_method=later">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">الحجوزات المنتهية (اللاحقة)</span>
                                <span class="info-box-number">
                                    {{ App\Models\Order::where('booking_method', 'later')->where('provider_id', $provider_id)->where('status' , 'finish')->count() }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{url('site-orders/refused/'.auth()->id())}}?booking_method=later">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">الحجوزات الملغية (اللاحقة)</span>
                                <span class="info-box-number">
                                    {{ App\Models\Order::where('booking_method', 'later')->where('provider_id', $provider_id)->where('status' , 'refused')->count() }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('script')  @endsection
