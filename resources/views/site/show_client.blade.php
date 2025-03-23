@extends('site.master')
@section('title')
    {{ $data->first_name }}
@endsection
@section('style')
    <style>
   @keyframes borderAnimation {
    0% { box-shadow: 0 0 5px #b72dd2; }
    50% { box-shadow: 0 0 10px #26bbd9, 0 0 15px #26bbd9; }
    100% { box-shadow: 0 0 5px #b72dd2; }
}

.profile-img {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    width: 200px; /* Adjust width as needed */
    height: 200px; /* Keep it square */
    border-radius: 15%;
    border: 2px solid #b72dd2;
    margin: 0 auto; /* Center the profile image */
    animation: borderAnimation 2s infinite alternate; /* Apply animation */
}

.profile-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0%;
}


        .btn-redesigned {
            display: inline-flex;
            width: 180px;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            background: linear-gradient(hsl(190, 60%, 45%) 50%, hsl(190, 65%, 40%) 50%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-redesigned:hover {
            background: linear-gradient(hsl(190, 65%, 40%) 50%, hsl(190, 60%, 45%) 50%);
            color: white;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
        }

        .btn-redesigned::before {
            content: "";
            display: inline-block;
            width: 18px;
            height: 18px;
            margin-left: 8px;
            right: 5px;
            background-image: url('/public/site/assets/img/icons/envelope.png');
            /* Replace with the correct file path */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .btn-redesigned:active {
            transform: translateY(2px);
        }

        .btn-like {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            background: linear-gradient(hsl(290, 80%, 55%) 50%, hsl(290, 65%, 50%) 50%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-like:hover {
            background: linear-gradient(hsl(290, 65%, 50%) 50%, hsl(290, 80%, 55%) 50%);
            color: white;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
        }

        .btn-like::before {
            content: "";
            display: inline-block;
            width: 18px;
            height: 18px;
            margin-left: 8px;
            right: 5px;
            background-image: url('/public/site/assets/img/icons/heart.png');
            /* Replace with the correct file path */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .vip-mark {
            position: absolute;
            left: 20px;
            top: 0px;
            display: flex;
            align-items: center;
            /* Ensures the icon and text are aligned vertically */
            width: 100%;
            direction: ltr;
            /* Ensures the text direction is left to right */
        }

        .vip-mark::before {
            content: "";
            /* Icon or image */
            display: inline-block;
            width: 80px;
            /* Adjust the width of the icon */
            height: 80px;
            /* Adjust the height of the icon */
            margin-left: 2px;
            /* Space between the icon and the text */
            background-image: url('/site/assets/img/vip2.png');
            /* Path to your icon */
            background-size: contain;
            /* Ensures the icon fits */
            background-repeat: no-repeat;
            /* Prevents the icon from repeating */
            background-position: center;
            /* Centers the icon inside its container */

        }

        .vip-mark span {
            flex-grow: 1;
            /* Allows the text to take up remaining space */
        }

        .vip-mark:hover::after {
            content: "عضو مميز";
            /* The text to display on hover */
            position: absolute;
            top: -30px;
            /* Adjust the positioning above the element */
            left: 0;
            /* Align with the left edge */
            background-color: #fff;
            /* Background color of the tooltip */
            color: #000;
            /* Text color */
            padding: 5px 10px;
            /* Padding inside the tooltip */
            border: 1px solid #ccc;
            /* Optional border for the tooltip */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 14px;
            /* Text size */
            white-space: nowrap;
            /* Prevent wrapping */
            z-index: 10;
            /* Ensure it appears above other elements */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Adds a subtle shadow for emphasis */
        }





        .btn-like:active {
            transform: translateY(2px);
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

    <section class="profile mt-5">

        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="hold-profile-info">
                        <div class="align-items-center flex-md-row text-center">
                            <div class="profile-img text-center mt-3">
                                <img loading="lazy" src="{{ url('' . $data->avatar) }}" alt="Profile Image">
                            </div>

                            <div class="profile-info-name text-center mt-3">
                                @if ($data->gender ==='female' || $data->package_id != null )
                                    <h4 class="vip-mark"></h4>
                                @endif
                                <h4 style="font-size:22px">
                                    <i    data-bs-toggle="tooltip"
   data-bs-placement="top"
   title="{{ $data->is_still_online ? 'متصل الآن' : 'غير متصل الآن' }}" class="fa-solid fa-user {{ $data->is_still_online ? 'text-success' : 'text-muted' }}" ></i> {{ $data->first_name }}</h4>
                            </div>
                        </div>

                        {{-- for non registered --}}
                        @if(!auth()->check())
                        <div class="mt-3">
                            <a  href="{{ url('show_chat/' . $data->id) }}"
                            class="btn-redesigned" style="width:100%">أرسل رسالة</a>
                            </div>
                             <div class="mt-3">
                            <a  href="{{ url('show_chat/' . $data->id) }}"
                            class="btn-like" style="width:100%">أرسل رسالة إعجاب</a>
                            </div>
                        @endif

                        @if (auth()->check() && auth()->user()->user_type == 'client')
                            <div class="mt-3 text-center">
                                @if (!user_block_list($data->id, auth()->id()) && !user_block_list(auth()->id(), $data->id))
                                    @if (auth()->id() != $data->id && auth()->user()->gender != $data->gender)
                                    <div class="mt-3">
                                        <a @if (auth()->id() != $data->id) href="{{ url('show_chat/' . $data->id) }}" @endif
                                            class="btn-redesigned" style="width:100%"> ارسل رسالة </a>
                                            </div>
                                            <div class="mt-3">
                                        <a @if (auth()->id() != $data->id) style="width:100%" href="{{ url('add_to_favourite/' . $data->id) }}" @endif
                                            class="btn-like"
                                            @if (user_favourite(auth()->id(), $data->id)) style="background-color: #d22c2c; color: white; width:100%"  @endif>
                                            @if (!$favouritted)
                                            أرسل رسالة إعجاب
                                            @elseif($favouritted->show_in_list == 0)
                                            اضافة إلى اعجباتي
                                            @else
                                            أزالة من اعجباتي
                                            @endif
                                        </a>
                                        </div>
                                    @endif
                                    @if (auth()->id() != $data->id && auth()->user()->gender != $data->gender && !checkUserPackage())
                                        <p style="color: red">العدد المتبقي لرسائل الاعجاب
                                            {{ getFavCount() <= 0 ? convertToArabicNumbers(0) : convertToArabicNumbers(getFavCount()) }}</p>
                                        @if (getFavCount() <= 0)
                                            <p>
                                                <span style="color: red">لارسال رسائل اعجاب جديدة قم بـ </span>
                                                <a href="{{ url('all_packages') }}"
                                                    style="color: blue;background-color: #ede2ab">ترقية حسابك</a>
                                            </p>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="hold-profile-info" style="line-height: 1.8">
                        <p><strong>الهدف من الموقع:</strong></p>
                        <p>{{ $data->goals }}</p>
                        <p><strong>طريقة التواصل مع الاخرين:</strong></p>
                        <p>{{ $data->communications }}</p>

                        @if (!$data->login)
                            <p><strong>آخر تواجد في الموقع:</strong></p>
                            <p>{{ Carbon\Carbon::parse($data->logout_date)->diffForHumans() }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="hold-profile-info">
                        <table class="info-table">
                            <tr>
                                <td>لون العين:</td>
                                <td>{{ $data->eye_color }}</td>
                            </tr>
                            <tr>
                                <td>لون الشعر:</td>
                                <td>{{ $data->hair_color }}</td>
                            </tr>
                            <tr>
                                <td>لون البشرة:</td>
                                <td>{{ $data->skin_color }}</td>
                            </tr>
                            <tr>
                                <td>الطول:</td>
                                <td>{{ $data->height }}</td>
                            </tr>
                            <tr>
                                <td>الوزن:</td>
                                <td>{{ $data->width }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @php
                    $goal = App\Models\Media_file::where('id', $data->goal_id)->first();
                    $city = App\Models\City::where('id', $data->city_id)->first();
                @endphp

            </div>

            <div class="row mt-lg-4">
                <div class="col-lg-12 col-md-12">
                    <div class="profile-desc">
                        <table class="info-table">
                            <tr>
                                <td>المدينة:</td>
                                <td>{{ $data->city?->title_ar }}</td>
                            </tr>
                            <tr>
                                <td>الجنسية:</td>
                                <td>{{ $data->nationality }}</td>
                            </tr>
                            <tr>
                                <td>العمر:</td>
                                <td>{{ $data->age }}</td>
                            </tr>
                            <tr>
                                <td>الحالة:</td>
                                <td>{{ $data->social_level }}</td>
                            </tr>
                        </table>
                        <table class="info-table">
                            <tr>
                                <td>لديك ابناء:</td>
                                <td>{{ $data->has_sons ? 'نعم' : 'لا' }}</td>
                            </tr>
                            <tr>
                                <td>التحصيل العلمي:</td>
                                <td>{{ $data->level }}</td>
                            </tr>
                            <tr>
                                <td>المهنة:</td>
                                <td>{{ $data->job }}</td>
                            </tr>
                        </table>
                    </div>


                </div>
                <div class="col-lg-12 col-md-12 ">
                    <div class="profile-desc profile-desc-with mt-5 ">
                        <p class="section-title">تحدث عن نفسك</p>
                        <p>{{ $data->desc_ar }}</p>
                    </div>

                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="hold-profile-info_no_width mt-5 mb-5">

                        <div class="profile-desc">
                            <p class="section-title">صف الشخص الذي تبحث عنه</p>
                            <p>{{ $data->goal_desc_ar }}</p>
                        </div>
                    </div>
                </div>


                @if (auth()->check() && auth()->user()->user_type == 'client' && auth()->id() != $data->id && auth()->user()->gender != $data->gender)
                    <div class="container">
                        <div class="profilePage-url">
                            <a @if (auth()->id() != $data->id) href="{{ url('add_to_block_list/' . $data->id) }}" @endif
                                class="exit-btn"
                                @if (user_block_list(auth()->id(), $data->id)) style="background-color: green; color: white" @endif>
                                {{ !user_block_list(auth()->id(), $data->id) ? 'أضف إلى قائمة التجاهل' : 'ازالة من قائمة التجاهل' }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
