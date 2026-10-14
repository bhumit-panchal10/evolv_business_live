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
use App\Models\OneToOne;
use App\Models\Member_metting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BusinessCreated;
use validate;
use Illuminate\Support\Str;
use App\Mail\BusinessStatusMail;
use App\Services\AuthkeyWhatsAppService;

class OneToOneController extends Controller
{

    public function pending(Request $request)
    {
        try {
            $givenby = $request->given_by;
            $businesstype = $request->business_type;
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $session = Auth::user()->id;

            $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
                ->where('users.status', 1)
                ->where('users.role_id', 2)
                ->where('members.Arrival_flag', 0)
                ->orderBy('users.first_name')
                ->select('users.*')
                ->get();

            $Datadrop = User::where('status', 1)->orderBy('first_name')->get();
            //dd($session);
            $OneToOne = OneToOne::where('one_to_one_detail.iStatus', 1)
                ->where('one_to_one_detail.isDelete', 0)
                ->where('one_to_one_detail.isapproved_status', 0)

                // Important: sirf logged-in TO member ke pending records

                // ->where('one_to_one_detail.to_id', $session)
                ->when($session != 1, function ($query) use ($session) {
                    return $query->where('one_to_one_detail.to_id', $session);
                })

                ->when($request->fromdate, function ($query, $FromDate) {
                    return $query->where(
                        'one_to_one_detail.date',
                        '>=',
                        date('Y-m-d 00:00:00', strtotime($FromDate))
                    );
                })
                ->when($request->given_by, function ($query) use ($givenby) {
                    $query->where('one_to_one_detail.to_id', 'LIKE', '%' . $givenby . '%');
                })

                ->when($request->todate, function ($query, $ToDate) {
                    return $query->where(
                        'one_to_one_detail.date',
                        '<=',
                        date('Y-m-d 23:59:59', strtotime($ToDate))
                    );
                });
            if ($businesstype !== "" && $businesstype !== null) {
                $OneToOne->where('one_to_one_detail.isapproved_status', $businesstype);
            }

            $Business = $OneToOne
                ->orderBy('one_to_one_detail.id', 'DESC')
                ->paginate(env('PAR_PAGE_COUNT', 20));

            $Count = $Business->count();
            $businesses = DB::table('members')
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->orderBy('Contact_person', 'asc')
                ->get();

            return view('OneToOne.pending', compact(
                'givenby',
                'businesses',
                'Business',
                'Data',
                'Datadrop',
                'Count',
                'businesstype',
                'FromDate',
                'ToDate'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function approved(Request $request)
    {
        try {
            $givenby = $request->given_by;
            $businesstype = $request->business_type;
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $session = Auth::user()->id;
            // $Data = User::where('status', 1)->orderBy('first_name')->get();
            $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
                ->where('users.status', 1)
                ->where('users.role_id', 2)
                ->where('members.Arrival_flag', 0)
                ->orderBy('users.first_name')
                ->select('users.*')
                ->get();
            $businesses = DB::table('members')
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->orderBy('Contact_person', 'asc')
                ->get();
            $Datadrop = User::where('status', 1)->orderBy('first_name')->get();

            // dd($businesstype);
            $OneToOne = OneToOne::where([
                'iStatus' => 1,
                'isDelete' => 0
            ])
                ->where('one_to_one_detail.isapproved_status', 1)

                ->when($request->fromdate, function ($query, $FromDate) {
                    return $query->where(
                        'one_to_one_detail.date',
                        '>=',
                        date('Y-m-d 00:00:00', strtotime($FromDate))
                    );
                })
                ->when($request->given_by, function ($query) use ($givenby) {
                    $query->where('one_to_one_detail.to_id', 'LIKE', '%' . $givenby . '%');
                })

                ->when($request->todate, function ($query, $ToDate) {
                    return $query->where(
                        'one_to_one_detail.date',
                        '<=',
                        date('Y-m-d 23:59:59', strtotime($ToDate))
                    );
                })

                ->when($businesstype, function ($query, $businesstype) {
                    return $query->where('isapproved_status', $businesstype);
                });
            $Business = $OneToOne->orderBy('id', 'DESC')
                ->paginate(env('PAR_PAGE_COUNT', 20));

            $Count = $Business->count();
            return view('OneToOne.approve', compact('givenby', 'businesses', 'Business', 'Data', 'Datadrop', 'Count', 'businesstype', 'FromDate', 'ToDate'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function rejectlist(Request $request)
    {
        try {
            $givenby = $request->given_by;

            $businesstype = $request->business_type;
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $session = Auth::user()->id;
            // $Data = User::where('status', 1)->orderBy('first_name')->get();
            $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
                ->where('users.status', 1)
                ->where('users.role_id', 2)
                ->where('members.Arrival_flag', 0)
                ->orderBy('users.first_name')
                ->select('users.*')
                ->get();
            $businesses = DB::table('members')
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->orderBy('Contact_person', 'asc')
                ->get();
            $Datadrop = User::where('status', 1)->orderBy('first_name')->get();

            $OneToOne = OneToOne::where(['iStatus' => 1, 'isDelete' => 0])
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->where('isapproved_status', '=', 2)
                ->when($request->given_by, function ($query) use ($givenby) {
                    $query->where('one_to_one_detail.to_id', 'LIKE', '%' . $givenby . '%');
                })
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))));

            $Business = $OneToOne->orderBy('id', 'DESC')
                ->paginate(env('PAR_PAGE_COUNT', 20));

            $Count = $Business->count();
            return view('OneToOne.rejectlist', compact('givenby', 'businesses', 'Business', 'Data', 'Datadrop', 'Count', 'businesstype', 'FromDate', 'ToDate'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function index(Request $request)
    {
        try {
            $businesstype = $request->business_type;
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $session = Auth::user()->id;

            $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
                ->where('users.status', 1)
                ->where('users.role_id', 2)
                ->where('members.Arrival_flag', 0)
                ->orderBy('users.first_name')
                ->select('users.*')
                ->get();

            $Datadrop = User::where('status', 1)->orderBy('first_name')->get();

            $OneToOne = OneToOne::query()
                ->select(
                    'one_to_one_detail.*',
                    DB::raw("
                    CASE 
                        WHEN one_to_one_detail.from_id = {$session} 
                        THEN one_to_one_detail.to
                        ELSE one_to_one_detail.from
                    END AS meeting_with
                "),
                    DB::raw("
                    CASE 
                        WHEN one_to_one_detail.from_id = {$session} 
                        THEN one_to_one_detail.to_id
                        ELSE one_to_one_detail.from_id
                    END AS meeting_with_id
                ")
                )
                ->where(function ($query) use ($session) {
                    $query->where('one_to_one_detail.from_id', $session)
                        ->orWhere('one_to_one_detail.to_id', $session);
                })
                ->where('one_to_one_detail.iStatus', 1)
                ->where('one_to_one_detail.isDelete', 0)
                ->when($request->fromdate, function ($query, $FromDate) {
                    return $query->where(
                        'one_to_one_detail.date',
                        '>=',
                        date('Y-m-d 00:00:00', strtotime($FromDate))
                    );
                })
                ->when($request->todate, function ($query, $ToDate) {
                    return $query->where(
                        'one_to_one_detail.date',
                        '<=',
                        date('Y-m-d 23:59:59', strtotime($ToDate))
                    );
                });

            if ($businesstype !== "" && $businesstype !== null) {
                $OneToOne->where('one_to_one_detail.isapproved_status', $businesstype);
            }

            $Business = $OneToOne
                ->orderBy('one_to_one_detail.id', 'DESC')
                ->paginate(env('PAR_PAGE_COUNT', 20));

            $Count = $Business->count();

            return view('OneToOne.index', compact(
                'Business',
                'Data',
                'Datadrop',
                'Count',
                'businesstype',
                'FromDate',
                'ToDate'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function exportToexcel_list(Request $request, $fromdate = null, $todate = null)
    {
        try {
            $FromDate = $fromdate;
            $ToDate = $todate;
            $datas = Business::select(
                'Business.*'
            )
                ->where(['Business.iStatus' => 1, 'Business.isDelete' => 0, 'isapproved_status' => 0])
                ->when($fromdate, fn($query, $FromDate) => $query
                    ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($todate, fn($query, $ToDate) => $query
                    ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->get();
            //    ->paginate(20);

            return view('OneToOne.exportlist', compact('datas', 'FromDate', 'ToDate'));
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
            return view('OneToOne.storeview', compact('Data', 'session'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function Tostoreview()
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
            return view('OneToOne.Tostoreview', compact('Data', 'session'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try {
            $session = Auth::user();
            $ToUser = User::find($request->oneToone_to);
            $mobileNo = $ToUser->mobile_number ?? '';
            $ToUserName = $ToUser ? $ToUser->first_name : 'Unknown User';
            $request->validate([
                'oneToone_to'     => 'required',
                'Date'   => 'required|date',
            ]);

            $img = "";
            if ($request->hasFile('photo')) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('photo');
                $img = time() . '.' . $image->getClientOriginalExtension();
                $destinationpath = $root . '/OneToOne/';
                if (!file_exists($destinationpath)) {
                    mkdir($destinationpath, 0755, true);
                }
                $image->move($destinationpath, $img);
            }

            $gu_id = Str::random(10);

            $Data = array(
                'from'   => $session->first_name,
                'to'     => $ToUserName,
                'date'   => $request->Date,
                'question_1'   => $request->question_1,
                'question_2'   => $request->question_2,
                'question_3'   => $request->question_3,
                'question_4'   => $request->question_4,
                'question_5'   => $request->question_5,
                'question_6'   => $request->question_6,
                // 'question_7'   => $request->question_7,
                // 'question_8'   => $request->question_8,
                // 'question_9'   => $request->question_9,
                // 'business_worth'   => $request->business_worth,
                // 'business_till'   => $request->business_till,
                'gu_id'           => $gu_id,
                'from_id' => $session->id,
                'to_id' => $request->oneToone_to,
                'created_at'      => date('Y-m-d H:i:s'),
                'created_by'      => auth()->id(),
                "strIP" => $_SERVER['REMOTE_ADDR']

            );

            $businessId = DB::table('one_to_one_detail')->insertGetId($Data);
            $whatsappService = new AuthkeyWhatsAppService();
            $wid = "41828"; // template id
            $statusofMessage = $whatsappService->sendText($mobileNo, $wid);
            // $id = DB::table('member_points')->insertGetId([
            //     'member_id' => $session->id,
            //     'business_id' => $businessId,
            //     'points_id' => 6,
            //     'points' => 5,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);

            return response()->json(['success' => true, 'message' => 'One To One Created Successfully.']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function Tocreate(Request $request)
    {
        try {
            $session = Auth::user();
            $oneToOne = OneToOne::where('to_id', $session->id)->first();

            // Check logged in user is receiver
            if ($oneToOne->to_id != $session->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized Access'
                ], 403);
            }
            OneToOne::where('to_id', $session->id)
                ->update([
                    'to_question_1'     => $request->to_question_1,
                    'to_question_2'     => $request->to_question_2,
                    'to_question_3'     => $request->to_question_3,
                    'to_question_4'     => $request->to_question_4,
                    'to_question_5'     => $request->to_question_5,
                    'to_question_6'     => $request->to_question_6,
                    // 'to_question_7'     => $request->to_question_7,
                    // 'to_question_8'     => $request->to_question_8,
                    // 'to_question_9'     => $request->to_question_9,
                    // 'to_business_worth' => $request->to_business_worth,
                    // 'to_business_till'  => $request->to_business_till,
                    'updated_by'        => $session->id,
                    'updated_at'        => now(),
                ]);
            return response()->json([
                'success' => true,
                'message' => 'Questions Updated Successfully'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function editview(Request $request, $Id)
    {

        $Business = OneToOne::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $Id])->first();
        return response()->json($Business);
    }

    public function update(Request $request)
    {
        $session = Auth::user();
        $ToUser = User::find($request->oneToone_to);
        $ToUserName = $ToUser ? $ToUser->first_name : 'Unknown User';
        $request->validate([
            //'place'   => 'required',
            'oneToone_to'     => 'required',
            //'comment' => 'required',
            'Date'   => 'required|date',
        ]);

        // $img = "";
        // if ($request->hasFile('photo')) {
        //     $root = $_SERVER['DOCUMENT_ROOT'];
        //     $image = $request->file('photo');
        //     $img = time() . '.' . $image->getClientOriginalExtension();
        //     $destinationpath = $root . '/OneToOne/';
        //     if (!file_exists($destinationpath)) {
        //         mkdir($destinationpath, 0755, true);
        //     }
        //     $image->move($destinationpath, $img);
        //     $oldImg = $request->input('hiddenPhoto') ? $request->input('hiddenPhoto') : null;

        //     if ($oldImg != null || $oldImg != "") {
        //         if (file_exists($destinationpath . $oldImg)) {
        //             unlink($destinationpath . $oldImg);
        //         }
        //     }
        // } else {
        //     $oldImg = $request->input('hiddenPhoto');
        //     $img = $oldImg;
        // }

        $Data = array(
            'from'   => $session->first_name,
            'to'     => $ToUserName,
            'date'   => $request->Date,
            //'photo'   => $img,
            'from_id' => $session->id,
            'to_id' => $request->oneToone_to,
            'question_1'   => $request->question_1,
            'question_2'   => $request->question_2,
            'question_3'   => $request->question_3,
            'question_4'   => $request->question_4,
            'question_5'   => $request->question_5,
            'question_6'   => $request->question_6,
            // 'question_7'   => $request->question_7,
            // 'question_8'   => $request->question_8,
            // 'question_9'   => $request->question_9,
            // 'business_worth'   => $request->business_worth,
            // 'business_till'   => $request->business_till,
            'updated_at'      => now(),
            'updated_by'      => auth()->id(),
            "strIP" => request()->ip()

        );
        DB::table('one_to_one_detail')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])
            ->update($Data);

        return redirect()->route('OneToOne.index')->with('success', 'One To One Updated Successfully.');
    }

    public function delete(Request $request)
    {

        DB::table('one_to_one_detail')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();
        return redirect()->route('OneToOne.index')->with('success', 'One To One Deleted Successfully!.');
    }
}
