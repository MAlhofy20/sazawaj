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
