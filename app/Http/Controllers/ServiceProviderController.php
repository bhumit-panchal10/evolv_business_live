<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use validate;

class ServiceProviderController extends Controller
{
    public function index(Request $request)
    {
        $datas = City::select('id', 'city_name')->orderBy('city_name')->paginate(env('PAR_PAGE_COUNT',20));
        $Count = $datas->count();
        
        return view('serviceprovider.index', compact('datas','Count'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'city_name' => 'required|unique:city,city_name',
        ]);

        $Data = array(
            'city_name' => $request->city_name,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        DB::table('city')->insert($Data);

        return back()->with('success', 'city Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        $data = City::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'city_name' => 'required|unique:city,city_name,' . $request->id . ',id',
        ]);

        $update = DB::table('city')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
            ->update([
                'city_name' => $request->city_name,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'City Updated Successfully.');
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
