    <div class="row mt-4" id="replytrenewalupdate{{$update->id}}form" style="display: none;">
         <form method="post" action="{{ route('renewal.update.reply.store') }}" autocomplete="off" class="mt--3">
                         @csrf
        <div class="row">
     <input type="hidden" name="renewal_id" value="{{$renewal->id}}">
     <input type="hidden" name="renewal_update_id" value="{{$update->id}}">
     <input type="hidden" name="user_id" value="{{loginUserId()}}">
                                
                          </div>
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('reply') ? ' has-danger' : '' }}">
<!--                                             <label class="form-control-label" for="input-comment">{{ __('Comment') }}</label> -->
                                            <textarea class="form-control" name="reply"  placeholder="Type a reply" rows="2" required></textarea>

                                            @if ($errors->has('reply'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('reply') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
            <div class="text-center">
    <button type="button" onclick="replyRenewalUpdate({{$update->id}})" class="btn btn-warning">{{ __('Cancel') }}</button>

    <button type="submit" class="btn btn-success" id="submitRenewalButton">{{ __('Save') }}</button>

  </div>
</form>
    </div>