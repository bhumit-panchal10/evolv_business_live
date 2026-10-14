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
use Carbon\Carbon;

class ReportController extends Controller
{
    public function report(Request $request)
    {

        $firstname = $request->first_name;
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        
        $cities = City::select('id', 'city_name')->get();
        $cityGroups = City_group::select('id', 'group_name')->get();
        $categories = Categories::select('id', 'name')->get();
        $subcategories = Subcategories::select('id', 'name')->get();
        $plans = Membershipplans::select('id', 'plan_name')->get();
       
  $datas = Members::select(
    'members.*',
    'users.id as user_id',
    'city.id as city_id',
    'city_groups.id as citygroup_id',
    'categories.id as category_id',
    'categories.name as category_name',
    'city.city_name',
    'city_groups.group_name',
    'users.first_name',
    DB::raw('(select renewal_history.plan_id from renewal_history where renewal_history.member_id = members.id order by renewal_history.id desc limit 1) as plan_id'),
    DB::raw('(select renewal_history.renewal_date from renewal_history where renewal_history.member_id = members.id order by renewal_history.id desc limit 1) as renewal_date'),
    DB::raw('(select renewal_history.paymentrefNo from renewal_history where renewal_history.member_id = members.id order by renewal_history.id desc limit 1) as paymentrefNo'),
    'membership_plans.plan_name',
    'membership_plans.amount'
)
->join('city', 'members.city_id', '=', 'city.id')
->join('city_groups', 'members.citygroup_id', '=', 'city_groups.id')
->join('categories', 'members.category_id', '=', 'categories.id')
->join('users', 'users.id', '=', 'members.user_id')
->join('renewal_history', function($join) {
    $join->on('renewal_history.member_id', '=', 'members.id');
})
->join('membership_plans', 'membership_plans.id', '=', 'renewal_history.plan_id')
->where([
    'members.iStatus' => 1,
    'members.isDelete' => 0
])
->when($request->fromdate, fn($query, $FromDate) =>
    $query->where('renewal_history.renewal_date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate)))
)
->when($request->todate, fn($query, $ToDate) =>
    $query->where('renewal_history.renewal_date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate)))
)
->when($request->first_name, fn($query) =>
    $query->where('users.first_name', 'LIKE', '%' . $request->first_name . '%')
)
->paginate(env('PAR_PAGE_COUNT',20));

$Count = $datas->count();

// ->toSql();
// dd($datas);
    return view('reports.report', compact('Count','cities', 'cityGroups', 'categories', 'subcategories', 'plans', 'datas','firstname','FromDate','ToDate'));
}
   
//export-payment-data 
public function exportToexcel(Request $request, $fromdate = null, $todate = null, $first_name = null)
{
    $firstname = $request->first_name;
    $FromDate = $request->fromdate;
    $ToDate = $request->todate;

    $query = Members::select(
        'members.*',
        'users.id as user_id',
        'city.id as city_id',
        'city_groups.id as citygroup_id',
        'categories.id as category_id',
        'categories.name as category_name',
        'city.city_name',
        'city_groups.group_name',
        'users.first_name',      
        DB::raw('(select users.first_name from users where users.id = members.user_id order by users.id desc limit 1) as user_id'),
        DB::raw('(select renewal_history.plan_id from renewal_history where renewal_history.member_id = members.id order by renewal_history.id desc limit 1) as plan_id'),
        DB::raw('(select renewal_history.renewal_date from renewal_history where renewal_history.member_id = members.id order by renewal_history.id desc limit 1) as renewal_date'),
        DB::raw('(select renewal_history.paymentrefNo from renewal_history where renewal_history.member_id = members.id order by renewal_history.id desc limit 1) as paymentrefNo'),
        'membership_plans.plan_name',
        'membership_plans.amount' 
    )
    ->join('city', 'members.city_id', '=', 'city.id')
    ->join('city_groups', 'members.citygroup_id', '=', 'city_groups.id')
    ->join('categories', 'members.category_id', '=', 'categories.id')
    ->join('renewal_history', 'renewal_history.member_id', '=', 'members.id')
    ->join('membership_plans', 'membership_plans.id', '=', 'renewal_history.plan_id') 
    ->join('users', 'users.id', '=', 'members.user_id')
    ->where(['members.iStatus' => 1, 'members.isDelete' => 0])
    ->when($FromDate, function ($query, $FromDate) {
        return $query->where('renewal_history.renewal_date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate)));
    })
    ->when($ToDate, function ($query, $ToDate) {
        return $query->where('renewal_history.renewal_date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate)));
    })
    ->when($firstname, function ($query, $firstname) {
        return $query->where('users.first_name', 'LIKE', '%' . $firstname . '%');
    });

    $datas = $query->get();

    // dd($datas);

    return view('reports.exportdata', compact('datas', 'firstname', 'ToDate', 'FromDate'));
}

public function Analysisindex(Request $request)
{
  
    $firstname = $request->first_name;
    $FromDate = $request->fromdate;
    $ToDate = $request->todate;

    $datas = Members::select(
        'members.Contact_person',
        'members.id as memberid',
        'members.companyname',
        'members.phonenumber',
        DB::raw("(select sum(Business.Business_amount) from Business where Business.business_type = '1' and Business.isapproved_status =1 and  Business.business_from_id = members.user_id) as DirectBuinessGiven"),
        DB::raw("(select sum(Business.Business_amount) from Business where Business.business_type = '1' and Business.isapproved_status =1 and Business.business_to_id = members.user_id) as DirectBusinessReceived"),
        DB::raw("(select sum(Business.Business_amount) from Business where Business.business_type = '2' and Business.isapproved_status=1 and Business.business_from_id = members.user_id) as RefBuinessGiven"),
        DB::raw("(select sum(Business.Business_amount) from Business where Business.business_type = '2' and Business.isapproved_status=1 and Business.business_to_id = members.user_id) as RefBusinessReceived"),
        DB::raw("(select count(*) from Reference where Reference.Reference_from = members.user_id and Reference.isapproved_status=1) as RefGiven"),
        DB::raw("(select count(*) from Reference where Reference.Reference_to = members.user_id and Reference.isapproved_status=1) as RefReceived")
    )
//     ->where('Business.isapproved_status' ,'1')
    ->when($request->fromdate, function ($query, $FromDate) {
        return $query->whereExists(function ($subQuery) use ($FromDate) {
            $subQuery->select(DB::raw(1))
                     ->from('Business')
                     ->whereRaw('Business.business_from_id = members.user_id')                    
                     ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate)));
        });
    })
    ->when($request->todate, function ($query, $ToDate) {
        return $query->whereExists(function ($subQuery) use ($ToDate) {
            $subQuery->select(DB::raw(1))
                     ->from('Business')
                     ->whereRaw('Business.business_from_id = members.user_id')
                     ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate)));
        });
    })
    ->when($request->first_name, function ($query) use ($firstname) {
        $query->where('members.Contact_person', 'LIKE', '%' . $firstname . '%');
    })
    ->paginate(env('PAR_PAGE_COUNT',20));

    $Count =$datas->count();
    return view('reports.BusinessAnalysis', compact('Count','datas','firstname','FromDate','ToDate'));
}
// Business Analysisi export to excle 
public function BusinessexportToexcel(Request $request, $fromdate = null, $todate = null, $first_name = null)
{

    $firstname = $request->first_name;
    $FromDate = $request->fromdate;
    $ToDate = $request->todate;

    $datas = Members::select(
        'members.Contact_person',
        'members.companyname',
        'members.phonenumber',
        DB::raw("(select sum(Business.Business_amount) from Business where Business.business_type = '1' and Business.business_from_id = members.user_id) as DirectBuinessGiven"),
        DB::raw("(select sum(Business.Business_amount) from Business where Business.business_type = '1' and Business.business_to_id = members.user_id) as DirectBusinessReceived"),
        DB::raw("(select sum(Business.Business_amount) from Business where Business.business_type = '2' and Business.business_from_id = members.user_id) as RefBuinessGiven"),
        DB::raw("(select sum(Business.Business_amount) from Business where Business.business_type = '2' and Business.business_to_id = members.user_id) as RefBusinessReceived"),
        DB::raw("(select count(*) from Reference where Reference.Reference_from = members.user_id) as RefGiven"),
        DB::raw("(select count(*) from Reference where Reference.Reference_to = members.user_id) as RefReceived")
    )
    ->when($request->fromdate, function ($query, $FromDate) {
        return $query->whereExists(function ($subQuery) use ($FromDate) {
            $subQuery->select(DB::raw(1))
                     ->from('Business')
                     ->whereRaw('Business.business_from_id = members.user_id')                    
                     ->where('Business.business_Date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate)));
        });
    })
    ->when($request->todate, function ($query, $ToDate) {
        return $query->whereExists(function ($subQuery) use ($ToDate) {
            $subQuery->select(DB::raw(1))
                     ->from('Business')
                     ->whereRaw('Business.business_from_id = members.user_id')
                     ->where('Business.business_Date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate)));
        });
    })
    ->when($request->first_name, function ($query) use ($firstname) {
        $query->where('members.Contact_person', 'LIKE', '%' . $firstname . '%');
    })
    ->paginate(env('PAR_PAGE_COUNT',20));

    return view('reports.businessexportdata', compact('datas', 'firstname', 'ToDate', 'FromDate'));
}

//upcoming renewal report

public function upcomingrenual(Request $request)
{

$firstname = $request->first_name;
$FromDate = $request->fromdate;
$ToDate = $request->todate;
//dd($firstname);

$cities = City::select('id', 'city_name')->get();
$cityGroups = City_group::select('id', 'group_name')->get();
$categories = Categories::select('id', 'name')->get();
$subcategories = Subcategories::select('id', 'name')->get();
$plans = Membershipplans::select('id', 'plan_name')->get();

// Subquery to get latest renewal per member
$latestRenewalSub = DB::table('renewal_history as rh1')
    ->select('rh1.member_id', 'rh1.plan_id', 'rh1.renewal_date', 'rh1.paymentrefNo', 'rh1.substartdate')
    ->whereRaw('rh1.id = (select max(rh2.id) from renewal_history as rh2 where rh2.member_id = rh1.member_id)');

$datas = Members::select(
    'members.*',
    'users.id as user_id',
    'city.id as city_id',
    'city_groups.id as citygroup_id',
    'categories.id as category_id',
    'categories.name as category_name',
    'city.city_name',
    'city_groups.group_name',
    'users.first_name',
    'latest_renewal.plan_id',
    'latest_renewal.renewal_date',
    'latest_renewal.paymentrefNo',
    'latest_renewal.substartdate',
    'membership_plans.plan_name',
    'membership_plans.amount'
)
->join('city', 'members.city_id', '=', 'city.id')
->join('city_groups', 'members.citygroup_id', '=', 'city_groups.id')
->join('categories', 'members.category_id', '=', 'categories.id')
->join('users', 'users.id', '=', 'members.user_id')
->leftJoinSub($latestRenewalSub, 'latest_renewal', function ($join) {
    $join->on('latest_renewal.member_id', '=', 'members.id');
})
->leftJoin('membership_plans', 'membership_plans.id', '=', 'latest_renewal.plan_id')
->where([
    ['members.iStatus', '=', 1],
    ['members.isDelete', '=', 0]
])
->whereMonth('members.SubscriptionExpiredDate', '=', Carbon::now()->month)
->whereYear('members.SubscriptionExpiredDate', '=', Carbon::now()->year)
->when($request->fromdate, function ($query, $fromDate) {
    return $query->where('members.created_at', '>=', Carbon::parse($fromDate)->startOfDay());
})
->when($request->todate, function ($query, $toDate) {
    return $query->where('members.created_at', '<=', Carbon::parse($toDate)->endOfDay());
})
->when($request->first_name, function ($query) use ($request) {
    return $query->where('users.first_name', 'LIKE', '%' . $request->first_name . '%');
})
->paginate(env('PAR_PAGE_COUNT',20));


$Count = $datas->count();

return view('reports.upcomingrenual', compact('Count','cities', 'cityGroups', 'categories', 'subcategories', 'plans', 'datas','firstname','FromDate','ToDate'));
}


// 30-7-25



public function Member_reports_detail(Request $request, $id = null)
{
    $getmemberid = DB::table('members')->where('id', $id)->first();

    $datas = DB::table('Business')
        ->where('business_type', '1')
        ->where('business_from_id', $getmemberid->user_id)
        ->where('isapproved_status', 1) // Only approved records
        ->when($request->fromdate, function ($query, $from) {
            return $query->where('business_Date', '>=', date('Y-m-d 00:00:00', strtotime($from)));
        })
        ->when($request->todate, function ($query, $to) {
            return $query->where('business_Date', '<=', date('Y-m-d 23:59:59', strtotime($to)));
        })
        ->paginate(50);

    $Count = $datas->total();

    return view('reports.Member_reports_detail', compact('datas', 'Count', 'getmemberid'));
}

public function DirectBuiness_Given(Request $request, $id = null)
{
    $getmemberid = DB::table('members')->where('id', $id)->first();

    $datas = DB::table('Business')
        ->where('business_type', '1')
        ->where('business_to_id', $getmemberid->user_id)
        ->where('isapproved_status', 1) // Only approved records
        ->when($request->fromdate, function ($query, $from) {
            return $query->where('business_Date', '>=', date('Y-m-d 00:00:00', strtotime($from)));
        })
        ->when($request->todate, function ($query, $to) {
            return $query->where('business_Date', '<=', date('Y-m-d 23:59:59', strtotime($to)));
        })
        ->paginate(50);

    $Count = $datas->total();

    return view('reports.business_received', compact('datas', 'Count', 'getmemberid'));
}

public function RefBusiness_given(Request $request, $id = null)
{
    $getmemberid = DB::table('members')->where('id', $id)->first();

    $datas = DB::table('Business')
        ->where('business_type', '2')
        ->where('business_from_id', $getmemberid->user_id)
        ->where('isapproved_status', 1) //  Only approved records
        ->when($request->fromdate, function ($query, $from) {
            return $query->where('business_Date', '>=', date('Y-m-d 00:00:00', strtotime($from)));
        })
        ->when($request->todate, function ($query, $to) {
            return $query->where('business_Date', '<=', date('Y-m-d 23:59:59', strtotime($to)));
        })
        ->paginate(50);

    $Count = $datas->total();

    return view('reports.refbusiness_given', compact('datas', 'Count', 'getmemberid'));
}

public function RefBusiness_Received(Request $request, $id = null)
{
    $getmemberid = DB::table('members')->where('id', $id)->first();

    $datas = DB::table('Business')
        ->where('business_type', '2')
        ->where('business_to_id', $getmemberid->user_id)
        ->where('isapproved_status', 1) // Only approved records
        ->when($request->fromdate, function ($query, $from) {
            return $query->where('business_Date', '>=', date('Y-m-d 00:00:00', strtotime($from)));
        })
        ->when($request->todate, function ($query, $to) {
            return $query->where('business_Date', '<=', date('Y-m-d 23:59:59', strtotime($to)));
        })
        ->paginate(50);

    $Count = $datas->total();

    return view('reports.refbusiness_received', compact('datas', 'Count', 'getmemberid'));
}


}
