<?php

namespace App\Http\Controllers;

use App\Opportunity;
use App\Renewal;
use App\SubUser;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('homepage');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function homepage()
    {
        if(authUser()){
            return redirect()->route('home');
        }
        return view('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
             $userId = auth()->user()->id;
        $today = Carbon::now();
       $data['current_month'] = $today->format('M');
       $data['formated_current_yr'] = $today->format('Y');
        $guard_object = getActiveGuardType();
        $curr_year = Carbon::now('y');
        $curr_momth = Carbon::now('m');
        // dd($curr_momth);
        if($guard_object->user_type == 'users'){
            // this array holds the ids of subusers that report to parent  user
             $parentUserAndSubUsersThatReportToThem = array('0'=>[0]);

            $get_main_user_from_subuser = SubUser::where('email',authUser()->email)->first();

             $usersThatreportsToParentUser = $get_main_user_from_subuser->users_that_report_tome->pluck('id')->toArray();

             $arrayLenght = count($usersThatreportsToParentUser);
             $i = 0;

             while ( $i <  $arrayLenght) {
                
                 $subUser = SubUser::where('id', $usersThatreportsToParentUser[$i])->first();
                    $subusersThatreportToThisSubUser = $subUser->users_that_report_tome->pluck('id')->toArray();
                    if($subusersThatreportToThisSubUser){
                    $parentUserAndSubUsersThatReportToThem[] = $subusersThatreportToThisSubUser;
                    }

                $i++;
             }
                //combine a multidimensional array to one single array
             $combinedArray = call_user_func_array('array_merge', $parentUserAndSubUsersThatReportToThem);

             $idsOfUsersUnderParentUser =   array_merge($combinedArray, $usersThatreportsToParentUser);
// ....................Last month Open opportunities...........................................
               $parent_user_last_month_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_last_month_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();

              $last_month_opportunities = $parent_user_last_month_opportunities->merge($users_that_reports_to_parent_user_last_month_opportunities);

             $last_month_opportunities_amt_sum = $parent_user_last_month_opportunities->merge($users_that_reports_to_parent_user_last_month_opportunities)->sum('amount');

            $data['last_month_opportunities_count'] = count($last_month_opportunities); 
            $data['last_month_opportunities_amt_sum'] = $last_month_opportunities_amt_sum;
// .............................Current Month Open Opportunities.............................................

             $parent_user_current_month_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_current_month_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

            $current_month_opportunities = $parent_user_current_month_opportunities->merge($users_that_reports_to_parent_user_current_month_opportunities);

            $current_month_opportunities_amt_sum = $parent_user_current_month_opportunities->merge($users_that_reports_to_parent_user_current_month_opportunities)->sum('amount');
            

            $data['current_month_opportunities_count'] = count($current_month_opportunities); 
            $data['current_month_opportunities_amt_sum'] = $current_month_opportunities_amt_sum;

            $data['last_month_plus_current_month_opp_count'] = count($current_month_opportunities) + count($last_month_opportunities);

            $data['last_month_plus_current_month_opp_amt_sum'] =  $last_month_opportunities_amt_sum + $current_month_opportunities_amt_sum;

            $opp_amt_difference =  ($data['current_month_opportunities_amt_sum'] - $data['last_month_opportunities_amt_sum']) / abs($data['last_month_opportunities_amt_sum'] == 0 ? 1 : $data['last_month_opportunities_amt_sum']);

            $data['opp_percentage_change'] =  $opp_amt_difference * 100;

            $data['formatted_opp_percentage_change'] = round($data['opp_percentage_change'], 2);
// ----------------------------------------Year To Date Open Opportunities----------------------------------------

             $parent_user_YTD_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereYear('created_at', $curr_year)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_YTD_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereYear('created_at', $curr_year)->get();

        $ytd_opportunities = $parent_user_YTD_opportunities->merge($users_that_reports_to_parent_user_YTD_opportunities);
            

            $data['ytd_opportunities_amt_sum'] = $parent_user_YTD_opportunities->merge($users_that_reports_to_parent_user_YTD_opportunities)->sum('amount');
        $data['ytd_opp_count'] = count($ytd_opportunities);
// ...........................................................................................





        // ....................Last month Won opportunities...........................................
               $parent_user_last_month_won_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'users'],
                ['status', 'Closed Won'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_last_month_won_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();//last month opp

              $last_month_won_opportunities = $parent_user_last_month_won_opportunities->merge($users_that_reports_to_parent_user_last_month_won_opportunities);

             $last_month_won_opportunities_amt_sum = $parent_user_last_month_won_opportunities->merge($users_that_reports_to_parent_user_last_month_won_opportunities)->sum('amount');

            $data['last_month_won_opportunities_count'] = count($last_month_won_opportunities); 
            $data['last_month_won_opportunities_amt_sum'] = $last_month_won_opportunities_amt_sum;
// .............................Current Month Won Opportunities.............................................

             $parent_user_current_month_won_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'users'],
                ['status', 'Closed Won'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_current_month_won_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

            $current_month_won_opportunities = $parent_user_current_month_won_opportunities->merge($users_that_reports_to_parent_user_current_month_won_opportunities);

            $current_month_won_opportunities_amt_sum = $parent_user_current_month_won_opportunities->merge($users_that_reports_to_parent_user_current_month_won_opportunities)->sum('amount');
            

            $data['current_month_won_opportunities_count'] = count($current_month_won_opportunities); 
            $data['current_month_won_opportunities_amt_sum'] = $current_month_won_opportunities_amt_sum;

            $data['last_month_plus_current_month_won_opp_count'] = count($current_month_won_opportunities) + count($last_month_won_opportunities);

            $data['last_month_plus_current_month_won_opp_amt_sum'] =  $last_month_won_opportunities_amt_sum + $current_month_won_opportunities_amt_sum;

            $won_opp_amt_difference =  ($data['current_month_won_opportunities_amt_sum'] - $data['last_month_won_opportunities_amt_sum']) / abs($data['last_month_won_opportunities_amt_sum'] == 0 ? 1 :$data['last_month_won_opportunities_amt_sum']);

            $data['won_opp_percentage_change'] = round($won_opp_amt_difference * 100, 2);

// ----------------------------------------Year To Date Won Opportunities----------------------------------------

             $parent_user_YTD_won_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'users'],
                ['status', 'Closed Won'],
            ])->whereYear('created_at', $curr_year)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_YTD_won_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereYear('created_at', $curr_year)->get();

        $ytd_won_opportunities = $parent_user_YTD_won_opportunities->merge($users_that_reports_to_parent_user_YTD_won_opportunities);
            

         $data['ytd_won_opportunities_amt_sum'] =  $ytd_won_opportunities->sum('amount');
        $data['ytd_won_opp_count'] = count($ytd_won_opportunities);

        // ......................Outstanding Renewal (Recurring) current mmonth......................
        $current_month_partly_paid_renewal = Renewal::where([
            ['status', 'Partly paid'],
            ['main_acct_id', $userId],
            ['userType', 'Primary_user'],
        ])->whereMonth('created_at', $curr_momth)->get();

         $current_month_pending_renewal = Renewal::where([
            ['status', 'Pending'],
            ['main_acct_id', $userId],
            ['userType', 'Primary_user'],
        ])->whereMonth('created_at', $curr_momth)->get();
      

         $data['current_month_outstanding_renewal_amt'] = $current_month_partly_paid_renewal->sum('billingBalance') + $current_month_pending_renewal->sum('billingAmount');

          $data['current_month_outstanding_renewal_count'] = count($current_month_partly_paid_renewal->merge($current_month_pending_renewal));

           // ......................Outstanding Renewal (Recurring) year to date......................
        $ytd_partly_paid_renewal = Renewal::where([
            ['status', 'Partly paid'],
            ['main_acct_id', $userId],
            ['userType', 'Primary_user'],
        ])->whereYear('created_at', $curr_year)->get();

         $ytd_pending_renewal = Renewal::where([
            ['status', 'Pending'],
            ['main_acct_id', $userId],
            ['userType', 'Primary_user'],
        ])->whereYear('created_at', $curr_year)->get();
      

         $data['ytd_outstanding_renewal_amt'] = $ytd_partly_paid_renewal->sum('billingBalance') + $ytd_pending_renewal->sum('billingAmount');

          $data['ytd__outstanding_renewal_count'] = count($ytd_partly_paid_renewal->merge($ytd_pending_renewal));

          // dd($data['ytd_outstanding_renewal_amt']);

        // ......................Paid Renewal (Recurring) current mmonth......................
        // $current_month_paid_renewal = Renewal::where([
        //     ['status', 'Paid'],
        //     ['main_acct_id', $userId],
        //     ['userType', 'Primary_user'],
        // ])->whereMonth('created_at', $curr_momth)->get();


        //  $data['current_month_paid_renewal_amt'] = $current_month_paid_renewal->sum('billingBalance');

        //   $data['current_month_outstanding_renewal_count'] = count($current_month_partly_paid_renewal->merge($current_month_pending_renewal));
       


     return view('dashboard', $data);

}else if($guard_object->user_type == 'sub_users'){

                    // this array holds the ids of subusers that report to parent  user
             $topLevelSubUserAndSubUsersThatReportToThem = array('0'=>[0]);

            $get_main_user_from_subuser = SubUser::where('email',authUser()->email)->first();

             $usersThatreportsToParentUser = authUser()->users_that_report_tome->pluck('id')->toArray();

            foreach($usersThatreportsToParentUser as $subuserid) {

                     $subUser = SubUser::where('id', $subuserid)->first();
                    $subusersThatreportToThisSubUser = $subUser->users_that_report_tome->pluck('id')->toArray();
                    
                    if($subusersThatreportToThisSubUser){
                    $topLevelSubUserAndSubUsersThatReportToThem[] = $subusersThatreportToThisSubUser;
                    }

             }
 
        
             $combinedArray = call_user_func_array('array_merge', $topLevelSubUserAndSubUsersThatReportToThem);

             $idsOfUsersUnderParentUser =   array_merge($combinedArray, $usersThatreportsToParentUser);

// ....................Last month Open opportunities...........................................
              $parent_user_last_month_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_last_month_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();

              $last_month_opportunities = $parent_user_last_month_opportunities->merge($users_that_reports_to_parent_user_last_month_opportunities);

             $last_month_opportunities_amt_sum = $parent_user_last_month_opportunities->merge($users_that_reports_to_parent_user_last_month_opportunities)->sum('amount');

            $data['last_month_opportunities_count'] = count($last_month_opportunities); 
            $data['last_month_opportunities_amt_sum'] = $last_month_opportunities_amt_sum;
// .............................Current Month Open opportunities.......................................
$parent_user_current_month_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_current_month_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

            $current_month_opportunities = $parent_user_current_month_opportunities->merge($users_that_reports_to_parent_user_current_month_opportunities);

            $current_month_opportunities_amt_sum = $parent_user_current_month_opportunities->merge($users_that_reports_to_parent_user_current_month_opportunities)->sum('amount');
            

            $data['current_month_opportunities_count'] = count($current_month_opportunities); 
            $data['current_month_opportunities_amt_sum'] = $current_month_opportunities_amt_sum;

            $data['last_month_plus_current_month_opp_count'] = count($current_month_opportunities) + count($last_month_opportunities);

            $data['last_month_plus_current_month_opp_amt_sum'] =  $last_month_opportunities_amt_sum + $current_month_opportunities_amt_sum;

            $opp_amt_difference =  ($data['current_month_opportunities_amt_sum'] - $data['last_month_opportunities_amt_sum']) / abs($data['last_month_opportunities_amt_sum'] == 0 ? 1 : $data['last_month_opportunities_amt_sum']);

            $data['opp_percentage_change'] =  $opp_amt_difference * 100;

            $data['formatted_opp_percentage_change'] = round($data['opp_percentage_change'], 2);
            
// ------------------------Year To Date Open opportunities------------------------------------------------------
                  $parent_user_YTD_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereYear('created_at', $curr_year)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_YTD_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereYear('created_at', $curr_year)->get();

        $ytd_opportunities = $parent_user_YTD_opportunities->merge($users_that_reports_to_parent_user_YTD_opportunities);
            

            $data['ytd_opportunities_amt_sum'] = $parent_user_YTD_opportunities->merge($users_that_reports_to_parent_user_YTD_opportunities)->sum('amount');
        $data['ytd_opp_count'] = count($ytd_opportunities);
// ...........................................................................................

        


        // ....................Last month Won opportunities...........................................
               $parent_user_last_month_won_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_last_month_won_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();

              $last_month_won_opportunities = $parent_user_last_month_won_opportunities->merge($users_that_reports_to_parent_user_last_month_won_opportunities);

             $last_month_won_opportunities_amt_sum = $parent_user_last_month_won_opportunities->merge($users_that_reports_to_parent_user_last_month_won_opportunities)->sum('amount');

            $data['last_month_won_opportunities_count'] = count($last_month_won_opportunities); 
            $data['last_month_won_opportunities_amt_sum'] = $last_month_won_opportunities_amt_sum;
// .............................Current Month Won Opportunities.............................................

             $parent_user_current_month_won_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_current_month_won_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

            $current_month_won_opportunities = $parent_user_current_month_won_opportunities->merge($users_that_reports_to_parent_user_current_month_won_opportunities);

            $current_month_won_opportunities_amt_sum = $parent_user_current_month_won_opportunities->merge($users_that_reports_to_parent_user_current_month_won_opportunities)->sum('amount');
            

            $data['current_month_won_opportunities_count'] = count($current_month_won_opportunities); 
            $data['current_month_won_opportunities_amt_sum'] = $current_month_won_opportunities_amt_sum;

            $data['last_month_plus_current_month_won_opp_count'] = count($current_month_won_opportunities) + count($last_month_won_opportunities);

            $data['last_month_plus_current_month_won_opp_amt_sum'] =  $last_month_won_opportunities_amt_sum + $current_month_won_opportunities_amt_sum;

            $won_opp_amt_difference =  ($data['current_month_won_opportunities_amt_sum'] - $data['last_month_won_opportunities_amt_sum']) / abs($data['last_month_won_opportunities_amt_sum'] == 0 ? 1 :$data['last_month_won_opportunities_amt_sum']);

            $data['won_opp_percentage_change'] = round($won_opp_amt_difference * 100, 2);

// ----------------------------------------Year To Date Won Opportunities----------------------------------------

             $parent_user_YTD_won_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereYear('created_at', $curr_year)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_YTD_won_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereYear('created_at', $curr_year)->get();

        $ytd_won_opportunities = $parent_user_YTD_won_opportunities->merge($users_that_reports_to_parent_user_YTD_won_opportunities);
            

            $data['ytd_won_opportunities_amt_sum'] = $parent_user_YTD_won_opportunities->merge($users_that_reports_to_parent_user_YTD_won_opportunities)->sum('amount');
        $data['ytd_won_opp_count'] = count($ytd_won_opportunities);

         // ......................Outstanding Renewal (Recurring) current mmonth......................
        $current_month_partly_paid_renewal = Renewal::where([
            ['status', 'Partly paid'],
            ['main_acct_id', $userId],
            ['userType', 'Sub_user'],
        ])->whereMonth('created_at', $curr_momth)->get();

         $current_month_pending_renewal = Renewal::where([
            ['status', 'Pending'],
            ['main_acct_id', $userId],
            ['userType', 'Sub_user'],
        ])->whereMonth('created_at', $curr_momth)->get();
      

         $data['current_month_outstanding_renewal_amt'] = $current_month_partly_paid_renewal->sum('billingBalance') + $current_month_pending_renewal->sum('billingAmount');

          $data['current_month_outstanding_renewal_count'] = count($current_month_partly_paid_renewal->merge($current_month_pending_renewal));


           // ......................Outstanding Renewal (Recurring) year to date......................
        $ytd_partly_paid_renewal = Renewal::where([
            ['status', 'Partly paid'],
            ['main_acct_id', $userId],
            ['userType', 'Sub_user'],
        ])->whereYear('created_at', $curr_year)->get();

         $ytd_pending_renewal = Renewal::where([
            ['status', 'Pending'],
            ['main_acct_id', $userId],
            ['userType', 'Sub_user'],
        ])->whereYear('created_at', $curr_year)->get();
      

         $data['ytd_outstanding_renewal_amt'] = $ytd_partly_paid_renewal->sum('billingBalance') + $ytd_pending_renewal->sum('billingAmount');

          $data['ytd__outstanding_renewal_count'] = count($ytd_partly_paid_renewal->merge($ytd_pending_renewal));

        return view('dashboard', $data);

            }


        
    }
}
