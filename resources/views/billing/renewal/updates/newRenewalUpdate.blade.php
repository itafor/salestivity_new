<form method="post" action="{{ route('renewal.update.store') }}" autocomplete="off" class="mt--3">
     @csrf
                                <div class="row">
     <input type="hidden" name="renewal_id" value="{{$renewal->id}}">
     <input type="hidden" name="user_id" value="{{loginUserId()}}">

                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('update_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="update_date_id">{{ __('Update Date') }}</label>
                                           
                                           <input type="text" name="update_date" class="form-control" data-toggle="datepicker" placeholder="Date" required>
                                            @if ($errors->has('update_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('update_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    {{--<div class="col-md-6">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('Type') }}</label>
                                            <select name="type" class="form-control" placeholder="{{ __('type') }}" value="{{ old('type') }}" required>
                                               <option value="">Select type</option>
                                               <option value="Phone">Phone</option>
                                               <option value="Email">Email</option>
                                               <option value="Online Meeting">Online Meeting
                                               </option>
                                               <option value="Physical Meeting">Physical Meeting</option>
                                               <option value="General">General</option>
                                            </select>
                                            @if ($errors->has('type'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('type') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>--}}
                          </div>
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('commments') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-comment">{{ __('Comment') }}</label>
                                            <textarea class="form-control" name="commments" placeholder="Type a commment" rows="4" required></textarea>

                                            @if ($errors->has('commments'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('commments') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
            <div class="text-center">
    <button type="submit" class="btn btn-success" id="submitRenewalButton">{{ __('Submit') }}</button>
  </div>
</form>