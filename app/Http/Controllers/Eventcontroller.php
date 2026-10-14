<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventMembers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use validate;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\AuthkeyWhatsAppService;

class Eventcontroller extends Controller
{
    public function PastEventList(Request $request)
    {

        $today = Carbon::today();
        $Events = Event::where([
            'iStatus' => 1,
            'isDelete' => 0,
            'isapproved_status' => 1
        ])
            ->where('member_id', auth()->user()->id)
            ->whereDate('eventstart_date', '<', $today)
            ->orderBy('eventstart_date', 'DESC')
            ->paginate(20);
        // $Events = Event::orderBy('event_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->paginate(20);
        return view('MemberEventList.index', compact('Events'));
    }

    public function UpcomingEventList(Request $request)
    {
        $today = Carbon::today();
        $Events = Event::where([
            'iStatus' => 1,
            'isDelete' => 0,
            'isapproved_status' => 1
        ])
            ->where('member_id', auth()->user()->id)
            ->whereDate('eventstart_date', '>=', $today)
            ->orderBy('eventstart_date', 'ASC')
            ->paginate(20);
        return view('MemberEventList.UpcomingEvent', compact('Events'));
    }
    public function index(Request $request)
    {
        // $Events = Event::orderBy('event_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0])->paginate(20);
        $members = DB::table('members')
            ->select('id', 'Contact_person', 'phonenumber', 'email', 'user_id')
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->orderBy('Contact_person')
            ->get();
        $givenby = $request->given_by;
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $Data = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
        $Datadrop = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();

        $Events = Event::select(
            'news_and_events.*',
            'event_members.isapproved_status as member_status'
        )
            ->leftJoin('event_members', 'event_members.event_id', '=', 'news_and_events.event_id')

            ->where([
                'news_and_events.iStatus' => 1,
                'news_and_events.isDelete' => 0,
                //'news_and_events.isapproved_status' => 0
            ])

            ->when($request->fromdate, function ($query, $FromDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '>=',
                    date('Y-m-d 00:00:00', strtotime($FromDate))
                );
            })

            ->when($request->todate, function ($query, $ToDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '<=',
                    date('Y-m-d 23:59:59', strtotime($ToDate))
                );
            })

            ->when($request->given_by, function ($query) use ($request) {
                return $query->where('event_members.member_id', $request->given_by);
            })

            ->groupBy('news_and_events.event_id') // ⚠️ duplicate avoid
            ->orderBy('news_and_events.event_id', 'DESC')
            ->paginate(env('PAR_PAGE_COUNT', 20));
        return view('Event.index', compact('Events', 'members', 'givenby', 'FromDate', 'ToDate'));
    }

    public function approvelist(Request $request)
    {
        $members = DB::table('members')
            ->select('id', 'Contact_person', 'phonenumber', 'email', 'user_id')
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->orderBy('Contact_person')
            ->get();
        $givenby = $request->given_by;
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $Data = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
        $Datadrop = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();

        $Events = Event::select('news_and_events.*', 'event_members.isapproved_status as member_status')
            ->join('event_members', 'event_members.event_id', '=', 'news_and_events.event_id')

            ->where([
                'news_and_events.iStatus' => 1,
                'news_and_events.isDelete' => 0,
            ])

            // ✅ status from event_members table
            ->where('event_members.isapproved_status', 1)

            ->when($request->fromdate, function ($query, $FromDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '>=',
                    date('Y-m-d 00:00:00', strtotime($FromDate))
                );
            })

            ->when($request->todate, function ($query, $ToDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '<=',
                    date('Y-m-d 23:59:59', strtotime($ToDate))
                );
            })

            ->when($request->given_by, function ($query) use ($request) {
                return $query->where('event_members.member_id', $request->given_by);
            })

            ->orderBy('news_and_events.event_id', 'DESC')
            ->paginate(env('PAR_PAGE_COUNT', 20));
        //$Count = $Business->count();
        return view('Event.approvelist', compact('Events', 'members', 'givenby', 'FromDate', 'ToDate'));
    }

    public function removelist(Request $request)
    {
        $members = DB::table('members')
            ->select('id', 'Contact_person', 'phonenumber', 'email', 'user_id')
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->orderBy('Contact_person')
            ->get();
        $givenby = $request->given_by;
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $Data = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();
        $Datadrop = User::where('status', 1)->where('role_id', 2)->orderBy('first_name')->get();

        $Events = Event::select('news_and_events.*', 'event_members.isapproved_status as member_status')
            ->join('event_members', 'event_members.event_id', '=', 'news_and_events.event_id')

            ->where([
                'news_and_events.iStatus' => 1,
                'news_and_events.isDelete' => 0,
            ])

            // ✅ status from event_members table
            ->where('event_members.isapproved_status', 2)

            ->when($request->fromdate, function ($query, $FromDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '>=',
                    date('Y-m-d 00:00:00', strtotime($FromDate))
                );
            })

            ->when($request->todate, function ($query, $ToDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '<=',
                    date('Y-m-d 23:59:59', strtotime($ToDate))
                );
            })

            ->when($request->given_by, function ($query) use ($request) {
                return $query->where('event_members.member_id', $request->given_by);
            })

            ->orderBy('news_and_events.event_id', 'DESC')
            ->paginate(env('PAR_PAGE_COUNT', 20));
        //$Count = $Business->count();
        return view('Event.removelist', compact('Events', 'members', 'givenby', 'FromDate', 'ToDate'));
    }

    public function EventParticipate(Request $request, $id)
    {
        $Events = Event::with('EventMembers.member')
            ->where('event_id', $id)
            ->where([
                'iStatus' => 1,
                'isDelete' => 0
            ])
            ->orderBy('event_id', 'DESC')
            ->get();
        return view('Event.Participate', compact('Events'));
    }

    // public function updateEventMemberStatus(Request $request)
    // {
    //     $request->validate([
    //         'event_member_id' => 'required|integer|exists:event_members,id',
    //         'absent' => 'required|in:0,1',
    //     ]);

    //     $member = EventMembers::findOrFail($request->event_member_id);
    //     $member->absent = (int) $request->absent;
    //     $member->save();
    //     $memberdata = DB::table('members')
    //         ->where('id', $member->member_id)
    //         ->first();
    //     // Deduct points only when marking as absent
    //     if ($member->absent == 1) {
    //         $events = DB::table('news_and_events')
    //             ->where('event_id', $member->event_id)
    //             ->first();

    //         if ($events) {
    //             $deductPoints = null;
    //             $description = null;

    //             if ($events->event_type == 1) {
    //                 // ESP
    //                 $deductPoints = -20;
    //                 $points_id = 2;
    //                 $description = 'Event ESP Absent';
    //             } elseif ($events->event_type == 2) {
    //                 // Training
    //                 $deductPoints = -25;
    //                 $points_id = 7;
    //                 $description = 'Event Training Absent';
    //             }

    //             if ($deductPoints !== null) {
    //                 DB::table('member_points')->insert([
    //                     'business_id' => $member->event_id,
    //                     'member_id'   => $memberdata->user_id,
    //                     'points_id'   => $points_id,
    //                     'points'      => $deductPoints,
    //                     'status'      => 0,
    //                     'description' => $description,
    //                     'created_at'  => now(),
    //                     'updated_at'  => now(),
    //                 ]);
    //             }
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Event member updated successfully.');
    // }
    
    public function updateEventMemberStatus(Request $request)
    {
        $request->validate([
            'event_member_id' => 'required|integer|exists:event_members,id',
            'absent' => 'required|in:0,1',
        ]);
        
        $member = EventMembers::findOrFail($request->event_member_id);
       
    
        $member->absent = (int) $request->absent;
        $member->save();
        
        if ($member->absent == 0) {
            DB::table('event_members')
                ->where('member_id', $member->member_id)
                ->update([
                    'isapproved_status' => 1,
                ]);
        }
    
        $memberdata = DB::table('members')
            ->where('id', $member->member_id)
            ->first();
    
        if (!$memberdata) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        $events = DB::table('news_and_events')
        ->where('event_id', $member->event_id)
        ->first();

       if ($events) {

        $points = null;
        $points_id = null;
        $description = null;

        if ($events->event_type == 1) {
            // ESP
            $points_id = 2;

            if ($member->absent == 1) {
                $points = -20;
                $description = 'Event ESP Absent';
            } else {
                $points = 20;
                $description = 'Event ESP Join';
            }

        } elseif ($events->event_type == 2) {
            // Training
            $points_id = 7;

            if ($member->absent == 1) {
                $points = -25;
                $description = 'Event Training Absent';
            } else {
                $points = 25;
                $description = 'Event Training Join';
            }
        }

        if ($points !== null) {
            DB::table('member_points')->insert([
                'business_id' => $member->event_id,
                'member_id'   => $memberdata->user_id,
                'points_id'   => $points_id,
                'points'      => $points,
                'status'      => 0,
                'description' => $description,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

     return redirect()->back()->with('success', 'Event member updated successfully.');
    }

    public function exportToexcel_list(Request $request, $fromdate = null, $todate = null)
    {
        $datas = Event::select('news_and_events.*', 'event_members.isapproved_status as member_status')
            ->join('event_members', 'event_members.event_id', '=', 'news_and_events.event_id')

            ->where([
                'news_and_events.iStatus' => 1,
                'news_and_events.isDelete' => 0,
            ])

            // ✅ status from event_members table
            ->where('event_members.isapproved_status', 0)

            ->when($request->fromdate, function ($query, $FromDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '>=',
                    date('Y-m-d 00:00:00', strtotime($FromDate))
                );
            })

            ->when($request->todate, function ($query, $ToDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '<=',
                    date('Y-m-d 23:59:59', strtotime($ToDate))
                );
            })

            ->when($request->given_by, function ($query) use ($request) {
                return $query->where('event_members.member_id', $request->given_by);
            })

            ->orderBy('news_and_events.event_id', 'DESC')
            ->get();

        return view('Event.exportlist', compact('datas'));
    }

    public function exporteventapprove(Request $request, $fromdate = null, $todate = null)
    {
        $datas = Event::select('news_and_events.*', 'event_members.isapproved_status as member_status')
            ->join('event_members', 'event_members.event_id', '=', 'news_and_events.event_id')

            ->where([
                'news_and_events.iStatus' => 1,
                'news_and_events.isDelete' => 0,
            ])

            // ✅ status from event_members table
            ->where('event_members.isapproved_status', 1)

            ->when($request->fromdate, function ($query, $FromDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '>=',
                    date('Y-m-d 00:00:00', strtotime($FromDate))
                );
            })

            ->when($request->todate, function ($query, $ToDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '<=',
                    date('Y-m-d 23:59:59', strtotime($ToDate))
                );
            })

            ->when($request->given_by, function ($query) use ($request) {
                return $query->where('event_members.member_id', $request->given_by);
            })

            ->orderBy('news_and_events.event_id', 'DESC')
            ->get();

        return view('Event.exportlist', compact('datas'));
    }

    public function exporteventreject(Request $request, $fromdate = null, $todate = null)
    {
        $datas = Event::select('news_and_events.*', 'event_members.isapproved_status as member_status')
            ->join('event_members', 'event_members.event_id', '=', 'news_and_events.event_id')

            ->where([
                'news_and_events.iStatus' => 1,
                'news_and_events.isDelete' => 0,
            ])

            // ✅ status from event_members table
            ->where('event_members.isapproved_status', 1)

            ->when($request->fromdate, function ($query, $FromDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '>=',
                    date('Y-m-d 00:00:00', strtotime($FromDate))
                );
            })

            ->when($request->todate, function ($query, $ToDate) {
                return $query->where(
                    'news_and_events.eventstart_date',
                    '<=',
                    date('Y-m-d 23:59:59', strtotime($ToDate))
                );
            })

            ->when($request->given_by, function ($query) use ($request) {
                return $query->where('event_members.member_id', $request->given_by);
            })

            ->orderBy('news_and_events.event_id', 'DESC')
            ->get();

        return view('Event.exportlist', compact('datas'));
    }
    public function storeview()
    {
        $members = DB::table('members')
            ->select('id', 'Contact_person', 'phonenumber', 'email')
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->orderBy('Contact_person')
            ->get();
        return view('Event.storeview', compact('members'));
    }
    public function create(Request $request)
    {

        $request->validate([
            'name' => 'required',

        ]);

        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/evolv_business/event/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }
        $slug = Str::slug($request->name);
        $Data = array(
            'name'            => $request->name,
            'user_id'   => auth()->id(),
            'photo'           => $img,
            'eventstart_date' => $request->eventstart_date,
            'eventstart_time'   => $request->eventstart_time,
            'eventend_time'   => $request->eventend_time,
            'event_type'   => $request->event_type,
            'assign_member_id'  => json_encode($request->assign_member_id),   // Save as JSON
            'ispaid'          => $request->ispaid,
            'price'           => $request->price,
            'limitedset'      => $request->limitedset,
            'setnumber'       => $request->setnumber,
            'description'     => $request->description,
            'event_slug' => $slug,
            'created_at'      => date('Y-m-d H:i:s'),
            'created_by'      => auth()->user()->id,
            'strIP' => $request->ip()
        );
        // dd($Data);
        // DB::table('news_and_events')->insert($Data);
        $eventId = DB::table('news_and_events')->insertGetId($Data);
        if (!empty($request->assign_member_id)) {

            $members = [];
            $whatsappService = new AuthkeyWhatsAppService();
            $wid = "41821"; // Event template ID
            foreach ($request->assign_member_id as $memberId) {
                $members[] = [
                    'event_id'          => $eventId,
                    'member_id'         => $memberId,
                    'isapproved_status' => 0, // Pending
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
                $member = DB::table('members')
                    ->where('id', $memberId)
                    ->first();
                if (!empty($member) && !empty($member->phonenumber)) {

                    $response = $whatsappService->sendText($member->phonenumber, $wid);
                }
            }

            DB::table('event_members')->insert($members);
        }
        return redirect()->route('Event.index')->with('success', 'Event Created Successfully.');
    }

    public function editPage($id)
    {
        $event = Event::with([
            'EventMembers.member'
        ])
            ->where('event_id', $id)
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | Already assigned member ids
    |--------------------------------------------------------------------------
    */

        $assignedMemberIds = $event->EventMembers
            ->pluck('member_id')
            ->toArray();


        /*
    |--------------------------------------------------------------------------
    | Section 2 dropdown:
    | Show only members which are NOT already assigned.
    |--------------------------------------------------------------------------
    */

        $availableMembers = DB::table('members')
            ->select(
                'id',
                'Contact_person',
                'phonenumber',
                'email'
            )
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->when(
                !empty($assignedMemberIds),
                function ($query) use ($assignedMemberIds) {

                    $query->whereNotIn(
                        'id',
                        $assignedMemberIds
                    );
                }
            )
            ->orderBy('Contact_person')
            ->get();


        return view(
            'Event.edit',
            compact(
                'event',
                'availableMembers'
            )
        );
    }

    public function updateEventDetails(Request $request)
    {
        $request->validate([
            'event_id'        => 'required|exists:news_and_events,event_id',
            'name'            => 'required|max:255',
            'eventstart_date' => 'required|date',
            'eventstart_time' => 'required',
            'eventend_time'   => 'required',
            'event_type'      => 'required|in:1,2,3',
            'description'     => 'required',
            'photo'           => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);


        $event = Event::where('event_id', $request->event_id)
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | Existing Image
    |--------------------------------------------------------------------------
    */

        $img = $event->photo;


        /*
    |--------------------------------------------------------------------------
    | New Image
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('photo')) {

            $root = $_SERVER['DOCUMENT_ROOT'];

            $destinationPath =
                $root . '/evolv_business/event/';


            if (!file_exists($destinationPath)) {

                mkdir(
                    $destinationPath,
                    0755,
                    true
                );
            }


            /*
         * Delete old photo
         */
            if (
                !empty($event->photo)
                &&
                file_exists(
                    $destinationPath . $event->photo
                )
            ) {

                unlink(
                    $destinationPath . $event->photo
                );
            }


            $image = $request->file('photo');


            $img =
                time() .
                '_' .
                uniqid() .
                '.' .
                $image->getClientOriginalExtension();


            $image->move(
                $destinationPath,
                $img
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Update Event
    |--------------------------------------------------------------------------
    */

        DB::table('news_and_events')
            ->where(
                'event_id',
                $event->event_id
            )
            ->update([

                'name' =>
                $request->name,

                'photo' =>
                $img,

                'eventstart_date' =>
                $request->eventstart_date,

                'eventstart_time' =>
                $request->eventstart_time,

                'eventend_time' =>
                $request->eventend_time,

                'event_type' =>
                $request->event_type,

                'description' =>
                $request->description,

                'event_slug' =>
                Str::slug($request->name),

                'updated_at' =>
                now(),

                'updated_by' =>
                auth()->id(),

            ]);


        /*
     * IMPORTANT:
     * event_members ko yahan delete/update nahi karna.
     */


        return redirect()
            ->route(
                'Event.edit.page',
                $event->event_id
            )
            ->with(
                'success',
                'Event details updated successfully.'
            );
    }

    public function addEventMembers(Request $request, $id)
    {
        $request->validate([
            'member_ids'   => 'required|array|min:1',
            'member_ids.*' => 'required|integer|exists:members,id',
        ]);


        $event = Event::where('event_id', $id)
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | Existing Members
    |--------------------------------------------------------------------------
    */

        $existingMemberIds = EventMembers::where(
            'event_id',
            $event->event_id
        )
            ->pluck('member_id')
            ->toArray();


        /*
    |--------------------------------------------------------------------------
    | Remove duplicates
    |--------------------------------------------------------------------------
    */

        $newMemberIds = array_diff(
            $request->member_ids,
            $existingMemberIds
        );


        if (empty($newMemberIds)) {

            return redirect()
                ->route(
                    'Event.edit.page',
                    $event->event_id
                )
                ->with(
                    'error',
                    'Selected members are already assigned.'
                );
        }


        DB::beginTransaction();


        try {

            foreach ($newMemberIds as $memberId) {

                EventMembers::create([

                    'event_id' =>
                    $event->event_id,

                    'member_id' =>
                    $memberId,

                    /*
                 * Newly assigned member is Pending
                 */
                    'isapproved_status' =>
                    0,

                    'absent' =>
                    0,

                ]);
            }


            /*
        |--------------------------------------------------------------------------
        | Keep news_and_events.assign_member_id JSON synchronized
        |--------------------------------------------------------------------------
        */

            $this->syncEventAssignedMembers(
                $event->event_id
            );


            DB::commit();


            return redirect()
                ->route(
                    'Event.edit.page',
                    $event->event_id
                )
                ->with(
                    'success',
                    count($newMemberIds) .
                        ' member(s) added successfully.'
                );
        } catch (\Exception $e) {

            DB::rollBack();


            return redirect()
                ->back()
                ->with(
                    'error',
                    'Unable to add members.'
                );
        }
    }

    public function deleteEventMember(
        $eventId,
        $eventMemberId
    ) {
        $eventMember = EventMembers::where(
            'id',
            $eventMemberId
        )
            ->where(
                'event_id',
                $eventId
            )
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | Only Pending Member Can Be Deleted
    |--------------------------------------------------------------------------
    */

        if (
            (int) $eventMember->isapproved_status !== 0
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Only pending members can be removed.'
                );
        }


        DB::beginTransaction();


        try {

            $eventMember->delete();


            /*
         * Sync JSON column
         */
            $this->syncEventAssignedMembers(
                $eventId
            );


            DB::commit();


            return redirect()
                ->back()
                ->with(
                    'success',
                    'Member removed successfully.'
                );
        } catch (\Exception $e) {

            DB::rollBack();


            return redirect()
                ->back()
                ->with(
                    'error',
                    'Unable to remove member.'
                );
        }
    }

    private function syncEventAssignedMembers($eventId)
    {
        $memberIds = EventMembers::where(
            'event_id',
            $eventId
        )
            ->pluck('member_id')
            ->map(function ($id) {
                return (int) $id;
            })
            ->values()
            ->toArray();


        DB::table('news_and_events')
            ->where(
                'event_id',
                $eventId
            )
            ->update([

                'assign_member_id' =>
                json_encode($memberIds),

                'updated_at' =>
                now(),

            ]);
    }
    public function editview(Request $request, $id)
    {
        $event = Event::where([
            'iStatus'  => 1,
            'isDelete' => 0,
            'event_id' => $id,
        ])->first();

        if (!$event) {
            return response()->json([
                'status'  => false,
                'message' => 'Event not found.',
            ], 404);
        }

        $selectedMemberIds = DB::table('event_members')
            ->where('event_id', $id)
            ->pluck('member_id')
            ->map(function ($memberId) {
                return (string) $memberId;
            })
            ->values()
            ->toArray();

        return response()->json([
            'status'               => true,
            'event_id'             => $event->event_id,
            'name'                 => $event->name,
            'photo'                => $event->photo,
            'eventstart_date'      => $event->eventstart_date
                ? Carbon::parse($event->eventstart_date)->format('Y-m-d')
                : '',
            'eventstart_time'      => $event->eventstart_time,
            'eventend_time'        => $event->eventend_time,
            'event_type'           => $event->event_type,
            'description'          => $event->description ?? '',
            'selected_member_ids'  => $selectedMemberIds,
        ]);
    }
    public function update(Request $request)
    {
        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            //dd($img);
            $destinationpath = $root . '/evolv_business/event/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
            $oldImg = $request->input('hiddenPhoto') ? $request->input('hiddenPhoto') : null;
            //dd($oldImg);

            if ($oldImg != null || $oldImg != "") {
                if (file_exists($destinationpath . $oldImg)) {
                    unlink($destinationpath . $oldImg);
                }
            }
        } elseif ($request->input('hiddenPhoto')) {
            $oldImg = $request->input('hiddenPhoto');
            $img = $oldImg;
        } else {
            // $root = $_SERVER['DOCUMENT_ROOT'];
            // $img = $root . '/images/noimage.jpg';
            //   $img = null;
        }
        // dd($img);
        //dd($request);
        $slug = Str::slug($request->name);
        $Event = DB::table('news_and_events')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'event_id' => $request->event_id])
            ->update([
                'name'            => $request->name,
                'user_id'   => auth()->id(),
                'photo'           => $img,
                'eventstart_date' => $request->eventstart_date,
                'eventstart_time' => $request->eventstart_time,
                'eventend_time' => $request->eventend_time,
                'event_type'          => $request->event_type,
                'description' => $request->description,
                'assign_member_id' => !empty($request->assign_member_id)
                    ? json_encode($request->assign_member_id)
                    : json_encode([]),
                'event_slug' => $slug,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => auth()->user()->id,
            ]);
        DB::table('event_members')
            ->where('event_id', $request->event_id)
            ->delete();
        if (!empty($request->assign_member_id)) {

            $members = [];

            foreach ($request->assign_member_id as $memberId) {
                $members[] = [
                    'event_id'          => $request->event_id,
                    'member_id'         => $memberId,
                    'isapproved_status' => 0,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
            }

            DB::table('event_members')->insert($members);
        }
        return redirect()->route('Event.index')->with('success', 'Event Updated Successfully.');
    }
    // public function delete(Request $request)
    // {
    //     $delete = DB::table('news_and_events')
    //         ->where(['iStatus' => 1, 'isDelete' => 0, 'event_id' => $request->id])
    //         ->first();

    //     if (!$delete) {
    //         return redirect()->route('Event.index')->with('error', 'Event not found!');
    //     }

    //     // Delete the event photo if it exists
    //     $root = $_SERVER['DOCUMENT_ROOT'];
    //     $destinationpath = $root . '/evolv_business/event/';
    //     if ($delete->photo && file_exists($destinationpath . $delete->photo)) {
    //         unlink($destinationpath . $delete->photo);
    //     }

    //     DB::beginTransaction();
    //     try {
    //         // Delete assigned members for this event
    //         DB::table('event_members')
    //             ->where('event_id', $request->id)
    //             ->delete();

    //         // Delete the event itself
    //         DB::table('news_and_events')
    //             ->where(['iStatus' => 1, 'isDelete' => 0, 'event_id' => $request->id])
    //             ->delete();

    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->route('Event.index')->with('error', 'Something went wrong while deleting the event.');
    //     }

    //     return redirect()->route('Event.index')->with('success', 'Event Deleted Successfully!');
    // }

    public function delete(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | Get Event
    |--------------------------------------------------------------------------
    */

        $event = DB::table('news_and_events')
            ->where([
                'iStatus'  => 1,
                'isDelete' => 0,
                'event_id' => $request->id
            ])
            ->first();


        if (!$event) {

            return redirect()
                ->route('Event.index')
                ->with('error', 'Event not found!');
        }


        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | Get Point Configuration
        |--------------------------------------------------------------------------
        */

            $pointsId = null;
            $description = null;


            if ((int) $event->event_type === 1) {

                // ESP
                $pointsId = 2;

                $description =
                    'Event ESP Deleted';
            } elseif ((int) $event->event_type === 2) {

                // Training
                $pointsId = 7;

                $description =
                    'Event Training Deleted';
            }


            /*
        |--------------------------------------------------------------------------
        | Get Approved Members BEFORE deleting event_members
        |--------------------------------------------------------------------------
        */

            $approvedMembers = DB::table('event_members')
                ->where('event_id', $event->event_id)
                ->where('isapproved_status', 1)
                ->get();


            /*
        |--------------------------------------------------------------------------
        | Insert Minus Points
        |--------------------------------------------------------------------------
        */

            if ($pointsId && $approvedMembers->count() > 0) {

                /*
             * Get actual points from points_master
             */
                $pointsData = DB::table('points_master')
                    ->where('id', $pointsId)
                    ->first();


                if ($pointsData) {

                    foreach ($approvedMembers as $eventMember) {

                        /*
                     * event_members.member_id = members.id
                     */
                        $member = DB::table('members')
                            ->where('id', $eventMember->member_id)
                            ->first();


                        if (
                            !$member ||
                            empty($member->user_id)
                        ) {
                            continue;
                        }


                        /*
                    |--------------------------------------------------------------------------
                    | Add Negative Point
                    |--------------------------------------------------------------------------
                    |
                    | member_points.member_id uses members.user_id
                    |
                    */

                        DB::table('member_points')
                            ->insert([

                                'business_id' =>
                                $event->event_id,

                                'member_id' =>
                                $member->user_id,

                                'points_id' =>
                                $pointsId,

                                'points' =>
                                -abs($pointsData->points),

                                'status' =>
                                0,

                                'description' =>
                                $description,

                                'created_at' =>
                                now(),

                                'updated_at' =>
                                now(),

                            ]);
                    }
                }
            }


            /*
        |--------------------------------------------------------------------------
        | Delete Event Members
        |--------------------------------------------------------------------------
        */

            DB::table('event_members')
                ->where(
                    'event_id',
                    $event->event_id
                )
                ->delete();


            /*
        |--------------------------------------------------------------------------
        | Delete Event
        |--------------------------------------------------------------------------
        */

            DB::table('news_and_events')
                ->where([
                    'iStatus'  => 1,
                    'isDelete' => 0,
                    'event_id' => $event->event_id
                ])
                ->delete();


            DB::commit();


            /*
        |--------------------------------------------------------------------------
        | Delete Photo
        |--------------------------------------------------------------------------
        */

            $root =
                $_SERVER['DOCUMENT_ROOT'];

            $destinationPath =
                $root . '/evolv_business/event/';


            if (
                !empty($event->photo) &&
                file_exists(
                    $destinationPath .
                        $event->photo
                )
            ) {

                unlink(
                    $destinationPath .
                        $event->photo
                );
            }


            return redirect()
                ->route('Event.index')
                ->with(
                    'success',
                    'Event Deleted Successfully and points deducted!'
                );
        } catch (\Exception $e) {

            DB::rollBack();


            return redirect()
                ->route('Event.index')
                ->with(
                    'error',
                    'Something went wrong: ' .
                        $e->getMessage()
                );
        }
    }

    public function Eventindex(Request $request, $id)
    {

        $eventname = DB::table('news_and_events')
            ->select('news_and_events.name')->where(['news_and_events.iStatus' => 1, 'news_and_events.isDelete' => 0, 'news_and_events.event_id' => $id])->first();

        $inquiry = DB::table('member_news_comment')
            ->select('member_news_comment.ispaid', 'member_news_comment.Payment_Status', 'member_news_comment.id', 'member_news_comment.news_id', 'member_news_comment.name as member_news_comment_name', 'member_news_comment.email', 'member_news_comment.companyname', 'member_news_comment.businesscategory', 'member_news_comment.phonenumber', 'member_news_comment.message', 'news_and_events.name', 'member_news_comment.referred_by', 'member_news_comment.reference_name')
            ->leftjoin('news_and_events', 'member_news_comment.news_id', '=', 'news_and_events.event_id')
            ->where(['member_news_comment.iStatus' => 1, 'member_news_comment.isDelete' => 0, 'member_news_comment.news_id' => $id])
            ->orderBy('id', 'DESC')
            ->paginate(50);
        return view('Eventinquiry.index', compact('inquiry', 'eventname'));
    }
    public function Eventdelete(Request $request)
    {
        // dd($request);
        DB::table('member_news_comment')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();
        return back()->with('success', 'Event inquiry Deleted Successfully!');
    }
}
