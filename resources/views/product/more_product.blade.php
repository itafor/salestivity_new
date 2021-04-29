
<!-- Modal -->
<div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('product.store') }}" autocomplete="off">
                            @csrf
                            
                            <div class="pl-lg-4 pr-lg-4">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="category_id">{{ __('Category') }}</label>   
                                            <select name="category_id" id="category_id" class="form-control border-input" data-toggle="select" required>
                                                <option value="">Choose a Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('category_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('category_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                      <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="product">{{ __('Sub Category') }}</label>
                                            <select name="sub_category_id" id="sub_category_id" class="form-control border-input" data-toggle="select" required>
                                                <option value="">Choose a Sub Category</option>
                                              
                                            </select>     
                                            @if ($errors->has('sub_category_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('sub_category_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                  

                                        <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="name">{{ __('Product Name *') }}</label>
                                            <input type="text" name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Name') }}" value="{{ old('name') }}" required >

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="standard_price">{{ __('Standard Price') }}</label>
                                            <input type="number" name="standard_price" id="standard_price" class="form-control form-control-alternative{{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Standard Price') }}" value="{{ old('standard_price') }}" required >

                                            @if ($errors->has('standard_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('standard_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="description">{{ __('Description') }}</label>
                                            <textarea name="description" id="description" class="form-control form-control-alternative border-input{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Description') }}" value="{{ old('description') }}" required rows="3"></textarea>

                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                
                                
                                <div class="modal-footer">
        <button onclick="hide_product_form()" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add product</button>
       
      </div>
                                
                            </div>
                        </form>
      </div>
     
    </div>
  </div>
</div>