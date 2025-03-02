<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="description" content="{{ settings('description') }}">
    <meta name="keywords" content="{{ settings('key_words') }}">
    <meta name="author" content="Abdelrahman">
    <meta name="robots" content="index/follow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1,, shrink-to-fit=no, maximum-scale=1, user-scalable=no">
    <meta name="HandheldFriendly" content="true">
    <meta property="og:title" content="{{ settings('site_name') }}" />
    <meta property="og:image" content="{{ url('' . settings('logo')) }}" />
    <meta property="og:description" content="{{ settings('site_name') }}" />
    <meta property="og:site_name" content="{{ settings('site_name') }}" />
    <link rel="shortcut icon" type="image/png" href="{{ static_path() }}/images/favicon.jpg" />
    <title>{{ settings('site_name') }} | الرئيسية</title>

    <link rel="stylesheet" href="{{ static_path() }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ static_path() }}/css/font-awesome-5all.css">
    <link rel="stylesheet" href="{{ static_path() }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ static_path() }}/css/style.css">
</head>

<body>
<main class="warp">


    <section class="nav-overlay"></section>

    <section class="mobile-nav-list">
        <a class="mobile-logo text-center" href="/">
            <img src="{{ url('' . settings('logo')) }}">
        </a>

        <ul class="mobile-list list-unslyled">



        </ul>

    </section>


    <header class="home-head">
        <div class="container">
            <div class="main-nav">
                <a class="menu-logo" href="/">
                    <img src="{{ url('' . settings('logo')) }}">
                </a>
                {{--<ul class="nav-list">



                </ul>
                <button class="nav-btn">
                    <i class="fas fa-bars"></i>
                </button>--}}
            </div>
        </div>
    </header>


    <div class="body-wrap">


        <section id="about" class="about">

            <div class="container">
                <div class="row align-items-center">

                    <div class="col-md-12">

                        <h3 class="sec-tit">{!! $page->title !!}</h3>
                        <div class="about-des">
                            {{--
                            نهتمّ بخصوصيتك. تهدف سياسة الخصوصية هذه إلى مساعدتك على فهم ما المعلومات التي نجمع ولأي سبب نجمعها وكيف يمكنك تدبير معلوماتك.

                            في سياسة الخصوصية هذه، يشير مصطلح "المعلومات الشخصية" إلى المعلومات التي تقدمها لنا والتي تحدد هويتك الشخصية، مثل اسمك أو معرّف الجهاز أو عنوان البريد الإلكتروني أو موقعك الجغرافي.
                            كما نستخدم معلوماتك للتواصل معك عن طريق إرسال رسائل تحتوي على معلومات حول التحديثات أو العروض الترويجية أو الأخبار المتعلقة بالتطبيق.
                            أثناء تقديم لخدمات سبق أن سجّلت الموقع وأنت استخدمت تلك الخدمات، يمكن لـ جمع بيانات موقعك ومعالجتها لتقديم خدمات تستند إلى ذلك الموقع. لا يمكن الوصول إلى موقعك بناءً على نظام التموضع العالمي (GPS) دون موافقتك.

                            قد تستخدم  معلومات موقع مجهول (من المستحيل ربطها بالمستخدمين) لإتاحتها لشركائها أو لأي طرف ثالث آخر فمثلاً على سبيل المثال يمكنها توفير معلومات GPS (الموقع والسرعة ودقة إشارة الـ GPS والعنوان والتاريخ والوقت) والتي تتلقاها من الجوال الخاص بك وذلك لإرسالها لشركات الملاحة ومشغلي شبكات الجوال وشركات المرور ومحرري الخرائط في شكل مجمع أو مجهول وذلك لمساعدتهم على تحسين خدماتهم وأيضاً علي حل المشاكل التقنية التي يواجهونها أو التي قد تنشأ طالما أن تجعل الموقع متاحًا لأطراف ثالثة وفقًا لسياسة الخصوصية هذه لذلك فسوف يتم توفيره دائمًا بطريقة مجهولة.
                            تستخدم جميع المعلومات التي يتم جمعها للحفاظ على جودة الخدمة المقدّمة وتحسينها.
                            لا نقوم تحت أي ظرف من الظروف ببيع البيانات المجمّعة ولا نشاركها مع أطراف ثالثة إلا إذا استلزم القانون ذلك.

                            عند تثبيت التطبيق على جهازك، يجمع التطبيق معلومات مجهولة الاسم حول استخدامه ومعلومات حول الجهاز المثبت عليه. على سبيل المثال: معدّل استخدام التطبيق ووقت الاستخدام ونوع وطراز الجهاز والمعرّفات الفريدة واللغة وإصدار نظام التشغيل واستخدام البطارية وعنوان IP. ونقوم أيضًا بجمع معلومات مجهولة الاسم حول تقارير الأخطاء والأداء.

                            استخدام هذا التطبيق يقتضي:

                            أنك تقبل المخاطر التي قد تنشأ نتيجة لاستخدام هذا التطبيق.
                            أنك تقبل العواقب التي قد تنتج عن استخدام أي من الخدمات التي قد يوفرها هذا التطبيق بغض النظر عن الوظيفة والغرض من استخدامها.
                            أنك تقبل المسؤولية عن أي فعل قد يحدث ويترتّب عليه ضرر للمستخدم أو لطرف ثالث.
                            أنك تعفي التطبيق من أي مسؤولية عن النتائج السلبية أو العواقب غير المرجوّة التي قد تترتّب عنها مخالفة أو جنحة من أي نوع.
                            أنك مسؤول عن أي استخدام غير قانوني قد تقوم به مع التطبيق وتترتّب عنه أي مخالفة للقواعد أو القانون.
                            --}}
                            {!! $page->desc !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="social-media text-center">
            <div class="container">
                <div class="social-media-icons mb-5">
                    <a href="{{ settings('facebook') }}"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ settings('twitter') }}"><i class="fab fa-twitter"></i></a>
                    <a href="{{ settings('instagram') }}"><i class="fab fa-instagram"></i></a>
                    <a href="{{ settings('linkedin') }}"><i class="fab fa-linkedin-in"></i></a>
                </div>

                <div class="maroof-logo">
                    <a href="{{ settings('maroof') }}"><img class="img-fluid"
                                                            src="{{ static_path() }}/images/maroof.png"></a>
                </div>


            </div>

        </section>

        <footer>
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-auto">
                        <div class="site-copyright">
                            جميع الحقوق محفوظة {{ settings('site_name') }}
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <div class="efadh-copyright">
                            تصميم وتطوير
                            <a href="https://efadh.com">
                                شركة أفادة لتقنية المعلومات
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</main>

<script src="{{ static_path() }}/js/jquery-3.2.1.min.js"></script>
<script src="{{ static_path() }}/js/popper.min.js"></script>
<script src="{{ static_path() }}/js/bootstrap.min.js"></script>
<!--<script src="{{ static_path() }}/js/jquery-ui.js"></script>-->
<script src="{{ static_path() }}/js/owl.carousel.min.js"></script>
<script src="{{ static_path() }}/js/scrollreveal.min.js"></script>
<script src="{{ static_path() }}/js/plugin.js"></script>
<script src="{{ url('/public/notify.js') }}"></script>
</body>

</html>
