@extends('dashboard.master')
@section('title') الطلبات @endsection
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
                        <div>
                            <i class="fas fa-print bg-blue"></i>
                            <div class="timeline-item">


                                <div class="timeline-body">
                                    <div class="bill-info">
                                        <a href="#" class="btn btn-info print" onclick="print_this_page()">طباعة</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END timeline item -->
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-info bg-blue"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">{{$order->title}}</h3>

                                <div class="timeline-body">
                                    <div class="bill-info">
                                        <ul>
                                            {{--<li class="text-bold">
                                                <span>عنوان التقرير</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->title}}</span>
                                            </li>--}}
                                            <li class="text-bold">
                                                <span>الاسم</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->name}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>ID</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->report_number}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>TEL</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->phone}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>D.O.B</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->dob}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>اليمنى</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->right}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>اليمنى بالتقويم</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->right_w}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>اليسرى</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->left}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>اليسرى بالتقويم</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->left_w}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>تمييز الالوان</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->color}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>ABO</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->blood_type}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>القيود</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{$order->notes}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>رفع البيانات للمنصه تبع وزاره الصحه</span>
                                                <span>:</span>
                                                <br>
                                                <span>{{is_null($order->order) ? '' : $order->order->data_upload == '1' ? 'نعم' : 'لا'}}</span>
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
        </div>
        <!-- /.timeline -->

    </section>
    <!-- /.content -->
@endsection

@section('modal')
    <!-- confirm-del modal-->
    <div class="modal fade" id="notes-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ملاحظات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center" id="notes">

                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!--end confirm-del modal-->
@endsection

@section('script')
    <script>
        function showNotes(notes) {
            if (notes == '') notes = 'لا يوجد ملاحظات';
            $('#notes').html(notes);
        }

        function print_this_page(){
            event.preventDefault();
            window.print();
        }
    </script>
@endsection
