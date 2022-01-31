<?php

namespace App\Http\Services;

use App\SubUser;
use App\Team;
use App\TeamMember;

/**
 * 
 */
class TeamService
{
	
	//create a new team in storage
	public function newTeam($data)
	{
		$team = new Team();
		$team->main_acct_id = getActiveGuardType()->main_acct_id;
        $team->created_by_id =  getActiveGuardType()->created_by;
		$team->team_name = $data['team_name'];
		$team->description = isset($data['description']) ? $data['description'] : null;
		$team->save();
		return $team;
	}

   //Update team 
	public function manageTeam($data)
	{
		$team = Team::findOrFail($data['team_id']);
		$team->team_name = $data['team_name'];
		$team->description = isset($data['description']) ? $data['description'] : null;
		$team->save();
		return $team;
	}

	//Add a new member to a tea
	public function addMemberToTeam($data)
	{
		$member = new TeamMember();
		$member->team_id = $data['team_id'];
		$member->sub_user_id = $data['sub_user_id']; // This represent the member
		$member->save();
		return $member;
	}

//Update team member
	public function manageTeamMember($data)
	{
		$member = $this->member($data);

		if($member){
		$member->team_id = $data['team_id'];
		$member->sub_user_id = $data['sub_user_id'];
		$member->save();
		return $member;
		}
		
	}

// Fetch a member from a team
	public function member($data)
	{
		return $member = TeamMember::where([
			['team_id', $data['team_id']],
			['sub_user_id', $data['sub_user_id']]
		])->first();

		return $member;
	}

	public function myTeams()
	{
	  return Team::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
	}

	public function getTeamMembers($team_id)
	{
		 $members = SubUser::join('team_members', 'sub_users.id', '=', 'team_members.sub_user_id')
                            ->where('team_members.team_id', $team_id)
                            ->select('sub_users.*')
                            ->get();
                            
                 return $members;

	}
}