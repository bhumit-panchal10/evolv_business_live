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


class BlogController extends Controller
{
    public function index(Request $request)
    {
      
        $userId = auth()->id();
        $user = User::where('id', '=', $userId)->where(['status' => 1])->first();
        if ($user->role_id == 1) {
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
                ->where(['blogs.isDelete' => 0, 'blogs.iStatus' => 1])
                ->paginate(env('PAR_PAGE_COUNT',20));
                // dd($Data);
                return view('Blog.index', compact('Data','user'));
                

        }else{   

            $Data = Blog::select(
                'blogs.id as blogsid',
                'blogs.blogTitle',
                'blogs.blogDescription',
                'blogs.blogImage',
                'blogs.metaTitle',
                'blogs.metaKeyword',
                'blogs.rejectedcomments',
                'blogs.metaDescription',
                'blogs.status as blogstatus',
                'blogs.user_id', 
                'users.*'
            )
                ->join('users', 'blogs.user_id', '=', 'users.id') 
                ->orderBy('blogs.id', 'DESC')
                ->where(['blogs.isDelete' => 0, 'blogs.iStatus' => 1 , 'blogs.user_id' => $user->id,])
                ->paginate(env('PAR_PAGE_COUNT',20));
                return view('Blog.index', compact('Data','user'));
    
        } 
    }

    public function status(Request $request)
    {
        try { 
        // dd($request);

        DB::table('blogs')->where('id', $request->id)->update([
            'status' => $request->newStatus,
            'rejectedcomments'   => $request->rejectedComments,
        ]);
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
            ->where(['blogs.isDelete' => 0, 'blogs.iStatus' => 1])
            ->paginate(env('PAR_PAGE_COUNT',20));

            return view('Blog.index', compact('Data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function createview()
    {
        try { 
                $user = User::all();
                $Data = Blog::where(['isDelete' => 0, 'iStatus' => 1])->get();
                return view('Blog.add', compact('Data','user'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }

    public function create(Request $request)
    {
        // dd($request);
        $user = Auth::user();
        if ($user->role_id == 1) {
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
            'status'  =>1,
            'blogDate' => date('Y-m-d'),
            'blog_slug'=>$slug,
            'strIP' => $request->ip(),
        ]);
        return redirect()->route('Blog.index')->with('success', 'Blog Created Successfully.');
    }else{
 
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
        return redirect()->route('Blog.index')->with('success', 'Blog Created Successfully.');
           
        }
    }
    public function editview(Request $request, $id)
    {
        try { 
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
            
                return view('Blog.edit', compact('Data','user','alluser'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }

    public function update(Request $request)
    {
        try {  
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
               // 'user_id'   => auth()->id(),
                'blogTitle' => $request->blogTitle,
                'blogImage' => $img,
                'blogDescription' => $request->blogDescription,
                'metaTitle' => $request->metaTitle,
                // 'head' => $request->head,
                'blog_slug'=>$slug,
                'metaKeyword' => $request->metaKeyword,
                'metaDescription' => $request->metaDescription,
            ]);

        return redirect()->route('Blog.index')->with('success', 'Blog Updated Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function delete(Request $request)
    {
        try {  
                DB::table('blogs')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();
                return back()->with('success', 'Blog Deleted Successfully!.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }
  
}
