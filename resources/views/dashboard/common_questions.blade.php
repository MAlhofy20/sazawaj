@extends('dashboard.master')
@section('title') الاسئلة المتداولة @endsection
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
                        <button class="btn bg-teal" title="{{Translate('اضافة')}}" data-toggle="modal" data-target="#add-common_question">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteAllCommon_question('more')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            {{Translate('حذف المحدد')}}
                        </button>
                        {{--<button class="btn btn-danger" onclick="deleteAllCommon_question('all')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            {{Translate('حذف الكل')}}
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
                            <th>{{Translate('السؤال')}}</th>
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
                                <td>{{$item->title}}</td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-action">
                                        <a href="#" class="btn btn-sm bg-teal" title="{{Translate('تعديل')}}" onclick="editCommon_question({{ $item }})"  data-toggle="modal" data-target="#edit-common_question">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-danger" title="{{Translate('حذف')}}" onclick="deleteCommon_question('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
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
    <!-- add-common_question modal-->
    <div class="modal fade" id="add-common_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <form action="{{route('addcommon_question')}}"  method="POST">
                        @csrf
                        <div class="form-group">
                            <label>السؤال بالعربية</label>
                            <input type="text" name="title_ar" class="form-control">
                        </div>
                        
                @php $types = ['التسجيل','الاشتراكات والباقات','البحث والتواصل مع الأعضاء','الأمان والخصوصية','الإبلاغ عن المشكلات والدعم الفني','إدارة الحساب','استفسارات أخرى']@endphp
                        <div class="form-group">
                            <label>نوع السؤال</label>
                            <select name="typesQ" class="form-select m-3 p-1" aria-label="Default select example">
                                <option selected disabled>إختر نوع السؤال</option>
                                @foreach ($types as $i => $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                         </div>
                        
                        <div class="form-group" style="display: none">
                            <label>السؤال بالإنجليزية</label>
                            <input type="text" name="title_en" dir="ltr" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>الاجابة بالعربية</label>
                            <textarea name="desc_ar" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>الاجابة بالإنجليزية</label>
                            <textarea name="desc_en" dir="ltr" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="addCommon_question()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end add-common_question modal-->
    <!-- edit-common_question modal-->
    <div class="modal fade" id="edit-common_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <form action="{{route('updatecommon_question')}}" id="updateCommon_questionForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        {{--<div class="form-group">
                            <label>الصورة</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photo" accept="image/*" />
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                                <div class="uploaded-image">
                                    <img src="" id="edit_image" alt="">
                                </div>
                            </div>
                        </div>--}}
                        <div class="form-group">
                            <label>السؤال بالعربية</label>
                            <input type="text" name="title_ar" id="edit_title_ar" class="form-control">
                        </div>
                        
                         @php $types = ['التسجيل','تسجيل الدخول','إلغاء الحساب','حسابي','الوصف','الصور','التواصل مع الأعضاء','الشكاوي']@endphp
                        <div class="form-group">
                            <label>نوع السؤال</label>
                                <select class="form-select m-3 p-1" aria-label="Default select example">
                                    <option selected>إختر نوع السؤال</option>
                                    @foreach ($types as $i => $type)
                                    <option name='types' value="{{$i+1}}">{{$type}}</option>
                                    @endforeach
                                </select>
                         </div>
                        
                        <div class="form-group" style="display: none">
                            <label>السؤال بالإنجليزية</label>
                            <input type="text" name="title_en" dir="ltr" id="edit_title_en" class="form-control">
                        </div>
                        {{--<div class="form-group">
                            <label>السعر</label>
                            <input type="text" name="price" id="edit_price" class="form-control phone">
                        </div>--}}
                        <div class="form-group">
                            <label>الاجابة بالعربية</label>
                            <textarea name="desc_ar" id="edit_desc_ar" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group" style="display: none">
                            <label>الاجابة بالإنجليزية</label>
                            <textarea name="desc_en" dir="ltr" id="edit_desc_en" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="updateCommon_question()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-common_question modal-->
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
                    <form action="{{route('deletecommon_question')}}" method="post" class="d-flex align-items-center">
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
                    <form action="{{route('deletecommon_questions')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="common_question_ids" id="delete_ids">
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
       

      

        function editCommon_question(common_question){
            $('#edit_id').val(common_question.id);
            $('#edit_title_ar').val(common_question.title_ar);
            $('#edit_title_en').val(common_question.title_en);
            $('#edit_desc_ar').val(common_question.desc_ar);
            $('#edit_desc_en').val(common_question.desc_en);
            $('#edit_price').val(common_question.price);
            $('#edit_image').removeAttr('src');
            $('#edit_image').attr('src', "{{ url('') }}" + common_question.image);
        }

        function updateCommon_question() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('updatecommon_question') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updateCommon_questionForm")[0]),
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

        function deleteCommon_question(id){
            $('#delete_id').val(id);
        }

        function deleteAllCommon_question(type){
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
            let common_questionsIds = '';
            $('.checkSingle:checked').each(function () {
                let id = $(this).attr('id');
                common_questionsIds += id + ' ';
            });
            let requestData = common_questionsIds.split(' ');
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
