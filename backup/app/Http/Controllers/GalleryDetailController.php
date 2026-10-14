<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\GalleryDetail;
use Illuminate\Support\Facades\DB;

class GalleryDetailController extends Controller
{
    public function index(Request $request, $id)
    {
        $Data = GalleryDetail::orderBy('gallery_detail_id', 'DESC')->where(['photo_gallery_detail.isDelete' => 0, 'photo_gallery_detail.iStatus' => 1, 'photo_gallery_detail.gallery_id' => $id])->paginate(env('PAR_PAGE_COUNT',20));
        //dd($Data);
        $AlbumName = Gallery::orderBy('gallery_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0, 'gallery_id' => $id])->first();

        return view('gallerydetail.index', compact('Data', 'id', 'AlbumName'));
    }

    public function createview()
    {
        $Data = GalleryDetail::where(['isDelete' => 0, 'iStatus' => 1])->get();

        return view('gallerydetail.add', compact('Data'));
    }


    public function create(Request $request)
    {
     

        $img = "";
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('photo');
                $img = time() . '_' . mt_rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                //dd($img);
                $destinationpath = $root . '/GalleryDetail/';
                if (!file_exists($destinationpath)) {
                    mkdir($destinationpath, 0755, true);
                }
                $file->move($destinationpath, $img);
                //dd($file);

                $Data = array([
                    'gallery_id' => $request->gallery_id,
                    'photo' => $img,
                    'strIP' => $request->ip()
                ]);
                //dd($Data);
                DB::table('photo_gallery_detail')->insert($Data);
            }
        }

        return redirect()->route('gallerydetail.index', $request->gallery_id)->with('success', 'Album Detail Created Successfully.');
    }

    public function delete(Request $request)
    {
        // dd($request);
        $delete = DB::table('photo_gallery_detail')->where(['iStatus' => 1, 'isDelete' => 0, 'gallery_detail_id' => $request->id])->first();
        $root = $_SERVER['DOCUMENT_ROOT'];
        $destinationpath = $root . '/GalleryDetail/';
        unlink($destinationpath . $delete->photo);

        DB::table('photo_gallery_detail')->where(['iStatus' => 1, 'isDelete' => 0, 'gallery_detail_id' => $request->id])->delete();
        return back();
    }

    public function deleteselected(Request $request)
    {
        // dd('hello');
        // dd($request);
        $Data = 0;
        $data = array('iStatus' => 1);
        foreach ($request->check_list as $id) {
            $delete = DB::table('photo_gallery_detail')->where(['iStatus' => 1, 'isDelete' => 0, 'gallery_detail_id' => $id])->first();

            $Data = GalleryDetail::where('gallery_detail_id', '=', $id)->delete($data);

            $root = $_SERVER['DOCUMENT_ROOT'];
            $destinationpath = $root . '/GalleryDetail/';
            unlink($destinationpath . $delete->photo);
        }
        echo $Data;
    }
}
