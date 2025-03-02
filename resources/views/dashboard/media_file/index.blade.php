@extends('dashboard.master')
@section('title') بيانات عامة @endsection
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
                        @if($type != 'statics')

                            @if($type == 'news')
                                <a class="btn bg-teal" title="اضافة"
                                   href="{{ url('add-page-media_file', $type) }}">
                                    <i class="fas fa-plus"></i>
                                </a>
                            @else
                                <button class="btn bg-teal" title="{{Translate('اضافة')}}" data-toggle="modal" data-target="#add-service">
                                    <i class="fas fa-plus"></i>
                                </button>
                            @endif


                            <button class="btn btn-danger" onclick="deleteAllService('more')" data-toggle="modal"
                                    data-target="#confirm-all-del">
                                <i class="fas fa-trash"></i>
                                حذف المحدد
                            </button>
                        @endif
                        {{--<a class="btn bg-teal" title="اضافة"
                           href="{{ url('add-page-media_file', $type) }}">
                            <i class="fas fa-plus"></i>
                        </a>--}}

                        {{-- <button class="btn btn-danger" onclick="deleteAllService('all')" data-toggle="modal"
                            data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف الكل
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

                            @if($type != 'statics')
                                <th>
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input" id="checkedAll">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                </th>
                            @endif

                            <th>#</th>
                            @if($type != 'goals' && $type != 'nationality' && $type != 'levels' && $type != 'jobs' && $type != 'social_levels' && $type != 'news_bar')
                                <th>الصورة</th>
                            @endif
                            @if($type != 'photos' && $type != 'videos')
                                <th>العنوان</th>
                            @endif
                            @if($type == 'videos')
                                <th>الفيديو</th>
                            @endif
                            @if($type == 'projects')
                                <th>الموقع</th>
                            @endif
                            <th>وقت التسجيل</th>
                            <th>التحكم</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $i => $item)
                            <tr style="text-align: center">

                                @if($type != 'statics')
                                    <td>
                                        <label class="custom-control material-checkbox" style="margin: auto">
                                            <input type="checkbox" class="material-control-input checkSingle"
                                                   id="{{ $item->id }}">
                                            <span class="material-control-indicator"></span>
                                        </label>
                                    </td>
                                @endif
                                <td>{{ ++$i }}</td>
                                @if($type != 'goals' && $type != 'nationality' && $type != 'levels' && $type != 'jobs' && $type != 'social_levels' && $type != 'news_bar')
                                    <td>
                                        <a data-fancybox data-caption="{{ $item->title }}"
                                           href="{{ url('' . $item->image) }}">
                                            <img src="{{ url('' . $item->image) }}" height="40px" width="35px" alt=""
                                                 class="img-circle">
                                        </a>
                                    </td>
                                @endif
                                @if($type != 'photos' && $type != 'videos')
                                    <td>{{ $item->title }}</td>
                                @endif
                                @if($type == 'videos')
                                    <td><a href="{{ url('' . $item->video) }}" class="btn btn-info" target="_blanck">عرض</a></td>
                                @endif
                                @if($type == 'projects')
                                    <td>
                                        <a href="https://www.google.com/maps/?q={{ $item->lat }},{{ $item->lng }}"
                                            class="btn btn-info" target="_blanck">عرض</a>
                                    </td>
                                @endif
                                <td>
                                     <p>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</p>
                                     {{--<p>{{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</p>--}}
                                </td>
                                <td>
                                    <div class="btn-action">
                                        @if($type == 'news')
                                            <a href="{{ url('edit-page-media_file/' . $item->id) }}"
                                               class="btn btn-sm bg-teal" title="تعديل">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-sm bg-teal" title="{{Translate('تعديل')}}" onclick="editService({{ $item }})"  data-toggle="modal" data-target="#edit-service">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        @endif


                                        @if($type != 'statics')
                                            <a href="#" class="btn btn-sm btn-danger" title="حذف"
                                               onclick="deleteService('{{ $item->id }}')" data-toggle="modal"
                                               data-target="#confirm-del">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
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
    <!-- add-service modal-->
    <div class="modal fade" id="add-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <form action="{{route('addmedia_file')}}" id="addServiceForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" id="type" value="{{ $type }}">

                        @if($type != 'goals' && $type != 'nationality' && $type != 'levels' && $type != 'jobs' && $type != 'social_levels' && $type != 'news_bar')
                            <div class="form-group">
                                <label>الصورة</label>
                                <div class="main-input">
                                    <input class="file-input" type="file" name="photo" accept="image/*" />
                                    <i class="fas fa-camera gray"></i>
                                    <span class="file-name text-right gray">

                                    </span>
                                    <div class="uploaded-image"></div>
                                </div>
                            </div>
                        @endif

                        @if($type != 'photos' && $type != 'videos')
                            <div class="form-group">
                                <label>الاسم</label>
                                <input type="text" name="title_ar" id="title_ar" class="form-control" value="">
                            </div>
                            <div class="form-group" style="display: none">
                                <label>الاسم بالإنجليزية</label>
                                <input type="text" name="title_en" id="title_en" dir="ltr" class="form-control" value="">
                            </div>
                        @endif

                        @if($type != 'goals' && $type != 'nationality' && $type != 'levels' && $type != 'jobs' && $type != 'social_levels' && $type != 'news_bar')
                            <div class="form-group">
                                <label>التفاصيل</label>
                                <textarea name="desc_ar" id="desc_ar" class="form-control" rows="1"></textarea>
                            </div>
                            <div class="form-group" style="display: none">
                                <label>التفاصيل بالإنجليزية</label>
                                <textarea name="desc_en" id="desc_en" dir="ltr" class="form-control" rows="1"></textarea>
                            </div>
                        @endif
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="addService()" class="btn btn-sm btn-success save">حفظ</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end add-service modal-->
    <!-- edit-service modal-->
    <div class="modal fade" id="edit-service" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <form action="{{route('updateservice')}}" id="updateServiceForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">

                        @if($type != 'goals' && $type != 'nationality' && $type != 'levels' && $type != 'jobs' && $type != 'social_levels' && $type != 'news_bar')
                            <div class="form-group">
                                <label>الصورة</label>
                                <div class="main-input">
                                    <input class="file-input" type="file" name="photo" accept="image/*"/>
                                    <i class="fas fa-camera gray"></i>
                                    <span class="file-name text-right gray">

                                </span>
                                    <div class="uploaded-image">
                                        <img src="" id="edit_image" alt="">
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($type != 'photos' && $type != 'videos')
                            <div class="form-group">
                                <label>الاسم</label>
                                <input type="text" name="title_ar" id="edit_title_ar" class="form-control" value="">
                            </div>
                            <div class="form-group" style="display: none">
                                <label>الاسم بالإنجليزية</label>
                                <input type="text" name="title_en" id="edit_title_en" dir="ltr" class="form-control" value="">
                            </div>
                        @endif

                        @if($type != 'goals' && $type != 'nationality' && $type != 'levels' && $type != 'jobs' && $type != 'social_levels' && $type != 'news_bar')
                            <div class="form-group">
                                <label>التفاصيل</label>
                                <textarea name="desc_ar" id="edit_desc_ar" class="form-control" rows="1"></textarea>
                            </div>
                            <div class="form-group" style="display: none">
                                <label>التفاصيل بالإنجليزية</label>
                                <textarea name="desc_en" id="edit_desc_en" dir="ltr" class="form-control" rows="1"></textarea>
                            </div>
                        @endif
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="updateService()" class="btn btn-sm btn-success save">حفظ</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-service modal-->
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
                    <form action="{{ route('deletemedia_file') }}" method="post" class="d-flex align-items-center">
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
                    <form action="{{ route('deletemedia_files') }}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="media_file_ids" id="delete_ids">
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



        function addService() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('addmedia_file') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addServiceForm")[0]),
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

        function editService(service){
            $('#edit_id').val(service.id);
            $('#edit_section_id').val(service.section_id);
            $('#edit_title_ar').val(service.title_ar);
            $('#edit_title_en').val(service.title_en);
            $('#edit_short_desc_ar').val(service.short_desc_ar);
            $('#edit_short_desc_en').val(service.short_desc_en);
            $('#edit_desc_ar').val(service.desc_ar);
            $('#edit_desc_en').val(service.desc_en);
            $('#edit_image').removeAttr('src');
            $('#edit_image').attr('src' , "{{url('')}}"+service.image);
        }

        function updateService() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('updatemedia_file') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updateServiceForm")[0]),
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

        function deleteService(id) {
            $('#delete_id').val(id);
        }

        function deleteAllService(type) {
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
            let media_filesIds = '';
            $('.checkSingle:checked').each(function() {
                let id = $(this).attr('id');
                media_filesIds += id + ' ';
            });
            let requestData = media_filesIds.split(' ');
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
