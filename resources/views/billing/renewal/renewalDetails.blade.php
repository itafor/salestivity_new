   <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <?php   
                            $currentStatus= renewalPaymentStatus($renewal);
                            ?>
                            <div class="col-6">
                                 <a href="{{ route('billing.renewal.navigate', [$renewal->id, $currentStatus, 'previous']) }}" title="Previous {{$currentStatus}} Recurring Invoice">
                                <button class="btn btn-primary btn-sm float-left"
                                {{isset($minId) && $minId == $currentId ? "disabled" : "" }} ><i class="fa fa-arrow-left" aria-hidden="true"></i></button>

                                 </a>

                                  <a href="{{ route('billing.renewal.navigate', [$renewal->id, $currentStatus, 'next']) }}"  title="Next {{$currentStatus}} Recurring Invoice">                        

                                    <button class="btn btn-primary btn-sm float-right"
                                    {{isset($maxId) && $maxId == $currentId ? "disabled" : "" }}><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                 </a>

                            </div>
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Recurring') }} </h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.renewal.invoice.view', [$currentStatus]) }}" class="btn-icon btn-tooltip" title="{{ __('Back to List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                        <div class="row align-items-center">

                        
         @if(isset($renewal))
            <div class="col-8">
                @if($renewal->status == 'Paid')
            <a >
                <button class="btn btn-sm btn-success" id="pay">
            {{ __('Paid') }}
            </button>
        </a>
        @else
               <a onclick="renewalPayment({{$renewal->id}})" >
                <button class="btn btn-sm btn-primary" >
            {{ __('Payment') }}
            </button>
        </a>

        @endif

         
            <a href="{{ route('billing.renewal.edit', ['id'=>$renewal->id]) }}">
            <button class="btn btn-sm btn-primary">
            {{ __('Edit') }}
            </button>
            </a>
            

            
             <a onclick="return confirm_delete()"  href="{{route('items.destroy',['renewal',$renewal->id])}}"><button class="btn btn-sm btn-danger">{{ __('Delete') }}</button></a>
              

        <a  href="{{route('renewal.invoice.download',[$renewal->id])}}" >
                <button class="btn btn-sm btn-dark" >
            {{ __('Download Invoice') }}
            </button>
        </a>

         <a onclick="return confirm_invoice_payment_resend()" href="{{route('renewal.invoice.resend',[$renewal->id])}}"><button class="btn btn-sm btn-primary">{{ __('Resend Invoice') }}</button></a>
            </div>
            @endif
                        </div>
                    </div>


                    <div class="card-body">
                                <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($renewal))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Invoice Number') }}</b></td>
                     <td>{{ $renewal->invoice_number ? $renewal->invoice_number : 'N/A' }}</td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Bill Status') }}</b></td>
                     <td>

                        {{ $renewal->bill_status ? $renewal->bill_status : 'N/A' }}
                        &nbsp;&nbsp;&nbsp;&nbsp;
             
              <div class="dropdown">
                  <span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <b>Change Bill Status</b>
              </span>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a onclick="return confirm_delete()" class="dropdown-item" href="{{route('recurring.bill.status.sent',[$renewal->id])}}">Sent</a>
                    <a onclick="return confirm_delete()" class="dropdown-item" href="{{route('recurring.bill.status.confirm',[$renewal->id])}}">Confirmed</a>
                  </div>
                </div>

                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{ $renewal->customers ? $renewal->customers->name : 'N/A' }}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Email') }}</b></td>
                     <td>{{ $renewal->customers ? $renewal->customers->email : 'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Phone') }}</b></td>
                     <td>{{ $renewal->customers ? $renewal->customers->phone : 'N/A' }}</td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Category') }}</b></td>
                     <td>{{ $renewal->category? $renewal->category->name:'N/A' }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Sub Category') }}</b></td>
                     <td>{{ $renewal->subcategory? $renewal->subcategory->name:'N/A' }}
                     </td>
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $renewal->prod? $renewal->prod->name:'N/A' }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Price') }}</b></td>
                     <td>{!! $renewal->prod && $renewal->prod->currency ? $renewal->prod->currency->symbol : '&#8358;' !!}{{ number_format($renewal->productPrice,2) }}
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Discount') }}</b></td>
                     <td>
                        {{ $renewal->discount == '' ? 'N/A' : $renewal->discount.'%'}} 
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Billing Amount') }}</b></td>
                     <td>{!! $renewal->prod && $renewal->prod->currency ? $renewal->prod->currency->symbol : '&#8358;' !!}{{ number_format($renewal->billingAmount,2) }}
                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Amount Paid') }}</b></td>
                     <td>{!! $renewal->prod && $renewal->prod->currency ? $renewal->prod->currency->symbol : '&#8358;' !!}{{ number_format($renewal->amount_paid,2) }}
                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Billing Balance') }}</b></td>
                     <td>{!! $renewal->prod && $renewal->prod->currency ? $renewal->prod->currency->symbol : '&#8358;' !!}{{ number_format($renewal->billingBalance,2) }}
                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Discription') }}</b></td>
                     <td>{{ $renewal->description }}
                     </td>
                   </tr>

                    @if($renewal->status == 'Paid')
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Payment Status') }}</b></td>
                     <td class="text-success">{{ $renewal->status }}
                     </td>
                   </tr>
                    @elseif($renewal->status == 'Partly paid')
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Payment Status') }}</b></td>
                     <td class="text-warning">
                        {{ $renewal->status }}
                     </td>
                   </tr>
                     @else
                      <tr>
                     <td style="width: 200px;"><b>{{ __('Payment Status') }}</b></td>
                     <td class="text-danger">
                         {{ $renewal->status }}
                     </td>
                   </tr>
                     @endif

                 

                <tr>
                     <td style="width: 200px;"><b>{{ __('Start Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($renewal->start_date)) }}</td>           
              </tr>
              <tr>
                     <td style="width: 200px;"><b>{{ __('Due Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($renewal->end_date)) }}</td>           
              </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Duration Type') }}</b></td>
                <td>{{ $renewal->duration_type ? $renewal->duration_type : 'N/A' }}</td>           
              </tr>

               <tr>
                 <td style="width: 200px;"><b>{{ __('Reminder Durations') }}</b></td>
                 <td> First : {{$renewal->duration ? $renewal->duration->first_duration.'days' : 'N/A' }}, Second: {{$renewal->duration ? $renewal->duration->second_duration.'days' : 'N/A' }}, Third: {{$renewal->duration ? $renewal->duration->third_duration.'days' : 'N/A' }} </td>
                 </tr>

                 <tr>
                     <td style="width: 200px;"><b>{{ __('Delivery Email') }}</b></td>
                <td>{{ $renewal->compEmail ? $renewal->compEmail->email : 'N/A' }}</td>           
              </tr>
              <tr>
                 <td style="width: 200px;"><b>{{ __('Bank Account') }}</b></td>
                 <td> <strong>Bank</strong> : {{$renewal->compBankAcct ? $renewal->compBankAcct->bank_name : 'N/A' }}, <strong>Account Name</strong>: {{$renewal->compBankAcct ? $renewal->compBankAcct->account_name : 'N/A' }}, <strong>Account Number</strong>: {{$renewal->compBankAcct ? $renewal->compBankAcct->account_number : 'N/A' }} </td>
                 </tr>

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>
                    </div>
                     @if($renewalPayments !='')
                    @include('billing.renewal.payment.show')
                      @endif





<div class="container mb-5 mt-5">
<h3 class="text-center mb-5"> Recurring Updates </h3>

    @if(isset($renewal_updates) && count($renewal_updates) >=1)
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                    
                        @foreach($renewal_updates as $update)
                        <div class="media mt-3"> <img class="mr-3 rounded-circle" alt="Bootstrap Media Preview" src="https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_360,h_360/https://al-azharinternationalcollege.com/wp-content/uploads/2017/08/avatar.png" />
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-8 d-flex">
                                        <h5>{{$update->user ? $update->user->name:''}} {{$update->user ?$update->user->last_name:''}}</h5> &nbsp;&nbsp;&nbsp;<span> <i class="fa fa-clock" aria-hidden="true"></i>  
                                    {{ date("jS F, Y", strtotime($update->update_date)) }}
                                        </span>
                                       <span>&nbsp;<b>Remark:</b> &nbsp;{{$update->bill_remark ? $update->bill_remark : "N/A"}}</span> 

                                       @if($update->bill_remark_payment_date !='')
                                       &nbsp;&nbsp;<span> <b>Payment Date: </b> 
                                    {{ date("jS F, Y", strtotime($update->bill_remark_payment_date)) }}
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <div class="pull-right reply"> <span onclick="replyRenewalUpdate({{$update->id}})" style="cursor: pointer;"><i class="fa fa-reply"></i> reply</span> </div>
                                    </div>
                                </div> 
                            <span style="color: gray; border-radius: 5px;" id="lessRenewalUpdateComment{{$update->id}}">{{ \Illuminate\Support\Str::limit($update->commments, 210)}} 
                                    @if(strlen($update->commments) > 210)
                                <b onclick="seeMoreRenewalUpdateComment({{$update->id}})" style="cursor:pointer;">See more</b>
                                @endif
                            </span>

                            <span style="color: gray; border-radius: 5px; display: none;" id="moreRenewalUpdateComment{{$update->id}}">{{$update->commments}} <b onclick="seeLessRenewalUpdateComment({{$update->id}})" style="cursor: pointer;">&nbsp;See Less</b></span>

                            <div class="row">
                                     <div class="col-8 d-flex mt-2">
                                        
                                @if(loginUserId() == $update->user->id)
                               
                                        <span onclick="editRenewalUpdate({{$update->id}})" style="cursor: pointer;">&nbsp;&nbsp; <i class="fa fa-edit" aria-hidden="true" title="Edit renewal update"></i> </span>&nbsp;&nbsp;
                                       
                                          <a onclick="return confirm_delete()"  href="{{route('items.destroy',['renewalUpdate',$update->id])}}">&nbsp;<i class="fa fa-trash text-danger" aria-hidden="true" title="Delete renewal update"></i>&nbsp; &nbsp; </a>

                                         <span onclick="editRenewalUpdate({{$update->id}})" style="cursor: pointer;">&nbsp;&nbsp; </span>&nbsp;&nbsp;

                                @endif
                          </div>
                          <div class="col-4">
                                        <div class="pull-right reply"> <span onclick="renewalUpdateReplies({{$update->id}})" style="cursor: pointer;">  <label id="hideRenewalReplyLabel{{$update->id}}" style="display: none;">Hide</label> <label id="">Replies</label> ({{count($update->updateReplies)}})</span> </div>
                                    </div>
                                </div>

                                <!-- edit update form -->
            <div class="row mt-4" id="editRenewalUpdate{{$update->id}}form" style="display: none;">
         @include('billing.renewal.updates.edit_renewal_update_form')
                                </div>


            <!-- renewal update  replies -->
            <div id="renewal_updateReplies{{$update->id}}" style="display: none;">
         @include('billing.renewal.updates.replies')
            </div>
                      
            <!-- replies form -->
         @include('billing.renewal.updates.repliesForm')
                                
                            </div>
                        </div>
                        @endforeach
                      {!! $renewal_updates->links() !!}
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
     @endif
    <br>
         @include('billing.renewal.updates.newRenewalUpdate')
</div>

                </div>

 
            </div>

     