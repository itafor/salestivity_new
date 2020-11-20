@extends('layouts.app', ['title' => __('Add Sub Category')])
@section('content')
@include('users.partials.header', ['title' => __('Add Sub Category')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Sub Category') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('product.subcategory.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('product.subcategory.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Sub Category') }}</h6>
                            <div class="pl-lg-4 pr-lg-4">
                 <div class="col-md-12 pl-1">
                      <div class="form-group">
                        <label for="category_id">Advert Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control" required>
                          <option>Select a category</option>
                          @foreach(productCategories() as $category)
                          <option value="{{$category->id}}">{{$category->name}}</option>
                          @endforeach
                        </select>
                        </div>
                        @error('category_id')
                    <small style="color: red; font-size: 14px;"> {{ $message }}</small>
                    @enderror
                    </div>
                  </div>

                  <div class="col-md-12">
                  <label class="form-control-label" for="input-property_type">{{ __('Subcategories') }}</label>
                  <input type="text" name="subcategories[112211][name]"  class="form-control" required>
                </div>

                <div style="clear:both"></div>
                <div id="subcaegoryContainer" class="col-md-12">
                </div>   
                <div style="clear:both"></div>

                   <div class="form-group">
                  <button type="button" id="addMoreSubcategory" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>  Add more Subcategories</button>
                </div>
                            
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div> 
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                var maxField = 10; //Input fields increment limitation
                var addButton = $('.add_button'); //Add button selector
                var wrapper = $('.field_wrapper'); //Input field wrapper
                var fieldHTML = '<div>'+ 
                                    '<input type="text" name="addSubCategory[]" id="addSubCategory" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Category Name') }}" value="{{ old('name') }}" required autofocus>' +

                                        '@if ($errors->has('name'))' +
                                            '<span class="invalid-feedback" role="alert">' +
                                                '<strong>{{ $errors->first('name') }}</strong>' +
                                            '</span>' +
                                        '@endif' +
                                        '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times"></i></a>' +
                                        '</div>'
                var x = 1; //Initial field counter is 1
                
                //Once add button is clicked
                $(addButton).click(function(){
                    //Check maximum number of input fields
                    if(x < maxField){ 
                        x++; //Increment field counter
                        $(wrapper).append(fieldHTML); //Add field html
                    }
                });
                
                //Once remove button is clicked
                $(wrapper).on('click', '.remove_button', function(e){
                    e.preventDefault();
                    $(this).parent('div').remove(); //Remove field html
                    x--; //Decrement field counter
                });
            });
            </script>
        
        @include('layouts.footers.auth')
    </div>

@endsection