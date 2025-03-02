@extends('dashboard.master')
@section('title') {{Translate('الدفع الاجل')}} @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <div class="card-header">
                <div class="col-12">
                    <h3>الدفع بالاجل</h3>
                </div>
                <div class="col-12">
                    <div class="btns header-buttons">
                        <button class="btn bg-teal" title="{{Translate('اضافة')}}" data-toggle="modal" data-target="#add-promo_code">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="text-align: center">
                             <th>#</th>
                            <th>{{Translate('تاجر الجملة')}}</th>
                            <th>{{Translate('الاجمالي')}}</th>
                            <th>{{Translate('مدة السداد')}}</th>
                            <th>{{Translate('وقت التسجيل')}}</th>
                            <th>{{Translate('التحكم')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $i=>$item)
                            <tr style="text-align: center">
                                 <td>{{ ++$i }}</td>
                                <td>{{is_null($item->saler) ? '' : $item->saler->name}}</td>
                                <td>{{$item->total}}</td>
                                <td>{{$item->duration}}</td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-action">
                                        <a href="#" class="btn btn-sm bg-teal" title="{{Translate('تعديل')}}" onclick="editPromo_code({{ $item }})"  data-toggle="modal" data-target="#edit-promo_code">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-danger" title="{{Translate('حذف')}}" onclick="deletePromo_code('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
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

        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <div class="card-header">
                <div class="col-12">
                    <h3>حسابات التاجر</h3>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable2" class="table table-bordered table-striped">
                        <thead>
                        <tr style="text-align: center">
                            <th>#</th>
                            <th>{{Translate('تاجر الجملة')}}</th>
                            <th>{{Translate('الاجمالي')}}</th>
                            <th>{{Translate('المسدد')}}</th>
                            <th>{{Translate('المتبقي')}}</th>
                            <th>{{Translate('سداد')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $i=>$item)
                            <tr style="text-align: center">
                                <td>{{ ++$i }}</td>
                                <td>{{is_null($item->saler) ? '' : $item->saler->name}}</td>
                                <td>{{$item->current_total}}</td>
                                <td>{{$item->current_total - $item->current_debt}}</td>
                                <td>{{$item->current_debt}}</td>
                                <td>
                                    <div class="btn-action">
                                        <form action="{{route('paid_pay_not_now')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <input type="text" name="current_debt" required id="" class="form-control phone" placeholder="المبلغ" style="margin-bottom: 2px;width : 100px;text-align: center">
                                            <button class="form-control btn-success" style="width : 100px">سداد</button>
                                        </form>
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
    <!-- add-promo_code modal-->
    <div class="modal fade" id="add-promo_code" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{Translate('إضافة جديد')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('add_pay_not_now')}}" id="addPromo_codeForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="form-group">
                            <label>{{Translate('الاجمالي')}}</label>
                            <input type="text" name="total" class="form-control phone">
                        </div>
                        <div class="form-group">
                            <label>{{Translate('مدة السداد')}}</label>
                            <div class="input-group">
                                <input type="text" name="duration" class="form-control phone">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">يوم</span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>{{Translate('تاجر الجملة')}}</label>
                            <select name="saler_id" class="form-control">
                                @foreach($salers as $saler)
                                    <option value="{{$saler->id}}">{{$saler->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="addPromo_code()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end add-promo_code modal-->
    <!-- edit-promo_code modal-->
    <div class="modal fade" id="edit-promo_code" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{Translate('تعديل كود')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('update_pay_not_now')}}" id="updatePromo_codeForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label>{{Translate('الاجمالي')}}</label>
                            <input type="text" name="total" id="edit_total" class="form-control phone">
                        </div>
                        <div class="form-group">
                            <label>{{Translate('مدة السداد')}}</label>
                            <div class="input-group">
                                <input type="text" name="duration" id="edit_duration" class="form-control phone">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">يوم</span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>{{Translate('تاجر الجملة')}}</label>
                            <select name="saler_id" id="edit_saler_id" class="form-control">

                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="updatePromo_code()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-promo_code modal-->
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
                    <form action="{{route('delete_pay_not_now')}}" method="post" class="d-flex align-items-center">
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
                    <form action="{{route('deletepromo_codes')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="country_ids" id="delete_ids">
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

        function addPromo_code() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('add_pay_not_now') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addPromo_codeForm")[0]),
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

        function editPromo_code(promo_code){
            $('#edit_id').val(promo_code.id);
            $('#edit_total').val(promo_code.total);
            $('#edit_duration').val(promo_code.duration);
            $.ajax({
                type        : 'POST',
                url         : '{{ route('fill_salers') }}' ,
                data        : {
                    _token   : '{{csrf_token()}}',
                    user_id  : promo_code.user_id,
                    saler_id : promo_code.saler_id
                },
                success     : function(msg){
                    $('#edit_saler_id').html(msg);
                    $('#edit_saler_id').val(promo_code.saler_id);
                }
            });
        }

        function updatePromo_code() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('update_pay_not_now') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updatePromo_codeForm")[0]),
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

        function deletePromo_code(id){
            $('#delete_id').val(id);
        }

        function deleteAllPromo_code(type){
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
            let promo_codesIds = '';
            $('.checkSingle:checked').each(function () {
                let id = $(this).attr('id');
                promo_codesIds += id + ' ';
            });
            let requestData = promo_codesIds.split(' ');
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
    </script>
@endsection
