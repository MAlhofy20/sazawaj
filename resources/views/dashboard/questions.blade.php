@extends('dashboard.master')
@section('title') {{Translate('اسئلة الاختبار')}} @endsection
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
                        <button class="btn bg-teal" title="{{Translate('اضافة')}}" data-toggle="modal" data-target="#add-question">
                            <i class="fas fa-plus"></i>
                        </button>
                        {{--<button class="btn btn-danger" onclick="deleteAllSection('more')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            {{Translate('حذف المحدد')}}
                        </button>--}}
                        {{--<button class="btn btn-danger" onclick="deleteAllSection('all')" data-toggle="modal" data-target="#confirm-all-del">
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
                            {{--<th>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input" id="checkedAll">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </th>--}}
                            <th>#</th>
                            <th>{{Translate('السؤال')}}</th>
                            <th>{{Translate('وقت التسجيل')}}</th>
                            <th>{{Translate('التحكم')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $i=>$item)
                            <tr style="text-align: center">
                                {{--<td>
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input checkSingle" id="{{$item->id}}">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                </td>--}}
                                <td>{{ ++$i }}</td>
                                <td>{{$item->question_ar}}</td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-action">
                                        <a href="#" class="btn btn-sm bg-teal" title="{{Translate('تعديل')}}" onclick="editSection({{ $item }})"  data-toggle="modal" data-target="#edit-question">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-danger" title="{{Translate('حذف')}}" onclick="deleteSection('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
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
    <!-- add-question modal-->
    <div class="modal fade" id="add-question" tabindex="-1" role="dialog" aria-labelledby="questionpleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionpleModalLabel">{{Translate('إضافة سؤال')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('addquestion')}}" id="addSectionForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="exam_id" value="{{$exam_id}}">
                        <div class="form-group">
                            <label>{{Translate('السؤال')}}</label>
                            <textarea name="question_ar" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الاجابة الصحيحة')}}</label>
                            <select name="answer" class="form-control">
                                <option value="1">{{Translate('الاختيار الاول')}}</option>
                                <option value="2">{{Translate('الاختيار الثاني')}}</option>
                                <option value="3">{{Translate('الاختيار الثالث')}}</option>
                                <option value="4">{{Translate('الاختيار الرابع')}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{Translate('الاختيار الاول')}}</label>
                            <textarea name="first_answer_ar" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الاختيار الثاني')}}</label>
                            <textarea name="second_answer_ar" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الاختيار الثالث')}}</label>
                            <textarea name="third_answer_ar" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الاختيار الرابع')}}</label>
                            <textarea name="fourth_answer_ar" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="addSection()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end add-question modal-->
    <!-- edit-question modal-->
    <div class="modal fade" id="edit-question" tabindex="-1" role="dialog" aria-labelledby="questionpleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionpleModalLabel">{{Translate('تعديل سؤال')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('updatequestion')}}" id="updateSectionForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{Translate('السؤال')}}</label>
                            <textarea name="question_ar" id="edit_question_ar" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الاجابة الصحيحة')}}</label>
                            <select name="answer" id="edit_answer" class="form-control">
                                <option value="1">{{Translate('الاختيار الاول')}}</option>
                                <option value="2">{{Translate('الاختيار الثاني')}}</option>
                                <option value="3">{{Translate('الاختيار الثالث')}}</option>
                                <option value="4">{{Translate('الاختيار الرابع')}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>{{Translate('الاختيار الاول')}}</label>
                            <textarea name="first_answer_ar" id="edit_first_answer_ar" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الاختيار الثاني')}}</label>
                            <textarea name="second_answer_ar" id="edit_second_answer_ar" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الاختيار الثالث')}}</label>
                            <textarea name="third_answer_ar" id="edit_third_answer_ar" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الاختيار الرابع')}}</label>
                            <textarea name="fourth_answer_ar" id="edit_fourth_answer_ar" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="updateSection()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-question modal-->
    <!-- confirm-del modal-->
    <div class="modal fade" id="confirm-del" tabindex="-1" role="dialog" aria-labelledby="questionpleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionpleModalLabel">{{Translate('تأكيد الحذف')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        {{Translate('هل تريد الاستمرار في عملية الحذف ؟')}}
                    </h3>
                    <form action="{{route('deletequestion')}}" method="post" class="d-flex align-items-center">
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
    <div class="modal fade" id="confirm-all-del" tabindex="-1" role="dialog" aria-labelledby="questionpleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionpleModalLabel">{{Translate('تأكيد الحذف')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        {{Translate('هل تريد الاستمرار في عملية الحذف ؟')}}
                    </h3>
                    <form action="{{route('deletequestions')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="question_ids" id="delete_ids">
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

        function addSection() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('addquestion') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addSectionForm")[0]),
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

        function editSection(question){
            $('#edit_id').val(question.id);
            $('#edit_question_ar').val(question.question_ar);
            $('#edit_answer').val(question.answer);
            $('#edit_first_answer_ar').val(question.first_answer_ar);
            $('#edit_second_answer_ar').val(question.second_answer_ar);
            $('#edit_third_answer_ar').val(question.third_answer_ar);
            $('#edit_fourth_answer_ar').val(question.fourth_answer_ar);
        }

        function updateSection() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('updatequestion') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updateSectionForm")[0]),
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

        function deleteSection(id){
            $('#delete_id').val(id);
        }

        function deleteAllSection(type){
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
            let questionsIds = '';
            $('.checkSingle:checked').each(function () {
                let id = $(this).attr('id');
                questionsIds += id + ' ';
            });
            let requestData = questionsIds.split(' ');
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
