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
use App\Models\Reference;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BusinessCreated;
use validate;
use Illuminate\Support\Str;
class Referencecontroller extends Controller
{
    public function index(Request $request)
    {

        $session =Auth::user();
        $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
            ->where('users.status', 1)
            ->where('users.role_id', 2)
            ->where('members.Arrival_flag', 0)
            ->orderBy('users.first_name')
            ->select('users.*')
            ->get();
        $Datadrop = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();

        $Business = Reference::join('users', 'users.id', '=', 'Reference.Reference_from')
        ->join('users as to_user', 'to_user.id', '=', 'Reference.Reference_to')
        ->where('Reference.Reference_from', $session->id)
        ->where(['iStatus' => 1, 'isDelete' => 0])
        ->orderBy('Reference.Reference_id', 'DESC')
        ->paginate(env('PAR_PAGE_COUNT',20));
   
        $Count = $Business->count();

        return view('Reference.index', compact('Business','Data','Datadrop','Count'));
        // return view('Reference.index');
    }
   

    public function storeview1()
    {
        $session =Auth::user();
         $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
            ->where('users.status', 1)
            ->where('users.role_id', 2)
            ->where('members.Arrival_flag', 0)
            ->orderBy('users.first_name')
            ->select('users.*')
            ->get();
        echo json_encode($Data);
    }
    public function create(Request $request)
    {
        // dd($request);
        $session =Auth::user();
        $ToUser = User::find($request->Reference_to);
        $ToUserName = $ToUser ? $ToUser->first_name : 'Unknown User';
       
        $request->validate([
            
            'Reference_to'     => 'required',
            // 'Email'     => 'required',
            'Reference_Name' => 'required',
            'phonenumber' => 'required',
            
        ]);

        $gu_id = Str::random(10);
        $Data = array(
            // 'business_type'   => $request->business_type,
            'Reference_from'   => $session->id,
            'Reference_to'     => $request->Reference_to,
            'Reference_Name'     => $request->Reference_Name,
            'Company_Name' => $request->Company_Name ?? '',
            'Reference_Date'  => date('Y-m-d H:i:s'),
            'gu_id'           => $gu_id, 
            'Email'        => $request->Email ?? '',
            'phonenumber'=> $request->phonenumber,
            'Refer_for_message'=> $request->Refer_for_message ?? '',
            'created_at'      => date('Y-m-d H:i:s'),
            'created_by'      => auth()->id(),
            "strIP" => $_SERVER['REMOTE_ADDR']

        );
    //    dd($Data);
      
// dd($Data);
        $ReferenceId = DB::table('Reference')->insertGetId($Data);
    // dd($ReferenceId);
        $toUserEmail = $ToUser ? $ToUser->email : null;
        // dd($toUserEmail);
            $SendEmailDetails = DB::table('sendemaildetails')
            ->where(['id' => 4])
            ->first();
            $root = $_SERVER['DOCUMENT_ROOT'];
            $file = file_get_contents($root . '/evolve_business/mailers/Referencestatusemail.html', 'r');

            // $file = str_replace('#name', $data['name'], $file);
            // $file = str_replace('#email', $request['email'], $file);
           // $file = str_replace('#business_type', ($Data['business_type'] == 2) ? 'Reference' : 'Direct', $file);
            $file = str_replace('#Reference_from', $session['first_name'], $file);
            $file = str_replace('#Reference_to', $ToUserName, $file);
            $file = str_replace('#Company_Name', $Data['Company_Name'], $file);
            $file = str_replace('#Reference_Name', $Data['Reference_Name'], $file);
            $file = str_replace('#Email', $Data['Email'], $file);
            $file = str_replace('#phonenumber', $Data['phonenumber'], $file);
            $file = str_replace('#Reference_Date', $Data['Reference_Date'], $file);
            $file = str_replace('#Refer_for_message', $Data['Refer_for_message'], $file);


            $statusUpdateLink = url('https://evolv.co.in/evolve_business/Referencestatus/' . $gu_id); 
            $approveLink = url('https://evolv.co.in/evolve_business/Ref_approve/' . $gu_id);
            $rejectLink = url('https://evolv.co.in/evolve_business/Ref_reject/' . $gu_id);

            $file = str_replace('#status_update_link', $statusUpdateLink, $file);
            $file = str_replace('#approve_link', $approveLink, $file);
            $file = str_replace('#reject_link', $rejectLink, $file);

            $toMail = $ToUser ? $ToUser->email : null;
            $to = $toMail;
            $subject = "REFERENCE STATUS UPDATE";
            $message = $file;
            // dd($message);
            $header = "From:" . $SendEmailDetails->strFromMail . "\r\n";
            //$header .= "cc:afgh@somedomain.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            $retval = mail($to, $subject, $message, $header);

        return redirect()->route('Reference.index')->with('success', 'Reference Created Successfully.');
    }

    public function update(Request $request)
    {
        // dd($request);
        $session =Auth::user();
        $Business = DB::table('Business')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'business_id' => $request->business_id])
            ->update([
            'business_type'   => $request->business_type,
            'business_from'   => $session->first_name,
            'business_to'     => $request->business_to,
            'Business_amount' => $request->Business_amount,
            'business_Date'   => $request->business_Date,
            // 'business_from_id'=> $session->id,
            // 'business_to_id'=> $request->business_to,
            'updated_at'      => date('Y-m-d H:i:s'),
            'updated_by'      => auth()->id(),
            "strIP" => $_SERVER['REMOTE_ADDR']
            ]);
        //dd($Product);
        return redirect()->route('MemberBusiness.index')->with('success', 'Business Updated Successfully.');
    }

    public function editview(Request $request, $Id)
    {
        // dd($Id);
        $Business = Reference::where(['iStatus' => 1, 'isDelete' => 0, 'Reference_id' => $Id])->first();
        // dd($Business);
        echo json_encode($Business);
    }

    public function delete(Request $request)
    {
        // dd($request);
        DB::table('Reference')->where(['iStatus' => 1, 'isDelete' => 0, 'Reference_id' => $request->id])->delete();
        return redirect()->route('Reference.index')->with('success', 'Reference Deleted Successfully!.');
    }


    public function newstatus($gu_id)
    {
        // dd($gu_id);
        return view('MemberBusiness.newstatus', compact('gu_id'));
    }
    public function statusadd(Request $request)
    {
      
     
       DB::table('Business')->where('business_id', $request->id)->update([
            'isapproved_status' => $request->newStatus,
            'businesscomment'  => $request->businesscomment,
            'approved_by' =>Auth::user()->user_type,
            'approved_by_id' =>Auth::user()->id,

        ]);
        return redirect()->route('newstatus', $request->id)->with('success', 'Business Status updated successfully!');
        
    }

    public function approveReference(Request $request , $gu_id){
        $Data = DB::table('Reference')->where('gu_id', $gu_id)->update([
            'isapproved_status' => 1,
            // 'businesscomment'  => $request->businesscomment,
            // 'approved_by' =>Auth::user()->user_type,
            // 'approved_by_id' =>Auth::user()->id,
        ]);
        // dd($gu_id);

        return view('Referencestatus');
    }
    public function rejectReference(Request $request , $gu_id){
        // dd($gu_id);
        return view('Referencerejects',compact('gu_id'));
        
    }
    public function updatestatus(Request $request){
        
        // dd($request);
        $Data = DB::table('Reference')->where('gu_id', $request->id)->update([
            'isapproved_status' => 2,
            'Referencecomment'  => $request->Referencecomment,
            'approved_by' =>Auth::user()->user_type,
            'approved_by_id' =>Auth::user()->id,
        ]);
        // dd($Data);

        return view('Referencerejectedcom');
    }   
    
     // login member user pending list code 

     public function indexpending(Request $request)
     {
        $Data = User::where('status', 1)->get(); 
        $Datadrop = User::where('status', 1)->get(); 
        $session = Auth::user();
        $Business = Business::join('users', 'users.id', '=', 'Business.business_to_id')
                ->where('users.id', $session->id)
                ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 0])
                ->orderBy('Business.business_id', 'DESC')
                ->paginate(env('PAR_PAGE_COUNT',20));
        //  dd($Business);
         return view('pendinglogincheck.index', compact('Business','Data','Datadrop'));
     }

     public function statuspendinglogin(Request $request)
     {
        //  dd($request);
         DB::table('Business')->where('business_id', $request->id)->update([
            'isapproved_status' => $request->newStatus,
            'businesscomment'  => $request->businesscomment,
            'approved_by' =>Auth::user()->user_type,
            'approved_by_id' =>Auth::user()->id,
            'Business_received_date'=>date('Y-m-d H:i:s'),

        ]);
         return redirect()->back();
     }

     public function Received1(Request $request)
     {
        //  dd('czcxzcxzcall');
         $Data = User::where('status', 1)->get(); 
         $Datadrop = User::where('status', 1)->get(); 

         $session = Auth::user();

         $Business = Reference::join('users', 'users.id', '=', 'Reference.Reference_to')
         ->join('users as to_user', 'to_user.id', '=', 'Reference.Reference_from')
            ->where('Reference_to', $session->id)
            ->where([
                'iStatus' => 1,
                'isDelete' => 0
            ])
            ->whereIn('isapproved_status', [1])
            ->orderBy('Reference.Reference_id', 'DESC')
            ->paginate(env('PAR_PAGE_COUNT',20));
           
            $Count = $Business->count();
            // dd($Business);
       return view('Reference.ReceivedReference',compact('Business','Data','Datadrop','Count'));

        //  dd($Business);
     }
     public function reference_approve_(Request $request ,$gu_id=null)
     {
        
         $Data = DB::table('Reference')->where('gu_id', $gu_id)->update([
            'isapproved_status' => 1,
        ]);
        return view('newstatus');
         
     }
    public function reference_reject(Request $request ,$gu_id=null)
    {
        return view('reference_rejected',compact('gu_id'));
       
    }
    public function ref_updatestatus(Request $request){
       try {
        $Data = DB::table('Reference')->where('gu_id', $request->id)->update([
            'isapproved_status' => 2,
            'reject_comment'  => $request->businesscomment,
            'approved_by' =>Auth::user()->user_type ?? 'Admin',
            'approved_by_id' =>Auth::user()->id ?? '1',
        ]);
       
        return view('rejectedcom');
       } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }  
}
