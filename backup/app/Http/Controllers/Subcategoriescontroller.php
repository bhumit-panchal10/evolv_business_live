<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\subcategories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use validate;

class Subcategoriescontroller extends Controller
{
    public function index(Request $request)
    {
     
        $category = Categories::select('id', 'name')->get();
        $datas = subcategories::orderBy('id', 'desc')->paginate(10);
        
        return view('subcategories.index', compact('datas','category'));
    }

    public function create(Request $request)
{
   
    $request->validate([
        'name' => 'required',
        'category_id' => 'required',
    ]);

   
    $existingSubcategory = DB::table('sub_categories')
        ->where('name', $request->name)
        ->where('category_id', $request->category_id)
        ->first();

    if ($existingSubcategory) {
      
        return back()->with('error', 'Subcategory already exists for the selected category.');
    }

    
    $data = [
        'name' => $request->name,
        'category_id' => $request->category_id,
        'created_at' => now(),
        'strIP' => $request->ip(),
    ];

    DB::table('sub_categories')->insert($data);

    return back()->with('success', 'Subcategory created successfully.');
}

    public function editview(Request $request, $id)
    {
        $cities = Categories::select('id', 'name')->get();
        $data = subcategories::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();
    echo json_encode($data);
    
    }
    

    public function update(Request $request)
{
   
    $request->validate([
        'name' => 'required',
        'category_id' => 'required',
    ]);

   
    $existingSubcategory = DB::table('sub_categories')
        ->where('name', $request->name)
        ->where('category_id', $request->category_id)
        ->where('id', '!=', $request->id)
        ->where('iStatus', 1)
        ->where('isDelete', 0)
        ->first();

    if ($existingSubcategory) {
     
        return back()->with('error', 'Subcategory name already exists for the selected category.');
    }

    // If the subcategory is unique, proceed with the update
    $update = DB::table('sub_categories')
        ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
        ->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'updated_at' => now(),
        ]);

    return back()->with('success', 'Subcategory updated successfully.');
}


    public function delete(Request $request)
    {
        DB::table('sub_categories')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();

        return back()->with('success', 'Sub categories Deleted Successfully!.');
    }

    public function checkserviceprovider(Request $request)
    {
        
        $data = subcategories::where(['iStatus' => 1, 'isDelete' => 0, 'name' => $request->name])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }
}

