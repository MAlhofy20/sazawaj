@extends('site.master')
@section('title') حسابي @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <!-- /.card-header -->
            <div class="card-body">
                <form action="{{route('site_post_profile')}}" id="profileForm" method="post" autocomplete="off" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{auth()->id()}}">
                    <input type="hidden" name="compelete" value="1">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <h3>البيانات الشخصية</h3>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div>
                                    <img style="width:110px;height: 100px;" src="{{url('') . auth()->user()->avatar}}" alt="">
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="control-label">الصورة الشخصية</label>
                                    <input type="file" autocomplete="nope" name="photo" id="photo" class="form-control" accept="image/*">
                                </div>
                            </div>
                            @if(auth()->user()->user_type == 'provider')
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">الاسم بالعربية</label>
                                        <input type="text" autocomplete="nope" name="full_name_ar" value="{{auth()->user()->full_name_ar}}" id="first_name" required class="form-control" placeholder="الاسم بالعربية">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">الاسم بالانجليزية</label>
                                        <input type="text" autocomplete="nope" name="full_name_en" value="{{auth()->user()->full_name_en}}" id="first_name" required class="form-control" placeholder="الاسم بالانجليزية">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group" style="position: relative;">
                                        <label class="control-label">سعر خدمة الاصدار</label>
                                        <input type="number" name="price" value="{{auth()->user()->price}}" required id="edit_price" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group" style="position: relative;">
                                        <label class="control-label">سعر خدمة التجديد</label>
                                        <input type="number" name="renewal_price" value="{{auth()->user()->renewal_price}}" required id="edit_renewal_price" class="form-control">
                                    </div>
                                </div>

                                @if((float) auth()->user()->lat == 0 || (float) auth()->user()->lng == 0)
                                    <div class="col-xs-12 col-md-12" style="margin-bottom: 5px">
                                        <input type="hidden" name="lat" id="lat" value="0" readonly />
                                        <input type="hidden" name="lng" id="lng" value="0" readonly />
                                        <div class="col-sm-12" id="add_map"></div>
                                    </div>
                                @else
                                    <div class="col-xs-12 col-md-12" style="margin-bottom: 5px">
                                        <input type="hidden" name="lat" id="edit_lat" value="{{auth()->user()->lat}}" readonly />
                                        <input type="hidden" name="lng" id="edit_lng" value="{{auth()->user()->lng}}" readonly />
                                        <div class="col-sm-12" id="edit_add_map"></div>
                                    </div>
                                @endif
                            @else
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">الاسم </label>
                                        <input type="text" autocomplete="nope" name="first_name" value="{{auth()->user()->first_name}}" id="first_name" required class="form-control" placeholder="الاسم ">
                                    </div>
                                </div>
                            @endif

                            <div class="col-xs-12 col-md-6">
                                <div class="form-group" style="position: relative;">
                                    <label for="field-2" class="control-label">رقم الجوال</label>
                                    <input type="text" autocomplete="nope" name="phone" value="{{auth()->user()->phone}}" id="phone" class="form-control phone" placeholder="رقم الجوال">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">البريد الألكتروني</label>
                                    <input type="email" autocomplete="nope" name="email" value="{{auth()->user()->email}}" id="email" required class="form-control" placeholder="البريد الألكتروني">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="field-3" class="control-label">كلمة السر</label>
                                    <input type="password" autocomplete="nope" value="" name="password" id="password"  class="form-control">
                                </div>
                            </div>

                            {{--@if(auth()->user()->user_type == 'provider')

                            @endif--}}
                        </div>
                    </div>
                    {{-- <input type="hidden" name="edit_lat"> --}}
                    {{-- <input type="hidden" name="edit_lng"> --}}
                    <div class="col-xs-12 col-md-12">
                        <button type="submit" style="width: 100%" class="btn btn-success waves-effect waves-light save" {{--onclick="site_post_profile()"--}}>تعديل</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            check_delivary();
        });

        function check_delivary() {
            let type = $('#has_delivary').val();
            if(type == '1') $('#delivary').removeAttr('disabled');
            else {
                $('#delivary').val('0');
                $('#delivary').attr('disabled' , '');
            }
        }

        function changeServiceType() {
            let type = $('#service_type').val();
            if(type == 'check') $('.check').show();
            else $('.check').hide();
        }

        function site_post_profile() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('site_post_profile') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#profileForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "top"
                            }
                        );
                    }else{
                        window.location.reload();
                    }
                }
            });
        }
    </script>
@endsection
