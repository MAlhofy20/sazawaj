@extends('site.master')
@section('title')
    تسجيل جديد
@endsection
@section('meta')
    @include('meta::manager', [
        'title' => settings('site_name')  . ' - تسجيل جديد',
        'description' => settings('description'),
        'image' => url('' . settings('logo')),
        'keywords' => settings('key_words')
    ])
@endsection

@section('style')
    <style>
        .hint-label {
            position: relative;
            font-size: 15px;
            margin-top: -20px;
            margin-bottom: 20px;
            color: rgb(123, 10, 10);
            margin-right: 50px;
            font-weight: 500;
            display: flex;

            justify-content: center;
            align-content: center;
            flex-wrap: nowrap;
            flex-direction: row;
        }

        @media (max-width:480px) {
            .hint-label {
                margin-top: -20px;
            }
        }


        @media only screen and (min-width: 768px) {
            .hint-label {
                margin-top: -20px;
            }

        }

        .errorDiv {
            color: white !important;
            background-color: #d94552;
            font-size: 15px;
            font-weight: bold;
            border-color: #df3648;
            display: block;
            margin-top: 15px;
            text-align: -webkit-auto;
            width: 750px;
            margin-left: 20%;
        }

        .flex-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-content: center;
        }

        .form-group {
            padding: 5px;
            width: 100%;
        }

        /* Responsive layout - makes a one column layout instead of a two-column layout */
        @media (max-width: 1150px) {
            .flex-container {
                flex-direction: column;
            }
        }
    </style>

    <style>
        .registration-form {
            background-color: #f9f4e7;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .gender-selection {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .gender-selection label {
            cursor: pointer;
            font-weight: bold;
            color: #6b3f9e;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #6b3f9e;
        }

        .btn-primary:hover {
            background-color: #532f7e;
        }

        .registration-step {
            display: none;
        }

        .registration-step.active {
            display: block;
        }

        .errorDiv {
            color: white;
            background-color: #d94552;
            font-size: 15px;
            font-weight: bold;
            border-color: #df3648;
            display: block;
            margin-top: 15px;
            text-align: -webkit-auto;
            width: 750px;
            margin-left: 20%;
        }

        label {
            display: block;
            font-weight: bold;
        }

        .gender-selection label img {
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            object-fit: initial;
        }

        input[type="checkbox"] {
            width: 20px;
            /* حجم المربع */
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
            /* تغيير لون الـ checkbox */
            border-radius: 4px;
            /* إضافة حواف دائرية */
            border: 2px solid #ccc;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* تأثير عند التمرير */
        input[type="checkbox"]:hover {
            transform: scale(1.1);
            /* تكبير عند التمرير */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            /* إضافة ظل */
        }

        /* إضافة تنسيق عند التحديد */
        input[type="checkbox"]:checked {
            accent-color: #b72dd2;
            /* لون مخصص عند التحديد */
            border-color: #b72dd2;
            /* تغيير لون الإطار */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            border: 2px solid #e6e6e6;
            background-color: #fff;
            background-repeat: no-repeat;
            border-radius: 5px;
            transition: border-color .3s ease-in-out;
            height: 50px !important;
            padding: 5px 10px;
        }

        input:hover[type="text"],
        input:hover[type="email"],
        input:hover[type="password"],
        select:hover {
            border-color: #b72dd2 !important;
            transition: all .35s ease-in-out;
        }


        .checkbox-group label {

            align-items: center;
            /* محاذاة العناصر في المنتصف */
            /* إضافة مسافة بين كل label */
        }

        .checkbox-group input[type="checkbox"] {
            margin-left: 5px;
            /* إضافة مسافة بين الـ checkbox والنص */
            display: inline-block;
            width: auto !important;
        }

        .gender-selection input[type="radio"] {
            display: inline-block;
            width: auto !important;

        }

        button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(hsl(100, 95%, 40%) 50%, hsl(100, 80%, 40%) 50%);
            background-color: #46c705;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: var(--sec);
        }

        small {
            display: block;
            margin: 5px 0;
            color: #666;
        }

        .gender-selection {
            display: flex;
        }

        .gender-selection label {
            margin-inline-end: 50px;
        }

        .step textarea {
            width: 100%;
            border: 2px solid #e6e6e6;
            background-color: #fff;
            background-repeat: no-repeat;
            border-radius: 5px;
            transition: border-color .3s ease-in-out;
            height: 250px;
            padding: 5px 10px;
        }

        .step textarea:hover {
            border: 2px solid #b72dd2;
        }

        #multiStepForm input,
        #multiStepForm textarea {
            width: 100%;
            border: 1px solid var(--sec);

        }

        #multiStepForm select {
            border: 1px solid var(--sec);

        }
    </style>

    <style>
        .steps-container {
            display: flex;
            justify-content: space-evenly;
            margin-bottom: 50px;


        }

        .step-number {

            cursor: pointer;
            border: 1px solid var(--main);
            background: white;
            margin: 0 5px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            line-height: 100px;
            text-align: center;
            font-size: 48px;
            transition: background-color 0.3s;
        }

        .step-number.completed {
            background-color: var(--main);
            color: white;
            cursor: default;
        }

        .step-number.active {
            background-color: var(--main);
            color: white;
        }

        .step {
            display: none;
        }

        .active-step {
            display: block;
        }
    </style>

    <style>
        .gender-label {
            display: inline-block;
            cursor: pointer;
            margin-right: 20px;
            text-align: center;
        }

        .gender-label img {
            width: 50px;
            height: 50px;
            transition: opacity 0.3s;
        }

        .gender-label input[type="radio"] {
            display: none;
        }

        /* عند تحميل الصفحة، عرض الصور المختارة فقط */
        .gender-label input[type="radio"]:not(:checked)~.unselected {
            display: none;
        }

        .gender-label input[type="radio"]:checked~.unselected {
            display: block;
        }

        /* عند عدم تحديد الخيار، عرض الصور الغير مختارة */
        .gender-label input[type="radio"]:not(:checked)~. selected {
            display: block;
        }

        .gender-label input[type="radio"]:checked~.selected {
            display: none;
        }

        .gender-label span {
            display: block;
        }
    </style>
@endsection

@section('content')
    <!--  welcome  -->
    <section class="welcome">
        <div class="welcome-img">
            <img src="{{ site_path() }}/assets/img/welcome.png" alt="">
        </div>
        <p class="welcome-tit"> هلا بك في مجتمع <span class='text-center' style="color:#2492a8"> {{ settings('site_name') }}
            </span></p>
    </section>
    <!--  //welcome  -->

    @if ($errors->any())
        <div class="alert alert-danger errorDiv">
            <span onclick="this.parentElement.style.display='none'"
                class="w3-button w3-green w3-large w3-display-topright">&times;</span>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="margin-right: 15px">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="register">
        <div class="container">
            {{-- <div class="sec-tit inside text-center">
                اشترك الآن
            </div> --}}
            <div class="steps-container">
                <div class="step-number {{ !isset($step) || ($step != '2' && $step != '3') ? 'active' : '' }}"
                    {{-- onclick="goToStepPage(1)" --}} {{-- onclick="goToStep(0)" --}}>1</div>
                <div class="step-number {{ $step == '2' ? 'active' : '' }}"
                    @if (isset($user)) {{-- onclick="goToStepPage(2)" --}} @endif {{-- onclick="goToStep(2)" --}}>2</div>
                <div class="step-number {{ $step == '3' ? 'active' : '' }}"
                    @if (isset($user)) {{-- onclick="goToStepPage(3)" --}} @endif {{-- onclick="goToStep(3)" --}}>3</div>
            </div>
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-7">


                    <input type="hidden" id="userIdVal" value="{{ isset($user) ? $user->id : '0' }}">

                    <!-- الخطوة 1 -->
                    {{-- <form id="formStep1" class="step active-step" onsubmit="return nextStep(event)">
                        <h2>الخطوة 1</h2>
                        <label>اسمك:</label>
                        <input type="text" name="name" required>
                        <button type="submit">التالي</button>
                    </form> --}}

                    <!-- الخطوة 2 -->
                    {{-- <form id="formStep2" class="step" onsubmit="return nextStep(event)">
                        <h2>الخطوة 2</h2>
                        <label>البريد الإلكتروني:</label>
                        <input type="email" name="email" required>
                        <button type="button" onclick="goToStepPage(1)" --}}{{-- onclick="prevStep()" --}}{{-- >رجوع</button>
                        <button type="submit">التالي</button>
                    </form> --}}

                    <!-- الخطوة 3 -->
                    {{-- <form id="formStep3" class="step" onsubmit="return submitAllForms(event)">
                        <h2>الخطوة 3</h2>
                        <label>رسالتك:</label>
                        <textarea name="message" required></textarea>
                        <button type="button" onclick="prevStep()">رجوع</button>
                        <button type="submit">إرسال</button>
                    </form> --}}


                    <div class="steps-forms-reg">
                        <div class="main-tit head-tit">
                            التسجيل
                        </div>
                        @if (!isset($step) || ($step != '2' && $step != '3'))
                            <form id="formStep1" class="step active-step"
                                action="{{ route('site_post_register') }}?step=1&user={{ isset($user) ? $user->id : '0' }}"
                                method="post" enctype="multipart/form-data">

                                @csrf

                                <input type="hidden" name="step" id="step" value="1">
                                <input type="hidden" name="device_id" id="device_id">
                                <input type="hidden" name="id" id="user_id"
                                    value="{{ isset($user) ? $user->id : '0' }}">
                                <div class="gender-selection">

                                    <label class="gender-label">
                                        <input type="radio" name="gender" value="male" id="male" required>
                                        <img src="{{ site_path() }}/assets/img/male-selected.png" alt="ذكر"
                                            class="selected" id="male-selected">
                                        <img src="{{ site_path() }}/assets/img/male-unselected.png" alt="ذكر"
                                            class="unselected" id="male-unselected">
                                        <span>ذكر</span>
                                    </label>

                                    <label class="gender-label">
                                        <input type="radio" name="gender" value="female" id="female" required>
                                        <img src="{{ site_path() }}/assets/img/female-selected.png" alt="أنثى"
                                            class="selected" id="female-selected">
                                        <img src="{{ site_path() }}/assets/img/female-unselected.png" alt="أنثى"
                                            class="unselected" id="female-unselected">
                                        <span>أنثى</span>
                                    </label>

                                </div>
                                <small id="genderError"
                                    style="color:red; display:none;font-size: larger;width: 100%;text-align: center">يرجى
                                    اختيار الجنس</small>

                                <!-- الاسم -->
                                <div class="labelform-content">
                                    <label class="labelform">الاسم</label>
                                    <input class="input-field" type="text" name="first_name" placeholder="أدخل اسمك"
                                        value="{{ isset($user) ? $user->first_name : old('first_name') }}" required
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                </div>
                                <p class="hint-label mb-4 text-center">هذا الاسم هو الذي يظهر للجميع في الموقع</p>

                                <div class="labelform-content">
                                    <!-- الهدف من الموقع -->
                                    <label class="labelform">الهدف من الموقع</label>
                                    <div class="checkbox-group input-field" id="goalsGroup">
                                        @foreach (App\Models\Media_file::where('type', 'goals')->orderBy('title_ar')->get() as $item)
                                            <label>
                                                <input type="checkbox" name="goals[]" value="{{ $item->title }}"
                                                    {{ isset($user) && in_array($item->title_ar, explode(',', $user->goals)) ? 'checked' : '' }}>{{ $item->title }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <small id="goalsError"
                                    style="color:red; display:none;font-size: larger;width: 100%;text-align: center">يرجى
                                    اختيار هدف واحد على الأقل</small>


                                <div class="labelform-content">
                                    <!-- العمر والطول -->
                                    <label class="labelform">العمر</label>
                                    <select class="form-control" name="age" required
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                        <option value="">اختار</option>
                                        <option value="22 - 18"
                                            {{ isset($user) && $user->age == '22 - 18' ? 'selected' : '' }}>
                                            22 - 18
                                        </option>
                                        <option value="27 - 23"
                                            {{ isset($user) && $user->age == '27 - 23' ? 'selected' : '' }}>
                                            27 - 23
                                        </option>
                                        <option value="32 - 28"
                                            {{ isset($user) && $user->age == '32 - 28' ? 'selected' : '' }}>
                                            32 - 28
                                        </option>
                                        <option value="37 - 33"
                                            {{ isset($user) && $user->age == '37 - 33' ? 'selected' : '' }}>
                                            37 - 33
                                        </option>
                                        <option value="42 - 38"
                                            {{ isset($user) && $user->age == '42 - 38' ? 'selected' : '' }}>
                                            42 - 38
                                        </option>
                                        <option value="47 - 43"
                                            {{ isset($user) && $user->age == '47 - 43' ? 'selected' : '' }}>
                                            47 - 43
                                        </option>
                                        <option value="52 - 48"
                                            {{ isset($user) && $user->age == '52 - 48' ? 'selected' : '' }}>
                                            52 - 48
                                        </option>
                                        <option value="53+" {{ isset($user) && $user->age == '53+' ? 'checked' : '' }}>
                                            53+
                                        </option>
                                        {{-- @for ($age = 10; $age <= 100; $age++)
                                        <option value="{{$age}}">{{$age}}</option>
                                    @endfor --}}
                                        <!-- المزيد من الأعمار -->
                                    </select>
                                </div>


                                <div class="form-group">
                                    <div class="labelform-content">
                                        <label class="labelform" for="nationality">المدينة</label>
                                        <select class="form-control" id="city" name="city" required
                                            oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                            oninput="setCustomValidity('')">
                                            <option value="">اختار</option>
                                            @foreach (App\Models\City::orderBy('id')->get() as $item)
                                                <option value="{{ $item->title_ar }}"
                                                    {{ isset($user) && $user->city_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <!-- التفاصيل -->
                                <h3 class="main-tit">التفاصيل</h3>

                                <div class="form-group">
                                    <div class="labelform-content">
                                        <label class="labelform" for="nationality">الجنسية</label>
                                        <select class="form-control" id="nationality" name="nationality" required
                                            oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                            oninput="setCustomValidity('')">
                                            <option value="">اختار</option>
                                            @foreach (App\Models\Media_file::where('type', 'nationality')->orderBy('id')->get() as $item)
                                                <option value="{{ $item->title_ar }}"
                                                    {{ isset($user) && $user->nationality == $item->title_ar ? 'selected' : '' }}>
                                                    {{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="labelform-content">
                                        <label class="labelform" for="levels">الحالة الاجتماعية</label>
                                        <select class="form-control" id="social_level" name="social_level" required
                                            oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                            oninput="setCustomValidity('')">
                                            <option value="">اختار</option>
                                            @foreach (App\Models\Media_file::where('type', 'social_levels')->orderBy('title_ar')->get() as $item)
                                                <option value="{{ $item->title_ar }}"
                                                    {{ isset($user) && $user->social_level == $item->title_ar ? 'selected' : '' }}>
                                                    {{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="labelform-content">
                                        <label class="labelform" for="levels">لديك ابناء</label>
                                        <select class="form-control" id="has_sons" name="has_sons" required
                                            oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                            oninput="setCustomValidity('')">
                                            <option value="">اختار</option>
                                            <option value="0"
                                                {{ isset($user) && $user->has_sons == '0' ? 'selected' : '' }}>
                                                لا
                                            </option>
                                            <option value="1"
                                                {{ isset($user) && $user->has_sons == '1' ? 'selected' : '' }}>
                                                نعم
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- التعليم -->
                                <div class="labelform-content">
                                    <label class="labelform">التحصيل العلمي</label>
                                    <select class="form-control" name="level" required
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                        <option value="">اختار</option>
                                        @foreach (App\Models\Media_file::where('type', 'levels')->orderBy('title_ar')->get() as $item)
                                            <option value="{{ $item->title_ar }}"
                                                {{ isset($user) && $user->level == $item->title_ar ? 'selected' : '' }}>
                                                {{ $item->title_ar }}</option>
                                        @endforeach
                                        <!-- المزيد من الخيارات -->
                                    </select>
                                </div>
                                <!-- التعليم -->
                                <div class="labelform-content">
                                    <label class="labelform">المهنه</label>
                                    <select class="form-control" name="job" required
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                        <option value="">اختار</option>
                                        @foreach (App\Models\Media_file::where('type', 'jobs')->orderBy('title_ar')->get() as $item)
                                            <option value="{{ $item->title_ar }}"
                                                {{ isset($user) && $user->job == $item->title_ar ? 'selected' : '' }}>
                                                {{ $item->title_ar }}</option>
                                        @endforeach
                                        <!-- المزيد من الخيارات -->
                                    </select>
                                </div>


                                <!-- الحالة العملية -->
                                {{-- <label>الحالة العملية:</label>
                                <select name="employment" required>
                                    <option value="موظف">موظف</option>
                                    <option value="مستقل">مستقل</option>
                                    <!-- المزيد من الخيارات -->
                                </select> --}}

                                <!-- طريقة التواصل -->
                                <div class="labelform-content">
                                    <label class="labelform">طريقة التواصل مع الاخرين</label>
                                    <div class="checkbox-group" id="communicationsGroup">
                                        <label><input type="checkbox" name="communications[]"
                                                {{ isset($user) && in_array('الموقع', explode(',', $user->communications)) ? 'checked' : '' }}
                                                value="الموقع">الموقع</label>
                                        <label><input type="checkbox" name="communications[]"
                                                {{ isset($user) && in_array('الهاتف', explode(',', $user->communications)) ? 'checked' : '' }}
                                                value="الهاتف">الهاتف</label>
                                        <label><input type="checkbox" name="communications[]"
                                                {{ isset($user) && in_array('الايميل', explode(',', $user->communications)) ? 'checked' : '' }}
                                                value="الايميل">الايميل</label>
                                        <label><input type="checkbox" name="communications[]"
                                                {{ isset($user) && in_array('ماسنجر', explode(',', $user->communications)) ? 'checked' : '' }}
                                                value="ماسنجر">ماسنجر</label>
                                        <label><input type="checkbox" name="communications[]"
                                                {{ isset($user) && in_array('واتس اب', explode(',', $user->communications)) ? 'checked' : '' }}
                                                value="واتس اب">واتس
                                            اب</label>
                                        <label><input type="checkbox" name="communications[]"
                                                {{ isset($user) && in_array('ولي الأمر', explode(',', $user->communications)) ? 'checked' : '' }}
                                                value="ولي الأمر">ولي الأمر</label>
                                    </div>
                                </div>

                                <small id="communicationsError"
                                    style="color:red; display:none;font-size: larger;width: 100%;text-align: center">يرجى
                                    اختيار طريقة واحدة على الأقل</small>

                                <!-- المظهر -->
                                <h3 class="main-tit">المظهر</h3>

                                <!-- نوع السكن، لون العيون، لون الشعر، الحالة الصحية -->
                                {{-- <label>نوع السكن:</label>
                                <select name="housing" required>
                                    <option value="ملك">ملك</option>
                                    <option value="إيجار">إيجار</option>
                                </select> --}}

                                <div class="labelform-content">
                                    <label class="labelform">لون العيون:</label>
                                    <select class="form-control" name="eye_color" required
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                        <option value="">اختار</option>
                                        <option value="أسود"
                                            {{ isset($user) && $user->eye_color == 'أسود' ? 'selected' : '' }}>
                                            أسود
                                        </option>
                                        <option value="بني"
                                            {{ isset($user) && $user->eye_color == 'بني' ? 'selected' : '' }}>
                                            بني
                                        </option>
                                        <option value="عسلي"
                                            {{ isset($user) && $user->eye_color == 'عسلي' ? 'selected' : '' }}>
                                            عسلي
                                        </option>
                                        <option value="أزرق"
                                            {{ isset($user) && $user->eye_color == 'أزرق' ? 'selected' : '' }}>
                                            أزرق
                                        </option>
                                        <option value="اخضر"
                                            {{ isset($user) && $user->eye_color == 'اخضر' ? 'selected' : '' }}>
                                            اخضر
                                        </option>
                                        <option value="رمادي"
                                            {{ isset($user) && $user->eye_color == 'رمادي' ? 'selected' : '' }}>
                                            رمادي
                                        </option>
                                    </select>
                                </div>


                                <div class="labelform-content">
                                    <label class="labelform">لون الشعر:</label>
                                    <select class="form-control" name="hair_color" required
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                        <option value="">اختار</option>
                                        <option value="أسود"
                                            {{ isset($user) && $user->hair_color == 'أسود' ? 'selected' : '' }}>
                                            أسود
                                        </option>
                                        <option value="بني"
                                            {{ isset($user) && $user->hair_color == 'بني' ? 'selected' : '' }}>
                                            بني
                                        </option>
                                        <option value="اشقر"
                                            {{ isset($user) && $user->hair_color == 'اشقر' ? 'selected' : '' }}>
                                            اشقر
                                        </option>
                                        <option value="احمر"
                                            {{ isset($user) && $user->hair_color == 'احمر' ? 'selected' : '' }}>
                                            احمر
                                        </option>
                                        <option value="رمادي"
                                            {{ isset($user) && $user->hair_color == 'رمادي' ? 'selected' : '' }}>
                                            رمادي
                                        </option>
                                        <option value="ابيض"
                                            {{ isset($user) && $user->hair_color == 'ابيض' ? 'selected' : '' }}>
                                            ابيض
                                        </option>
                                        <option value="اصلع"
                                            {{ isset($user) && $user->hair_color == 'اصلع' ? 'selected' : '' }}>
                                            اصلع
                                        </option>
                                    </select>
                                </div>


                                <div class="labelform-content">
                                    <label class="labelform">لون البشرة:</label>
                                    <select class="form-control" name="skin_color" required
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                        <option value="">اختار</option>
                                        <option value="ابيض"
                                            {{ isset($user) && $user->skin_color == 'ابيض' ? 'selected' : '' }}>
                                            ابيض
                                        </option>
                                        <option value="يميل الى البياض"
                                            {{ isset($user) && $user->skin_color == 'يميل الى البياض' ? 'selected' : '' }}>
                                            يميل الى البياض
                                        </option>
                                        <option value="أسود"
                                            {{ isset($user) && $user->skin_color == 'أسود' ? 'selected' : '' }}>
                                            أسود
                                        </option>
                                        <option value="يميل الى السواد"
                                            {{ isset($user) && $user->skin_color == 'يميل الى السواد' ? 'selected' : '' }}>
                                            يميل الى السواد
                                        </option>
                                        <option value="أسمر"
                                            {{ isset($user) && $user->skin_color == 'أسمر' ? 'selected' : '' }}>
                                            أسمر
                                        </option>
                                        <option value="حنطي"
                                            {{ isset($user) && $user->skin_color == 'حنطي' ? 'selected' : '' }}>
                                            حنطي
                                        </option>
                                    </select>
                                </div>


                                <div class="labelform-content">
                                    <label class="labelform">الطول:</label>
                                    <select class="form-control" name="height" required
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                        <option value="">اختار</option>
                                        <option value="قصير"
                                            {{ isset($user) && $user->height == 'قصير' ? 'selected' : '' }}>
                                            قصير
                                        </option>
                                        <option value="متوسط"
                                            {{ isset($user) && $user->height == 'متوسط' ? 'selected' : '' }}>
                                            متوسط
                                        </option>
                                        <option value="طويل"
                                            {{ isset($user) && $user->height == 'طويل' ? 'selected' : '' }}>
                                            طويل
                                        </option>
                                        {{-- @for ($height = 100; $height <= 200; $height++)
                                        <option value="{{$height}}">{{$height}}</option>
                                    @endfor --}}
                                        <!-- المزيد من الأطوال -->
                                    </select>
                                </div>

                                <div class="labelform-content">
                                    <label class="labelform">الوزن:</label>
                                    <select class="form-control" name="width" required
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                        <option value="">اختار</option>
                                        <option value="ضعيف"
                                            {{ isset($user) && $user->width == 'ضعيف' ? 'selected' : '' }}>
                                            ضعيف
                                        </option>
                                        <option value="عادي"
                                            {{ isset($user) && $user->width == 'عادي' ? 'selected' : '' }}>
                                            عادي
                                        </option>
                                        <option value="سمين"
                                            {{ isset($user) && $user->width == 'سمين' ? 'selected' : '' }}>
                                            سمين
                                        </option>
                                        {{-- @for ($height = 100; $height <= 200; $height++)
                                        <option value="{{$height}}">{{$height}}</option>
                                    @endfor --}}
                                        <!-- المزيد من الأطوال -->
                                    </select>
                                </div>

                                <button class="main-btn-reg" type="submit" onclick="checkData()">التالي</button>


                            </form>
                        @elseif($step == '2')
                            <form id="formStep2" class="step active-step"
                                action="{{ route('site_post_register') }}?step=2&user={{ isset($user) ? $user->id : '0' }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="step" id="step" value="2">
                                <input type="hidden" name="id" id="user_id"
                                    value="{{ isset($user) ? $user->id : '0' }}">
                                <div class="labelform-content">
                                    <label class="labelform" for="textarea1">تحدث عن نفسك :</label>
                                    <textarea id="textarea1" name="desc_ar" rows="4" cols="50"
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')" oninput="setCustomValidity('')" required>{{ isset($user) ? $user->desc_ar : '' }}</textarea>

                                </div>
                                <div class="labelform-content">
                                    <label class="labelform" for="textarea2">تحدث عن الشخص الذي تبحث عنة:</label>
                                    <textarea id="textarea2" name="goal_desc_ar" rows="4" cols="50"
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')" oninput="setCustomValidity('')" required>{{ isset($user) ? $user->goal_desc_ar : '' }}</textarea>

                                </div>

                                <button class="main-btn-reg" type="submit">التالي</button>
                                <button class="main-btn-reg2" type="button" onclick="goToStepPage(1)"
                                    {{-- onclick="prevStep()" --}}>رجوع</button>

                            </form>
                        @elseif($step == '3')
                            <form id="formStep3" class="step active-step"
                                action="{{ route('site_post_register') }}?step=3&user={{ isset($user) ? $user->id : '0' }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="step" id="step" value="3">
                                <input type="hidden" name="login" value="1">
                                <input type="hidden" name="id" id="user_id"
                                    value="{{ isset($user) ? $user->id : '0' }}">

                                <div class="labelform-content">
                                    <label class="labelform" for="username">اسم المستخدم:</label>
                                    <input type="text" id="username" name="username" value="{{ old('username') }}" required
                                        placeholder="اسم المستخدم"
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">

                                </div>
                                <p class="hint-label mb-4">اسم المستخدم يستخدم فقط لتسجيل الدخول ولا يظهر لأحد فى الموقع
                                </p>


                                <!-- البريد الإلكتروني -->
                                <div class="labelform-content">
                                    <label class="labelform" for="email">البريد الإلكتروني:</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        placeholder="أدخل البريد الإلكتروني"
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                </div>

                                <p class="hint-label mb-4">تأكد من إدخال بريد إلكتروني صحيح , ستستلم عليه الرسائل</p>

                                <!-- إعادة البريد الإلكتروني -->
                                {{-- <label for="confirmEmail">إعادة البريد الإلكتروني:</label>
                            <input type="email" id="confirmEmail" name="confirmEmail" required placeholder="أعد إدخال البريد الإلكتروني"> --}}

                                <!-- كلمة السر -->
                                <div class="labelform-content">
                                    <label class="labelform" for="password">كلمة السر:</label>
                                    <input type="password" id="password" name="password" required
                                        placeholder="أدخل كلمة السر"
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                </div>


                                <!-- إعادة كلمة السر -->
                                <div class="labelform-content">
                                    <label class="labelform" for="confirmPassword">إعادة كلمة السر:</label>
                                    <input type="password" id="confirmPassword" name="password_confirmation" required
                                        placeholder="أعد إدخال كلمة السر"
                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                        oninput="setCustomValidity('')">
                                </div>
                                <p class="text-center mb-4" style="color:red"> <strong>
                                        يرجى مراجعة جميع البيانات قبل الإرسال
                                    </strong> </p>


                                <!-- شروط الاستخدام -->



                                <div class="checkbox-group">
                                    <label><input type="checkbox"
                                            oninvalid="this.setCustomValidity('الرجاء الموافقة على الشروط')"
                                            oninput="setCustomValidity('')" required value="terms">أوافق على كل شروط
                                        الاستخدام للموقع</label>

                                </div>



                                <small>لمراجعة شروط الموقع اضغط <a href="{{ url('page/condition') }}"
                                        target="_blank">هنا</a>.</small>
                                <button class="main-btn-reg" type="submit">تسجيل</button>


                                <button class="main-btn-reg2" type="button" onclick="goToStepPage(2)"
                                    {{-- onclick="prevStep()" --}}>رجوع</button>
                            </form>
                        @endif
                    </div>



                    {{-- <div class="form-container">
                        <h2 class="main-tit head-tit sec-tit mb-5">التسجيل</h2>

                        <div class="form-container-items">
                        --}}{{-- <form id="multiStepForm"> --}}{{--
                        @if (!isset($step) || ($step != '2' && $step != '3'))
                            <!-- Step 1 -->
                                <div class="step active-step" id="step1">
                                    <form action="{{route('site_post_register')}}?step=1&user={{isset($user) ? $user->id : '0'}}"
                                          id="myForm" method="post" enctype="multipart/form-data">

                                        @csrf

                                        <input type="hidden" name="step" id="step" value="1">
                                        <input type="hidden" name="id" id="user_id"
                                               value="{{isset($user) ? $user->id : '0'}}">
                                        <div class="gender-selection">
                                            <label class="gender-label">
                                                <input type="radio" name="gender" value="male" id="male" required>
                                                <img src="{{ site_path() }}/assets/img/male-selected.png" alt="ذكر"
                                                     class="selected" id="male-selected">
                                                <img src="{{ site_path() }}/assets/img/male-unselected.png" alt="ذكر"
                                                     class="unselected" id="male-unselected">
                                                <span>ذكر</span>
                                            </label>

                                            <label class="gender-label">
                                                <input type="radio" name="gender" value="female" id="female" required>
                                                <img src="{{ site_path() }}/assets/img/female-selected.png" alt="أنثى"
                                                     class="selected" id="female-selected">
                                                <img src="{{ site_path() }}/assets/img/female-unselected.png" alt="أنثى"
                                                     class="unselected" id="female-unselected">
                                                <span>أنثى</span>
                                            </label>

                                        </div>
                                        <small id="genderError" style="color:red; display:none;font-size: larger;">يرجى
                                            اختيار الجنس</small>

                                        <!-- الاسم -->
                                        <div class="labelform-content">
                                            <label class="labelform">الاسم:</label>
                                            <input class="input-field" type="text" name="first_name"
                                                   value="{{isset($user) ? $user->first_name : old('first_name')}}"
                                                   required
                                                   oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                   oninput="setCustomValidity('')">
                                        </div>


                                        <div class="labelform-content">
                                            <!-- الهدف من الموقع -->
                                            <label class="labelform">الهدف من الموقع:</label>
                                            <div class="checkbox-group input-field" id="goalsGroup">
                                                @foreach (App\Models\Media_file::where('type', 'goals')->orderBy('title_ar')->get() as $item)
                                                    <label>
                                                        <input type="checkbox" name="goals[]" value="{{$item->title}}"
                                                                {{isset($user) && in_array($item->title_ar, explode(',', $user->goals)) ? 'checked' : ''}}>{{$item->title}}
                                                    </label>
                                                @endforeach
                                            </div>
                                            <small id="goalsError" style="color:red; display:none;font-size: larger;">يرجى
                                                اختيار هدف واحد على الأقل</small>
                                        </div>


                                        <div class="labelform-content">
                                            <!-- العمر والطول -->
                                            <label class="labelform">العمر:</label>
                                            <select name="age" required
                                                    oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                    oninput="setCustomValidity('')">
                                                <option value="">اختار</option>
                                                <option value="22 - 18" {{isset($user) && $user->age == '22 - 18' ? 'selected' : ''}}>
                                                    22 - 18
                                                </option>
                                                <option value="27 - 23" {{isset($user) && $user->age == '27 - 23' ? 'selected' : ''}}>
                                                    27 - 23
                                                </option>
                                                <option value="32 - 28" {{isset($user) && $user->age == '32 - 28' ? 'selected' : ''}}>
                                                    32 - 28
                                                </option>
                                                <option value="37 - 33" {{isset($user) && $user->age == '37 - 33' ? 'selected' : ''}}>
                                                    37 - 33
                                                </option>
                                                <option value="42 - 38" {{isset($user) && $user->age == '42 - 38' ? 'selected' : ''}}>
                                                    42 - 38
                                                </option>
                                                <option value="47 - 43" {{isset($user) && $user->age == '47 - 43' ? 'selected' : ''}}>
                                                    47 - 43
                                                </option>
                                                <option value="52 - 48" {{isset($user) && $user->age == '52 - 48' ? 'selected' : ''}}>
                                                    52 - 48
                                                </option>
                                                <option value="53+" {{isset($user) && $user->age == '53+' ? 'checked' : ''}}>
                                                    53+
                                                </option>
                                            --}}{{-- @for ($age = 10; $age <= 100; $age++)
                                                <option value="{{$age}}">{{$age}}</option>
                                            @endfor --}}{{--
                                            <!-- المزيد من الأعمار -->
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <div class="labelform-content">
                                                <label class="labelform" for="nationality">الدولة</label>
                                                <select class="form-control" id="country" name="country" required
                                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                        oninput="setCustomValidity('')">
                                                    <option value="">اختار</option>
                                                    @foreach (App\Models\Country::orderBy('title_ar')->get() as $item)
                                                        <option value="{{$item->title_ar}}" {{isset($user) && $user->country == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <!-- التفاصيل -->
                                        <h3 class="main-tit">التفاصيل</h3>

                                        <div class="form-group">
                                            <div class="labelform-content">
                                                <label class="labelform" for="nationality">الجنسية</label>
                                                <select class="form-control" id="nationality" name="nationality"
                                                        required
                                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                        oninput="setCustomValidity('')">
                                                    <option value="">اختار</option>
                                                    @foreach (App\Models\Media_file::where('type', 'nationality')->get() as $item)
                                                        <option value="{{$item->title_ar}}" {{isset($user) && $user->nationality == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="labelform-content">
                                                <label class="labelform" for="levels">الحالة الاجتماعية</label>
                                                <select class="form-control" id="social_level" name="social_level"
                                                        required
                                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                        oninput="setCustomValidity('')">
                                                    <option value="">اختار</option>
                                                    @foreach (App\Models\Media_file::where('type', 'social_levels')->orderBy('title_ar')->get() as $item)
                                                        <option value="{{$item->title_ar}}" {{isset($user) && $user->social_level == $item->title_ar ? 'selected' : ''}}>{{$item->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="labelform-content">
                                                <label class="labelform" for="levels">لديك ابناء</label>
                                                <select class="form-control" id="has_sons" name="has_sons" required
                                                        oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                        oninput="setCustomValidity('')">
                                                    <option value="">اختار</option>
                                                    <option value="0" {{isset($user) && $user->has_sons == '0' ? 'selected' : ''}}>
                                                        لا
                                                    </option>
                                                    <option value="1" {{isset($user) && $user->has_sons == '1' ? 'selected' : ''}}>
                                                        نعم
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- التعليم -->
                                        <div class="labelform-content">
                                            <label class="labelform">التحصيل العلمي:</label>
                                            <select name="level" required
                                                    oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                    oninput="setCustomValidity('')">
                                                <option value="">اختار</option>
                                                @foreach (App\Models\Media_file::where('type', 'levels')->orderBy('title_ar')->get() as $item)
                                                    <option value="{{$item->title_ar}}" {{isset($user) && $user->level == $item->title_ar ? 'selected' : ''}}>{{$item->title_ar}}</option>
                                            @endforeach
                                            <!-- المزيد من الخيارات -->
                                            </select>
                                        </div>


                                        <!-- الحالة العملية -->
                                        --}}{{-- <label>الحالة العملية:</label>
                                        <select name="employment" required>
                                            <option value="موظف">موظف</option>
                                            <option value="مستقل">مستقل</option>
                                            <!-- المزيد من الخيارات -->
                                        </select> --}}{{--

                                    <!-- طريقة التواصل -->
                                        <div class="labelform-content">
                                            <label class="labelform">طريقة التواصل مع الاخرين:</label>
                                            <div class="checkbox-group" id="communicationsGroup">
                                                <label><input type="checkbox" name="communications[]"
                                                              {{isset($user) && in_array('الموقع', explode(',', $user->communications)) ? 'checked' : ''}} value="الموقع">الموقع</label>
                                                <label><input type="checkbox" name="communications[]"
                                                              {{isset($user) && in_array('الهاتف', explode(',', $user->communications)) ? 'checked' : ''}} value="الهاتف">الهاتف</label>
                                                <label><input type="checkbox" name="communications[]"
                                                              {{isset($user) && in_array('الايميل', explode(',', $user->communications)) ? 'checked' : ''}} value="الايميل">الايميل</label>
                                                <label><input type="checkbox" name="communications[]"
                                                              {{isset($user) && in_array('ماسنجر', explode(',', $user->communications)) ? 'checked' : ''}} value="ماسنجر">ماسنجر</label>
                                                <label><input type="checkbox" name="communications[]"
                                                              {{isset($user) && in_array('واتس اب', explode(',', $user->communications)) ? 'checked' : ''}} value="واتس اب">واتس
                                                    اب</label>
                                            </div>
                                        </div>

                                        <small id="communicationsError"
                                               style="color:red; display:none;font-size: larger;">يرجى
                                            اختيار طريقة واحدة على الأقل</small>

                                        <!-- المظهر -->
                                        <h3 class="main-tit">المظهر</h3>

                                        <!-- نوع السكن، لون العيون، لون الشعر، الحالة الصحية -->
                                        --}}{{-- <label>نوع السكن:</label>
                                        <select name="housing" required>
                                            <option value="ملك">ملك</option>
                                            <option value="إيجار">إيجار</option>
                                        </select> --}}{{--

                                        <div class="labelform-content">
                                            <label class="labelform">لون العيون:</label>
                                            <select name="eye_color" required
                                                    oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                    oninput="setCustomValidity('')">
                                                <option value="">اختار</option>
                                                <option value="أسود" {{isset($user) && $user->eye_color == 'أسود' ? 'selected' : ''}}>
                                                    أسود
                                                </option>
                                                <option value="بني" {{isset($user) && $user->eye_color == 'بني' ? 'selected' : ''}}>
                                                    بني
                                                </option>
                                                <option value="عسلي" {{isset($user) && $user->eye_color == 'عسلي' ? 'selected' : ''}}>
                                                    عسلي
                                                </option>
                                                <option value="أزرق" {{isset($user) && $user->eye_color == 'أزرق' ? 'selected' : ''}}>
                                                    أزرق
                                                </option>
                                                <option value="اخضر" {{isset($user) && $user->eye_color == 'اخضر' ? 'selected' : ''}}>
                                                    اخضر
                                                </option>
                                                <option value="رمادي" {{isset($user) && $user->eye_color == 'رمادي' ? 'selected' : ''}}>
                                                    رمادي
                                                </option>
                                            </select>
                                        </div>


                                        <div class="labelform-content">
                                            <label class="labelform">لون الشعر:</label>
                                            <select name="hair_color" required
                                                    oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                    oninput="setCustomValidity('')">
                                                <option value="">اختار</option>
                                                <option value="أسود" {{isset($user) && $user->hair_color == 'أسود' ? 'selected' : ''}}>
                                                    أسود
                                                </option>
                                                <option value="بني" {{isset($user) && $user->hair_color == 'بني' ? 'selected' : ''}}>
                                                    بني
                                                </option>
                                                <option value="اشقر" {{isset($user) && $user->hair_color == 'اشقر' ? 'selected' : ''}}>
                                                    اشقر
                                                </option>
                                                <option value="احمر" {{isset($user) && $user->hair_color == 'احمر' ? 'selected' : ''}}>
                                                    احمر
                                                </option>
                                                <option value="رمادي" {{isset($user) && $user->hair_color == 'رمادي' ? 'selected' : ''}}>
                                                    رمادي
                                                </option>
                                                <option value="ابيض" {{isset($user) && $user->hair_color == 'ابيض' ? 'selected' : ''}}>
                                                    ابيض
                                                </option>
                                                <option value="اصلع" {{isset($user) && $user->hair_color == 'اصلع' ? 'selected' : ''}}>
                                                    اصلع
                                                </option>
                                            </select>
                                        </div>


                                        <div class="labelform-content">
                                            <label class="labelform">لون البشرة:</label>
                                            <select name="skin_color" required
                                                    oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                    oninput="setCustomValidity('')">
                                                <option value="">اختار</option>
                                                <option value="ابيض" {{isset($user) && $user->skin_color == 'ابيض' ? 'selected' : ''}}>
                                                    ابيض
                                                </option>
                                                <option value="يميل الى البياض" {{isset($user) && $user->skin_color == 'يميل الى البياض' ? 'selected' : ''}}>
                                                    يميل الى البياض
                                                </option>
                                                <option value="أسود" {{isset($user) && $user->skin_color == 'أسود' ? 'selected' : ''}}>
                                                    أسود
                                                </option>
                                                <option value="يميل الى السواد" {{isset($user) && $user->skin_color == 'يميل الى السواد' ? 'selected' : ''}}>
                                                    يميل الى السواد
                                                </option>
                                                <option value="أسمر" {{isset($user) && $user->skin_color == 'أسمر' ? 'selected' : ''}}>
                                                    أسمر
                                                </option>
                                            </select>
                                        </div>


                                        <div class="labelform-content">
                                            <label class="labelform">الطول:</label>
                                            <select name="height" required
                                                    oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                    oninput="setCustomValidity('')">
                                                <option value="">اختار</option>
                                                <option value="قصير" {{isset($user) && $user->height == 'قصير' ? 'selected' : ''}}>
                                                    قصير
                                                </option>
                                                <option value="متوسط" {{isset($user) && $user->height == 'متوسط' ? 'selected' : ''}}>
                                                    متوسط
                                                </option>
                                                <option value="طويل" {{isset($user) && $user->height == 'طويل' ? 'selected' : ''}}>
                                                    طويل
                                                </option>
                                            --}}{{-- @for ($height = 100; $height <= 200; $height++)
                                                <option value="{{$height}}">{{$height}}</option>
                                            @endfor --}}{{--
                                            <!-- المزيد من الأطوال -->
                                            </select>
                                        </div>

                                        <div class="labelform-content">
                                            <label class="labelform">الوزن:</label>
                                            <select name="width" required
                                                    oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                    oninput="setCustomValidity('')">
                                                <option value="">اختار</option>
                                                <option value="ضعيف" {{isset($user) && $user->width == 'ضعيف' ? 'selected' : ''}}>
                                                    ضعيف
                                                </option>
                                                <option value="عادي" {{isset($user) && $user->width == 'عادي' ? 'selected' : ''}}>
                                                    عادي
                                                </option>
                                                <option value="سمين" {{isset($user) && $user->width == 'سمين' ? 'selected' : ''}}>
                                                    سمين
                                                </option>
                                            --}}{{-- @for ($height = 100; $height <= 200; $height++)
                                                <option value="{{$height}}">{{$height}}</option>
                                            @endfor --}}{{--
                                            <!-- المزيد من الأطوال -->
                                            </select>
                                        </div>


                                    </form>

                                    <!-- زر التالي -->

                                </div>

                        @elseif($step == '2')

                            <!-- Step 2 -->
                                <div class="step">
                                    <div class="buttons">
                                        <button type="button" class="next-btn" onclick="goto_step()">
                                            <span>السابق</span>
                                            <i class="fa-solid fa-right-long"></i>
                                        </button>
                                        <button type="submit" class="next-btn">
                                            <span>التالي</span>
                                            <i class="fa-solid fa-left-long"></i>
                                        </button>
                                    </div>

                                    <form action="{{route('site_post_register')}}?step=2&user={{isset($user) ? $user->id : '0'}}"
                                          method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="step" id="step" value="2">
                                        <input type="hidden" name="id" id="user_id"
                                               value="{{isset($user) ? $user->id : '0'}}">
                                        <div class="labelform-content">
                                            <label class="labelform" for="textarea1">تحدث عن نفسك :</label>
                                            <textarea id="textarea1" name="desc_ar" rows="4" cols="50"
                                                      oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                      oninput="setCustomValidity('')" required>{{isset($user) ? $user->desc_ar : ''}}
                                    </textarea>

                                        </div>
                    <div class="labelform-content">
                        <label class="labelform" for="textarea2">تحدث عن الشخص الذي تبحث عنة:</label>
                        <textarea id="textarea2" name="goal_desc_ar" rows="4" cols="50"
                                  oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                  oninput="setCustomValidity('')" required>{{isset($user) ? $user->goal_desc_ar : ''}}
                                    </textarea>

                    </div>

                                    </form>

                                </div>

                        @elseif($step == '3')

                            <!-- Step 3 -->
                                <div class="step">
                                    <form action="{{route('site_post_register')}}?step=3&user={{isset($user) ? $user->id : '0'}}"
                                          method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="step" id="step" value="3">
                                        <input type="hidden" name="login" value="1">
                                        <input type="hidden" name="id" id="user_id"
                                               value="{{isset($user) ? $user->id : '0'}}">
                                        <p>يرجى مراجعة البيانات قبل الإرسال:</p>
                                        <div class="labelform-content">
                                            <label class="labelform"   for="username">اسم المستخدم:</label>
                                            <input type="text" id="username" name="username" required
                                                   placeholder="أدخل اسم المستخدم"
                                                   oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                   oninput="setCustomValidity('')">

                                        </div>

                                        <small>اسم المستخدم يستخدم فقط لتسجيل الدخول. هذا الاسم خاص بك ولا يظهر
                                            للآخرين</small>

                                        <!-- البريد الإلكتروني -->
                                        <div class="labelform-content">
                                            <label class="labelform"  for="email">البريد الإلكتروني:</label>
                                            <input type="email" id="email" name="email" required
                                                   placeholder="أدخل البريد الإلكتروني"
                                                   oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                   oninput="setCustomValidity('')">
                                        </div>


                                        <small>تأكد من إدخال بريدك الإلكتروني الصحيح لأن عملية تفعيل حسابك تعتمد
                                            عليه.</small>

                                        <!-- إعادة البريد الإلكتروني -->
                                    --}}{{-- <label for="confirmEmail">إعادة البريد الإلكتروني:</label>
                                    <input type="email" id="confirmEmail" name="confirmEmail" required placeholder="أعد إدخال البريد الإلكتروني"> --}}{{--

                                    <!-- كلمة السر -->
                                        <div class="labelform-content">
                                            <label class="labelform" for="password">كلمة السر:</label>
                                            <input type="password" id="password" name="password" required
                                                   placeholder="أدخل كلمة السر"
                                                   oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                   oninput="setCustomValidity('')">
                                        </div>


                                        <!-- إعادة كلمة السر -->
                                        <div class="labelform-content">
                                            <label class="labelform" for="confirmPassword">إعادة كلمة السر:</label>
                                            <input type="password" id="confirmPassword" name="password_confirmation"
                                                   required
                                                   placeholder="أعد إدخال كلمة السر"
                                                   oninvalid="this.setCustomValidity('الرجاء ادخال هذا العنصر')"
                                                   oninput="setCustomValidity('')">
                                        </div>


                                        <!-- شروط الاستخدام -->
                                        <label>
                                            <input type="checkbox" name="terms">
                                            أوافق على كل شروط الاستخدام للموقع
                                        </label>

                                        <small>لمراجعة شروط الموقع اضغط <a href="{{url('page/condition')}}"
                                                                           target="_blank">هنا</a>.</small>

                                        <div class="buttons">
                                            <button type="button" class="next-btn" onclick="goto_step()">
                                                <span>السابق</span>
                                                <i class="fa-solid fa-right-long"></i>
                                            </button>
                                            <button type="submit" class="next-btn">تسجيل</button>
                                        </div>
                                    </form>
                                </div>

                            @endif

                        </div>


                    </div> --}}
                </div>
                <div class="col-lg-4 col-non">
                    <h4 class="sec-tit mb-5">ﻳﻤﻜﻨﻚ اﻟﺘﻮاﺻﻞ ﻣﻊ ﻫﺆﻻء اﻷﻋﻀﺎء</h4>

                    <div class="register-sidebar">

                        @php
                            $new_users = App\Models\User::where('user_type', 'client')
                                ->where('blocked', '0')
                                ->where('avatar_seen', '1')
                                ->latest()
                                ->paginate(10);
                        @endphp

                        @foreach ($new_users as $item)
                            <div class="register-sidebar-content {{ $item->gender == 'male' ? 'male' : '' }} mb-3">
                                <div class="register-sidebar-head">
                                    <h2 class="text-center {{ $item->login == '1' ? 'online' : 'offline' }}">
                                        {{ $item->name }}</h2>
                                </div>
                                <div class="register-sidebar-body">
                                    <div class="image">
                                        <img src="{{ url('' . $item->avatar) }}" alt="{{ $item->full_name }}">
                                    </div>
                                    <div class="desc">
                                        <div class="desc-content-register mb-2">
                                            <div class="icon-text">
                                                <div class="icon">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>
                                                <div class="text">
                                                    العمر
                                                </div>
                                            </div>
                                            <div class="value">
                                                {{ $item->age }}
                                            </div>
                                        </div>
                                        <div class="desc-content-register mb-2">
                                            <div class="icon-text">
                                                <div class="icon">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                </div>
                                                <div class="text">
                                                    المدينة
                                                </div>
                                            </div>
                                            <div class="value">
                                                {{ $item->city?->title_ar }}
                                            </div>
                                        </div>
                                        <div class="desc-content-register mb-2">
                                            <div class="icon-text">
                                                <div class="icon">
                                                    <i class="fa-solid fa-heart"></i>
                                                </div>
                                                <div class="text">
                                                    الهدف
                                                </div>
                                            </div>
                                            <div class="value">
                                                {{ $item->goals }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{--    كود المودال استخدمة ف اي مكان مع الاستايل فوق --}}
    <div class="modal-prem">
        <div class="container">
            <!-- Button trigger modal -->

            <div class="buttons">
                {{-- <button type="button" class="" data-toggle="modal" data-target="#myModal">
                    ﺗﺮﻗﻴﺔ اﻟﻌﻀﻮﻳﺔ
                </button> --}}
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button type="button" class="close text-right" style="opacity: 1" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="modal-header     justify-content-center">
                            <h2 class="modal-title sec-tit text-center" id="exampleModalLabel">ﺗﺮﻗﻴﺔ اﻟﻌﻀﻮﻳﺔ</h2>
                        </div>
                        <div class="modal-body text-center">

                            <!-- Description -->
                            <p> ﻟﻜﻲ ﺗﺘﻤﻜﻦ ﻣﻦ اﻻﺳﺘﻔﺎدةﻣﻦ ﺟﻤﻴﻊ ﺧﺪﻣﺎت اﻟﻤﻮﻗﻊ .</p>
                            <!-- Image -->
                            <img src="{{ site_path() }}/assets/img/gold.png" alt="أنثى">

                            <!-- Button -->
                        </div>
                        <button type="button" class="next-btn">
                            <span>ترقيه</span>
                            <i class="fa-solid fa-left-long"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="sec-tit inside text-center">
        الباقات
    </div>
    --}}{{--    كود الباقات لما تعمل صفحه الباقات ضيفه فيه --}}{{--
    <div class="container">
        <div class="row">
            @foreach (App\Models\Package::get() as $item)
                <div class="col-md-6">
                    <div class="pricing-entry pb-5 text-center" style="padding: 10px ; border: 1px solid var(--main); border-radius: 5px ; ">
                        <div>
                            <h3 class="mb-2">{{$item->title_ar}}</h3>
                            --}}{{-- <h5 class="mb-4">(الباقه السنوية)</h5> --}}{{--
                        </div>
                        {!! $item->desc_ar !!}
                        <p class="price text-center" style="font-size: 48px; color: var(--main) ; margin: 5px 0 ; ">
                            {{$item->price_with_value}} ريال سعودي
                        </p>
                        --}}{{-- <button class="button text-center" style="width: 180px;">اشترك</button> --}}{{--
                    </div>
                </div>
            @endforeach
        </div>

    </div> --}}




@endsection

@section('script')
    <script>
        document.querySelectorAll('input[name="gender"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (document.getElementById("male").checked) {
                    document.getElementById("male-selected").style.display = "block";
                    document.getElementById("male-unselected").style.display = "none";
                    document.getElementById("female-selected").style.display = "none";
                    document.getElementById("female-unselected").style.display = "block";
                } else if (document.getElementById("female").checked) {
                    document.getElementById("female-selected").style.display = "block";
                    document.getElementById("female-unselected").style.display = "none";
                    document.getElementById("male-selected").style.display = "none";
                    document.getElementById("male-unselected").style.display = "block";
                }
            });
        });

        function goToStepPage(page = '1') {
            let userId = $('#userIdVal').val();
            window.location.assign("?step=" + page + "&user=" + userId);
        }
    </script>
    <script>
        function checkData() {
            // التحقق من اختيار أحد الخيارات
            const maleChecked = document.getElementById('male').checked;
            const femaleChecked = document.getElementById('female').checked;

            // المرجع لعنصر الرسالة
            const genderError = document.getElementById('genderError');

            if (!maleChecked && !femaleChecked) {
                // إظهار الرسالة ومنع إرسال الفورم
                genderError.style.display = 'block';
                //event.preventDefault();  // منع إرسال الفورم
                genderError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return false;
            } else {
                // إخفاء الرسالة إذا تم الاختيار
                genderError.style.display = 'none';
            }

            const goalsError = $('#goalsError');
            let isChecked = $('input[name="goals[]"]:checked').length > 0; // التحقق من اختيار أي هدف

            if (!isChecked) {
                goalsError.show(); // عرض الرسالة إذا لم يتم الاختيار
                event.preventDefault(); // منع إرسال النموذج
                // الصعود إلى أول عنصر checkbox في الصفحة
                $('input[name="goals[]"]')[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return false;
            } else {
                goalsError.hide(); // إخفاء الرسالة إذا تم الاختيار
            }

            const communicationsError = $('#communicationsError');
            let isCheckedCommunications = $('input[name="communications[]"]:checked').length > 0; // التحقق من اختيار أي هدف

            if (!isCheckedCommunications) {
                communicationsError.show(); // عرض الرسالة إذا لم يتم الاختيار
                event.preventDefault(); // منع إرسال النموذج
                // الصعود إلى أول عنصر checkbox في الصفحة
                $('input[name="communications[]"]')[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return false;
            } else {
                communicationsError.hide(); // إخفاء الرسالة إذا تم الاختيار
            }
        }

        $(document).ready(function() {
            // التحقق وتحديد "ذكر" كخيار افتراضي
            // if (!$('#male').is(':checked') && !$('#female').is(':checked')) {
            //     $('#male').prop('checked', true);  // تحديد "ذكر" افتراضيًا
            //
            //     document.getElementById("male-selected").style.display = "block";
            //     document.getElementById("male-unselected").style.display = "none";
            //     document.getElementById("female-selected").style.display = "none";
            //     document.getElementById("female-unselected").style.display = "block";
            // }
        });

        /*let currentStep = 0; // بدء من الخطوة الأولى
        showStep(currentStep); // عرض الخطوة الحالية

        function showStep(step) {
            const steps = document.getElementsByClassName("step");
            // إخفاء جميع الخطوات
            for (let i = 0; i < steps.length; i++) {
                steps[i].style.display = "none";
            }
            // إظهار الخطوة المحددة
            steps[step].style.display = "block";

            // إخفاء زر السابق في الخطوة الأولى
            if (step == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }

            // تغيير زر "التالي" إلى "إرسال" في الخطوة الأخيرة
            if (step == (steps.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "إرسال";
            } else {
                document.getElementById("nextBtn").innerHTML = "التالي";
            }
        }

        function nextStep(n) {
            const steps = document.getElementsByClassName("step");
            // التحقق من صحة النموذج في الخطوة الحالية قبل التقدم
            if (n == 1 && !validateForm()) return false;

            // إخفاء الخطوة الحالية
            steps[currentStep].style.display = "none";

            // تحديث قيمة الخطوة الحالية
            currentStep = currentStep + n;

            // في حالة الوصول إلى الخطوة الأخيرة، إرسال النموذج
            if (currentStep >= steps.length) {
                document.getElementById("multiStepForm").submit();
                return false;
            }

            // إظهار الخطوة التالية
            showStep(currentStep);

            // إذا كنت في الخطوة الأخيرة، قم بمراجعة البيانات
            if (currentStep == steps.length - 1) {
                document.getElementById("confirmFirstName").textContent = document.getElementsByName("first_name")[0].value;
                document.getElementById("confirmLastName").textContent = document.getElementsByName("last_name")[0].value;
                document.getElementById("confirmEmail").textContent = document.getElementsByName("email")[0].value;
                document.getElementById("confirmAddress").textContent = document.getElementsByName("address")[0].value;
                document.getElementById("confirmCity").textContent = document.getElementsByName("city")[0].value;
                document.getElementById("confirmCountry").textContent = document.getElementsByName("country")[0].value;
            }
        }

        function validateForm() {
            let valid = true;
            const inputs = document.getElementsByClassName("step")[currentStep].getElementsByTagName("input");

            // التحقق من صحة الحقول في الخطوة الحالية
            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].value == "") {
                    inputs[i].style.borderColor = "red";
                    valid = false;
                } else {
                    inputs[i].style.borderColor = "#ccc";
                }
            }

            return valid;
        }
        document.querySelectorAll('input[name="purpose"]').forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
                console.log(checkbox.value + " تم اختياره: " + checkbox.checked);
            });
        });*/
    </script>
    <script>
        document.getElementById('formStep3').addEventListener('submit', function(event) {
            const checkbox = document.getElementById('customCheckbox');
            if (!checkbox.checked) {
                // Prevent form submission
                event.preventDefault();

                // Scroll to the checkbox
                checkbox.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Temporary red outline to guide the user
                checkbox.style.outline = '2px solid red';

                // Reset the outline after a short delay
                setTimeout(() => {
                    checkbox.style.outline = 'none';
                }, 2000);
            }
        });
    </script>
@endsection
