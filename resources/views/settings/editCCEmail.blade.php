<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="cc-email-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update CC Email Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
         <form action="{{route('update.cc.email')}}" method="post" class="form-inline" autocomplete="off">
            @csrf
            <div class="form-group mb-2 mr-1">
              <input type="hidden" name="cc_email_id" id="cc_email_id">
            <label for="cc_email" >CC Email</label>
            <input type="email" class="form-control-plaintext" name="ccEamil" id="cc_email" placeholder="Enter ReplyTo Email" required>
             @if ($errors->has('ccEamil'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('ccEamil') }}</strong>
                                    </span>
                                @endif
            </div>
           
            <button type="submit" class="btn btn-primary mb--3">Update</button>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>