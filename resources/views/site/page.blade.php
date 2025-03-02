@extends('site.master')
@section('title'){!! isset($page) ? $page->title_ar : '' !!}@endsection
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




        .faq-section .mb-0 > a {
            display: block;
            position: relative;
        }

        .faq-section .mb-0 > a:after {
            content: "\f067";
            font-family: "Font Awesome 5 Free";
            position: absolute;
            left: 0;
            font-weight: 600;
        }

        .faq-section .mb-0 > a[aria-expanded="true"]:after {
            content: "\f068";
            font-family: "Font Awesome 5 Free";
            font-weight: 600;
        }
        .card-header a{
            color: var(--balck);
        }
        .card-header{
            background-color: var(--forth);
            border-bottom: 1px solid var(--black);
        }

    </style>
@endsection

@section('content')
    @if(!auth()->check())
        <section class="welcome">
            <div class="welcome-img">
                <img src="{{ site_path() }}/assets/img/welcome.png" alt="">
            </div>
            <p class="welcome-tit">أهلاً بكم في موقع {{ settings('site_name') }}</p>
        </section>
    @endif
    
    <div class="d-flex justify-content-center my-4">
    <div class="page-title">
        @if($page->title_ar == 'نصائح واقتراحات') 
        <i class="fas fa-lightbulb icon"></i>
         @elseif($page->title_ar == 'إرشادات الأمان') 
         <i class="fas fa-shield-alt icon"></i>
          @elseif($page->title_ar == 'شروط الإستخدام') 
          <i class="fas fa-file-contract icon"></i>
          @elseif($page->title_ar == 'سياسة الخصوصية') 
           <i class="fas fa-lock icon"></i>
           @else
           @endif
        <span class="title-text">{!! isset($page) ? $page->title_ar : '' !!}</span>
        <div class="underline"></div>
    </div>
</div>

    
   <div class="container">
    <div class="row">
        <!-- FAQ Content -->
        <div class="col-md-9 content">
            <!-- FAQ Section 1 -->
            <div class="card">
                <div class="card-body">
                    <div class="flex flex-column mb-5 mt-4 faq-section">
                        {{--<h1 class="sec-tit">
                            {!! isset($page) ? $page->title_ar : '' !!}
                        </h1>--}}
                        <div class="about-content">
                            {!! isset($page) ? $page->desc_ar : '' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('site.static_sidebar')
    </div>
</div>

<!-- Add Custom Styles for Better Mobile Support -->
<style>
    /* General Content Styling */
    .about-content {
        font-size: 1.1rem; /* Adjust font size */
        line-height: 1.6; /* Increase line height for readability */
        word-break: break-word; /* Ensure that long words break and wrap properly */
        word-wrap: break-word; /* Allow words to wrap within their container */
        white-space: normal; /* Allow line breaks between words */
    }

    /* Adjust content and layout on mobile screens */
    @media (max-width: 768px) {
        .about-content {
            font-size: 1rem; /* Slightly smaller text for mobile */
            padding: 15px; /* Add padding around content */
            text-align: justify; /* Justify text for better readability */
        }

        .container {
            padding-left: 10px;
            padding-right: 10px;
        }

        .card-body {
            padding: 15px;
        }

        /* Adjust column widths on small screens */
        .col-md-9 {
            width: 100%; /* Make the content take full width on small screens */
            padding-left: 0;
            padding-right: 0;
        }

        .col-md-3 {
            display: none; /* Hide the sidebar on small screens */
        }
    }

    /* For very small screens (extra small phones) */
    @media (max-width: 480px) {
        .about-content {
            font-size: 0.9rem; /* Even smaller text on very small screens */
            padding: 10px; /* Reduce padding for smaller screens */
        }

        .container {
            padding-left: 5px;
            padding-right: 5px;
        }

        .card-body {
            padding: 10px; /* Reduce card padding */
        }
    }
</style>


    <!-- about -->
    {{--<section class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="sec-tit">
                        {!! isset($page) ? $page->title_ar : '' !!}
                    </h1>
                    <div class="about-content">
                        {!! isset($page) ? $page->desc_ar : '' !!}
                    </div>
                </div>
                --}}{{--<div class="col-lg-5">
                    <div class="about-img">
                        <img src="{{ site_path() }}/assets/img/about.png" alt="">
                    </div>
                </div>--}}{{--
            </div>
        </div>
    </section>--}}
    <!-- //about -->
@endsection

@section('script')
@endsection