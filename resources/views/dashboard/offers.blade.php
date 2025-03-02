@extends('dashboard.master')
@section('title') {{ Translate('العروض') }} @endsection
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
                        <button class="btn bg-teal" title="{{ Translate('اضافة') }}" data-toggle="modal"
                            data-target="#add-offer">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteAllOffer('more')" data-toggle="modal"
                            data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            {{ Translate('حذف المحدد') }}
                        </button>
                        {{-- <button class="btn btn-danger" onclick="deleteAllOffer('all')" data-toggle="modal" data-target="#confirm-all-del">
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
                                {{-- <th>{{Translate('الصورة')}}</th> --}}
                                <th>{{ Translate('اسم المحل') }}</th>
                                <th>{{ Translate('الحد الادنى') }}</th>
                                {{-- <th>{{Translate('القسم')}}</th> --}}
                                <th>{{ Translate('وقت التسجيل') }}</th>
                                <th>{{ Translate('التحكم') }}</th>
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
                                    {{-- <td>
                                        <a data-fancybox data-caption="{{$item->title_ar}}" href="{{ url(''.$item->image) }}">
                                            <img src="{{ url(''.$item->image) }}" height="40px" width="35px" alt="" class="img-circle">
                                        </a>
                                    </td> --}}
                                    <td>
                                        @if (!is_null($item->user))
                                            {{ is_null($item->user->full_name) ? $item->user->name : $item->user->full_name }}
                                        @endif
                                    </td>
                                    <td>{{ $item->price }}</td>
                                    {{-- <td>{{$item->section->title_ar}}</td> --}}
                                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-action">
                                            <a href="#" class="btn btn-sm bg-teal" title="{{ Translate('تعديل') }}"
                                                onclick="editOffer({{ $item }})" data-toggle="modal"
                                                data-target="#edit-offer">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <a href="#" class="btn btn-sm btn-danger" title="{{ Translate('حذف') }}"
                                                onclick="deleteOffer('{{ $item->id }}')" data-toggle="modal"
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
    <!-- add-offer modal-->
    <div class="modal fade" id="add-offer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ Translate('إضافة عرض') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addoffer') }}" id="addOfferForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="form-group">
                            <label>{{ Translate('الصورة') }}</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photo" accept="image/*" />
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                                <div class="uploaded-image"></div>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label>{{ Translate('اسم المحل') }}</label>
                            <select name="user_id" class="form-control select2">
                                @foreach (App\Models\User::where('user_type', 'market')->orderBy('full_name', 'asc')->get()
        as $item)
                                    <option value="{{ $item->id }}">
                                        {{ is_null($item->full_name) ? $item->name : $item->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ Translate('الحد الادنى') }}</label>
                            <input type="text" name="price" class="form-control phone">
                        </div>
                        <div class="form-group">
                            <label>{{ Translate('التفاصيل الكاملة بالعربية') }}</label>
                            <textarea name="desc_ar" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ Translate('التفاصيل الكاملة بالإنجليزية') }}</label>
                            <textarea name="desc_en" dir="ltr" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="addOffer()"
                                class="btn btn-sm btn-success save">{{ Translate('حفظ') }}</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">{{ Translate('إغلاق') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end add-offer modal-->
    <!-- edit-offer modal-->
    <div class="modal fade" id="edit-offer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ Translate('تعديل عرض') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateoffer') }}" id="updateOfferForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id">
                        {{-- <div class="form-group">
                            <label>{{ Translate('الصورة') }}</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photo" accept="image/*" />
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                                <div class="uploaded-image">
                                    <img src="" id="edit_image" alt="">
                                </div>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label>{{ Translate('اسم المحل') }}</label>
                            <select name="user_id" id="edit_user_id" class="form-control edit-select2">
                                @foreach (App\Models\User::where('user_type', 'market')->orderBy('full_name', 'asc')->get()
        as $item)
                                    <option value="{{ $item->id }}">
                                        {{ is_null($item->full_name) ? $item->name : $item->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ Translate('الحد الادنى') }}</label>
                            <input type="text" name="price" id="edit_price" class="form-control phone">
                        </div>
                        <div class="form-group">
                            <label>{{ Translate('التفاصيل الكاملة بالعربية') }}</label>
                            <textarea name="desc_ar" id="edit_desc_ar" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ Translate('التفاصيل الكاملة بالإنجليزية') }}</label>
                            <textarea name="desc_en" id="edit_desc_en" dir="ltr" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" onclick="updateOffer()"
                                class="btn btn-sm btn-success save">{{ Translate('حفظ') }}</button>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">{{ Translate('إغلاق') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end edit-offer modal-->
    <!-- confirm-del modal-->
    <div class="modal fade" id="confirm-del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ Translate('تأكيد الحذف') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        {{ Translate('هل تريد الاستمرار في عملية الحذف ؟') }}
                    </h3>
                    <form action="{{ route('deleteoffer') }}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="id" id="delete_id">
                        <button type="submit" class="btn btn-sm btn-success">{{ Translate('تأكيد') }}</button>
                        <button class="btn btn-sm btn-danger" data-dismiss="modal">{{ Translate('إلغاء') }}</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ Translate('تأكيد الحذف') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        {{ Translate('هل تريد الاستمرار في عملية الحذف ؟') }}
                    </h3>
                    <form action="{{ route('deleteoffers') }}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="section_ids" id="delete_ids">
                        <input type="hidden" name="type" id="delete_type">
                        <button type="submit" onclick="checkDataIds()"
                            class="btn btn-sm btn-success">{{ Translate('تأكيد') }}</button>
                        <button class="btn btn-sm btn-danger" id="delete-all-modal"
                            data-dismiss="modal">{{ Translate('إلغاء') }}</button>
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

        function addOffer() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('addoffer') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#addOfferForm")[0]),
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

        function editOffer(offer) {
            $('#edit_id').val(offer.id);
            $('#edit_user_id').val(offer.user_id);
            $('#edit_price').val(offer.price);
            $('#edit_desc_ar').val(offer.desc_ar);
            $('#edit_desc_en').val(offer.desc_en);
            $('.edit-select2').select2();
            // $('#edit_image').removeAttr('src');
            // $('#edit_image').attr('src', "{{ url('') }}" + offer.image);
        }

        function updateOffer() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('updateoffer') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updateOfferForm")[0]),
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

        function deleteOffer(id) {
            $('#delete_id').val(id);
        }

        function deleteAllOffer(type) {
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
            let offersIds = '';
            $('.checkSingle:checked').each(function() {
                let id = $(this).attr('id');
                offersIds += id + ' ';
            });
            let requestData = offersIds.split(' ');
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
