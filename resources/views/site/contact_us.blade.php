@extends('site.master')
@section('title')
    راسل إدارة الموقع
@endsection
@section('meta')
    @include('meta::manager', [
        'title' => settings('site_name')  . ' - راسل إدارة الموقع',
        'description' => settings('description'),
        'image' => url('' . settings('logo')),
        'keywords' => settings('key_words')
    ])
@endsection

@section('style')
    <style>
    .page-title {
    position: relative;
    color: #b72dd2; /* Main color */
    font-size: 1.8rem;
    font-weight: bold;
    font-family: 'Tajawal', sans-serif;
    text-align: center;
    display: inline-block;
    padding: 10px 20px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(50, 142, 164, 0.19);
}

/* Icon Styling */
.icon {
    font-size: 1.8rem;
    color: #2492a8; /* Secondary color */
    margin-left: 12px; /* Space for RTL */
}

/* Super Stylish Underline */
.underline {
    width: 100px;
    height: 6px;
    background: linear-gradient(to right, #b72dd2, #2492a8);
    margin: 8px auto 0;
    border-radius: 30px;
    position: relative;
    overflow: hidden;
}

/* ✨ Stylish Animation Effect */
.underline::before {
    content: "";
    position: absolute;
    width: 50%;
    height: 100%;
    background: rgba(255, 255, 255, 0.4);
    left: -50%;
    border-radius: 30px;
    animation: underlineGlow 1.8s infinite ease-in-out;
}

@keyframes underlineGlow {
    0% { left: -50%; opacity: 0.6; }
    50% { left: 50%; opacity: 1; }
    100% { left: 150%; opacity: 0.6; }
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
    </style>

    <style>
        .form-section .desc {
            font-size: 18px;
            font-weight: 600;
        }

        .form-section p {
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .form-header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group select {
            width: 100%;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .form-group textarea {
            width: 100%;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .form-section .form-group input{
            height:48px
        }

        .form-group .input-label {
            width: 100%;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .form-group button {
            background-color: #b72dd2;
            color: white;
            cursor: pointer;
            width: 100%;
            padding: 13px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .form-group button:hover {
            background-color: #2492a8;
        }
        .sidebars ul li a{
            font-size:18px;
            font-weight: 600;
            color:#2e2e2e;
        }
    </style>
@endsection

@section('content')
    <!--  welcome  -->
    @if (!auth()->check())
        <section class="welcome">
            <div class="welcome-img">
                <img src="{{ site_path() }}/assets/img/welcome.png" alt="">
            </div>
            <p class="welcome-tit">أهلاً بكم في موقع {{ settings('site_name') }}</p>
        </section>
    @endif
    <!--  //welcome  -->



    <div class="container">
             <div class="d-flex justify-content-center my-4">
                <div class="page-title">
                    <i class="fas fa-phone-alt icon"></i>
                    <span class="title-text">راسل الإدارة</span>
                    <div class="underline"></div>
                </div>
            </div>



        <div class="row">
            <!-- Main Content Column -->
            <div class="col-md-9 form-section">
                <p class='desc'>
                    يرجى مراجعة <a href="{{ url('questions') }}">الأسئلة المتداولة</a> فقد تجد جوابًا لسؤالك.<br>
                    إذا لم تجد الإجابة الكافية، يمكنك مراسلة إدارة الموقع عن طريق هذه الصفحة
                    وسيتم الرد عليك في أقرب فرصة ممكنة.<br>
                    يجب أن تكون الرسالة واضحة ودقيقة مع توفير جميع المعلومات المهمة لذلك.
                </p>

                @if (!session()->has('contact_form_submitted'))
                <form action="{{ route('post_contact_us') }}" id="formRegister" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- <input type="hidden" name="name" value="{{auth()->check() ? auth()->user()->first_name : ''}}"> --}}
                    <input type="hidden" name="phone" value="{{ auth()->check() ? auth()->user()->phone : '' }}">
                    {{-- <input type="hidden" name="email" value="{{auth()->check() ? auth()->user()->email : ''}}"> --}}
                    <div class="form-group">
                        @if(!auth()->check()) <label for="names">اسمك :</label>  @else <label for="names">اسم المستخدم:</label>  @endif
                        <input class='input-label' type="text" id="name" name="name"
                            value="{{ auth()->check() ? auth()->user()->first_name : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني:</label>
                        <input class='input-label' type="email" id="email" name="email"
                            value="{{ auth()->check() ? auth()->user()->email : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="subject">الموضوع:</label>
                        <select id="title" name="title" required>
                            <option value="">(اختر الموضوع)</option>
                            <option value="استفسار عام">استفسار عام</option>
                            <option value="ملاحظات">ملاحظات</option>
                            <option value="مشكلة تقنية">مشكلة تقنية</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">الرسالة:</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <button class='main-btn-reg' type="submit">أرسل</button>
                        <button class='main-btn-reg2' type="button" onclick="history.back()">رجوع</button>
                    </div>
                </form>
                @else
                    <div class="bg-white py-2 rounded text-center">
                        <p class="font-weight-bold text-success mb-0" style="font-size: 18px;">تم ارسال رسالتك بنجاح - سيقوم فريقنا بمراجعتها والرد عليها في أقرب وقت ممكن</p>
                    </div>
                @endif
            </div>
            <!-- Sidebar Column -->
            @include('site.static_sidebar')

        </div>
    </div>
@endsection

@section('script')
@endsection
