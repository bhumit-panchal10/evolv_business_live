<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videogallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VideogalleryController extends Controller
{

    public function index()
    {
        // dd($request);
        $Gallery = Videogallery::orderBy('video_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->paginate(env('PAR_PAGE_COUNT',20));
        // dd($Banner);

        return view('videogallery.index', compact('Gallery'));
    }

    public function createview()
    {
        return view('videogallery.add');
    }

    public function create(Request $request)
    {
        $slug=Str::slug($request->name);
        $Data = array(
            'name' => $request->name,
            'vidoeurl' => $request->vidoeurl,
            'comments' => $request->comments,
            'video_slug'=>$slug,
            'date'=>$request->date,
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        // dd($Data);
        DB::table('video_gallery')->insert($Data);

        return redirect()->route('videogallery.index')->with('success', 'Video Gallery Created Successfully.');
    }

    public function editview(Request $request, $Id)
    {
        $Gallery = Videogallery::where(['iStatus' => 1, 'isDelete' => 0, 'video_id' => $Id])->first();
        //dd($Product);
        echo json_encode($Gallery);
    }

    public function update(Request $request)
    {
        $slug=Str::slug($request->name); 
        $Product = DB::table('video_gallery')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'video_id' => $request->video_id])
            ->update([
                'name' => $request->name,
                'vidoeurl' => $request->vidoeurl,
                'comments' => $request->comments,
                'video_slug'=>$slug,
                'date'=>$request->date,
                "strIP" => $_SERVER['REMOTE_ADDR']
            ]);
        //dd($Product);
        return redirect()->route('videogallery.index')->with('success', 'Video Gallery Updated Successfully.');
    }

    public function delete(Request $request)
    {
        // dd($request);
        $delete = DB::table('video_gallery')->where(['iStatus' => 1, 'isDelete' => 0, 'video_id' => $request->id])->first();
       
        DB::table('video_gallery')->where(['iStatus' => 1, 'isDelete' => 0, 'video_id' => $request->id])->delete();
        return redirect()->route('videogallery.index')->with('success', 'Video Gallery Deleted Successfully!.');
    }
}
