@extends('dashboard.master')
@section('title') تقارير الطلبات @endsection
@section('style')
    <style>
        .flex-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-content: center;
        }

        .form-group {
            margin: 10px;
            border: solid 0px;
            border-radius: 10px;
            padding: 5px;
            width: 100%;
            text-align: center;
            align-items: center;
            color: white;
            background-color: #5092c2;
        }

        /* Responsive layout - makes a one column layout instead of a two-column layout */
        @media (max-width: 1150px) {
            .flex-container {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <div class="row card-header">
                <div class="col-12">
                    <h3>
                        عرض حسب :
                    </h3>
                </div>
                <div class="col-2">
                    <div class="btns header-buttons">
                        <label for="">من تاريخ</label>
                        <input type="text" name="start_date" id="start_date" value="{{isset($queries['start_date']) ? $queries['start_date'] : ''}}" class="date form-control" placeholder="">
                    </div>
                </div>
                <div class="col-2">
                    <div class="btns header-buttons">
                        <label for="">الى تاريخ</label>
                        <input type="text" name="end_date" id="end_date" value="{{isset($queries['end_date']) ? $queries['end_date'] : ''}}" class="date form-control" placeholder="">
                    </div>
                </div>
                <div class="col-2">
                    <div class="btns header-buttons">
                        <label for="">رقم الهوية</label>
                        <select name="id_code" id="id_code" class="form-control" style="width: 100%">
                            <option value="" {{isset($queries['id_code']) && $queries['id_code'] == '' ? 'selected' : ''}}>الكل</option>
                            <option value="2" {{isset($queries['id_code']) && $queries['id_code'] == '2' ? 'selected' : ''}}>مقيم</option>
                            <option value="1" {{isset($queries['id_code']) && $queries['id_code'] == '1' ? 'selected' : ''}}>مواطن</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="btns header-buttons">
                        <label for="">نوع الطلب</label>
                        <select name="type" id="type" class="form-control" style="width: 100%">
                            <option value="" {{isset($queries['type']) && $queries['type'] == '' ? 'selected' : ''}}>الكل</option>
                            <option value="issuance" {{isset($queries['type']) && $queries['type'] == 'issuance' ? 'selected' : ''}}>إصدار</option>
                            <option value="renewal" {{isset($queries['type']) && $queries['type'] == 'renewal' ? 'selected' : ''}}>تجديد</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="btns header-buttons">
                        <label for="">طريقة الحجز</label>
                        <select name="booking_method" id="booking_method" class="form-control" style="width: 100%">
                            <option value="" {{isset($queries['booking_method']) && $queries['booking_method'] == '' ? 'selected' : ''}}>الكل</option>
                            <option value="now" {{isset($queries['booking_method']) && $queries['booking_method'] == 'now' ? 'selected' : ''}}>حجز الآن</option>
                            <option value="later" {{isset($queries['booking_method']) && $queries['booking_method'] == 'later' ? 'selected' : ''}}>حجز في وقت لاحق</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="btns header-buttons">
                        <label for="">حالة الطلب</label>
                        <select name="status" id="status" class="form-control" style="width: 100%">
                            <option value="" {{isset($queries['status']) && $queries['status'] == '' ? 'selected' : ''}}>الكل</option>
                            <option value="new" {{isset($queries['status']) && $queries['status'] == 'new' ? 'selected' : ''}}>طلبات قيد الانتظار</option>
                            <option value="current" {{isset($queries['status']) && $queries['status'] == 'current' ? 'selected' : ''}}>طلبات حالية</option>
                            <option value="finish" {{isset($queries['status']) && $queries['status'] == 'finish' ? 'selected' : ''}}>طلبات منتهية</option>
                            {{-- <option value="refused" {{isset($queries['status']) && $queries['status'] == 'refused' ? 'selected' : ''}}>طلبات ملغية</option> --}}
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="btns header-buttons">
                        <label for="">طريقة الدفع</label>
                        <select name="payment_method" id="payment_method" class="form-control" style="width: 100%">
                            <option value="" {{isset($queries['payment_method']) && $queries['payment_method'] == '' ? 'selected' : ''}}>الكل</option>
                            <option value="cash" {{isset($queries['payment_method']) && $queries['payment_method'] == 'cash' ? 'selected' : ''}}>الدفع كاش</option>
                            <option value="point" {{isset($queries['payment_method']) && $queries['payment_method'] == 'point' ? 'selected' : ''}}>نقاط بيع</option>
                            <option value="online" {{isset($queries['payment_method']) && $queries['payment_method'] == 'online' ? 'selected' : ''}}>الدفع اونلاين</option>
                        </select>
                    </div>
                </div>
                <div class="col-3" style="display: none">
                    <div class="btns header-buttons">
                        <label for="">العميل</label>
                        <select name="user" id="user" class="form-control select2" style="width: 100%">
                            <option value="" {{isset($queries['user']) && $queries['user'] == '' ? 'selected' : ''}}>الكل</option>
                            @foreach (App\Models\User::whereIn('user_type', ['client'])->orderBy('first_name','asc')->orderBy('last_name','asc')->get() as $item)
                                <option value="{{$item->id}}" {{isset($queries['user']) && $queries['user'] == $item->id ? 'selected' : ''}}>{{$item->name}} - {{$item->phone}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3" style="display: none">
                    <div class="btns header-buttons">
                        <label for="">جوال العميل</label>
                        <input type="text" name="phone" id="phone" class="phone form-control" value="{{isset($queries['phone']) ? $queries['phone'] : ''}}" style="width: 100%">
                    </div>
                </div>
                <div class="col-3" style="display: none">
                    <div class="btns header-buttons">
                        <label for="">مقدمين الخدمات</label>
                        <select name="market" id="market" class="form-control select2" style="width: 100%">
                            <option value="" {{isset($queries['market']) && $queries['market'] == '' ? 'selected' : ''}}>الكل</option>
                            <optgroup label="الملاعب">
                                @foreach (App\Models\User::whereIn('user_type', ['market'])->orderBy('first_name','asc')->orderBy('last_name','asc')->get() as $item)
                                    <option value="{{$item->id}}" {{isset($queries['market']) && $queries['market'] == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="المدربين">
                                @foreach (App\Models\User::whereIn('user_type', ['provider'])->orderBy('first_name','asc')->orderBy('last_name','asc')->get() as $item)
                                    <option value="{{$item->id}}" {{isset($queries['provider']) && $queries['provider'] == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="btns header-buttons">
                        <label for="">الفروع</label>
                        <select name="provider" id="provider" class="form-control select2" style="width: 100%">
                            <option value="" {{isset($queries['provider']) && $queries['provider'] == '' ? 'selected' : ''}}>الكل</option>
                            @foreach (App\Models\User::whereIn('user_type', ['provider'])->orderBy('first_name','asc')->orderBy('last_name','asc')->get() as $item)
                                <option value="{{$item->id}}" {{isset($queries['provider']) && $queries['provider'] == $item->id ? 'selected' : ''}}>{{$item->full_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-3">
                    <div class="btns header-buttons">
                        <label for="" style="color: white">بحث</label>
                        <a class="btn btn-success form-control" onclick="sortedBy()" title="بحث"><i class="fa fa-search"></i></a>
                    </div>
                </div>
            </div>
            @if(isset($queries['show']) && !empty($queries['show']))
                <div class="card-body">
                    {{--<div class="flex-container">
                        <div class="form-group">
                            <p>عدد الطلبات: <span>{{count($data)}}</span></p>
                            <p>اجمالي الطلبات: <span>{{$total}}</span></p>
                        </div>
                        <div class="form-group">
                            <p>عدد الطلبات كاش: <span>{{$cash_count}}</span></p>
                            <p>اجمالي الطلبات كاش: <span>{{$cash}}</span></p>
                        </div>
                        <div class="form-group">
                            <p>عدد الطلبات اونلاين: <span>{{$online_count}}</span></p>
                            <p>اجمالي الطلبات اونلاين: <span>{{$online}}</span></p>
                        </div>
                    </div>--}}
                    <div class="flex-container">
                        <div class="form-group">
                            <p>اجمالي عدد الطلبات: <span>{{count($data)}}</span></p>
                            <p>اجمالي الطلبات: <span>{{$total}} ريال</span></p>
                        </div>
                        <div class="form-group">
                            <p>عدد الرخص اصدار: <span>{{$issuance_count}}</span></p>
                            <p>اجمالي الرخص اصدار: <span>{{$issuance}} ريال</span></p>
                        </div>
                        <div class="form-group">
                            <p>عدد الرخص تجديد: <span>{{$renewal_count}}</span></p>
                            <p>اجمالي الرخص تجديد: <span>{{$renewal}} ريال</span></p>
                        </div>
                    </div>
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
                                <th>رقم الجوال</th>
                                <th>رقم الهوية</th>
                                <th>تاريخ الميلاد</th>
                                <th>طريقة الحجز</th>
                                <th>نوع الحجز</th>
                                <th>طريقة الدفع</th>
                                <th>الاجمالي قبل الخصم</th>
                                <th>الاجمالي بعد الخصم</th>
                                <th>حالة الحجز</th>
                                <th>تاريخ الحجز</th>
                                <th>
                                    الملفات المرفقة
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $payment  = ["cash" => "كاش", "point" => "نقاط بيع", "transfer" => "تحويل بنكي", "online" => "اون لاين" , "not_now" => "الدفع اجلا"]; ?>
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
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->id_number}}</td>
                                    <td>{{$item->birthdate}}</td>
                                    @php
                                        $payment  = [
                                            "now" => 'حجز الآن',
                                            "later" => 'حجز في وقت لاحق',
                                            "online" => 'الدفع اونلاين',
                                            "cash" => 'الدفع كاش',
                                            "point" => 'نقاط بيع',
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
                                    <td>{{isset($payment[$item->payment_method]) ? $payment[$item->payment_method] : 'كاش'}}</td>
                                    <td>{{$item->total_before_promo}}</td>
                                    <td>{{$item->total_after_promo}}</td>
                                    <td>{{order_status($item->status)}}</td>

                                    <td>
                                        <p>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</p>
                                        <p>{{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</p>
                                    </td>
                                    <td>
                                        @foreach($item->files as $file)
                                            <p>
                                                <span>{{$file->title}}</span>
                                                <a href="{{url(''.$file->file)}}" target="_blank">(عرض)</a>
                                            </p>
                                            <hr>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('modal')
    <!-- confirm-del modal-->
    <div class="modal fade" id="confirm-del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        هل تريد الاستمرار في عملية الحذف ؟
                    </h3>
                    <form action="{{route('deletecountry')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="id" id="delete_id">
                        <button type="submit" class="btn btn-sm btn-success">تأكيد</button>
                        <button class="btn btn-sm btn-danger" data-dismiss="modal">إلغاء</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end confirm-del modal-->
    <!-- confirm-del-all modal-->
    <div class="modal fade" id="confirm-all-del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        هل تريد الاستمرار في عملية الحذف ؟
                    </h3>
                    <form action="{{route('deletecountrys')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="country_ids" id="delete_ids">
                        <input type="hidden" name="type" id="delete_type">
                        <button type="submit" onclick="checkDataIds()" class="btn btn-sm btn-success">تأكيد</button>
                        <button class="btn btn-sm btn-danger" id="delete-all-modal" data-dismiss="modal">إلغاء</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end confirm-del-all modal-->
@endsection

@section('script')
    <script>
        function sortedBy(){
            let start_date     = $('#start_date').val();
            let end_date       = $('#end_date').val();
            let status         = $('#status').val();
            let phone          = $('#phone').val();
            let user           = $('#user').val();
            let provider       = $('#provider').val();
            let market         = $('#market').val();
            let city           = $('#city').val();
            let type           = $('#type').val();
            let booking_method = $('#booking_method').val();
            let payment_method = $('#payment_method').val();
            let id_code        = $('#id_code').val();
            window.location.assign('?show=1&start_date=' + start_date + '&end_date=' + end_date+ '&status=' + status + '&phone=' + phone + '&user=' + user + '&provider=' + provider + '&market=' + market + '&city=' + city + '&type=' + type + '&booking_method=' + booking_method + '&id_code=' + id_code + '&payment_method=' + payment_method);
        }
    </script>
@endsection
