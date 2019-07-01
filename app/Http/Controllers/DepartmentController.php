<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Department;
use App\Unit;
use Session;

class DepartmentController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $departments = Department::where('main_acct_id', $userId)->get();
        $units = Unit::where('main_acct_id', $userId)->get();
        return view('dept.index', compact('departments', 'units'));
    }

    public function create()
    {
        return view('dept.create');
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        // store each new category that was added
        $dept = new Department;
        $dept->name = $request->dept;
        $dept->dept_head = $request->dept_head;
        $dept->main_acct_id = $userId;
        // dd($category);
        $dept->save();

        $unit = new Unit;

        $unit->name = $request->unit;
        $unit->head = $request->unit_head;
        $unit->dept_id = $dept->id;
        $unit->main_acct_id = $userId;
        $unit->save();

        if($request->addUnit && $request->addUnitHead) {
            $addNew = new Unit;
            foreach($request->addUnit as $addUnit)
            {
                $addNew->name = $addUnit;
                $addNew->main_acct_id = $userId;

            }
            foreach($request->addUnitHead as $addUnitHead) {
                $addNew->head =$addUnitHead ;
                $addNew->dept_id = $dept->id;
            }
            $addNew->save();
        }


        $status = "Department has been created successfully!!!";
        Session::flash('status', $status);
        return redirect()->route('dept.index');
    }

    public function show($id)
    {
        $userId = auth()->user()->id;

        $dept = Department::where('id', $id)->where('main_acct_id', $userId)->first();
        $units = Unit::where('dept_id', $dept->id)->get();
        // dd($units);
        return view('dept.show', compact('dept', 'units'));
    }

    public function update(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $dept = Department::where('id', $id)->where('main_acct_id', $userId)->first();
    
        $dept->name = $request->input('dept');
        $dept->dept_head = $request->input('dept_head');
        $dept->save();
        
        $units = Unit::where('dept_id', $dept->id)->get();
   
        // update each unit field independently
        foreach($units as $single => $id){
            $match = Unit::find($id->id);
            $match->update(['name' => $request->unit[$single],'head' => $request->unit_head[$single]]);
        }

        // if the add more contact was clicked    
        if($request->addUnit && $request->addUnitHead) {
            $addNew = new Unit;
            foreach($request->addUnit as $addUnit)
            {
                $addNew->name = $addUnit;
                $addNew->main_acct_id = $userId;

            }
            foreach($request->addUnitHead as $addUnitHead) {
                $addNew->head =$addUnitHead ;
                $addNew->dept_id = $dept->id;
            }
            $addNew->save();
        }


        $status = "Department has been updated successfully!!!";
        Session::flash('status', $status);
        return redirect()->route('dept.index');
    }
}
