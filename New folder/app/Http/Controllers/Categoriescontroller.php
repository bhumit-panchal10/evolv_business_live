<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use validate;
use Illuminate\Support\Str;

class Categoriescontroller extends Controller
{
    public function index(Request $request)
    {
        try {  
                $categorysearch = $request->category_id;
                $category = Categories::select('id', 'name')->get();
                $datas = Categories::select('id', 'name','photo')
                ->orderBy('name')
                ->when($request->category_id, function ($query) use ($categorysearch) {
                $query->where('categories.id', '=', $categorysearch);
                })
            ->paginate(env('PAR_PAGE_COUNT',20));
            
                $Count = $datas->count();
            
                return view('categories.index', compact('Count','datas','category','categorysearch'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }

    public function create(Request $request)
    {
        try { 
                // dd($request);
                $validation = $request->validate([
                    'name' => 'required|unique:categories',
                ]);

                $img = ""; // Initialize $img variable
                if ($request->hasFile('photo')) {
                    $root = $_SERVER['DOCUMENT_ROOT'];
                    $image = $request->file('photo');
                    $img = time() . '.' . $image->getClientOriginalExtension();
                    $destinationpath = $root . '/category/';
                    if (!file_exists($destinationpath)) {
                        mkdir($destinationpath, 0755, true);
                    }
                    $image->move($destinationpath, $img);
                }

                $slug=Str::slug($request->name);
                $Data = array(
                    'name' => $request->name,
                    'photo' =>$img,
                    'category_slug' => $slug,
                    'created_at' => date('Y-m-d H:i:s'),
                    'strIP' => $request->ip()
                );
                // dd($Data);
                DB::table('categories')->insert($Data);

                return back()->with('success', 'Category Created Successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }

    public function editview(Request $request, $id)
    {
        $data = Categories::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();

        echo json_encode($data);
    }

	public function update(Request $request)
	{
        try { 
            
                $existingCategory = DB::table('categories')
                ->where('name', $request->name)
                ->where('id', '!=', $request->id)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->first();

                if ($existingCategory) {     
                return back()->with('error', 'Category name already exists for a different category.');
                }

                $img = "";
                if ($request->hasFile('photo')) {
                    $root = $_SERVER['DOCUMENT_ROOT'];
                    $image = $request->file('photo');
                    $img = time() . '.' . $image->getClientOriginalExtension();
                    //dd($img);
                    $destinationpath = $root . '/category/';
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
                $update = DB::table('categories')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
                ->update([
                    'name' => $request->name,
                    'photo' =>$img,
                    'category_slug' => $slug,
                    'updated_at' => now() 
                ]);
            
                return back()->with('success', 'Category Updated Successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
	}

    public function delete(Request $request)
    {
        try { 
                $delete = DB::table('categories')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->first();
                
                if ($delete) {
                    if (!empty($delete->photo)) {
                        $root = $_SERVER['DOCUMENT_ROOT'];
                        $destinationpath = $root . '/category/';
                        $filePath = $destinationpath . $delete->photo;
            
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                    DB::table('categories')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();
                    return back()->with('success', 'Category Deleted Successfully!.');
                } else {
                    return back()->with('error', 'Category not found or already deleted.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }

    public function checkserviceprovider(Request $request)
    {
        
        $data = Categories::where(['iStatus' => 1, 'isDelete' => 0, 'name' => $request->name])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
