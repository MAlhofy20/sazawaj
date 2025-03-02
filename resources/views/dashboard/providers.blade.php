@extends('dashboard.master')
@section('title') الفروع @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <div class="card-header">
                <div class="col-12">
                    <div class="btns header-buttons">
                        <button class="btn bg-teal" title="اضافة" data-toggle="modal"
                                data-target="#add-provider">
                            <i class="fas fa-plus"></i>
                        </button>
                        {{-- <button class="btn bg-warning" onclick="sendNotify('all' , '0')" data-toggle="modal"
                            data-target="#send-noti">
                            <i class="fas fa-paper-plane"></i>
                            إرسال للكل
                        </button> --}}
                        <button class="btn btn-danger" onclick="deleteAllProvider('more')" data-toggle="modal"
                                data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف المحدد
                        </button>
                        {{-- <button class="btn btn-danger" onclick="deleteAllProvider('all')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            {{Translate('حذف الكل')}}
                        </button> --}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <div class="btns header-buttons">
                            <input type="text" id="sortedByName"
                                   value="{{ isset($queries['name']) ? $queries['name'] : '' }}" class="form-control"
                                   style="" placeholder="بحث بالاسم">
                        </div>
                    </div>

                    <div class="col-3" style="display: none">
                        <div class="btns header-buttons">
                            <input type="text" id="sortedByPhone"
                                   value="{{ isset($queries['phone']) ? $queries['phone'] : '' }}" class="form-control phone"
                                   style="" placeholder="بحث بالجوال">
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="btns header-buttons">
                            <input type="email" id="sortedByEmail"
                                   value="{{ isset($queries['email']) ? $queries['email'] : '' }}" class="form-control"
                                   style="" placeholder="بحث بالايميل">
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="btns header-buttons">
                            <label for=""></label>
                            <a href="#" onclick="sortedByData()" id="sortedByButton" class="btn btn-success" style="">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-button" class="table table-bordered table-striped">
                        <thead>
                        <tr style="text-align: center">
                            <th>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input" id="checkedAll">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </th>
                            <th>#</th>
                            <th>الصورة</th>
                            {{-- <th>تواجد الفرع</th> --}}
                            <th>الأسم</th>
                            {{--<th>الجوال</th>--}}
                            <th>البريد الإلكتروني</th>
                            <th>سعر خدمة الاصدار</th>
                            <th>سعر خدمة التجديد</th>
                            <th>Qr Code</th>
                            <th>ملاحظات الفرع</th>
                            {{--<th>حالة الفرع</th>--}}
                            <th>وقت التسجيل</th>
                            <th>التحكم</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $i => $item)
                            <tr style="text-align: center">
                                <td>
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input checkSingle"
                                               id="{{ $item->id }}">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                </td>
                                <td>{{ ++$i }}</td>
                                <td>
                                    <a data-fancybox data-caption="{{ $item->name }}"
                                       href="{{ url('' . $item->avatar) }}">
                                        <img src="{{ url('' . $item->avatar) }}" height="40px" width="35px" alt=""
                                             class="img-circle">
                                    </a>
                                </td>
                                {{-- <td>{{ $item->login ? 'متصل' : 'غير متصل' }}</td> --}}
                                <td>{{ $item->full_name }}</td>
                                {{--<td>
                                    <a href="tel:{{ $item->full_phone }}" target="_blanck">{{ $item->phone }}</a>
                                </td>--}}
                                <td><a href="mailto:{{$item->email}}" target="_blanck">{{$item->email}}</a></td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->renewal_price}}</td>
                                <td>
                                    <a href="{{route('show-qrcode', ['id' => $item->id])}}" class="btn btn-info" target="_blanck">عرض</a>
                                </td>
                                <td>
                                    <a href="{{route('user_notes', ['user_id' => $item->id])}}" class="btn btn-info">عرض</a>
                                </td>
                                {{-- <td>{{$item->address}}</td> --}}
                                {{-- <td>
                                    <div class="confirm" id="confirm-{{ $item->id }}">
                                        @if ($item->confirm == '0')
                                            <a href="#" onclick="confirmUser('{{ $item->id }}')"
                                                class="btn btn-success">تفعيل الحساب</a>
                                        @else حساب مفعل
                                        @endif

                                        <p id="confirm-err-{{ $item->id }}" style="color: red;margin-top: 2px"></p>
                                    </div>
                                </td> --}}
                                {{--@php
                                    $all_orders      = App\Models\Order::whereProviderId($item->id)->count();  
                                    $new_orders      = App\Models\Order::whereProviderId($item->id)->where('status', 'new')->count();  
                                    $current_orders  = App\Models\Order::whereProviderId($item->id)->where('status', 'current')->count();  
                                    $finish_orders   = App\Models\Order::whereProviderId($item->id)->where('status', 'finish')->count();  
                                    $refused_orders  = App\Models\Order::whereProviderId($item->id)->where('status', 'refused')->count();  
                                    $current_orders_total = App\Models\Order::whereProviderId($item->id)->where('status', 'current')->sum('total_after_promo');  
                                    $finish_orders_total  = App\Models\Order::whereProviderId($item->id)->where('status', 'finish')->sum('total_after_promo');  
                                @endphp
                                <td>
                                    {{$all_orders}}
                                </td>
                                <td>
                                    {{$new_orders}}
                                </td>
                                <td>
                                    {{$current_orders}}
                                </td>
                                <td>
                                    {{$finish_orders}}
                                </td>
                                <td>
                                    {{$refused_orders}}
                                </td>
                                <td>
                                    {{$current_orders_total}}
                                </td>
                                <td>
                                    {{$finish_orders_total}}
                                </td>--}}
                                {{--<td>
                                    <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        --}}{{-- <label class="custom-control-label" for="customSwitch3">{{Translate('حظر')}}</label> --}}{{--
                                        <input type="checkbox" onchange="changeProviderStatus('{{ $item->id }}')"
                                               {{ $item->blocked ? '' : 'checked' }} class="custom-control-input"
                                               id="customSwitch{{ $item->id }}">
                                        <label class="custom-control-label" id="status_label{{ $item->id }}"
                                               for="customSwitch{{ $item->id }}">{{ $item->blocked ? Translate('حظر') : Translate('مفعل') }}</label>
                                    </div>
                                </td>--}}
                                <td>
                                     <p>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</p>
                                     <p>{{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</p>
                                </td>
                                <td>
                                    <div class="btn-action">
                                        {{-- <a href="#" class="btn btn-sm btn-primary" title="عرض"
                                            onclick="showProvider({{ $item }})" data-toggle="modal"
                                            data-target="#provider-profile">
                                            <i class="fas fa-provider"></i>
                                        </a> --}}

                                        {{-- <a href="#" class="btn btn-sm btn-warning"
                                            title="إرسال إشعار"
                                            onclick="sendNotify('one' , '{{ $item->id }}')" data-toggle="modal"
                                            data-target="#send-noti">
                                            <i class="fas fa-paper-plane"></i>
                                        </a> --}}

                                        <a href="#" class="btn btn-sm bg-teal" title="تعديل"
                                           onclick="editProvider({{ $item }})" data-toggle="modal"
                                           data-target="#edit-provider">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-danger" title="حذف"
                                           onclick="deleteProvider('{{ $item->id }}')" data-toggle="modal"
                                           data-target="#confirm-del">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $data->links() }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('modal')
    <!-- provider-profile modal-->
    <div class="modal fade provider-profile" id="provider-profile" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="img-div">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <a id="show_avatar_fancy" data-fancybox data-caption="" href="">
                            <img id="show_avatar" src="" alt="">
                        </a>
                    </div>
                    <div class="provider-d text-center">
                        <p class="name" id="show_name"></p>
                        <ul>
                            <li style="display:none;">
                                <i class="fa fa-phone"></i>
                                <a id="show_phone" href="">

                                </a>
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <a id="show_email" href="">
        
                                </a>
                            </li> 
                            {{-- <li>
                        <i class="fa fa-home"></i>
                        <span id="show_address"></span>
                    </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end provider-profile modal-->
    <!-- send-noti modal-->
    <div class="modal fade" id="send-noti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إرسال أشعار</h5>
                    <button type="button" id="notifyClose" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sendnotifyprovider') }}" id="sendnotifyproviderForm" method="POST">
                        @csrf
                        <input type="hidden" name="type" id="notify_type">
                        <input type="hidden" name="id" id="notify_id">
                        <div class="form-group">
                            <label for="">
                                الرسالة
                            </label>
                            <textarea name="message" id="notifyMessage" cols="30" rows="4" class="form-control"
                                      placeholder="اكتب رسالتك ..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success save"
                                onclick="sendnotifyprovider()">إرسال</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end send-noti modal-->
    <!-- add-provider modal-->
    <div class="modal fade" id="add-provider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة فرع</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addprovider') }}" id="addProviderForm" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>الصورة الشخصية</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photo" accept="image/*" />
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                                <div class="uploaded-image"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>الأسم بالعربية</label>
                            <input type="text" name="full_name_ar" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>الأسم بالانجليزية</label>
                            <input type="text" name="full_name_en" id="" dir="ltr" class="form-control">
                        </div>
                        {{--<div class="form-group">
                            <label>{{Translate('الأسم الاخير')}}</label>
                            <input type="text" name="last_name" class="form-control">
                        </div> --}}
                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" dir="ltr" class="form-control">
                        </div>
                        {{-- <div class="form-group">
                            <label>{{Translate('كود الدولة')}}</label>
                            <select name="phone_code" id="" class="form-control">
                                @foreach (get_countries('code') as $item)
                                    <option value="{{$item->code}}">{{$item->code}} - {{$item->title}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{--<div class="form-group">
                            <label>الجوال</label>
                            <input type="text" name="phone" class="form-control phone">
                        </div>--}}
                        {{-- <div class="form-group">
                            <label>المدينة</label>
                            <select name="city_id" id="city_id" class="form-control" onchange="get_neighborhood('')">
                                @foreach (App\Models\City::orderBy('title_ar')->get() as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>الاحياء<span style="color: red">( لاختيار اكثر من حي اضغط ctrl اثناء الاختيار)</span></label>
                            <select name="neighborhood_ids[]" id="neighborhood_id" class="form-control" multiple>

                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label>سعر خدمة الاصدار</label>
                            <input type="number" name="price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>سعر خدمة التجديد</label>
                            <input type="number" name="renewal_price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>وقت بداية العمل</label>
                            <input type="time" name="start_time" class="form-control" dir="ltr">
                        </div>
                        <div class="form-group">
                            <label>وقت نهاية العمل</label>
                            <input type="time" name="end_time" class="form-control" dir="ltr">
                        </div>
                        <div class="form-group" style="margin-bottom: 10px;display: none">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="defaultCheck1" style="">
                                    طرق الدفع :
                                </label>
                            </div>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="by_cash" value="1" id="test1" checked>
                                <label class="form-check-label" for="test1" style="margin-right: 5px">
                                    الدفع كاش
                                </label>
                            </div>
                            {{-- <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="by_transfer" value="1" id="test3">
                                <label class="form-check-label" for="test3" style="margin-right: 5px">
                                    الدفع بالتحويل البنكي
                                </label>
                            </div> --}}
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="by_online" value="1" id="test2" checked>
                                <label class="form-check-label" for="test2" style="margin-right: 5px">
                                    الدفع اونلاين
                                </label>
                            </div>
                        </div>
                        <div class="form-group" style="position: relative;">
                            <input type="hidden" name="lat" id="lat" value="24.774265" readonly />
                            <input type="hidden" name="lng" id="lng" value="46.738586" readonly />
                            <div class="col-sm-12" id="add_map"></div>
                        </div>
                        <div class="form-group">
                            <label>كلمة المرور</label>
                            <input type="password" name="password" value="123456" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="addProvider()"
                                    class="btn btn-sm btn-success save">حفظ</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end add-provider modal-->
    <!-- edit-provider modal-->
    <div class="modal fade" id="edit-provider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل فرع</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateprovider') }}" id="updateProviderForm" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label>الصورة الشخصية</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photo" accept="image/*" />
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                                <div class="uploaded-image">
                                    <img src="" id="edit_avatar" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>الأسم بالعربية</label>
                            <input type="text" name="full_name_ar" id="edit_full_name_ar" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>الأسم بالانجليزية</label>
                            <input type="text" name="full_name_en" id="edit_full_name_en" dir="ltr" class="form-control">
                        </div>
                        {{-- <div class="form-group">
                            <label>{{Translate('الأسم الاخير')}}</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control">
                        </div> --}}
                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" dir="ltr" class="form-control">
                        </div>
                        {{-- <div class="form-group">
                            <label>{{Translate('كود الدولة')}}</label>
                            <select name="phone_code" id="edit_phone_code" class="form-control">
                                @foreach (get_countries('code') as $item)
                                    <option value="{{$item->code}}">{{$item->code}} - {{$item->title}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{--<div class="form-group">
                            <label>الجوال</label>
                            <input type="text" name="phone" class="form-control phone" id="edit_phone">
                        </div>--}}
                        {{-- <div class="form-group">
                            <label>المدينة</label>
                            <select name="city_id" id="edit_city_id" class="form-control" onchange="get_neighborhood('edit_')">
                                @foreach (App\Models\City::orderBy('title_ar')->get() as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>الاحياء<span style="color: red">( لاختيار اكثر من حي اضغط ctrl اثناء الاختيار)</span></label>
                            <select name="neighborhood_ids[]" id="edit_neighborhood_id" class="form-control" multiple>

                            </select>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label>{{Translate('العنوان')}}</label>
                            <input type="text" name="address" id="edit_address" class="form-control">
                        </div> --}}

                        <div class="form-group">
                            <label>سعر خدمة الاصدار</label>
                            <input type="number" name="price" id="edit_price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>سعر خدمة التجديد</label>
                            <input type="number" name="renewal_price" id="edit_renewal_price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>وقت بداية العمل</label>
                            <input type="time" name="start_time" id="edit_start_time" class="form-control" dir="ltr">
                        </div>
                        <div class="form-group">
                            <label>وقت نهاية العمل</label>
                            <input type="time" name="end_time" id="edit_end_time" class="form-control" dir="ltr">
                        </div>
                        <div class="form-group" style="margin-bottom: 10px;display: none">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="defaultCheck1" style="">
                                    طرق الدفع :
                                </label>
                            </div>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="by_cash" value="1" id="cash">
                                <label class="form-check-label" for="cash" style="margin-right: 5px">
                                    الدفع كاش
                                </label>
                            </div>
                            {{-- <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="by_transfer" value="1" id="transfer">
                                <label class="form-check-label" for="transfer" style="margin-right: 5px">
                                    الدفع بالتحويل البنكي
                                </label>
                            </div> --}}
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="by_online" value="1" id="online">
                                <label class="form-check-label" for="online" style="margin-right: 5px">
                                    الدفع اونلاين
                                </label>
                            </div>
                        </div>
                        <div class="form-group" style="position: relative;">
                            <input type="hidden" name="lat" id="edit_lat" value="24.774265" readonly />
                            <input type="hidden" name="lng" id="edit_lng" value="46.738586" readonly />
                            <div class="col-sm-12" id="edit_add_map"></div>
                        </div>
                        <div class="form-group">
                            <label>كلمة المرور</label>
                            <input type="password" name="password" id="edit_password" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="updateProvider()"
                                    class="btn btn-sm btn-success save">حفظ</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-provider modal-->
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
                    <form action="{{ route('deleteprovider') }}" method="post" class="d-flex align-items-center">
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
                    <form action="{{ route('deleteproviders') }}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="user_ids" id="delete_ids">
                        <input type="hidden" name="type" id="delete_type">
                        <button type="submit" onclick="checkDataIds()"
                                class="btn btn-sm btn-success">تأكيد</button>
                        <button class="btn btn-sm btn-danger" id="delete-all-modal"
                                data-dismiss="modal">إلغاء</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end confirm-del-all modal-->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // get_neighborhood('');
        });

        function sortedByData() {
            event.preventDefault();
            let sortedByName = $('#sortedByName').val();
            let sortedByPhone = $('#sortedByPhone').val();
            let sortedByEmail = $('#sortedByEmail').val();

            window.location.assign('providers?name=' + sortedByName + '&phone=' + sortedByPhone + '&email=' +
                sortedByEmail);
        }

        $(function() {
            $(document).on("change", ".file-input", function() {
                let input = $(this),
                    uploadedImage = input.siblings(".uploaded-image"),
                    placeHolder = input.siblings(".placeholder"),
                    fileName = input.parent().find(".file-name"),
                    plus = input.siblings("i.fas.fa-camera");
                if (input.val() === "") {
                    fileName.empty();
                    uploadedImage.empty();
                    placeHolder.removeClass("active");
                    plus.fadeIn(100);
                } else {
                    plus.fadeOut(100);
                    fileName.text(input.val().replace("C:\\fakepath\\", ""));
                    uploadedImage.empty();
                    uploadedImage.append('<img src="' + URL.createObjectURL(event.target.files[0]) + '">');
                }
            });

            $(document).on("click", ".file-name", function() {
                $(this).siblings(".file-input").click();
            });

            $(document).on("click", ".uploaded-image", function() {
                $(this).addClass("active");
            });

            $("body").on("click", function() {
                $('.uploaded-image').removeClass("active");
            });

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
                $('#label-switch').bootstrapSwitch('onText', 'I');
                $('#label-switch').bootstrapSwitch('offText', 'O');
            });

        });

        function changeProviderStatus(id) {
            var tokenv = "{{ csrf_token() }}";
            $.ajax({
                type: 'POST',
                url: '{{ route('changestatusprovider') }}',
                datatype: 'json',
                data: {
                    'id': id,
                    '_token': tokenv
                },
                success: function(msg) {
                    //success here
                    if (msg == 0)
                        return false;
                    else
                        $('#status_label' + id).html(msg);
                }
            });
        }

        function sendNotify(type, id) {
            $('#notify_type').val(type);
            $('#notify_id').val(id);
            $('#notifyMessage').html('');
        }

        function addProvider() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('addprovider') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#addProviderForm")[0]),
                success: function(msg) {
                    if (msg.value == '0') {
                        stop_loader();
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    } else {
                        window.location.reload();
                    }
                }
            });
        }

        function showProvider(provider) {
            $('#show_name').html(provider.full_name_ar);
            $('#show_phone').html(provider.phone);
            $('#show_phone').removeAttr('href');
            $('#show_phone').attr('href', "tel:" + provider.phone);
            $('#show_email').html(provider.email);
            $('#show_email').removeAttr('href');
            $('#show_email').attr('href', "mailto:" + provider.email);
            // $('#show_address').html(provider.address);
            $('#show_avatar').removeAttr('src');
            $('#show_avatar').attr('src', "{{ url('') }}" + provider.avatar);
            $('#show_avatar_fancy').removeAttr('data-caption');
            $('#show_avatar_fancy').attr('data-caption', provider.name);
            $('#show_avatar_fancy').removeAttr('href');
            $('#show_avatar_fancy').attr('href', "{{ url('') }}" + provider.avatar);
        }

        function get_neighborhood(id = '', city_id = 0) {
            var tokenv = "{{ csrf_token() }}";
            $.ajax({
                type: 'POST',
                url: '{{ route('get_neighborhood') }}',
                datatype: 'json',
                data: {
                    'city_id' : city_id > 0 ? city_id : $('#' + id + 'city_id').val(),
                    '_token'  : tokenv
                },
                success: function(msg) {
                    //success here
                    $('#' + id + 'neighborhood_id').html(msg);
                }
            });
        }

        function editProvider(provider) {
            $('#edit_id').val(provider.id);
            $('#edit_first_name').val(provider.first_name);
            $('#edit_last_name').val(provider.last_name);
            $('#edit_full_name_ar').val(provider.full_name_ar);
            $('#edit_full_name_en').val(provider.full_name_en);
            $('#edit_phone_code').val(provider.phone_code);
            $('#edit_phone').val(provider.phone);
            $('#edit_email').val(provider.email);
            $('#edit_address').val(provider.address);
            $('#edit_price').val(provider.price);
            $('#edit_renewal_price').val(provider.renewal_price);
            $('#edit_desc_ar').val(provider.desc_ar);
            $('#edit_desc_en').val(provider.desc_en);
            $('#edit_start_time').val(provider.start_time);
            $('#edit_end_time').val(provider.end_time);
            // $('#edit_password').val('');
            $('#edit_avatar').removeAttr('src');
            $('#edit_avatar').attr('src', "{{ url('') }}" + provider.avatar);
            $('#edit_city_id').val(provider.city_id);

            $('#cash').prop('checked' , false);
            $('#online').prop('checked' , false);
            $('#transfer').prop('checked' , false);

            let cash    = provider.cash;
            let online  = provider.online;
            let transfer  = provider.transfer;

            if(parseInt(cash) == 1)     $('#cash').prop('checked' , true);
            if(parseInt(online) == 1)   $('#online').prop('checked' , true);
            if(parseInt(transfer) == 1)   $('#transfer').prop('checked' , true);

            $('#edit_lat').val(provider.lat > 0 ? provider.lat : 24.774265);
            $('#edit_lng').val(provider.lng > 0 ? provider.lng : 46.738586);
            edit_initialize();
        }

        function updateProvider() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('updateprovider') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updateProviderForm")[0]),
                success: function(msg) {
                    if (msg.value == '0') {
                        stop_loader();
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    } else {
                        window.location.reload();
                    }
                }
            });
        }

        function confirmUser(id) {
            var tokenv = "{{ csrf_token() }}";
            $.ajax({
                type: 'POST',
                url: '{{ route('confirmprovider') }}',
                datatype: 'json',
                data: {
                    'id': id,
                    '_token': tokenv
                },
                success: function(msg) {
                    //success here

                    if (msg == 0)
                        return false;
                    else if (msg.value == 0) {
                        $('#confirm-err-' + id).html(msg.msg);
                        return false;
                    } else
                        $('#confirm-' + id).html(msg);
                }
            });
        }

        function sendnotifyprovider() {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route('sendnotifyprovider') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#sendnotifyproviderForm")[0]),
                success: function(msg) {
                    if (msg.value == '0') {
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    } else {
                        $('#notifyClose').trigger('click');
                        $('#notifyMessage').html('');
                        $.notify(msg.msg, 'success');
                    }
                }
            });
        }

        function deleteProvider(id) {
            $('#delete_id').val(id);
        }

        function deleteAllProvider(type) {
            $('#delete_type').val(type);
        }

        function checkDataIds() {
            let ids = $('#delete_ids').val();
            let type = $('#delete_type').val();
            if (type != 'all' && ids == '') {
                event.preventDefault();
                $('#delete-all-modal').trigger('click');
            }
        }

        function checkIds() {
            let providersIds = '';
            $('.checkSingle:checked').each(function() {
                let id = $(this).attr('id');
                providersIds += id + ' ';
            });
            let requestData = providersIds.split(' ');
            $('#delete_ids').val(requestData);
        }

        $("#checkedAll").change(function() {
            if (this.checked) {
                $(".checkSingle").each(function() {
                    this.checked = true;
                });
            } else {
                $(".checkSingle").each(function() {
                    this.checked = false;
                });
            }
            checkIds();
        });

        $(".checkSingle").click(function() {
            if ($(this).is(":checked")) {
                var isAllChecked = 0;
                $(".checkSingle").each(function() {
                    if (!this.checked)
                        isAllChecked = 1;
                })
                if (isAllChecked == 0) {
                    $("#checkedAll").prop("checked", true);
                }
            } else {
                $("#checkedAll").prop("checked", false);
            }
            checkIds();
        });

        $(document).on("click", ".uploaded-image", function() {
            $(this).addClass("active");
        });

        $("body").on("click", function() {
            $('.uploaded-image').removeClass("active");
        });

    </script>
@endsection
