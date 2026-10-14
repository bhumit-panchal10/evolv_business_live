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
use validate;

class AdminReferencecontroller extends Controller
{
    public function index(Request $request)
    {
        // dd('call');
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        // $Data = User::where('status', 1)->get(); 
        // $Datadrop = User::where('status', 1)->get(); 
        $Data = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
        $Datadrop = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
        $Business = Reference::select('Reference.*', 
        DB::raw('(select users.first_name from users where users.id = Reference.Reference_from order by users.id desc limit 1) as Reference_from'),
        DB::raw('(select users.first_name from users where users.id = Reference.Reference_to order by users.id desc limit 1) as Reference_to'),
        )
        ->orderBy('Reference_id', 'DESC')
        ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 0])
        ->when($request->fromdate, fn ($query, $FromDate) => $query
        ->where('Reference.Reference_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
        ->when($request->todate, fn ($query, $ToDate) => $query
        ->where('Reference.Reference_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
        ->join('users', 'Reference.Reference_from', '=', 'users.id')
        ->paginate(env('PAR_PAGE_COUNT',20));
        $Count=$Business->count();
        // ->toSql();
        // dd($Business);
        return view('Admin-Reference.index', compact('Business','Data','Datadrop','FromDate','ToDate','Count'));
    }
    public function exportToexcel_list(Request $request,$fromdate = null,$todate = null)
    {
        // dd($fromdate);
        $FromDate = $fromdate;
        $ToDate = $todate;
    
        $datas = Reference::select(
        'Reference.*',DB::raw('(select users.first_name from users where users.id = Reference.Reference_from order by users.id desc limit 1) as Reference_from'),
        DB::raw('(select users.first_name from users where users.id = Reference.Reference_to order by users.id desc limit 1) as Reference_to'),
        )
        ->where(['Reference.iStatus' => 1, 'Reference.isDelete' => 0 ,'isapproved_status' => 0])
        ->when($fromdate, fn ($query, $FromDate) => $query
        ->where('Reference.Reference_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
        ->when($todate, fn ($query, $ToDate) => $query
        ->where('Reference.Reference_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
        ->get();
    //    ->paginate(20);
        //->toSql();
    //  dd($datas);
        return view('Admin-Reference.exportlist', compact('datas','FromDate','ToDate'));
    }


    public function status(Request $request)
    {
        // dd($request);
        DB::table('Reference')->where('Reference_id', $request->id)->update([
            'isapproved_status' => $request->newStatus,
            'Referencecomment'  => $request->businesscomment,
            'approved_by' =>Auth::user()->user_type,
            'approved_by_id' =>Auth::user()->id,

        ]);
        return back()->with('success', 'Your status update Successfully.');
        
    }


    public function storeview(Request $request)
    {
         $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
            ->where('users.status', 1)
            ->where('users.role_id', 2)
            ->where('members.Arrival_flag', 0)
            ->orderBy('users.first_name')
            ->select('users.*')
            ->get();
        return view('Admin-Reference.storeview',compact('Data'));
    }
    public function create(Request $request)
    {
        $fromUser = User::find($request->business_from);
        $fromUserName = $fromUser ? $fromUser->first_name : 'Unknown User';
        $ToUser = User::find($request->business_to);
        $ToUserName = $ToUser ? $ToUser->first_name : 'Unknown User';
        $request->validate([
            // 'business_type'   => 'required',
            'Reference_from'   => 'required',
            'Reference_to'     => 'required',
            'Reference_Name' => 'required',
            // 'Company_Name'   => 'required',
            'phonenumber'   => 'required',
            // 'Email'   => 'required',
        ]);
        $Data = array(
            // 'business_type'   => $request->business_type,
            'Reference_from'   => $request->Reference_from,
            'Reference_to'     => $request->Reference_to,
            'Reference_Name'   => $request->Reference_Name,
            'Company_Name'     => $request->Company_Name ?? '',
            'phonenumber'      => $request->phonenumber,
            'Email'            => $request->Email ?? '',
            'Refer_for_message'=> $request->Refer_for_message ?? '',
            'Reference_Date'   => date('Y-m-d H:i:s'),
            'created_at'       => date('Y-m-d H:i:s'),
            'created_by'       => auth()->id(),
            "strIP"            => $_SERVER['REMOTE_ADDR']
        );
        // dd($Data);
        DB::table('Reference')->insert($Data);

        return redirect()->route('Admin-Reference.index')->with('success', 'Reference Created Successfully.');
    }

    public function update(Request $request)
    { 
    // dd($request);
        $Business = DB::table('Reference')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'Reference_id' => $request->Reference_id])
            ->update([
         
            'Reference_from'   => $request->Reference_from,
            'Reference_to'     => $request->Reference_to,
            'Reference_Name' => $request->Reference_Name,
            'Company_Name'     => $request->Company_Name ?? '',
            'phonenumber'      => $request->phonenumber,
            'Email'            => $request->Email ?? '',
            'Refer_for_message'=> $request->Refer_for_message ?? '',
            'Reference_Date'   => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'updated_by'      => auth()->id(),
            "strIP" => $_SERVER['REMOTE_ADDR']
            ]);
        // dd($Business);
        return back()->with('success', 'Reference Updated Successfully.');
        
    }

    public function editview(Request $request, $Id)
    {
        $Business = Reference::where(['iStatus' => 1, 'isDelete' => 0, 'Reference_id' => $Id])->first();
        // dd($Business);
        echo json_encode($Business);
    }
    // reference pending list delete
    public function delete(Request $request)
    {
        // dd($request);
        DB::table('Reference')->where(['iStatus' => 1, 'isDelete' => 0, 'Reference_id' => $request->id])->delete();
        return redirect()->route('Admin-Reference.index')->with('success', 'Reference Deleted Successfully!.');
    }
    // reference Approve list delete
    public function deleteapprove(Request $request)
    {
        // dd($request);
        DB::table('Reference')->where(['iStatus' => 1, 'isDelete' => 0, 'Reference_id' => $request->id])->delete();
        return redirect()->route('Admin-Reference.Approve_list')->with('success', 'Reference Deleted Successfully!.');
    }
    // reference rejected list delete
    public function deleterejected(Request $request)
    {
        DB::table('Reference')->where(['iStatus' => 1, 'isDelete' => 0, 'Reference_id' => $request->id])->delete();
        return redirect()->route('Admin-Reference.Rejected_list')->with('success', 'Reference Deleted Successfully!.');
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
      
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        // $Data = User::where('status', 1)->get(); 
        // $Datadrop = User::where('status', 1)->get(); 
        $Data = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
        $Datadrop = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
        $Business = Reference::select('Reference.*', 
        DB::raw('(select users.first_name from users where users.id = Reference.Reference_from order by users.id desc limit 1) as Reference_from'),
        DB::raw('(select users.first_name from users where users.id = Reference.Reference_to order by users.id desc limit 1) as Reference_to'),
        )
        ->orderBy('Reference_id', 'DESC')
        ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 1])
        ->when($request->fromdate, fn ($query, $FromDate) => $query
        ->where('Reference.Reference_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
        ->when($request->todate, fn ($query, $ToDate) => $query
        ->where('Reference.Reference_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
        ->join('users', 'Reference.Reference_from', '=', 'users.id')
        ->paginate(env('PAR_PAGE_COUNT',20));
        $Count=$Business->count();
        // ->toSql();
        // dd($Business);
        return view('Admin-Reference.Approve_list', compact('Business','Data','Datadrop','FromDate','ToDate','Count'));
       
    }

    public function exportapprove(Request $request,$fromdate = null,$todate = null)
    {
    
        $FromDate = $fromdate;
        $ToDate = $todate;
        $datas = Reference::select(
        'Reference.*',DB::raw('(select users.first_name from users where users.id = Reference.Reference_from order by users.id desc limit 1) as Reference_from'),
        DB::raw('(select users.first_name from users where users.id = Reference.Reference_to order by users.id desc limit 1) as Reference_to'),
        )
        ->where(['Reference.iStatus' => 1, 'Reference.isDelete' => 0 ,'isapproved_status' => 1])
        ->when($fromdate, fn ($query, $FromDate) => $query
        ->where('Reference.Reference_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
        ->when($todate, fn ($query, $ToDate) => $query
        ->where('Reference.Reference_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
        ->get();
    //    ->paginate(20);
        //->toSql();
    //  dd($datas);
        return view('Admin-Reference.exportapprove_list', compact('datas','FromDate','ToDate'));
    }


    public function rejected(Request $request)
    {
          $FromDate = $request->fromdate;
          $ToDate = $request->todate;
          $Data = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
          $Datadrop = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
          $Business = Reference::select('Reference.*', 
          DB::raw('(select users.first_name from users where users.id = Reference.Reference_from order by users.id desc limit 1) as Reference_from'),
          DB::raw('(select users.first_name from users where users.id = Reference.Reference_to order by users.id desc limit 1) as Reference_to'),
          )
          ->orderBy('Reference_id', 'DESC')
          ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 2])
          ->when($request->fromdate, fn ($query, $FromDate) => $query
          ->where('Reference.Reference_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
          ->when($request->todate, fn ($query, $ToDate) => $query
          ->where('Reference.Reference_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
          ->join('users', 'Reference.Reference_from', '=', 'users.id')
          ->paginate(env('PAR_PAGE_COUNT',20));
          $Count=$Business->count();
          // ->toSql();
        //   dd($Business);
          return view('Admin-Reference.Rejected_list', compact('Business','Data','Datadrop','FromDate','ToDate','Count'));
        
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
        // dd($request);
        $data = Reference::where(['iStatus' => 1, 'isDelete' => 0, 'Reference_id' => $request->id])->first();
        // dd($data);  
        echo json_encode($data);
    }
    
    public function resendReferenceReminder(Request $request)
    {
        
        $pendingReferences = DB::table('Reference')
            ->leftJoin('users', 'users.id', '=', 'Reference.Reference_to')
            ->leftJoin('members', 'members.user_id', '=', 'Reference.Reference_from')
            ->where(['Reference.iStatus' => 1, 'Reference.isDelete' => 0, 'Reference.isapproved_status' => 0])
            ->select(
                'Reference.*',
                'users.email as user_email',
                'users.first_name as user_name',
                'members.Contact_person as Reference_from_name'
            )
            ->get();
            
 
        foreach ($pendingReferences as $data) {
            try {
                $sendemaildetails = DB::table('sendemaildetails')->where('id', 12)->first();
 
                $msg = [
                    'FromMail' => $sendemaildetails->strFromMail ?? 'info@getdemo.in',
                    'Title' => $sendemaildetails->strTitle ?? 'Reference Reminder',
                    'ToEmail' =>$data->user_email,
                    'Subject' => $sendemaildetails->strSubject ?? 'Pending Reference Reminder',
                ];
 
                $mailData = [
                    'reference_name' => $data->Reference_Name ?? '',
                    'reference_from' => $data->Reference_from_name ?? '',
                    'reference_to' => $data->user_name ?? '',
                    'company_name' => $data->Company_Name ?? 'No Data',
                    'phonenumber' => $data->phonenumber ?? '',
                    'reference_date' => $data->Reference_Date ?? '',
                    'gu_id' => $data->gu_id ?? '',
                ];
                 //dd($mailData);
 
                $send = Mail::send('emails.reference_reminder', ['data' => $mailData], function ($message) use ($msg) {
                    $message->from($msg['FromMail'], $msg['Title']);
                    $message->to($msg['ToEmail'])->subject($msg['Subject']);
                });
              

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred while sending email: ' . $e->getMessage());
            }
        }
 
        return redirect()->back()->with('success', 'Reminder emails sent to all pending reference users.');
    }
    
}
