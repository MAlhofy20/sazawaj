@extends('site.master')
@section('title') الباقات @endsection
@section('style')
    <style>
        .dim{
            opacity: 0.5;
        }
    </style>
@endsection

@section('content')
    <!--  welcome  -->
    {{--<section class="welcome">
        <div class="welcome-img">
            <img src="{{ site_path() }}/assets/img/welcome.png" alt="">
        </div>
        <p class="welcome-tit">أهلاً بكم في موقع {{ settings('site_name') }}</p>
    </section>--}}
    <!--  //welcome  -->

    <section class="new-members">
        <div class="container">
            <h2 class="sec-tit text-center">
                الباقات
            </h2>
            <div class="row justify-content-center">
                @forelse($data as $item)
                    <div class="col-md-5 text-center {{ auth()->user()->package_id === $item->id ? 'dim' : '' }} " data-wow-delay="0.2s">
                        <div class="package-items">


                        <h3>{{$item->title_ar}}</h3>
                        <hr>
                        <div class="<!--desc-->">{!! $item->desc_ar !!}</div>
                        <hr>
                        <span>{{$item->price_with_value}} <spa>ريال</spa></span>
                        <hr>
                        <a href="{{ auth()->user()->package_id === $item->id ? '#' : url('subscripe_package/' . $item->id) }}" 
                           class="btn btn-info {{ auth()->user()->package_id === $item->id ? 'disabled' : '' }}">
                            اشتراك
                        </a>
                        </div>
                    </div>

                @empty
                    <div class="col-lg-auto col-md-12 col-12 wow bounceInRight" data-wow-delay="0.2s">
                        <div class="package-items-nofound">
                            <h4 style="color: red"> لا يوجد نتائج </h4>

                        </div>
                    </div>
                @endforelse
            </div>
            <!-- package Modal -->
            @if(auth()->user()->gender !='female' && auth()->user()->package_id === 3)
            <div class="modal fade" id="upgradeModal" tabindex="-1" aria-labelledby="upgradeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="upgradeModalLabel">ترقية الباقة</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            أنت الآن علي باقة 3 اشهر، يرجى الترقية إلى باقة أعلى لأستخدام ميزة الرسائل الصوتية.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Script to Auto Open Modal -->
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var upgradeModal = new bootstrap.Modal(document.getElementById('upgradeModal'));
                    upgradeModal.show();
                });
            </script>
            @endif
        </div>
    </section>
@endsection