@extends('layouts.app', ['title' => __('Recurring Management'), 'icon' => 'las la-file-invoice-dollar'])
@section('content')
@include('users.partials.header', ['title' => __('View Recurring')])  
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
@if(isset($renewal))
    <div class="row">

    @include('billing.renewal.renewalDetails')
     
        </div>
        
        @include('layouts.footers.auth')
       
    @include('billing.renewal.payment.create')
    @else
<div class="col-4 text-right">
    End of records
    <a href="{{ route('billing.renewal.invoice.view', ['all']) }}" class="btn-icon btn-tooltip" title="{{ __('Back to List') }}"><i class="fas fa-arrow-right"></i></a>
</div>
    @endif
    </div>

@endsection

