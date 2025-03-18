@extends('site.master')
@section('title') تفاصيل الباقة @endsection
@section('style')
@endsection

@section('content')
    <div class="container">
        <div class="membership-info ">
            <div class="container">
                <div class="membership-info mt-5 mb-5 mr-5 ml-5">
                    <div class="membership-header">
                        <h1><span class="star"></span> تقرير العضوية </h1>
                    </div>

                    @if(auth()->check() && !is_null(auth()->user()->package_date) && !Carbon\Carbon::parse(auth()->user()->package_end_date)->isPast())
                        <div class="membership-details">
                            <h2>تاريخ العضوية</h2>
                            <p>
                                تاريخ بداية الباقة:
                                <span>{{is_null(auth()->user()->package_date) ? '' : date('d-m-Y', strtotime(auth()->user()->package_date))}}</span>
                            </p>
                            <p>
                                تاريخ انتهاء الباقة:
                                <span>{{is_null(auth()->user()->package_end_date) ? '' : date('d-m-Y', strtotime(auth()->user()->package_end_date))}}</span>
                            </p>
                            <p>
                                عدد الايام على انتهاء الباقة:
                                <span>{{is_null(auth()->user()->package_end_date) ? '' : Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse(auth()->user()->package_end_date))}}</span>
                                <span>يوم</span>
                            </p>
                        </div>
                    @endif

                    <div class="financial-details">
                        <h2>{{$package->title_ar}}</ا2>
                        <div class="<!--desc-->">{!! $package->desc_ar !!}</div>
                    </div>

                    <!-- <div class="important-note">
                        <p class="note-header">طرق الدفع:</p>
                        <p class="note-content">لاستفسار آخر: إذا كان الشخص مشترك، يمكنه الاتصال بالموقع لمزيد من التفاصيل. إذا كان المستخدم لا يمكنه دفع المبلغ في الوقت المحدد، يجب التواصل مع الإدارة لتحديد مواعيد دفع بديلة.</p>
                    </div> -->

                    <div class="instructions">
                        <p class="instructions-text">
                            لمراجعة الباقات <a href="{{ url('all_packages') }}">اضغط هنا</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
        </div>
@endsection
