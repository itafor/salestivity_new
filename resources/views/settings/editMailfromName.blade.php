<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="mailFrormName" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Mail From Name</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body">
         <form action="{{route('update.mail.from.name')}}" method="post" class="form-inline" autocomplete="off">
            @csrf
            <div class="form-group mb-2 mr-1">
              <input type="hidden" name="mail_from_name_id" id="mail_from_name_id">
            <label for="reply_to_email" >Mail From Name</label>
            <input type="text" class="form-control-plaintext" name="mail_from_name" id="mail_from_name" placeholder="Enter ReplyTo Email" required>
             @if ($errors->has('mail_from_name'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('mail_from_name') }}</strong>
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