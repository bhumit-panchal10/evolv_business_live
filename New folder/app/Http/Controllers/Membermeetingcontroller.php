<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\City_group;
use App\Models\Member_metting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use validate;


class Membermeetingcontroller extends Controller
{
    public function index(Request $request)
    {
       
        // dd('call');
        $cities = City::select('id', 'city_name')->orderBy('city_name')->get();
        $cityGroups = City_group::select('id', 'group_name')->orderBy('group_name')->get();
        $datas =DB::table('Cluster_Meet')->orderBy(DB::raw('STR_TO_DATE(`start_date`,"%d.%m.%y %H:%i")'),'DESC')->paginate(env('PAR_PAGE_COUNT',20));
       //$datas =DB::table('Cluster_Meet')->paginate(env('PAR_PAGE_COUNT'));
        $Count =$datas->count();
        
        return view('Membermeeting.index', compact('Count','cityGroups','cities','datas'));
    }

    public function create(Request $request)
    {
        // dd($request);

        $Data = array(
            'city_id' => $request->city_id,
            'city_group_id'    => $request->citygroup_id,
            'Meeting_title'    => $request->Meetingtitle,
            'start_date'    => $request->start_date,
            'End_date'    => $request->End_date,
            'created_at' => date('Y-m-d H:i:s'),      
        );
        DB::table('Cluster_Meet')->insert($Data);
        return back()->with('success', 'Cluster Meet Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
   
        $cities = City::select('id', 'city_name')->get();
        $cityGroups = City_group::select('id', 'group_name')->orderBy('group_name')->get();
        $data = DB::table('Cluster_Meet')->where('id',$id)->first();
// dd($data);
      echo json_encode($data);
    
    }
    

    public function update(Request $request)
    {
       
        // dd($request);

        $update = DB::table('Cluster_Meet')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
            ->update([
                'city_id' => $request->city_id,
                'city_group_id'    => $request->citygroup_id,
                'Meeting_title'    => $request->Meeting_title,
                'start_date'    => $request->start_date,
                'End_date'    => $request->End_date,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
          
        return back()->with('success', 'Cluster Meet Updated Successfully.');
    }


    public function delete(Request $request)
    {
        // dd($request);

        DB::table('Cluster_Meet')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();
        DB::table('Cluster_Meet_Member_meeting')->where(['iStatus' => 1, 'isDelete' => 0, 'meeting_id' => $request->id])->delete();

        return back()->with('success', 'Cluster Meet Deleted Successfully!.');
    }


    public function Memberindex(Request $request,$id)
    {
       
        $meetingdata = Member_metting::select("member_id")->where(['meeting_id' => $id])->get();
    //    dd($permission);
        $data =DB::table('Cluster_Meet')->where('id',$id)->first();
        $meetingid = $id;
        $members = DB::table('Cluster_Meet as cm')
            ->select('m.id as member_id','m.Contact_person')
            ->join('members as m', function ($join) {
                $join->on('cm.city_id', '=', 'm.city_id')
                     ->on('cm.city_group_id', '=', 'm.citygroup_id');
            })
            ->where('cm.isDelete', 0)
            ->where('m.isDelete', 0)
            ->where('cm.city_id', $data->city_id)
            ->where('cm.city_group_id', $data->city_group_id)
            ->orderBy('Contact_person','asc')
            ->distinct()
            ->get(); 
            return view('Membermeeting.Memberindex', compact('members','meetingid','meetingdata'));
        
       
    }
    public function memberstore(Request $request)
    {
       
        DB::table('Cluster_Meet_Member_meeting')
        ->where('meeting_id', $request->meetingid)
        ->delete();

        $meetingId = $request->input('meetingid');
        $memberIds = $request->input('members');
        foreach ($memberIds as $memberId) {
            Member_metting::create([
                'meeting_id' => $meetingId,
                'member_id' => $memberId,
            ]);
        }

        $cities = City::select('id', 'city_name')->orderBy('city_name')->get();
        $cityGroups = City_group::select('id', 'group_name')->orderBy('group_name')->get();
        $datas =DB::table('Cluster_Meet')->paginate(env('PAR_PAGE_COUNT',20));
        $Count =$datas->count();
 
        return redirect()->route('Membermeeting.index', compact('Count', 'cityGroups', 'cities', 'datas'))->with('success', 'Meeting Members added successfully!');

    }
     public function Membermeeting_comment(Request $request, $id = null)
    {
        try {
            $metting_id = $id ?? '';
            $datas = DB::table('Cluster_Meet_Member_meeting')
                ->select('Cluster_Meet_Member_meeting.id as Cluster_Meet_Member_meeting_id', 'Cluster_Meet_Member_meeting.member_id', 'Cluster_Meet_Member_meeting.meeting_id', 'members.Contact_person', 'Cluster_Meet.*')
                ->leftJoin('members', 'Cluster_Meet_Member_meeting.member_id', '=', 'members.id')
                ->leftJoin('Cluster_Meet', 'Cluster_Meet_Member_meeting.meeting_id', '=', 'Cluster_Meet.id')
                ->where('Cluster_Meet_Member_meeting.meeting_id', $id)
                ->paginate(env('PAR_PAGE_COUNT',20));

            $count = $datas->count();
            return view('Membermeeting.Membercomment', compact('datas', 'count', 'metting_id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function comments_store(Request $request)
    {
        try {
            $request->validate([
                'cluster_meet_member_meeting_id' => 'required|integer',
            ]);
            DB::table('Cluster_Meet_Member_meeting')
                ->where('id', $request->cluster_meet_member_meeting_id)
                ->update([
                    'comment' => $request->comment,
                ]);
            return back()->with('success', 'Comment added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function getAvailableMembers($meeting_id)
    {
        try {
            $existing = DB::table('Cluster_Meet_Member_meeting')
                ->where('meeting_id', $meeting_id)
                ->pluck('member_id');
            // Get members not already in this meeting
            $availableMembers = DB::table('members')
                ->whereNotIn('id', $existing)
                ->where('Arrival_flag', '!=', 1)
                ->where('iStatus', 1)
                ->select('members.id', 'members.Contact_person as name')
                ->get();
            return response()->json($availableMembers);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function Meeting_add_member(Request $request)
    {
        try {
            $request->validate([
                'meeting_id' => 'required|exists:Cluster_Meet_Member_meeting,meeting_id',
                'member_id' => 'required|exists:members,id',
            ]);

            DB::table('Cluster_Meet_Member_meeting')->insert([
                'meeting_id' => $request->meeting_id ?? '',
                'member_id' => $request->member_id ?? '',
                'created_at' => now(),
            ]);
            return redirect()->route('Membermeeting.Membercomment', ['id' => $request->meeting_id])
                ->with('success', 'Member added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
  

}
