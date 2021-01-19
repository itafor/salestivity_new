@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Opportunity Report Details')])

<div class="container-fluid mt--7 ">

    <div class="card">
  <div class="card-header">
    Reports
  </div>
  <div class="card-body">
    @if($errors->any())
    <div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    <strong>{{ implode(', ', $errors->all(':message')) }}</strong>
</div>
@endif



<!-- @if ($errors->any())
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    Please check the form below for errors
</div>
@endif -->
        <form method="post" action="{{ route('opportunity.get.report') }}" autocomplete="off">
             @csrf
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputEmail4">Sales Person</label>
            <select name="owner_id" id="owner_id" class="form-control form-control-alternative border-input {{ $errors->has('owner_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Sales Person') }}" value="{{ old('owner_id') }}" >
            <option value="All">All</option>
            @foreach(mySubUsers() as $owner)
                <option value="{{ $owner->id }}"> {{ $owner->name }} {{ $owner->last_name }}  </option>
            @endforeach
            </select>
    </div>
    <div class="form-group col-md-4">
      <label for="inputPassword4">Account</label>
                <select name="account_id" id="customer" class="form-control form-control-alternative border-input {{ $errors->has('account_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Account') }}" value="{{ old('account_id') }}" >
                <option value="All">All</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
                </select>
    </div>
     <div class="form-group col-md-4">
      <label for="inputPassword4">Stage</label>
            <select name="status" id="status" class="form-control form-control-alternative border-input {{ $errors->has('status') ? ' is-invalid' : '' }}" placeholder="{{ __('Status') }}" value="{{ old('status') }}">
            <option value="All">All</option>
            <option value="Prospecting">Prospecting</option>
            <option value="Qualifying">Qualifying</option>
            <option value="Needs Analysis">Needs Analysis</option>
            <option value="Presentation">Presentation</option>
            <option value="Proposal">Proposal</option>
            <option value="Negotiation">Negotiation</option>
            <option value="Closed Won">Closed Won</option>
            <option value="Closed Lost">Closed Lost</option>
            </select>
    </div>
  </div>
  <div class="form-row col-md-12">
    <div class="form-group col-md-4">

             <label class="control-label col-sm-4" for="date">Amount:</label>
            <div class="col-md-12">
                <input id="amount1" type="number" min="1" class="form-control" name="amount_from" value="" placeholder="From">
                <input id="amount2" type="number" min="1" class="form-control" name="amount_to" value="" placeholder="To">
            </div>
      
  </div>

  <div class="form-group col-md-4">
            <label class="control-label col-sm-6" for="date">Initiation Date:</label>
            <div class="col-md-12">
                <input id="date1" type="text" class="form-control" name="init_date_from" value="" placeholder="From" data-toggle="datepicker"> 
                <input id="date2" type="text" class="form-control" name="init_date_to" value="" placeholder="To" data-toggle="datepicker">
            </div>
</div>
     <div class="form-group col-md-4">

             <label class="control-label col-sm-6" for="date">Closure Date:</label>
            <div class="col-md-12">
                <input id="date1" type="text" class="form-control" name="closure_date_from" value="" placeholder="From" data-toggle="datepicker">
                <input id="date2" type="text" class="form-control" name="closure_date_to" value="" placeholder="To" data-toggle="datepicker">
            </div>
      
  </div>
</div>

 <div class="text-right">
     <button type="button" class="btn btn-warning">Reset</button>

        <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
    </div>
  
</form>
  </div>
</div>
@if(isset($opportunities_report_details))
<div class="card">
  <div class="card-header">
    Opportunities Record List
  </div>
  <div class="card-body">
        
                            <div class="table-responsive">
                                           <table class="table align-items-center table-flush" >
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Account') }}</th>
                                        <th scope="col">{{ __('Amount') }}</th>
                                        <th scope="col">{{ __('Stage | Probability') }}</th>
                                        <th scope="col">{{ __('Date Initiated') }}</th>
                                        <th scope="col">{{ __('Closure Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($opportunities_report_details->isEmpty())
                                        <tr>
                                            <td colspan="8" style="text-align: center">
                                                <h3>No data available</h3>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($opportunities_report_details as $report)
                                            <tr>
                                                <td>{{$report->opportunity_name}}</td>
                                                <td>{{$report->customer_name}}</td>
                                                 <td>&#8358;{{ number_format($report->opportunity_amount,2) }} </td>
                                                <td>{{$report->opportunity_status}} | {{$report->opportunity_probability}}%</td> 
                                               
                                                <td>{{ strftime('%d-%b-%Y', strtotime($report->opportunity_initiation_date)) }}</td>
                                                 <td>{{ strftime('%d-%b-%Y', strtotime($report->opportunity_closure_date)) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            </div>
  </div>
</div>
@endif 
    </div>

@endsection