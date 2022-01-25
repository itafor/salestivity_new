
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
