@extends('layouts.app', ['title' => __('Add Renewal')])
@section('content')
@include('users.partials.header', ['title' => __('Add Renewal')])  


<script>
        $(document).ready(function(){
            /*Disable all input type="text" box*/
            $('#form1 input').prop("disabled", true);
            $('#form1 select').prop("disabled", true);
            $('#form1 button').hide();

            $('#edit').click(function(){
            $('#form1 input').prop("disabled", false);
            $('#form1 select').prop("disabled", false);
            $('#form1 button').show();
            $('#title').html('Edit Renewal');
            $('#edit').toggle();
            })
            
        });
	</script> 

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0" id="title">{{ __('View Renewal') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button id="edit" class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('billing.renewal.update', [$renewal->id]) }}" autocomplete="off" id="form1">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Renewal information') }}</h6>
                            <div class="pl-lg-4">
                              <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
                                  <div class="col-sm-6" data-toggle="select">
                                  <!-- pass in the customer_id to the pivot table ie customer_renewal -->
                                    <select name="customer_id" id="customer" class="form-control select2-multi" onchange="myFunction(event)">
                                        <option value="{{ $renewal->customer_id }}">{{ $renewal->customers->name }}</option>
                                        @foreach($customers as $key => $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- Pass in this name to the database and store in renewals table -->
                                    <input type="hidden" id="myText" class="form-control" name="customer" value="{{ $renewal->customer }}">
                                  </div>
                                  <script>
                                    function myFunction(e) {
                                    var sel = document.getElementById("customer");
                                    var text = sel.options[sel.selectedIndex].text; 
                                    document.getElementById("myText").value = text;
                                    }
                                  </script>
                                </div>
                                <div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="product">{{ __('Product') }}</label>
                                  <div class="col-sm-6" data-toggle="select">
                                    <select name="product" id="product" class="form-control" data-toggle="select">
                                        <option value="{{ $renewal->product }}">{{ $renewal->product }}</option>
                                            @foreach($products as $key => $product)
                                            <option value="{{ $product->name }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <!-- <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="amount">{{ __('Amount') }}</label>
                                    <input type="number" name="amount" id="amount" class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}" placeholder="{{ __('Amount') }}" value="{{ $renewal->amount }}" required >

                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div> -->
                                
                                <div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="start_date">{{ __('Start Date (in days)') }}</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control form-control-alternative{{ $errors->has('period') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Date') }}" value="{{ date('Y-m-d', strtotime($renewal->start_date)) }}" required>

                                    @if ($errors->has('start_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('start_date') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                                <div class="form-group{{ $errors->has('end_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="end_date">{{ __('End Date') }}</label>
                                    <input type="text" name="end_date" id="end_date" class="form-control form-control-alternative{{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="{{ __('End Date') }}" value="{{ date('Y-m-d', strtotime($renewal->end_date)) }}" required>

                                    @if ($errors->has('period'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('period') }}</strong>
                                        </span>
                                    @endif
                                </div>                                  

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @include('billing.renewal.payment.show')
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection