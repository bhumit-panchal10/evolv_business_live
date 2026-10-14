<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products_service;
use App\Models\members;
use App\Models\User;
use App\Models\City;
use App\Models\City_group;
use App\Models\Categories;
use App\Models\subcategories;
use App\Models\membershipplans;
use App\Models\renewalhistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use validate;

class MemberProductscontroller extends Controller
{
    public function Productindex(Request $request)
    {      
        $user = Auth::User();
        $memberData = members::select('*')
        ->where('user_id', $user->id)
        ->first();
    
      $id = $memberData->id;
      $datas = Products_service::select('member_services.*','member_services.id as memberservices_id','members.id','members.user_id','users.id','users.first_name')->orderBy('member_services.id', 'desc')
      ->join('members', 'members.id', '=', 'member_services.member_id')
      ->join('users','users.id','members.user_id') 
      ->where(['member_services.iStatus' => 1, 'member_services.isDelete' => 0, 'members.id' => $id])
      ->orderBy('member_services.id', 'desc')
      ->paginate(env('PAR_PAGE_COUNT',20));
      $count = $datas->count();
// dd($datas);
        return view('MemberProducts.Productindex', compact('datas','user','id','count'));
    }


    public function ProductStoreview(Request $request,$id)
    {
        
        $membersData = members::select('members.id','members.user_id','users.first_name')
        // ->select('members.id', 'users.fullname')
        ->join('users', 'members.user_id', '=', 'users.id')
        ->get();
// dd($membersData);
       return view('MemberProducts.ProductStoreview',compact('membersData','id'));
    }


    public function create(Request $request)
    {
        $priceType = $request->input('price_type');
        
        $request->validate([
            
            'memberid' => 'required',
            'product_name' => 'required',
            // 'photo' => 'required',
            // 'price' => 'required',
            
        ]); 

        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/productimage/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }
        
        $Data = array(
            'member_id' => $request->memberid,
            'product_name'    => $request->product_name,
            'photo'    => $img,
            'description'    => $request->description,
            'price_type'    =>$priceType,
            'price'    => $request->price,
            'Hash_Tag'    =>$request->multiline_description,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip(),
            'created_by'     => auth()->id()
            
        );
        
        if ($priceType === 'fixed') {
            $Data['price'] = $request->input('fixed_price');
        } elseif ($priceType === 'ranged') {
            $Data['min_price'] = $request->input('min_price');
            $Data['max_price'] = $request->input('max_price');
        }
        //  dd( $Data);
        
        DB::table('member_services')->insert($Data);

        return redirect()->route('MemberProducts.Productindex',$request->memberid)->with('success', 'Product-service Created Successfully.');
    }


    public function editview(Request $request)
    {
        // dd($request);
        $data = Products_service::select('member_services.*','member_services.id as memberservices_id','members.id','members.user_id','users.id','users.first_name')->orderBy('member_services.id')
    ->join('members', 'members.id', '=', 'member_services.member_id')
    ->join('users','users.id','members.user_id') 
    ->where(['member_services.iStatus' => 1, 'member_services.isDelete' => 0, 'member_services.id' => $request->id])
    ->first();
// dd($data);
    // echo json_encode($data);

     return view('MemberProducts.productedit',compact('data'));
    }


  
    public function delete(Request $request)
{
    // $delete = DB::table('member_services')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->first();
    DB::table('member_services')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();
    return back()->with('success', 'Product-service Deleted Successfully!.');
}



    public function update(Request $request)
    {
    //  dd($request);
        $priceType = $request->input('edit_price_type');
        $request->validate([
            'product_name' => 'required',
            
        ]);

        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/productimage/';
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

       
        $Data = array(
            'member_id' => $request->member_id,
            'product_name'    => $request->product_name,
            'photo'    => $img,
            'description'    => $request->description,
            'price_type'    =>$priceType,
            'price'    => $request->edit_fixed_price,
            'Hash_Tag'    =>$request->multiline_description,
            'updated_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip(),
            'updated_by'     => auth()->id()
            
        );
        if ($priceType === 'fixed') {
            $Data['price'] = $request->input('edit_fixed_price');
        } elseif ($priceType === 'ranged') {
            $Data['min_price'] = $request->input('edit_min_price');
            $Data['max_price'] = $request->input('edit_max_price');
        }
        //  dd($Data);
        DB::table('member_services')->where('id', $request->id)->update($Data);

        return redirect()->route('MemberProducts.Productindex',$request->member_id)->with('success', 'Product-service update Successfully.');
    }
}