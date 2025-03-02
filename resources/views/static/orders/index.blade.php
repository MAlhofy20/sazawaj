@extends('site.master')
@section('title') الحجوزات @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <input type="hidden" id="page_number" value="1">
        <input type="hidden" id="booking_method" value="{{$booking_method}}">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <div class="card-header">
                <div class="col-12">
                    <div class="btns header-buttons">
                        @if(auth()->user()->user_type == 'market')
                            <a href="{{url('site-orders/new/' . $id)}}?booking_method={{$booking_method}}" class="btn waves-effect btn-lg waves-light" style="width: 220px;margin: 2px;color:white;background: #daa21c !important">الحجوزات قيد الانتظار</a>
                        @endif

                        <a href="{{url('site-orders/current/' . $id)}}?booking_method={{$booking_method}}" class="btn waves-effect btn-lg waves-light" style="width: 220px;margin: 2px;color:white;background: #35b8e0 !important">الحجوزات الحالية</a>

                        <a href="{{url('site-orders/finish/' . $id)}}?booking_method={{$booking_method}}" class="btn waves-effect btn-lg waves-light" style="width: 220px;margin: 2px;color:white;background: #10c469 !important">الحجوزات المنتهية</a>
                        <a href="{{url('site-orders/refused/' . $id)}}?booking_method={{$booking_method}}" class="btn waves-effect btn-lg waves-light" style="width: 220px;margin: 2px;color:white;background: #ed683d !important">الحجوزات الملغية</a>
                    </div>
                </div>
                <div class="col-12">
                    <h3>
                        @if($status == 'new') الحجوزات قيد الانتظار @endif
                        @if($status == 'current') الحجوزات الحالية @endif
                        @if($status == 'finish') الحجوزات المنتهية @endif
                        @if($status == 'refused') الحجوزات الملغية @endif
                    </h3>
                </div>
                {{--<div class="col-12">
                    <div class="btns header-buttons">
                        <label for="">عرض حسب}}</label>
                        <select name="" id="sortedBy" onchange="sortedBy()" class="form-control" style="width: 25%">
                        <option value="" {{$filter == '' ? 'selected' : ''}}>الكل</option>
                        <option value="day" {{$filter == 'day' ? 'selected' : ''}}>هذا اليوم</option>
                        <option value="month" {{$filter == 'month' ? 'selected' : ''}}>هذا الشهر</option>
                        <option value="year" {{$filter == 'year' ? 'selected' : ''}}>هذه السنة</option>
                        </select>
                    </div>
                </div>--}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="text-align: center">
                            {{-- <th>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input" id="checkedAll">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </th> --}}
                            <th>#</th>
                            <th>رقم الحجز</th>
                            <th>الصورة</th>
                            <th>الفرع</th>
                            <th>الاسم</th>
                            @if(auth()->user()->user_type != 'saler')
                                <th>رقم الجوال</th>
                                <th>رقم الهوية</th>
                                <th>تاريخ الميلاد</th>
                            @endif
                            <th>طريقة الحجز</th>
                            <th>نوع الحجز</th>
                            @if(auth()->user()->user_type != 'saler')
                                <th>طريقة الدفع</th>
                                <th>الاجمالي</th>
                            @endif
                            <th>تاريخ الحجز</th>
                            @if($status != 'new')
                                <th>
                                    الملفات المرفقة
                                </th>
                            @endif
                            <th></th>
                            @if(auth()->user()->user_type == 'market')
                                <th></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        <?php $payment  = ["cash" => "كاش", "transfer" => "تحويل بنكي", "online" => "اون لاين" , "not_now" => "الدفع اجلا"]; ?>
                        @foreach ($data as $i=>$item)
                            <tr style="text-align: center">
                                {{-- <td>
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input checkSingle" id="{{$item->id}}">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                </td> --}}
                                <td>{{ ++$i }}</td>
                                <td>{{$item->id}}</td>
                                <td>
                                    @if(!empty($item->file))
                                        <a href="{{url(''.$item->file)}}" target="_blank">عرض</a>
                                    @endif
                                </td>
                                <td>
                                    @if(is_null($item->provider))
                                        لا يوجد
                                    @else
                                        <div>
                                            <p>{{is_null($item->provider) ? '' : $item->provider->full_name}}</p>
                                            <a href="tel:{{convert_phone_to_international_format(is_null($item->provider) ? 0 : $item->provider->phone, '966')}}" target="_blanck">{{is_null($item->provider) ? 0 : $item->provider->phone}}</a>
                                        </div>
                                    @endif
                                </td>
                                <td>{{$item->name}}</td>
                                @if(auth()->user()->user_type != 'saler')
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->id_number}}</td>
                                    <td>{{$item->birthdate}}</td>
                                @endif
                                @php
                                    $payment  = [
                                        "now" => 'حجز الآن',
                                        "later" => 'حجز في وقت لاحق',
                                        "online" => 'الدفع اونلاين',
                                        "cash" => 'الدفع كاش',
                                        "point" => 'نقاط بيع'
                                    ];
                                    $type  = [
                                        "issuance" => 'إصدار',
                                        "renewal" => 'تجديد'
                                    ];
                                @endphp
                                <td>
                                    <p>{{isset($payment[$item->booking_method]) ? $payment[$item->booking_method] : 'حجز الآن'}}</p>
                                    @if($item->booking_method == 'later' && !empty($item->booking_later_date)) <p>{{date('Y-m-d', strtotime($item->booking_later_date))}}</p> @endif
                                    @if($item->booking_method == 'later' && !empty($item->booking_later_time)) <p>{{date('H:i', strtotime($item->booking_later_time))}}</p> @endif
                                </td>
                                <td>{{isset($type[$item->type]) ? $type[$item->type] : 'إصدار'}}</td>

                                @if(auth()->user()->user_type != 'saler')
                                    <td>{{isset($payment[$item->payment_method]) ? $payment[$item->payment_method] : 'كاش'}}</td>
                                    {{--<td>{{$item->total_before_promo}}</td>--}}
                                    <td>{{$item->total_after_promo}}</td>
                                    {{--<td>{{order_status($item->status)}}</td>--}}
                                @endif

                                <td>
                                    <p>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</p>
                                    <p>{{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</p>
                                </td>
                                @if($status != 'new')
                                    <td>
                                        @foreach($item->files as $file)
                                            <p>
                                                <span>{{$file->title}}</span>
                                                <a href="{{url('site-show-order/' . $file->id)}}" target="_blank">(عرض)</a>
                                            </p>
                                            {{--@if(auth()->id() == $file->user_id)--}}
                                            @if(auth()->user()->user_type == 'saler')
                                                <div class="btn-action">
                                                    <a href="#" class="btn btn-sm bg-teal" title="تعديل" onclick="editData({{$file}})" data-toggle="modal" data-target="#edit-file">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            {{--@endif--}}
                                            <hr>
                                        @endforeach
                                    </td>
                                @endif
                                <td>
                                    @if(auth()->user()->user_type == 'market')
                                        @if($status == 'new')
                                            <form action="{{route('site_changeorder')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{$item->id}}">
                                                <input type="hidden" name="status" value="current">

                                                <input type="number" name="discount_percent" max="{{settings('discount_percent_max')}}"
                                                       id="discount_percent" class="form-control"
                                                       placeholder="نسبة الخصم %" style="width: 130px">
                                                <button class="btn-success" style="width: 100%;margin-top: 5px;margin-bottom: 20px">قبول</button>
                                            </form>
                                            <hr>
                                            <form action="{{route('site_changeorder')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{$item->id}}">
                                                <input type="hidden" name="status" value="refused">

                                                <button class="btn-danger" style="width: 100%;margin-bottom: 5px">الغاء</button>
                                            </form>

                                        @endif

                                        @if($status == 'current')
                                            <form action="{{route('site_changeorder')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{$item->id}}">
                                                <input type="hidden" name="status" value="finish">

                                                <button class="btn-success" style="width: 100%;margin-bottom: 30px">انهاء</button>
                                            </form>
                                            <hr>
                                            <form action="{{route('site_changeorder')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{$item->id}}">
                                                <input type="hidden" name="status" value="refused">

                                                <button class="btn-danger" style="width: 100%;margin-bottom: 5px">الغاء</button>
                                            </form>

                                        @endif

                                        @if($status == 'finish' || $status == 'refused')
                                            <form action="{{route('site_changeorder')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{$item->id}}">
                                                <input type="hidden" name="status" value="current">

                                                <input type="number" name="discount_percent" value="0"
                                                       id="discount_percent" class="form-control"
                                                       placeholder="نسبة الخصم %" style="display: none">
                                                <button class="btn-success" style="width: 100%;margin-top: 5px;margin-bottom: 20px">استعادة</button>
                                            </form>
                                        @endif
                                    @endif



                                    @if(auth()->user()->user_type == 'saler')
                                        @php
                                            $report = App\Models\Order_file::where('order_id', $item->id)->latest()->first();
                                        @endphp
                                        @if(!isset($report))
                                            <div class="btn-action">
                                                <a href="#" class="btn btn-sm bg-teal" title="التقرير" onclick="addData({{$item}})" data-toggle="modal" data-target="#edit-admin{{$item->id}}">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>

                                            <!-- edit-admin modal-->
                                            <div class="modal fade" id="edit-admin{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">التقرير</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('site_add_order_report')}}" id="updateAdminForm" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="order_id" value="{{$item->id}}">
                                                                <input type="hidden" name="user_id" value="{{auth()->id()}}">
                                                                <div class="form-group" style="display: none">
                                                                    <label>عنوان التقرير</label>
                                                                    <input type="text" name="title" id="title" value="تقرير الفحص الطبي" class="form-control">
                                                                </div>
                                                                <div class="form-group" style="display:none;">
                                                                    <label>رفع البيانات للمنصه تبع وزاره الصحه</label>
                                                                    <select name="seha" class="form-control">
                                                                        <option value="0">لا</option>
                                                                        <option value="1">نعم</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>الاسم</label>
                                                                    <input type="text" name="name" id="name" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ID</label>
                                                                    <input type="text" name="report_number" id="report_number" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>TEL</label>
                                                                    <input type="text" name="phone" id="phone" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>D.O.B</label>
                                                                    <input type="text" name="dob" id="dob" class="form-control old_datepicker">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>اليمنى</label>
                                                                    <select name="right" id="right" class="form-control">
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>اليمنى بالتقويم</label>
                                                                    <select name="right_w" id="right_w" class="form-control">
                                                                        <option value="0">0</option>
                                                                        <option value="6">6</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>اليسرى</label>
                                                                    <select name="left" id="left" class="form-control">
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>اليسرى بالتقويم</label>
                                                                    <select name="left_w" id="left_w" class="form-control">
                                                                        <option value="0">0</option>
                                                                        <option value="6">6</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>تمييز الالوان</label>
                                                                    <select name="color" id="color" class="form-control">
                                                                        <option value="سليم">سليم</option>
                                                                        <option value="غير سليم">غير سليم</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ABO-Rh</label>
                                                                    <select name="blood_type" id="blood_type" class="form-control" dir="ltr">
                                                                        <option value="">فصيلة الدم</option>
                                                                        <option value="A+">A+</option>
                                                                        <option value="A-">A-</option>
                                                                        <option value="B+">B+</option>
                                                                        <option value="B-">B-</option>
                                                                        <option value="AB+">AB+</option>
                                                                        <option value="AB-">AB-</option>
                                                                        <option value="O+">O+</option>
                                                                        <option value="O-">O-</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>القيود</label>
                                                                    <!-- بدون قيود ، يحتاج نظارة ، يحتاج عدسات لاصقة -->
                                                                    <select name="notes" id="notes" class="form-control">
                                                                        <option value="بدون قيود">بدون قيود</option>
                                                                        <option value="يحتاج نظارة">يحتاج نظارة</option>
                                                                        <option value="يحتاج عدسات لاصقة">يحتاج عدسات لاصقة</option>
                                                                    </select>
                                                                </div>
                                                                <div class="d-flex justify-content-center">
                                                                    <button type="submit" class="btn btn-sm btn-success save">حفظ</button>
                                                                    <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end edit-admin modal-->
                                        @endif
                                    @endif
                                </td>

                                
                                @if(auth()->user()->user_type == 'market')
                                    <td>
                                        <div class="btn-action">
                                            <a href="#" class="btn btn-sm bg-teal" title="تعديل" onclick="updateData({{$item}})" data-toggle="modal" data-target="#edit-order{{$item->id}}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </div>

                                        <!-- edit-order modal-->
                                        <div class="modal fade" id="edit-order{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">تعديل الطلب</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('site_updateorder')}}" id="updateOrderForm" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$item->id}}">
                                                            <div class="form-group">
                                                                <label>نوع الطلب</label>
                                                                <select name="type" id="update_type" class="form-control">
                                                                    <option value="issuance" {{$item->type == 'issuance' ? 'selected' : ''}}>اصدار</option>
                                                                    <option value="renewal" {{$item->type == 'renewal' ? 'selected' : ''}}>تجديد</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>اجمالي الطلب</label>
                                                                <input type="text" name="total_after_promo" id="update_total_after_promo" value="{{$item->total_after_promo}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>الاسم</label>
                                                                <input type="text" name="name" id="update_name" value="{{$item->name}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>رقم الجوال</label>
                                                                <input type="text" name="phone" id="update_phone" value="{{$item->phone}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>رقم الهوية</label>
                                                                <input type="text" name="id_number" id="update_id_number" value="{{$item->id_number}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>تاريخ الميلاد</label>
                                                                <input type="text" name="birthdate" id="update_birthdate" value="{{$item->birthdate}}" class="form-control old_datepicker">
                                                            </div>
                                                            {{-- <div class="form-group">
                                                                <label>الصورة</label>
                                                                <input type="file" name="photo" id="photo" class="form-control">
                                                            </div> --}}
                                                            <div class="d-flex justify-content-center">
                                                                <button type="submit" class="btn btn-sm btn-success save">حفظ</button>
                                                                <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end edit-admin modal-->
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="allDepartmentsLinks">{{$data->links()}}</div>

                <!-- edit-admin modal-->
                <div class="modal fade" id="edit-file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">التقرير</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('site_update_order_report')}}" id="updateAdminForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" id="edit_id">
                                    <div class="form-group" style="display:none;">
                                        <label>عنوان التقرير</label>
                                        <input type="text" name="title" id="edit_title" class="form-control">
                                    </div>
                                    <div class="form-group" style="display:none;">
                                        <label>رفع البيانات للمنصه تبع وزاره الصحه</label>
                                        <select name="seha" class="form-control">
                                            <option value="0">لا</option>
                                            <option value="1">نعم</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>الاسم</label>
                                        <input type="text" name="name" id="edit_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>ID</label>
                                        <input type="text" name="report_number" id="edit_report_number" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>TEL</label>
                                        <input type="text" name="phone" id="edit_phone" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>D.O.B</label>
                                        <input type="text" name="dob" id="edit_dob" class="form-control old_datepicker">
                                    </div>
                                    <div class="form-group">
                                        <label>اليمنى</label>
                                        <select name="right" id="edit_right" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>اليمنى بالتقويم</label>
                                        <select name="right_w" id="edit_right_w" class="form-control">
                                            <option value="0">0</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>اليسرى</label>
                                        <select name="left" id="edit_left" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>اليسرى بالتقويم</label>
                                        <select name="left_w" id="edit_left_w" class="form-control">
                                            <option value="0">0</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>تمييز الالوان</label>
                                        <select name="color" id="edit_color" class="form-control">
                                            <option value="سليم">سليم</option>
                                            <option value="غير سليم">غير سليم</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>ABO-Rh</label>
                                        <select name="blood_type" id="edit_blood_type" class="form-control" dir="ltr">
                                            <option value="">فصيلة الدم</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>القيود</label>
                                        <!-- بدون قيود ، يحتاج نظارة ، يحتاج عدسات لاصقة -->
                                        <select name="notes" id="edit_notes" class="form-control">
                                            <option value="بدون قيود">بدون قيود</option>
                                            <option value="يحتاج نظارة">يحتاج نظارة</option>
                                            <option value="يحتاج عدسات لاصقة">يحتاج عدسات لاصقة</option>
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-sm btn-success save">حفظ</button>
                                        <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end edit-admin modal-->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('modal')

@endsection

@section('script')
    <script>
        function getUrlVars(url_with_query)
        {
            var vars = [], hash;
            var hashes = url_with_query.slice(url_with_query.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }

        $(document).on('click', '#allDepartmentsLinks a', function(e) {
            e.preventDefault();
            /*let sortedByName  = $('#sortedByName').val();
            let sortedByPhone = $('#sortedByPhone').val();
            let sortedByEmail = $('#sortedByEmail').val();
            let city          = $('#city').val();
            let section       = $('#section').val();
            let queries       = $(this).attr('href') + '&name=' + sortedByName + '&phone=' + sortedByPhone + '&email=' + sortedByEmail + '&city=' + city + '&section=' + section;
            console.log(queries);
            $('.allDepartmentsDiv').load(queries + ' .allDepartmentsDiv');
            $(window).scrollTop(0);*/

            let query_string = getUrlVars($(this).attr('href'));
            $('#page_number').val(query_string['page']);
            let page = query_string['page'];
            let booking_method = $('#booking_method').val();
            window.location.assign(`?page=${page}&booking_method=${booking_method}`);
        });

        function addData(item){
            $('#name').val(item.name);
            $('#phone').val(item.phone);
            $('#report_number').val(item.id_number);
            $('#dob').val(item.birthdate);
        }
        
        function updateData(item){
            //$('#edit_type').val(item.type);
            //$('#edit_name').val(item.name);
            //$('#edit_phone').val(item.phone);
            //$('#edit_id_number').val(item.id_number);
            //$('#edit_birthdate').val(item.birthdate);
        }

        function editData(item){
            $('#edit_id').val(item.id);
            $('#edit_title').val(item.title);
            $('#edit_name').val(item.name);
            $('#edit_report_number').val(item.report_number);
            $('#edit_phone').val(item.phone);
            $('#edit_dob').val(item.dob);
            $('#edit_right').val(item.right);
            $('#edit_right_w').val(item.right_w);
            $('#edit_left').val(item.left);
            $('#edit_left_w').val(item.left_w);
            $('#edit_color').val(item.color);
            $('#edit_blood_type').val(item.blood_type);
            $('#edit_notes').val(item.notes);
        }

        function deleteCountry(id){
            $('#delete_id').val(id);
        }

        function deleteAllCountry(type){
            $('#delete_type').val(type);
        }

        function checkDataIds(){
            let ids  = $('#delete_ids').val();
            let type = $('#delete_type').val();
            if(type != 'all' && ids == ''){
                event.preventDefault();
                $('#delete-all-modal').trigger('click');
            }
        }

        function checkIds(){
            let countrysIds = '';
            $('.checkSingle:checked').each(function () {
                let id = $(this).attr('id');
                countrysIds += id + ' ';
            });
            let requestData = countrysIds.split(' ');
            $('#delete_ids').val(requestData);
        }

        $("#checkedAll").change(function(){
            if(this.checked){
                $(".checkSingle").each(function(){
                    this.checked=true;
                });
            }else{
                $(".checkSingle").each(function(){
                    this.checked=false;
                });
            }
            checkIds();
        });

        $(".checkSingle").click(function () {
            if ($(this).is(":checked")){
                var isAllChecked = 0;
                $(".checkSingle").each(function(){
                    if(!this.checked)
                        isAllChecked = 1;
                })
                if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }
            }else {
                $("#checkedAll").prop("checked", false);
            }
            checkIds();
        });

        function sortedBy(){
            let sorted_by = $('#sortedBy').val();
            window.location.assign('?filter=' + sorted_by);
        }
    </script>
@endsection
