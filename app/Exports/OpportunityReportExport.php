<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Session;

class OpportunityReportExport implements FromCollection, WithHeadings
{

    /**
     * Display the CSV headings
     * @return array
     */
    public function headings(): array
    {
        return ["Name", "Account", "Amount", "Stage", "Probability", "Date Initiated", "Closure Date"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    
    $report =  Session::get('reports');
        if($report){
       return $report;
    }
    }
}
