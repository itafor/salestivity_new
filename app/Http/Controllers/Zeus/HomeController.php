<?php

namespace App\Http\Controllers\Zeus;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Customer;
use App\User;

class HomeController extends Controller
{
    public function index()
    {
        // $tables = DB::table('customers')
        //     ->where('account_type', 1)
        //     ->join('users', 'customers.main_acct_id', '=', 'users.id')
        //     ->select('customers.name', 'customers.email', 'customers.phone')
        //     ->get();
            // dd(count($tables));
            // $tabless = collect([]);
            
            // foreach ($tables as $key => $table) {
            //     $tabless->push($table);
            // }
            // dd($tables);
            // $tabless = $tables;
            // $tables = DB::table('users')
            // // ->where('account_type', 1)
            // ->rightjoin('customers', 'users.id', '=', 'customers.main_acct_id')
            // ->select('users.company_name', 'users.email', 'users.phone', DB::raw("count(users.email) as organization_count"))
            // ->groupBy('customers.main_acct_id')
            // // ->select()
            // ->get();

            // $tables = DB::table('users')
            // // ->where('account_type', 1)
            // ->join('customers', 'users.id', '=', 'customers.main_acct_id')
            // ->select('users.company_name', 'users.email', 'users.phone', DB::raw("count(users.email) as organization_count"))
            // ->groupBy('customers.main_acct_id')
            // // ->select()
            // ->get();

        // $tables = Customer::rightJoin('users', 'users.profile_id', '=', 'customers.main_acct_id')
        //                     ->select('users.company_name', 'users.email', 'users.phone', DB::raw("count(users.email) as organization_count"))
        //                     ->groupBy('users.email')
        //                     ->get();
                
        $tables = DB::table('users')
                ->leftJoin('sub_users', 'users.id', '=', 'sub_users.main_acct_id')
                ->leftJoin('customers', 'sub_users.id', '=', 'customers.main_acct_id')
                ->select('users.company_name', 'users.email', 'users.phone', DB::raw("count(users.email) as organization_count"))
                ->groupBy('users.id')
                ->get();
        

        return view('zeus.index', compact('tables'));
    }
}
