<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\subcategories;
use App\Models\members;
use App\Models\User;
use App\Models\City;
use App\Models\City_group;
use App\Models\Categories;
use App\Models\membershipplans;
use App\Models\renewalhistory;
use App\Models\Overteem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class Overteemcontroller extends Controller
{
    public function index(Request $request)
    {
       
        $Overteem = Overteem::orderBy('Overteem_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->paginate(env('PAR_PAGE_COUNT',20));
        $Count =$Overteem->count(); 
        return view('overteem.index', compact('Overteem','Count'));
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/overteem/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }

        $Data = array(
            'Overteem_name' => $request->name,
            'Overteem_photo' => $img,
            'designation' => $request->designation,
            'description' => $request->description,
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        // dd($Data);
        DB::table('Overteem')->insert($Data);

        return redirect()->route('overteem.index')->with('success', 'Our Team Created Successfully.');
    }


    public function editview(Request $request, $Id)
    {
        // dd('call');

        $Overteem = Overteem::where(['iStatus' => 1, 'isDelete' => 0, 'Overteem_id' => $Id])->first();

        // dd($Overteem);
        echo json_encode($Overteem);
    }

    public function update(Request $request)
    {
        // dd($request);

        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            //dd($img);
            $destinationpath = $root . '/overteem/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
            $oldImg = $request->input('hiddenPhoto') ? $request->input('hiddenPhoto') : null;
            //dd($oldImg);

            if ($oldImg != null || $oldImg != "") {
                if (file_exists($destinationpath . $oldImg)) {
                    unlink($destinationpath . $oldImg);
                }
            }
        } elseif ($request->input('hiddenPhoto')) {
            $oldImg = $request->input('hiddenPhoto');
            $img = $oldImg;
        } else {
            // $root = $_SERVER['DOCUMENT_ROOT'];
            // $img = $root . '/images/noimage.jpg';
            //   $img = null;
        }

    //    dd('call');
        $Product = DB::table('Overteem')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'Overteem_id' => $request->Overteem_id])
            ->update([
                'Overteem_name' => $request->name,
                'Overteem_photo' => $img,
                'description' => $request->description,
                'designation' => $request->designation,
                "strIP" => $_SERVER['REMOTE_ADDR']
            ]);
        // dd($Product);
        return redirect()->route('overteem.index')->with('success', 'Our Team Updated Successfully.');
    }


    public function delete(Request $request)
    {
        // dd($request);
        $delete = DB::table('Overteem')->where(['iStatus' => 1, 'isDelete' => 0, 'Overteem_id' => $request->id])->first();
        $root = $_SERVER['DOCUMENT_ROOT'];
        $destinationpath = $root . '/overteem/';
        unlink($destinationpath . $delete->Overteem_photo);

        DB::table('Overteem')->where(['iStatus' => 1, 'isDelete' => 0, 'Overteem_id' => $request->id])->delete();
        return redirect()->route('overteem.index')->with('success', 'Our Team Deleted Successfully!.');
    }

}
