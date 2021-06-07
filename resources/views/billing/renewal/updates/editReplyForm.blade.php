    <div class="row mt-4" id="renewalUpdateReply{{$reply->id}}form" style="display: none;">
         <form method="post" action="{{ route('renewal.update.reply.edit') }}" autocomplete="off" class="mt--3">
                         @csrf
        <div class="row">
     <input type="hidden" name="renewal_id" value="{{$renewal->id}}">
     <input type="hidden" name="renewal_update_reply_id" id="renewal_update_reply_id{{$reply->id}}">
                                
                          </div>
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('reply') ? ' has-danger' : '' }}">
                                            <textarea class="form-control" name="reply" id="reply{{$reply->id}}"  placeholder="Type reply" rows="2" required></textarea>

                                            @if ($errors->has('reply'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('reply') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
            <div class="text-center">
    <button type="button" onclick="editRenewalUpdateReply({{$reply->id}})" class="btn btn-warning">{{ __('Cancel') }}</button>

    <button type="submit" class="btn btn-success" id="submitRenewalButton">{{ __('Save') }}</button>

  </div>
</form>
    </div>