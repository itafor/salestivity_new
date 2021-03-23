@extends('layouts.app', ['title' => __('Settings Managment'), 'icon' => 'las la-plus-circle'])
@section('content')
@include('users.partials.header', ['title' => __('Application settins')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Settings') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('product.subcategory.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                 
                    <div class="card-body">
                            <h3>Company Logo</h3>
                            @if(isset($user))
                           <img src="{{$user->company_logo_url}}" alt="company logo" width="200" height="200">
                            @endif
                           
                            <form action="{{route('company.upload.logo')}}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="row g-3 align-items-center">
                     <!--  <div class="col-auto">
                        <label for="inputPassword6" class="col-form-label">Company Logo</label>
                      </div> -->
                      <div class="col-auto">
                        <input type="file" name="company_logo_url" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline" required>
                      </div>
                      <div class="col-auto">
                        <span id="passwordHelpInline" class="form-text">
                         <button type="submit" class="btn btn-primary">Change Logo</button>
                        </span>
                      </div>
                    </div>
                </form>
                    <hr>
                       </div>
                                
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