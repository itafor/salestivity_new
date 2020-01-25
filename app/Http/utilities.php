<?php

use Carbon\Carbon;



function formatDate($date, $oldFormat, $newFormat)
{
    return Carbon::createFromFormat($oldFormat, $date)->format($newFormat);
}

function compareEndStartDate($start_date,$end_date) {
	date_default_timezone_set("Africa/Lagos");
    $startdate = strtotime($start_date); 
    $enddate = strtotime($end_date); 

    if($enddate < $startdate){
        return false;
    }else{
     return true;
    }
}