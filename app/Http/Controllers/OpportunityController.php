<?php

namespace App\Http\Controllers;

use App\Category;
use App\Contact;
use App\Customer;
use App\Http\Controllers\ReportController;
use App\Http\Services\TeamService;
use App\Opportunity;
use App\OpportunityProduct;
use App\OpportunityUpdate;
use App\Product;
use App\SubCategory;
use App\SubUser;
use App\Team;
use Auth;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Validator;

class OpportunityController extends Controller
{

    protected $team_service;

  public function __construct(TeamService $service)
    {
        $this->middleware(['auth','mainuserVerified','subuserVerified'])->except('homepage');
        $this->team_service = $service;

    }

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

               $parent_user_opportunities = Opportunity::where([
                ['main_acct_id', $userId],
                ['user_type', 'users'],
                ['status', '!=', 'Closed Lost'],
                ['status', '!=', 'Closed Won']
            ])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Lost'],
                ['status', '!=', 'Closed Won']
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.index', compact('opportunities'));
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
                ['owner_id', $userId],
                ['user_type', 'sub_users'],
                 ['status', '!=', 'Closed Lost'],
                ['status', '!=', 'Closed Won']
            ])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)
            ->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Lost'],
                ['status', '!=', 'Closed Won']
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);
        
        return view('opportunity.index', compact('opportunities'));

            }

    }

    public function create()
    {
         $data['categories'] = Category::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
      ])->get();

        $data['customers'] = Customer::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
      ])->get();
       
        $data['products'] = Product::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
      ])->get();

          $data['subCategories'] = SubCategory::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
      ])->get();


        return view('opportunity.create', $data);
    }

    public function store(Request $request)
    {
        $guard_object = getActiveGuardType();
        $input = request()->all();
       //dd($input);
        $rules = [
 
            'opportunity_name' => 'required',
            'account_id' => 'required',
            'status' => 'required',
            'initiation_date' => 'required',
            'closure_date' => 'required',
            'products' => 'required',
        ];
        $message = [
            'opportunity_name.required' => 'Opportunity name is required',
            'account_id.required' => 'Please choose an account',
            'status.required' => 'Please select a status',
            'initiation_date.required' => 'Pick an Initiation date',
            'closure.required' => 'Pick a Closure date',
            'products.required' => 'Please add a product',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

         if(compareEndStartDate($request->initiation_date,$request->closure_date) == false){
            Alert::error('Invalid Closure Date', 'Please ensure that the Closure Date is after the Initiation Date');
         return back()->withInput();
        }

         $my_parent_user = authUser()->parent_user;
        $my_subusers = authUser()->subUsers;
        
            $opportunity = new Opportunity;
            $opportunity->created_by = $guard_object->created_by;
            $opportunity->user_type = $guard_object->user_type;
            $opportunity->main_acct_id = $guard_object->main_acct_id;
            $opportunity->name = $request->opportunity_name;
            $opportunity->owner_id = $request->owner_id;
            $opportunity->account_id = $request->account_id;
            $opportunity->amount = $request->amount;
            $opportunity->probability = $request->probability;
            $opportunity->initiation_date =  Carbon::parse(formatDate($request->initiation_date, 'd/m/Y', 'Y-m-d'));
            $opportunity->closure_date = Carbon::parse(formatDate($request->closure_date, 'd/m/Y', 'Y-m-d'));
            $opportunity->contact_id = $request->contact_id;
            $opportunity->status = $request->status;
            $opportunity->parent_user_id =  $guard_object->user_type == 'users' ? null :  $my_parent_user->id;

            $opportunity->save();
            if($opportunity){

            if(isset($input['products']) && $input['products'] !='') {
                foreach ($input['products'] as $key => $prodId) {
                    $opp_product = new OpportunityProduct();
                    $opp_product->product_id = $prodId;
                    $opp_product->opportunity_id = $opportunity->id;
                    $opp_product->save();
                }
            }

            $status = "Opportunity has been saved";
            Alert::success('Opportunity', $status);
            return back();
        }
        
            Alert::error('Add Project', 'This action could not be completed');
            return back()->withInput()->withErrors($validator);
        

    }
    
    /**
     * Method that populates the table according to what is selected .
     */
 public function getOpportunities($id)
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



    switch ($id) {
        case 1:
            $parent_user_opportunities = Opportunity::where([
                ['main_acct_id', $userId],
                ['user_type', 'users']
            ])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)
            ->where([
                ['user_type', 'sub_users']
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);
          
            return view('opportunity.all', compact('opportunities'));
       break;
       case 2:
              $parent_user_opportunities = Opportunity::where([
                ['main_acct_id', $userId],
                ['user_type', 'users']
            ])->whereBetween('closure_date', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();


             $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users']
            ])->whereBetween('closure_date', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.currentmonth', compact('opportunities'));
        break;

        case 3:

           $parent_user_opportunities = Opportunity::where([
                ['main_acct_id', $userId],
                ['user_type','users']
            ])->whereBetween('closure_date', [$today->copy()->addMonth(1)->startOfMonth(), $today->copy()->endOfMonth()->addMonth(1)])->get();

             $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users']
            ])->whereBetween('closure_date', [$today->copy()->addMonth(1)->startOfMonth(), $today->copy()->endOfMonth()->addMonth(1)])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.nextmonth', compact('opportunities'));

       break;

       case 4:
        $user = SubUser::where('email',Auth::user()->email)->first();

            $opportunities = Opportunity::where([
                ['main_acct_id', $userId],
                ['user_type','users']
            ])->where('owner_id', $user->id)->get();
            return view('opportunity.myopp', compact('opportunities'));
       break;

       case 5:

        $parent_user_opportunities = Opportunity::where([
                ['main_acct_id', $userId],
                ['user_type','users']
            ])->where('status', '=', 'Closed Won')->get();

            $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser) ->where([
                ['user_type', 'sub_users'],
                ['status', '=', 'Closed Won']
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.won', compact('opportunities'));
     break;

     case 6:
            $parent_user_opportunities = Opportunity::where([
                ['main_acct_id', $userId],
                ['user_type','users']
            ])->where('status', '=', 'Closed Lost')->get();

            $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['status', '=', 'Closed Lost'],
                ['user_type', '=', 'sub_users']
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.lost', compact('opportunities'));
    break;

         case 7:
            $parent_user_opportunities = Opportunity::where([
                ['main_acct_id', $userId],
                ['user_type','users']
            ])->where([
                ['status', '!=', 'Closed Lost'],
                ['status', '!=', 'Closed Won']
            ])->get();

            $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['status', '!=', 'Closed Lost'],
                ['status', '!=', 'Closed Won'],
                ['user_type', '=', 'sub_users']
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.open', compact('opportunities'));
    break;
                 
        default:
                     # code...
                     break;
    }
   
 }else{

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


            if($id == 1){
            
            $parent_user_opportunities = Opportunity::where([
                ['owner_id', $userId],
                ['user_type', 'sub_users']
            ])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)
            ->where([
                ['user_type', 'sub_users']
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.all', compact('opportunities'));
        
        } elseif($id == 2) {
            
            $parent_user_opportunities = Opportunity::where([
                ['owner_id', $userId],
                ['user_type','sub_users']
            ])->whereBetween('closure_date', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

             $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)
            ->where([
                ['user_type', 'sub_users']
            ])->whereBetween('closure_date', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.currentmonth', compact('opportunities'));
        }
         elseif($id == 3) {

            $parent_user_opportunities = Opportunity::where([
                ['owner_id', $userId],
                ['user_type','sub_users']
            ])->whereBetween('closure_date', [$today->copy()->addMonth(1)->startOfMonth(), $today->copy()->endOfMonth()->addMonth(1)])->get();

             $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)
            ->where([
                ['user_type', 'sub_users']
            ])->whereBetween('closure_date', [$today->copy()->addMonth(1)->startOfMonth(), $today->copy()->endOfMonth()->addMonth(1)])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.nextmonth', compact('opportunities'));
        
        } elseif ($id == 4) {

            $user = SubUser::where('email',Auth::user()->email)->first();

            $opportunities = Opportunity::where([
                ['owner_id', $userId],
                ['user_type','sub_users']
            ])->where('owner_id', $user->id)->get();
            return view('opportunity.myopp', compact('opportunities'));
        
        }elseif ($id == 5) {
            $parent_user_opportunities = Opportunity::where([
                ['owner_id', $userId],
                ['user_type','sub_users']
            ])->where('status', '=', 'Closed Won')->get();

             $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)
            ->where([
                ['user_type', 'sub_users'],
                ['status', '=', 'Closed Won']
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.won', compact('opportunities'));
        
        } elseif ($id == 6) {

             $parent_user_opportunities = Opportunity::where([
                ['owner_id', $userId],
                ['user_type','sub_users']
            ])->where('status', '=', 'Closed Lost')->get();

             $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)
            ->where([
                ['user_type', 'sub_users'],
                ['status', '=', 'Closed Lost']
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.lost', compact('opportunities'));
        }else{
             $parent_user_opportunities = Opportunity::where([
                ['owner_id', $userId],
                ['user_type','sub_users']
            ])->where([
                 ['status', '!=', 'Closed Lost'],
                ['status', '!=', 'Closed Won'],
            ])->get();

             $users_that_reports_to_parent_user_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)
            ->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Lost'],
                ['status', '!=', 'Closed Won'],
            ])->get();

            $opportunities = $parent_user_opportunities->merge($users_that_reports_to_parent_user_opportunities);

            return view('opportunity.open', compact('opportunities'));
        }
    }
       

    }



    public function show($id)
    {
        $opportunity = Opportunity::where('id', $id)->first();
        $opportunity_updates = OpportunityUpdate::where('opportunity_id', $id)->orderBy('created_at','desc')->paginate(10);
        
        return view('opportunity.show', compact('opportunity','opportunity_updates'));
    }

    public function edit($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $data['opportunity'] = Opportunity::where('id', $id)->first();

        $data['customers'] = Customer::where([
         ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

   $data['categories'] = Category::where([
         ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        $data['products'] = Product::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
      ])->get();
        
        //dd($opportunity);
        return view('opportunity.edit', $data);
    }

    /**
     * Method to modify and update an opportunity's information.
     */
    public function update(Request $request)
    {
         $input = request()->all();
        // dd($input);

         if(compareEndStartDate($request->initiation_date,$request->closure_date) == false){
            Alert::error('Invalid Closure Date', 'Please ensure that the Closure Date is after the Initiation Date');
         return back()->withInput();
        }
        
         $guard_object = getActiveGuardType();
        
            $opportunity = Opportunity::find($request->input('opportunity_id'));
        $opportunity->name = $request->input('opportunity_name');
        $opportunity->owner_id = $request->input('owner_id');
        $opportunity->account_id = $request->input('account_id');
        $opportunity->amount = $request->input('amount');
        $opportunity->probability = $request->input('probability');
        $opportunity->status = $request->input('status');
        $opportunity->initiation_date = Carbon::parse(formatDate($request->initiation_date, 'd/m/Y', 'Y-m-d'));
        $opportunity->closure_date = Carbon::parse(formatDate($request->closure_date, 'd/m/Y', 'Y-m-d'));
        $opportunity->contact_id = $request->input('contact');

        // dd($opportunity);
        $opportunity->update();
        //dd($opportunity);
        $product = $request->input('product_id');
        
       if(isset($input['products']) && $input['products'] !='') {
                foreach ($input['products'] as $key => $prodId) {
                    $opp_product = new OpportunityProduct();
                    $opp_product->product_id = $prodId;
                    $opp_product->opportunity_id = $opportunity->id;
                    $opp_product->save();
                }
            }

        $status = "Opportunity has been successfully updated";
        Alert::success('Opportunity', $status);
        return back();
       
            // Alert::error('The process could not be completed');
        
        
    }

      public function getSelectedAccount($id){
    $account = Customer::where('id',$id)
                    ->where('main_acct_id',getActiveGuardType()->main_acct_id)->first();
                    if($account){
                      return $account;
            }
  }

       public function getSelectedSalesPerson($id){
    $sales_person = SubUser::where('id',$id)
                    ->where('main_acct_id',getActiveGuardType()->main_acct_id)->first();
                    if($sales_person){
                      return $sales_person;
            }
  }

public function getSelectedTeam($id){
    $team = Team::where('id',$id)
                    ->where('main_acct_id',getActiveGuardType()->main_acct_id)->first();
                    if($team){
                      return $team;
            }
  }

  public function report()
    {
        
    $data['selectedSalesPerson'] = '';
    $data['selectedTeam'] = '';
    $data['selectedAccount'] = '';
    $data['selectedstatus'] = '';
    $data['selectedAmountFrom'] = '';
    $data['selectedAmountTo'] = '';
    $data['selectedInitDateFrom'] = '';
    $data['selectedInitDateTo'] = '';
    $data['selectedClosureDateFrom'] = '';
    $data['selectedClosureDateTo'] = '';


    $data['teams'] =  $this->team_service->myTeams();

    $data['sales_persons']  = SubUser::where('main_acct_id',getActiveGuardType()->main_acct_id)->get();
             
    
        $data['customers'] = Customer::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
      ])->get();
       
        return view('opportunity.Reports.report_form', $data);
        
    }

    public function getReport(Request $request)
    {

 $data = $request->all();
          $rules = [
 
            'owner_id' => 'required',
            'account_id' => 'required',
            'status' => 'required',
            'init_date_from' => 'required',
            'init_date_to' => 'required',
            'closure_date_from' => 'required',
            'closure_date_to' => 'required',
            'amount_from' => 'required',
            'amount_to' => 'required',
        ];
        $message = [
            'owner_id.required' => 'Please select a sales person',
            'account_id.required' => 'Please choose an account',
            'status.required' => 'Please select a status',
            'init_date_from.required' => 'Please enter initiation start date',
            'init_date_to.required' => 'Please enter initiation end date',
            'closure_date_from.required' => 'Please enter Closure start date',
            'closure_date_to.required' => 'Please enter Closure end date',
            'amount_from.required' => 'Please enter starting amount',
            'amount_to.required' => 'Please enter ending amount',
            
        ];
        $validator = Validator::make($data, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

    
     $init_date_from = Carbon::parse(formatDate($data['init_date_from'], 'd/m/Y', 'Y-m-d'));
     $init_date_to = Carbon::parse(formatDate($data['init_date_to'], 'd/m/Y', 'Y-m-d'));

    $closure_date_from   = Carbon::parse(formatDate($data['closure_date_from'], 'd/m/Y', 'Y-m-d'));
    $closure_date_to   = Carbon::parse(formatDate($data['closure_date_to'], 'd/m/Y', 'Y-m-d'));

    //   if($init_date_to < $init_date_from){
    //     return back()->withInput()->with('error','initiation end date should always be ahead of initiation start date');
    // }


        $data['customers'] = Customer::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
      ])->get();
        
    $data['sales_persons']  = SubUser::where('main_acct_id',getActiveGuardType()->main_acct_id)->get();
    
     $data['teams'] =  $this->team_service->myTeams();

    $data['selectedTeam'] = $request->team_id !='All' ? $this->getSelectedTeam($request->team_id) : 'All';


         $data['selectedSalesPerson'] = $request->owner_id !='All' ? $this->getSelectedSalesPerson($request->owner_id) : 'All';

         $data['selectedAccount'] =  $request->account_id !='All' ? $this->getSelectedAccount($request->account_id) : 'All';
    $data['selectedstatus'] = $request->status;
    $data['selectedAmountFrom'] = $request->amount_from;
    $data['selectedAmountTo'] = $request->amount_to;
    $data['selectedInitDateFrom'] = $init_date_from;
    $data['selectedInitDateTo'] = $init_date_to;
    $data['selectedClosureDateFrom'] = $closure_date_from;
    $data['selectedClosureDateTo'] = $closure_date_to;


        $data['opportunities_report_details'] = Opportunity::join('sub_users as owner','owner.id','=','opportunities.owner_id')
                        ->join('customers as account','account.id','=','opportunities.account_id')
                        ->where([
                          ['opportunities.main_acct_id', getActiveGuardType()->main_acct_id],
                       $request->account_id !='All' ?  ['account.id', $request->account_id] : ['opportunities.main_acct_id', getActiveGuardType()->main_acct_id],
                      $request->owner_id !='All' ? ['owner.id', $request->owner_id] : ['opportunities.main_acct_id', getActiveGuardType()->main_acct_id],
                      $request->status !='All' ? ['opportunities.status', $request->status] : ['opportunities.main_acct_id', getActiveGuardType()->main_acct_id]])
                        ->whereBetween('opportunities.initiation_date',[$init_date_from, $init_date_to])
                        ->whereBetween('opportunities.closure_date',[$closure_date_from, $closure_date_to])
                        ->whereBetween('opportunities.amount',[$request->amount_from, $request->amount_to])
                        ->select('opportunities.name as opportunity_name','account.name as customer_name','opportunities.amount as opportunity_amount','opportunities.status as opportunity_status','opportunities.probability as opportunity_probability','opportunities.initiation_date as opportunity_initiation_date','opportunities.closure_date as opportunity_closure_date')->get(); //'owner.*'

            
                        Session::put('reports', $data['opportunities_report_details']);

        return view('opportunity.Reports.report_form', $data);
    }
}
