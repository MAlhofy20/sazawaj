@extends('site.master')
@section('title') {{Translate('حسابي')}} @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <!-- /.card-header -->
            <div class="card-body">
                <form action="{{route('site_post_hospital_profile')}}" id="profileForm" method="post" autocomplete="off" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{Auth::id()}}">
                    <input type="hidden" name="compelete" value="1">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <h3>{{Translate('البيانات الشخصية')}}</h3>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div>
                                    <img style="width:110px;height: 100px;" src="{{url('') . Auth::user()->avatar}}" alt="">
                                </div>
                                <div class="form-group">
                                    <label for="field-1" class="control-label">الصورة الشخصية</label>
                                    <input type="file" autocomplete="nope" name="avatar" id="avatar" required class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">الاسم </label>
                                    <input type="text" autocomplete="nope" name="first_name" value="{{Auth::user()->first_name}}" id="first_name" required class="form-control" placeholder="الاسم الاول">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group" style="position: relative;">
                                    <label for="field-2" class="control-label">رقم الجوال</label>
                                    <input type="text" autocomplete="nope" name="phone" value="{{Auth::user()->phone}}" id="phone" required class="form-control phone" placeholder="رقم الجوال">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">البريد الألكتروني</label>
                                    <input type="email" autocomplete="nope" name="email" value="{{Auth::user()->email}}" id="email" required class="form-control" placeholder="البريد الألكتروني">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="field-3" class="control-label">كلمة السر</label>
                                    <input type="password" autocomplete="nope" value="" name="password" id="password"  class="form-control">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <h3>{{Translate('البيانات الأساسية')}}</h3>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label>{{Translate('الدولة - المدينة')}}</label>
                                    <select name="city_id" class="form-control">
                                        @foreach (App\Models\City::orderBy('title_ar' , 'asc')->get() as $item)
                                            <option value="{{ $item->id }}" {{Auth::user()->city_id == $item->id ? 'selected' : ''}}>{{ $item->country->title_ar }} - {{ $item->title_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label>{{Translate('القسم')}}</label>
                                    <select name="sub_section_id" class="form-control">
                                        @foreach (App\Models\Sub_section::whereHas('section' , function($q){return $q->whereType(Auth::user()->user_type);})->orderBy('section_id' , 'asc')->get() as $item)
                                            <option value="{{ $item->id }}" {{Auth::user()->sub_section_id == $item->id ? 'selected' : ''}}>{{ $item->section->title_ar }} - {{ $item->title_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 check">
                                <div class="form-group">
                                    <label>{{Translate('طريقة الدفع')}}</label>
                                    <select name="payment_method" id="payment_method" class="form-control">
                                        <option value="online" {{Auth::user()->payment_method == 'online' ? 'selected' : ''}}>{{Translate('دفع الكتروني')}}</option>
                                        <option value="cash"   {{Auth::user()->payment_method == 'cash' ? 'selected' : ''}}>{{Translate('في المعمل')}}</option>
                                        <option value="both"   {{Auth::user()->payment_method == 'both' ? 'selected' : ''}}>{{Translate('الطريقتين')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group" style="position: relative;">
                                    <label for="field-2" class="control-label">التخصص</label>
                                    <input type="text" autocomplete="nope" name="specialist" value="{{Auth::user()->specialist}}" id="specialist" required class="form-control" placeholder="التخصص">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 check">
                                <div class="form-group" style="position: relative;">
                                    <label for="field-2" class="control-label">{{Translate('رسوم الحجز')}}</label>
                                    <input type="text" autocomplete="nope" name="total" value="{{Auth::user()->total}}" id="total" required class="form-control phone" placeholder="مدة الانتظار">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group" style="position: relative;">
                                    <label for="field-2" class="control-label">{{Translate('نبذة عنه')}}</label>
                                    <textarea autocomplete="nope" name="desc" id="desc" required class="form-control">{{Auth::user()->desc}}</textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 check">
                                <div class="form-group">
                                    <label>{{Translate('وقت بداية العمل')}}</label>
                                    <input type="time" name="start_time" class="form-control" value="{{Auth::user()->start_time}}" dir="ltr">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 check">
                                <div class="form-group">
                                    <label>{{Translate('وقت نهاية العمل')}}</label>
                                    <input type="time" name="end_time" class="form-control" value="{{Auth::user()->end_time}}" dir="ltr">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <h3>{{Translate('ايام العمل')}}</h3>
                            </div>
                            @foreach (App\Models\Day::get() as $item)
                                <div class="col-xs-4 col-md-3 check">
                                    <div class="form-group">
                                        <input type="checkbox" name="days[]" class="" value="{{$item->id}}" {{check_user_day($item->id) ? 'checked' : ''}}> {{$item->title}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- <input type="hidden" name="edit_lat"> --}}
                    {{-- <input type="hidden" name="edit_lng"> --}}
                    <div class="col-xs-12 col-md-12">
                        <button type="submit" style="width: 100%" class="btn btn-success waves-effect waves-light save" onclick="site_post_profile()">تعديل</button>
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
        function addTypes() {
            event.preventDefault();
            let counter = parseInt($('#counter').val()) + 1;
            $('#counter').val(counter);
            $('.types').append('<div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">عنوان الفحص بالعربية </label><input type="text" autocomplete="nope" name="titles_ar['+counter+']" value="" required class="form-control" placeholder="عنوان الفحص بالعربية "></div></div><div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">عنوان الفحص بالانجليزية </label><input type="text" autocomplete="nope" name="titles_en['+counter+']" value="" required class="form-control" placeholder="عنوان الفحص بالانجليزية "></div></div><div class="col-xs-12 col-md-4"><div class="form-group"><label for="field-1" class="control-label">رسوم الحجز </label><input type="text" autocomplete="nope" name="prices['+counter+']" value="" required class="form-control phone" placeholder="رسوم الحجز"></div></div>');
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
                url         : '{{ route('site_post_hospital_profile') }}' ,
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
