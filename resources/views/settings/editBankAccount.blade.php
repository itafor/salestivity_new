
<!-- Modal -->
<div class="modal fade" id="bank-account-modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form method="post" action="{{ route('company.update.bank.account') }}" autocomplete="off">
           @csrf
    
    <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label"> Bank Name</label>
    <div class="col-sm-10">
      <input type="text"  name="bank_name" class="form-control" id="bank_name" >
    </div>
  </div>

   <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label"> Account Name</label>
    <div class="col-sm-10">
      <input type="text"  name="account_name" class="form-control" id="account_name" >
    </div>
  </div>

   <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label"> Account Number</label>
    <div class="col-sm-10">
      <input type="text"  name="account_number" class="form-control" id="account_number" >
    </div>
  </div>

   
      <input type="hidden" name="company_bank_account_id" class="form-control" id="company_bank_account_id" placeholder="Enter Customer">
   
 
  
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
</form>

      </div>
      
    </div>
  </div>
</div>

  
