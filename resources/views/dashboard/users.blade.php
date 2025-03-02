@extends('dashboard.master')
@section('title') الأعضاء @endsection
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
                            data-target="#add-user">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn bg-warning" onclick="sendNotify('all' , '0')" data-toggle="modal"
                            data-target="#send-noti">
                            <i class="fas fa-paper-plane"></i>
                            إرسال للكل
                        </button>
                        <button class="btn btn-danger" onclick="deleteAllUser('more')" data-toggle="modal"
                            data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف المحدد
                        </button>
                        {{-- <button class="btn btn-danger" onclick="deleteAllUser('all')" data-toggle="modal" data-target="#confirm-all-del">
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
                            <select name="" id="created" class="form-control">
                                <option value="" {{isset($queries['created']) && $queries['created'] == '' ? 'selected' : ''}}>مدة الاشتراك</option>
                                <option value="1" {{isset($queries['created']) && $queries['created'] == '1' ? 'selected' : ''}}>اليوم</option>
                                <option value="7" {{isset($queries['created']) && $queries['created'] == '7' ? 'selected' : ''}}>منذ اسبوع</option>
                                <option value="30" {{isset($queries['created']) && $queries['created'] == '30' ? 'selected' : ''}}>منذ شهر</option>
                                <option value="90" {{isset($queries['created']) && $queries['created'] == '90' ? 'selected' : ''}}>منذ 3 أشهر</option>
                                <option value="180" {{isset($queries['created']) && $queries['created'] == '180' ? 'selected' : ''}}>منذ 6 أشهر</option>
                                <option value="365" {{isset($queries['created']) && $queries['created'] == '365' ? 'selected' : ''}}>منذ سنة</option>
                                <option value="custom" {{isset($queries['created']) && $queries['created'] == 'custom' ? 'selected' : ''}}>تاريخ محدد</option>
                            </select>
                            <input type="date" id="created_custom_date" class="form-control mt-2" style="display: none;" value="{{ isset($queries['created_custom_date']) ? $queries['created_custom_date'] : '' }}">
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="btns header-buttons">
                            <select name="" id="logout" class="form-control">
                                <option value="" {{isset($queries['logout']) && $queries['logout'] == '' ? 'selected' : ''}}>اخر ظهور</option>
                                <option value="1" {{isset($queries['logout']) && $queries['logout'] == '1' ? 'selected' : ''}}>اليوم</option>
                                <option value="7" {{isset($queries['logout']) && $queries['logout'] == '7' ? 'selected' : ''}}>منذ اسبوع</option>
                                <option value="30" {{isset($queries['logout']) && $queries['logout'] == '30' ? 'selected' : ''}}>منذ شهر</option>
                                <option value="90" {{isset($queries['logout']) && $queries['logout'] == '90' ? 'selected' : ''}}>منذ 3 أشهر</option>
                                <option value="180" {{isset($queries['logout']) && $queries['logout'] == '180' ? 'selected' : ''}}>منذ 6 أشهر</option>
                                <option value="custom" {{isset($queries['logout']) && $queries['logout'] == 'custom' ? 'selected' : ''}}>تاريخ محدد</option>
                            </select>
                            <input type="date" id="logout_custom_date" class="form-control mt-2" style="display: none;" value="{{ isset($queries['logout_custom_date']) ? $queries['logout_custom_date'] : '' }}">
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="btns header-buttons">
                            <select name="" id="package_status" class="form-control">
                                <option value="" {{isset($queries['package_status']) && $queries['package_status'] == '' ? 'selected' : ''}}>كل الاعضاء</option>
                                <option value="1" {{isset($queries['package_status']) && $queries['package_status'] == '1' ? 'selected' : ''}}>المشتركين في الباقة</option>
                                <option value="2" {{isset($queries['package_status']) && $queries['package_status'] == '2' ? 'selected' : ''}}>الغير مشتركين في باقة</option>
                            </select>
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
                    <table id="datatable-users-button" class="table table-bordered table-striped">
                        <thead>
                            <tr style="text-align: center">
                                <th>
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input" id="checkedAll">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                </th>
                                <th>#</th>
                                <th>الصورة الحالية</th>
                                <th>الصورة الجديدة</th>
                                <th>الأسم</th>
                                <th>البريد الالكتروني</th>
                                <th>العمر</th>
                                <th>الهدف من التسجيل</th>
                                <th>المدينة</th>
                                <th>النوع</th>
                                <th>حالة الصورة</th>
                                <th>حالة العضو</th>
                                <th>الباقة</th>
                                <th>تاريخ بداية الباقة</th>
                                <th>تاريخ نهاية الباقة</th>
                                <th>اخر ظهور</th>
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
                                    <td>
                                        @if($item->edit_seen == '0' && !empty($item->avatar_edit))
                                            <a href="{{ url('user/review/' . $item->id) }}" target="_blank" class="btn btn-info">
                                                عرض
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $item->first_name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->age }}</td>
                                    @php
                                        $goal = App\Models\Media_file::where('id', $item->goal_id)->first();
                                        $city = App\Models\City::where('id', $item->city_id)->first();
                                    @endphp
                                    <td>{{ isset($goal) ? $goal->title_ar : '' }}</td>
                                    <td>{{ isset($city) ? $city->title_ar : '' }}</td>
                                    <td>{{ $item->gender == 'female' ? 'انثى' : 'ذكر' }}</td>
                                    <td>
                                        @if($item->edit_seen == '0' && !empty($item->avatar_edit))
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                {{-- <label class="custom-control-label" for="customSwitch3">{{Translate('حظر')}}</label> --}}
                                                <input type="checkbox" onchange="changeUserAvatar('{{ $item->id }}')"
                                                       {{ !$item->avatar_seen || !$item->edit_seen ? '' : 'checked' }} class="custom-control-input"
                                                       id="customSwitchAvatar{{ $item->id }}">
                                                <label class="custom-control-label" id="avatar_label{{ $item->id }}"
                                                       for="customSwitchAvatar{{ $item->id }}">{{ !$item->avatar_seen || !$item->edit_seen ? 'اخفاء' : 'اظهار' }}</label>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            {{-- <label class="custom-control-label" for="customSwitch3">{{Translate('حظر')}}</label> --}}
                                            <input type="checkbox" onchange="changeUserStatus('{{ $item->id }}')"
                                                {{ $item->blocked ? '' : 'checked' }} class="custom-control-input"
                                                id="customSwitch{{ $item->id }}">
                                            <label class="custom-control-label" id="status_label{{ $item->id }}"
                                                for="customSwitch{{ $item->id }}">{{ $item->blocked ? Translate('حظر') : Translate('مفعل') }}</label>
                                        </div>
                                    </td>
                                    <td>{{$item->package_title}}</td>
                                    <td>
                                        @if(!empty($item->package_date))
                                            <p>{{ Carbon\Carbon::parse($item->package_date)->format('Y-m-d') }}</p>
                                            <p>{{ Carbon\Carbon::parse($item->package_date)->format('H:i:s') }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($item->package_end_date))
                                            <p>{{ Carbon\Carbon::parse($item->package_end_date)->format('Y-m-d') }}</p>
                                            <p>{{ Carbon\Carbon::parse($item->package_end_date)->format('H:i:s') }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <p>{{ Carbon\Carbon::parse($item->logout_date)->format('Y-m-d') }}</p>
                                        <p>{{ Carbon\Carbon::parse($item->logout_date)->format('H:i:s') }}</p>
                                        <span>
                                            @if($item->logout_date)
                                                @php
                                                    $days = Carbon\Carbon::parse($item->logout_date)->diffInDays(Carbon\Carbon::now());
                                                @endphp
                                                @if($days == 0)
                                                    المنذ يوم
                                                @elseif($days <= 7)
                                                    منذ أسبوع
                                                @elseif($days <= 30)
                                                    منذ شهر
                                                @elseif($days <= 90)
                                                    منذ 3 أشهر
                                                @elseif($days <= 180)
                                                    منذ 6 أشهر
                                                @elseif($days <= 365)
                                                    منذ سنة
                                                @else
                                                    منذ أكثر من سنة
                                                @endif
                                            @else
                                                لم يسجل دخول
                                            @endif
                                        </span> 
                                    </td>
                                    <td>
                                         <p>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</p>
                                         <p>{{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</p>
                                    </td>
                                    <td>
                                        <div class="btn-action">
                                            <a href="{{url('show_client/' . $item->id)}}" class="btn btn-sm btn-primary" target="_blank">
                                                <i class="fas fa-user"></i>
                                            </a>

                                            <a href="#" class="btn btn-sm btn-warning"
                                                title="إرسال إشعار"
                                                onclick="sendNotify('one' , '{{ $item->id }}')" data-toggle="modal"
                                                data-target="#send-noti">
                                                <i class="fas fa-paper-plane"></i>
                                            </a>

                                            <a href="#" class="btn btn-sm bg-teal" title="تعديل البيانات"
                                                onclick="editUser({{ $item }})" data-toggle="modal"
                                                data-target="#edit-user">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <a href="#" class="btn btn-sm bg-teal" title="اضافة باقة"
                                                onclick="editPackageUser({{ $item }})" data-toggle="modal"
                                                data-target="#edit-package-user">
                                                <i class="fas fa-plus"></i>
                                            </a>

                                            <a href="#" class="btn btn-sm btn-danger" title="حذف"
                                                onclick="deleteUser('{{ $item->id }}')" data-toggle="modal"
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
                <div class="d-flex justify-content-center mt-3">
                    {{ $data->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('modal')
    <!-- user-profile modal-->
    <div class="modal fade user-profile" id="user-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <div class="user-d text-center">
                        <p class="name" id="show_name"></p>
                        <ul>
                            <li>
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
    <!--end user-profile modal-->
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
                    <form action="{{ route('sendnotifyuser') }}" id="sendnotifyuserForm" method="POST">
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
                            onclick="sendnotifyuser()">إرسال</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end send-noti modal-->
    <!-- add-user modal-->
    <div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة عضو</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('adduser') }}" id="addUserForm" method="POST" enctype="multipart/form-data">
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
                            <label>الأسم </label>
                            <input type="text" name="first_name" class="form-control">
                        </div>
                        {{-- <div class="form-group">
                            <label>{{Translate('الأسم الاخير')}}</label>
                            <input type="text" name="last_name" class="form-control">
                        </div> --}}
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
                        <div class="form-group">
                            <label>{{Translate('البريد الإلكتروني')}}</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        {{-- <div class="form-group">
                            <label>{{Translate('العنوان')}}</label>
                            <input type="text" name="address" class="form-control">
                        </div> --}}

                        <div class="form-group">
                            <label>المدينة</label>
                            <div class="input-group">
                                <select name="city_id"
                                        class="form-control" id="">
                                    @foreach(App\Models\City::orderBy('title_ar')->get() as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label>النوع</label>
                            <div class="input-group">
                                <select name="gender"
                                        class="form-control" id="">
                                    <option value="male">ذكر</option>
                                    <option value="female">انثى</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label>كلمة المرور</label>
                            <input type="password" name="password" value="123456" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="addUser()"
                                class="btn btn-sm btn-success save">حفظ</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end add-user modal-->
    <!-- edit-user modal-->
    <div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل عضو</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateuser') }}" id="updateUserForm" method="POST"
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
                            <label>الأسم </label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control">
                        </div>
                        {{-- <div class="form-group">
                            <label>{{Translate('الأسم الاخير')}}</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control">
                        </div> --}}
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
                        <div class="form-group">
                            <label>{{Translate('البريد الإلكتروني')}}</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>المدينة</label>
                            <div class="input-group">
                                <select name="city_id"
                                        class="form-control" id="edit_city_id">
                                    @foreach(App\Models\City::orderBy('title_ar')->get() as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label>النوع</label>
                            <div class="input-group">
                                <select name="gender"
                                        class="form-control" id="edit_gender">
                                        <option value="male">ذكر</option>
                                        <option value="female">انثى</option>
                                </select>

                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label>{{Translate('العنوان')}}</label>
                            <input type="text" name="address" id="edit_address" class="form-control">
                        </div> --}}
                        <div class="form-group">
                            <label>كلمة المرور</label>
                            <input type="password" name="password" id="edit_password" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="updateUser()"
                                class="btn btn-sm btn-success save">حفظ</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-user modal-->
    <!-- edit-user modal-->
    <div class="modal fade" id="edit-package-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اضافة باقة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updatepackageuser') }}" id="updateUserForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_user_id">

                        <div class="form-group">
                            <label>الباقة</label>
                            <div class="input-group">
                                <select name="package_id" class="form-control" id="edit_package_id">
                                    <option value="">اختر</option>
                                    <option value="empty">بدون باقة</option>
                                    @foreach(App\Models\Package::orderBy('title_ar')->get() as $item)
                                        <option value="{{$item->id}}">{{$item->title}} - {{$item->amount}} شهر</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" {{--onclick="updatePackageUser()"--}}
                                class="btn btn-sm btn-success save">حفظ</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-user modal-->
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
                    <form action="{{ route('deleteuser') }}" method="post" class="d-flex align-items-center">
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
                    <form action="{{ route('deleteusers') }}" method="post" class="d-flex align-items-center">
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
        $("#datatable-users-button").DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "dom": "Bfrtip",
            "responsive": true,
            "fixedColumns": true,
            "lengthMenu": [
                [-1],
                ['all']
            ],
            "buttons": [{
                    extend: "excel",
                    text: "Excel"
                },
                //{ extend: "pdfHtml5"  , text: "PDF" },
                {
                    extend: "print",
                    text: "Print",
                    autoPrint: true,
                    customize: function (win) {
                        $(win.document.body).css('direction', 'rtl');
                    }
                }
            ],
        });
    </script>
    <script>
        function sortedByData() {
            event.preventDefault();
            let sortedByName   = $('#sortedByName').val();
            let sortedByPhone  = $('#sortedByPhone').val();
            let sortedByEmail  = $('#sortedByEmail').val();
            let package_status = $('#package_status').val();
            let created        = $('#created').val();
            let created_custom_date = $('#created_custom_date').val();
            let logout         = $('#logout').val();
            let logout_custom_date = $('#logout_custom_date').val();
        
            // تحديث URL مع القيم الجديدة
            window.location.assign('users?name=' + sortedByName + 
                                   '&phone=' + sortedByPhone + 
                                   '&email=' + sortedByEmail + 
                                   '&package_status=' + package_status + 
                                   '&created=' + created + 
                                   '&created_custom_date=' + created_custom_date + 
                                   '&logout=' + logout + 
                                   '&logout_custom_date=' + logout_custom_date);
        }
        
        $(document).ready(function() {
            $('#created').change(function() {
                if ($(this).val() == 'custom') {
                    $('#created_custom_date').show();
                } else {
                    $('#created_custom_date').hide();
                }
            });
        
            $('#logout').change(function() {
                if ($(this).val() == 'custom') {
                    $('#logout_custom_date').show();
                } else {
                    $('#logout_custom_date').hide();
                }
            });
        
            if ($('#created').val() == 'custom') {
                $('#created_custom_date').show();
            }
        
            if ($('#logout').val() == 'custom') {
                $('#logout_custom_date').show();
            }
        });


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

        function changeUserAvatar(id) {
            var tokenv = "{{ csrf_token() }}";
            $.ajax({
                type: 'POST',
                url: '{{ route('avataruserseen') }}',
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
                        $('#avatar_label' + id).html(msg);
                }
            });
        }

        function changeUserStatus(id) {
            var tokenv = "{{ csrf_token() }}";
            $.ajax({
                method: 'POST',
                url: '{{ route('changestatususer') }}',
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

        function changeUserSeeFamily(id) {
            var tokenv = "{{ csrf_token() }}";
            $.ajax({
                type: 'POST',
                url: '{{ route('changesee_familyuser') }}',
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
                        $('#status_label_see_family' + id).html(msg);
                }
            });
        }

        function sendNotify(type, id) {
            $('#notify_type').val(type);
            $('#notify_id').val(id);
            $('#notifyMessage').html('');
        }

        function addUser() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('adduser') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#addUserForm")[0]),
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

        function showUser(user) {
            $('#show_name').html(user.first_name);
            $('#show_phone').html(user.phone);
            $('#show_phone').removeAttr('href');
            $('#show_phone').attr('href', "tel:" + user.phone);
            $('#show_email').html(user.email);
            $('#show_email').removeAttr('href');
            $('#show_email').attr('href', "mailto:" + user.email);
            // $('#show_address').html(user.address);
            $('#show_avatar').removeAttr('src');
            $('#show_avatar').attr('src', "{{ url('') }}" + user.avatar);
            $('#show_avatar_fancy').removeAttr('data-caption');
            $('#show_avatar_fancy').attr('data-caption', user.name);
            $('#show_avatar_fancy').removeAttr('href');
            $('#show_avatar_fancy').attr('href', "{{ url('') }}" + user.avatar);
        }

        function editUser(user) {
            $('#edit_id').val(user.id);
            $('#edit_first_name').val(user.first_name);
            $('#edit_last_name').val(user.last_name);
            $('#edit_phone_code').val(user.phone_code);
            $('#edit_phone').val(user.phone);
            $('#edit_email').val(user.email);
            $('#edit_address').val(user.address);
            $('#edit_city_id').val(user.city_id);
            $('#edit_gender').val(user.gender);
            // $('#edit_password').val('');
            $('#edit_avatar').removeAttr('src');
            $('#edit_avatar').attr('src', "{{ url('') }}" + user.avatar);
        }

        function editPackageUser(user) {
            $('#edit_user_id').val(user.id);
        }

        function updateUser() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('updateuser') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updateUserForm")[0]),
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

        function sendnotifyuser() {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route('sendnotifyuser') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#sendnotifyuserForm")[0]),
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

        function deleteUser(id) {
            $('#delete_id').val(id);
        }

        function deleteAllUser(type) {
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
            let usersIds = '';
            $('.checkSingle:checked').each(function() {
                let id = $(this).attr('id');
                usersIds += id + ' ';
            });
            let requestData = usersIds.split(' ');
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
