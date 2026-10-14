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
use Illuminate\Support\Facades\Mail;
use validate;


class MemberrequestController extends Controller
{
    public function index(Request $request)
    {
       // only book persion get not all member 
        $datas = members::select('members.id as memberid','users.status','users.id','users.first_name','members.companyname','members.phonenumber','members.email','members.address','members.pincode','members.gstnumber','members.Book_Your_Podcast','members.Book_Your_Member_of_the_week')->orderBy('members.Book_Your_Podcast', 'desc')
        ->join('users','users.id','members.user_id') 
        ->where(['members.iStatus' => 1, 'members.isDelete' => 0])
        ->whereNotNull('members.Book_Your_Podcast')
        // ->whereNotNull('members.Book_Your_Member_of_the_week')
        ->paginate(env('PAR_PAGE_COUNT',20));
        $Count = $datas->count();
      
        // dd($datas);
        return view('Memberrequest.index', compact('datas','Count'));
    }
    public function statusget(Request $request,$id)
    {
        $data = members::findOrFail($id);
        // dd($data);
       echo json_encode($data);
        
    }
    public function addstatus(Request $request)
    {
      
        $member = members::findOrFail($request->id);
        $Emailsenddate = date('d-m-Y', strtotime($request->member_podcast_date));
       
        DB::table('members')->where('id', $request->id)->update([
            'Book_Your_Podcast' => $request->member_podcast_date,
            
        ]);
        
        $sendemaildetails = DB::table('sendemaildetails')->where('id', 10)->first();
        
        $msg = [
            'FromMail' => $sendemaildetails->strFromMail ??  'info@getdemo.in',
            'Title' => $sendemaildetails->strTitle ??  'Evolve Business Community',
            'ToEmail' =>$member->email ?? '',
            'Subject' => $sendemaildetails->strSubject ?? 'Book Your Podcast status' ?? '',
        ];
        
        $data = [
            'Book_Your_Podcast' => $Emailsenddate ?? '',
        ];
       
        $mail = Mail::send('emails.BookYourPodcaststatus', ['data' => $data], function ($message) use ($msg) {
            $message->from($msg['FromMail'], $msg['Title']);
            $message->to($msg['ToEmail'])->subject($msg['Subject']);
        });
        
        
       return back();
        
    }
    public function Memberweekindex(Request $request)
    {
      
       // only book persion get not all member 
        $datas = members::select('members.id as memberid','users.status','users.id','users.first_name','members.companyname','members.phonenumber','members.email','members.address','members.pincode','members.gstnumber','members.Book_Your_Podcast','members.Book_Your_Member_of_the_week','members.Member_of_the_week_enddate','members.Book_week_time')
        ->orderBy('members.id', 'desc')
        ->join('users','users.id','members.user_id') 
        ->where(['members.iStatus' => 1, 'members.isDelete' => 0])
        // ->whereNotNull('members.Book_Your_Podcast')
        ->whereNotNull('members.Book_Your_Member_of_the_week')
        ->paginate(env('PAR_PAGE_COUNT',20));
      
        $Count =$datas->count();
      
        // dd($datas);
        return view('Memberrequest.Memberweek', compact('datas','Count'));
    }

    public function statusget1(Request $request,$id)
    {
        $data = members::findOrFail($id);
        // dd($data);
       echo json_encode($data);
        
    }
    public function addstatus1(Request $request)
    {
        

        $member = members::findOrFail($request->id);
        $Emailsenddate = date('d-m-Y', strtotime($request->Book_Your_Member_of_the_week));

        $startDate = new \DateTime($request->Book_Your_Member_of_the_week);
        $endDate = clone $startDate; 
        $endDate->modify('+6 days');
        $endDateFormatted = $endDate->format('Y-m-d');
        $weekend = date('d-m-Y', strtotime($endDateFormatted));
    
         DB::table('members')->where('id', $request->id)->update([
            'Book_Your_Member_of_the_week' => $request->Book_Your_Member_of_the_week,
            'Member_of_the_week_enddate' => $endDateFormatted,
        ]);
        
        $sendemaildetails = DB::table('sendemaildetails')->where('id', 11)->first();

        $msg = [
            'FromMail' => $sendemaildetails->strFromMail ??  'info@getdemo.in',
            'Title' => $sendemaildetails->strTitle ??  'Evolve Business Community',
            'ToEmail' =>  $member->email ?? '',
            'Subject' => $sendemaildetails->strSubject ?? 'Book Your Member of the week' ?? '',
        ];

        $data = [
            'Book_Your_Member_of_the_week' => $Emailsenddate ?? '',
            'Member_of_the_week_end' => $weekend ?? '',
        ];

        $mail = Mail::send('emails.BookYourMemberoftheweek', ['data' => $data], function ($message) use ($msg) {
            $message->from($msg['FromMail'], $msg['Title']);
            $message->to($msg['ToEmail'])->subject($msg['Subject']);
        }); 

       
       return back();
        
        
    }
    public function delete(Request $request)
    {
        try {    
                DB::table('members')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
                ->update([
                    'Book_Your_Podcast' =>null,            
                ]);
                return back()->with('success', 'Book your podcast Deleted Successfully!.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }
    public function delete_week(Request $request)
    {
        
        try {    
                DB::table('members')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
                ->update([
                    'Book_Your_Member_of_the_week' =>null, 
                    'Member_of_the_week_enddate' =>null,

                ]);
                return back()->with('success', 'Member of the week Deleted Successfully!.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
            
    }

}