
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
          <div class="col-xl-4 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                <div class="row">
                 <div class="col">
                            <h3 class="card-title text-uppercase mb-0 float-left">Open Opportunities </h3>
                    
                             <div class="icon icon-shape bg-danger text-white rounded-circle shadow float-right">
                                        <i class="fas fa-door-open"></i>
                            </div>
                    </div>
                </div>
                            <div class="row">
                                <div class="col">
                                     <span class="text-nowrap"> {{$current_month}} ({{$current_month_opportunities_count}}) : </span>
                                    <span class="h4 font-weight-bold mb-0">&#8358;{{number_format($current_month_opportunities_amt_sum, 2)}} </span>
                                </div>
                            </div>

                            @if($formatted_opp_percentage_change > 0)
                             <div class="row">
                                <div class="col">
                                <span class="text-nowrap">Since last month : </span>
                                     <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>   {{abs($formatted_opp_percentage_change)}}%</span>
                                </div>
                            </div>
                            @elseif($formatted_opp_percentage_change < 0)
                             <div class="row">
                                <div class="col">
                                <span class="text-nowrap">Since last month : </span>
                                    <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i>  {{abs($formatted_opp_percentage_change)}}%</span>
                                </div>
                            </div>
                             @elseif($last_month_opportunities_amt_sum == 0 && $current_month_opportunities_amt_sum == 0)
                              <div class="row">
                                <div class="col">
                                <span class="text-nowrap">Since last month  : </span>
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>  0 %</span>
                                </div>
                            </div>
                             @elseif($last_month_opportunities_amt_sum == 0)
                               <div class="row">
                                <div class="col">
                                <span class="text-nowrap">Since last month : </span>
                                <span class="text-success mr-2"> <i class="fas fa-arrow-up"></i>  100 %</span>
                                </div>
                            </div>
                             @elseif($last_month_opportunities_amt_sum ==  $current_month_opportunities_amt_sum)
                            <div class="row">
                                <div class="col">
                                 <span class="text-nowrap">Since last month : </span>
                                 <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 0 %</span>
                                </div>
                            </div>
                            @else
                             <div class="row">
                                <div class="col">
                                 <span class="text-nowrap">Since last month : </span>
                                 <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> {{$formatted_opp_percentage_change}} %</span>
                                </div>
                            </div>
                            @endif

                              <div class="row">
                                <div class="col">
                                <span class="text-nowrap">Year to Date ({{$ytd_opp_count}}) : </span>
                                    <span class="h4 font-weight-bold mb-0"> &#8358;{{number_format($ytd_opportunities_amt_sum, 2)}} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    
                <!-- Won opportunities -->
                
                <div class="col-xl-4 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                   
                        <div class="row">
                 <div class="col">
                             <h3 class="card-title text-uppercase mb-0 float-left">Won Opportunities</h3>
                    
                             <div class="icon icon-shape bg-success text-white rounded-circle shadow float-right">
                                       <i class="fas fa-trophy"></i>
                            </div>
                    </div>
                </div>
                            <div class="row">
                               <div class="col">
                                 <span class="text-nowrap">{{$current_month}} ({{$current_month_won_opportunities_count}}) :  </span>
                                <span class="h4 font-weight-bold mb-0">&#8358;{{number_format($current_month_won_opportunities_amt_sum, 2)}}</span>
                                </div>
                            </div>
                      @if($won_opp_percentage_change > 0)
                            <div class="row">
                               <div class="col">
                                <span class="text-nowrap">Since last month : </span> 
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i>   {{abs($won_opp_percentage_change)}}%</span>
                                </div>
                            </div>
                      @elseif($won_opp_percentage_change < 0)
                             <div class="row">
                               <div class="col">
                                <span class="text-nowrap">Since last month : </span> 
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i>  {{abs($won_opp_percentage_change)}}%</span>
                                </div>
                            </div>
                    @elseif($last_month_won_opportunities_amt_sum == 0 && $current_month_won_opportunities_amt_sum == 0)
                            <div class="row">
                               <div class="col">
                                <span class="text-nowrap">Since last month : </span> 
                               <span class="text-success mr-2">   <i class="fas fa-arrow-up"></i>  0 %</span>
                                </div>
                            </div>
                 @elseif($last_month_won_opportunities_amt_sum == 0)
                <div class="row">
                       <div class="col">
                        <span class="text-nowrap">Since last month : </span> 
                       <span class="text-success mr-2">   <i class="fas fa-arrow-up"></i>  100 %</span>
                        </div>
                    </div>

             @elseif($last_month_won_opportunities_amt_sum == $current_month_won_opportunities_amt_sum)
                    <div class="row">
                       <div class="col">
                        <span class="text-nowrap">Since last month : </span> 
                        <span class="text-success mr-2">   <i class="fas fa-arrow-up"></i>  0 %</span>
                        </div>
                    </div>

                    @else
                    <div class="row">
                       <div class="col">
                        <span class="text-nowrap">Since last month : </span> 
                        <span class="text-success mr-2">   <i class="fas fa-arrow-up"></i> {{$won_opp_percentage_change}} %</span>
                        </div>
                    </div>

                    @endif
                             <div class="row">
                                <div class="col">
                                <span class="text-nowrap">Year to Date ({{$ytd_won_opp_count}}) : </span>
                                    <span class="h4 font-weight-bold mb-0"> &#8358;{{number_format($ytd_won_opportunities_amt_sum, 2)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0 dashboardReport">
                        <div class="card-body">

                <div class="row">
                   <div class="col">
                      <h3 class="card-title text-uppercase mb-0  float-left">Paid Invoice</h3>
                         <div class="icon icon-shape bg-info text-white rounded-circle shadow float-right">
                                <i class="fas fa-file-invoice"></i>
                          </div>
                    </div>
                </div>

                            <div class="row">
                                <div class="col">
                                <span class="text-nowrap">{{$current_month}} ({{$current_month_paid_invoice_count}}) : </span>

                                 <span class="h4 font-weight-bold mb-0">&#8358;{{number_format($current_month_paid_invoice_amount, 2)}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                <span class="text-nowrap">Year to Date ({{$ytd_paid_invoice_count}}) : </span>

                                 <span class="h4 font-weight-bold mb-0">&#8358;{{number_format($ytd_paid_invoice_amount, 2)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-xl-4 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0 dashboardReport">
                        <div class="card-body">
                      

                <div class="row">
                 <div class="col">
                  <h3 class="card-title text-uppercase mb-0 float-left">Outstanding Invoice </h3>

                             <div class="icon icon-shape bg-yellow text-white rounded-circle shadow float-right">
                                        <i class="fas fa-file-invoice"></i>
                            </div>
                    </div>
                </div>

                            <div class="row">
                                <div class="col">
                                <span class="text-nowrap">{{$current_month}} ({{$current_month_outstanding_invoice_count}}) : </span>

                                    <span class="h4 font-weight-bold mb-0">&#8358;{{number_format($current_month_outstanding_invoice_amount, 2)}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                <span class="text-nowrap">Year to Date ({{$ytd_outstanding_invoice_count}}) : </span>
                                    
                                    <span class="h4 font-weight-bold mb-0">&#8358;{{number_format($ytd_outstanding_invoice_amount, 2)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        

                    <div class="col-xl-4 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0 dashboardReport">
                        <div class="card-body">

                <div class="row">
                 <div class="col">
                        <h3 class="card-title text-uppercase mb-0 float-left">Paid Recurring</h3>
                           
                    
                             <div class="icon icon-shape bg-info text-white rounded-circle shadow float-right">
                                       <i class="fas fa-credit-card"></i>
                            </div>
                    </div>
                </div>

                            <div class="row">
                                <div class="col">
                                <span class="text-nowrap">{{$current_month}} ({{$paid_recurring_count_for_current_month}}): </span>

                                    <span class="h4 font-weight-bold mb-0">&#8358;{{number_format($paid_recurring_amount_for_current_month, 2)}}</span>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col">
                                <span class="text-nowrap">Year to Date ({{$paid_recurring_count_for_year_to_date}}) : </span>

                                    <span class="h4 font-weight-bold mb-0">&#8358;{{number_format($paid_recurring_amount_for_year_to_date, 2)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="col-xl-4 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0 dashboardReport">
                        <div class="card-body">
                        

                 <div class="row">
                 <div class="col">
                        <h3 class="card-title text-uppercase mb-0 float-left">Outstanding Recurring</h3>
                           
                             <div class="icon icon-shape bg-yellow text-white rounded-circle shadow float-right">
                                       <i class="fa fa-credit-card"></i>
                            </div>
                    </div>
                </div>
                            <div class="row">
                                <div class="col">
                                <span class="text-nowrap">{{$current_month}} ({{$current_month_outstanding_renewal_count}}) : </span>
                               <span class="h4 font-weight-bold mb-0">&#8358;{{number_format($current_month_outstanding_renewal_amt, 2)}}</span>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col">
                                <span class="text-nowrap">Year to date ({{$ytd__outstanding_renewal_count}}) : </span>
                               <span class="h4 font-weight-bold mb-0">&#8358;{{number_format($ytd_outstanding_renewal_amt, 2)}}</span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
         
             <!--  
                <div class="col-xl-4 col-lg-6">
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
                </div> -->
            </div>
        </div>
    </div>
</div>