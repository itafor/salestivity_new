
<!-- Modal -->
<div class="modal fade" id="addProductToTarget" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Product to target</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('target.product.add') }}" autocomplete="off">
                            @csrf
                            
                            <div class="pl-lg-4 pr-lg-4">
                                <input type="hidden" name="target_id" value="{{$target->id}}">
                                <div class="row">
                                  

                                        <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="name">{{ __('Product Name') }}</label>
                                            <select name="product_id" id="productId" class="form-control border-input" data-toggle="select" required>
                                                <option value="">Choose a product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                            </select>

                                            @if ($errors->has('productId'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('productId') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('unit_price') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="unit_price">{{ __('Unit Price') }}</label>
                                            <input type="number" name="unit_price" id="unit_price" class="form-control form-control-alternative{{ $errors->has('unit_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Standard Price') }}" value="{{ old('unit_price') }}" required readonly>

                                            @if ($errors->has('unit_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('unit_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="quantity">{{ __('Quantity') }}</label>
                                            <input type="number" name="quantity" id="target_quantity" class="form-control form-control-alternative{{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="{{ __('Standard Price') }}" value="{{ old('quantity') }}" required >

                                            @if ($errors->has('quantity'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('quantity') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                     <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="amount">{{ __('Amount') }}</label>
                                            <input type="number" name="amount" id="target_amount" class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}" placeholder="{{ __('Standard Price') }}" value="{{ old('amount') }}" required readonly>

                                            @if ($errors->has('amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('amount') }}</strong>
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