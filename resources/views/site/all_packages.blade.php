@extends('site.master')
@section('title') الباقات @endsection
@section('style')
<style>
    .page-title {
        position: relative;
        color: #b72dd2;
        /* Main color */
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
        color: #2492a8;
        /* Secondary color */
        margin-left: 12px;
        /* Space for RTL */
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
        0% {
            left: -50%;
            opacity: 0.6;
        }

        50% {
            left: 50%;
            opacity: 1;
        }

        100% {
            left: 150%;
            opacity: 0.6;
        }
    }

    /* الأكثر طلبا Badge */
    .most-popular {
        position: absolute;
        top: 40px;
        left: 0px;
        background: #ff9800;
        /* Orange for highlight */
        color: white;
        font-size: 14px;
        font-weight: bold;
        padding: 5px 12px;
        border-radius: 5px;
        transform: rotate(-50deg);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Ensure the card has a relative position */
    .package-card {
        position: relative;
        width: 100%;
        background: #fff;
        border-radius: 12px;
        padding: 5px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        border: 2px solid #f1f1f1;
        overflow: hidden;
    }

    /* On hover, make it stand out */
    .package-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        border-color: #b72dd2;
    }



    /* Package Header */
    .package-header h3 {
        font-size: 20px;
        font-weight: bold;
        background: linear-gradient(to right, #b72dd2, #2492a8);
        color: white;
        padding: 12px;
        border-radius: 8px;
        display: inline-block;
        width: 100%;
    }

    /* Price Style */
    .package-price {
        font-size: 22px;
        font-weight: bold;
        color: #333;
        margin: 15px 0;
    }

    .package-price span {
        color: #b72dd2;
        font-size: 26px;
    }

    .package-features {
        font-size: 16px;
        color: #666;
        text-align: start;
        padding: 8px;
        border-top: 1px solid #eee;
        overflow: hidden;
        /* Ensures text doesn't overflow */
        text-overflow: ellipsis;
        /* Adds "..." if text is too long */
        display: block;
        max-width: 90%;
        /* Adjusts width to fit inside the card */
        margin: 0 auto;
        /* Centers text inside the card */
        box-sizing: border-box;
    }



    /* Package Button */
    .package-btn {
        display: inline-block;
        background: linear-gradient(to right, #b72dd2, #2492a8);
        color: white;
        padding: 12px 30px;
        border-radius: 30px;
        font-size: 18px;
        text-decoration: none;
        transition: all 0.3s ease-in-out;
        margin-top: 15px;
        box-shadow: 0 3px 10px rgba(183, 45, 210, 0.3);
    }

    /* Button Hover */
    .package-btn:hover {
        background: linear-gradient(to right, #2492a8, #b72dd2);
        transform: scale(1.05);
        color: white;
    }

    /* Disabled Button */
    .package-btn.disabled {
        background: #ccc;
        cursor: not-allowed;
        box-shadow: none;
    }

    /* Active Plan */
    .package-card.active {
        border: 2px solid #b72dd2;
        box-shadow: 0 6px 20px rgba(183, 45, 210, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .package-card {
            width: 100%;
            margin-bottom: 20px;
        }
    }


    .dim {
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
        <div class="d-flex justify-content-center my-4">
            <div class="page-title">
                <i class="fas fa-gift icon"></i>
                <span class="title-text">الباقات</span>
                <div class="underline"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            @forelse($data as $item)
            <div class="col-lg-4 col-md-6 col-12">
                @if(auth()->check())
                <div class="package-card {{ auth()->user()->package_id === $item->id ? 'active' : '' }} {{ auth()->user()->package_id === $item->id ? 'disabled' : '' }}">
                    @else
                    <div class="package-card">
                        @endif
                        <!-- Badge for الأكثر طلبا -->
                        @if($item->id == 2)
                        <span class="most-popular">الأكثر استخداما</span>
                        @endif

                        <div class="package-header">
                            <h3>{{$item->title_ar}}</h3>
                        </div>

                        <div class="package-body">

                            <div class="package-features">
                                {!! $item->desc_ar !!}
                            </div>
                            <hr>
                            <p class="package-price">
                                <span>{{$item->price_with_value}}</span> ريال
                            </p>

                        </div>

                        @if(auth()->check())
                        <div class="package-footer">
                        <form action="{{ url('subscripe_package') }}" method="POST" id="subscripePackageForm{{ $item->id }}">
                            @csrf
                            <input type="hidden" name="package_id" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-info {{ auth()->user()->package_id === $item->id ? 'disabled' : '' }}">
                                اشتراك
                            </button>
                        </form>

                        </div>
                        @else
                        <div class="package-footer">

                            <a href="{{ route('site_register') }}"
                                class="package-btn">
                                اشتراك
                            </a>

                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <div class="package-items-nofound">
                        <h4 style="color: red"> لا يوجد نتائج </h4>
                    </div>
                </div>
                @endforelse
            </div>



            <!-- package Modal -->
            <!-- @if(auth()->check() && auth()->user()->gender !='female' && auth()->user()->package_id === 1)
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

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var upgradeModal = new bootstrap.Modal(document.getElementById('upgradeModal'));
                    upgradeModal.show();
                });
            </script>
            @endif -->
        </div>
</section>
@endsection