<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\members;
use App\Models\City;
use App\Models\City_group;
use App\Models\Categories;
use App\Models\subcategories;
use App\Models\membershipplans;
use App\Models\Business;
use App\Models\renewalhistory;
use App\Models\Adminuserpermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;


class CheckApprovalStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        // dd($user);
        if($user->role_id == 2)
        {
            $loginPendingCheck = Business::join('users', 'users.id', '=', 'Business.business_to_id')
                ->where('users.id', $user->id)
                ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 0])
                ->orderBy('Business.business_id', 'DESC')
                ->get();
        
            if (!$loginPendingCheck->isEmpty()) 
            {
                // foreach ($loginPendingCheck as $pendingCheck)
                // {
                //     if ($pendingCheck->isapproved_status == 0)
                //     {
                        // dd('enter');
                        return redirect()->route('pendinglogincheck.index');
                //     }
                // }
            } else {
                return $next($request);
            }
        }    
        return $next($request);
    }
}