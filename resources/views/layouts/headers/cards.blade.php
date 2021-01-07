
@if ( auth()->user()->name !== '' )
    @include('users.partials.header', ['title' => __('Welcome') . ' '. auth()->user()->name,
    ]) 

@else
    @include('users.partials.header', ['title' => __('Welcome')]) 

@endif
<div class="header  cards-wrap pb-8 pt-md-0 pt--5">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                      @if($formatted_opp_percentage_change > 0)
                      <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                 <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Open Opportunities ({{$last_month_plus_current_month_opp_count}})</h5>
                                    <span class="h2 font-weight-bold mb-0">&#8358; {{number_format($last_month_plus_current_month_opp_amt_sum, 2)}}</span>
                                </div>
                               <!--  <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>   {{abs($formatted_opp_percentage_change)}}%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                @elseif($formatted_opp_percentage_change < 0)
          <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Open Opportunities ({{$last_month_plus_current_month_opp_count}})</h5>
                                    <span class="h2 font-weight-bold mb-0">&#8358; {{number_format($last_month_plus_current_month_opp_amt_sum, 2)}}</span>
                                </div>
                              <!--   <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i>  {{abs($formatted_opp_percentage_change)}}%</span>
                                <span class="text-nowrap">Since last month </span>
                            </p>
                        </div>
                    </div>
                </div>
                 @elseif($last_month_opportunities_amt_sum == $current_month_opportunities_amt_sum)
          <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Open Opportunities ({{$last_month_plus_current_month_opp_count}})</h5>
                                    <span class="h2 font-weight-bold mb-0">&#8358; {{number_format($last_month_plus_current_month_opp_amt_sum, 2)}}</span>
                                </div>
                              <!--   <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"> &#8596;<!--  <i class="fas fa-arrow-down"></i> -->  {{abs($formatted_opp_percentage_change)}}%</span>
                                <span class="text-nowrap">Since last month </span>
                            </p>
                        </div>
                    </div>
                </div>
                @else
     <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Open Opportunities ({{$last_month_plus_current_month_opp_count}})</h5>
                                    <span class="h2 font-weight-bold mb-0">&#8358; {{number_format($last_month_plus_current_month_opp_amt_sum, 2)}}</span>
                                </div>
                              <!--   <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 0 won opp. since last month</span>
                                <span class="text-nowrap"><!-- since last month --> </span>
                            </p>
                        </div>
                    </div>
                </div>

                @endif
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Open Opportunities ({{$current_month_opportunities_count}})  </h5>
                                    <span class="h2 font-weight-bold mb-0">  &#8358; {{number_format($current_month_opportunities_amt_sum, 2)}}</span>

                                </div>
                               <!--  <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0  text-sm">
                                <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span> -->
                                <span class=""> </span>
                                <span class="text-nowrap text-muted">Since current month ({{$current_month}})</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">OPEN OPPORTUNITIES ({{$ytd_opp_count}})</h5>
                                    <span class="h2 font-weight-bold mb-0">&#8358; {{number_format($ytd_opportunities_amt_sum, 2)}}</span>
                                </div>
                               <!--  <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <!-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span> -->
                                <span class="text-nowrap">Since {{$current_month}}, {{$formated_current_yr}} (YTD)</span>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Won opportunities -->
                 @if($won_opp_percentage_change > 0)
                      <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                 <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Won Opportunities ({{$last_month_plus_current_month_won_opp_count}})</h5>
                                    <span class="h2 font-weight-bold mb-0">&#8358; {{number_format($last_month_plus_current_month_won_opp_amt_sum, 2)}}</span>
                                </div>
                               <!--  <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>   {{abs($won_opp_percentage_change)}}%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                @elseif($won_opp_percentage_change < 0)
          <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Won Opportunities ({{$last_month_plus_current_month_won_opp_count}})</h5>
                                    <span class="h2 font-weight-bold mb-0">&#8358; {{number_format($last_month_plus_current_month_won_opp_amt_sum, 2)}}</span>
                                </div>
                              <!--   <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i>  {{abs($won_opp_percentage_change)}}%</span>
                                <span class="text-nowrap">Since last month </span>
                            </p>
                        </div>
                    </div>
                </div>
                 @elseif($last_month_won_opportunities_amt_sum == $current_month_won_opportunities_amt_sum)
          <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Won Opportunities ({{$last_month_plus_current_month_won_opp_count}})</h5>
                                    <span class="h2 font-weight-bold mb-0">&#8358; {{number_format($last_month_plus_current_month_won_opp_amt_sum, 2)}}</span>
                                </div>
                              <!--   <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2">  &#8596; <!-- <i class="fas fa-arrow-down"></i>  --> {{abs($won_opp_percentage_change)}}%</span>
                                <span class="text-nowrap">Since last month </span>
                            </p>
                        </div>
                    </div>
                </div>
                @else
     <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Won Opportunities ({{$last_month_plus_current_month_won_opp_count}})</h5>
                                    <span class="h2 font-weight-bold mb-0">&#8358; {{number_format($last_month_plus_current_month_won_opp_amt_sum, 2)}}</span>
                                </div>
                              <!--   <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 0 won opp. since last month</span>
                                <span class="text-nowrap"> </span>
                            </p>
                        </div>
                    </div>
                </div>

                @endif
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Won Opportunities ({{$current_month_won_opportunities_count}})  </h5>
                                    <span class="h2 font-weight-bold mb-0">  &#8358; {{number_format($current_month_won_opportunities_amt_sum, 2)}}</span>

                                </div>
                               <!--  <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0  text-sm">
                                <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span> -->
                                <span class=""> </span>
                                <span class="text-nowrap text-muted">Since current month ({{$current_month}})</span>
                            </p>
                        </div>
                    </div>
                </div>
                    <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Won OPPORTUNITIES ({{$ytd_won_opp_count}})</h5>
                                    <span class="h2 font-weight-bold mb-0">&#8358; {{number_format($ytd_won_opportunities_amt_sum, 2)}}</span>
                                </div>
                               <!--  <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div> -->
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <!-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span> -->
                                <span class="text-nowrap">Since {{$current_month}}, {{$formated_current_yr}} (YTD)</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Unpaid Invoices</h5>
                                    <span class="h2 font-weight-bold mb-0">924</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                <span class="text-nowrap">Since yesterday</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Due Renewals</h5>
                                    <span class="h2 font-weight-bold mb-0">924</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                <span class="text-nowrap">Since yesterday</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Paid Renewals</h5>
                                    <span class="h2 font-weight-bold mb-0">924</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                <span class="text-nowrap">Since yesterday</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Unpaid Invoices</h5>
                                    <span class="h2 font-weight-bold mb-0">924</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                <span class="text-nowrap">Since yesterday</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>