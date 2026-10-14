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
use Illuminate\Support\Facades\Mail;
use App\Mail\BusinessStatusMail;
use Illuminate\Support\Str;

class Businesscontroller extends Controller
{
    public function index(Request $request)
    {
        // dd('call');
        // dd($request);
        $givenby=$request->given_by;
        $businesstype =$request->business_type;
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $businesses = DB::table('members')
        ->where('iStatus', 1)
        ->where('isDelete', 0)
        ->orderBy('Contact_person', 'asc')
        ->get();
        // dd($businesses);
        $Data = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
        $Datadrop = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
        $Business = Business::orderBy('business_id', 'DESC')
        ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 0])
        ->when($request->fromdate, fn ($query, $FromDate) => $query
        ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
        ->when($request->todate, fn ($query, $ToDate) => $query
        ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
        ->when($request->business_type, function ($query) use ($businesstype) {
            $query->where('Business.business_type', 'LIKE', '%' . $businesstype . '%');
        })
        ->when($request->given_by, function ($query) use ($givenby) {
            $query->where('Business.business_from_id', 'LIKE', '%' . $givenby . '%');
        })
        ->paginate(env('PAR_PAGE_COUNT',20));
        $Count =$Business->count();

        // dd($Count);
        return view('Business.index', compact('Business','Data','Datadrop','FromDate','ToDate','Count','businesstype','givenby','businesses'));
    }
    public function exportToexcel_list(Request $request,$fromdate = null,$todate = null)
    {
        // dd($fromdate);
        $FromDate = $fromdate;
        $ToDate = $todate;
    
        $datas = Business::select(
        'Business.*')
        ->where(['Business.iStatus' => 1, 'Business.isDelete' => 0 ,'isapproved_status' => 0])
        ->when($fromdate, fn ($query, $FromDate) => $query
        ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
        ->when($todate, fn ($query, $ToDate) => $query
        ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
        ->get();
 
        return view('Business.exportlist', compact('datas','FromDate','ToDate'));
    }
    public function status(Request $request)
    {
        // dd($request);

        DB::table('Business')->where('business_id', $request->id)->update([
            'isapproved_status' => $request->newStatus,
            'businesscomment'  => $request->businesscomment,
            'approved_by' =>Auth::user()->user_type,
            'approved_by_id' =>Auth::user()->id,

        ]);
        return redirect()->back();
    }


    public function storeview()
    {
        $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
            ->where('users.status', 1)
            ->where('users.role_id', 2)
            ->where('members.Arrival_flag', 0)
            ->orderBy('users.first_name')
            ->select('users.*')
            ->get();
        return view('Business.storeview',compact('Data'));
    }
    public function create(Request $request)
    {
        // dd($request);
        $fromUser = User::find($request->business_from);
        $fromUserName = $fromUser ? $fromUser->first_name : 'Unknown User';
        $ToUser = User::find($request->business_to);
        $ToUserName = $ToUser ? $ToUser->first_name : 'Unknown User';
        $gu_id = Str::random(10);
        $request->validate([
            'business_type'   => 'required',
            'business_from'   => 'required',
            'business_to'     => 'required',
            'Business_amount' => 'required|numeric',
            'business_Date'   => 'required|date',
        ]);
        $Data = array(
            'business_type'   => $request->business_type,
            'business_from'   => $fromUserName,
            'business_to'     => $ToUserName,
            'Business_amount' => $request->Business_amount,
            'business_Date'   => $request->business_Date,
            'business_from_id'=> $request->business_from,
            'business_to_id'=> $request->business_to,
            'created_at'      => date('Y-m-d H:i:s'),
            'gu_id'           => $gu_id,
            'created_by'      => auth()->id(),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
       
        DB::table('Business')->insert($Data);

        return redirect()->route('Business.index')->with('success', 'Business Created Successfully.');
    }

    public function update(Request $request)
    {
        
    
        $Business = DB::table('Business')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'business_id' => $request->business_id])
            ->update([
            'business_type'   => $request->business_type,
            'business_from'   => $request->business_from,
            'business_to'     => $request->business_to,
            'Business_amount' => $request->Business_amount,
            'business_Date'   => $request->business_Date,
            // 'business_from_id'=> $request->business_from,
            // 'business_to_id'=> $request->business_to,
            'updated_at'      => date('Y-m-d H:i:s'),
            'updated_by'      => auth()->id(),
            "strIP" => $_SERVER['REMOTE_ADDR']
            ]);
        //dd($Product);
        return redirect()->route('Business.index')->with('success', 'Business Updated Successfully.');
    }

    public function editview(Request $request, $Id)
    {
        // dd($Id);
        $Business = Business::where(['iStatus' => 1, 'isDelete' => 0, 'business_id' => $Id])->first();
        echo json_encode($Business);
    }

    public function delete(Request $request)
    {
        // dd($request);
        DB::table('Business')->where(['iStatus' => 1, 'isDelete' => 0, 'business_id' => $request->id])->delete();
        return redirect()->route('Business.index')->with('success', 'Business Deleted Successfully!.');
    }

    public function deleteapprove(Request $request)
    {
        // dd($request);
        DB::table('Business')->where(['iStatus' => 1, 'isDelete' => 0, 'business_id' => $request->id])->delete();
        return redirect()->route('Business.approve_list')->with('success', 'Business Deleted Successfully!.');
    }

    public function deleterejected(Request $request)
    {
        // dd($request);
        DB::table('Business')->where(['iStatus' => 1, 'isDelete' => 0, 'business_id' => $request->id])->delete();
        return redirect()->route('Business.rejected_list')->with('success', 'Business Deleted Successfully!.');
    }

    public function search(Request $request)
    {
        $input = $request->input('input');
        $suggestions = User::where('first_name', 'like', '%' . $input . '%')->get();
        // echo json_encode($suggestions);
        // return view('partials.suggestions', ['suggestions' => $suggestions]);
        return response()->json($suggestions);
    }

    public function approvelist(Request $request)
    {
    //    dd($request);
        $givenby=$request->given_by;
        $businesstype =$request->business_type;
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;

        // $businesses = DB::table('Business')
        // ->where('iStatus', 1)
        // ->where('isDelete', 0)
        // ->where('isapproved_status', 1)
        // ->groupBy('business_from')
        // ->get();
        $businesses = DB::table('members')
        ->where('iStatus', 1)
        ->where('isDelete', 0)
        ->orderBy('Contact_person', 'asc')
        ->get();

        $Data = User::where('status', 1)->get(); 
        $Datadrop = User::where('status', 1)->get(); 
        $Business = Business::orderBy('business_id', 'DESC')
        ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 1])
        ->when($request->fromdate, fn ($query, $FromDate) => $query
        ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
        ->when($request->todate, fn ($query, $ToDate) => $query
        ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
        ->when($request->business_type, function ($query) use ($businesstype) {
            $query->where('Business.business_type', 'LIKE', '%' . $businesstype . '%');
        })
        ->when($request->given_by, function ($query) use ($givenby) {
            $query->where('Business.business_from_id', 'LIKE', '%' . $givenby . '%');
        })
        ->paginate(env('PAR_PAGE_COUNT',20));
        $Count =$Business->count();
        // ->toSql();
        // dd($Business);
        return view('Business.approve_list', compact('Business','Data','Datadrop','FromDate','ToDate','businesstype','givenby','Count','businesses'));
       
    }

    public function exportapprove(Request $request,$fromdate = null,$todate = null)
    {
        // dd($request);
        $FromDate = $fromdate;
        $ToDate = $todate;
    
        $datas = Business::select(
        'Business.*')
        ->where(['Business.iStatus' => 1, 'Business.isDelete' => 0 ,'isapproved_status' => 1])
        ->when($fromdate, fn ($query, $FromDate) => $query
        ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
        ->when($todate, fn ($query, $ToDate) => $query
        ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
        ->get();
    
     
        return view('Business.exportapprove_list', compact('datas','FromDate','ToDate'));
    }


    public function rejected(Request $request)
    {

        $givenby=$request->given_by;
        $businesstype =$request->business_type;
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;

        // $businesses = DB::table('Business')
        // ->where('iStatus', 1)
        // ->where('isDelete', 0)
        // ->where('isapproved_status', 2)
        // ->groupBy('business_from')
        // ->get();
        $businesses = DB::table('members')
        ->where('iStatus', 1)
        ->where('isDelete', 0)
        ->orderBy('Contact_person', 'asc')
        ->get();

        $Data = User::where('status', 1)->get(); 
        $Datadrop = User::where('status', 1)->get(); 
        $Business = Business::orderBy('business_id', 'DESC')
        ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 2])
        ->when($request->fromdate, fn ($query, $FromDate) => $query
        ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
        ->when($request->todate, fn ($query, $ToDate) => $query
        ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
        ->when($request->business_type, function ($query) use ($businesstype) {
            $query->where('Business.business_type', 'LIKE', '%' . $businesstype . '%');
        })
        ->when($request->given_by, function ($query) use ($givenby) {
            $query->where('Business.business_from_id', 'LIKE', '%' . $givenby . '%');
        })
        ->paginate(env('PAR_PAGE_COUNT',20));
        $Count =$Business->count();

        return view('Business.rejected_list', compact('Business','Data','Datadrop','FromDate','ToDate','businesstype','givenby','businesses','Count'));
        
    }

    public function exportrejected(Request $request,$fromdate = null,$todate = null)
    {
        // dd($fromdate);
        $FromDate = $fromdate;
        $ToDate = $todate;
    
        $datas = Business::select(
        'Business.*')
        ->where(['Business.iStatus' => 1, 'Business.isDelete' => 0 ,'isapproved_status' => 2])
        ->when($fromdate, fn ($query, $FromDate) => $query
        ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
        ->when($todate, fn ($query, $ToDate) => $query
        ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
        ->get();
    //    ->paginate(20);
        //->toSql();
    //  dd($datas);
        return view('Business.exportrejected_list', compact('datas','FromDate','ToDate'));
    }

    public function statusget(Request $request)
    {
        $data = Business::where(['iStatus' => 1, 'isDelete' => 0, 'business_id' => $request->id])->first();
        // dd($Business);  
        echo json_encode($data);
    }
      public function Business_resend_Reminder(Request $request)
    {
        $pendingBusinesses = DB::table('Business')
            ->leftjoin('members', 'members.user_id', '=', 'Business.business_to_id')
            ->where(['Business.iStatus' => 1, 'Business.isDelete' => 0, 'Business.isapproved_status' => 0])
            ->select('Business.*', 'members.email as user_email', 'members.Contact_person as user_name')
            ->get();

        foreach ($pendingBusinesses as $datas) {
            
            try {
                
                $sendemaildetails = DB::table('sendemaildetails')->where('id', 1)->first();
               
                $msg = [
                        'FromMail' => $sendemaildetails->strFromMail ?? 'support@evolv.co.in',
                        'Title' => $sendemaildetails->strTitle ?? 'Business Send',
                        'ToEmail' => $datas->user_email,
                        'Subject' => $sendemaildetails->strSubject ?? 'Business Send',
                    ];
                $data = [
                    'business_type' => $datas->business_type == 2 ? 'Reference' : 'Direct',
                    'business_from' => $datas->business_from,
                    'business_to' => $datas->business_to,
                    'Business_amount' => $datas->Business_amount,
                    'business_Date' => $datas->business_Date,
                    'gu_id' => $datas->gu_id ?? '',
                ];
                $mail = Mail::send('emails.statusemail', ['data' => $data], function ($message) use ($msg) {
                    $message->from($msg['FromMail'], $msg['Title']);
                    $message->to($msg['ToEmail'])->subject($msg['Subject']);
                });
               
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Reminder emails sent to all pending users.');
    }
}
