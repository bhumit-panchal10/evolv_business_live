<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Models\PointsMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use validate;

class PointsMasterController extends Controller
{
    public function index(Request $request)
    {
        $datas = PointsMaster::select('id', 'points_name', 'points')->paginate(env('PAR_PAGE_COUNT', 20));
        $Count = $datas->count();
        return view('Points.index', compact('datas', 'Count'));
    }



    public function editview(Request $request, $id)
    {
        $data = PointsMaster::where(['id' => $id])->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'points' => 'required',
        ]);

        $update = DB::table('points_master')
            ->where(['id' => $request->id])
            ->update([
                'points' => $request->points,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Points Updated Successfully.');
    }




    public function delete(Request $request)
    {
        DB::table('city')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();

        return back()->with('success', 'City Deleted Successfully!.');
    }

    public function checkserviceprovider(Request $request)
    {
        // dd('call');
        $data = City::where(['iStatus' => 1, 'isDelete' => 0, 'city_name' => $request->city_name])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function editcheckserviceprovider(Request $request)
    {
        $data = City::where(['status' => 0, 'serial_no' => $request->city_name])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
