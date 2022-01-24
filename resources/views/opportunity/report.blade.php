@extends('layouts.app', ['title' => __('Opportunities'), 'icon' => 'las la-compass'])
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

        <form method="post" action="{{ route('opportunity.get.report') }}" autocomplete="off" id="opportunityReportForm">
             @csrf
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputEmail4">Sales Person</label>
            <select name="owner_id" id="owner_id" class="form-control form-control-alternative border-input {{ $errors->has('owner_id') ? ' is-invalid' : '' }} reportselectOption" placeholder="{{ __('Sales Person') }}" value="{{ old('owner_id') }}" required>
             @if(isset($selectedSalesPerson) && $selectedSalesPerson !='')
              <option value="{{$selectedSalesPerson == 'All' ? 'All' : $selectedSalesPerson->id }}">{{$selectedSalesPerson == 'All' ? 'All' : $selectedSalesPerson->name.' '.$selectedSalesPerson->last_name }}</option>
               @endif
            <option value="">Select</option>
            <option value="All">All</option>
            @foreach(mySubUsers() as $owner)
                <option value="{{ $owner->id }}"> {{ $owner->name }} {{ $owner->last_name }}  </option>
            @endforeach
            </select>
    </div>
    <div class="form-group col-md-4">
      <label for="inputPassword4">Account</label>
                <select name="account_id" id="customer" class="form-control form-control-alternative border-input {{ $errors->has('account_id') ? ' is-invalid' : '' }} reportselectOption" placeholder="{{ __('Account') }}" value="{{ old('account_id') }}" required>
                   @if(isset($selectedAccount) && $selectedAccount !='')
              <option value="{{$selectedAccount == 'All' ? 'All' : $selectedAccount->id }}">{{$selectedAccount == 'All' ? 'All' : $selectedAccount->name }}</option>
               @endif
               
            <option value="">Select</option>
                <option value="All">All</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
                </select>
    </div>
     <div class="form-group col-md-4">
      <label for="inputPassword4">Stage</label>
            <select name="status" id="status" class="form-control form-control-alternative border-input {{ $errors->has('status') ? ' is-invalid' : '' }} reportselectOption" placeholder="{{ __('Status') }}" value="{{ old('status') }}" required>
                  @if(isset($selectedstatus) && $selectedstatus !='')
              <option value="{{$selectedstatus}}">{{$selectedstatus}}</option>
               @endif
            <option value="">Select</option>
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
  <div class="form-row">
    <div class="form-group col-md-4">

             <label class="control-label col-sm-4" for="date">Amount:</label>
            <div class="col-md-12 stack-input">
                <input id="amount1" type="number" min="1" class="form-control" name="amount_from" value="{{$selectedAmountFrom !='' ? $selectedAmountFrom : ''}}" placeholder="From" required>
                <input id="amount2" type="number" min="1" class="form-control" name="amount_to" value="{{$selectedAmountTo !='' ? $selectedAmountTo : ''}}" placeholder="To" required>
            </div>
      
  </div>

  <div class="form-group col-md-4">
            <label class="control-label col-sm-6" for="date">Initiation Date:</label>
            <div class="col-md-12 stack-input">
                <input id="date1" type="text" class="form-control" name="init_date_from" value="{{$selectedInitDateFrom !='' ? \Carbon\Carbon::parse($selectedInitDateFrom)->format('d/m/Y') : ''}}" placeholder="From" data-toggle="datepicker" required> 
                <input id="date2" type="text" class="form-control" name="init_date_to" value="{{$selectedInitDateTo !='' ? \Carbon\Carbon::parse($selectedInitDateTo)->format('d/m/Y') : ''}}" placeholder="To" data-toggle="datepicker" required>
            </div>
</div>
     <div class="form-group col-md-4">

             <label class="control-label col-sm-6" for="date">Closure Date:</label>
            <div class="col-md-12 stack-input">
                <input id="date1" type="text" class="form-control" name="closure_date_from" value="{{$selectedClosureDateFrom !='' ? \Carbon\Carbon::parse($selectedClosureDateFrom)->format('d/m/Y') : ''}}" placeholder="From" data-toggle="datepicker" required>
                <input id="date2" type="text" class="form-control" name="closure_date_to" value="{{$selectedClosureDateTo !='' ? \Carbon\Carbon::parse($selectedClosureDateTo)->format('d/m/Y') : ''}}" placeholder="To" data-toggle="datepicker" required>
            </div>
      
  </div>
</div>

 <div class="text-right">
     <button type="button" class="btn btn-warning btn-sm" onclick="resetOpportunityReport()">Reset</button>

        <button type="submit" class="btn btn-primary btn-sm">{{ __('Search') }}</button>
    </div>
  
</form>
  </div>
</div>
@if(isset($opportunities_report_details))
<div class="card">
  <div class="card-header">
    <div class="col-md-12">
      <h2 class="float-left"> Opportunities Record List</h2>
    <a href="{{route('export.csv')}}" target="_blank" class="btn btn-primary me-1 btn-sm float-right">Export CSV</a>

    </div>
   

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