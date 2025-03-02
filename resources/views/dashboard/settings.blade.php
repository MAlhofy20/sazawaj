@extends('dashboard.master')
@section('title') الإعدادات @endsection
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
                                        <a class="nav-link active" id="setting-tab" data-toggle="tab" href="#setting"
                                           role="tab" aria-controls="setting" aria-selected="true">
                                            <img src="{{ dashboard_path() }}/dist/img/presentation.png" alt="">
                                            <span>اعدادت عامة</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                       <a class="nav-link" id="intro-tab" data-toggle="tab" href="#intro" role="tab"
                                           aria-controls="intro" aria-selected="true">
                                           <img src="{{ dashboard_path() }}/dist/img/presentation.png" alt="">
                                           <span>اكواد جوجل</span>
                                       </a>
                                   </li>
                                    {{--<li class="nav-item">
                                        <a class="nav-link" id="social-tab" data-toggle="tab" href="#social"
                                           role="tab" aria-controls="social" aria-selected="false">
                                            <img src="{{ dashboard_path() }}/dist/img/meeting.png" alt="">
                                            <span>مواقع التواصل</span>
                                        </a>
                                    </li>--}}
                                    <li class="nav-item">
                                        <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab"
                                           aria-controls="seo" aria-selected="true">
                                            <img src="{{ dashboard_path() }}/dist/img/headphone.png" alt="">
                                            <span>اعدادات البحث</span>
                                        </a>
                                    </li>
                                    {{--<li class="nav-item">
                                        <a class="nav-link" id="location-tab" data-toggle="tab" href="#location" role="tab"
                                            aria-controls="location" aria-selected="false">
                                            <img src="{{dashboard_path()}}/dist/img/map-placeholder.png" alt="">
                                            <span>{{Translate('اعدادات الخريطة')}}</span>
                                        </a>
                                    </li>--}}
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
                                    <div class="tab-pane fade show active" id="setting" role="tabpanel"
                                         aria-labelledby="setting-tab">
                                        <form action="{{ route('updatesetting') }}" method="post" id="updatesettingForm"
                                              class="dropzone" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail2">اسم الموقع</label>
                                                    <input type="text" name="keys[site_name]"
                                                           value="{{ settings('site_name') }}" class="form-control"
                                                           id="exampleInputEmail2" placeholder="">
                                                </div>
                                                {{--<div class="form-group">
                                                    <label
                                                            for="exampleInputEmail2">الجوال</label>
                                                    <input type="tel" name="keys[phone]" value="{{ settings('phone') }}"
                                                           class="form-control phone" id="exampleInputEmail2" placeholder="">
                                                </div>--}}
                                                {{--<div class="form-group">
                                                    <label
                                                            for="exampleInputEmail2">الهاتف</label>
                                                    <input type="tel" name="keys[telephone]" value="{{ settings('telephone') }}"
                                                           class="form-control phone" id="exampleInputEmail2" placeholder="">
                                                </div>--}}
                                                {{--<div class="form-group">
                                                    <label
                                                            for="exampleInputEmail2">السجل التجاري</label>
                                                    <input type="tel" name="keys[commercial_register]" value="{{ settings('commercial_register') }}"
                                                           class="form-control phone" id="exampleInputEmail2" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                            for="exampleInputEmail2">الرقم الضريبي</label>
                                                    <input type="tel" name="keys[tax_number]" value="{{ settings('tax_number') }}"
                                                           class="form-control phone" id="exampleInputEmail2" placeholder="">
                                                </div>--}}
                                                {{-- <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail2">الواتس اب</label>
                                                    <input type="tel" name="keys[whatsapp]" value="{{ settings('whatsapp') }}"
                                                        class="form-control phone" id="exampleInputEmail2" placeholder="">
                                                </div> --}}
                                                <div class="form-group">
                                                    <label
                                                            for="exampleInputEmail2">البريد الالكتروني</label>
                                                    <input type="email" name="keys[email]"
                                                           value="{{ settings('email') }}" class="form-control"
                                                           id="exampleInputEmail2" placeholder="">
                                                </div>
                                                {{--<div class="form-group">
                                                    <label
                                                            for="exampleInputEmail1">رابط فيديو الرئيسية</label>
                                                    <input type="url" name="keys[home_video]"
                                                           value="{{ settings('home_video') }}" class="form-control"
                                                           id="exampleInputEmail1" placeholder="">
                                                </div>--}}

                                                {{--<div class="form-group">
                                                    <label>الحد الاقصى لنسبة الخصم</label>
                                                    <div class="input-group">
                                                        <input type="number" name="keys[discount_percent_max]"
                                                               value="{{ settings('discount_percent_max') }}"
                                                               class="form-control">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="fa fa-percent"></i></span>
                                                        </div>
                                                    </div>
                                                </div>--}}

                                                {{--<div class="form-group">
                                                    <label for="exampleInputEmail2">العنوان بالعربية</label>
                                                    <input type="text" name="keys[address_ar]"
                                                        value="{{ settings('address_ar') }}" class="form-control"
                                                        id="exampleInputEmail2" placeholder="">
                                                </div>--}}
                                                {{--<div class="form-group">
                                                    <label for="exampleInputEmail2">العنوان بالانجليزية</label>
                                                    <input type="text" name="keys[address_en]"
                                                        value="{{ settings('address_en') }}" class="form-control"
                                                        id="exampleInputEmail2" placeholder="">
                                                </div>--}}

                                                 <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail5">الوصف في الرئيسية اعلى اعضاء جدد</label>
                                                    <textarea name="keys[new_users_desc]" class="form-control"
                                                        id="exampleInputEmail5" rows="5">{{ settings('new_users_desc') }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail5">الوصف في اسفل الرئيسية</label>
                                                    <textarea name="keys[home_footer_desc]" class="form-control"
                                                        id="exampleInputEmail5" rows="5">{{ settings('home_footer_desc') }}</textarea>
                                                </div>

                                                {{-- <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail2">وقت بداية العمل</label>
                                                    <input type="time" dir="ltr" name="keys[start_time]" value="{{ settings('start_time') }}"
                                                        class="form-control" id="exampleInputEmail2" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail2">وقت نهاية العمل</label>
                                                    <input type="time" dir="ltr" name="keys[end_time]" value="{{ settings('end_time') }}"
                                                        class="form-control" id="exampleInputEmail2" placeholder="">
                                                </div> --}}
                                                {{-- <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail5">الخريطة بالرئيسية</label>
                                                    <textarea dir="ltr" name="keys[location]" class="form-control"
                                                        id="exampleInputEmail5" rows="6">{{ settings('location') }}</textarea>
                                                </div> --}}
                                                <div class="form-group">
                                                    <label
                                                            for="input-file-now-custom-1">لوجو الموقع</label>
                                                    <input type="file" name="logo" id="input-file-now-custom-1"
                                                           class="dropify"
                                                           data-default-file="{{ url('' . settings('logo')) }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="input-file-now-custom-1">اللوجو اسفل الموقع</label>
                                                    <input type="file" name="logo_footer" id="input-file-now-custom-1"
                                                        class="dropify"
                                                        data-default-file="{{ url('' . settings('logo_footer')) }}" />
                                                </div>
                                                {{--<div class="form-group">
                                                    <label
                                                        for="input-file-now-custom-1">صورة البحث</label>
                                                    <input type="file" name="search_photo" id="input-file-now-custom-1"
                                                        class="dropify"
                                                        data-default-file="{{ url('' . settings('search_photo')) }}" />
                                                </div>--}}
                                                {{--<div class="form-group">
                                                    <label
                                                        for="input-file-now-custom-1">صورة التواصل والاستفسار</label>
                                                    <input type="file" name="contact_photo" id="input-file-now-custom-1"
                                                        class="dropify"
                                                        data-default-file="{{ url('' . settings('contact_photo')) }}" />
                                                </div>--}}
                                                <div class="form-group">
                                                    <label
                                                        for="input-file-now-custom-1">صورة من نحن</label>
                                                    <input type="file" name="about_photo" id="input-file-now-custom-1"
                                                        class="dropify"
                                                        data-default-file="{{ url('' . settings('about_photo')) }}" />
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label
                                                        for="input-file-now-custom-1">لوجو الخريطة</label>
                                                    <input type="file" name="logo_map" id="input-file-now-custom-1"
                                                        class="dropify"
                                                        data-default-file="{{ url('' . settings('logo_map')) }}" />
                                                </div> --}}
                                                {{-- <hr> --}}
                                                {{-- <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail5">النص المرسل عبر البريد الالكتروني</label>
                                                    <textarea name="keys[email_desc]" class="form-control"
                                                        id="exampleInputEmail5">{{ settings('email_desc') }}</textarea>
                                                </div> --}}
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" onclick="" class="btn btn-success save"
                                                        style="width:100%">حفظ</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade show" id="intro" role="tabpanel" aria-labelledby="intro-tab">
                                        <form action="{{ route('updateintro') }}" method="post" id="updateintroForm"
                                              class="dropzone" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label
                                                            for="exampleInputEmail5">جوجل سيرش كونسل</label>
                                                    <textarea name="keys[google_search]" class="form-control"
                                                              id="exampleInputEmail5">{{ settings('google_search') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                            for="exampleInputEmail5">جوجل اناليتكس</label>
                                                    <textarea name="keys[google_statics]" class="form-control"
                                                              id="exampleInputEmail5">{{ settings('google_statics') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                            for="exampleInputEmail5">جوجل تاج مانجر</label>
                                                    <textarea name="keys[google_tags]" class="form-control"
                                                              id="exampleInputEmail5">{{ settings('google_tags') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                            for="exampleInputEmail5">جوجل ادسنس</label>
                                                    <textarea name="keys[google_ads]" class="form-control"
                                                              id="exampleInputEmail5">{{ settings('google_ads') }}</textarea>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail3">عنوان المقدمة الاولى بالعربية</label>
                                                    <input type="text" name="keys[first_intro_title_ar]"
                                                        value="{{ settings('first_intro_title_ar') }}"
                                                        class="form-control" id="exampleInputEmail3" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail4">عنوان المقدمة الاولى بالإنجليزية</label>
                                                    <input type="text" name="keys[first_intro_title_en]"
                                                        value="{{ settings('first_intro_title_en') }}"
                                                        class="form-control" id="exampleInputEmail4" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail5">تفاصيل المقدمة الاولى بالعربية</label>
                                                    <textarea name="keys[first_intro_desc_ar]" class="form-control"
                                                        id="exampleInputEmail5">{{ settings('first_intro_desc_ar') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail6">تفاصيل المقدمة الاولى بالإنجليزية</label>
                                                    <textarea name="keys[first_intro_desc_en]" class="form-control"
                                                        id="exampleInputEmail6">{{ settings('first_intro_desc_en') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="input-file-now-custom-1">ايقونة المقدمة الاولى</label>
                                                    <input type="file" name="first_intro_icon" id="input-file-now-custom-1"
                                                        class="dropify"
                                                        data-default-file="{{ url('' . settings('first_intro_icon')) }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="input-file-now-custom-1">صورة المقدمة الاولى</label>
                                                    <input type="file" name="first_intro_image" id="input-file-now-custom-1"
                                                        class="dropify"
                                                        data-default-file="{{ url('' . settings('first_intro_image')) }}" />
                                                </div> --}}
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" onclick="updateintro()" class="btn btn-success save"
                                                        style="width:100%">حفظ</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                                        <form action="{{ route('updatesocial') }}" id="updatesocialForm" method="POST"
                                              class="dropzone">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>واتس اب</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fab fa-whatsapp"></i>
                                                            </span>
                                                        </div>
                                                        <input type="tel" name="keys[whatsapp]"
                                                               value="{{ settings('whatsapp') }}" class="form-control phone">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                 <div class="form-group">
                                                    <label>فيسبوك</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fab fa-facebook-f"></i>
                                                            </span>
                                                        </div>
                                                        <input type="url" name="keys[facebook]"
                                                            value="{{ settings('facebook') }}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <div class="form-group">
                                                    <label>تويتر</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fab fa-twitter"></i>
                                                            </span>
                                                        </div>
                                                        <input type="url" name="keys[twitter]"
                                                               value="{{ settings('twitter') }}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <div class="form-group">
                                                    <label>انستجرام</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fab fa-instagram"></i>
                                                            </span>
                                                        </div>
                                                        <input type="url" name="keys[instagram]"
                                                               value="{{ settings('instagram') }}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                 <div class="form-group">
                                                    <label>سناب شات</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fab fa-snapchat"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" name="keys[snapchat]"
                                                            value="{{ settings('snapchat') }}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label>يوتيوب</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fab fa-youtube"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" name="keys[youtube]"
                                                            value="{{ settings('youtube') }}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div> --}}
                                                {{-- <div class="form-group">
                                                    <label>لينكد ان</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="fab fa-linkedin"></i></span>
                                                        </div>
                                                        <input type="text" name="keys[linkedin]"
                                                            value="{{ settings('linkedin') }}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div> --}}
                                                {{-- <div class="form-group">
                                                    <label>معروف</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="fab fa-wpforms"></i></span>
                                                        </div>
                                                        <input type="text" name="keys[maroof]"
                                                            value="{{ settings('maroof') }}" class="form-control">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div> --}}
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" onclick="updatesocial()" class="btn btn-success save"
                                                        style="width:100%">حفظ</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade show" id="location" role="tabpanel"
                                         aria-labelledby="location-tab">
                                        <form action="{{ route('updatelocation') }}" id="updatelocationForm"
                                              method="POST" class="dropzone">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group" style="position: relative;">
                                                    <input class="controls" id="edit_pac-input" name="pac-input" value=""
                                                           placeholder="اكتب موقعك" />
                                                    <input type="hidden" name="keys[lat]" id="edit_lat"
                                                           value="{{ settings('lat') }}" readonly />
                                                    <input type="hidden" name="keys[lng]" id="edit_lng"
                                                           value="{{ settings('lng') }}" readonly />
                                                    <div class="col-sm-12" id="edit_add_map"></div>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" onclick="updatelocation()"
                                                        class="btn btn-success save"
                                                        style="width:100%">حفظ</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                        <form action="{{ route('updateseo') }}" id="updateseoForm" method="POST"
                                              class="dropzone">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group pad">
                                                    <label>الوصف</label>
                                                    <textarea class="form-control" name="keys[description]"
                                                              placeholder="" rows="5">{{ settings('description') }}</textarea>
                                                </div>

                                                <div class="form-group pad">
                                                    <label>الكلمات المفتاحية</label>
                                                    <textarea class="form-control" name="keys[key_words]" placeholder=""
                                                              rows="5">{{ settings('key_words') }}</textarea>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" onclick="updateseo()" class="btn btn-success save"
                                                        style="width:100%">حفظ</button>
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
        function updatesetting() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('updatesetting') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updatesettingForm")[0]),
                success: function(msg) {
                    if (msg.value == '0') {
                        stop_loader();
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    } else {
                        window.location.reload();
                    }
                }
            });
        }

        function updateintro() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('updateintro') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updateintroForm")[0]),
                success: function(msg) {
                    if (msg.value == '0') {
                        stop_loader();
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    } else {
                        window.location.reload();
                    }
                }
            });
        }

        function updatesocial() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('updatesocial') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updatesocialForm")[0]),
                success: function(msg) {
                    stop_loader();
                    if (msg.value == '0') {
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    } else {
                        $.notify(msg.msg, 'success');
                    }
                }
            });
        }

        function updatelocation() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('updatelocation') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updatelocationForm")[0]),
                success: function(msg) {
                    stop_loader();
                    if (msg.value == '0') {
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    } else {
                        $.notify(msg.msg, 'success');
                    }
                }
            });
        }

        function updateseo() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('updateseo') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updateseoForm")[0]),
                success: function(msg) {
                    stop_loader();
                    if (msg.value == '0') {
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    } else {
                        $.notify(msg.msg, 'success');
                    }
                }
            });
        }

        CKEDITOR.replace('keys[email_desc]');
    </script>
@endsection
