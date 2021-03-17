@extends('layouts.app', ['title' => __('User Management'), 'icon' => 'las la-compass'])
@section('content')
@include('users.partials.header', ['title' => __('Opportunity')])




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
                                <a href="{{ route('opportunity.view',[$opportunity->id]) }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
  <div class="card-body">
         <form method="post" action="{{ route('opportunity.update') }}" autocomplete="off" id="form1">
                            @csrf
                            <div class="pl-lg-4">
                                <input type="hidden" name="opportunity_id" value="{{$opportunity->id}}">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('opportunity_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-opportunity">{{ __('Opportunity Name') }}</label>
                                            <input type="text" name="opportunity_name" id="input-opportunity" class="form-control form-control-alternative{{ $errors->has('opportunity_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Opportunity Name') }}" value="{{ $opportunity->name }}" required>

                                            @if ($errors->has('opportunity_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('opportunity_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('account') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-account">{{ __('Account') }}</label>
                                            <select name="account_id" id="customer" class="form-control form-control-alternative{{ $errors->has('account_id') ? ' is-invalid' : '' }}" >
                                                
                                                @foreach($customers as $customer)
                                                    <option {{ $customer->id == $opportunity->customer->id ? 'selected': '' }} value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('account_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('account_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                              
                                    <div class="col-xl-12">
                                        <div class="form-group{{ $errors->has('contact') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-contact">{{ __('Contact') }}</label>
                                            <select name="contact" id="contact_emails" class="form-control form-control-alternative{{ $errors->has('contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Contact') }}" value="{{ old('contact') }}">
                                                <!-- Automatically filled according to an account picked using jquery -->
                                                    <option value="{{ $opportunity->contact_person ? $opportunity->contact_person->id : '' }}">{{ $opportunity->contact_person ? $opportunity->contact_person->surname .' '.$opportunity->contact_person->name : '' }}</option>
                                            </select>
                                            @if ($errors->has('contact'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contact') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('probability') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-probability">{{ __('Probability(%)') }}</label>
                                            <select  name="probability" id="input-probability" class="form-control form-control-alternative{{ $errors->has('probability') ? ' is-invalid' : '' }}">
                                                <option value="{{$opportunity->probability}}">{{$opportunity->probability}}%</option>
                                                <option value="1">1%</option>
                                                <option value="25">25%</option>
                                                <option value="50">50%</option>
                                                <option value="75">75%</option>
                                                <option value="99">99%</option>
                                            </select>

                                            @if ($errors->has('probability'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('probability') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-amount">{{ __('Amount(₦)') }}</label>
                                            <input type="text" name="amount" id="input-amount" class="form-control form-control-alternative{{ $errors->has('probability') ? ' is-invalid' : '' }}" placeholder="{{ __('Amount') }}" value="{{ $opportunity->amount }}">

                                            @if ($errors->has('amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('initiation_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-initiation_date">{{ __('Initiation Date') }}</label>
                                            <input type="text" name="initiation_date" id="input-initiation_date" class="form-control form-control-alternative{{ $errors->has('initiation_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Initiation Date') }}" value="{{ \Carbon\Carbon::parse($opportunity->initiation_date)->format('d/m/Y')  }}" data-toggle="datepicker" required>

                                            @if ($errors->has('initiation_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('initiation_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('closure_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-closure_date">{{ __('Expected Closure Date') }}</label>
                                            <input type="text" name="closure_date" id="input-closure_date" class="form-control form-control-alternative{{ $errors->has('closure_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Expected Closure Date') }}" value="{{ \Carbon\Carbon::parse($opportunity->closure_date)->format('d/m/Y')  }}" data-toggle="datepicker" required>

                                            @if ($errors->has('closure_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('closure_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('owner') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-owner">{{ __('Owner') }} </label>

                                            <select name="owner_id" class="form-control" >
                                                    @if(count(mySubUsers()) >=1)
                                                @foreach(mySubUsers() as $owner)
                                                    <option value="{{ $owner->id }}" {{$owner->email == authUser()->email ? 'selected':''}}>{{ $owner->name }} {{ $owner->last_name }}</option>
                                                @endforeach
                                                 @else

                                                 <option value="{{subuser(authUser()->email)['id']}}">{{subuser(authUser()->email)['name']}} {{subuser(authUser()->email)['last_name']}}</option>

                                                 @endif
                                            </select>

                                            @if ($errors->has('owner'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('owner') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('contact') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                                            <select name="status" id="status" class="form-control form-control-alternative border-input {{ $errors->has('status') ? ' is-invalid' : '' }}" placeholder="{{ __('Status') }}" value="{{ old('status') }}">
                                                <option value="{{$opportunity->status}}">{{$opportunity->status}}</option>
                                                <option value="Prospecting">Prospecting</option>
                                                <option value="Qualifying">Qualifying</option>
                                                <option value="Needs Analysis">Needs Analysis</option>
                                                <option value="Presentation">Presentation</option>
                                                <option value="Proposal">Proposal</option>
                                                <option value="Negotiation">Negotiation</option>
                                                <option value="Closed Won">Closed Won</option>
                                                <option value="Closed Lost">Closed Lost</option>
                                            </select>
                                            @if ($errors->has('contact'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contact') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                   <h3>Products</h3>
                                <div class="row">
                                    <div class="col-xl-6">
                                        @forelse($opportunity->opp_product as $product)
                                            <span class="badge bg-purple">{{ $product->produc ? $product->produc->name : 'N/A'  }} </span>
                                            <small class="removeProduct" style="color: red; margin-top: -100px; cursor: pointer;"> 
                                        <a onclick="return confirm_delete()"  href="{{route('items.destroy',['opportunityProduct',$product->id])}}" title="Delete"><button type="button" class="btn btn-sm btn-danger">x</button></a></small> 
                                        @empty
                                            <span class="badge bg-purple">No Product Added</span>
                                        @endforelse
                                    </div>
                       </div>
                 

          @include('product.add_new')


                    <div class="row">
                                    <div class="col-xl-12 button">
                                        @if($products)
                                @foreach($products as $product)
                                        <label>
                            <input type="checkbox" name="products[]" value="{{$product->id}}">
                                  {{$product->name}} </label>
                                  
                            @endforeach
                            @error('products')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                                  @else
                                  <small>No product found</small>
                                  @endif

                                    </div>
                                </div>
                               

                             
                                <div class="text-center">
                                    <button type="submit" id="save" class="btn btn-success mt-4">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </form>
             
  </div>
</div>


            </div>
        </div>
          @include('product.more_product')
        @include('layouts.footers.auth')
    </div>

@endsection