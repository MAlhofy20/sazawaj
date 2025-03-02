@extends('site.master')
@section('title') {{Translate('تعديل منتج')}} @endsection
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
                    <form action="{{route('site_updateservice')}}" id="updateServiceForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="edit_id" value="{{$data->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
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
                                <input class="file-input" type="file" name="photos[]" accept="image/*" multiple/>
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('العنوان بالعربية')}}</label>
                            <input type="text" name="title_ar" value="{{$data->title_ar}}" id="edit_title_ar" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{Translate('العنوان بالإنجليزية')}}</label>
                            <input type="text" name="title_en" value="{{$data->title_en}}" id="edit_title_en" class="form-control" dir="ltr">
                        </div>
                        <div class="form-group">
                            <label>{{Translate('سعر الوحدة')}}</label>
                            <input type="text" name="price" value="{{$data->price}}" id="edit_price" class="form-control phone" placeholder="سعر (الكيلو, اللتر, ....)">
                        </div>
                        <div class="form-group">
                            <label>{{Translate('الكمية')}}</label>
                            <input type="text" name="amount" value="{{$data->amount}}" id="" class="form-control phone">
                        </div>
                        <div class="form-group">
                            <label>{{Translate('وحدة القياس')}}</label>
                            <select name="unit" class="form-control">
                                @foreach (App\Models\Unit::orderBy('title' , 'asc')->get() as $item)
                                    <option value="{{ $item->title }}" {{$item->title == $data->unit ? 'selected' : ''}}>{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('التفاصيل الكاملة بالعربية')}}</label>
                            <textarea name="desc_ar" id="edit_desc_ar" class="form-control" rows="3">{{$data->desc_ar}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{Translate('التفاصيل الكاملة بالإنجليزية')}}</label>
                            <textarea name="desc_en" id="edit_desc_en" class="form-control" rows="3" dir="ltr">{{$data->desc_en}}</textarea>
                        </div>



                        <hr>

                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <h3>{{Translate('عروض الاسعار')}}</h3>
                            </div>
                        </div>
                        <div class="row types">
                            @if($data->offers->count() > 0)
                                @foreach ($data->offers as $key=>$item)
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">الكمية من</label>
                                            <input type="text" autocomplete="nope" name="amounts[{{$key}}]" value="{{$item->amount}}" required class="form-control phone" placeholder="رسوم الحجز">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">السعر</label>
                                            <input type="text" autocomplete="nope" name="prices[{{$key}}]" value="{{$item->price}}" required class="form-control phone" placeholder="رسوم الحجز">
                                        </div>
                                    </div>
                                @endforeach
                                <input type="hidden" id="counter" value="{{$key}}">
                            @else
                                <input type="hidden" id="counter" value="0">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">الكمية من</label>
                                        <input type="text" autocomplete="nope" name="amounts[0]" required class="form-control phone" placeholder="الكمية من">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">سعر الوحدة</label>
                                        <input type="text" autocomplete="nope" name="prices[0]" required class="form-control phone" placeholder="سعر (الكيلو, اللتر, ....)">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-xs-12 col-md-12">
                                <a href="#" onclick="addTypes()" class="btn btn-info"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" style="width:100%" class="btn btn-sm btn-success save" onclick="updateService()">{{Translate('حفظ')}}</button>
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

        function addTypes() {
            event.preventDefault();
            let counter = parseInt($('#counter').val()) + 1;
            $('#counter').val(counter);
            $('.types').append('<div class="col-xs-12 col-md-6"><div class="form-group"><label for="field-1" class="control-label">الكمية من </label><input type="text" autocomplete="nope" name="amounts['+counter+']" value="" required class="form-control phone" placeholder="الكمية من"></div></div><div class="col-xs-12 col-md-6"><div class="form-group"><label for="field-1" class="control-label">سعر الوحدة </label><input type="text" autocomplete="nope" name="prices['+counter+']" value="" required class="form-control phone" placeholder="سعر (الكيلو, اللتر, ....)"></div></div>');
        }

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
                type        : 'POST',
                url         : '{{ route('site_updateservice') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updateServiceForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        window.location.assign("{{route('site_services' , $data->sub_section)}}");
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
