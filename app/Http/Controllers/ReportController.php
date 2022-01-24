<?php

namespace App\Http\Controllers;

use App\Exports\OpportunityReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
}
