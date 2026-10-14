<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\Category;
use App\Models\CategoryMultiple;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Str;

class memberblogcontroller extends Controller
{
    public function blogindex(Request $request)
    {
        $userId = auth()->id();
        $user = User::where('id', '=', $userId)->where(['status' => 1])->first();
    
        $Data = Blog::select(
                'blogs.id as blogsid',
                'blogs.blogTitle',
                'blogs.blogDescription',
                'blogs.blogImage',
                'blogs.metaTitle',
                'blogs.metaKeyword',
                'blogs.metaDescription',
                'blogs.rejectedcomments',
                'blogs.status as blogstatus',
                'blogs.user_id', 
                'users.*'
            )
            ->join('users', 'blogs.user_id', '=', 'users.id') 
            ->orderBy('blogs.id', 'DESC')
            ->where('blogs.isDelete', 0)
            ->where('blogs.iStatus', 1)
            ->where('blogs.user_id', $user->id) 
            ->paginate(env('PAR_PAGE_COUNT',20));
            $Count = $Data->count();
        // dd($Data);
        return view('Usermember.blogindex', compact('Data', 'user','Count'));  
    }

    public function createview()
    {
        $user = User::all();
        $Data = Blog::where(['isDelete' => 0, 'iStatus' => 1])->get();
        return view('Usermember.blogadd', compact('Data','user'));
    }

    public function create(Request $request)
    {
        // dd($request);
        $user = Auth::user();
        $img = "";
        if ($request->hasFile('blogImage')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('blogImage');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/Blog/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }
        $slug=Str::slug($request->blogTitle);
        $data = Blog::create([
            'user_id'   => auth()->id(),
            'blogTitle' => $request->blogTitle,
            'blogImage' => $img,
            'blogDescription' => $request->blogDescription,
            'metaTitle' => $request->metaTitle,
            'metaKeyword' => $request->metaKeyword,
            'metaDescription' => $request->metaDescription,
            'blogDate' => date('Y-m-d'),
            'blog_slug'=>$slug,
            'strIP' => $request->ip(),
        ]);
        return redirect()->route('Usermember.blogindex')->with('success', 'Blog Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        // dd($request->id);
        $userId = auth()->id();
        $alluser =User::get();
    
        $user = User::where('id', '=', $request->id)->where(['status' => 1])->first();
        $Data = Blog::select(
            'blogs.id as blogsid',
            'blogs.blogTitle',
            'blogs.blogDescription',
            'blogs.blogImage',
            'blogs.metaTitle',
            'blogs.metaKeyword',
            'blogs.metaDescription',
            'blogs.status as blogstatus',
            'blogs.user_id', 
            'users.*'
        )
            ->join('users', 'blogs.user_id', '=', 'users.id') 
            ->orderBy('blogs.id', 'DESC')
            ->where(['blogs.id' => $request->id,'blogs.isDelete' => 0, 'blogs.iStatus' => 1])
            ->first();
           
            // dd($Data);
       
        return view('Usermember.blogedit', compact('Data','user','alluser'));
    }

    public function update(Request $request)
    {
        // dd($request);
        $img = "";
        if ($request->hasFile('blogImage')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('blogImage');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/Blog/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
            $oldImg = $request->input('hiddenPhoto') ? $request->input('hiddenPhoto') : null;

            if ($oldImg != null || $oldImg != "") {
                if (file_exists($destinationpath . $oldImg)) {
                    unlink($destinationpath . $oldImg);
                }
            }
        } else {
            $oldImg = $request->input('hiddenPhoto');
            $img = $oldImg;
        }
        $slug=Str::slug($request->blogTitle);
        $Student = DB::table('blogs')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->blogId])
            ->update([
                // 'categoryId' => $request->categoryID,
                'user_id'   => auth()->id(),
                'blogTitle' => $request->blogTitle,
                'blogImage' => $img,
                'blogDescription' => $request->blogDescription,
                'metaTitle' => $request->metaTitle,
                // 'head' => $request->head,
                'blog_slug'=>$slug,
                'metaKeyword' => $request->metaKeyword,
                'metaDescription' => $request->metaDescription,
            ]);

        return redirect()->route('Usermember.blogindex')->with('success', 'Blog Updated Successfully.');
    }
    public function delete(Request $request)
    {
        // dd($request->id);
        DB::table('blogs')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();

        return back()->with('success', 'Blog Deleted Successfully!.');
    }
}
