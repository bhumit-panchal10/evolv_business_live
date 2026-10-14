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
use App\Models\OneToOne;
use App\Models\Member_metting;
use App\Models\Event;
use App\Models\Reference;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BusinessCreated;
use validate;
use Illuminate\Support\Str;
use App\Mail\BusinessStatusMail;
use Carbon\Carbon;
use App\Services\AuthkeyWhatsAppService;

class MemberBusinesscontroller extends Controller
{
    public function index(Request $request)
    {
        try {
            $businesstype = $request->business_type;
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $session = Auth::user()->id;
            $Data = User::where('status', 1)->orderBy('first_name')->get();
            $Datadrop = User::where('status', 1)->orderBy('first_name')->get();
            // $Business = Business::join('users', 'users.id', '=', 'Business.business_from_id')
            // ->where('users.id', $session)
            // ->where(['iStatus' => 1, 'isDelete' => 0])
            // ->orderBy('Business.business_id', 'DESC')
            $Businesses = Business::leftjoin('users', 'users.id', '=', 'Business.business_from_id')
                ->where('users.id', $session)
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))));
            if ($businesstype != "") {
                $Businesses->where('Business.isapproved_status', '=', $businesstype);
            }
            $Business = $Businesses->orderBy('Business.business_id', 'DESC')
                ->paginate(env('PAR_PAGE_COUNT', 20));
            $Count = $Business->count();
            return view('MemberBusiness.index', compact('Business', 'Data', 'Datadrop', 'Count', 'businesstype', 'FromDate', 'ToDate'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function exportToexcel_list(Request $request, $fromdate = null, $todate = null)
    {
        try {
            // $FromDate = $fromdate;
            // $ToDate = $todate;
            // $datas = Business::select(
            //     'Business.*',
            //      'members.*'
            // )
            // ->leftjoin('members', 'members.user_id', '=', 'Business.business_from_id')
            //  ->leftjoin('city_groups', 'members.citygroup_id', '=', 'city_groups.id')

            //     ->where('Business.iStatus', 1)
            //     ->where('Business.isDelete', 0)
            //     ->where('Business.isapproved_status', 0)
            //     ->when($fromdate, fn($query, $FromDate) => $query
            //         ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            //     ->when($todate, fn($query, $ToDate) => $query
            //         ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
            //     ->get();
            //    ->paginate(20);

            $FromDate = $fromdate;
            $ToDate = $todate;

            $datas = Business::select(
                'Business.*',
                'members.*',
                'city_groups.name as city_group_name'

            )
                ->leftJoin('members', 'members.user_id', '=', 'Business.business_from_id')
                ->leftJoin('city_groups', 'members.citygroup_id', '=', 'city_groups.id')
                ->where('Business.iStatus', 1)
                ->where('Business.isDelete', 0)
                ->where('Business.isapproved_status', 0)
                ->when($FromDate, function ($query) use ($FromDate) {
                    $query->where(
                        'Business.business_Date',
                        '>=',
                        date('Y-m-d 00:00:00', strtotime($FromDate))
                    );
                })
                ->when($ToDate, function ($query) use ($ToDate) {
                    $query->where(
                        'Business.business_Date',
                        '<=',
                        date('Y-m-d 23:59:59', strtotime($ToDate))
                    );
                })
                ->get();

            return view('Business.exportlist', compact('datas', 'FromDate', 'ToDate'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function storeview1()
    {

        try {
            $session = Auth::user();
            $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
                ->where('users.status', 1)
                ->where('users.role_id', 2)
                ->where('members.Arrival_flag', 0)
                ->orderBy('users.first_name')
                ->select('users.*')
                ->get();
            return view('MemberBusiness.storeview', compact('Data', 'session'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $session = Auth::user();
            $ToUser = User::find($request->business_to);
            $ToUserName = $ToUser ? $ToUser->first_name : 'Unknown User';
            $mobileNo = $ToUser->mobile_number ?? '';

            $request->validate([
                'business_type'   => 'required',
                // 'business_from'   => 'required',
                'business_to'     => 'required',
                'Business_amount' => 'required|numeric',
                'business_Date'   => 'required|date',
            ]);

            $gu_id = Str::random(10);

            $Data = array(
                'business_type'   => $request->business_type,
                'business_from'   => $session->first_name,
                'business_to'     => $ToUserName,
                'Business_amount' => $request->Business_amount,
                'business_Date'   => $request->business_Date,
                'gu_id'           => $gu_id,
                'business_from_id' => $session->id,
                'business_to_id' => $request->business_to,
                'created_at'      => date('Y-m-d H:i:s'),
                'created_by'      => auth()->id(),
                "strIP" => $_SERVER['REMOTE_ADDR']

            );

            $businessId = DB::table('Business')->insertGetId($Data);
            $toUserEmail = $ToUser ? $ToUser->email : null;
            $sendemaildetails = DB::table('sendemaildetails')->where('id', 2)->first();
            $msg = [
                'FromMail' => $sendemaildetails->strFromMail ??  'info@getdemo.in',
                'Title' => $sendemaildetails->strTitle ??  'business send',
                'ToEmail' => isset($ToUser) ? ($ToUser->email ?? '') : '',
                //'ToEmail' => 'ai.dev.laravel10@gmail.com',
                //'CCEmail' => 'k.krupa0101@gmail.com',
                'Subject' => $sendemaildetails->strSubject ?? 'Business send' ?? '',
            ];

            $data = [
                'business_type' => $request->business_type == 2 ? 'Reference' : 'Direct',
                'business_from' => $session->first_name ?? '',
                'business_to' => $ToUserName,
                'Business_amount' => $request->Business_amount ?? 0,
                'business_Date' => $request->business_Date,
                'gu_id' => $gu_id ?? '',
            ];

            $mail = Mail::send('emails.statusemail', ['data' => $data], function ($message) use ($msg) {
                $message->from($msg['FromMail'], $msg['Title']);
                $message->to($msg['ToEmail'])->subject($msg['Subject']);
                if (!empty($msg['CCEmail'])) {
                    $message->cc($msg['CCEmail']);
                }
            });
            $whatsappService = new AuthkeyWhatsAppService();
            $wid = "41861"; // template id
            $statusofMessage = $whatsappService->sendText($mobileNo, $wid);
            return response()->json(['success' => true, 'message' => 'Business Created Successfully.']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $session = Auth::user();
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

        return redirect()->route('MemberBusiness.index')->with('success', 'Business Updated Successfully.');
    }

    public function editview(Request $request, $Id)
    {

        $Business = Business::where(['iStatus' => 1, 'isDelete' => 0, 'business_id' => $Id])->first();
        echo json_encode($Business);
    }

    public function delete(Request $request)
    {

        DB::table('Business')->where(['iStatus' => 1, 'isDelete' => 0, 'business_id' => $request->id])->delete();
        return redirect()->route('MemberBusiness.index')->with('success', 'Business Deleted Successfully!.');
    }


    public function newstatus($gu_id)
    {

        return view('MemberBusiness.newstatus', compact('gu_id'));
    }
    public function statusadd(Request $request)
    {
        DB::table('Business')->where('business_id', $request->id)->update([
            'isapproved_status' => $request->newStatus,
            'businesscomment'  => $request->businesscomment,
            'approved_by' => Auth::user()->user_type,
            'approved_by_id' => Auth::user()->id,

        ]);
        return redirect()->route('newstatus', $request->id)->with('success', 'Business Status updated successfully!');
    }

    public function approveBusiness(Request $request, $gu_id)
    {

        $Data = DB::table('Business')->where('gu_id', $gu_id)->update([
            'isapproved_status' => 1,
            // 'businesscomment'  => $request->businesscomment,
            // 'approved_by' =>Auth::user()->user_type,
            // 'approved_by_id' =>Auth::user()->id,
        ]);
        return view('newstatus');
    }
    public function rejectBusiness(Request $request, $gu_id)
    {

        return view('rejectstatus', compact('gu_id'));
    }
    public function updatestatus(Request $request)
    {
        $d = DB::table('Business')->where('gu_id', $request->id)->first();

        $Data = DB::table('Business')->where('gu_id', $request->id)->update([
            'isapproved_status' => 2,
            'businesscomment'  => $request->businesscomment,
            'approved_by' => Auth::user()->user_type ?? 'User',
            'approved_by_id' => Auth::user()->id ?? $d->business_to_id,
        ]);


        return view('rejectedcom');
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
            ->paginate(env('PAR_PAGE_COUNT', 20));

        $Referral = Reference::join('users as reference_to_user', 'reference_to_user.id', '=', 'Reference.Reference_to')
            ->leftJoin('users as reference_from_user', 'reference_from_user.id', '=', 'Reference.Reference_from')
            ->where('reference_to_user.id', $session->id)
            ->where([
                'Reference.iStatus' => 1,
                'Reference.isDelete' => 0,
                'Reference.isapproved_status' => 0,
            ])
            ->select(
                'Reference.*',
                'reference_to_user.first_name as reference_to_name',
                'reference_from_user.first_name as reference_from_name'
            )
            ->orderBy('Reference.Reference_id', 'DESC')
            ->paginate(env('PAR_PAGE_COUNT', 20));
        $OneToOne = OneToOne::join('users', 'users.id', '=', 'one_to_one_detail.to_id')
            ->where('users.id', $session->id)
            ->select('one_to_one_detail.*')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 0])
            ->orderBy('one_to_one_detail.id', 'DESC')
            ->paginate(env('PAR_PAGE_COUNT', 20));

        $member = members::where('user_id', $session->id)->first();
        $Member_metting = Member_metting::join('Cluster_Meet', 'Cluster_Meet.id', '=', 'Cluster_Meet_Member_meeting.meeting_id')
            ->leftJoin('members as bs1', 'bs1.id', '=', 'Cluster_Meet_Member_meeting.brand_showcase_1')
            ->leftJoin('members as bs2', 'bs2.id', '=', 'Cluster_Meet_Member_meeting.brand_showcase_2')
            ->where(function ($q) use ($member) {
                $q->where('Cluster_Meet_Member_meeting.brand_showcase_1', '=', $member->id)
                    ->orWhere('Cluster_Meet_Member_meeting.brand_showcase_2', '=', $member->id);
            })
            ->where('Cluster_Meet_Member_meeting.member_id', $member->id)
            ->where('Cluster_Meet_Member_meeting.iStatus', 1)
            ->where('Cluster_Meet_Member_meeting.isDelete', 0)
            ->where('Cluster_Meet_Member_meeting.is_approve', 0)
            ->select(
                'Cluster_Meet_Member_meeting.*',
                DB::raw("
            CASE
                WHEN Cluster_Meet_Member_meeting.brand_showcase_1 = {$member->id}
                THEN bs1.Contact_person
                ELSE bs2.Contact_person
            END as member_name
        ")
            )
            ->orderByDesc('Cluster_Meet_Member_meeting.id')
            ->first();
        if ($member) {
            $pendingMeeting = DB::table('Cluster_Meet')
                ->select(
                    'Cluster_Meet.*',
                    'mm.is_approve_meeting',
                    'mm.id as member_meeting_id',
                    DB::raw('GROUP_CONCAT(mm.member_id) AS member_ids'),
                    DB::raw('COUNT(mm.member_id) AS member_count')
                )
                ->join('Cluster_Meet_Member_meeting AS mm', 'mm.meeting_id', '=', 'Cluster_Meet.id')
                ->where('Cluster_Meet.city_group_id', $member->citygroup_id)
                ->where('mm.is_approve_meeting', 0)
                ->where('mm.member_id', $member->id)
                // ->whereRaw("STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %H:%i') >= ?", [Carbon::today()->format('Y-m-d')])
                ->whereRaw("DATE(STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %H:%i')) >= CURDATE()")
                ->groupBy('Cluster_Meet.id')
                ->orderByRaw("STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %T') ASC")
                ->paginate(env('PAR_PAGE_COUNT', 20));
            //dd($pendingMeeting);
        }
        // $Events = Event::where([
        //     'iStatus' => 1,
        //     'isDelete' => 0,
        // ])
        //     ->whereNotIn('event_id', function ($query) {
        //         $query->select('event_id')
        //             ->from('event_members')
        //             ->where('member_id', Auth::id());
        //     })
        //     ->orderBy('event_id', 'DESC')
        //     ->paginate(env('PAR_PAGE_COUNT', 20));  

        $Memberid = $member->id;

        $Events = Event::where([
            'iStatus' => 1,
            'isDelete' => 0,
        ])
            ->whereJsonContains('assign_member_id', (string) $Memberid)
            ->whereHas('EventMembers', function ($q) use ($Memberid) {
                $q->where('member_id', $Memberid)
                    ->where('isapproved_status', 0);
            })
            ->orderByDesc('event_id')
            ->paginate(env('PAR_PAGE_COUNT', 20));

        $hasBrandShowcase = $Member_metting &&
            (
                $Member_metting->ppt_taken_1 > 0 ||
                $Member_metting->ppt_taken_2 > 0 ||
                $Member_metting->brand_showcase_1 > 0 ||
                $Member_metting->brand_showcase_2 > 0
            );
        return view('pendinglogincheck.index', compact('Referral', 'hasBrandShowcase', 'pendingMeeting', 'member', 'Member_metting', 'Events', 'Business', 'Data', 'Datadrop', 'OneToOne'));
    }

    // public function statuspendinglogin(Request $request)
    // {
    //     DB::table('Business')->where('business_id', $request->id)->update([
    //         'isapproved_status' => $request->newStatus,
    //         'businesscomment'  => $request->businesscomment,
    //         'approved_by' => Auth::user()->user_type,
    //         'approved_by_id' => Auth::user()->id,
    //         'Business_received_date' => date('Y-m-d H:i:s'),

    //     ]);
    //     $business = DB::table('Business')->where('business_id', $request->id)->first();
    //     $pointsId = null;

    //     if ($business->business_type == 1) {
    //         // Direct
    //         $pointsId = 4;
    //     } elseif ($business->business_type == 2) {
    //         // Reference
    //         $pointsId = 5;
    //     }

    //     if ($pointsId) {
    //         $pointsData = DB::table('points_master')
    //             ->where('id', $pointsId)
    //             ->first();

    //         if ($pointsData) {
    //             DB::table('member_points')->insert([
    //                 'business_id' => $business->business_id,
    //                 'member_id'  => Auth::id(),
    //                 'points_id'  => $pointsData->id,
    //                 'points'     => $pointsData->points,
    //                 'status'     => 0,
    //                 'created_at' => now(),
    //                 'updated_at' => now()
    //             ]);
    //         }
    //     }
    //     return redirect()->back();
    // }

    public function statuspendinglogin(Request $request)
    {
        DB::table('Business')->where('business_id', $request->id)->update([
            'isapproved_status' => $request->newStatus,
            'businesscomment'   => $request->businesscomment,
            'approved_by'       => Auth::user()->user_type,
            'approved_by_id'    => Auth::user()->id,
            'Business_received_date' => now(),
        ]);

        // Only add points if Approved
        if ($request->newStatus == 1) {

            $business = DB::table('Business')
                ->where('business_id', $request->id)
                ->first();

            $pointsId = null;

            if ($business->business_type == 1) {
                // Direct
                $pointsId = 4;
            } elseif ($business->business_type == 2) {
                // Reference
                $pointsId = 5;
            }

            if ($pointsId) {
                $pointsData = DB::table('points_master')
                    ->where('id', $pointsId)
                    ->first();

                if ($pointsData) {
                    DB::table('member_points')->insert([
                        'business_id' => $business->business_id,
                        'member_id'   => $business->business_from_id,
                        'points_id'   => $pointsData->id,
                        'points'      => $pointsData->points,
                        'status'      => 0,
                        'description'      => 'Business ' . ($business->business_type == 1 ? 'Direct' : 'Reference') . ' Approved',
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
            }
        }

        return redirect()->back();
    }

    public function onestatuspendinglogin(Request $request)
    {

        $onetoone = DB::table('one_to_one_detail')
            ->where('id', $request->id)
            ->first();

        if (!$onetoone) {
            return redirect()->back()->with('error', 'One to One record not found.');
        }

        DB::table('one_to_one_detail')
            ->where('id', $request->id)
            ->update([
                'isapproved_status' => $request->newStatus,
                'reject_comment'    => $request->businesscomment,
                'approved_by'       => Auth::user()->user_type,
                'approved_by_id'    => Auth::user()->id,
                'receive_date'      => now(),
            ]);

        // Give points only when approved
        if ($request->newStatus == 1) {

            // Meeting User Points - From Member
            DB::table('member_points')->insert([
                'member_id'   => $onetoone->from_id,
                'business_id' => $request->id,
                'points_id'   => 6,
                'points'      => 5,
                'status'      => $request->newStatus,
                'description' => 'One to One From Approved',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // Meeting User Points - To Member
            DB::table('member_points')->insert([
                'member_id'   => $onetoone->to_id,
                'business_id' => $request->id,
                'points_id'   => 6,
                'points'      => 5,
                'status'      => $request->newStatus,
                'description' => 'One to One To Approved',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        if ($request->newStatus == 2) {
            return redirect()->back();
        }

        return redirect()->route('OneToOne.Tostoreview');
    }

    public function referralstatuspendinglogin(Request $request)
    {
        $Reference = DB::table('Reference')->where('Reference_id', $request->id)->first();
        DB::table('Reference')->where('Reference_id', $request->id)->update([
            'isapproved_status' => $request->newStatus,
            'Referencecomment'  => $request->businesscomment,
            'approved_by' => Auth::user()->user_type,
            'approved_by_id' => Auth::user()->id,
            'Reference_received_date' => date('Y-m-d H:i:s'),
        ]);
        // Meeting User Points
        DB::table('member_points')->insert([
            'member_id'   => $Reference->Reference_from ?? 0,
            'business_id' => $request->id,
            'points_id'   => 5,
            'points'      => 10,
            'description' => 'Reference Approved',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // update member_points status
        DB::table('member_points')
            ->where('business_id', $request->id)
            ->update([
                'status' => $request->newStatus,
                'updated_at' => now()
            ]);
        return redirect()->back();
    }

    public function Eventpendinglogin(Request $request)
    {
        $member = DB::table('members')->where(['user_id' => Auth::user()->id])->first();

        if ($request->newStatus == 1) {
            DB::table('event_members')->where([
                'isapproved_status' => 0,
                'event_id' => $request->id,
                'member_id' => $member->id,
            ])->update(['isapproved_status' => $request->newStatus]);

            $events = DB::table('news_and_events')
                ->where('event_id', $request->id)
                ->first();
            $pointsId = null;

            if ($events->event_type == 1) {
                // Direct
                $pointsId = 2;
            } elseif ($events->event_type == 2) {
                // Reference
                $pointsId = 7;
            }

            if ($pointsId) {
                $pointsData = DB::table('points_master')
                    ->where('id', $pointsId)
                    ->first();

                if ($pointsData) {
                    DB::table('member_points')->insert([
                        'business_id' => $request->id,
                        'member_id'   => Auth::id(),
                        'points_id'   => $pointsData->id,
                        'points'      => $pointsData->points,
                        'status'      => 0,
                        'description'      => 'Event ' . ($events->event_type == 1 ? 'ESP' : 'Training') . ' Joined',
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
            }
        } else {

            DB::table('event_members')->where([
                'isapproved_status' => 0,
                'event_id' => $request->id,
                'member_id' => $member->id,
            ])->update(['isapproved_status' => $request->newStatus]);
        }

        return redirect()->back();
    }

    public function Brandshowcaselogincheck(Request $request)
    {
        DB::table('Cluster_Meet_Member_meeting')->where('id', $request->id)->update([
            'is_approve' => $request->newStatus,
            'is_approve_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->back();
    }

    // public function meetinglogincheck(Request $request, $id = null)
    // {
    //     $request->validate([
    //         'newStatus' => 'required|in:1,2,3',
    //         'id' => 'required|integer',
    //         'comment' => 'nullable',
    //     ]);

    //     $userId = Auth::user()->id;
    //     $members = members::where('user_id', $userId)->first();
    //     $updateData = [
    //         'is_approve_meeting' => $request->newStatus,
    //         'is_approve_by' => $userId,
    //         'created_at' => date('Y-m-d H:i:s'),
    //     ];

    //     if ($request->filled('comment')) {
    //         $updateData['comment'] = $request->comment;
    //     }
    //     DB::table('Cluster_Meet_Member_meeting')->where(['id' => $request->id])->update($updateData);
    //     if ($request->newStatus == 1) {
    //         DB::table('member_points')->insert([
    //             'business_id' => $request->id,
    //             'member_id'   => $userId,
    //             'points_id'   => 3,
    //             'points'      => 15,
    //             'status'      => 0,
    //             'description'      => 'Meeting Joined',
    //             'created_at'  => now(),
    //             'updated_at'  => now(),
    //         ]);
    //     }
    //     if ($request->newStatus == 3) {

    //         $exists = DB::table('member_points')
    //             ->where('business_id', $request->id)
    //             ->where('member_id', $userId)
    //             ->where('points_id', 3)
    //             ->where('points', -15)
    //             ->exists();

    //         if (!$exists) {
    //             DB::table('member_points')->insert([
    //                 'business_id' => $request->id,
    //                 'member_id'   => $userId,
    //                 'points_id'   => 3,
    //                 'points'      => -15,
    //                 'status'      => 0,
    //                 'description' => 'Meeting Absent',
    //                 'created_at'  => now(),
    //                 'updated_at'  => now(),
    //             ]);
    //         }
    //     }
    //     return redirect()->back();
    // }
    
     public function meetinglogincheck(Request $request, $id = null)
    {
        $request->validate([
            'newStatus' => 'required|in:1,2,3,4',
            'id' => 'required|integer',
            'comment' => 'nullable',
            'substitute_name' => 'nullable|string|max:255',

        ]);
        $userId = Auth::user()->id;
        if ($userId == 1) {
            $members = members::where('user_id', $request->memberid)->first();
        } else {

            $members = members::where('user_id', $userId)->first();
        }
        $updateData = [
            'is_approve_meeting' => $request->newStatus,
            'is_approve_by' => $members->user_id,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($request->newStatus == 4) {
            $updateData['substitute_name'] = $request->substitute_name;
        }

        if ($request->filled('comment')) {
            $updateData['comment'] = $request->comment;
        }
        DB::table('Cluster_Meet_Member_meeting')->where(['id' => $request->id])->update($updateData);
        if ($request->newStatus == 1) {
            DB::table('member_points')->insert([
                'business_id' => $request->id,
                'member_id'   => $members->user_id,
                'points_id'   => 3,
                'points'      => 15,
                'status'      => 0,
                'description'      => 'Meeting Joined',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
        if ($request->newStatus == 3) {

            $exists = DB::table('member_points')
                ->where('business_id', $request->id)
                ->where('member_id', $members->user_id)
                ->where('points_id', 3)
                ->where('points', -15)
                ->exists();

            if (!$exists) {
                DB::table('member_points')->insert([
                    'business_id' => $request->id,
                    'member_id'   => $members->user_id,
                    'points_id'   => 3,
                    'points'      => -15,
                    'status'      => 0,
                    'description' => 'Meeting Absent',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
        return redirect()->back();
    }

    public function Received1(Request $request)
    {

        $Data = User::where('status', 1)->get();
        $Datadrop = User::where('status', 1)->get();
        $session = Auth::user();
        $Business = Business::join('users', 'users.id', '=', 'Business.business_to_id')
            ->where('users.id', $session->id)
            ->where([
                'iStatus' => 1,
                'isDelete' => 0
            ])
            ->whereIn('isapproved_status', [1])
            ->orderBy('Business.business_Date', 'DESC')
            ->paginate(env('PAR_PAGE_COUNT', 20));
        $Count = $Business->count();
        return view('MemberBusiness.Received', compact('Business', 'Data', 'Datadrop', 'Count'));
    }
    public function member_listing(Request $request, $id = null)
    {
        try {
            $datas = DB::table('Cluster_Meet_Member_meeting')
                ->select('Cluster_Meet_Member_meeting.*', 'members.Contact_person', 'Cluster_Meet.*') // optionally select columns
                ->leftJoin('members', 'Cluster_Meet_Member_meeting.member_id', '=', 'members.id')
                ->leftJoin('Cluster_Meet', 'Cluster_Meet_Member_meeting.meeting_id', '=', 'Cluster_Meet.id')
                ->where('Cluster_Meet_Member_meeting.meeting_id', $id)
                ->paginate(env('PAR_PAGE_COUNT', 20));
            $count = $datas->count();
            return view('MemberBusiness.Memberlist', compact('datas', 'count'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
