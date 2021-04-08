
<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form method="post" action="{{ route('company.update.email') }}" autocomplete="off">
           @csrf
    
    <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label"> Email</label>
    <div class="col-sm-10">
      <input type="email"  name="company_email" class="form-control" id="company_email" >
    </div>
  </div>

   
      <input type="hidden" name="company_email_id" class="form-control" id="company_email_id" placeholder="Enter Customer">
   
 
  
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
</form>

      </div>
      
    </div>
  </div>
</div>

  
