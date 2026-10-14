<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GalleryController extends Controller
{

    public function index()
    {
        // dd($request);
        $Gallery = Gallery::orderBy('gallery_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->paginate(env('PAR_PAGE_COUNT'));
        // dd($Banner);

        return view('gallery.index', compact('Gallery'));
    }

    public function createview()
    {
        return view('gallery.add');
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/Gallery/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }
        $slug=Str::slug($request->name);
        $Data = array(
            'name' => $request->name,
            'photo' => $img,
            'photo_slug'=>$slug,
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        // dd($Data);
        DB::table('photo_gallery')->insert($Data);

        return redirect()->route('gallery.index')->with('success', 'Gallery Created Successfully.');
    }

    public function editview(Request $request, $Id)
    {
        $Gallery = Gallery::where(['iStatus' => 1, 'isDelete' => 0, 'gallery_id' => $Id])->first();
        //dd($Product);
        echo json_encode($Gallery);
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
            $destinationpath = $root . '/Gallery/';
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
        $slug=Str::slug($request->name);
        $Product = DB::table('photo_gallery')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'gallery_id' => $request->gallery_id])
            ->update([
                'name' => $request->name,
                'photo' => $img,
                'photo_slug'=>$slug,
                "strIP" => $_SERVER['REMOTE_ADDR']
            ]);
        //dd($Product);
        return redirect()->route('gallery.index')->with('success', 'Gallery Updated Successfully.');
    }

    public function delete(Request $request)
    {
        // dd($request);
        $delete = DB::table('photo_gallery')->where(['iStatus' => 1, 'isDelete' => 0, 'gallery_id' => $request->id])->first();
        $root = $_SERVER['DOCUMENT_ROOT'];
        $destinationpath = $root . '/Gallery/';
        unlink($destinationpath . $delete->photo);
        DB::table('photo_gallery')->where(['iStatus' => 1, 'isDelete' => 0, 'gallery_id' => $request->id])->delete();
        return redirect()->route('gallery.index')->with('success', 'Gallery Deleted Successfully!.');
    }
}
