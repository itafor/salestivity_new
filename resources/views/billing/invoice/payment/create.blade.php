
<!-- Modal -->
<div class="modal fade" id="invoice-payment-modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form method="post" action="{{ route('billing.invoice.pay') }}" autocomplete="off">
           @csrf
    <!-- <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">product Price</label>
    <div class="col-sm-10"> -->
      <input type="hidden" name="productPrice" class="form-control" id="productPrice" readonly="">
  <!--   </div>
  </div> -->
    <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Billing Amount</label>
    <div class="col-sm-10">
      <input type="text" min="1" name="billingAmount" class="form-control" id="billingAmount" readonly="">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Amount Paid</label>
    <div class="col-sm-10">
      <input type="number" min="1" name="amount_paid"  class="form-control" id="amount_paid" placeholder="Enter amount paid" required>
    </div>
  </div>
   <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Billing Balance</label>
    <div class="col-sm-10">
      <input type="number" min="1" name="billingbalance"  class="form-control" id="billingbalance" placeholder="Enter balance" readonly="">
    </div>
  </div>
     
      <input type="hidden" min="1" name="discount"  class="form-control" id="discount">
    
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Payment Date</label>
    <div class="col-sm-10">
      <input type="text" name="payment_date" class="form-control" id="payment_date"  data-toggle="datepicker"  placeholder="Enter payment date" required>
    </div>
  </div>
   
      <input type="hidden" name="customer_id" class="form-control" id="customer_id" placeholder="Enter Customer">
   
 
      <input type="hidden" name="product_id" class="form-control" id="product_id" placeholder="Enter Product">
 
  
      <input type="hidden" name="invoice_id" class="form-control" id="invoice_id">
  
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Payment</button>
      </div>
</form>

      </div>
      
    </div>
  </div>
</div>

  
