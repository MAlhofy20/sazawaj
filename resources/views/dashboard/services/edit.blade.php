@extends('dashboard.master')
@section('title')
    تعديل منتج
@endsection
@section('style')
    <style>
        .hide {
            display: none;
        }

    </style>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route('updateservice') }}" id="updateServiceForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id" value="{{ $data->id }}">

                        <div class="form-group">
                            <div class="input-group">
                                @foreach ($data->images as $image)
                                    <div id="image{{$image->id}}" style="width:25%;margin-bottom: 10px">
                                        <img src="{{url(''.$image->image)}}" style="width: 100%;height: 150px;">
                                        <a href="#" onclick="rmvImage('{{$image->id}}')" class="btn btn-danger" id="rmvImage" style="width: 100%">حذف</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الصورة')}}</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photos[]" accept="image/*" {{--multiple--}}/>
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>القسم - القسم الفرعي</label>
                            <select name="sub_section_id" class="form-control">
                                @foreach(App\Models\Sub_section::orderBy('section_id')->get() as $item)
                                    <option value="{{$item->id}}" {{$data->sub_section_id == $item->id ? 'selected' : ''}}>
                                        {{is_null($item->section) ? '' : $item->section->title . ' - '}} {{$item->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>العنوان بالعربية</label>
                            <input type="text" name="title_ar" value="{{ $data->title_ar }}" id="edit_title_ar"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>العنوان بالإنجليزية</label>
                            <input type="text" name="title_en" value="{{ $data->title_en }}" id="edit_title_en"
                                class="form-control" dir="ltr">
                        </div>
                        {{-- <div class="form-group">
                            <label>ملاحظات بالعربية</label>
                            <input type="text" name="desc_ar" value="{{ $data->desc_ar }}" id="edit_desc_ar"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label>ملاحظات بالإنجليزية</label>
                            <input type="text" name="desc_en" value="{{ $data->desc_en }}" id="edit_desc_en"
                                class="form-control" dir="ltr">
                        </div> --}}
                        <div class="form-group">
                            <label>السعر (شامل القيمة المضافة)</label>
                            <div class="input-group">
                                <input type="tel" name="price_with_value" class="form-control phone" value="{{ $data->price_with_value }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">ريال</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>السعر قبل الخصم (شامل القيمة المضافة)</label>
                            <div class="input-group">
                                <input type="tel" name="discount" class="form-control phone" value="{{ $data->discount }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">ريال</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label>القيمة المضافة</label>
                            <div class="input-group">
                                <input type="tel" name="value_added" class="form-control phone" {{--value="{{ $data->value_added }}"--}} value="15">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-percent"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label>التقييم</label>
                            <div class="input-group">
                                <input type="tel" name="rate" class="form-control phone" value="{{ $data->rate }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-star"></i></span>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label>نوع التصميم</label>
                            <select name="type" class="form-control">
                                <option value="special" {{$data->type == 'special' ? 'selected' : ''}}>قالب مخصص</option>
                                <option value="static" {{$data->type == 'static' ? 'selected' : ''}}>قالب جاهز</option>
                            </select>
                        </div> --}}

                        <div class="form-group">
                            <label>الوصف بالعربية</label>
                            <textarea name="desc_ar" id="edit_desc_ar" class="form-control"
                                rows="3">{{ $data->desc_ar }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>الوصف بالإنجليزية</label>
                            <textarea name="desc_en" id="edit_desc_en" class="form-control" rows="3"
                                dir="ltr">{{ $data->desc_en }}</textarea>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <h3>خدمات اضافية</h3>
                            </div>
                        </div>
                        <div class="row options">
                            @if($data->options->count() > 0)
                                @foreach ($data->options as $key=>$item)
                                    <div class="col-xs-12 col-md-4">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">العنوان بالعربية</label>
                                            <input type="text" autocomplete="nope" name="option_titles_ar[{{$key}}]" value="{{$item->title_ar}}" class="form-control" placeholder="العنوان بالعربية">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">العنوان بالانجليزية</label>
                                            <input type="text" autocomplete="nope" name="option_titles_en[{{$key}}]" value="{{$item->title_en}}" class="form-control" placeholder="العنوان بالانجليزية">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">السعر (شامل القيمة المضافة)</label>
                                            <input type="text" autocomplete="nope" name="option_prices[{{$key}}]" value="{{$item->price_with_value}}" class="form-control phone" placeholder="السعر (شامل القيمة المضافة)">
                                        </div>
                                    </div>
                                @endforeach
                                <input type="hidden" id="option_counter" value="{{$key}}">

                            @else
                                <input type="hidden" id="option_counter" value="0">
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">العنوان بالعربية</label>
                                        <input type="text" autocomplete="nope" name="option_titles_ar[0]" value="" class="form-control" placeholder="العنوان بالعربية">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">العنوان بالانجليزية</label>
                                        <input type="text" autocomplete="nope" name="option_titles_en[0]" value="" class="form-control" placeholder="العنوان بالانجليزية">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">السعر (شامل القيمة المضافة)</label>
                                        <input type="text" autocomplete="nope" name="option_prices[0]" value="" class="form-control phone" placeholder="السعر (شامل القيمة المضافة)">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <a href="#" onclick="addOptions()" class="btn btn-info"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" style="width:100%" class="btn btn-sm btn-success save"
                                onclick="updateService()">حفظ</button>
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
        function show_price(id) {
            // $('#price_'+id).toggleClass('hide');
            // $('#discount_'+id).toggleClass('hide');
            // $('#price_input_'+id).val('');
            // $('#discount_input_'+id).val('');
        }

        function addTypes() {
            event.preventDefault();
            let counter = parseInt($('#counter').val()) + 1;
            $('#counter').val(counter);
            $('.types').append('<div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">العنوان بالعربية</label><input type="text" autocomplete="nope" name="size_titles_ar['+counter+']" value="" class="form-control" placeholder="العنوان بالعربية"></div></div><div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">العنوان بالانجليزية</label><input type="text" autocomplete="nope" name="size_titles_en['+counter+']" value="" class="form-control" placeholder="العنوان بالانجليزية"></div></div><div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">السعر (شامل القيمة المضافة)</label><input type="text" autocomplete="nope" name="size_prices['+counter+']" value="" class="form-control phone" placeholder="السعر (شامل القيمة المضافة)"></div></div>');
        }

        function addOptions() {
            event.preventDefault();
            let option_counter = parseInt($('#option_counter').val()) + 1;
            $('#option_counter').val(option_counter);
            $('.options').append('<div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">العنوان بالعربية</label><input type="text" autocomplete="nope" name="option_titles_ar['+option_counter+']" value="" class="form-control" placeholder="العنوان بالعربية"></div></div><div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">العنوان بالانجليزية</label><input type="text" autocomplete="nope" name="option_titles_en['+option_counter+']" value="" class="form-control" placeholder="العنوان بالانجليزية"></div></div><div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">السعر (شامل القيمة المضافة)</label><input type="text" autocomplete="nope" name="option_prices['+option_counter+']" value="" class="form-control phone" placeholder="السعر (شامل القيمة المضافة)"></div></div>');
        }

        function addSides() {
            event.preventDefault();
            let side_counter = parseInt($('#side_counter').val()) + 1;
            $('#side_counter').val(side_counter);
            $('.sides').append('<div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">العنوان بالعربية</label><input type="text" autocomplete="nope" name="side_titles_ar['+side_counter+']" value="" class="form-control" placeholder="العنوان بالعربية"></div></div><div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">العنوان بالانجليزية</label><input type="text" autocomplete="nope" name="side_titles_en['+side_counter+']" value="" class="form-control" placeholder="العنوان بالانجليزية"></div></div><div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">السعر (شامل القيمة المضافة)</label><input type="text" autocomplete="nope" name="side_prices['+side_counter+']" value="" class="form-control phone" placeholder="السعر (شامل القيمة المضافة)"></div></div>');
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

        function rmvImage(id) {
            if(id == '') return false;
            var token = '{{csrf_token()}}';
            $.ajax({
                type     : 'POST',
                url      : '{{ route('rmvImage') }}' ,
                datatype : 'json' ,
                data     : {
                    'id'         :  parseInt(id) ,
                    '_token'     :  token
                }, success   : function(msg){
                    if(msg=='err'){
                        $('#rmvImage').html('لا يمكن حذف اخر صورة');
                        return false;
                    }
                    $('#image'+id).fadeOut();
                }
            });
        }

        function updateService() {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route('updateservice') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updateServiceForm")[0]),
                success: function(msg) {
                    if (msg.value == '0') {
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    } else {
                        window.location.assign("{{ route('services', $data->sub_section_id) }}");
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
    </script>
@endsection
