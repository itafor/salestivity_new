<!-- Modal -->
<div class="modal fade" id="add_team_member_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add member to <b><span id="teamName"></span></b></h5>
        <span class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">X</span>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('team.add.member') }}" autocomplete="off">
          @csrf

            <input type="hidden" name="team_id" id="teamId" class="form-control">


        <label for="inputPassword5" class="form-label">Team Member</label>
            
             <select name="sub_user_id" id="sub_user_id" class="form-control" style="width: 300px;">
               <option value="">Select a member</option>
               @foreach(mySubUsers() as $member)
               <option value="{{$member->id}}">{{$member->name}} {{$member->last_name}}</option>
               @endforeach
             </select>

    
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
        </div>
    </div>
  </div>
</div>