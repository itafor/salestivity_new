       <div class="table-responsive">
                        <table class="table align-items-center table-bordered datatable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Author') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($user->users_that_report_tome->isEmpty())
                                    <tr>
                                        <td colspan="8" style="text-align: center">
                                            <h3>No user found</h3>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($user->users_that_report_tome as $user)
                                        <tr>
                                            <td>{{ $user->name }} {{ $user->last_name }}</td>
                                            <td>
                                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                            </td>
                                           
                                          
                                            @if(getCreatedByDetails($user->user_type, $user->created_by) !== null)
                                                <td>{{ getCreatedByDetails($user->user_type, $user->created_by)['name'] .' '.
                                                        getCreatedByDetails($user->user_type, $user->created_by)['last_name']
                                                    }}
                                                </td>
                                            @else
                                                <td>Not Set</td>
                                            @endif
                                            <td>
                                                <a href="{{route('lowerLevelUserOpp.view',[$user->id])}}"> <button class="btn btn-success btn-sm">View opportunities</button> </a>
                                            </td>
                                      
                                            
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
