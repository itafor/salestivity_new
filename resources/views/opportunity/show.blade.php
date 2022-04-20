@extends('layouts.app', ['title' => __('Opportunities'), 'icon' => 'las la-compass'])
@section('content')
@include('users.partials.header', ['title' => __('Opportunity')])


<style type="text/css">
  
.card {
    position: relative;
    display: flex;
    padding: 20px;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #d2d2dc;
    border-radius: 11px;
    -webkit-box-shadow: 0px 0px 5px 0px rgb(249, 249, 250);
    -moz-box-shadow: 0px 0px 5px 0px rgba(212, 182, 212, 1);
    /*box-shadow: 0px 0px 5px 0px rgb(161, 163, 164)*/
}

.media img {
    width: 40px;
    height: 40px
}

.reply a {
    text-decoration: none
}
</style>

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">

        <div class="card">
      <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Opportunity Details') }} </h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('opportunity.edit',[$opportunity->id]) }}" class="btn btn-sm btn-info">{{ __('Manage') }}</a>
                                &nbsp;&nbsp;
                               <!--  <a href="{{ route('opportunity.view',[$opportunity->id]) }}" class="btn btn-sm btn-primary">{{ __('Back To List') }}</a> -->
                            </div>
                        </div>
                    </div>
  <div class="card-body">
        <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($opportunity))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Opportunity Name') }}</b></td>
                     <td>{{ $opportunity->name }}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{ $opportunity->customer ? $opportunity->customer->name : 'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Contact Person') }}</b></td>
                     <td>{{ $opportunity->contact_person ? $opportunity->contact_person->name .' '.$opportunity->contact_person->surname :'N/A'  }}</td>
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('Owner') }}</b></td>
                     <td>{{ $opportunity->owner ? $opportunity->owner->name .' '.$opportunity->owner->last_name : 'N/A'  }}</td>
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('Probability') }}</b></td>
                     <td>{{ $opportunity->probability }} %
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Amount') }}</b></td>
                     <td>&#8358;{{ number_format($opportunity->amount,2) }}
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Status') }}</b></td>
                     <td>
                        {{ $opportunity->status }} 
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __(' Initiation Date ') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($opportunity->initiation_date)) }}</td>           
              </tr>
              <tr>
                     <td style="width: 200px;"><b>{{ __('Expected Closure Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($opportunity->closure_date)) }}</td>           
              </tr>

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>
                   <h2>All Products</h2>
                                <div class="row">
                                    <div class="col-xl-6">
                                        @forelse($opportunity->opp_product as $product)
                                            <span class="text-gray"><b>{{ $product->produc ? $product->produc->name : 'N/A'  }}</b>,</span>
                                        @empty
                                            <span class="badge bg-purple">No Product Added</span>
                                        @endforelse
                                    </div>
                </div>
                <hr>
                <h3 class="text-center mb-5"> Opportunity Updates </h3>

<div class="container mb-5 mt-5">
    @if(count($opportunity_updates) >=1)
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                    
                        @foreach($opportunity_updates as $update)
                        <div class="media mt-3"> <img class="mr-3 rounded-circle" alt="Bootstrap Media Preview" src="https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_360,h_360/https://al-azharinternationalcollege.com/wp-content/uploads/2017/08/avatar.png" />
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-8 d-flex">
                                        <h5>{{$update->user ? $update->user->name:''}} {{$update->user ?$update->user->last_name:''}}</h5> &nbsp;&nbsp;&nbsp;<span> <i class="fa fa-clock" aria-hidden="true"></i>  
                                    {{ date("jS F, Y", strtotime($update->update_date)) }}
                                        </span>
                                        <span>&nbsp; <i class="fa fa-star text-blue" aria-hidden="true"></i>&nbsp;<b>{{$update->type}}</b></span>
                                    </div>
                                    <div class="col-4">
                                        <div class="pull-right reply"> <span onclick="replyOpportunityUpdate({{$update->id}})" style="cursor: pointer;"><i class="fa fa-reply"></i> reply</span> </div>
                                    </div>
                                </div> 
                            <span style="color: gray; border-radius: 5px;" id="lessOppUpdateComment{{$update->id}}">{{ \Illuminate\Support\Str::limit($update->commments, 210)}} 
                                    @if(strlen($update->commments) > 210)
                                <b onclick="seeMoreOppUpdateComment({{$update->id}})" style="cursor:pointer;">See more</b>
                                @endif
                            </span>

                            <span style="color: gray; border-radius: 5px; display: none;" id="moreOppUpdateComment{{$update->id}}">{{$update->commments}} <b onclick="seeLessOppUpdateComment({{$update->id}})" style="cursor: pointer;">&nbsp;See Less</b></span>


                                @if(loginUserId() == $update->user->id)
                                <div class="row">
                                     <div class="col-8 d-flex mt-2">
                                        
                                        <span onclick="editOpportunityUpdate({{$update->id}})" style="cursor: pointer;">&nbsp;&nbsp; <i class="fa fa-edit" aria-hidden="true" title="Edit opportunity update"></i> </span>&nbsp;&nbsp;
                                       
                                          <a onclick="return confirm_delete()"  href="{{route('items.destroy',['opportunityUpdate',$update->id])}}">&nbsp;<i class="fa fa-trash text-danger" aria-hidden="true" title="Delete opportunity update"></i>&nbsp; &nbsp; </a>

                                         <span onclick="editOpportunityUpdate({{$update->id}})" style="cursor: pointer;">&nbsp;&nbsp; </span>&nbsp;&nbsp;
                                    </div>
                                     <div class="col-4">
                                        <div class="pull-right reply"> <span onclick="opportunityUpdateReplies({{$update->id}})" style="cursor: pointer;">  <label id="hideOPPReplyLabel{{$update->id}}" style="display: none;">Hide</label> <label id="">Replies</label> ({{count($update->updateReplies)}})</span> </div>
                                    </div>
                                </div>
                         @endif

                                <!-- edit update form -->
            <div class="row mt-4" id="editopportunityupdate{{$update->id}}form" style="display: none;">
         @include('opportunity.updates.edit_opportunity_update_form')
                                </div>


            <!-- opportunity update  replies -->
            <div id="opportunity_updateReplies{{$update->id}}" style="display: none;">
         @include('opportunity.updates.replies')
            </div>
                      
            <!-- replies form -->
         @include('opportunity.updates.repliesForm')
                                
                            </div>
                        </div>
                        @endforeach
                      {{ $opportunity_updates->links('pagination::bootstrap-4') }}
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
     @endif
    <br>
         @include('opportunity.updates.newOpportunityUpdate')
</div>

  </div>

</div>

            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection