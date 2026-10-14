<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\members;
use App\Models\User;
use App\Models\City;
use App\Models\City_group;
use App\Models\Categories;
use App\Models\subcategories;
use App\Models\membershipplans;
use App\Models\renewalhistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use validate;
use Carbon\Carbon;
class Renewalhistorycontroller extends Controller
{
    public function index(Request $request,$id)
    {   
    //    dd($id);
        $membername = members::where('id',$id)->first();
        $username =User::where('id',$membername->user_id)->first(); 
        $plans = Membershipplans::select('id', 'plan_name')->get();
        $datas = renewalhistory::select('renewal_history.*', 'renewal_history.id as renewal_history_id', 'members.id as member_id', 'members.user_id', 'users.id as user_id', 'users.first_name','membership_plans.plan_name','membership_plans.amount')
        ->orderBy('renewal_history.id', 'desc')
        ->join('members', 'members.id', '=', 'renewal_history.member_id')
        ->join('users', 'users.id', '=', 'members.user_id')
        ->join('membership_plans','membership_plans.id','renewal_history.plan_id') 
        ->where(['renewal_history.iStatus' => 1, 'renewal_history.isDelete' => 0, 'members.id' => $id])
        ->orderBy('renewal_history.id', 'desc')
        ->paginate(10);
    //    dd($datas);
        return view('Renewalhistory.index', compact('datas','id','plans','username'));
    }

    public function delete(Request $request)
    {
        // dd($request);
        DB::table('renewal_history')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();
        return back()->with('success', 'Renewalhistory Deleted Successfully!.');
    }

    public function checkserviceprovider(Request $request)
    {
        
        $data = City_group::where(['iStatus' => 1, 'isDelete' => 0, 'group_name' => $request->group_name])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }


    public function editview(Request $request)
    {
       
        $renewalHistoryId = $request->id;
        

        $data = renewalhistory::select(
            'renewal_history.*',
            'renewal_history.id as renewal_history_id',
            'membership_plans.id as plan_id',
            'members.id as member_id',
            'members.user_id',
            'users.id as user_id',
            'users.first_name',
            'membership_plans.plan_name'
        )
            ->orderBy('renewal_history.id', 'desc')
            ->join('members', 'members.id', '=', 'renewal_history.member_id')
            ->join('membership_plans', 'membership_plans.id', '=', 'renewal_history.plan_id')
            ->join('users', 'users.id', '=', 'members.user_id')
            ->where(['renewal_history.member_id' => $renewalHistoryId, 'renewal_history.iStatus' => 1, 'renewal_history.isDelete' => 0])
            ->first();
      echo json_encode($data);

    //    return view('Products_service.index',$request->id,compact('product'));
    }

    public function update(Request $request)
{
    // dd($request);
    $planId = $request->input('plan_id');
    $membershipPlan = MembershipPlans::where('id', $planId)->first();
    $oldplan = DB::table('renewal_history')->where('id', $request->id)->first();
    $oldPlanEndDate =$oldplan->stbenddate;  
    $oldEndDate = strtotime($oldPlanEndDate);
    $newRenewalDate = strtotime($request->renewal_date);
    $oldYear = date('Y', $oldEndDate);
    $oldMonth = date('m', $oldEndDate);
    $subStartDate = Carbon::createFromFormat('Y-m-d', $oldYear . '-' . $oldMonth . '-' . date('d', $newRenewalDate));
    
    $subEndDate = $subStartDate->copy()->addDays($membershipPlan->duration_in_days);
    // dd($subEndDate);
  
    $renewalHistory = DB::table('renewal_history')->insertGetId([
        'plan_id'       => $request->plan_id,
        'member_id'     =>$request->member_id,
        'renewal_date'  => $request->renewal_date,
        'updated_at'     => now(),
        // 'PaymentRefNo'  => $request->PaymentRefNo,
        'SubStartDate'  => $subStartDate,
        'StbEndDate'    => $subEndDate,
        
    ]);
    DB::table('members')->where('id', $request->member_id)->update([
        'SubscriptionExpiredDate' => $subEndDate,
        'renewalhistory_id'       => $renewalHistory,
    ]);

     return redirect()->route('Renewalhistory.index',['id' => $request->member_id])->with('success', 'Renewal History Updated Successfully.');
}
}
