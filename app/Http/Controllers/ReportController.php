<?php

namespace App\Http\Controllers;

use App\Exports\OpportunityReportExport;
use App\Http\Services\TeamService;
use App\SubUser;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;

class ReportController extends Controller
{

   protected $team_service;

    function __construct(TeamService $service)
    {
    	$this->team_service = $service;

    }

	public function exportCSVReport()
	{
		 return Excel::download(new OpportunityReportExport, 'report.csv');
	}

	public function downloadPdf()
	{
		 $opportunities_report_details =  Session::get('reports');
		 if($opportunities_report_details){

		 	 $pdf = PDF::loadView('opportunity.Reports.report_details', [
            'opportunities_report_details' => $opportunities_report_details,
        ]);

        $documentName = 'report'.'.pdf';

        return $pdf->download($documentName);
		 }
       
	}

	public function displayTeamMembers($team_id)
	{
		if($team_id == "All"){

			 $members =  SubUser::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        
        return response()->json(['members'=>$members]);

		}

      $members =  $this->team_service->getTeamMembers($team_id);

      return response()->json(['members'=>$members]);

	}
}
