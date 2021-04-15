<?php

namespace App\Http\Controllers;

use App\OpportunityUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class OpportunityUpdateController extends Controller
{
    public function storeUpdate(Request $request){
    	//dd($request->all());
    	$data = $request->all();
    		 $validator = Validator::make($request->all(), [
            'opportunity_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'update_date' => 'required',
            'type' => 'required',
            'commments' => 'required',
        ]);
    	  if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in all required fields');
            return back()->withInput();
        }


    	$opportunity_update = OpportunityUpdate::create([
        'opportunity_id' => $data['opportunity_id'],
        'user_id' => $data['user_id'],
        'update_date' => Carbon::parse(formatDate($data['update_date'], 'd/m/Y', 'Y-m-d')),
        'type' => $data['type'],
        'commments' => $data['commments'],
    	]);
    
      if($opportunity_update){
    	return redirect()->route('opportunity.show', [$request->opportunity_id]);
    }else{
    		Alert::error('Ooops', 'Something went wrong. please try again!!');
    	return redirect()->route('opportunity.show', [$request->opportunity_id]);

}

}

public function editOpportunityUpdate(Request $request){
        //dd($request->all());
        $data = $request->all();
             $validator = Validator::make($request->all(), [
            'opportunity_update_id' => 'required|numeric',
            'opportunity_id' => 'required',
            'update_date' => 'required',
            'type' => 'required',
            'commments' => 'required',
        ]);
          if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in all required fields');
            return back()->withInput();
        }


        $opportunity_update = OpportunityUpdate::find($data['opportunity_update_id'])->update([
        'update_date' => Carbon::parse(formatDate($data['update_date'], 'd/m/Y', 'Y-m-d')),
        'type' => $data['type'],
        'commments' => $data['commments'],
        ]);
    
      if($opportunity_update){
        return redirect()->route('opportunity.show', [$request->opportunity_id]);
    }else{
            Alert::error('Ooops', 'Something went wrong. please try again!!');
        return redirect()->route('opportunity.show', [$request->opportunity_id]);

}

}

}
