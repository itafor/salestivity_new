<form method="post" action="{{ route('review.update') }}" autocomplete="off" class="mt--3">
     @csrf
                                <div class="row">
     <input type="hidden" name="review_id" value="{{$review->id}}">
     <input type="hidden" name="review_inventory_id" value="{{$review->inventory->id}}">
     <input type="hidden" name="review_product_id" value="{{$review->product->id}}">
     <input type="hidden" name="user_id" value="{{loginUserId()}}">

                                   
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('Attribute') }}</label>
                                            <select name="review_attribute" class="form-control" placeholder="{{ __('type') }}" value="{{ old('attribute') }}" required>
                                               <option value="{{$review->attribute}}">{{$review->attribute}}</option>
                                               <option value="Quality">Quality</option>
                                               <option value="Visibility">Visibility</option>
                                               <option value="Distribution">Distribution
                                               </option>
                                               <option value="Others">Others</option>
                                            </select>
                                           
 @error('review_attribute')
<small class="text-danger">{{$message}}</small>
@enderror
                                        </div>
                                    </div>
                          </div>
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('review_comment') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-comment">{{ __('Comment') }}</label>
                                            <textarea class="form-control" name="review_comment" placeholder="Type a review_comment" rows="4" required>{{$review->comment}}</textarea>

     @error('review_comment')
<small class="text-danger">{{$message}}</small>
@enderror
                                        </div>
                                    </div>
                                </div>
            <div class="text-center">
    <button type="submit" class="btn btn-success" id="submitRenewalButton">{{ __('Submit') }}</button>
  </div>
</form>