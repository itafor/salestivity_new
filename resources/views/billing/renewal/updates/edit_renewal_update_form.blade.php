<form method="post" action="{{ route('renewalupdateopperator')}}" autocomplete="off" class="mt--3">
                         @csrf
                                <div class="row">
     <input type="hidden" name="renewal_id" value="{{$renewal->id}}">
     <input type="hidden" name="renewal_update_id" id="renewal_update_id{{$update->id}}">
     <input type="hidden" name="user_id" value="{{loginUserId()}}">

                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('update_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="update_date_id">{{ __('Update Date') }}</label>
                                           
                                           <input type="text" name="update_date" class="form-control" id="update_date{{$update->id}}" data-toggle="datepicker" placeholder="Date" required>
                                            @if ($errors->has('update_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('update_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                        <div class="col-md-6 ">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label">{{ __('Bill Remark') }}</label>
                                            <select name="bill_remark" id="bill_remark_id{{$update->id}}" class="form-control edit_bill_remark_class" placeholder="{{ __('bill_remark') }}" value="{{ old('bill_remark') }}" required style="width: 400px">
                                              
                                            </select>
                                            @if ($errors->has('bill_remark'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bill_remark') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                     <div class="col-md-6" id="edit_bill_remark_date{{$update->id}}">
                                        <div class="form-group{{ $errors->has('bill_remark_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="bill_remark_date_idx" id="bill_remark_date_labelx">{{ __('Payment Date') }}</label>
                                           
                                           <input type="text" name="bill_remark_payment_date" id="bill_remark_date_id{{$update->id}}" class="form-control bill_remark_date_class" data-toggle="datepicker" placeholder="Date" >
                                            @if ($errors->has('bill_remark_payment_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bill_remark_payment_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                   {{-- <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('Type') }}</label>
                                            <select name="type" id="type_id{{$update->id}}" class="form-control" placeholder="{{ __('type') }}" value="{{ old('type') }}" required style="width: 100%;">
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
                                    </div> --}}
                        
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('commments') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-comment">{{ __('Comment') }}</label>
                                            <textarea class="form-control" name="commments" id="commments_id{{$update->id}}" placeholder="Type commments" rows="2" required></textarea>

                                            @if ($errors->has('commments'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('commments') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
            <div class="text-center">
    <button type="button" onclick="editRenewalUpdate({{$update->id}})" class="btn btn-warning">{{ __('Cancel') }}</button>

    <button type="submit" class="btn btn-success" id="submitRenewalButton">{{ __('Save') }}</button>

  </div>
</form>