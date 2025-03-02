@extends('dashboard.master')
@section('title') التقييمات @endsection
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
                        {{--<button class="btn bg-teal" title="اضافة" data-toggle="modal" data-target="#add-exam">
                            <i class="fas fa-plus"></i>
                        </button>--}}
                        <button class="btn btn-danger" onclick="deleteAllUser('more')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف المحدد
                        </button>
                        {{--<button class="btn btn-danger" onclick="deleteAllSection('all')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف الكل
                        </button>--}}
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
                            {{-- <th>رقم الطلب</th> --}}
                            <th>اسم العضو</th>
                            <th>المنتج</th>
                            {{-- <th>اسم المندوب</th> --}}
                            <th>التقييم</th>
                            {{-- <th>تقييم المندوب</th> --}}
                            {{-- <th>تقييم المنتجات</th> --}}
                            <th>التعليق</th>
                            {{--<th>حالة التقييم</th>--}}
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
                                {{-- <td>
                                    <a href="{{route('showorder' , $item->order_id)}}">
                                        {{$item->order_id}}
                                    </a>
                                </td> --}}
                                <td>{{is_null($item->user) ? '' : $item->user->name}}</td>
                                <td>{{is_null($item->service) ? '' : $item->service->name}}</td>
                                {{-- <td>{{is_null($item->delegate) ? '' : $item->delegate->name}}</td> --}}
                                <td>{{$item->rate}}</td>
                                {{-- <td>{{$item->delegate_rate}}</td> --}}
                                {{-- <td>{{$item->services_rate}}</td> --}}
                                <td>{{$item->desc}}</td>
                                {{--<td>
                                    <div class="custom-control custom-switch custom-switch-off-success custom-switch-on-danger">
                                        --}}{{-- <label class="custom-control-label" for="customSwitch3">حظر</label> --}}{{--
                                        <input type="checkbox" onchange="changeUserStatus('{{$item->id}}')" {{ $item->seen ? '' : 'checked' }} class="custom-control-input" id="customSwitch{{$item->id}}">
                                        <label class="custom-control-label" id="status_label{{$item->id}}" for="customSwitch{{$item->id}}">{{ $item->seen ? Translate('ظاهر') : Translate('مخفي')}}</label>
                                    </div>
                                </td>--}}
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-action">
                                        {{--<a href="#" class="btn btn-sm bg-teal" title="تعديل" onclick="editSection({{ $item }})"  data-toggle="modal" data-target="#edit-exam">
                                            <i class="fas fa-pen"></i>
                                        </a>--}}

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
            </div>
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
                    <form action="{{route('deleterate')}}" method="post" class="d-flex align-items-center">
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
                    <form action="{{route('deleterates')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="rate_ids" id="delete_ids">
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

        function changeUserStatus(id) {
            var tokenv  = "{{csrf_token()}}";
            $.ajax({
                type     : 'POST',
                url      : '{{ route('seenrate') }}' ,
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
