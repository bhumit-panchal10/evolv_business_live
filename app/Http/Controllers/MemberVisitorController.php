<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products_service;
use App\Models\Visitor;
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

class MemberVisitorController extends Controller
{

    public function getStatus($id)
    {
        $data = Visitor::find($id);

        return response()->json($data);
    }
    public function index(Request $request)
    {
        $givenby = $request->given_by;
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $user = Auth::User();
        $memberData = members::select('*')
            ->where('user_id', $user->id)
            ->first();
        $members = DB::table('members')
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->orderBy('Contact_person', 'asc')
            ->get();

        // $id = $memberData->id;
        $datas = Visitor::with(['business_category', 'members'])
            ->where('iStatus', 0)
            ->when($request->fromdate, function ($query) use ($request) {
                $query->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime($request->fromdate)));
            })
            ->when($request->todate, function ($query) use ($request) {
                $query->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($request->todate)));
            })
            ->when($request->given_by, function ($query) use ($request) {
                $query->where('created_by', $request->given_by);
            })
            ->paginate(env('PAR_PAGE_COUNT', 20));
        $count = $datas->count();
        // dd($datas);
        return view('MemberVisitor.index', compact('datas', 'user', 'count', 'members', 'givenby', 'FromDate', 'ToDate'));
    }
    
    public function Add(Request $request)
    {
        $user = Auth::User();
        // $Data = members::select('*')
        //     ->join('users', 'members.user_id', '=', 'users.id')
        //     ->where('users.status', 1)
        //     ->get();

        $Data = members::query()
            ->join('users', 'members.user_id', '=', 'users.id')
            ->where('users.status', 1)
            ->select(
                'members.*',
                'members.id as member_id',
                'users.first_name',
                'users.mobile_number'
            )
            ->get();
        $futureMeetings = DB::table('Cluster_Meet')
            ->join(
                'city_groups',
                'city_groups.id',
                '=',
                'Cluster_Meet.city_group_id'
            )
            ->where('Cluster_Meet.isDelete', 0)
            ->where('Cluster_Meet.iStatus', 1)
            ->whereRaw(
                "STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %H:%i')"
            )
            ->orderByRaw(
                "STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %H:%i') ASC"
            )
            ->select('Cluster_Meet.*')
            ->get();

        return view('MemberVisitor.AddVisitor', compact('Data', 'futureMeetings'));
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
            $destinationpath = $root . '/evolv_business/Visitor/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }
        $phone = preg_replace('/\D/', '', $request->phone);

        // If country code (91) is present, keep only last 10 digits
        if (strlen($phone) > 10 && substr($phone, 0, 2) == '91') {
            $phone = substr($phone, -10);
        }
        $Data = array(
            'member_id' => $request->member_id,
            'name'    => $request->name,
            'social_media'    => $request->social_media,
            'phone'    => $phone,
            'photo'   => $img,
            'email'    => $request->email,
            'mode'    => $request->mode,
            'business_catgory'    => $request->business_category_id,
            'business_name'    => $request->business_name,
            'meeting_id'    => $request->meeting,
            'created_at' => date('Y-m-d H:i:s'),
            //'strIP' => $request->ip(),
            'created_by'     => auth()->id()

        );
        DB::table('visitors')->insert($Data);

        return redirect()->route('MemberVisitor.index')->with('success', 'Visitor Created Successfully.');
    }

    public function destroy($id)
    {
        $visitor = Visitor::findOrFail($id);

        $visitor->delete();

        return redirect()
            ->back()
            ->with('success', 'Visitor deleted successfully.');
    }

    public function approved(Request $request)
    {
        $givenby = $request->given_by;
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $user = Auth::User();
        $memberData = members::select('*')
            ->where('user_id', $user->id)
            ->first();
        $members = DB::table('members')
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->orderBy('Contact_person', 'asc')
            ->get();

        // $id = $memberData->id;
        $datas = Visitor::with(['business_category', 'members'])
            ->where('iStatus', 1)
            ->when($request->fromdate, function ($query) use ($request) {
                $query->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime($request->fromdate)));
            })
            ->when($request->todate, function ($query) use ($request) {
                $query->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($request->todate)));
            })
            ->when($request->given_by, function ($query) use ($request) {
                $query->where('created_by', $request->given_by);
            })
            ->paginate(env('PAR_PAGE_COUNT', 20));
        $count = $datas->count();
        // dd($datas);
        return view('MemberVisitor.approve', compact('datas', 'user', 'count', 'members', 'givenby', 'FromDate', 'ToDate'));
    }

    public function rejectlist(Request $request)
    {
        $givenby = $request->given_by;
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $user = Auth::User();
        $memberData = members::select('*')
            ->where('user_id', $user->id)
            ->first();
        $members = DB::table('members')
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->orderBy('Contact_person', 'asc')
            ->get();

        // $id = $memberData->id;
        $datas = Visitor::with(['business_category', 'members'])
            ->where('iStatus', 2)
            ->when($request->fromdate, function ($query) use ($request) {
                $query->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime($request->fromdate)));
            })
            ->when($request->todate, function ($query) use ($request) {
                $query->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($request->todate)));
            })
            ->when($request->given_by, function ($query) use ($request) {
                $query->where('created_by', $request->given_by);
            })
            ->paginate(env('PAR_PAGE_COUNT', 20));
        $count = $datas->count();
        // dd($datas);
        return view('MemberVisitor.rejectlist', compact('datas', 'user', 'count', 'members', 'givenby', 'FromDate', 'ToDate'));
    }

    public function exportExcel(Request $request, $status)
    {
        $filename = "Visitor_List_" . date('d-m-Y_H-i-s') . ".xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo "No\tName\tEmail\tDate\tPhone\tMember\tBusiness Name\tBusiness Category\tStatus\n";

        $datas = Visitor::with(['business_category', 'members'])
            ->where('iStatus', $status)
            ->when($request->fromdate, function ($query) use ($request) {
                $query->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime($request->fromdate)));
            })
            ->when($request->todate, function ($query) use ($request) {
                $query->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($request->todate)));
            })
            ->when($request->given_by, function ($query) use ($request) {
                $query->where('created_by', $request->given_by);
            })
            ->get();

        $i = 1;

        foreach ($datas as $row) {

            // ✅ Status text
            $statusText = ($row->iStatus == 0) ? 'Pending' : ($row->iStatus == 1 ? 'Approved' : 'Rejected');

            // ✅ Safe text (tab issue fix)
            $name = str_replace(["\t", "\n", "\r"], ' ', $row->name);
            $email = str_replace(["\t", "\n", "\r"], ' ', $row->email);
            $member = str_replace(["\t", "\n", "\r"], ' ', $row->members->Contact_person ?? '');
            $business = str_replace(["\t", "\n", "\r"], ' ', $row->business_name);
            $category = str_replace(["\t", "\n", "\r"], ' ', $row->business_category->name ?? '');

            echo $i . "\t" .
                $name . "\t" .
                $email . "\t" .
                date('d-m-Y', strtotime($row->created_at)) . "\t" .
                $row->phone . "\t" .
                $member . "\t" .
                $business . "\t" .
                $category . "\t" .
                $statusText . "\n";

            $i++;
        }

        exit();
    }


    public function updateStatus(Request $request)
    {
        $data = Visitor::find($request->id);

        if ($data) {
            $data->iStatus = $request->newStatus;
            $data->comments = $request->comment;
            $data->save();

            return redirect()->back()->with('success', 'Status Updated');
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }
}
