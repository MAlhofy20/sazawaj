@extends('site.master')
@section('title')
    الغاء وقت
@endsection
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
                        <button class="btn bg-teal" title="{{Translate('اضافة')}}" data-toggle="modal" data-target="#add-user_time">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteAllUser_time('more')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            {{Translate('حذف المحدد')}}
                        </button>
                        {{-- <button class="btn btn-danger" onclick="deleteAllUser_time('all')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            {{Translate('حذف الكل')}}
                        </button> --}}
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="text-align: center">
                            <th>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input" id="checkedAll">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </th>
                            <th>#</th>
                            <th>{{Translate('التاريخ')}}</th>
                            <th>بداية الوقت</th>
                            <th>نهاية الوقت</th>
                            @if(auth()->user()->user_type == 'market')
                                <th>رقم الملعب</th>
                            @endif
                            <th>{{Translate('وقت التسجيل')}}</th>
                            <th>{{Translate('التحكم')}}</th>
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
                                <td>{{$item->date}}</td>
                                <td>{{$item->time}}</td>
                                <td>{{$item->end_time}}</td>
                                @if(auth()->user()->user_type == 'market')
                                    <td>{{$item->count}}</td>
                                @endif
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-action">
                                        {{-- <a href="#" class="btn btn-sm bg-teal" title="{{Translate('تعديل')}}" onclick="editUser_time({{ $item }})"  data-toggle="modal" data-target="#edit-user_time">
                                            <i class="fas fa-pen"></i>
                                        </a> --}}

                                        <a href="#" class="btn btn-sm btn-danger" title="{{Translate('حذف')}}" onclick="deleteUser_time('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('modal')
    <!-- add-user_time modal-->
    <div class="modal fade" id="add-user_time" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{Translate('إضافة عنصر')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('site_adduser_time')}}" id="addUser_timeForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{isset($id) ? $id : Auth::id()}}">
                        <div class="form-group">
                            <label>{{Translate('التاريخ')}}</label>
                            <input type="text" name="date" class="form-control datepicker">
                        </div>
                        <div class="form-group">
                            <label>بداية الوقت</label>
                            <input type="time" name="time" dir="ltr" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>نهاية الوقت</label>
                            <input type="time" name="end_time" dir="ltr" class="form-control">
                        </div>
                        <div class="form-group" @if(auth()->user()->user_type != 'market') style="display: none" @endif>
                            <label>رقم الملعب</label>
                            <select name="count" class="form-control">
                                @for ($i = 1; $i <= auth()->user()->count; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="addUser_time()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end add-user_time modal-->
    <!-- edit-user_time modal-->
    <div class="modal fade" id="edit-user_time" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{Translate('تعديل عنصر')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('site_updateuser_time')}}" id="updateUser_timeForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label>{{Translate('التاريخ')}}</label>
                            <input type="text" name="date" id="edit_date" class="form-control datepicker">
                        </div>

                        <div class="form-group">
                            <label>بداية الوقت</label>
                            <input type="time" name="time" id="edit_time" dir="ltr" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>نهاية الوقت</label>
                            <input type="time" name="end_time" id="edit_end_time" dir="ltr" class="form-control">
                        </div>
                        <div class="form-group" @if(auth()->user()->user_type != 'market') style="display: none" @endif>
                            <label>رقم الملعب</label>
                            <select name="count" id="edit_count" class="form-control">
                                @for ($i = 1; $i <= auth()->user()->count; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="updateUser_time()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-user_time modal-->
    <!-- confirm-del modal-->
    <div class="modal fade" id="confirm-del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{Translate('تأكيد الحذف')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        {{Translate('هل تريد الاستمرار في عملية الحذف ؟')}}
                    </h3>
                    <form action="{{route('site_deleteuser_time')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="id" id="delete_id">
                        <button type="submit" class="btn btn-sm btn-success">{{Translate('تأكيد')}}</button>
                        <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إلغاء')}}</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">{{Translate('تأكيد الحذف')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        {{Translate('هل تريد الاستمرار في عملية الحذف ؟')}}
                    </h3>
                    <form action="{{route('site_deleteuser_times')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="user_time_ids" id="delete_ids">
                        <input type="hidden" name="type" id="delete_type">
                        <button type="submit" onclick="checkDataIds()" class="btn btn-sm btn-success">{{Translate('تأكيد')}}</button>
                        <button class="btn btn-sm btn-danger" id="delete-all-modal" data-dismiss="modal">{{Translate('إلغاء')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end confirm-del-all modal-->
@endsection

@section('script')
    <script>
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

        function back() {
            // window.location.assign("{{route('site_sections')}}");
        }

        function addUser_time() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('site_adduser_time') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addUser_timeForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
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

        function editUser_time(user_time){
            $('#edit_id').val(user_time.id);
            $('#edit_amount').val(user_time.amount);
            $('#edit_price').val(user_time.price);
            $('#edit_date').val(user_time.date);
            $('#edit_time').val(user_time.time);
            $('#edit_end_time').val(user_time.end_time);
            $('#edit_count').val(user_time.count);
            $('#edit_title_ar').val(user_time.title_ar);
            $('#edit_title_en').val(user_time.title_en);
            $('#edit_desc_ar').val(user_time.desc_ar);
            $('#edit_desc_en').val(user_time.desc_en);
            $('#edit_image').removeAttr('src');
            $('#edit_image').attr('src' , "{{url('')}}"+user_time.image);
        }

        function updateUser_time() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('site_updateuser_time') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updateUser_timeForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
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

        function deleteUser_time(id){
            $('#delete_id').val(id);
        }

        function deleteAllUser_time(type){
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
            let user_timesIds = '';
            $('.checkSingle:checked').each(function () {
                let id = $(this).attr('id');
                user_timesIds += id + ' ';
            });
            let requestData = user_timesIds.split(' ');
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
