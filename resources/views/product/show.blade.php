@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Add Account')]) 
		
<script>
    $(document).ready(function(){
        /*Disable all input type="text" box*/
        $('#form1 input').prop("disabled", true);
        $('#form1 button').hide();

        $('#edit').click(function(){
        $('#form1 input').prop("disabled", false);
        $('#form1 button').show();
        $('#edit').toggle();
        })
        
    });
		</script> 

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('View Product') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button id="edit" class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('product.update', [$product->id]) }}" id="form1" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Product information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="name">{{ __('Product Name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Name') }}" value="{{ $product->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="category">{{ __('Category') }}</label>
                                    <input type="text" name="category" id="category" class="form-control form-control-alternative{{ $errors->has('category') ? ' is-invalid' : '' }}" placeholder="{{ __('Category') }}" value="{{ $product->category }}" required>

                                    @if ($errors->has('category'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="type">{{ __('Type') }}</label>
                                    <input type="text" name="type" id="type" class="form-control form-control-alternative{{ $errors->has('type') ? ' is-invalid' : '' }}" placeholder="{{ __('Type') }}" value="{{ $product->type }}" required>

                                    @if ($errors->has('type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('notes') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="notes">{{ __('Notes') }}</label>
                                    <input type="textarea" name="notes" id="notes" class="form-control form-control-alternative{{ $errors->has('notes') ? ' is-invalid' : '' }}" placeholder="{{ __('Notes') }}" value="{{ $product->notes }}" required >

                                    @if ($errors->has('notes'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('notes') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
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