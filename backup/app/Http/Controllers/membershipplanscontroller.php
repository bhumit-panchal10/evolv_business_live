<?php

namespace App\Http\Controllers;
use App\Models\membershipplans;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use validate;

use Illuminate\Http\Request;

class membershipplanscontroller extends Controller
{
    public function index(Request $request)
    {
        $datas = membershipplans::orderBy('id', 'desc')->paginate(env('PAR_PAGE_COUNT',20));
        $Count = $datas->count();
       
        return view('membershipplans.index', compact('datas','Count'));
    }

     public function create(Request $request)
    {
        // dd($request);
        $request->validate([
            'plan_name'        => 'required|unique:membership_plans,plan_name',
            'duration_in_days' => 'required',
            'amount'           => 'required',
            'discount'         => 'required|numeric|min:0|max:50',    
              
        ]);
        $calculatedDiscount = min($request->amount * ($request->discount / 100), 0.5 * $request->amount);

        $Data = array(
            'plan_name'  => $request->plan_name,
            'duration_in_days'  => $request->duration_in_days,
            'amount'            => $request->amount,
            'discount'          => $request->discount,
            'discountamout'=> $calculatedDiscount,
            'created_at'        => date('Y-m-d H:i:s'),
            'strIP'             => $request->ip()
        );
        DB::table('membership_plans')->insert($Data);

        return back()->with('success', 'Membership plan Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        $data = membershipplans::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

        echo json_encode($data);
    }

   public function update(Request $request)
{
    $request->validate([
        'plan_name'        => 'required|unique:membership_plans,plan_name,' . $request->id . ',id',
        'duration_in_days' => 'required',
        'amount'           => 'required',
        'discount'         => 'required|numeric|min:0|max:50',    
          
    ]);

    $calculatedDiscount = min($request->amount * ($request->discount / 100), 0.5 * $request->amount);
// dd($calculatedDiscount);

    $update = DB::table('membership_plans')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
            ->update([
                'plan_name'         => $request->plan_name,
                'duration_in_days'  => $request->duration_in_days,
                'amount'            => $request->amount,
                'discount'          => $request->discount,
                'discountamout'=> $calculatedDiscount,
                'updated_at'        => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Membership plan Updated Successfully.');
    }


    public function delete(Request $request)
    {
        DB::table('membership_plans')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();

        return back()->with('success', 'Membership plan Deleted Successfully!.');
    }

    // public function checkserviceprovider(Request $request)
    // {
        
    //     $data = membershipplans::where(['iStatus' => 1, 'isDelete' => 0, 'city_name' => $request->city_name])->count();
    //     if ($data > 0) {
    //         echo 1;
    //     } else {
    //         echo 0;
    //     }
    // }


}

