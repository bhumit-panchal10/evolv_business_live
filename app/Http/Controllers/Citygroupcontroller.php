<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\City_group;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use validate;


class Citygroupcontroller extends Controller
{
    public function index(Request $request)
    {
    
        $cities = City::select('id', 'city_name')->orderBy('city_name')->get();
        $datas = City_group::orderBy('id', 'desc')->paginate(env('PAR_PAGE_COUNT',20));
        $Count =$datas->count();
        
        return view('serviceprovider.citygroupindex', compact('Count','datas','cities'));
    }

    public function create(Request $request)
    {

        // dd($request->city_id);
        $request->validate([
            'group_name' => ['required',
                Rule::unique('city_groups')->where(function ($query) use ($request) {
                    return $query->where('city_id', $request->city_id);
                }),
            ],
            // other validation rules...
        ]);

        $Data = array(
            'group_name' => $request->group_name,
            'city_id'    => $request->city_id,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()  
        );
        DB::table('city_groups')->insert($Data);
        return back()->with('success', 'Group Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        $cities = City::select('id', 'city_name')->get();
        $data = City_group::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

      echo json_encode($data);
    
    }
    

    public function update(Request $request)
    {
        // dd($request);

        $request->validate([
            'group_name' => [
                'required',
                Rule::unique('city_groups')->where(function ($query) use ($request) {
                    return $query->where('city_id', $request->city_id);
                })->ignore($request->id),
            ],
            // other validation rules...
        ]);

        $update = DB::table('city_groups')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
            ->update([
                'group_name' => $request->group_name,
                'city_id'    => $request->city_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return back()->with('success', 'Group Updated Successfully.');
    }


    public function delete(Request $request)
    {
        DB::table('city_groups')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();

        return back()->with('success', 'Group Deleted Successfully!.');
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

}
