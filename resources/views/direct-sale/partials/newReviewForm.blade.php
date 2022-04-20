<form method="post" action="{{ route('review.store') }}" autocomplete="off" class="mt--3">
     @csrf
                                <div class="row">
     <input type="hidden" name="inventory_id" value="{{$inventory->id}}">
     <input type="hidden" name="product_id" value="{{$inventory->product->id}}">
     <input type="hidden" name="user_id" value="{{loginUserId()}}">

                                   
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('Attribute') }}</label>
                                            <select name="attribute" class="form-control" placeholder="{{ __('type') }}" value="{{ old('attribute') }}" required>
                                               <option value="">Select Attribute</option>
                                               <option value="Quality">Quality</option>
                                               <option value="Visibility">Visibility</option>
                                               <option value="Distribution">Distribution
                                               </option>
                                               <option value="Others">Others</option>
                                            </select>
                                           
    @error('attribute')
<small class="text-danger">{{$message}}</small>
@enderror
                                        </div>
                                    </div>
                          </div>
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('comment') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-comment">{{ __('Comment') }}</label>
                                            <textarea class="form-control" name="comment" placeholder="Type a comment" rows="4" required></textarea>

                                            
                                            
    @error('comment')
<small class="text-danger">{{$message}}</small>
@enderror
                                        </div>
                                    </div>
                                </div>
            <div class="text-center">
    <button type="submit" class="btn btn-success" id="submitRenewalButton">{{ __('Submit') }}</button>
  </div>
</form>