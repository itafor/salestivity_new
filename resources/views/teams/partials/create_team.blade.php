<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Team</h5>
        <span class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">X</span>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('team.store') }}" autocomplete="off">
          @csrf
        <label for="inputPassword5" class="form-label">Team Name</label>
            
            <input type="text" name="team_name" id="team_name" class="form-control">

             <label for="inputPassword5" class="form-label">Description (Optional)</label>
            
            <textarea name="description" id="description" class="form-control"></textarea>

    
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
        </div>
    </div>
  </div>
</div>