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
                              @if(getActiveGuardType()->created_by == $opportunity->created_by)
                                <a href="{{ route('opportunity.edit',[$opportunity->id]) }}" class="btn btn-sm btn-info">{{ __('Manage') }}</a>
                                @endif
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
                                            <span class="badge bg-purple">{{ $product->produc ? $product->produc->name : 'N/A'  }}</span>
                                        @empty
                                            <span class="badge bg-purple">No Product Added</span>
                                        @endforelse
                                    </div>
                </div>
                <hr>

<div class="container mb-5 mt-5">
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center mb-5"> Opportunity Updates </h3>
                <div class="row">
                    <div class="col-md-12">
                      @if(count($opportunity->opp_updates) >=1)
                        @foreach($opportunity->opp_updates as $update)
                        <div class="media"> <img class="mr-3 rounded-circle" alt="Bootstrap Media Preview" src="https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_360,h_360/https://al-azharinternationalcollege.com/wp-content/uploads/2017/08/avatar.png" />
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-8 d-flex">
                                        <h5>{{$update->user ?$update->user->name:''}} {{$update->user ?$update->user->last_name:''}}</h5> <span>&nbsp; <i class="fa fa-clock" aria-hidden="true"></i> {{ date("jS F, Y", strtotime($update->update_date)) }}</span>
                                        <span>&nbsp; <i class="fa fa-star text-blue" aria-hidden="true"></i>&nbsp;{{$update->type}}</span>
                                    </div>
                                    <div class="col-4">
                                        <div class="pull-right reply"> <a href="#"><span><i class="fa fa-reply"></i> reply</span></a> </div>
                                    </div>
                                </div> {{$update->commments}}. <div class="media mt-4"> <a class="pr-3" href="#"><img class="rounded-circle" alt="Bootstrap Media Another Preview" src="https://i.imgur.com/xELPaag.jpg" /></a>
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-12 d-flex">
                                                <h5>Simona Disa</h5> <span>- 3 hours ago</span>
                                            </div>
                                        </div> letters, as opposed to using 'Content here, content here', making it look like readable English.
                                    </div>
                                </div>
                                <div class="media mt-3"> <a class="pr-3" href="#"><img class="rounded-circle" alt="Bootstrap Media Another Preview" src="https://i.imgur.com/nAcoHRf.jpg" /></a>
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-12 d-flex">
                                                <h5>John Smith</h5> <span>- 4 hours ago</span>
                                            </div>
                                        </div> the majority have suffered alteration in some form, by injected humour, or randomised words.
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                       @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <form method="post" action="{{ route('opportunity.update.store') }}" autocomplete="off" class="mt--3">
     @csrf
                                <div class="row">
     <input type="hidden" name="opportunity_id" value="{{$opportunity->id}}">
     <input type="hidden" name="user_id" value="{{loginUserId()}}">

                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('update_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="update_date_id">{{ __('Update Date') }}</label>
                                           
                                           <input type="text" name="update_date" class="form-control" id="update_date" data-toggle="datepicker" required>
                                            @if ($errors->has('update_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('update_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('Type') }}</label>
                                            <select name="type" id="type_id" class="form-control" placeholder="{{ __('type') }}" value="{{ old('type') }}" required>
                                               <option value="">Select type</option>
                                               <option value="Phone">Phone</option>
                                               <option value="Email">Email</option>
                                               <option value="Online Meeting">Online Meeting
                                               </option>
                                               <option value="Physical Meeting">Physical Meeting</option>
                                               <option value="General">General</option>
                                            </select>
                                            @if ($errors->has('type'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('type') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                          </div>
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('commments') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-comment">{{ __('Comment') }}</label>
                                            <textarea class="form-control" name="commments" id="commments_id" placeholder="Type commments" rows="4" required></textarea>

                                            @if ($errors->has('commments'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('commments') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
            <div class="text-center">
    <button type="submit" class="btn btn-success mt-4" id="submitRenewalButton">{{ __('Submit') }}</button>
  </div>
</form>
</div>

  </div>

</div>

            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection