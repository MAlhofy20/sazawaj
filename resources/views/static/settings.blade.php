@extends('site.master')
@section('title') {{Translate('الإعدادات')}} @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
      <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12">
                    <!-- Default box -->
                    <div class="card card card-outline card-info">
                        <div class="card-body p-0">
                            <div class="set-tabs">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="setting-tab" data-toggle="tab" href="#setting" role="tab"
                                            aria-controls="setting" aria-selected="true">
                                            <img src="{{dashboard_path()}}/dist/img/presentation.png" alt="">
                                            <span>{{Translate('اعدادت الموقع')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab"
                                            aria-controls="social" aria-selected="false">
                                            <img src="{{dashboard_path()}}/dist/img/meeting.png" alt="">
                                            <span>{{Translate('مواقع التواصل')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="location-tab" data-toggle="tab" href="#location" role="tab"
                                            aria-controls="location" aria-selected="false">
                                            <img src="{{dashboard_path()}}/dist/img/map-placeholder.png" alt="">
                                            <span>{{Translate('اعدادات الخريطة')}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab"
                                            aria-controls="seo" aria-selected="true">
                                            <img src="{{dashboard_path()}}/dist/img/presentation.png" alt="">
                                            <span>{{Translate('اعدادات البحث')}}</span>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" id="profile5-tab" data-toggle="tab" href="#profile5" role="tab"
                                            aria-controls="profile5" aria-selected="false">
                                            <img src="{{dashboard_path()}}/dist/img/headphone.png" alt="">
                                            <span>اعدادات الدعم </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact6-tab" data-toggle="tab" href="#contact6" role="tab"
                                            aria-controls="contact6" aria-selected="false">
                                            <img src="{{dashboard_path()}}/dist/img/wallet.png" alt="">
                                            <span>اعدادات الدفع </span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-8 col-12">
                    <!-- Default box -->
                    <div class="card card card-outline card-info">
                        <div class="card-body p-0">
                            <div class="set-tabsContent">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                                        <form action="{{route('updatesetting')}}" method="post" id="updatesettingForm" class="dropzone">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail2">{{Translate('اسم الموقع بالعربية')}}</label>
                                                    <input type="text" name="keys[site_name]" value="{{settings('site_name')}}" class="form-control" id="exampleInputEmail2"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail2">{{Translate('اسم الموقع بالانجليزية')}}</label>
                                                    <input type="text" name="keys[site_name_en]" value="{{settings('site_name_en')}}" class="form-control" id="exampleInputEmail2"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail2">{{Translate('العنوان بالعربية')}}</label>
                                                    <input type="text" name="keys[address_ar]" value="{{settings('address_ar')}}" class="form-control" id="exampleInputEmail2"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail2">{{Translate('العنوان بالإنجليزية')}}</label>
                                                    <input type="text" name="keys[address_en]" value="{{settings('address_en')}}" class="form-control" id="exampleInputEmail2"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{Translate('رقم الجوال')}}</label>
                                                    <input type="tel" name="keys[phone]" value="{{settings('phone')}}" class="form-control phone" id="exampleInputEmail1"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{Translate('البريد الإلكتروني')}}</label>
                                                    <input type="email" name="keys[email]" value="{{settings('email')}}" class="form-control" id="exampleInputEmail1"
                                                        placeholder="">
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label for="exampleInputEmail1">{{Translate('فيديو الرئيسية')}}</label>
                                                    <input type="url" name="keys[home_video]" value="{{settings('home_video')}}" class="form-control" id="exampleInputEmail1"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{Translate('سعر اشتراك اظهار بيانات المدربة')}}</label>
                                                    <div class="input-group">
                                                        <input type="number" min="0" name="keys[coach_amount]" value="{{settings('coach_amount')}}" class="form-control">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{Translate('ريال')}}</span>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="form-group">
                                                    <label for="input-file-now-custom-1">{{Translate('لوجو الموقع')}}</label>
                                                    <input type="file" name="logo" id="input-file-now-custom-1" class="dropify"
                                                        data-default-file="{{url('' . settings('logo'))}}" />
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" onclick="updatesetting()" class="btn btn-success save" style="width:100%">{{Translate('حفظ')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade show" id="intro" role="tabpanel" aria-labelledby="intro-tab">
                                        <form action="{{route('updateintro')}}" method="post" id="updateintroForm" class="dropzone" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail3">{{Translate('عنوان المقدمة الاولى بالعربية')}}</label>
                                                    <input type="text" name="keys[first_intro_title_ar]" value="{{settings('first_intro_title_ar')}}" class="form-control" id="exampleInputEmail3"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail4">{{Translate('عنوان المقدمة الاولى بالإنجليزية')}}</label>
                                                    <input type="text" name="keys[first_intro_title_en]" value="{{settings('first_intro_title_en')}}" class="form-control" id="exampleInputEmail4"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail5">{{Translate('تفاصيل المقدمة الاولى بالعربية')}}</label>
                                                    <textarea name="keys[first_intro_desc_ar]" class="form-control" id="exampleInputEmail5">{{settings('first_intro_desc_ar')}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail6">{{Translate('تفاصيل المقدمة الاولى بالإنجليزية')}}</label>
                                                    <textarea name="keys[first_intro_desc_en]" class="form-control" id="exampleInputEmail6">{{settings('first_intro_desc_en')}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input-file-now-custom-1">{{Translate('صورة المقدمة الاولى')}}</label>
                                                    <input type="file" name="first_intro_image" id="input-file-now-custom-1" class="dropify"
                                                        data-default-file="{{url('' . settings('first_intro_image'))}}" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail3">{{Translate('عنوان المقدمة الثانية بالعربية')}}</label>
                                                    <input type="text" name="keys[second_intro_title_ar]" value="{{settings('second_intro_title_ar')}}" class="form-control" id="exampleInputEmail3"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail4">{{Translate('عنوان المقدمة الثانية بالإنجليزية')}}</label>
                                                    <input type="text" name="keys[second_intro_title_en]" value="{{settings('second_intro_title_en')}}" class="form-control" id="exampleInputEmail4"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail5">{{Translate('تفاصيل المقدمة الثانية بالعربية')}}</label>
                                                    <textarea name="keys[second_intro_desc_ar]" class="form-control" id="exampleInputEmail5">{{settings('second_intro_desc_ar')}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail6">{{Translate('تفاصيل المقدمة الثانية بالإنجليزية')}}</label>
                                                    <textarea name="keys[second_intro_desc_en]" class="form-control" id="exampleInputEmail6">{{settings('second_intro_desc_en')}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input-file-now-custom-1">{{Translate('صورة المقدمة الثانية')}}</label>
                                                    <input type="file" name="second_intro_image" id="input-file-now-custom-1" class="dropify"
                                                        data-default-file="{{url('' . settings('second_intro_image'))}}" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail3">{{Translate('عنوان المقدمة الثالثة بالعربية')}}</label>
                                                    <input type="text" name="keys[third_intro_title_ar]" value="{{settings('third_intro_title_ar')}}" class="form-control" id="exampleInputEmail3"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail4">{{Translate('عنوان المقدمة الثالثة بالإنجليزية')}}</label>
                                                    <input type="text" name="keys[third_intro_title_en]" value="{{settings('third_intro_title_en')}}" class="form-control" id="exampleInputEmail4"
                                                        placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail5">{{Translate('تفاصيل المقدمة الثالثة بالعربية')}}</label>
                                                    <textarea name="keys[third_intro_desc_ar]" class="form-control" id="exampleInputEmail5">{{settings('third_intro_desc_ar')}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail6">{{Translate('تفاصيل المقدمة الثالثة بالإنجليزية')}}</label>
                                                    <textarea name="keys[third_intro_desc_en]" class="form-control" id="exampleInputEmail6">{{settings('third_intro_desc_en')}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input-file-now-custom-1">{{Translate('صورة المقدمة الثالثة')}}</label>
                                                    <input type="file" name="third_intro_image" id="input-file-now-custom-1" class="dropify"
                                                        data-default-file="{{url('' . settings('third_intro_image'))}}" />
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" onclick="updateintro()" class="btn btn-success save" style="width:100%">{{Translate('حفظ')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                                        <form action="{{route('updatesocial')}}" id="updatesocialForm" method="POST" class="dropzone">
                                            @csrf
                                            <div class="card-body">
                                                {{-- <div class="form-group">
                                                    <label>{{Translate('واتس اب')}}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                                        </div>
                                                        <input type="url" name="keys[whatsapp]" value="{{settings('whatsapp')}}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div> --}}
                                                <div class="form-group">
                                                    <label>{{Translate('فيسبوك')}}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                                                        </div>
                                                        <input type="url" name="keys[facebook]" value="{{settings('facebook')}}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <div class="form-group">
                                                    <label>{{Translate('تويتر')}}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                                        </div>
                                                        <input type="url" name="keys[twitter]" value="{{settings('twitter')}}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <div class="form-group">
                                                    <label>{{Translate('انستجرام')}}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                                        </div>
                                                        <input type="url" name="keys[instagram]" value="{{settings('instagram')}}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <div class="form-group">
                                                    <label>{{Translate('بنتراست')}}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fab fa-pinterest-p"></i></span>
                                                        </div>
                                                        <input type="text" name="keys[pinterest]" value="{{settings('pinterest')}}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <div class="form-group">
                                                    <label>{{Translate('سناب شات')}}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fab fa-snapchat"></i></span>
                                                        </div>
                                                        <input type="text" name="keys[snapchat]" value="{{settings('snapchat')}}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" onclick="updatesocial()" class="btn btn-success save" style="width:100%">{{Translate('حفظ')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade show" id="location" role="tabpanel" aria-labelledby="location-tab">
                                        <form action="{{route('updatelocation')}}" id="updatelocationForm" method="POST" class="dropzone">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group" style="position: relative;">
                                                    <input class="controls" id="pac-input" name="pac-input" value="" placeholder="{{Translate('اكتب موقعك')}}"/>
                                                    <input type="hidden" name="keys[lat]" id="lat" value="{{settings('lat')}}" readonly />
                                                    <input type="hidden" name="keys[lng]" id="lng" value="{{settings('lng')}}" readonly />
                                                    <div class="col-sm-12" id="add_map"></div>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" onclick="updatelocation()" class="btn btn-success save" style="width:100%">{{Translate('حفظ')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                        <form action="{{route('updateseo')}}" id="updateseoForm" method="POST" class="dropzone">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group pad">
                                                    <label>{{Translate('الوصف')}}</label>
                                                    <textarea class="form-control" name="keys[description]" placeholder="" rows="4">{{settings('description')}}</textarea>
                                                </div>

                                                <div class="form-group pad">
                                                    <label>{{Translate('الكلمات المفتاحية')}}</label>
                                                    <textarea class="form-control" name="keys[key_words]" placeholder="" rows="4">{{settings('key_words')}}</textarea>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" onclick="updateseo()" class="btn btn-success save" style="width:100%">{{Translate('حفظ')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </section>
      <!-- /.content -->
@endsection

@section('modal')
@endsection

@section('script')
    <script>
        function updatesetting(){
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('updatesetting') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updatesettingForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        window.location.reload();
                    }
                }
            });
        }

        function updateintro(){
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('updateintro') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updateintroForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        window.location.reload();
                    }
                }
            });
        }

        function updatesocial(){
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('updatesocial') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updatesocialForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        $.notify(msg.msg, 'success');
                    }
                }
            });
        }

        function updatelocation(){
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('updatelocation') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updatelocationForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        $.notify(msg.msg, 'success');
                    }
                }
            });
        }

        function updateseo(){
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('updateseo') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updateseoForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        $.notify(msg.msg, 'success');
                    }
                }
            });
        }
    </script>
@endsection
