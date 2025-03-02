@extends('dashboard.master')
@section('title') إضافة عنصر @endsection
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
                    <form action="{{ route('addmedia_file') }}" id="addServiceForm" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" id="type" value="{{ $type }}">

                        @if($type != 'goals' && $type != 'nationality' && $type != 'levels' && $type != 'social_levels' && $type != 'news_bar')
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

                        @if($type == 'videos')
                            <div class="form-group">
                                <label>الفيديو</label>
                                <div class="main-input">
                                    <input class="file-input" type="file" name="video_photo" accept="video/mp4,video/x-m4v,video/*"/>
                                    <i class="fas fa-camera gray"></i>
                                    <span class="file-name text-right gray">

                                    </span>
                                    <div class="uploaded-image"></div>
                                </div>
                            </div>
                        @endif

                        {{-- @if($type == 'reports')
                            <div class="form-group">
                                <label>PDF</label>
                                <div class="main-input">
                                    <input class="file-input" type="file" name="pdf_photo" accept="pdf/*" />
                                    <i class="fas fa-camera gray"></i>
                                    <span class="file-name text-right gray">

                                    </span>
                                    <div class="uploaded-image"></div>
                                </div>
                            </div>
                        @endif --}}

                        {{-- @if($type == 'photos')
                            <div class="form-group">
                                <label>الصور</label>
                                <div class="main-input">
                                    <input class="file-input" type="file" name="photos[]" accept="image/*" multiple/>
                                    <i class="fas fa-camera gray"></i>
                                    <span class="file-name text-right gray">

                                    </span>
                                    <div class="uploaded-image"></div>
                                </div>
                            </div>
                        @endif --}}

                        @if($type == 'news')
                            <div class="form-group">
                                <label>القسم</label>
                                <select name="section_id" id="section_id" class="form-control">
                                    @foreach(App\Models\Section::orderBy('title_ar')->get() as $item)
                                        <option value="{{$item->id}}">{{$item->title_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if($type != 'photos' && $type != 'videos' && $type != 'news_bar')
                            <div class="form-group">
                                <label>الاسم</label>
                                <input type="text" name="title_ar" id="title_ar" class="form-control" value="">
                            </div>
                            <div class="form-group" style="display: none">
                                <label>الاسم بالإنجليزية</label>
                                <input type="text" name="title_en" id="title_en" dir="ltr" class="form-control" value="">
                            </div>
                        @endif

                        @if($type == 'news_bar')
                            <div class="form-group">
                                <label>الخبر</label>
                                <input type="text" name="title_ar" id="title_ar" class="form-control" value="">
                            </div>
                            <div class="form-group" style="display: none">
                                <label>الخبر بالإنجليزية</label>
                                <input type="text" name="title_en" id="title_en" dir="ltr" class="form-control" value="">
                            </div>
                        @endif
                        
                        @if($type == 'market')
                            <div class="form-group">
                                <label>العنوان</label>
                                <input type="text" name="address_ar" id="address_ar" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>القسم</label>
                                <select name="section_title_ar" class="form-control">
                                    @foreach (App\Models\Section::orderBy('title_ar' , 'asc')->get() as $item)
                                        <option value="{{ $item->title_ar }}">{{ $item->title_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        {{--@if($type == 'news')
                            <div class="form-group">
                                <label>التاريخ</label>
                                <input type="text" name="date" id="" class="form-control date-picker">
                            </div>
                        @endif--}}

                        @if($type == 'news' || $type == 'projects' || $type == 'services')
                            <div class="form-group">
                                <label>التفاصيل المختصرة</label>
                                <textarea name="short_desc_ar" id="short_desc_ar" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="form-group" style="display: none">
                                <label>التفاصيل المختصرة بالإنجليزية</label>
                                <textarea name="short_desc_en" id="short_desc_en" class="form-control" rows="3"></textarea>
                            </div>
                        @endif

                        @if($type != 'goals' && $type != 'nationality' && $type != 'levels' && $type != 'social_levels' && $type != 'news_bar')
                            <div class="form-group">
                                <label>التفاصيل</label>
                                <textarea name="desc_ar" id="desc_ar" class="form-control" rows="6"></textarea>
                            </div>
                            <div class="form-group" style="display: none">
                                <label>التفاصيل بالإنجليزية</label>
                                <textarea name="desc_en" id="desc_en" dir="ltr" class="form-control" rows="3"></textarea>
                            </div>
                        @endif

                        @if($type == 'projects')
                            <div class="form-group" style="position: relative;">
                                <input class="controls" id="pac-input" value="" placeholder="اكتب موقعك"/>
                                <input type="hidden" name="lat" id="lat" value="24.774265" readonly />
                                <input type="hidden" name="lng" id="lng" value="46.738586" readonly />
                                <div class="col-sm-12" id="add_map"></div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-center">
                            <button type="submit" style="width:100%"
                                    class="btn btn-sm btn-success save">حفظ</button>
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

        //CKEDITOR.replace( 'desc_ar' );
        //CKEDITOR.replace( 'desc_en' );

        /*ClassicEditor
            .create( document.querySelector( '#desc_ar' ) )
            .catch( error => {
                console.error( error );
            } );*/

        /*ClassicEditor
            .create( document.querySelector( '#desc_en' ) )
            .catch( error => {
                console.error( error );
            } );*/

        function additems() {
            let old_counter = parseInt($('#counter').val());
            $('#counter').val(old_counter + 1);
            let counter = parseInt($('#counter').val());
            $('.imgDescDiv').append('<div class="col-6"><input type="text" name="img_titles[' + counter +
                ']" class="form-control" placeholder="العنوان"></div><div class="col-6"><input type="text" name="img_descs[' +
                counter + ']" class="form-control" placeholder="التفاصيل"></div>');
        }

        function addService() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('addmedia_file') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#addServiceForm")[0]),
                success: function(msg) {
                    if (msg.value == '0') {
                        stop_loader();
                        $('.save').notify(
                            msg.msg, {
                                position: "top"
                            }
                        );
                    } else {
                        document.location.assign("{{ url('media_files', $type) }}");
                    }
                }
            });
        }

        $(document).on("click", ".uploaded-image", function() {
            $(this).addClass("active");
        });

        $("body").on("click", function() {
            $('.uploaded-image').removeClass("active");
        });

        //CKEDITOR.replace('desc_ar');
        // CKEDITOR.replace('desc_en');
        // CKEDITOR.replace('short_desc_ar');
        // CKEDITOR.replace('short_desc_en');
    </script>
@endsection
