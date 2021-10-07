<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Validator;

class PlanController extends Controller
{

    public function index()
    {
        $data['plans'] = Plan::all();
        return view('zeus.plans.index', $data);
    }

    public function createPlan()
    {
        return view('zeus.plans.create');
    }

    public function storePlan(Request $request)
    {
        $data=$request->all();
        // dd($data);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'amount' => 'required',
            'number_of_subusers' => 'required',
            'number_of_accounts' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        Plan::createNewPlan($request->all());

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully');
    }

     public function edit($id)
    {
        $data['plan'] = Plan::findOrFail($id);
        return view('zeus.plans.edit', $data);
    }

        public function updatePlan(Request $request)
    {
        $data=$request->all();
        // dd($data);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'amount' => 'required',
            'number_of_subusers' => 'required',
            'number_of_accounts' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        Plan::updatePlan($request->all());

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully');
    }
}
