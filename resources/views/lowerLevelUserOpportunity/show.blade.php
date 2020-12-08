@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Opportunity')])


<script>
    $(document).ready(function(){
		/*Disable all input type="text" box*/
		$('#form1 input').prop("disabled", true);
		$('#form1 button').hide();
        $('#form1 #addProduct').hide();
        $('#form1 select').prop("disabled", true);
		$('#form1 #account').prop("disabled", true);
        
		$('#edit').click(function(){
            $('#form1 input').prop("disabled", false);
            $('#form1 button').show();
            $('#form1 select').prop("disabled", false);
        $('#form1 button').prop("disabled", false);
        $('#form1 #addProduct').prop("disabled", false);
		$('#form1 #account').prop("disabled", false);
		$('#form1 #stage').prop("disabled", false);
		$('#form1 #status').prop("disabled", false);
		$('#edit').toggle();
		})
		
	});
</script>

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">

        <div class="card">
      <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{$user->name}} {{$user->last_name}}'s {{ __('Opportunity Details') }} </h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('opportunity.edit',[$opportunity->id]) }}" class="btn btn-sm btn-info">{{ __('Edit') }}</a>
                                &nbsp;&nbsp;
                                <a href="{{ route('opportunity.view',[$opportunity->id]) }}" class="btn btn-sm btn-primary">{{ __('Back To List') }}</a>
                            </div>
                        </div>
                    </div>
  <div class="card-body">
        <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($opportunity))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Opportunity NAME') }}</b></td>
                     <td>{{ $opportunity->name }}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{ $opportunity->customer ? $opportunity->customer->name : 'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Contact Person') }}</b></td>
                     <td>{{ $opportunity->contact_person ? $opportunity->contact_person->name .' '.$opportunity->contact_person->surname :'N/A'  }}</td>
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('Owner') }}</b></td>
                     <td>{{ $opportunity->owner ? $opportunity->owner->name .' '.$opportunity->owner->last_name : 'N/A'  }}</td>
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('Probability') }}</b></td>
                     <td>{{ $opportunity->probability }} %
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Amount') }}</b></td>
                     <td>&#8358;{{ number_format($opportunity->amount,2) }}
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Status') }}</b></td>
                     <td>
                        {{ $opportunity->status }} 
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __(' Initiation Date ') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($opportunity->initiation_date)) }}</td>           
              </tr>
              <tr>
                     <td style="width: 200px;"><b>{{ __('Expected Closure Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($opportunity->closure_date)) }}</td>           
              </tr>

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>
                <hr>
                   <h3>All Products</h3>
                                <div class="row">
                                    <div class="col-xl-6">
                                        @forelse($opportunity->products as $product)
                                            <span class="badge bg-purple">{{ $product->name }}</span>
                                        @empty
                                            <span class="badge bg-purple">No Product Added</span>
                                        @endforelse
                                    </div>
                </div>
  </div>
</div>

            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection