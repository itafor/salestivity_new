<?php

namespace App\Imports;

use App\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

class IndividualCustomerImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(auth()->check()) {
        $main_acct_id = auth()->user()->id;
        $created_by = auth()->user()->id;
        $userType = 'users';
    }
    if(auth()->guard('sub_user')->check()) {
        // get the sub_user's main_acct_id
        $main_acct_id = auth()->guard('sub_user')->user()->main_acct_id;
        $created_by = auth()->guard('sub_user')->user()->id;
        $userType = 'sub_users';
    }

        return new Customer([
        'customer_id' => isset($row[0]) ? $row[0] : null,
        'name' => isset($row[1]) ? $row[1] :null,
        'email' =>  isset($row[2]) ? $row[2] :null,
        'website' => isset($row[3]) ? $row[3] : null,
        'employee_count' => isset($row[4]) ? $row[4] :null,
        'turn_over' => isset($row[5]) ? $row[5] :null,
        'phone' => isset($row[6]) ? $row[6] :null,
        'customer_type' => 'Individual',
        'account_type' => 2,
        'main_acct_id' => $main_acct_id,
        'created_by' => $created_by,
        'user_type' => $userType,
        'account_id' => null
        ]);
    }
}
