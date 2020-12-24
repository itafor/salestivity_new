<?php

namespace App\Http\Controllers;

use App\Opportunity;
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

        $guard_object = getActiveGuardType();

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

            $opportunities = $parent_user_last_month_opportunities->merge($users_that_reports_to_parent_user_last_month_opportunities);

            $data['opportunities_count'] = count($opportunities); 

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

                  $parent_user_opportunities = Opportunity::where([
                ['created_by', $userId],
                ['user_type', 'sub_users']
            ])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)
            ->where([
                ['user_type', 'sub_users']
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);
        
        return view('dashboard', $data);

            }


        
    }
}
