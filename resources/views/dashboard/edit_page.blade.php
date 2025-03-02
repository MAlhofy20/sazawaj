@extends('dashboard.master')
@section('title') {{ Translate('تعديل عنصر') }} @endsection
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
                    <form action="{{ route('updatepage') }}" id="updatepageForm" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data->id }}">

                        <div class="form-group" style="display: none">
                            <label>{{ Translate('الصورة') }}</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photo" accept="image/*" />
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                                <div class="uploaded-image">
                                    <img src="{{ url('' . $data->image) }}" id="" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ Translate('العنوان') }}</label>
                            <input type="text" name="title_ar" id="title_ar" class="form-control"
                                   value="{{ $data->title_ar }}">
                        </div>
                        <div class="form-group" style="display: none">
                            <label>{{ Translate('العنوان بالإنجليزية') }}</label>
                            <input type="text" name="title_en" id="title_en" dir="ltr" class="form-control"
                                   value="{{ $data->title_en }}">
                        </div>

                        <div class="form-group">
                            <label>{{ Translate('التفاصيل') }}</label>
                            <textarea name="desc_ar" id="desc_ar" class="form-control" rows="3"
                                      required>{{ $data->desc_ar }}</textarea>
                        </div>
                        
                        <!-- 
                        <div class="form-group" style="display: none">
                            <label>{{ Translate('التفاصيل الكاملة بالإنجليزية') }}</label>
                           <textarea name="desc_en" id="desc_en" class="form-control" rows="3"
                                     required>{{ $data->desc_en }}</textarea>
                        </div>
                        -->
                        

                        <div class="d-flex justify-content-center">
                            <button type="submit" style="width:100%"
                                    class="btn btn-sm btn-success save">{{ Translate('حفظ') }}</button>
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

        // Initialize Select2 Elements
        $('.select2').select2()

        // Initialize Select2 Elements with Bootstrap 4 Theme
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
            $('#label-switch').bootstrapSwitch('onText', 'I');
            $('#label-switch').bootstrapSwitch('offText', 'O');
        });

        // Initialize CKEditor for desc_ar (Arabic Text)
        ClassicEditor
            .create(document.querySelector('#desc_ar'), {
                language: 'ar', // Set language to Arabic
                removePlugins: ['Link'], // Example to remove the 'link' plugin
                toolbar: ['bold', 'italic', 'underline', 'fontSize', 'alignment', 'fontColor', 'numberedList', 'bulletedList'],
                allowedContent: true, // Allow all content (you may want to restrict this in production)
                autoParagraph: true, // Automatically create paragraphs
            })
            .catch(error => {
                console.error(error);
            });

        // Initialize CKEditor for desc_en (English Text)
        ClassicEditor
            .create(document.querySelector('#desc_en'), {
                language: 'en', // Set language to English
                removePlugins: ['Link'], // Example to remove the 'link' plugin
                toolbar: ['bold', 'italic', 'underline', 'fontSize', 'alignment', 'fontColor', 'numberedList', 'bulletedList'],
                allowedContent: true, // Allow all content (you may want to restrict this in production)
                autoParagraph: true, // Automatically create paragraphs
            })
            .catch(error => {
                console.error(error);
            });

    });

    function additems() {
        let old_counter = parseInt($('#counter').val());
        $('#counter').val(old_counter + 1);
        let counter = parseInt($('#counter').val());
        $('.imgDescDiv').append('<div class="col-6"><input type="text" name="img_titles[' + counter +
            ']" class="form-control" placeholder="العنوان"></div><div class="col-6"><input type="text" name="img_descs[' +
            counter + ']" class="form-control" placeholder="التفاصيل"></div>');
    }

    function updatepage() {
        event.preventDefault();
        start_loader();
        $.ajax({
            type: 'POST',
            url: '{{ route('updatepage') }}',
            datatype: 'json',
            async: false,
            processData: false,
            contentType: false,
            data: new FormData($("#updatepageForm")[0]),
            success: function(msg) {
                if (msg.value == '0') {
                    stop_loader();
                    $('.save').notify(
                        msg.msg, {
                            position: "top"
                        }
                    );
                } else {
                    document.location.assign("{{ url('pages') }}");
                }
            }
        });
    }

</script>
@endsection

