<form method="post" action="{{ route('renewal.update.store') }}" autocomplete="off" class="mt--3">
     @csrf
                                <div class="row">
     <input type="hidden" name="renewal_id" value="{{$renewal->id}}">
     <input type="hidden" name="user_id" value="{{loginUserId()}}">

                                    <div class="col-md-6 update_date_label">
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
                                    <div class="col-md-6 bill_remark_class">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('Bill Remark') }}</label>
                                            <select name="bill_remark" id="bill_remark_id" class="form-control" placeholder="{{ __('type') }}" value="{{ old('type') }}" required>
                                               <option value="">Select</option>
                                               <option value="Customer to make payment">Customer to make payment/Date</option>
                                               <option value="Customer asked to resend invoice">Customer asked to resend invoice</option>
                                               <option value="Customer cancelled service">Customer cancelled service
                                               </option>
                                               <option value="Customer not yet satisfied with work">Customer not yet satisfied with work</option>
                                               <option value="Customer not reachable">Customer not reachable</option>
                                            </select>
                                            @if ($errors->has('bill_remark'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bill_remark') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 bill_remark_date_label">
                                        <div class="form-group{{ $errors->has('bill_remark_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="bill_remark_date_id" id="bill_remark_date_label" style="display: none;">{{ __('Payment Date') }}</label>
                                           
                                           <input type="text" name="bill_remark_payment_date" id="bill_remark_date_id" class="form-control" data-toggle="datepicker" placeholder="Date" style="display: none;">
                                            @if ($errors->has('bill_remark_payment_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bill_remark_payment_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
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
