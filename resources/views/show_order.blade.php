@extends('master')
@section('title') {{$order->title}} @endsection
@section('style')
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Timelime example  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <div class="timeline">
                        <!-- timeline item -->
                        <div class="timeline-item-container">
                            <i class="fas fa-print bg-blue"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    <div class="bill-info">
                                        <a href="#" class="btn btn-info print" onclick="print_this_page()">طباعة</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- END timeline item -->
                        <!-- timeline item -->
                        <div>
                            <div class="timeline-item">
                                <h3 class="timeline-header">
                                    <i class="fas fa-info bg-blue"></i>
                                    {{$order->title}}</h3>
                                <div class="timeline-body">
                                    <div class="bill-info">
                                        <ul class="table-like-list">
                                            <li>
                                                <span class="label">رفع البيانات للمنصه تبع وزاره الصحه</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->seha == '1' ? 'نعم' : 'لا'}}</span>
                                            </li>
                                            <li>
                                                <span class="label">الاسم</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->name}}</span>
                                            </li>
                                            <li>
                                                <span class="label">ID</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->report_number}}</span>
                                            </li>
                                            <li>
                                                <span class="label">TEL</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->phone}}</span>
                                            </li>
                                            <li>
                                                <span class="label">D.O.B</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->dob}}</span>
                                            </li>
                                            <li>
                                                <span class="label">اليمنى</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->right}}</span>
                                            </li>
                                            <li>
                                                <span class="label">اليمنى بالتقويم</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->right_w}}</span>
                                            </li>
                                            <li>
                                                <span class="label">اليسرى</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->left}}</span>
                                            </li>
                                            <li>
                                                <span class="label">اليسرى بالتقويم</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->left_w}}</span>
                                            </li>
                                            <li>
                                                <span class="label">تمييز الالوان</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->color}}</span>
                                            </li>
                                            <li>
                                                <span class="label">ABO</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->blood_type}}</span>
                                            </li>
                                            <li>
                                                <span class="label">القيود</span>
                                                <span class="separator">:</span>
                                                <span class="value">{{$order->notes}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- END timeline item -->
                    </div>
                </div>
                <!-- /.col -->
         </div>
        <!-- /.timeline -->

    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        function print_this_page(){
            event.preventDefault();
            window.print();
        }
    </script>
@endsection