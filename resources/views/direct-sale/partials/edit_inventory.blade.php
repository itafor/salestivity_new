<!-- Modal -->
<div class="modal fade" id="edit_inventory_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        
            
<div class="form-horizontal">
   Manage
   @if($orderOwner)
  <strong>{{$orderOwner->name}}</strong>
@endif

   Inventory
</div>
        
        <span class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">X</span>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('inventory.update') }}" autocomplete="off">
          @csrf

            <input type="hidden" name="inventory_id" id="inventory_id" class="form-control">
            
            <input type="hidden" name="product_id" id="product_id" class="form-control">

        <label for="inputPassword5" class="form-label">Product</label>

            <input type="text" name="product_name" id="product_name" class="form-control">

             <label for="inputPassword5" class="form-label">Quantity</label>
            
            <input type="text" name="quantity" id="quantity" class="form-control">
           

    
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
        </div>
    </div>
  </div>
</div>