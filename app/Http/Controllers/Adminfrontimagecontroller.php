<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adminfrontimage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use validate;

class Adminfrontimagecontroller extends Controller
{
    public function index(Request $request)
    {
       
        $datas = Adminfrontimage::orderBy('id', 'desc')->paginate(env('PAR_PAGE_COUNT',20));

        return view('Adminfrontimage.index', compact('datas'));
    }

    public function create(Request $request)
    {
    
        // dd($request);
        $validation = $request->validate([
            'Title' => 'required',
        ]);

        $img = ""; // Initialize $img variable
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/Adminfrontimage/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }


        $Data = array(
            'Title' => $request->Title,
            'button_link' => $request->button_link,
            'photo' =>$img,
            'created_at' => date('Y-m-d H:i:s'),
            
        );
        // dd($Data);
        DB::table('Adminfrontimage')->insert($Data);

        return back()->with('success', 'Banner Image Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        $data = Adminfrontimage::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

        echo json_encode($data);
    }

	public function update(Request $request)
	{
	//   dd($request);
        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            //dd($img);
            $destinationpath = $root . '/Adminfrontimage/';
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

	    $update = DB::table('Adminfrontimage')
		->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
		->update([
		    'Title' => $request->name,
            'button_link' => $request->button_link,
            'photo' =>$img,
		    'update_at' => now() 
		]);
    //    dd($update);
	    return back()->with('success', 'Banner Image Updated Successfully.');
	}

    public function delete(Request $request)
    {
        $delete = DB::table('Adminfrontimage')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->first();
        $root = $_SERVER['DOCUMENT_ROOT'];
        $destinationpath = $root . '/Adminfrontimage/';
        unlink($destinationpath . $delete->photo);
        DB::table('Adminfrontimage')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();

        return back()->with('success', 'Banner Image Deleted Successfully!.');
    }

    // public function checkserviceprovider(Request $request)
    // {
        
    //     $data = Adminfrontimage::where(['iStatus' => 1, 'isDelete' => 0, 'name' => $request->name])->count();
    //     if ($data > 0) {
    //         echo 1;
    //     } else {
    //         echo 0;
    //     }
    // }
}