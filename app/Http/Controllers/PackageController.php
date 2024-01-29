<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packages;    
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {

        return view("packages");
    }

    function upgradePlan(request $request) {
        try {
            $status = $request->input("selected_plan");

            $user_id = Auth::id();            
            Packages::updateOrInsert(
                ['user_id' => $user_id], 
                ['is_active' => $status]  // Data to be inserted or updated
            );
            
            return back()->with('message', 'Successffull');

        } catch (\Exception $e) {
            return back()->with('error', ['errorMessage' => $e->getMessage()]);
        }
          
    }

}
