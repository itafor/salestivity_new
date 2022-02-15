 <div class="col-12">
    <div class="table-responsive">
 <table class="table table-bordered invoices">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Start Date') }}</th>
                                            <th scope="col">{{ __('Account') }}</th>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Amount') }}</th>                                           
                                            <th scope="col">{{ __('Owner') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>                                           
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($opportunities->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($opportunities as $opportunity)
                                                <tr>
                                                
                                                    <td>
                    {{ date('Y/m/d', strtotime($opportunity->initiation_date)) }}
                                                        
                                                    </td>
                                                    <td>{{ $opportunity->customer ? $opportunity->customer->name : 'N/A'}}</td>
                                                    <td>{{ $opportunity->name }}</td>
                                                     <td>{{ number_format($opportunity->amount,2) }} </td>
                                                     <td>{{ $opportunity->owner ? $opportunity->owner->name .' '.$opportunity->owner->last_name : 'N/A'  }}</td>
                                                    
                                                    <td>{{ $opportunity->status }}</td>
                                                  
                                                    <td>
                                                        <a href="{{ route('opportunity.show', [$opportunity->id]) }}" title="View" class="btn-icon btn-tooltip">
                                                            
                                                            <i class="las la-eye"></i>
                                                           
                                                        </a>

                                                         <a onclick="return confirm_delete()"  href="{{route('items.destroy',['opportunity',$opportunity->id])}}" title="Delete" class="btn-icon btn-tooltip">
                                                             <i class="las la-trash"></i>
                                                      
                                                            
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                </div>
                                 </div>