<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Services\TeamService;
use App\Team;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class TeamController extends Controller
{
    protected $team_service;

    function __construct(TeamService $service)
    {
        $this->middleware(['auth','mainuserVerified']);

    	$this->team_service = $service;

    }

    public function index()
    {
    	$data['teams'] = Team::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
    	return view('teams.index', $data);
    }

    public function store(Request $request)
    {
    	  $data = $request->all();

    	  $validator = Validator::make($request->all(), [
            'team_name' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'The team name is required');
            return back()->withInput();
        }

        $this->team_service->newTeam($data);

         $status = "New team creatd succesfully";
            Alert::success('Team created', $status);
        return redirect()->back();

    }

   public function update(Request $request)
    {
    	  $data = $request->all();

    	  $validator = Validator::make($request->all(), [
            'team_name' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'The team name is required');
            return back()->withInput();
        }

        $this->team_service->manageTeam($data);

         $status = "Team updated succesfully";
            Alert::success('Team updated', $status);
        return redirect()->back();

    }

      public function show(Team $team)
    {
    	$data['team'] = $team;
    	$data['team_members'] = $team->members;

    							// dd($data['team_members']);

    	return view('teams.show', $data);
        
    }



     public function fetchTeam(Team $team)
    {
        return response()->json(['team' => $team]);
    }

      public function destroy(Team $team)
    {
        if($team){
        	$team->delete();
        }
        $status = "Team deleted succesfully";
            Alert::success('Team Deleted', $status);
        return redirect()->back();

    }

    public function addMember(Request $request)
    {
    	  $data = $request->all();
    	  // dd($data);
    	  $validator = Validator::make($request->all(), [
            'team_id' => 'required',
            'sub_user_id' => 'required',
        ]);

       if($this->team_service->member($data)){
       	 Alert::warning('Member already exist', 'The selected member already exist');
            return back()->withInput();
       }


        if ($validator->fails()) {
            Alert::warning('Required Fields', 'The member name is required');
            return back()->withInput();
        }

        $this->team_service->addMemberToTeam($data);

         $status = "New member added succesfully";
            Alert::success('Add new member', $status);
        return redirect()->back();

    }
}
