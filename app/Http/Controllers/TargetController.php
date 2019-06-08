<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Target;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::all();
        return view('target.index', compact('target'));
    }
}
