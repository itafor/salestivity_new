@extends('layouts.app', ['title' => __('Project Management'), 'icon' => 'las la-gem' ])
@section('content')
@include('users.partials.header', ['title' => __('Account')]) 
		
    <script>
        $(document).ready(function(){
            /*Disable all input type="text" box*/
            $('#form1 input').prop("disabled", true);
            $('#form1 select').prop("disabled", true);
            $('#form1 button').hide();

            $('#edit').click(function(){
            $('#form1 input').prop("disabled", false);
            $('#form1 select').prop("disabled", false);
            $('#form1 button').show();
            $('#title').html('Edit Account');
            $('#edit').toggle();
            })
            
        });
	</script> 

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 id="title" class="mb-0">{{ __('View Project') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button id="edit"  class="btn-icon btn-tooltip" title="{{ __('Edit') }}"><i class="las la-edit"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('project.update', $project->id) }}" id="form1" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Project information') }}</h6>
                            <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('customer_account') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="customer_account">{{ __('Customer Account') }}</label>
                                        <input type="text" name="customer_account" id="customer_account" class="form-control form-control-alternative{{ $errors->has('customer_account') ? ' is-invalid' : '' }}" placeholder="{{ __('Account') }}" value="{{ $project->customer_account }}">

                                        @if ($errors->has('customer_account'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('customer_account') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-email">{{ __('Product Name') }}</label>
                                        
                                    
                                        <select name="product_id" id="product_id" class="form-control" >
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                        
                                        @if ($errors->has('product_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('product_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('technician') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-password">{{ __('Technician') }}</label>
                                        <input type="text" name="technician" id="technician" class="form-control form-control-alternative{{ $errors->has('technician') ? ' is-invalid' : '' }}" placeholder="{{ __('Technician') }}" value="{{ $project->technician }}">
                                        
                                        @if ($errors->has('technician'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('technician') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                               
                                <div class="col-xl-6">
                                   <div class="form-group{{ $errors->has('notes') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="notes">{{ __('Notes') }}</label>
                                        <input type="textarea" name="notes" id="notes" class="form-control form-control-alternative{{ $errors->has('notes') ? ' is-invalid' : '' }}" placeholder="{{ __('Notes') }}" value="{{ $project->notes }}" >

                                        @if ($errors->has('notes'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('notes') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>       
                                
                            <div class="form-group{{ $errors->has('uploads') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="uploads">{{ __('Uploads') }}</label>
                                <input type="file" name="uploads[]" id="uploads" class="form-control form-control-alternative{{ $errors->has('uploads') ? ' is-invalid' : '' }}" multiple>

                                @if ($errors->has('uploads'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('uploads') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Update') }}</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection