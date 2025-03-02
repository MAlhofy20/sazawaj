@extends('site.master')
@section('title') الملاعب @endsection
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
                        {{-- <button class="btn btn-danger" onclick="deleteAllUser('more')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف المحدد
                        </button> --}}
                        {{--<button class="btn btn-danger" onclick="deleteAllUser('all')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف الكل
                        </button>--}}
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-button" class="table table-bordered table-striped">
                        <thead>
                        <tr style="text-align: center">
                            {{-- <th>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input" id="checkedAll">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </th> --}}
                            <th>#</th>
                            <th>الصورة</th>
                            <th>اسم الملعب</th>
                            <th>العنوان</th>
                            {{-- <th>المدينة</th> --}}
                            {{-- <th>الحي</th> --}}
                            <th>اجمالي عدد الطلبات</th>
                            <th>عدد الطلبات قيد التنفيذ</th>
                            <th>عدد الطلبات الحالية</th>
                            <th>عدد الطلبات المنتهية</th>
                            <th>عدد الطلبات الملغية</th>
                            <th>اجمالي الطلبات الحالية</th>
                            <th>اجمالي الطلبات المنتهية</th>
                            <th>وقت التسجيل</th>
                            <th>التحكم</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $i=>$item)
                            <tr style="text-align: center">
                                {{-- <td>
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input checkSingle" id="{{$item->id}}">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                </td> --}}
                                <td>{{ ++$i }}</td>
                                <td>
                                    <a data-fancybox data-caption="{{ $item->name }}"
                                       href="{{ url('' . $item->avatar) }}">
                                        <img src="{{ url('' . $item->avatar) }}" height="40px" width="35px" alt=""
                                             class="img-circle">
                                    </a>
                                </td>
                                <td>{{$item->full_name}}</td>
                                <td><a href="https://www.google.com/maps/?q={{$item->lat}},{{$item->lng}}" target="_blanck">{{$item->address}}</a></td>
                                <?php
                                    // $neighborhood = App\Models\Neighborhood::whereId($item->neighborhood_id)->first();
                                    $city         = App\Models\City::whereId($item->city_id)->first();
                                ?>
                                {{-- <td>{{ isset($city) ? $city->title_ar : '' }}</td> --}}
                                {{-- <td>{{ isset($neighborhood) ? $neighborhood->title_ar : '' }}</td> --}}
                                @php
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
                                </td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
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

                                        {{-- <a href="#" class="btn btn-sm btn-danger" title="حذف" onclick="deleteUser('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
                                            <i class="fas fa-trash"></i>
                                        </a> --}}
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
                    <form action="{{route('site_addmarket')}}" id="addUserForm" method="POST" enctype="multipart/form-data">
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
                            <label>اسم الملعب بالعربية</label>
                            <input type="text" name="full_name_ar" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>اسم الملعب بالانجليزية</label>
                            <input type="text" name="full_name_en" class="form-control" required>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group" style="display: none">
                            <label>الجوال</label>
                            <input type="text" name="phone" class="form-control phone" id="">
                        </div>
                        <div class="form-group" style="margin-bottom: 10px;">
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
                        <div class="form-group" style="display: none">
                            <label>المدينة</label>
                            <select name="city_id" id="city_id" class="form-control" onchange="get_neighborhood('')">
                                @foreach (App\Models\City::orderBy('title_ar')->get() as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>العنوان بالعربية</label>
                            <input type="text" name="address_ar" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>العنوان بالانجليزية</label>
                            <input type="text" name="address_en" class="form-control">
                        </div>
                        <div class="form-group" style="position: relative;">
                            {{-- <input class="controls" id="pac-input" name="pac-input" value="" placeholder="اكتب موقعك"/> --}}
                            <input type="hidden" name="lat" id="lat" value="24.774265" readonly />
                            <input type="hidden" name="lng" id="lng" value="46.738586" readonly />
                            <div class="col-sm-12" id="add_map"></div>
                        </div>
                        <div class="form-group">
                            <label>التفاصيل بالعربية</label>
                            <textarea name="desc_ar" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>التفاصيل بالإنجليزية</label>
                            <textarea name="desc_en" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>كلمة المرور</label>
                            <input type="password" name="password" class="form-control" value="123456">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" 
                                {{-- onclick="addUser()" --}}
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
                    <h5 class="modal-title" id="exampleModalLabel">تعديل عنصر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('site_updatemarket')}}" id="updateUserForm" method="POST" enctype="multipart/form-data">
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
                            <label>اسم الملعب بالعربية</label>
                            <input type="text" name="full_name_ar" id="edit_full_name_ar" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>اسم الملعب بالانجليزية</label>
                            <input type="text" name="full_name_en" id="edit_full_name_en" required class="form-control">
                        </div>
                        <div class="form-group" style="display: none">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>
                        <div class="form-group" style="display: none">
                            <label>الجوال</label>
                            <input type="text" name="phone" class="form-control phone" id="edit_phone">
                        </div>
                        <div class="form-group" style="margin-bottom: 10px;">
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
                        <div class="form-group" style="display: none">
                            <label>المدينة</label>
                            <select name="city_id" id="edit_city_id" class="form-control" onchange="get_neighborhood('edit_')">
                                @foreach (App\Models\City::orderBy('title_ar')->get() as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label>العنوان</label>
                            <input type="text" name="address" id="edit_address" class="form-control">
                        </div> --}}
                        <div class="form-group">
                            <label>العنوان بالعربية</label>
                            <input type="text" name="address_ar" id="edit_address_ar" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>العنوان بالانجليزية</label>
                            <input type="text" name="address_en" id="edit_address_en" class="form-control">
                        </div>

                        <div class="form-group" style="position: relative;">
                            {{-- <input class="controls" id="edit_pac-input" name="pac-input" value="" placeholder="اكتب موقعك"/> --}}
                            <input type="hidden" name="lat" id="edit_lat" value="24.774265" readonly />
                            <input type="hidden" name="lng" id="edit_lng" value="46.738586" readonly />
                            <div class="col-sm-12" id="edit_add_map"></div>
                        </div>

                        <div class="form-group">
                            <label>التفاصيل بالعربية</label>
                            <textarea name="desc_ar" id="edit_desc_ar" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>التفاصيل بالإنجليزية</label>
                            <textarea name="desc_en" id="edit_desc_en" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>كلمة المرور</label>
                            <input type="password" name="password" id="edit_password" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" 
                                {{-- onclick="updateUser()" --}}
                                class="btn btn-sm btn-success save">حفظ</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-user modal-->
@endsection

@section('script')
    <script>
        

        function addUser() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('site_addmarket') }}' ,
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
                url         : '{{ route('site_updatemarket') }}' ,
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

        $(document).on("click", ".uploaded-image", function () {
            $(this).addClass("active");
        });
        $("body").on("click", function () {
            $('.uploaded-image').removeClass("active");
        });
    </script>
@endsection
