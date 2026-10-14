<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products_service;
use App\Models\OneToOne;
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

class MemberOneToOneController extends Controller
{

    public function getStatus($id)
    {
        $data = OneToOne::find($id);

        return response()->json($data);
    }
    public function index(Request $request)
    {
        $user = Auth::User();
        $memberData = members::select('*')
            ->where('user_id', $user->id)
            ->first();

        // $id = $memberData->id;
        $datas = OneToOne::where('to_id',$user->id)->paginate(env('PAR_PAGE_COUNT', 20));
        $count = $datas->count();
        // dd($datas);
        return view('MemberOneToOne.index', compact('datas', 'user', 'count'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'newStatus' => 'required|in:0,1,2',
        ]);

        $data = OneToOne::find($request->id);

        if (!$data) {
            return redirect()->back()->with('error', 'Record not found');
        }

        // If Approved → insert points
        if ($request->newStatus == 1) {

            // check already exists (avoid duplicate points)
            $exists = DB::table('member_points')
                ->where('business_id', $data->id)
                ->where('points_id', 6)
                ->exists();

            if (!$exists) {
                DB::table('member_points')->insert([
                    'member_id' => $data->to_id,
                    'business_id' => $data->id,
                    'points_id' => 6,
                    'points' => 5,
                    'status' => 1,
                    'created_at' => now(),
                ]);
            }
        }

        // Update status
        $data->isapproved_status = $request->newStatus;
        $data->reject_comment = $request->comment ?? null;
        $data->updated_at = now();
        $data->save();

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }
}
