@foreach($data as $item)
                        <?php $user = App\Models\User::whereId($item->from_id)->first(); ?>
                        <div class="row">
                            <div class="{{$item->from_id == auth()->id() ? 'myMsg' : 'msg'}}">
                                <p class="member-name {{$item->from_id == auth()->id() ? 'myMsgDesc' : 'msgDesc'}}">
                                    <a href="{{url('show_client/' . $user->id)}}">
                                        <img loading="lazy" src="{{url(''.$user->avatar)}}" height="30px" width="30px" class="available">
                                        <span class="available">{{$user->name}}</span>
                                    </a>
                                </p>
                                <br>
                                <p class="member-name {{$item->from_id == auth()->id() ? 'myMsgDesc' : 'msgDesc'}}">
                                    <span class="available">
                                        @if($item->type == 'file')
                                            <audio src="{{url('' . $item->message)}}" class="audio-playback" controls></audio>
                                        @else
                                            {{$item->message}}
                                        @endif
                                    </span>
                                </p>
                                <p class="chat-status {{$item->from_id == auth()->id() ? 'myMsgTime' : 'msgTime'}}">
                                    <span class="available">{{(string) Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach