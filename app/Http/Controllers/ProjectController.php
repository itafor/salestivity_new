<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Product;
use Session;
use DB;
use Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        
        return view('project.index', compact('projects', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $products = Product::all();
        
        return view('project.create', compact('project', 'products'));
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
        $this->validate($request, [
            'customer_account' => 'required',
            'product_id' => 'required',
            'technician' => 'required',
            'start' => 'required',
            'end' => 'required',
            'notes' => 'required|max:255',
						'uploads' => 'required',
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
						}
						
						// dd($data);
				$project->uploads = json_encode($data); 
				$project->customer_account = $request->customer_account;
				$project->product_id = $request->product_id;
				$project->technician = $request->technician;
				$project->start_date = $request->start;
				$project->end_date = $request->end;
				$project->notes = $request->notes;
				// dd($project);
				$project->save();

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
        $project = Project::find($id);
        $products = Product::all();
        $product = Product::where('id', $project->product_id)->first();
        // dd($product);
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
        //
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
