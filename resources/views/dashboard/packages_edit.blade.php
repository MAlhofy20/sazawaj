@extends('dashboard.master')
@section('title') تعديل عنصر @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{route('updatepackage')}}" id="updateSectionForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$data->id}}">
                        <div class="form-group">
                            <label>{{Translate('العنوان')}}</label>
                            <input type="text" name="title_ar" value="{{$data->title_ar}}" id="edit_title_ar" class="form-control" required>
                        </div>
                        {{--<div class="form-group">
                            <label>{{Translate('العنوان بالإنجليزية')}}</label>
                            <input type="text" name="title_en" value="{{$data->title_en}}" dir="ltr" id="edit_title_en" class="form-control">
                        </div>--}}
                        <div class="form-group">
                            <label>السعر (شامل القيمة المضافة)</label>
                            <div class="input-group">
                                <input type="tel" name="price_with_value" value="{{$data->price_with_value}}" id="edit_price_with_value" class="form-control phone">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">ريال</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>المدة (بالشهور)</label>
                            <div class="input-group">
                                <input type="tel" name="amount" value="{{$data->amount}}" id="edit_amount" class="form-control phone">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">شهر</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>الوصف</label>
                            <textarea name="desc_ar" id="desc_ar" class="form-control" rows="4">{{$data->desc_ar}}</textarea>
                        </div>
                        {{--<div class="form-group">
                            <label>الوصف بالإنجليزية</label>
                            <textarea name="desc_en" id="desc_en" class="form-control" rows="4" dir="ltr">{{$data->desc_en}}</textarea>
                        </div>--}}
                        <div class="d-flex justify-content-center">
                            <button type="submit" style="width:100%" class="btn btn-sm btn-success save">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
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

        CKEDITOR.replace('desc_ar');
    </script>
@endsection
