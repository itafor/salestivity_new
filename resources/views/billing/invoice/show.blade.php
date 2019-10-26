@extends('layouts.app', ['title' => __('View Invoice')])
@section('content')
@include('users.partials.header', ['title' => __('View Invoice')])  

<script>
        $(document).ready(function(){
            /*Disable all input type="text" box*/
            $('#form1 input').prop("disabled", true);
            $('#form1 select').prop("disabled", true);
            $('#form1 button').hide();

            $('#edit').click(function(){
            $('#form1 input').prop("disabled", false);
            $('#form1 select').prop("disabled", false);
            $('#title').html('Edit Invoice');
            $('#form1 button').show();
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
                                <h3 class="mb-0" id="title">{{ __('View Invoice') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button href="{{ route('billing.invoice.index') }}" id="edit" class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('billing.invoice.update', [$invoice->id]) }}" id="form1" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Invoice information') }}</h6>
                            <div class="pl-lg-4">
                              <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
                                  <div class="col-sm-6" >
                                  <!-- pass in the customer_id to the pivot table ie customer_invoice -->
                                    <select name="customer_id" id="customer" class="form-control " onchange="myFunction(event)">
                                        <option value="{{ $invoice->customers->id }}">{{ $invoice->customers->name }}</option>
                                            @foreach($customers as $key => $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- Pass in this name to the database and store in invoices table -->
                                    <input type="hidden" id="myText" class="form-control" name="customer" value="{{ $invoice->customer }}">
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
                                        <option value="{{ $invoice->product }}">{{ $invoice->getProductName($invoice->product) }}</option>
                                            @foreach($products as $key => $product)
                                            <option value="{{ $product->name }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="cost">{{ __('Cost') }}</label>
                                    <input type="number" name="cost" id="cost" class="form-control form-control-alternative{{ $errors->has('cost') ? ' is-invalid' : '' }}" placeholder="{{ __('Cost') }}" value="{{ $invoice->cost }}" required >

                                    @if ($errors->has('cost'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cost') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="status">{{ __('Status') }}</label>
                                    <select name="status" id="" class="form-control">
                                    <option value="{{ $invoice->status }}">{{ $invoice->status }}</option>
                                      <option value="Confirmed">Confirmed</option>
                                      <option value="Not Confirmed">Not Confirmed</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="form-group{{ $errors->has('timeline') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="timeline">{{ __('Timeline (in days)') }}</label>
                                    <input type="text" name="timeline" id="timeline" class="form-control form-control-alternative{{ $errors->has('timeline') ? ' is-invalid' : '' }}" placeholder="{{ __('Timeline') }}" value="{{ $invoice->timeline }}" required>

                                    @if ($errors->has('timeline'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('timeline') }}</strong>
                                        </span>
                                    @endif
                                </div>                             

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if($payments->isEmpty() )
                    
                    @else
                        @include('billing.invoice.payment.show')
                    @endif
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection