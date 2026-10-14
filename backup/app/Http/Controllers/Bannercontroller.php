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
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
class Bannercontroller extends Controller
{
    public function index(Request $request)
    {
        try { 
                // dd('call');
                $Banner = Banner::orderBy('banner_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->paginate(env('PAR_PAGE_COUNT',20));
                $Count =$Banner->count();
                return view('Banner.index', compact('Banner','Count'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }

    public function create(Request $request)
    {
        try { 
                // dd($request->all());
                $img = "";
                if ($request->hasFile('photo')) {
                    $root = $_SERVER['DOCUMENT_ROOT'];
                    $image = $request->file('photo');
                    $img = time() . '.' . $image->getClientOriginalExtension();
                    $destinationpath = $root . '/Banner/';
                    if (!file_exists($destinationpath)) {
                        mkdir($destinationpath, 0755, true);
                    }
                    $image->move($destinationpath, $img);
                }

                $Data = array(
                    'Title' => $request->Title,
                    'photo' => $img,
                    "strIP" => $_SERVER['REMOTE_ADDR']
                );
                // dd($Data);
                DB::table('banners')->insert($Data);

                return redirect()->route('Banner.index')->with('success', 'Offer Banner Created Successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }


    public function editview(Request $request, $Id)
    {
        // dd('call');

        $Overteem = Banner::where(['iStatus' => 1, 'isDelete' => 0, 'banner_id' => $Id])->first();

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
            $destinationpath = $root . '/Banner/';
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
        $Product = DB::table('banners')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'banner_id' => $request->banner_id])
            ->update([
                'Title' => $request->Title,
                'photo' => $img,
                "strIP" => $_SERVER['REMOTE_ADDR']
            ]);
        // dd($Product);
        return redirect()->route('Banner.index')->with('success', 'Offer Banner Updated Successfully.');
    }


    public function delete(Request $request)
    {
        try { 
        // dd($request);
                $delete = DB::table('banners')->where(['iStatus' => 1, 'isDelete' => 0, 'banner_id' => $request->id])->first();

                if (!empty($delete->photo)) 
                {
                    $root = $_SERVER['DOCUMENT_ROOT'];
                    $destinationpath = $root . '/Banner/';
                    $filePath = $destinationpath . $delete->photo;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                DB::table('banners')->where(['iStatus' => 1, 'isDelete' => 0, 'banner_id' => $request->id])->delete();
                return redirect()->route('Banner.index')->with('success', 'Offer Banner Deleted Successfully!.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }
    

  
}
