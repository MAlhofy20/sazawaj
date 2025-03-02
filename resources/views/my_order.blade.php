@extends('master')
@section('title') {{Translate('طلباتي')}} @endsection
@section('style')
@endsection

@section('content')
    <!--  banner  -->
    <div id="contact-section" class="container">
        <section class="banner">
            <div class="row">
                <div class="col-md-6">
                    <div class="banner-img">
                        <img src="{{ url('' . settings('search_photo')) }}" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="banner-item">
                        <h5 class="banner-tit">
                            {{Translate('البحث عن طلب')}}
                        </h5>
                        <div class="banner-url">
                            <form action="{{route('get_order')}}" method="get">
                                @csrf
                                <input type="text" class="form-control" name="order_number" id="order_number" placeholder="{{Translate('رقم الطلب')}}" style="margin-bottom: 10px">
                                <button class="form-control main-btn">
                                    {{Translate('البحث')}}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--  banner  -->

    <!--  partners  -->
    <section id="order-section" class="partners">
            <div class="container">
                <h2 class="section-tit text-center">

                </h2>
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{Translate('رقم الطلب')}}</th>
                                    <th>{{Translate('الصورة')}}</th>
                                    <th>{{Translate('الاسم')}}</th>
                                    <th>{{Translate('رقم الجوال')}}</th>
                                    <th>{{Translate('رقم الهوية')}}</th>
                                    <th>{{Translate('تاريخ الميلاد')}}</th>
                                    <th>{{Translate('طريقة الحجز')}}</th>
                                    <th>{{Translate('نوع الطلب')}}</th>
                                    <th>{{Translate('طريقة الدفع')}}</th>
                                    <th>{{Translate('الاجمالي قبل الخصم')}}</th>
                                    <th>{{Translate('الاجمالي بعد الخصم')}}</th>
                                    <th>{{Translate('حالة الطلب')}}</th>
                                    <th>{{Translate('تاريخ الطلب')}}</th>
                                    <th>
                                        {{--{{Translate('الملفات المرفقة')}}--}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>
                                        <a href="{{url(''.$order->file)}}" target="_blank">{{Translate('عرض')}}</a>
                                    </td>
                                    <td>{{$order->name}}</td>
                                    <td>{{$order->phone}}</td>
                                    <td>{{$order->id_number}}</td>
                                    <td>{{$order->birthdate}}</td>
                                    @php
                                        $payment  = [
                                            "now" => Translate('حجز الآن'),
                                            "later" => Translate('حجز في وقت لاحق'),
                                            "online" => Translate('الدفع اونلاين'),
                                            "cash" => Translate('الدفع كاش'),
                                            "point" => Translate('نقاط بيع'),
                                        ];
                                        $type  = [
                                            "issuance" => Translate('إصدار'),
                                            "renewal" => Translate('تجديد')
                                        ];
                                    @endphp
                                    <td>
                                        <p>{{isset($payment[$order->booking_method]) ? $payment[$order->booking_method] : Translate('حجز الآن')}}</p>
                                        @if(!empty($order->booking_later_date)) <p>{{date('Y-m-d', strtotime($order->booking_later_date))}}</p> @endif
                                    </td>
                                    <td>{{isset($type[$order->type]) ? $type[$order->type] : Translate('إصدار')}}</td>
                                    <td>{{isset($payment[$order->payment_method]) ? $payment[$order->payment_method] : Translate('كاش')}}</td>
                                    <td>{{$order->total_before_promo}}</td>
                                    <td>{{$order->total_after_promo}}</td>
                                    <td>{{order_status($order->status)}}</td>
                                    <td>{{ Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        @foreach($order->files as $file)
                                            <p>
                                                <span>{{$file->title}}</span>
                                                <a href="{{url('static-show-order/' . $file->id)}}" target="_blank">({{Translate('عرض')}})</a>
                                            </p>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    <!--  partners  -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Replace 'section2' with the ID of the section you want to scroll to
            var targetSection = $('#order-section');

            // Animate scrolling to the target section
            $('html, body').animate({
                scrollTop: targetSection.offset().top
            }, 1000); // Adjust the duration as needed
        });
    </script>
@endsection