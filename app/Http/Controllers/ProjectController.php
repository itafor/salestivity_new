<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Product;
use Session;
use DB;
use Storage;
use App\Customer;


class ProjectController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $customers = Customer::where('main_acct_id', $userId)->get();
        $projects = Project::where('main_acct_id', $userId)->orderBy('created_at', 'DESC')->get();
        
        return view('project.index', compact('projects', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = auth()->user()->id;
        $customers = Customer::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        
        return view('project.create', compact('products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Project;
        $userId = auth()->user()->id;
        $this->validate($request, [
            'customer_account' => 'required',
            'product_id' => 'required',
            'technician' => 'required',
            'start' => 'required',
            'end' => 'required',
            // 'notes' => 'required|max:255',
			// 'uploads' => 'required',
						// 'uploads.*' => 'image|file',
				]);
				
				if($request->hasfile('uploads'))
                {

					// save each file in the specified folder
                foreach($request->file('uploads') as $file){
                        $date = date('Y-m-d');
                        $name=$file->getClientOriginalName();
                        // create a folder according to dates
                        if (!Storage::exists('/public/files/$date')) {
                            Storage::makeDirectory('/public/files/$date');
                        } 
                        $file->move(public_path().'/files/'.$date, $name); 
                        $data[] = $name; 
                    }
                    $project->uploads = json_encode($data); 
                    $project->main_acct_id = $userId;
                    $project->customer_account = $request->customer_account;
                    $project->product_id = $request->product_id;
                    $project->technician = $request->technician;
                    $project->start_date = $request->start;
                    $project->end_date = $request->end;
                    $project->notes = $request->notes;
                    $project->save();
                } else {
                    $project->main_acct_id = $userId;
                    $project->customer_account = $request->customer_account;
                    $project->product_id = $request->product_id;
                    $project->technician = $request->technician;
                    $project->start_date = $request->start;
                    $project->end_date = $request->end;
                    $project->notes = $request->notes;
                    $project->save();
                }
						
						// dd($data);

        $status = "Project Added";
				Session::flash('status', $status);
				
				return redirect()->route('project.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = auth()->user()->id;
        $project = Project::where('main_acct_id', $userId)->first();
        $products = Product::where('main_acct_id', $userId)->get();
        $product = Product::where('id', $project->product_id)->where('main_acct_id', $userId)->first();
        return view('project.show', compact('project', 'product', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {	
        $userId = auth()->user()->id;
        $project = Project::where('main_acct_id', $userId)->where('id', $id)->first();														
				
        if($request->hasfile('uploads'))
        {

            // save each file in the specified folder
        foreach($request->file('uploads') as $file){
                $date = date('Y-m-d');
                $name=$file->getClientOriginalName();
                // create a folder according to dates
                if (!Storage::exists('/public/files/$date')) {
                    Storage::makeDirectory('/public/files/$date');
                } 
                $file->move(public_path().'/files/'.$date, $name); 
                $data[] = $name; 
            }
            $project->uploads = json_encode($data); 
            $project->main_acct_id = $userId;
            $project->customer_account = $request->customer_account;
            $project->product_id = $request->product_id;
            $project->technician = $request->technician;
            $project->start_date = $request->start;
            $project->end_date = $request->end;
            $project->notes = $request->notes;
            // dd($project);
            $project->update();
        } else {
            $project->main_acct_id = $userId;
            $project->customer_account = $request->customer_account;
            $project->product_id = $request->product_id;
            $project->technician = $request->technician;
            $project->start_date = $request->start;
            $project->end_date = $request->end;
            $project->notes = $request->notes;
            $project->update();
        }

        $status = "Project Updated";
        Session::flash('status', $status);
        
        return redirect()->route('project.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();

        Session::flash('status', 'The Project has been successfully deleted');
        return redirect()->route('project.index');
    }
}
