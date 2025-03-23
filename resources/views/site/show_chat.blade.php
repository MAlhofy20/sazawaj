@extends('site.master')
@section('title') الدردشة @endsection
@section('style')
    <style>
        .myMsg {
            width: 40%;
            border-radius: 10px;
            padding: 10px;
            margin: 5px;
            display: flex;
            flex-direction: column;
            background-color: white;
        }

        .myMsgDesc {
            float: right;
            color: black;
            min-width: 51%;
            max-width: 70%;
            word-wrap: break-word;
        }

        .myMsgTime {
            float: left;
        }

        .msg {

            width: 40%;
    border-radius: 10px;
    padding: 10px;
    margin: 5px;
    position: relative;
    display: flex;
    flex-direction: column;
    background-color: white;
    background-color:wheat;

        }

        .msgDesc {
                        float: right;
            color: black;
            min-width: 51%;
            max-width: 70%;
            word-wrap: break-word;

            float: right;
            color: black;
            min-width: 51%;
            max-width: 70%;
            word-wrap: break-word;
        }

        .msgTime {
            text-align: end;
            align-items: end;
            color: #666666;
            font-size: 12px;
        }
        .icon-micro {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 15px;
        padding: 10px;
        }

        #record-btn {
            cursor: pointer;
            font-size: 28px;
            color: #4CAF50;
            transition: transform 0.3s ease;
        }

        #record-btn-notActive {
            cursor: pointer;
            font-size: 28px;
            color: #4CAF50;
            transition: transform 0.3s ease;
        }

        .recording #record-btn {
            animation: pulse 1s infinite;
            color: red;
        }

        .timer {
            font-size: 18px;
            color: #666;
            display: none;
            font-weight: bold;
        }

        .controls {
            display: none;
            align-items: center;
            gap: 5px;
        }

        .recording .timer {
            display: inline-block;
        }

        .recording .controls {
            display: flex;
        }



        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        .myMsg .audio-playback {
              width: 220px !important;
        }
        #audio-playback {
            max-width: 300px; /* عرض عنصر الصوت */
            /*margin-right: 2px; !* المسافة بين الصوت وزر الحذف *!*/
        }

        .audio-playback {
            width: 250px; /* عرض عنصر الصوت */
        }

        .delete-btn {
            cursor: pointer;
            color: red;
            font-size: 0px;
            font-weight: bold;
        }

        input[type="file"] {
            display: none; /* إخفاء input type="file" */
        }
        @media (max-width: 480px) {
            .myMsg {
                min-width: 50%;
                max-width: 90%;
                width: 100%;
            }
            .myMsgDesc {
                min-width: 51%;
                max-width: 51%;
            }
            .msg {
                min-width: 50%;
                max-width: 90%;
                width: 100%;
            }
            .msgDesc {
                min-width: 51%;
                max-width: 51%;
            }
        }
        @media (max-width: 600px) {
            .controls{
               width: 100%;
            }
            .chat .main-btn{
                        margin: 20px auto;
        display: table;
        float: none;
            }
            .icon-micro {

                align-items: center; /* محاذاة العناصر لأعلى */
            }
    .icon-micro i {
        font-size: 24px;
    }
            #audio-playback {
                width: 100%; /* توسيع عنصر الصوت في الشاشات الصغيرة */
            }
            .chat-input{
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
    <!--  welcome  -->
    @if(!auth()->check())
        <section class="welcome">
            <div class="welcome-img">
                <img src="{{ site_path() }}/assets/img/welcome.png" alt="">
            </div>
            <p class="welcome-tit">أهلاً بكم في موقع {{ settings('site_name') }}</p>
        </section>
    @endif
    <!--  //welcome  -->

    @php
        $id   = auth()->id() == $room->user_id ? (int) $room->saler_id : (int) $room->user_id;
        $user = App\Models\User::whereId($id)->first();
    @endphp
    <!--  chat  -->
    <section class="chat">
        <div class="container">

            <!-- Modal -->
            <div class="modal fade" id="upgradeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-body modal-dialog modal-dialog-centered">
                        <div class="border-info modal-content p-3">
                            <button type="button" class="close text-right" style="opacity: 1" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="modal-header justify-content-center">
                                <h5 class="modal-title  text-center" id="exampleModalLabel">الميزة ليست متوفرة</h5>
                            </div>
                            <div class="modal-body text-center">

                                <!-- Description -->
                                <p> يجب ترقية الباقة لأستفادة من هذه الميزه</p>
                                <!-- Image -->
                                <img src="{{ site_path() }}/assets/img/gold.png" alt="">

                                <!-- Button -->
                            </div>
                            <a href="{{ url('all_packages') }}" class="next-btn">
                                <span>ترقيه</span>
                                <i class="fa-solid fa-left-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <div class="chat-container">
                <div class="chat-header">
                    <div class="member-name">
                        {{isset($user) ? $user->first_name : ''}}
                    </div>
                    <div class="chat-status">
                        <p class="{{isset($user) && $user->is_still_online ? 'available' : 'offline'}} ">
                            {{isset($user) && $user->is_still_online ? 'متواجد حاليا' : 'غير متواجد حالياً'}}
                        </p>
                        {{--<a href="#">
                            <img src="{{ site_path() }}/assets/img/document%20(1).png" alt="">
                        </a>
                        <a href="#">
                            <img src="{{ site_path() }}/assets/img/block.png" alt="">
                        </a>--}}
                    </div>
                </div>
                <div class="chat-screen" id="roomChats">
                    @foreach($data as $item)
                        <?php $user = App\Models\User::whereId($item->from_id)->first(); ?>
                        <div  class="row" style="display: flex; justify-content: {{ $item->from_id == auth()->id() ? 'flex-start' : 'flex-end' }};">
                            <div class="{{$item->from_id == auth()->id() ? 'myMsg' : 'msg'}}">
                                <p class="member-name {{$item->from_id == auth()->id() ? 'myMsgDesc' : 'msgDesc'}}">
                                    <a href="{{url('show_client/' . $user->id)}}">
                                        <img loading="lazy" src="{{url(''.$user->avatar)}}" height="30px" width="30px" class="available">
                                        <span class="available">{{$user->name}}</span>
                                    </a>
                                </p>
                                <p class="member-name {{$item->from_id == auth()->id() ? 'myMsgDesc' : 'msgDesc'}}">
                                    <span class="available">
                                        @if($item->type == 'file')
                                            <audio src="{{url('' . str_replace('\\', '', $item->message))}}" class="audio-playback" controls></audio>
                                        @else
                                            {{$item->message}}
                                        @endif
                                    </span>
                                </p>
                                <p  style="align-self: end; color: #666666; font-size: 12px;" class="chat-status {{$item->from_id == auth()->id() ? 'myMsgTime' : 'msgTime'}}">
                                    <span class="available">{{(string) Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="chat-input">
                    <form class=" w-100  pr-2 pl-2" action="{{url('store_chat')}}" method="post" enctype="multipart/form-data">
                        <div class="row align-items-center">
                            <div class="col-12" style="display: flex; align-items: center; gap: 10px;">
                                                        @csrf
                        <input type="hidden" name="type" value="text">
                        <input type="hidden" name="room_id" value="{{$room->id}}">
                        <input type="hidden" name="from_id" value="{{auth()->id()}}">
                        @php
                            $user_id = $room->user_id == auth()->id() ? $room->saler_id : $room->user_id;
                        @endphp
                        <input type="hidden" name="to_id" value="{{$user_id}}">

                        {{--{{dd(auth()->id(), $user_id, check_user_block_list(auth()->id(), $user_id))}}--}}
                        <input class="w-100 mb-2 mt-2" type="text" name="message" id="messageInput" placeholder="رسالتك هنا" {{check_user_block_list(auth()->id(), $user_id) ? 'readonly' : ''}}/>
                               @php
                            $start = Carbon\Carbon::parse(auth()->user()->package_date);
                            $end   = Carbon\Carbon::parse(auth()->user()->package_end_date);
                            $monthsDifference = $start->diffInMonths($end);
                        @endphp
                        @if(auth()->user()->gender === 'female' || auth()->user()->package_id != 1)
                            <div class="icon-micro" id="mic-container">
                                <div id="record-btn">
                                    <i class="fa-solid fa-microphone"></i>
                                </div>
                                <div class="timer" id="timer">0:00</div>
                                <div class="controls" id="controls" style="display:none;">
                                    <audio id="audio-playback" controls></audio>
                                    <a class="delete-btn" id="delete-btn">
                                        <i class="fas fa-trash" style="font-size: 25px !important; color: red !important;"></i>
                                    </a>
                                </div>
                            </div>

                            <input type="file" id="audio-file" name="file_path" accept="audio/*" hidden>
                        @else
                            <div class="icon-micro" id="mic-container">
                                <div id="record-btn-notActive">
                                    <i class="fa-solid fa-microphone"></i>
                                </div>
                            </div>
                        @endif
                            </div>
                            <div class="col-lg-6 col-12">


                            </div>
                            <div class="col-lg-6 col-12">
                                            <button class="main-btn " onclick="checkMessage();">ارسل</button>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
            {{--<a href="#" class="exit-btn">خروج من الدردشة</a>--}}
        </div>
    </section>
    <!--  //chat  -->
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#record-btn-notActive').click(function(){
                $('#upgradeModal').modal('show');
            });
        });
    </script>
    <script>
        function checkMessage() {
            let messageInput = $('#messageInput').val();
            let audioInput   = $('#audio-file').val();
            if(messageInput == '' && audioInput == '') event.preventDefault();
        }
        $(document).ready(function() {
            var section = document.getElementById("roomChats");
            section.scrollTop = section.scrollHeight;

            document.getElementById("roomChats").scrollIntoView({ behavior: 'smooth' });

            $('#messageInput').val('');
            $('#audio-file').val('');
        });

         setInterval(function() {
             updateChat();
         }, 10000);

        function updateChat() {
            $.ajax({
                url: "{{url('ajax_show_room/' . $room->id)}}",
                type: "GET",
                success: function(response) {
                    $("#roomChats").html(response);
                }
            });

            // var section = document.getElementById("roomChats");
            // section.scrollTop = section.scrollHeight;
        }
    </script>
    <script>
    let isRecording = false;
    let mediaRecorder;
    let audioChunks = [];
    let timer;
    let seconds = 0;

    const micContainer = document.getElementById('mic-container');
    const recordBtn = document.getElementById('record-btn');
    const timerElement = document.getElementById('timer');
    const controlsElement = document.getElementById('controls');
    const deleteBtn = document.getElementById('delete-btn');
    const audioElement = document.getElementById('audio-playback');
    let audioFileInput = document.getElementById('audio-file');

    recordBtn.addEventListener('click', () => {
        if (isRecording) {
            stopRecording();
        } else {
            startRecording();
        }
    });

    deleteBtn.addEventListener('click', () => {
        deleteRecording();
    });

    async function startRecording() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = event => {
                audioChunks.push(event.data);
            };

            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                const audioUrl = URL.createObjectURL(audioBlob);
                audioElement.src = audioUrl;
                controlsElement.style.display = 'flex';
                 // Save the audio as a file in the input element
                const fileList = createFileList(audioBlob);
                audioFileInput.files = fileList;  // Assign file to input[type="file"]
            };

            mediaRecorder.start();

            isRecording = true;
            micContainer.classList.add('recording');
            seconds = 0;
            timerElement.textContent = `0:00`;
            timer = setInterval(updateTimer, 1000);
        } else {
            alert('الميكروفون غير مدعوم في متصفحك');
        }
    }

    function stopRecording() {
        mediaRecorder.stop();
        clearInterval(timer);
        isRecording = false;
        audioElement.setAttribute('duration',timerElement.textContent);
        audioElement.setAttribute('bufferd',timerElement.textContent);
        micContainer.classList.remove('recording');
    }

    function updateTimer() {
        seconds++;
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        timerElement.textContent = `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
    }

    // Create a FileList with the audio file to assign it to the input element
    function createFileList(blob) {
        const file = new File([blob], 'recorded_audio.wav', { type: 'audio/wav' });
        const dataTransfer = new DataTransfer();  // Create DataTransfer object
        dataTransfer.items.add(file);  // Add the file to the DataTransfer
        return dataTransfer.files;  // Return the FileList object
    }

    function deleteRecording() {
        audioElement.src = '';
        audioChunks = [];
        micContainer.classList.remove('recording');
        audioFileInput.value = '';
        controlsElement.style.display = 'none';
        clearInterval(timer);
        seconds = 0;
        timerElement.textContent = `0:00`;
        isRecording = false;
        audioElement.setAttribute('duration',0);
    }
</script>
@endsection
