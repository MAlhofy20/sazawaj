@extends('dashboard.master')
@section('title') الملاحظات @endsection
@section('style')

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
                <div class="col-3">
                    <div class="btns header-buttons">
                        <label for="">من تاريخ</label>
                        <input type="text" name="start_date" id="start_date" value="{{isset($queries['start_date']) ? $queries['start_date'] : ''}}" class="date form-control" placeholder="">
                    </div>
                </div>
                <div class="col-3">
                    <div class="btns header-buttons">
                        <label for="">الى تاريخ</label>
                        <input type="text" name="end_date" id="end_date" value="{{isset($queries['end_date']) ? $queries['end_date'] : ''}}" class="date form-control" placeholder="">
                    </div>
                </div>

                <div class="col-3">
                    <div class="btns header-buttons">
                        <label for="" style="color: white">بحث</label>
                        <a class="btn btn-success form-control" onclick="sortedBy()" title="بحث"><i class="fa fa-search"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <div class="col-12">
                    <div class="btns header-buttons">
                        <button class="btn bg-teal" onclick="" title="اضافة" data-toggle="modal"
                                data-target="#add-section">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteAllSection('more')" data-toggle="modal"
                                data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف المحدد
                        </button>
                        {{-- <button class="btn btn-danger" onclick="deleteAllSection('all')" data-toggle="modal" data-target="#confirm-all-del">
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
                            <th>الملاحظة</th>
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
                                <td>{{ $item->note }}</td>

                                <td>
                                    <p>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</p>
                                    <p>{{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</p>
                                </td>
                                <td>
                                    <div class="btn-action">
                                        <a href="#" class="btn btn-sm bg-teal" title="تعديل"
                                           onclick="editSection({{ $item }})" data-toggle="modal"
                                           data-target="#edit-section">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-danger" title="حذف"
                                           onclick="deleteSection('{{ $item->id }}')" data-toggle="modal"
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
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('modal')
    <!-- add-section modal-->
    <div class="modal fade" id="add-section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة قسم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('adduser_note') }}" id="addSectionForm" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <div class="form-group">
                            <label>الملاحظة</label>
                            <input type="text" name="note" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="addSection()"
                                    class="btn btn-sm btn-success save">حفظ</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end add-section modal-->
    <!-- edit-section modal-->
    <div class="modal fade" id="edit-section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل قسم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateuser_note') }}" id="updateSectionForm" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label>العنوان بالعربية</label>
                            <input type="text" name="note" id="edit_note" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="updateSection()"
                                    class="btn btn-sm btn-success save">حفظ</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-section modal-->
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
                    <form action="{{ route('deleteuser_note') }}" method="post" class="d-flex align-items-center">
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
                    <form action="{{ route('deleteuser_notes') }}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="user_note_ids" id="delete_ids">
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

        function sortedBy(){
            let start_date     = $('#start_date').val();
            let end_date       = $('#end_date').val();
            window.location.assign('?start_date=' + start_date + '&end_date=' + end_date);
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

        function addSection() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('adduser_note') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#addSectionForm")[0]),
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

        function editSection(section) {
            $('#edit_id').val(section.id);
            $('#edit_note').val(section.note);
            $('#edit_title_en').val(section.title_en);
            $('#edit_short_desc_ar').html(section.short_desc_ar);
            $('#edit_short_desc_en').html(section.short_desc_en);
            $('#edit_desc_ar').html(section.desc_ar);
            $('#edit_desc_en').html(section.desc_en);
            $('#edit_image').removeAttr('src');
            $('#edit_image').attr('src', "{{ url('') }}" + section.image);
        }

        function updateSection() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('updateuser_note') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updateSectionForm")[0]),
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

        function deleteSection(id) {
            $('#delete_id').val(id);
        }

        function deleteAllSection(type) {
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
            let sectionsIds = '';
            $('.checkSingle:checked').each(function() {
                let id = $(this).attr('id');
                sectionsIds += id + ' ';
            });
            let requestData = sectionsIds.split(' ');
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
