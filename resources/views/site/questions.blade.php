@extends('site.master')
@section('title')
    الأسئلة المتداولة
@endsection

@section('meta')
    @include('meta::manager', [
        'title' => settings('site_name')  . ' - الأسئلة المتداولة',
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

        .card {
            background-color: #ede2ab;
        }

        .card-body {
            padding: 20px 20px 5px 20px;
        }

        .collapse.show {
            background-color: #96883c;
            color: white;
        }

        .exclamation-icon {

            font-size: 48px;
            color: #005c70;
            font-weight: bold;
            line-height: 1;
        }

        .faq-header {
            font-weight: bold;
            color: #177082;
            cursor: pointer;
        }

        .faq-question {
            background-color: #f9f9f9;
            margin: 5px 0;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .faq-answer {
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ccc;
            margin-top: 5px;
            border-radius: 5px;
        }

        .collapse {
            transition: none !important;
        }


        .faq-section .mb-0>a {
            display: block;
            position: relative;
        }

        /*.faq-section .mb-0 > a:after {*/
        /*    content: "\f067";*/
        /*    font-family: "Font Awesome 5 Free";*/
        /*    position: absolute;*/
        /*    left: 0;*/
        /*    font-weight: 600;*/
        /*}*/

        /*.faq-section .mb-0 > a.collapsed:after {*/
        /*     content: "\f068";*/
        /*    font-family: "Font Awesome 5 Free";*/
        /*    font-weight: 600;*/
        /*}*/
        .card-header a {
            color: var(--balck);
        }

        .card-header {
            background-color: var(--forth);
            border-bottom: 1px solid var(--black);
        }

        .toggle-icon .icon {
            font-weight: bold;
            margin-right: 10px;
            transition: transform 0.3s ease;
            float: left;
        }

        .toggle-icon[aria-expanded="true"] .icon {
            color: #000;
            /* لون العلامة في حالة الفتح */
        }

        .Qtitle {
            font-size: 130%;
            font-weight: bold;
            color: #177082;
        }
    </style>
@endsection

@section('content')
<div class="d-flex justify-content-center my-4">
    <div class="page-title">
        <i class="fas fa-question-circle icon"></i>
        <span class="title-text">الأسئلة المتداولة</span>
        <div class="underline"></div>
    </div>
</div>

    <div class="container">
        <div class="row">
            <!-- FAQ Content -->
            <div class="col-md-9 content">
                <!-- FAQ Section 1 -->
                <div class="card">

                    <div class="card-body ">
                        <div class="flex flex-column mt-0 faq-section">
                            <div id="accordion">
                                <h2 class="Qtitle position-relative mt-0 mr-2 mb-2">
                                    التسجيل
                                </h2>
                                @foreach (App\Models\Common_question::where('type', 'التسجيل')->get() as $i => $item)
                                    <div class="card">
                                        <div class="card-header" id="heading-{{ $i + 1 }}">
                                            <h5 class="mb-0">
                                                <a role="button" class="toggle-icon" data-toggle="collapse"
                                                    href="#collapse-{{ $i + 1 }}" aria-expanded="false"
                                                    aria-controls="collapse-{{ $i + 1 }}">
                                                    <span class="icon">+</span> {{ $item->title }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapse-{{ $i + 1 }}" class="collapse" data-parent="#accordion"
                                            aria-labelledby="heading-{{ $i + 1 }}">
                                            <div class="card-body">
                                                {!! $item->desc !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                    <div class="card-body ">
                        <div class="flex flex-column faq-section">
                            <div id="accordion">
                                <h2 class="Qtitle position-relative  mr-2 mb-2">
                                    الاشتراكات والباقات
                                </h2>
                                @foreach (App\Models\Common_question::where('type', 'الاشتراكات والباقات')->get() as $i => $item)
                                    <div class="card">
                                        <div class="card-header" id="heading2-{{ $i + 1 }}">
                                            <h5 class="mb-0">
                                                <a role="button" class="toggle-icon" data-toggle="collapse"
                                                    href="#collapse2-{{ $i + 1 }}" aria-expanded="false"
                                                    aria-controls="collapse2-{{ $i + 1 }}">
                                                    <span class="icon">+</span> {{ $item->title }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapse2-{{ $i + 1 }}" class="collapse" data-parent="#accordion"
                                            aria-labelledby="heading2-{{ $i + 1 }}">
                                            <div class="card-body">
                                                {!! $item->desc !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="flex flex-column faq-section">
                            <div id="accordion">
                                <h2 class="Qtitle position-relative mr-2 mb-2">
                                    البحث والتواصل مع الأعضاء
                                </h2>
                                @foreach (App\Models\Common_question::where('type', 'البحث والتواصل مع الأعضاء')->get() as $i => $item)
                                    <div class="card">
                                        <div class="card-header" id="heading3-{{ $i + 1 }}">
                                            <h5 class="mb-0">
                                                <a role="button" class="toggle-icon" data-toggle="collapse"
                                                    href="#collapse3-{{ $i + 1 }}" aria-expanded="false"
                                                    aria-controls="collapse3-{{ $i + 1 }}">
                                                    <span class="icon">+</span> {{ $item->title }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapse3-{{ $i + 1 }}" class="collapse" data-parent="#accordion"
                                            aria-labelledby="heading3-{{ $i + 1 }}">
                                            <div class="card-body">
                                                {!! $item->desc !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="flex flex-column faq-section">
                            <div id="accordion">
                                <h2 class="Qtitle position-relative mr-2 mb-2">
                                    الأمان والخصوصية
                                </h2>
                                @foreach (App\Models\Common_question::where('type', 'الأمان والخصوصية')->get() as $i => $item)
                                    <div class="card">
                                        <div class="card-header" id="heading4-{{ $i + 1 }}">
                                            <h5 class="mb-0">
                                                <a role="button" class="toggle-icon" data-toggle="collapse"
                                                    href="#collapse4-{{ $i + 1 }}" aria-expanded="false"
                                                    aria-controls="collapse4-{{ $i + 1 }}">
                                                    <span class="icon">+</span> {{ $item->title }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapse4-{{ $i + 1 }}" class="collapse" data-parent="#accordion"
                                            aria-labelledby="heading4-{{ $i + 1 }}">
                                            <div class="card-body">
                                                {!! $item->desc !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="flex flex-column faq-section">
                            <div id="accordion">
                                <h2 class="Qtitle position-relative mr-2 mb-2">
                                    الإبلاغ عن المشكلات والدعم الفني
                                </h2>
                                @foreach (App\Models\Common_question::where('type', 'الإبلاغ عن المشكلات والدعم الفني')->get() as $i => $item)
                                    <div class="card">
                                        <div class="card-header" id="heading5-{{ $i + 1 }}">
                                            <h5 class="mb-0">
                                                <a role="button" class="toggle-icon" data-toggle="collapse"
                                                    href="#collapse5-{{ $i + 1 }}" aria-expanded="false"
                                                    aria-controls="collapse5-{{ $i + 1 }}">
                                                    <span class="icon">+</span> {{ $item->title }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapse5-{{ $i + 1 }}" class="collapse"
                                            data-parent="#accordion" aria-labelledby="heading5-{{ $i + 1 }}">
                                            <div class="card-body">
                                                {!! $item->desc !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="flex flex-column faq-section">
                            <div id="accordion">
                                <h2 class="Qtitle position-relative mr-2 mb-2">
                                    إدارة الحساب
                                </h2>
                                @foreach (App\Models\Common_question::where('type', 'إدارة الحساب')->get() as $i => $item)
                                    <div class="card">
                                        <div class="card-header" id="heading6-{{ $i + 1 }}">
                                            <h5 class="mb-0">
                                                <a role="button" class="toggle-icon" data-toggle="collapse"
                                                    href="#collapse6-{{ $i + 1 }}" aria-expanded="false"
                                                    aria-controls="collapse6-{{ $i + 1 }}">
                                                    <span class="icon">+</span> {{ $item->title }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapse6-{{ $i + 1 }}" class="collapse"
                                            data-parent="#accordion" aria-labelledby="heading6-{{ $i + 1 }}">
                                            <div class="card-body">
                                                {!! $item->desc !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="flex flex-column faq-section">
                            <div id="accordion">
                                <h2 class="Qtitle position-relative mr-2 mb-2">
                                    استفسارات أخرى
                                </h2>
                                @foreach (App\Models\Common_question::where('type', 'استفسارات أخرى')->get() as $i => $item)
                                    <div class="card">
                                        <div class="card-header" id="heading7-{{ $i + 1 }}">
                                            <h5 class="mb-0">
                                                <a role="button" class="toggle-icon" data-toggle="collapse"
                                                    href="#collapse7-{{ $i + 1 }}" aria-expanded="false"
                                                    aria-controls="collapse7-{{ $i + 1 }}">
                                                    <span class="icon">+</span> {{ $item->title }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapse7-{{ $i + 1 }}" class="collapse"
                                            data-parent="#accordion" aria-labelledby="heading7-{{ $i + 1 }}">
                                            <div class="card-body">
                                                {!! $item->desc !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>


                    <div class="card-body">
                        <div class="flex flex-column faq-section">
                            <div id="accordion">
                                <h2 class="Qtitle position-relative mr-2 mt-3 mb-5">
                                    إذا كان لديك أي استفسارات إضافية لم يتم تغطيتها في الأقسام السابقة
                                    فلا تتردد في
                                    <a href="/contact-us/contact">التواصل معنا</a>
                                </h2>
                            </div>
                        </div>
                    </div>



                </div>






            </div>

            @include('site.static_sidebar')


        </div>
        <script>
            document.querySelectorAll('.toggle-icon').forEach(link => {
                link.addEventListener('click', function() {
                    const icon = this.querySelector('.icon');
                    if (this.getAttribute('aria-expanded') === "true") {
                        icon.textContent = "+";
                    } else {
                        icon.textContent = "-";
                    }
                });
            });
        </script>
    </div>
@endsection
