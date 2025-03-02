@extends('dashboard.master')
@section('title')
    تعديل اسرة
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
                    <form action="{{ route('updatemarket') }}" id="updateMarketForm" method="POST"
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
                            <label>صور المنتجات</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photos[]" accept="image/*" multiple/>
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>الصورة الشخصية</label>
                            <div class="main-input">
                                <input class="file-input" type="file" name="photo" accept="image/*"/>
                                <i class="fas fa-camera gray"></i>
                                <span class="file-name text-right gray">

                                </span>
                                <div class="uploaded-image">
                                    <img src="{{url('' . $data->avatar)}}" id="edit_avatar" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>الاسم</label>
                            <input type="text" name="first_name" value="{{$data->first_name}}" id="edit_first_name" class="form-control">
                        </div>
                        <div class="form-group" style="display: none">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{$data->email}}" id="edit_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>الجوال</label>
                            <input type="text" name="phone" value="{{$data->phone}}" class="form-control phone" id="edit_phone">
                        </div>
                        <div class="form-group">
                            <label>المدينة - الحي</label>
                            <select name="neighborhood_id" class="form-control select2">
                                @foreach (App\Models\Neighborhood::whereHas('city')->orderBy('city_id' , 'asc')->get() as $item)
                                    <option value="{{ $item->id }}" {{$item->id == $data->neighborhood_id ? 'selected' : ''}}>{{ is_null($item->city) ? '' : $item->city->title_ar }} - {{ $item->title_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>الانستاجرام</label>
                            <input type="url" name="instagram" value="{{$data->instagram}}" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label>تويتر</label>
                            <input type="url" name="twitter" value="{{$data->twitter}}" class="form-control" id="">
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" style="width:100%" class="btn btn-sm btn-success save"
                                    onclick="updateMarket()">حفظ</button>
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
                url      : '{{ route('rmvMarketImage') }}' ,
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

        function updateMarket() {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route('updatemarket') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updateMarketForm")[0]),
                success: function(msg) {
                    if (msg.value == '0') {
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    } else {
                        window.location.assign("{{ route('markets') }}");
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
