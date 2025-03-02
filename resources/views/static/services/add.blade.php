@extends('site.master')
@section('title') {{Translate('إضافة كتاب')}} @endsection
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
                    <form action="{{route('addservice')}}" id="addServiceForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{Translate('القسم')}}</label>
                            <select name="section_id" class="form-control" required>
                                @foreach (App\Models\Section::orderBy('title_ar' , 'asc')->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->title_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الصورة')}}</label>
                            <div class="main-input">
                            <input class="file-input" type="file" name="photo" accept="image/*" required/>
                            <i class="fas fa-camera gray"></i>
                            <span class="file-name text-right gray">

                            </span>
                            <div class="uploaded-image"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الكتاب')}}</label>
                            <div class="main-input">
                            <input class="file-input" type="file" name="pdf_uploader"/>
                            <i class="fas fa-book gray"></i>
                            <span class="file-name text-right gray">

                            </span>
                            <div class="uploaded-image"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('التسجيل الصوتي')}}</label>
                            <div class="main-input">
                            <input class="file-input" type="file" name="audio_uploader"/>
                            <i class="fas fa-microphone-alt gray"></i>
                            <span class="file-name text-right gray">

                            </span>
                            <div class="uploaded-image"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('اسم الكتاب بالعربية')}}</label>
                            <input type="text" name="title_ar" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('اسم الكتاب بالإنجليزية')}}</label>
                            <input type="text" name="title_en" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('التفاصيل الكاملة بالعربية')}}</label>
                            <textarea name="desc_ar" id="desc_ar" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('التفاصيل الكاملة بالإنجليزية')}}</label>
                            <textarea name="desc_en" id="desc_en" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" style="width:100%" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
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

        CKEDITOR.replace( 'desc_ar' );
        CKEDITOR.replace( 'desc_en' );

        // ClassicEditor
        //     .create( document.querySelector( '#desc_ar' ) )
        //     .catch( error => {
        //         console.error( error );
        //     } );

        // ClassicEditor
        //     .create( document.querySelector( '#desc_en' ) )
        //     .catch( error => {
        //         console.error( error );
        //     } );

        function addService() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('addservice') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addServiceForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "top"
                            }
                        );
                    }else{
                        window.location.assign("{{route('services')}}");
                    }
                }
            });
        }

        $(document).on("click", ".uploaded-image", function () {
            $(this).addClass("active");
        });

        $("body").on("click", function () {
            $('.uploaded-image').removeClass("active");
        });
    </script>
@endsection
