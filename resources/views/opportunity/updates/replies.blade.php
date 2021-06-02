@if(count($update->updateReplies) >= 1)
            @foreach($update->updateReplies as $reply)
             <div class="media mt-3 mb-3"> <a class="pr-3" href="#"><img class="rounded-circle" alt="Bootstrap Media Another Preview" src="https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_360,h_360/https://al-azharinternationalcollege.com/wp-content/uploads/2017/08/avatar.png" /></a>
                <div class="media-body">
                    <div class="row">
                        <div class="col-12 d-flex">
                            <h5>{{$reply->user->name}} {{$reply->user->last_name}}</h5>&nbsp;&nbsp; <span><i class="fa fa-clock"></i>&nbsp;&nbsp; {{ \Carbon\Carbon::parse($reply->created_at)->diffForhumans() }}</span>
                        </div>
                    </div> <!-- {{$reply->reply}} -->

                      <span style="color: gray; border-radius: 5px;" id="lessOppUpdateCommentReply{{$reply->id}}">{{ \Illuminate\Support\Str::limit($reply->reply, 180)}} 
                                    @if(strlen($reply->reply) > 180)
                                <b onclick="seeMoreOppUpdateCommentReply({{$reply->id}})" style="cursor:pointer;">See more</b>
                                @endif
                            </span>

                            <span style="color: gray; border-radius: 5px; display: none;" id="moreOppUpdateCommentReply{{$reply->id}}">{{$reply->reply}} <b onclick="seeLessOppUpdateCommentReply({{$reply->id}})" style="cursor: pointer;">&nbsp;See Less</b></span>

                    @if(loginUserId() == $reply->user->id)
                    <div class="row">
                     <div class="col-8 d-flex mt-2">
                        
                        <span onclick="editOpportunityUpdateReply({{$reply->id}})" style="cursor: pointer;">&nbsp;&nbsp; <i class="fa fa-edit" aria-hidden="true" title="Edit reply"></i> </span>&nbsp;&nbsp;
                       
                          <a onclick="return confirm_delete()"  href="{{route('items.destroy',['opportunityUpdateReply',$reply->id])}}" title="Delete reply">&nbsp;<i class="fa fa-trash text-danger" aria-hidden="true"></i>&nbsp; &nbsp; </a>

                    </div>
                </div>
                         @endif
         @include('opportunity.updates.editReplyForm')

                </div>
            </div>
            @endforeach
            @endif