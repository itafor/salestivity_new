@extends('layouts.app', ['title' => __('Subscription'), 'icon' => 'las la-gem' ])
@section('content')
@include('users.partials.header', ['title' => __('Subscription Management')])  
@section('style')
    <style>
        .dt-price {
            font-size: 20px !important;
        }
        .dt-pricing-items li{
            font-size: 12px !important;
        }
        ul{
            list-style-type: none;
        }
    </style>
@endsection
<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Upgrade Plan') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('project.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                     <div class="card-body">

                                <!-- Grid -->
                                <div class="row">
                    @foreach ($plans as $plan)

                                    <!-- Grid item -->
                                    <div class="col-xl-3">

                                        <!-- Pricing -->
                                        <div class="dt-pricing dt-pricing-classic bg-light-yellow">

                                            <!-- Pricing header -->
                                            <div class="dt-pricing__header">
                                                <h2 class="dt-price">&#x20A6;{{number_format($plan->amount, 2)}}/ annum</h2>
                                                <p class="dt-letter-spacing-base text-uppercase mb-0">{{$plan->name}}</p>
                                            </div>
                                            <!-- /pricing header -->

                                            <!-- Pricing body -->
                                            <div class="dt-pricing__body">

                                                <ul class="dt-pricing-items">
                                                    <li><i class="icon icon-fw icon-company mr-3"></i>Manage {{$plan->number_of_accounts}} Accounts
                                                    </li>
                                                   
                                                    <li><i class="icon icon-fw icon-user-o mr-3"></i>Manage {{$plan->number_of_subusers}} Sub Users
                                                    </li>
                                                </ul>

                                                <div class="pt-2">
                                                  <button onclick="getSelectedPlan({{$plan->id}})" class="btn btn-primary btn-sm">Upgrade</button>
                                                </div>

                                            </div>
                                            <!-- /pricing body -->

                                        </div>
                                        <!-- /pricing -->

                                    </div>
                                    <!-- /grid item -->
                      @endforeach

                                </div>
                                <!-- /grid -->



<hr>
<div id="payment_detail" style="display: none;">
<h2>Payment Details</h2>

               <table class="table table-bordered mt-2" style="background-color: #ffffff;">
                    <tbody>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Bank') }}</b></td>
                     <td> First Bank</td>
                   </tr>
                     <tr>
                     <td style="width: 200px;"><b>{{ __('Account Number') }}</b></td>
                     <td> 0975432321</td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Account Name') }}</b></td>
                     <td> Itafor Francis</td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Plan Name') }}</b></td>
                     <td id="plan_name"></td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Price') }}</b></td>
                     <td id="plan_price"></td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Number Of Sub users') }}</b></td>
                     <td id="number_of_subusers"></td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Number of Account') }}</b></td>
                     <td id="number_of_accounts">
                     </td>
                   </tr>
                    </tbody>
                   
                  </table> 

                  <form method="post" action="{{ route('update.plan') }}" class="mt-2" autocomplete="off">
                            @csrf
                            <input type="hidden" name="plan_id" id="plan_id">
                            <button onsubmit="return confirm("Are you sure")" type="submit" class="btn btn-primary btn-sm">Confirm</button>
                        </form>
                    </div>
                            </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
<script type="text/javascript">
    function getSelectedPlan(plan_id) {
          $('#payment_detail').css('display', 'inline-block');
         $.ajax({
        url: baseUrl + "/subcription/fetch-plan-details/" + plan_id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.plan);
            $("#plan_name").empty();
            $("#plan_price").empty();
            $("#number_of_subusers").empty();
            $("#number_of_accounts").empty();
            $("#plan_id").empty();

            $("#plan_name").append(data.plan.name);
            $("#plan_price").append(data.plan.amount);
            $("#number_of_subusers").append(data.plan.number_of_subusers);
            $("#number_of_accounts").append(data.plan.number_of_accounts);
            $("#plan_id").val(data.plan.id);
        },
    });
    }
</script>
@endsection