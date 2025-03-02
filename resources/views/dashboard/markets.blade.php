@extends('dashboard.master')
@section('title') المحاسبين @endsection
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
                        <button class="btn bg-teal" title="اضافة" data-toggle="modal" data-target="#add-user">
                            <i class="fas fa-plus"></i>
                        </button>
                        {{-- <button class="btn bg-warning" onclick="sendNotify('all' , '0')" data-toggle="modal" data-target="#send-noti">
                            <i class="fas fa-paper-plane"></i>
                            إرسال للكل
                        </button> --}}
                        <button class="btn btn-danger" onclick="deleteAllUser('more')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف المحدد
                        </button>
                        {{--<button class="btn btn-danger" onclick="deleteAllUser('all')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف الكل
                        </button>--}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <div class="btns header-buttons">
                            <input type="text" id="sortedByName" value="{{isset($queries['name']) ? $queries['name'] : ''}}" class="form-control" style=""  placeholder="بحث بالاسم">
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="btns header-buttons">
                            <input type="text" id="sortedByPhone" value="{{isset($queries['phone']) ? $queries['phone'] : ''}}" class="form-control phone" style=""  placeholder="بحث بالجوال">
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="btns header-buttons">
                            <input type="email" id="sortedByEmail" value="{{isset($queries['email']) ? $queries['email'] : ''}}" class="form-control" style=""  placeholder="بحث بالايميل">
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
                            <th>الاسم</th>
                            <th>الجوال</th>
                            <th>البريد الإلكتروني</th>
                            <th>الفرع</th>
                            <th>حالة المحاسب</th>
                            <th>وقت التسجيل</th>
                            <th>التحكم</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $i=>$item)
                            <tr style="text-align: center">
                                <td>
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input checkSingle" id="{{$item->id}}">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                </td>
                                <td>{{ ++$i }}</td>
                                <td>
                                    <a data-fancybox data-caption="{{ $item->name }}"
                                       href="{{ is_null($item->avatar) ? url(''.settings('logo')) : url(''.$item->avatar) }}">
                                        <img src="{{ is_null($item->avatar) ? url(''.settings('logo')) : url(''.$item->avatar) }}" height="40px" width="35px" alt=""
                                             class="img-circle">
                                    </a>
                                </td>
                                <td>{{$item->first_name}}</td>
                                <td><a href="tel:{{convert_phone_to_international_format($item->phone)}}" target="_blanck">{{$item->phone}}</a></td>
                                <td><a href="mailto:{{$item->email}}" target="_blanck">{{$item->email}}</a></td>
                                <td>
                                    {{is_null($item->provider) ? '' : $item->provider->full_name}}
                                </td>
                                <td>
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        {{-- <label class="custom-control-label" for="customSwitch3">حظر</label> --}}
                                        <input type="checkbox" onchange="changeUserStatus('{{$item->id}}')" {{ $item->blocked ? '' : 'checked' }} class="custom-control-input" id="customSwitch{{$item->id}}">
                                        <label class="custom-control-label" id="status_label{{$item->id}}" for="customSwitch{{$item->id}}">{{ $item->blocked ? Translate('حظر') : Translate('مفعل')}}</label>
                                    </div>
                                </td>
                                <td>
                                     <p>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</p>
                                     <p>{{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</p>
                                </td>
                                <td>
                                    <div class="btn-action">
                                        {{-- <a href="#" class="btn btn-sm btn-primary" title="عرض" onclick="showUser({{ $item }})"  data-toggle="modal" data-target="#user-profile">
                                            <i class="fas fa-user"></i>
                                        </a> --}}

                                        {{-- <a href="#" class="btn btn-sm btn-warning" title="إرسال إشعار" onclick="sendNotify('one' , '{{ $item->id }}')" data-toggle="modal" data-target="#send-noti">
                                            <i class="fas fa-paper-plane"></i>
                                        </a> --}}

                                        <a href="#" class="btn btn-sm bg-teal" title="تعديل" onclick="editUser({{ $item }})"  data-toggle="modal" data-target="#edit-user">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-danger" title="حذف" onclick="deleteUser('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
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
                    {{$data->links()}}
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
                            <li>
                                <i class="fa fa-home"></i>
                                <span id="show_address"></span>
                            </li>
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
                    <form action="{{route('sendnotifyuser')}}" id="sendnotifyuserForm" method="POST">
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
                        <button type="submit" class="btn btn-sm btn-success save" onclick="sendnotifyuser()">إرسال</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">إضافة عنصر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('addmarket')}}" id="addUserForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>الصورة الشخصية</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photo" accept="image/*"/>
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                                <div class="uploaded-image"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>الفرع</label>
                            <select name="provider_id" id="" class="form-control">
                                @foreach(App\Models\User::where('user_type', 'provider')->orderBy('full_name_ar')->get() as $item)
                                    <option value="{{$item->id}}">{{$item->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>الاسم</label>
                            <input type="text" name="first_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>الجوال</label>
                            <input type="text" name="phone" class="form-control phone" id="">
                        </div>
                        <div class="form-group" style="margin-bottom: 10px;display: none">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="defaultCheck1" style="">
                                    طرق الدفع :
                                </label>
                            </div>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="by_cash" value="1" id="test1">
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
                                <input class="form-check-input" type="checkbox" name="by_online" value="1" id="test2">
                                <label class="form-check-label" for="test2" style="margin-right: 5px">
                                    الدفع اونلاين
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>كلمة المرور</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="addUser()" class="btn btn-sm btn-success save">حفظ</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">تعديل عنصر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('updatemarket')}}" id="updateUserForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label>الصورة الشخصية</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photo" accept="image/*"/>
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                                <div class="uploaded-image">
                                    <img src="" id="edit_avatar" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>الفرع</label>
                            <select name="provider_id" id="edit_provider_id" class="form-control">
                                @foreach(App\Models\User::where('user_type', 'provider')->orderBy('full_name_ar')->get() as $item)
                                    <option value="{{$item->id}}">{{$item->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>الاسم</label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>الجوال</label>
                            <input type="text" name="phone" class="form-control phone" id="edit_phone">
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
                        <div class="form-group">
                            <label>كلمة المرور</label>
                            <input type="password" name="password" id="edit_password" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="updateUser()" class="btn btn-sm btn-success save">حفظ</button>
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
                    <form action="{{route('deletemarket')}}" method="post" class="d-flex align-items-center">
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
                    <form action="{{route('deletemarkets')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="user_ids" id="delete_ids">
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
        function sortedByData(){
            event.preventDefault();
            let sortedByName  = $('#sortedByName').val();
            let sortedByPhone = $('#sortedByPhone').val();
            let sortedByEmail = $('#sortedByEmail').val();

            window.location.assign('markets?name=' + sortedByName + '&phone=' + sortedByPhone + '&email=' + sortedByEmail);
        }

        $(function () {
            $(document).on("change", ".file-input", function () {
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

            $(document).on("click", ".file-name", function () {
                $(this).siblings(".file-input").click();
            });

            $(document).on("click", ".uploaded-image", function () {
                $(this).addClass("active");
            });

            $("body").on("click", function () {
                $('.uploaded-image').removeClass("active");
            });

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
                $('#label-switch').bootstrapSwitch('onText', 'I');
                $('#label-switch').bootstrapSwitch('offText', 'O');
            });

        });

        function confirmUser(id) {
            var tokenv  = "{{csrf_token()}}";
            $.ajax({
                type     : 'POST',
                url      : '{{ route('confirmmarket') }}' ,
                datatype : 'json' ,
                data     : {
                    'id'         :  id ,
                    '_token'     :  tokenv
                }, success   : function(msg){
                    //success here

                    if(msg == 0)
                        return false;
                    else if(msg.value == 0){
                        $('#confirm-err-'+id).html(msg.msg);
                        return false;
                    }
                    else
                        $('#confirm-'+id).html(msg);
                }
            });
        }

        function changeUserStatus(id) {
            var tokenv  = "{{csrf_token()}}";
            $.ajax({
                type     : 'POST',
                url      : '{{ route('changestatusmarket') }}' ,
                datatype : 'json' ,
                data     : {
                    'id'         :  id ,
                    '_token'     :  tokenv
                }, success   : function(msg){
                    //success here
                    if(msg == 0)
                        return false;
                    else
                        $('#status_label'+id).html(msg);
                }
            });
        }

        function changeUserFav(id) {
            var tokenv  = "{{csrf_token()}}";
            $.ajax({
                type     : 'POST',
                url      : '{{ route('changefavmarket') }}' ,
                datatype : 'json' ,
                data     : {
                    'id'         :  id ,
                    '_token'     :  tokenv
                }, success   : function(msg){
                    //success here
                    if(msg == 0)
                        return false;
                    else
                        $('#status_fav_label'+id).html(msg);
                }
            });
        }

        function sendNotify(type , id) {
            $('#notify_type').val(type);
            $('#notify_id').val(id);
            $('#notifyMessage').html('');
        }

        function addUser() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('addmarket') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addUserForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        stop_loader();
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        window.location.reload();
                    }
                }
            });
        }

        function showUser(user){
            $('#show_name').html(user.name);
            $('#show_phone').html(user.phone);
            $('#show_phone').removeAttr('href');
            $('#show_phone').attr('href' , "tel:" + user.phone);
            $('#show_email').html(user.email);
            $('#show_email').removeAttr('href');
            $('#show_email').attr('href' , "mailto:" + user.email);
            $('#show_address').html(user.address);
            $('#show_avatar').removeAttr('src');
            $('#show_avatar').attr('src' , "{{url('')}}"+user.avatar);
            $('#show_avatar_fancy').removeAttr('data-caption');
            $('#show_avatar_fancy').attr('data-caption' , user.name);
            $('#show_avatar_fancy').removeAttr('href');
            $('#show_avatar_fancy').attr('href' , "{{url('')}}"+user.avatar);
        }

        function editUser(user){
            $('#edit_id').val(user.id);
            $('#edit_first_name').val(user.first_name);
            $('#edit_full_name_ar').val(user.full_name_ar);
            $('#edit_full_name_en').val(user.full_name_en);
            $('#edit_phone').val(user.phone);
            $('#edit_email').val(user.email);
            $('#edit_address_ar').val(user.address_ar);
            $('#edit_address_en').val(user.address_en);
            $('#edit_delivery_time').val(user.delivery_time);
            $('#edit_admin_percent').val(user.admin_percent);
            $('#edit_id_number').val(user.id_number);
            $('#edit_provider_id').val(user.provider_id);
            $('#edit_ecommercy_id').val(user.ecommercy_id);
            // $('#edit_password').val('');
            $('#edit_city_id').val(user.city_id);
            $('#edit_desc_ar').val(user.desc_ar);
            $('#edit_desc_en').val(user.desc_en);
            $('#edit_avatar').removeAttr('src');
            $('#edit_avatar').attr('src' , "{{url('')}}"+user.avatar);
            $('#edit_id_image').removeAttr('src');
            $('#edit_id_image').attr('src' , "{{url('')}}"+user.id_image);

            $('#cash').prop('checked' , false);
            $('#online').prop('checked' , false);
            $('#transfer').prop('checked' , false);

            let cash      = user.cash;
            let online    = user.online;
            let transfer  = user.transfer;

            if(parseInt(cash) == 1)     $('#cash').prop('checked' , true);
            if(parseInt(online) == 1)   $('#online').prop('checked' , true);
            if(parseInt(transfer) == 1)   $('#transfer').prop('checked' , true);

            $('#edit_lat').val(user.lat > 0 ? user.lat : 24.774265);
            $('#edit_lng').val(user.lng > 0 ? user.lng : 46.738586);
            edit_initialize();
        }

        function updateUser() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('updatemarket') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updateUserForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        stop_loader();
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        window.location.reload();
                    }
                }
            });
        }

        function sendnotifyuser() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('sendnotifyuser') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#sendnotifyuserForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        $('#notifyClose').trigger('click');
                        $('#notifyMessage').html('');
                        $.notify(msg.msg, 'success');
                    }
                }
            });
        }

        function deleteUser(id){
            $('#delete_id').val(id);
        }

        function deleteAllUser(type){
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
            let usersIds = '';
            $('.checkSingle:checked').each(function () {
                let id = $(this).attr('id');
                usersIds += id + ' ';
            });
            let requestData = usersIds.split(' ');
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
        $(document).on("click", ".uploaded-image", function () {
            $(this).addClass("active");
        });
        $("body").on("click", function () {
            $('.uploaded-image').removeClass("active");
        });
    </script>
@endsection
