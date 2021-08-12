@extends('layouts.app', ['title' => __('Invoice Management'), 'icon' => 'las la-receipt'])
@section('content')
@include('users.partials.header', ['title' => __('View Invoice')])  


<div class="container-fluid mt--7 main-container">
        <div class="row">
         @include('billing.invoice.invoiceDetails')
        </div>
        
        @include('layouts.footers.auth')
       
    @include('billing.invoice.payment.create')

    </div>

@endsection