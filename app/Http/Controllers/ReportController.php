<?php

namespace App\Http\Controllers;

use App\Exports\OpportunityReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;

class ReportController extends Controller
{

	// public $reportsCollection;

	// public function __construct($reporst)
	// {
	// 	$this->reportsCollection = $reporst;
	// }

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
}
