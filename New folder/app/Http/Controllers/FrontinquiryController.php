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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use validate;


class FrontinquiryController extends Controller
{
    public function index(Request $request)
    {
       
        $inquiry = DB::table('Register_frontview')
        ->select('id','reg_name','reg_business_segment', 'reg_category','reg_businessFirm','reg_OfficeAddress','reg_Other_Address','reg_designation','reg_Inceptionyear','reg_annual_turnover','business_documents_brand','industry','industry_subcategory','representative_name','chapter','payment_mode','documents','Status','business_establishment_year')
        ->where(['iStatus' => 1, 'isDelete' => 0,'Status' => 0])
        ->paginate(env('PAR_PAGE_COUNT',20));
         $Count =$inquiry->count(); 
       

        return view('inquiry.index',compact('inquiry','Count'));
        
    }
    public function edit(Request $request,$Id)
    {

        // $data = DB::table('Register_frontview')
        // ->select('id','reg_name','reg_business_segment', 'reg_category','reg_businessFirm','reg_OfficeAddress','reg_Other_Address','reg_designation','reg_Inceptionyear','reg_annual_turnover','business_documents_brand','industry','industry_subcategory','representative_name','chapter','payment_mode','documents','Status')
        // ->where(['iStatus' => 1, 'isDelete' => 0,'id' => $Id])
        // ->first();

        $data = DB::table('Register_frontview')
        ->select('Register_frontview.id','reg_name','reg_business_segment', 'reg_category','reg_businessFirm','reg_OfficeAddress','reg_Other_Address','reg_designation','reg_Inceptionyear','reg_annual_turnover','business_documents_brand','industry','industry_subcategory','representative_name','chapter','payment_mode','documents','Status','email','phonenumber','categories.id as categories_id','categories.name')
        ->join('categories', 'Register_frontview.industry', '=', 'categories.id')
        ->where(['Register_frontview.iStatus' => 1, 'Register_frontview.isDelete' => 0,'Register_frontview.id' => $Id])
        ->first();


        // dd($data);
        echo json_encode($data);   
    
    }
    public function statuspending(Request $request)
    {
       
        $Data = DB::table('Register_frontview')->where('id', $request->Editpending_id)->update([
            'Status' => $request->newStatus,  
        ]);   
        return back();
    
    }
    public function delete(Request $request)
    {
        // dd($request);
        DB::table('Register_frontview')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();
        return redirect()->route('inquiry.index')->with('success', 'Register Member Deleted Successfully!.');
    }
  
}