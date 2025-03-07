@extends('site.master')
@section('title') الرسائل @endsection
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

        .visitors-table-container {
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .visitors-table {
            width: 100%;
            border-collapse: collapse;
        }

        .visitors-table-header {
            background-color: #c930e8;
            color: #ffffff;
        }

        .visitors-header-cell, .visitor-cell {
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            flex: 1;
            display: flex;

        }
        .visitors-header-cell input[type=checkbox] {
            display: flex !important;

        }
        tr{
            flex-wrap: wrap;
        }
          .visitor-cell .visitor-cell-msg{
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            white-space: nowrap;
        }

        .visitor-row {
            background-color: #ede2ab;
        }

        .visitors-table-body .visitor-row:hover {
            background-color: #cbbc72;
        }
        .select-room {
            display: inline !important;
        }
        .delete-button {
            display: flex;
            padding: 12px;
            justify-content: center;
        }
        .visitor-cell-img{
            width: 75px !important;
            height: 75px !important;
            object-fit: fill !important;
            border-radius: 0 !important;
            margin-inline-end: 0px !important;
            border: 0px !important;
        }
        @media (max-width: 768px) {
            .new-members .visitors-table .visitor-cell img{
                width: 45px;
                height: 45px;
            }
            .new-members  .visitors-header-cell, .visitor-cell {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                font-size: 12px;
                width: 25%;
                padding: 0;
            }
            .new-members .visitor-cell .btn.btn-info{
                padding: 5px ;
                font-size: 10px;
            }
            .new-members .visitors-table-body tr{
                padding: 5px 0;
            }
        }
        @media (max-width: 768px) {
            .visitor-cell .visitor-cell-msg{
                max-width: 55px;
                overflow: hidden;
            }
        }
        @media (max-width: 320px) {
            .visitor-cell .visitor-cell-msg{
                max-width: 20px;
                overflow: hidden;
            }
        }

        @media (max-width: 480px) {
            .messages-container {
                background: #fcf8e3;
                padding: 20px;
                border-radius: 5px;
            }
            .message-card {
                background-color: #ede2ab;
                padding: 10px;
                margin-bottom: 10px;
                border-radius: 5px;
                display: flex;
                font-size: 18px;
                font-weight: bold;
                font-family: "NotoNaskh", serif !important;
                align-items: center;
                position: relative;
            }

            .message-cell {
                max-width: 100px;
                overflow: hidden;
                text-overflow: ellipsis;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                color: #212529;
            }
            .message-card img {
                width: 80%;
                height: 100%;
                margin-left: 10px;
            }
            .message-card a {
                width: 80%;
                height: 100%;
                margin-left: 10px;
            }
            .message-content {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            .message-content strong {
                margin-bottom: 5px;
            }
            .message-content p {
                margin: 0;
            }
            #select-all-mobile-btn {
                display: flex;
                flex-wrap: wrap;
                align-content: center;
                justify-content: center;
            }
            .select-room-btn {
              position: relative;
              right: 55px;
              bottom: 50px;
              display: block;
            }
            .message-footer {
                display: flex;
                justify-content: space-between;
                width: 100%;
                margin-top: 5px;
                color: #212529 ;
            }
            .delete-btn {
                color: red;
                text-align: center;
                cursor: pointer;
                margin-top: 10px;
            }
            .desktop-view { display: none; }
        }

        @supports (-webkit-overflow-scrolling: touch) {
          /* CSS specific to iOS devices */
          .select-room-btn {
              right: 180px;
          }

        }

        @media (min-width: 481px) {
            .messages-container {

                padding: 20px;
                border-radius: 5px;
            }
            .messages-table {
                width: 100%;
                border-collapse: collapse;
            }
            .messages-table th, .messages-table td {
                padding: 10px;
                text-align: right;
            }
            .messages-table th {

            }
            .profile-img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
            }
            .select-room {
                margin-right: 20px;
                width: 20px;
                height: 20px;
            }

            .mobile-view { display: none; }
            #select-all-mobile-btn { display: none !important;}
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
    <section class="">
        <ul class="nav nav-tabs" id="myTab" role="tablist" style="display: none">
            <li class="nav-item">
                <a class="nav-link active" id="general-members-tab" data-toggle="tab" href="#general-members" role="tab" aria-controls="general-members" aria-selected="true">الرسائل</a>
            </li>
        </ul>
        <div class="container">
            <h2 class="sec-tit text-center">
                <!--الأعضاء-->
            </h2>
            <div class="new-members-items">
                <div class=" mt-4">
                    <!-- Tabs navigation -->


                    <!-- Tabs content -->
                    <div class="tab-content" id="myTabContent">
                        <!-- General members content -->
                        <div class="tab-pane fade show active" id="general-members" role="tabpanel" aria-labelledby="general-members-tab">
                         <div class="d-flex justify-content-center my-4">
    <div class="page-title">
        <i class="fas fa-envelope icon"></i>
        <span class="title-text">الرسائل</span>
        <div class="underline"></div>
    </div>
</div>
<style>
                                            /* ahmed alhofy */
                                            /* ahmed alhofy */
                                            .all{
                                                padding: 10px;
                                                background: linear-gradient(hsl(290, 80%, 55%) 50%, hsl(290, 65%, 50%) 50%);
                                                background-color: #c930e8;
                                            }
                                            .ul{
                                                margin-bottom: 30px;
                                            }
                                            .li{
                                                line-height: 50px;
                                                color: #1a1a1a;
                                                background-color: #ede2ab;
                                                border-bottom: 2px solid #fff;
                                                font-size: 105%;
                                                position: relative;
                                                transition: background-color .3s ease-in-out;
                                            }
                                            .portrait{
                                                margin-left: 6px;
                                                width: 37.5px;
                                                height: 50px;
                                                vertical-align: bottom;
                                                background-color: #faf5e1;
                                                overflow: hidden;
                                            }
                                            .name{
                                                width: 30%;
                                            }
                                            .age{
                                                width: 20%;
                                            }
                                            .country{
                                                display: inline-block;
                                            width: 25%;
    }
                                            .date{
                                                font-size: 90%;

                                            }
                                            .li:hover {
                                                cursor: pointer;
                                                background-color: #e4d481;
                                            }
                                            @media(max-width:767px){
                                                .country{
                                                    display: none;
                                                }
                                                .age{
                                                    margin-left: 50px;
                                                }
                                            }
                                            @media(max-width:530px){
                                                .age{
                                                    display: none;
                                                }
                                                .date{
                                                    margin-right: 75px;
                                                }
                                                .li{
                                                    padding: 0 !important;
                                                }
                                            }
                                            /* ahmed alhofy */
                                            /* ahmed alhofy */
                                </style>
                            <div class="visitors-table-container">
                            <form id="delete-form" method="POST" action="{{ route('delete_rooms') }}">
                                @csrf
                                <div id="select-all-mobile-btn">
                                    <spa>حدد الكل</spa><input type="checkbox" class="select-room" id="select-all-mobile">
                                </div>
                                <!-- Desktop View -->
                                <div class=>
                                    <table class="visitors-table messages-table">
                                        <thead class="visitors-table-header">
                                        <tr>
                                            <th style="margin-right: 40px;text-wrap-mode: nowrap;" class="name" >الأسم</th>
                                            <th class="visitors-header-cell">الرسالة</th>
                                            <th  style="font-size: 14px; margin-right: 20px" class=" visitors-header-cell">تاريخ الرسالة</th>
                                            <th class="visitors-header-cell"><input type="checkbox" class="select-room" id="select-all"></th>
                                        </tr>
                                        </thead>
                                        <tbody class="visitors-table-body" id="message-list">
                                        @forelse($data as $item)
                                            @php
                                                $id   = auth()->id() == $item->user_id ? (int) $item->saler_id : (int) $item->user_id;
                                                $user = App\Models\User::whereId($id)->first();
                                            @endphp
                                            <tr style="cursor:pointer; border-bottom: 1px solid white;" class="visitor-row" onclick="window.location.href='{{url('show_room/' . $item->id)}}'"   >
                                                <td class="portrait">
                                                    <img src="{{url('' . $user->avatar)}}" alt="" class="visitor-image" width="100px" height="75px">
                                                </td>
                                                <td style="text-wrap-mode: nowrap;" class="name">
                                                    <a href="{{url('show_client/' . $item->user_id)}}">{{$item->user->name}}</a>
                                                </td>
                                                <!-- <td class="visitor-cell">
                                                    <span style="color:blue;">{{isset($user) ? $user->first_name : ''}}</span>
                                                </td> -->
                                                <td class="visitor-cell">
                                                    <span class="visitor-cell-msg">{{!is_null($item->chats_desc) && last_room_chat($item->id)['type'] == 'text' ? last_room_chat($item->id)['last_message'] : 'رسالة صوتية'}}</span>
                                                </td>
                                                <td class="visitor-cell">
                                                    <span>
                                                            {{--{{!is_null($item->chats_desc) ? last_room_chat($item->id)['duration'] : ''}}--}}
                                                       {{ !is_null($item->chats_desc) && isset(last_room_chat($item->id)['duration_format']) ? last_room_chat($item->id)['duration_format'] : '' }}
                                                    </span>
                                                </td>
                                                <td class="visitor-cell">
                                                    <input   type="checkbox" name="room_ids[]" value="{{ $item->id }}" class="select-room  select-room-btn select-room-btn-desktop">
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"> لا يوجد نتائج</td>
                                            </tr>
                                        @endforelse
                                        <!-- أضف المزيد من الصفوف هنا -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile View -->
                                <!-- <div class="mobile-view">
                                    @forelse($data as $item)
                                        @php
                                            $id   = auth()->id() == $item->user_id ? (int) $item->saler_id : (int) $item->user_id;
                                            $user = App\Models\User::whereId($id)->first();
                                        @endphp
                                    <div class="message-card">
                                        <a href="{{url('show_room/' . $item->id)}}" style="max-width: 100px;"><img src="{{url('' . $user->avatar)}}" alt="profile"></a>
                                        <a href="{{url('show_room/' . $item->id)}}" class="message-card-a">
                                            <div class="message-content">
                                                <strong style="color:blue;">{{isset($user) ? $user->first_name : ''}}</strong>
                                                <p class="message-cell">{{!is_null($item->chats_desc) && last_room_chat($item->id)['type'] == 'text' ? last_room_chat($item->id)['last_message'] : 'رسالة صوتية'}}</p>
                                                <input type="checkbox" name="room_ids[]" value="{{ $item->id }}" class="select-room message-checkbox select-room-btn select-room-btn-mobile">
                                                <div class="message-footer">
                                                   <small>{{ !is_null($item->chats_desc) && isset(last_room_chat($item->id)['duration_format']) ? last_room_chat($item->id)['duration_format'] : '' }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @empty
                                        <p>لا يوجد نتائج</p>
                                    @endforelse
                                </div> -->

                                <div class="delete-button">
                                    <button type="submit" class="btn btn-danger" id="delete-btn" disabled>حذف المحدد</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    </section>
    <script>
    //----------desktop-select-all-----------------------------------------------//
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.select-room-btn-desktop');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        if( document.getElementById('delete-btn').hasAttribute('disabled'))
        {
            let checked = 0;
                for(var counter = 0 ; counter < checkboxes.length; counter ++ ){
                    if(checkboxes[counter].checked == true ){
                        checked = 1;
                        break;
                    }else {
                        checked = -1 ;
                    }
                }
                if(checked != 1){
                }else{
                    document.getElementById('delete-btn').removeAttribute('disabled');
                }

        }else{
            let checked = 0;
                for(var counter = 0 ; counter < checkboxes.length; counter ++ ){
                    if(checkboxes[counter].checked == true ){
                        checked = 1;
                        break;
                    }else {
                        checked = -1 ;
                    }
                }
                if(checked != 1){
                    document.getElementById('delete-btn').setAttribute('disabled',true);
                }
        }

    });
    //----------desktop-select-buttons-----------------------------------------------//
    let selectbtns = document.querySelectorAll(".select-room-btn-desktop")
    selectbtns.forEach(selectbtn => {
        selectbtn.addEventListener('change', function () {
            if( document.getElementById('delete-btn').hasAttribute('disabled'))
            {
                document.getElementById('delete-btn').removeAttribute('disabled');
            }else {
                let checked = 0;
                let size = selectbtns.length;
                for(var counter = 0 ; counter < size; counter ++ ){
                    if(selectbtns[counter].checked == true ){
                        checked = 1;
                        break;
                    }else {
                        checked = -1 ;
                    }
                }
                if(checked != 1){
                    document.getElementById('delete-btn').setAttribute('disabled',true);
                }
            }
        });
    });
    //----------mobile-select-all-----------------------------------------------//
    document.getElementById('select-all-mobile').addEventListener('change', function () {
        const checkboxesMobile = document.querySelectorAll('.select-room-btn-mobile');
        checkboxesMobile.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        let checked = 0;
        let size = checkboxesMobile.length;
        if( document.getElementById('delete-btn').hasAttribute('disabled'))
        {

                for(var counter = 0 ; counter < size; counter ++ ){
                    if(checkboxesMobile[counter].checked == true ){
                        checked = 1;
                        break;
                    }else {
                        checked = -1 ;
                    }
                }
                if(checked != 1){
                }else{
                    document.getElementById('delete-btn').removeAttribute('disabled');
                }

        }else{
                for(var counter = 0 ; counter < size; counter ++ ){
                    if(checkboxesMobile[counter].checked == true ){
                        checked = 1;
                        break;
                    }else {
                        checked = -1 ;
                    }
                }
                if(checked != 1){
                    document.getElementById('delete-btn').setAttribute('disabled',true);
                }
        }

    });
    //----------mobile-select-buttons-----------------------------------------------//
    let selectbtnsMobile = document.querySelectorAll(".select-room-btn-mobile")
    selectbtnsMobile.forEach(selectbtn => {
        selectbtn.addEventListener('change', function () {
            if( document.getElementById('delete-btn').hasAttribute('disabled'))
            {
                document.getElementById('delete-btn').removeAttribute('disabled');
            }else {
                let checked = 0;
                let size = selectbtnsMobile.length;
                for(var counter = 0 ; counter < size; counter ++ ){
                    if(selectbtnsMobile[counter].checked == true ){
                        checked = 1;
                        break;
                    }else {
                        checked = -1 ;
                    }
                }
                if(checked != 1){
                    document.getElementById('delete-btn').setAttribute('disabled',true);
                }
            }
        });
    });

</script>
@endsection
