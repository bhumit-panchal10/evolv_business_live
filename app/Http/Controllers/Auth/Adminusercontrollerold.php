<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\members;
use App\Models\User;
use App\Models\City;
use App\Models\City_group;
use App\Models\Categories;
use App\Models\subcategories;
use App\Models\membershipplans;
use App\Models\renewalhistory;
use App\Models\Adminuserpermission;
use App\Models\Adminuser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use validate;

class Adminusercontroller extends Controller
{
    public function index(Request $request)
    {
        // dd('call');
        $datas = Adminuser::where('role_id', 3)
                          ->where('Status', 1)
                          ->orderBy('id', 'desc')
                          ->paginate(5);

        return view('Adminuser.index', compact('datas'));
    }

    public function create(Request $request)
    {
        //  dd($request);

        $request->validate([
            'first_name'    => 'required',
            'phonenumber' => 'required|regex:/^\d{10}$/',
            'email'       => 'required|unique:users',
            'password'       => 'required',        
        ]);

        $Data = array(
            'first_name'     =>  $request->first_name,
            'mobile_number'  => $request->phonenumber,
            'email'          => $request->email,
            'password'       => Hash::make($request['password']),  
            'role_id'       =>3,
            'user_type'     =>'Admin User',
            'created_at'    => date('Y-m-d H:i:s'),
        );
        // dd($Data);
        DB::table('users')->insert($Data);
         return redirect()->route('Adminuser.index')->with('success', 'Admin User Created Successfully.');
     
    }

    public function editview(Request $request, $id)
    {
        $data = Adminuser::where(['id' => $id])->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
    
        // dd($request);
        $update = DB::table('users')
            ->where(['id' => $request->id])
            ->update([
            'first_name'     =>  $request->first_name,
            'mobile_number'  => $request->mobile_number,
            'email'          => $request->email,
            'role_id'       =>3,
            'user_type'     =>'Admin User',
             'updated_at' => date('Y-m-d H:i:s'),

            ]);

        return back()->with('success', 'Admin User Updated Successfully.');
    }

    public function delete(Request $request)
    {
        DB::table('users')->where(['id' => $request->id])->delete();

        return back()->with('success', 'Admin User Deleted Successfully!.');
    }

   // Permission code
   
   public function permissionindex(Request $request,$id)
   { 
        $user_id = $id;
        $permission = Adminuserpermission::where(['user_id' => $id])->first();
        // dd($permission);
       
       return view('Userpermission.index',compact('user_id','permission'));
   }

   public function permissioncreate(Request $request)
   {

    DB::table('Adminuser_permission')
        ->where('user_id', $request->user_id)
        ->delete();
        
    $Data = array(
        'user_id'          =>  $request->user_id,
        'city'             => $request->city_permission,
        'city_group'       => $request->city_group_permission,
        'categories'       => $request->categories_permission,  
        'membershipplans'  => $request->membershipplans_permission,  
        'overteem'         => $request->overteem,  
        'Banner'           => $request->Banner,  
        'members'          => $request->members_permission, 
        'Products_service'   => $request->Products_service_permission,  
        'Renewalhistory'     => $request->Renewalhistory, 
        'Business'         => $request->Business,  
        'reports'          => $request->reports,  
        'Adminuser'        => $request->Adminuser,  
        'Blog'             => $request->Blog,  
        'gallery'          => $request->gallery,
        'videogallery'     => $request->videogallery,  
        'Event'            => $request->Event,  
        'created_at'         => date('Y-m-d H:i:s'),
    );
    // dd($Data);
    DB::table('Adminuser_permission')->insert($Data);
     return redirect()->route('Adminuser.index')->with('success', 'Admin User Permission Created Successfully.');
       
   }
}