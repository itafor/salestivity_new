 <div class="col-12">
 <table class="table table-bordered align-items-center table-flush invoices">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Account') }}</th>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Owner') }}</th>
                                            <th scope="col">{{ __('Amount') }}</th>                                           
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
                                                
                                                    
                                                    <td>{{ $opportunity->customer ? $opportunity->customer->name : 'N/A'}}</td>
                                                    <td>{{ $opportunity->name }}</td>
                                                     <td>{{ $opportunity->owner ? $opportunity->owner->name .' '.$opportunity->owner->last_name : 'N/A'  }}</td>
                                                     <td>{{ number_format($opportunity->amount,2) }} </td>
                                                  
                                                    <td>
                                                        <a href="{{ route('opportunity.show', [$opportunity->id]) }}" title="View">
                                                            <button  class="btn btn-sm text-success">
                                                            <i class="las la-eye"></i>
                                                            </button>
                                                        </a>

                                                         <a onclick="return confirm_delete()"  href="{{route('items.destroy',['opportunity',$opportunity->id])}}" title="Delete"><button class="btn  text-danger">
                                                             <i class="las la-trash"></i>
                                                         </button>
                                                            
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                 </div>