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
use App\Models\Business;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use validate;

class ContectinquiryController extends Controller
{
    public function index(Request $request)
    {
    //    dd('call');
        $inquiry = DB::table('Inquiry')
        ->select('inquiry_id','name','mobileNumber', 'email','message','created_at')
        ->where(['iStatus' => 1, 'isDelete' => 0])
        ->paginate(env('PAR_PAGE_COUNT',20));
       $count =$inquiry->count();
 
        return view('Contactinquiry.index',compact('count','inquiry'));
        
    }

    public function delete(Request $request)
    {
        // dd($request);
        DB::table('Inquiry')->where(['iStatus' => 1, 'isDelete' => 0, 'inquiry_id' => $request->id])->delete();
        return redirect()->route('Contactinquiry.index')->with('success', 'Contect inquiry Deleted Successfully!.');
    }
}