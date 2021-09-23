<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="replyToEmail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update ReplyTo Email Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
         <form action="{{route('update.replyToEmail')}}" method="post" class="form-inline" autocomplete="off">
            @csrf
            <div class="form-group mb-2 mr-1">
              <input type="hidden" name="reply_to_email_id" id="reply_to_email_id">
            <label for="reply_to_email" >ReplyTo Email</label>
            <input type="email" class="form-control-plaintext" name="replyToEmail" id="reply_to_email" placeholder="Enter ReplyTo Email" required>
             @if ($errors->has('replyToEmail'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('replyToEmail') }}</strong>
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