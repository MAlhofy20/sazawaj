@extends('site.master')
@section('title') الطلب @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content page-print-machine">
        <div class="container-fluid">

            <!-- Timelime example  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <div class="timeline">
                    @if($order->orders->count() == 0)
                        <!-- timeline item -->
                            <div>
                                <i class="fas fa-info bg-blue"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">تفاصيل الطلب</h3>

                                    <div class="timeline-body">
                                        <div class="bill-info provider-info text-center">
                                            <img class=" " src="{{!is_null($order->provider) ? url('' . $order->provider->avatar) : url('public/none.png')}}" alt="" width="100px" height="100px">

                                            <h3> <span>  اسم الفرع :  </span> <span> {{!is_null($order->provider) ? $order->provider->name : $order->provider_name}} </span> </h3>
                                            <?php $city = !is_null($order->provider) ? App\Models\City::whereId($order->provider->city_id)->first() : null; ?>
                                            <h5>المدينة : {{!is_null($order->provider) && isset($city) ? $city->title_ar     : ''}}</h5>

                                        </div>
                                        <div class="bill-info">
                                            <ul>
                                                <li class="text-bold">
                                                    <span>رقم الطلب</span>
                                                    <span>:</span>
                                                    <span>{{$order->id}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <span>حالة الطلب</span>
                                                    <span>:</span>
                                                    <span>{{order_status($order->status)}}</span>
                                                </li>
                                                {{-- <li>
                                                    <span>أسم الفرع</span>
                                                    <span>:</span>
                                                    <span>{{!is_null($order->provider) ? $order->provider->name : $order->provider_name}}</span>
                                                </li> --}}
                                                <li>
                                                    <span>أسم العميل</span>
                                                    <span>:</span>
                                                    <span>{{!is_null($order->user) ? $order->user->name : $order->user_name}}</span>
                                                </li>
                                                <li>
                                                    <span>جوال العميل</span>
                                                    <span>:</span>
                                                    <span>{{!is_null($order->user) ? $order->user->phone : $order->user_phone}}</span>
                                                </li>
                                                <li>
                                                    <span>اسم الفرع</span>
                                                    <span>:</span>
                                                    <span>{{!is_null($order->provider) ? $order->provider->name : $order->provider_name}}</span>
                                                </li>
                                                <li>
                                                    <span>جوال الفرع</span>
                                                    <span>:</span>
                                                    <span>{{!is_null($order->provider) ? $order->provider->phone : $order->provider_phone}}</span>
                                                </li>
                                                @if($order->type == 'delivery' && in_array($order->status, ['in_way', 'finish']))
                                                    <li>
                                                        <span>اسم المندوب</span>
                                                        <span>:</span>
                                                        <span>{{!is_null($order->delegate) ? $order->delegate->name : $order->delegate_name}}</span>
                                                    </li>
                                                    <li>
                                                        <span>جوال المندوب</span>
                                                        <span>:</span>
                                                        <span>{{!is_null($order->delegate) ? $order->delegate->phone : $order->delegate_phone}}</span>
                                                    </li>
                                                @endif
                                                <li>
                                                    <span>تاريخ الطلب </span>
                                                    <span>:</span>
                                                    <span>{{date('Y-m-d h:i a' , strtotime($order->created_at))}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <?php $payment  = ["cash" => "كاش", "transfer" => "تحويل بنكي", "online" => "اون لاين" , "not_now" => "الدفع اجلا"]; ?>
                                                    <span>طريقة الدفع</span>
                                                    <span>:</span>
                                                    <span>{{isset($payment[$order->payment_method]) ? $payment[$order->payment_method] : 'كاش'}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <span>ملاحظات الطلب</span>
                                                    <span>:</span>
                                                    <span>{{$order->notes}}</span>
                                                </li>
                                                {{--<li>
                                                    <span>موقع العميل</span>
                                                    <span>:</span>
                                                    <span><a href="https://www.google.com/maps/?q={{$order->lat}},{{$order->lng}}" target="_blanck">عرض</a></span>
                                                </li>
                                                <li>
                                                    <span>موقع الفرع</span>
                                                    <span>:</span>
                                                    <span><a href="https://www.google.com/maps/?q={{!is_null($order->provider) ? $order->provider->lat : $order->provider_lat}},{{!is_null($order->provider) ? $order->provider->lng : $order->provider_lng}}" target="_blanck">عرض</a></span>
                                                </li>--}}
                                                {{--<li>
                                                    <span>موقع المندوب</span>
                                                    <span>:</span>
                                                    <span><a href="https://www.google.com/maps/?q={{!is_null($order->delegate) ? $order->delegate->lat : 0}},{{!is_null($order->delegate) ? $order->delegate->lng : 0}}" target="_blanck">عرض</a></span>
                                                </li>--}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            {{--<div class="products-with-not-thumb">
                                <i class="fas fa-list bg-yellow"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">المنتجات</h3>
                                    <div class="timeline-body">
                                        @foreach($order->order_items as $service)
                                            <p>
                                                عدد    {{$service->count}} --}}{{--{{!is_null($service->service) ? $service->service->unit : ''}}--}}{{-- من  {{!is_null($service->service) ? $service->service->title_ar : $service->service_title_ar}} بـ {{round($service->total, 2)}} ريال
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>--}}
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            <div class="products-with-thumb">
                                <i class="fas fa-list bg-yellow"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">المنتجات</h3>
                                    <div class="timeline-body">
                                        @foreach ($order->order_items as $item)
                                            <div class="order-item">
                                                {{--<div class="img">
                                                    <div class="img-c">
                                                        <a data-fancybox data-caption="{{!is_null($item->service) ? $item->service->title_ar : $item->service_title_ar}}"
                                                           href="{{!is_null($item->service) && $item->service->images->count() > 0 ? url('' . $item->service->images->first()->image) : url('/public/none.png')}}">
                                                            <img class=" " src="{{!is_null($item->service) && $item->service->images->count() > 0 ? url('' . $item->service->images->first()->image) : url('/public/none.png')}}" alt="...">
                                                        </a>
                                                        <span class="count">{{$item->count}}</span>
                                                    </div>
                                                    <span class="order-name">{{!is_null($order->service) ? $order->service->title_ar : $order->service_title_ar}}</span>
                                                </div>--}}
                                                <div class="item-price">
                                                    <span> {{!is_null($item->service) ? $item->service->title_ar : $item->service_title_ar}}</span>
                                                    @if(!is_null($item->size_title) && !is_null($item->option_title))
                                                        <p>({{(string) $item->size_title}} , {{(string) $item->option_title}})</p>
                                                    @endif
                                                </div>
                                                <div class="item-total">
                                                    <span> {{round($item->total / $item->count, 2)}} (ريال)  * {{$item->count}}  {{!is_null($item->service) ? '(عدد)' : ''}}</span>
                                                </div>
                                                <div class="item-total">
                                                    <span> {{round($item->total, 2)}} (ريال) </span>
                                                </div>
                                                <div class="item-total">
                                                    <span> {{$item->notes}} </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- END timeline item -->
                    @else

                        <!-- timeline item -->
                            <div>
                                <i class="fas fa-info bg-blue"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">تفاصيل الطلب</h3>

                                    <div class="timeline-body">
                                        <div class="bill-info">
                                            <ul>
                                                <li class="text-bold">
                                                    <span>رقم الطلب</span>
                                                    <span>:</span>
                                                    <span>{{$order->id}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <span>حالة الطلب</span>
                                                    <span>:</span>
                                                    <span>{{order_status($order->status)}}</span>
                                                </li>
                                                <li>
                                                    <span>أسم العميل</span>
                                                    <span>:</span>
                                                    <span>{{!is_null($order->user) ? $order->user->name : $order->user_name}}</span>
                                                </li>
                                                <li>
                                                    <span>جوال العميل</span>
                                                    <span>:</span>
                                                    <span>{{!is_null($order->user) ? $order->user->phone : $order->user_phone}}</span>
                                                </li>
                                                @if($order->type == 'delivery' && in_array($order->status, ['in_way', 'finish']))
                                                    <li>
                                                        <span>اسم المندوب</span>
                                                        <span>:</span>
                                                        <span>{{!is_null($order->delegate) ? $order->delegate->name : $order->delegate_name}}</span>
                                                    </li>
                                                    <li>
                                                        <span>جوال المندوب</span>
                                                        <span>:</span>
                                                        <span>{{!is_null($order->delegate) ? $order->delegate->phone : $order->delegate_phone}}</span>
                                                    </li>
                                                @endif
                                                <li>
                                                    <span>تاريخ الطلب </span>
                                                    <span>:</span>
                                                    <span>{{date('Y-m-d h:i a' , strtotime($order->created_at))}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <?php $payment  = ["cash" => "كاش", "transfer" => "تحويل بنكي", "online" => "اون لاين" , "not_now" => "الدفع اجلا"]; ?>
                                                    <span>طريقة الدفع</span>
                                                    <span>:</span>
                                                    <span>{{isset($payment[$order->payment_method]) ? $payment[$order->payment_method] : 'كاش'}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <span>ملاحظات الطلب</span>
                                                    <span>:</span>
                                                    <span>{{$order->notes}}</span>
                                                </li>
                                                {{--<li>
                                                    <span>موقع العميل</span>
                                                    <span>:</span>
                                                    <span><a href="https://www.google.com/maps/?q={{$order->lat}},{{$order->lng}}" target="_blanck">عرض</a></span>
                                                </li>
                                                <li>
                                                    <span>موقع الفرع</span>
                                                    <span>:</span>
                                                    <span><a href="https://www.google.com/maps/?q={{!is_null($order->provider) ? $order->provider->lat : $order->provider_lat}},{{!is_null($order->provider) ? $order->provider->lng : $order->provider_lng}}" target="_blanck">عرض</a></span>
                                                </li>--}}
                                                {{--<li>
                                                    <span>موقع المندوب</span>
                                                    <span>:</span>
                                                    <span><a href="https://www.google.com/maps/?q={{!is_null($order->delegate) ? $order->delegate->lat : 0}},{{!is_null($order->delegate) ? $order->delegate->lng : 0}}" target="_blanck">عرض</a></span>
                                                </li>--}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END timeline item -->

                        @foreach($order->orders as $order_item)
                            <!-- timeline item -->
                                <div>
                                    <i class="fas fa-info bg-blue"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header">الطلب الفرعي :  {{$order_item->id}}</h3>

                                        <div class="timeline-body">
                                            <div class="bill-info text-center">
                                                <img class=" " src="{{!is_null($order_item->provider) ? url('' . $order_item->provider->avatar) : url('public/none.png')}}" alt="" width="100px" height="100px">
                                                <h3>اسم الفرع : {{!is_null($order_item->provider) ? $order_item->provider->name : $order_item->provider_name}}</h3>
                                                <?php $city = !is_null($order_item->provider) ? App\Models\City::whereId($order_item->provider->city_id)->first() : null; ?>
                                                <h5>المدينة : {{!is_null($order_item->provider) && isset($city) ? $city->title_ar     : ''}}</h5>
                                            </div>
                                            {{--<div class="bill-info">
                                                <ul>
                                                    <li class="text-bold">
                                                        <span>رقم الطلب الفرعي</span>
                                                        <span>:</span>
                                                        <span>{{$order_item->id}}</span>
                                                    </li>
                                                </ul>
                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                {{--<div class="products-with-not-thumb">
                                    <i class="fas fa-list bg-yellow"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header">المنتجات</h3>
                                        <div class="timeline-body">
                                            @foreach($order_item->order_items as $service)
                                                <p>
                                                    عدد {{$service->count}} --}}{{--{{!is_null($service->service) ? $service->service->unit : ''}}--}}{{-- من  {{!is_null($service->service) ? $service->service->title_ar : $service->service_title_ar}} بـ {{round($service->total, 2)}} ريال
                                                </p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>--}}
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <div  class="products-with-thumb">
                                    <i class="fas fa-list bg-yellow"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header">المنتجات</h3>
                                        <div class="timeline-body">
                                            @foreach ($order_item->order_items as $item)
                                                <div class="order-item">
                                                    {{--<div class="img">
                                                        <div class="img-c">
                                                            <a data-fancybox data-caption="{{!is_null($item->service) ? $item->service->title_ar : $item->service_title_ar}}"
                                                               href="{{!is_null($item->service) && $item->service->images->count() > 0 ? url('' . $item->service->images->first()->image) : url('/public/none.png')}}">
                                                                <img class=" " src="{{!is_null($item->service) && $item->service->images->count() > 0 ? url('' . $item->service->images->first()->image) : url('/public/none.png')}}" alt="...">
                                                            </a>
                                                            <span class="count">{{$item->count}}</span>
                                                        </div>
                                                        <span class="order-name">{{!is_null($order->service) ? $order->service->title_ar : $order->service_title_ar}}</span>
                                                    </div>--}}
                                                    <div class="item-price">
                                                        <span> {{!is_null($item->service) ? $item->service->title_ar : $item->service_title_ar}}</span>
                                                        @if(!is_null($item->size_title) && !is_null($item->option_title))
                                                            <p>({{(string) $item->size_title}} , {{(string) $item->option_title}})</p>
                                                        @endif
                                                    </div>
                                                    <div class="item-total">
                                                        <span> {{round($item->total / $item->count, 2)}} (ريال)  * {{$item->count}}  {{!is_null($item->service) ? '(عدد)' : ''}}</span>
                                                    </div>
                                                    <div class="item-total">
                                                        <span> {{round($item->total, 2)}} (ريال) </span>
                                                    </div>
                                                    <div class="item-total">
                                                        <span> {{$item->notes}} </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                        @endforeach
                    @endif

                    <!-- timeline item -->
                        <div>
                            <i class="fas fa-wallet bg-purple"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">تفاصيل الفاتورة</h3>
                                <div class="timeline-body">
                                    <div class="bill-total">
                                        <p>
                                            <span>الاجمالي بدون ضريبة</span>
                                            <span>{{number_format($order->sub_total, 2)}}</span>
                                        </p>
                                        <p>
                                            <span>الضريبة 15%</span>
                                            <span>{{number_format($order->value_added, 2)}}</span>
                                        </p>
                                        <p>
                                            <span>سعر التوصيل</span>
                                            <span>{{number_format($order->delivery, 2)}}</span>
                                        </p>
                                        <p>
                                            <span>اجمالي الفاتورة</span>
                                            <span>{{number_format($order->total_after_promo + $order->delivery, 2)}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END timeline item -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.timeline -->

    </section>
    <!-- /.content -->
@endsection

@section('modal')
    <!-- confirm-del modal-->
    <div class="modal fade" id="notes-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ملاحظات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center" id="notes">

                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!--end confirm-del modal-->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>
@endsection
