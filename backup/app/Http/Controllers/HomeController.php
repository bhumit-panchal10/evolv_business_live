<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\City_group;
use App\Models\Categories;
use App\Models\subcategories;
use App\Models\membershipplans;
use App\Models\Business;
use App\Models\Reference;
use App\Models\members;
use App\Models\renewalhistory;
use App\Models\Adminuserpermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Session;
use Carbon\Carbon;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   


    public function index(Request $request)
    {

   
        $session = Auth::user();
        $permissions = AdminuserPermission::where('user_id', $session->id)->first();
        $request->session()->put('permission_id', $permissions->permission_id ?? null);
        $request->session()->put('user_id', $permissions->user_id ?? null);
        $request->session()->put('city', $permissions->city ?? null);
        $request->session()->put('city_group', $permissions->city_group ?? null);
        $request->session()->put('categories', $permissions->categories ?? null);
        $request->session()->put('membershipplans', $permissions->membershipplans ?? null);
        $request->session()->put('overteem', $permissions->overteem ?? null);
        $request->session()->put('Banner', $permissions->Banner ?? null);
        $request->session()->put('members', $permissions->members ?? null);
        $request->session()->put('Products_service', $permissions->Products_service ?? null);
        $request->session()->put('Renewalhistory', $permissions->Renewalhistory ?? null);
        $request->session()->put('Business', $permissions->Business ?? null);
        $request->session()->put('reports', $permissions->reports ?? null);
        $request->session()->put('Adminuser', $permissions->Adminuser ?? null);
        $request->session()->put('Blog', $permissions->Blog ?? null);
        $request->session()->put('gallery', $permissions->gallery ?? null);
        $request->session()->put('videogallery', $permissions->videogallery ?? null);
        $request->session()->put('Event', $permissions->Event ?? null);  
        $request->session()->put('Utility', $permissions->Utility ?? null); 
        $request->session()->put('MasterEntry', $permissions->MasterEntry ?? null);        
        $request->session()->put('BannerImage', $permissions->BannerImage ?? null); 
        $request->session()->put('RegisterInquiry', $permissions->RegisterInquiry ?? null);        
        $request->session()->put('ContactInquiry', $permissions->ContactInquiry ?? null);        
        $request->session()->put('EventInquiry', $permissions->EventInquiry ?? null);        
        $formatter = new \NumberFormatter('en_IN', \NumberFormatter::CURRENCY);
        if($session->role_id == 1 || $session->role_id == 3)
        {
             $Product = 0;
             $Financed = 0;
             $NonFinanced = 0;
             $upcoming =0;
             $active = 0;
             $approvecount=0;
             $pending =0;
             $rejectedcount =0;
             $subexpricount =0;
             $currentMonth = Carbon::now()->month;
             $currentYear = Carbon::now()->year;
             
             $currentDate = now()->toDateString(); 
            $Subscriptionexpri = DB::table('members')
                ->where('SubscriptionExpiredDate', '<=', $currentDate)
                ->where(['members.iStatus' => 1, 'members.isDelete' => 0])
                ->get();
                
                $members = members::whereMonth('SubscriptionExpiredDate', now()->month)
                ->whereYear('SubscriptionExpiredDate', now()->year)
                ->whereDate('SubscriptionExpiredDate', '>=', $currentDate)
                ->where(['members.iStatus' => 1, 'members.isDelete' => 0])
                ->get(); 
                
            $upcoming = $members->count();  
            $users = User::leftjoin('members', 'members.user_id', '=', 'users.id')
                ->where('users.status', 1)
                ->where('users.role_id', 2)
                ->where('members.arrival_flag', 0)
                ->select('users.*', 'members.arrival_flag')
                ->get();
            $business = Business::where('isapproved_status', 0)->get();
            $approve = Business::where('isapproved_status', 1)->get();
            $rejected = Business::where('isapproved_status', 2)->get();
            $active = $users->count();  
            $pending =$business->count();
            $approvecount =$approve->count();
            $rejectedcount =$rejected->count(); 
            $subexpricount = $Subscriptionexpri->count();
            
            
            $pendingamount = Business::where('iStatus', 1)
            ->where('isDelete', 0)
            ->where('isapproved_status', 0)
         //   ->whereMonth('created_at', $currentMonth)
         //   ->whereYear('created_at', $currentYear)
            ->get();

            $approveamount = Business::where('iStatus', 1)
            ->where('isDelete', 0)
            ->where('isapproved_status', 1)
         //   ->whereMonth('created_at', $currentMonth)
          //  ->whereYear('created_at', $currentYear)
            ->get();

            $rejectedamount = Business::where('iStatus', 1)
            ->where('isDelete', 0)
            ->where('isapproved_status', 2)
         //   ->whereMonth('created_at', $currentMonth)
           // ->whereYear('created_at', $currentYear)
            ->get();

            $totalpendingamount = $pendingamount->sum('Business_amount');
            $totalapproveamount = $approveamount->sum('Business_amount');
            $totalrejectedamount = $rejectedamount->sum('Business_amount');

            //payment report amountcount code start
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
                DB::raw('(select users.first_name from users where users.id = members.user_id order by users.id desc limit 1) as user_id'),
                DB::raw('(select renewal_history.plan_id from renewal_history where renewal_history.member_id = members.id order by renewal_history.id desc limit 1) as plan_id'),
                DB::raw('(select renewal_history.renewal_date from renewal_history where renewal_history.member_id = members.id order by renewal_history.id desc limit 1) as renewal_date'),
                DB::raw('(select renewal_history.paymentrefNo from renewal_history where renewal_history.member_id = members.id order by renewal_history.id desc limit 1) as paymentrefNo'),
                'membership_plans.plan_name','membership_plans.amount' 
            )
            ->join('city', 'members.city_id', '=', 'city.id')
            ->join('city_groups', 'members.citygroup_id', '=', 'city_groups.id')
            ->join('categories', 'members.category_id', '=', 'categories.id')
            ->join('renewal_history', 'renewal_history.member_id', '=', 'members.id')
            ->join('membership_plans', 'membership_plans.id', '=', 'renewal_history.plan_id') 
            ->join('users', 'users.id', '=', 'members.user_id')
            ->where(['members.iStatus' => 1, 'members.isDelete' => 0])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
            ->where('renewal_history.renewal_date', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
            ->where('renewal_history.renewal_date', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
            ->when($request->first_name, function ($query) use ($firstname) {
                $query->where('users.first_name', 'LIKE', '%' . $firstname . '%');
            })
            ->get();
            $paymenttotal = $datas->sum('amount');
          
       

        //new code start
        $businessData = [
            'totalGiven' => DB::table('Business')
            ->where('Business.business_type', 1)
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->whereIn('isapproved_status', [1])
            ->sum('Business_amount'),
   
             'totalReceived' => DB::table('Business')
             ->where('Business.business_type', 2)
             ->where('iStatus', 1)
             ->where('isDelete', 0)
             ->whereIn('isapproved_status', [1])
             ->sum('Business_amount'),
     
        ];
   
//         $given_data = Business::selectRaw('business_id, YEAR(business_Date) as year, MONTHNAME(business_Date) as month, SUM(Business_amount) as total_given')
//         ->where('business_type', 1)
//         ->where('iStatus', 1)
//         ->where('isDelete', 0)
//         ->where('isapproved_status', 1)
//   //     ->whereYear('business_Date', now()->year)
//         ->groupByRaw('YEAR(business_Date), MONTH(business_Date)')
//         ->orderByRaw('YEAR(business_Date) ASC, MONTH(business_Date) ASC')
//         ->get()
//         ->toArray();
     
     
    // $Received_data = 
    //             Business::selectRaw('business_id, YEAR(business_Date) as year, MONTHNAME(business_Date) as month, SUM(Business_amount) as total_received')
    //             ->where('Business.business_type', 2)
    //             ->where('iStatus', 1)
    //             ->where('isDelete', 0)
    //             ->whereIn('isapproved_status', [1])
    //             ->groupByRaw('MONTHNAME(business_Date), YEAR(business_Date)')
    //             ->orderBy('business_Date', 'asc')
    //             ->get()->toArray();
                

          
            // $combined_data = [];

            // // Process given data
            // foreach ($given_data as $data) {
            //     $year = $data['year'];
            //     $month = $data['month'];
            //     $total_given = $data['total_given'];
                
            //     // Ensure the combined data array has the year and month
            //     if (!isset($combined_data[$year])) {
            //         $combined_data[$year] = [];
            //     }
            //     if (!isset($combined_data[$year][$month])) {
            //         $combined_data[$year][$month] = ['total_given' => 0, 'total_received' => 0];
            //     }
                
            //     // Add the total_given to the combined array
            //     $combined_data[$year][$month]['total_given'] = $total_given;
            // }
            
            // // Process received data
            // foreach ($Received_data as $data) {
            //     $year = $data['year'];
            //     $month = $data['month'];
            //     $total_received = $data['total_received'];
                
            //     // Ensure the combined data array has the year and month
            //     if (!isset($combined_data[$year])) {
            //         $combined_data[$year] = [];
            //     }
            //     if (!isset($combined_data[$year][$month])) {
            //         $combined_data[$year][$month] = ['total_given' => 0, 'total_received' => 0];
            //     }
                
            //     // Add the total_received to the combined array
            //     $combined_data[$year][$month]['total_received'] = $total_received;
            // }
            
            // // If you need the data in a specific format, you can convert the associative array to a list of objects or arrays
            
            // $formatted_combined_data = [];
            
            // foreach ($combined_data as $year => $months) {
            //     foreach ($months as $month => $totals) {
            //         $formatted_combined_data[] = [
            //             'year' => $year,
            //             'month' =>  $month,
            //             'total_given' => $totals['total_given'],
            //             'total_received' => $totals['total_received']
            //         ];
            //     }
            // }
            
            
             # < ========================== last 12 months recode get Business Growth chart new =========================>

            $start = Carbon::now()->startOfMonth()->subMonths(11);
            $end   = Carbon::now()->endOfMonth();
            // Fetch given data
            $given_data = Business::selectRaw("
                DATE_FORMAT(business_Date, '%Y-%m') as ym,
                SUM(Business_amount) as total_given
            ")
                ->where('business_type', 1)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->where('isapproved_status', 1)
                ->whereBetween('business_Date', [$start, $end])
                ->groupBy('ym')
                ->orderBy('ym', 'asc')
                ->get()
                ->keyBy('ym')
                ->toArray();

            // Fetch received data
            $received_data = Business::selectRaw("
                DATE_FORMAT(business_Date, '%Y-%m') as ym,
                SUM(Business_amount) as total_received
            ")
                ->where('business_type', 2)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->where('isapproved_status', 1)
                ->whereBetween('business_Date', [$start, $end])
                ->groupBy('ym')
                ->orderBy('ym', 'asc')
                ->get()
                ->keyBy('ym')
                ->toArray();

            // Build rolling 12 months
            $monthsList = [];
            for ($i = 0; $i < 12; $i++) {
                $m = $start->copy()->addMonths($i);
                $ym = $m->format('Y-m');

                $monthsList[$ym] = [
                    'year' => (int)$m->format('Y'),
                    'month' => $m->format('F'),
                    'total_given' => isset($given_data[$ym]['total_given']) ? (int)$given_data[$ym]['total_given'] : 0,
                    'total_received' => isset($received_data[$ym]['total_received']) ? (int)$received_data[$ym]['total_received'] : 0,
                ];
            }
            $formatted_combined_data = array_values($monthsList);

            # <=====================last 12 months recode get Business Growth chart end ===========================> 
    
                //Month Top 3 Business Receiver & Giver code 
                // $BusinesscurrentMonth = Carbon::now()->month;
                $BusinesscurrentMonth = Carbon::now()->startOfMonth()->subMonth()->month;
                $monthname =  date("F", mktime(0, 0, 0, $BusinesscurrentMonth, 1));
                if ($BusinesscurrentMonth == '12') {
                    $BusinesscurrentYear = Carbon::now()->subYear()->year;
                } else {
                    $BusinesscurrentYear = Carbon::now()->year;
                }
                // Top receivers in the current month and year
                // new start
                $topDirect = Business::select('Business.business_from', 'members.companyname', DB::raw('SUM(Business_amount) as total_amount'))
                ->leftjoin('members', 'members.user_id', '=', 'Business.business_from_id')
                ->whereYear('business_Date', $BusinesscurrentYear)
                ->whereMonth('business_Date', $BusinesscurrentMonth)
                ->where('Business.business_type', 1)
                ->where('Business.isapproved_status', 1)
                ->where('Business.iStatus', 1)
                ->where('Business.isDelete', 0)
                ->where('Business.business_from_id', '!=', 121)
                ->where('Business.business_from_id', '!=', 137)
                ->groupBy('business_from_id')
                ->orderByDesc('total_amount')
                ->limit(3)
                ->get();
          
               
               $topReference = Business::select('Business.business_from', 'members.companyname', DB::raw('SUM(Business_amount) as total_amount'))
               ->join('members', 'members.user_id', '=', 'Business.business_from_id')
               ->whereYear('business_Date', $BusinesscurrentYear)
               ->whereMonth('business_Date', $BusinesscurrentMonth)
               ->where('Business.business_type', 2)
               ->where('Business.isapproved_status', 1)
               ->where('Business.iStatus', 1)
               ->where('Business.isDelete', 0)
               ->where('Business.business_from_id', '!=', 121)
               ->where('Business.business_from_id', '!=', 137)
               ->groupBy('business_from_id')
               ->orderByDesc('total_amount')
               ->limit(3)
               ->get();
               //new end
               $Top_Reference_Givers = DB::table('Reference')
               ->select('Reference_from','members.Contact_person','members.companyname', DB::raw('count(*) as total_references'))
               ->leftjoin('members', 'members.user_id', '=', 'Reference.Reference_from')
               ->whereYear('Reference_Date', $BusinesscurrentYear)
               ->whereMonth('Reference_Date', $BusinesscurrentMonth)
               ->where('Reference.isapproved_status', 1)
               ->where('Reference.iStatus', 1)
               ->where('Reference.isDelete', 0)
               ->where('Reference.Reference_from', '!=', 121)
               ->where('Reference.Reference_from', '!=', 137)
               ->groupBy('Reference_from')
               ->orderByDesc('total_references')
               ->limit(3)
               ->get();
            
            $TopReferenceGivers =$Top_Reference_Givers->count();
      
            $Metting_member =DB::table('members')->where('user_id',$session->id)->first();
            $MettingcurrentDate = Carbon::now()->format('d-m-Y');
            $meetings = DB::table('Cluster_Meet')
            ->select('Cluster_Meet.*', DB::raw('GROUP_CONCAT(mm.member_id) AS member_ids'), DB::raw('COUNT(mm.member_id) AS member_count'))
            ->join('Cluster_Meet_Member_meeting AS mm', 'mm.meeting_id', '=', 'Cluster_Meet.id')
            ->whereRaw("STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %H:%i') >= ?", [Carbon::today()->format('Y-m-d')])
            ->groupBy('Cluster_Meet.id')
            ->orderByRaw("STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %T') ASC")
            ->get();

         
            return view('home', compact('monthname','meetings','upcoming', 'Financed', 'active','pending','approvecount','rejectedcount','subexpricount','permissions','totalpendingamount','totalapproveamount','totalrejectedamount','paymenttotal','businessData','topDirect','topReference','formatted_combined_data','Top_Reference_Givers','TopReferenceGivers')); 

        }else
        {

            $user = Auth::user();
            $loginPendingCheck = Business::join('users', 'users.id', '=', 'Business.business_to_id')
            ->where('users.id', $user->id)
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 0])
            ->orderBy('Business.business_id', 'DESC')
            ->get();
            if (!$loginPendingCheck->isEmpty()) 
            {
                 return redirect()->route('pendinglogincheck.index');
            } 
            
          $session =Auth::user();
          $Product = 0;
          $Financed = 0;
          $NonFinanced = 0;
          $upcoming =0;
          $active = 0;
          $business=0;   
          $currentDate = now()->toDateString(); 
          $members = members::whereMonth('SubscriptionExpiredDate', now()->month)
          ->whereYear('SubscriptionExpiredDate', now()->year)
          ->whereDate('SubscriptionExpiredDate', '>=', $currentDate)
          ->where([
              'members.iStatus' => 1,
              'members.isDelete' => 0,
              'members.user_id' => $session->id,   
          ])
          ->get();
          
          // CHECK MEMBERSHIP PLAN IS EXPRIED 
            $expiredMember = Members::where([
                'iStatus' => 1,
                'isDelete' => 0,
                'user_id' => $session->id
            ])->first();
            if ($expiredMember) {
                $subscriptionExpiredDate = $expiredMember->SubscriptionExpiredDate;
                $currentDate = now();
                if ($currentDate->greaterThanOrEqualTo($subscriptionExpiredDate)) {
                    auth()->logout(); 
                    return redirect()->route('Frontfront-login')->with('error', 'Your subscription has expired. Please login to renew your plan.');
                    // return view('frontlogout');
                }
            }
            // CHECK MEMBERSHIP END CODE  
        
          $upcoming = $members->count();  
          $users = User::where(['status' => 1, 'role_id' => 1])->get();
            $business = Business::join('users', 'users.id', '=', 'Business.business_from_id')
            ->where('users.id', $session->id)
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 0])
            ->orderBy('Business.business_id', 'DESC')
            ->get();

            $approve = Business::join('users', 'users.id', '=', 'Business.business_from_id')
            ->where('users.id', $session->id)
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 1])
            ->sum('Business.Business_amount');
         
            $Received_bussiness = Business::join('users', 'users.id', '=', 'Business.business_to_id')
            ->where('users.id', $session->id)
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 1])
            ->sum('Business.Business_amount');

            $rejected = Business::join('users', 'users.id', '=', 'Business.business_from_id')
            ->where('users.id', $session->id)
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isapproved_status' => 2])
            ->orderBy('Business.business_id', 'DESC')
            ->get();
               
                $active = $users->count();  
                $pending =$business->count();
                $approvecount =$approve;
                $rejectedcount =$rejected->count(); 
                
        // form given chart logic code create start  
            $businessData = [
                'totalGiven' => DB::table('Business')
                    ->leftjoin('users', 'users.id', '=', 'Business.business_from_id')
                    ->where('users.id', $session->id)
                    ->where('Business.business_type', 1)
                    ->where('iStatus', 1)
                    ->where('isDelete', 0)
                    ->whereIn('isapproved_status', [1])
                    ->sum('Business_amount'),

                'totalReceived' => DB::table('Business')
                    ->join('users', 'users.id', '=', 'Business.business_from_id')
                    ->where('users.id', $session->id)
                    ->where('Business.business_type', 2)
                    ->where('iStatus', 1)
                    ->where('isDelete', 0)
                    ->whereIn('isapproved_status', [1])
                    ->sum('Business_amount'),
            ];

            // $given_data = Business::selectRaw('business_id, YEAR(business_Date) as year, MONTHNAME(business_Date) as month, SUM(Business_amount) as total_given')
            //     ->leftjoin('users', 'users.id', '=', 'Business.business_from_id')
            //     ->where('users.id', $session->id)
            //     ->where('Business.business_type', 1)
            //     ->where('iStatus', 1)
            //     ->where('isDelete', 0)
            //     ->whereIn('isapproved_status', [1])
            //     ->groupByRaw('MONTHNAME(business_Date), YEAR(business_Date) ')
            //     ->orderBy('business_id', 'asc')
            //     ->get()
            //     ->toArray();


            // $Received_data = Business::selectRaw('business_id, YEAR(business_Date) as year, MONTHNAME(business_Date) as month, SUM(Business_amount) as total_received')
            //     ->join('users', 'users.id', '=', 'Business.business_from_id')
            //     ->where('users.id', $session->id)
            //     ->where('Business.business_type', 2)
            //     ->where('iStatus', 1)
            //     ->where('isDelete', 0)
            //     ->whereIn('isapproved_status', [1])
            //     ->groupByRaw('MONTHNAME(business_Date), YEAR(business_Date)')
            //     ->orderBy('business_id', 'asc')
            //     ->get()
            //     ->toArray();

            // $combined_data = [];
            // foreach ($given_data as $data) {
            //     $year = $data['year'];
            //     $month = $data['month'];
            //     $total_given = $data['total_given'];
            //     if (!isset($combined_data[$year])) {
            //         $combined_data[$year] = [];
            //     }
            //     if (!isset($combined_data[$year][$month])) {
            //         $combined_data[$year][$month] = ['total_given' => 0, 'total_received' => 0];
            //     }
            //     $combined_data[$year][$month]['total_given'] = $total_given;
            // }
            // foreach ($Received_data as $data) {
            //     $year = $data['year'];
            //     $month = $data['month'];
            //     $total_received = $data['total_received'];

            //     if (!isset($combined_data[$year])) {
            //         $combined_data[$year] = [];
            //     }
            //     if (!isset($combined_data[$year][$month])) {
            //         $combined_data[$year][$month] = ['total_given' => 0, 'total_received' => 0];
            //     }

            //     $combined_data[$year][$month]['total_received'] = $total_received;
            // }
            // $monthOrder = [
            //     'January' => 1,
            //     'February' => 2,
            //     'March' => 3,
            //     'April' => 4,
            //     'May' => 5,
            //     'June' => 6,
            //     'July' => 7,
            //     'August' => 8,
            //     'September' => 9,
            //     'October' => 10,
            //     'November' => 11,
            //     'December' => 12,
            // ];
            // $formatted_combined_data = [];
            // foreach ($combined_data as $year => $months) {
            //     uksort($months, function ($a, $b) use ($monthOrder) {
            //         return $monthOrder[$a] <=> $monthOrder[$b];
            //     });
            //     foreach ($months as $month => $totals) {
            //         $formatted_combined_data[] = [
            //             'year' => $year,
            //             'month' => $month,
            //             'total_given' => $totals['total_given'],
            //             'total_received' => $totals['total_received']
            //         ];
            //     }
            // }

          # =========================== last  12 months chart recode ==========================

            $start = Carbon::now()->startOfMonth()->subMonths(11);
            $end   = Carbon::now()->endOfMonth();
            $given_data = Business::selectRaw("
                    DATE_FORMAT(business_Date, '%Y-%m') as ym,
                    YEAR(business_Date) as year,
                    MONTHNAME(business_Date) as month,
                    SUM(Business_amount) as total_given
                ")
                ->leftJoin('users', 'users.id', '=', 'Business.business_from_id')
                ->where('users.id', $session->id)
                ->where('Business.business_type', 1)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->whereIn('isapproved_status', [1])
                ->whereBetween('business_Date', [$start, $end])
                ->groupBy('ym', 'year', 'month')
                ->orderBy('ym', 'asc')
                ->get()
                ->toArray();

            $Received_data = Business::selectRaw("
                    DATE_FORMAT(business_Date, '%Y-%m') as ym,
                    YEAR(business_Date) as year,
                    MONTHNAME(business_Date) as month,
                    SUM(Business_amount) as total_received
                ")
                ->join('users', 'users.id', '=', 'Business.business_from_id')
                ->where('users.id', $session->id)
                ->where('Business.business_type', 2)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->whereIn('isapproved_status', [1])
                ->whereBetween('business_Date', [$start, $end])
                ->groupBy('ym', 'year', 'month')
                ->orderBy('ym', 'asc')
                ->get()
                ->toArray();
            $monthsList = [];
            for ($i = 0; $i < 12; $i++) {
                $m  = $start->copy()->addMonths($i);
                $ym = $m->format('Y-m');
                $monthsList[$ym] = [
                    'year' => (int)$m->format('Y'),
                    'month' => $m->format('F'),
                    'total_given' => 0,
                    'total_received' => 0,
                ];
            }
            foreach ($given_data as $d) {
                if (!empty($d['ym']) && isset($monthsList[$d['ym']])) {
                    $monthsList[$d['ym']]['total_given'] = (int)($d['total_given'] ?? 0);
                }
            }

            foreach ($Received_data as $d) {
                if (!empty($d['ym']) && isset($monthsList[$d['ym']])) {
                    $monthsList[$d['ym']]['total_received'] = (int)($d['total_received'] ?? 0);
                }
            }
            $formatted_combined_data = array_values($monthsList);

            # =========================== last 12 months chart recode new code =================================
         
         // To Received chart logic code start
            //   $to_given_data = Business::selectRaw('business_id, YEAR(business_Date) as year, MONTHNAME(business_Date) as month, SUM(Business_amount) as total_given')
            //         ->leftjoin('users', 'users.id', '=', 'Business.business_to_id')
            //         ->where('users.id', $session->id)
            //         ->where('Business.business_type', 1)
            //         ->where('iStatus', 1)
            //         ->where('isDelete', 0)
            //         ->whereIn('isapproved_status', [1])
            //         ->groupByRaw('MONTHNAME(business_Date), YEAR(business_Date) ')
            //         ->orderBy('business_id', 'asc')
            //         ->get()
            //         ->toArray();
    
            //     $to_Received_data = Business::selectRaw('business_id, YEAR(business_Date) as year, MONTHNAME(business_Date) as month, SUM(Business_amount) as total_received')
            //         ->join('users', 'users.id', '=', 'Business.business_to_id')
            //         ->where('users.id', $session->id)
            //         ->where('Business.business_type', 2)
            //         ->where('iStatus', 1)
            //         ->where('isDelete', 0)
            //         ->whereIn('isapproved_status', [1])
            //         ->groupByRaw('MONTHNAME(business_Date), YEAR(business_Date)')
            //         ->orderBy('business_id', 'asc')
            //         ->get()
            //         ->toArray();
    
    
            //     $to_combined_data = [];
            //     foreach ($to_given_data as $data) {
            //         $year = $data['year'];
            //         $month = $data['month'];
            //         $total_given = $data['total_given'];
            //         if (!isset($to_combined_data[$year])) {
            //             $to_combined_data[$year] = [];
            //         }
            //         if (!isset($to_combined_data[$year][$month])) {
            //             $to_combined_data[$year][$month] = ['total_given' => 0, 'total_received' => 0];
            //         }
            //         $to_combined_data[$year][$month]['total_given'] = $total_given;
            //     }
            //     foreach ($to_Received_data as $data) {
            //         $year = $data['year'];
            //         $month = $data['month'];
            //         $total_received = $data['total_received'];
    
            //         if (!isset($to_combined_data[$year])) {
            //             $to_combined_data[$year] = [];
            //         }
            //         if (!isset($to_combined_data[$year][$month])) {
            //             $to_combined_data[$year][$month] = ['total_given' => 0, 'total_received' => 0];
            //         }
            //         $to_combined_data[$year][$month]['total_received'] = $total_received;
            //     }
            //     $monthOrder = [
            //         'January' => 1,
            //         'February' => 2,
            //         'March' => 3,
            //         'April' => 4,
            //         'May' => 5,
            //         'June' => 6,
            //         'July' => 7,
            //         'August' => 8,
            //         'September' => 9,
            //         'October' => 10,
            //         'November' => 11,
            //         'December' => 12,
            //     ];
            //     $to_formatted_combined_data = [];
            //     foreach ($to_combined_data as $year => $months) {
            //         // Sort the months based on the defined order
            //         uksort($months, function ($a, $b) use ($monthOrder) {
            //             return $monthOrder[$a] <=> $monthOrder[$b];
            //         });
    
            //         // Format the sorted data
            //         foreach ($months as $month => $totals) {
            //             $to_formatted_combined_data[] = [
            //                 'year' => $year,
            //                 'month' => $month,
            //                 'total_given' => $totals['total_given'],
            //                 'total_received' => $totals['total_received']
            //             ];
            //         }
            //     }
         // To Received chart logic code end 
         
      # ================= last 12 months based data start to given start==========================
            $start = Carbon::now()->startOfMonth()->subMonths(11);
            $end   = Carbon::now()->endOfMonth();

            // ✅ TO DIRECT (business_to_id, type=1)
            $to_given_data = Business::selectRaw("
                DATE_FORMAT(business_Date, '%Y-%m') as ym,
                YEAR(business_Date) as year,
                MONTHNAME(business_Date) as month,
                SUM(Business_amount) as total_given
            ")
                ->leftJoin('users', 'users.id', '=', 'Business.business_to_id')
                ->where('users.id', $session->id)
                ->where('Business.business_type', 1)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->whereIn('isapproved_status', [1])
                ->whereBetween('business_Date', [$start, $end])
                ->groupBy('ym', 'year', 'month')
                ->orderBy('ym', 'asc')
                ->get()
                ->toArray();

            // ✅ TO REFERENCE (business_to_id, type=2)
            $to_Received_data = Business::selectRaw("
                DATE_FORMAT(business_Date, '%Y-%m') as ym,
                YEAR(business_Date) as year,
                MONTHNAME(business_Date) as month,
                SUM(Business_amount) as total_received
            ")
                ->leftjoin('users', 'users.id', '=', 'Business.business_to_id')
                ->where('users.id', $session->id)
                ->where('Business.business_type', 2)
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->whereIn('isapproved_status', [1])
                ->whereBetween('business_Date', [$start, $end])
                ->groupBy('ym', 'year', 'month')
                ->orderBy('ym', 'asc')
                ->get()
                ->toArray();

            // ✅ skeleton 12 months (handles year change + missing months)
            $to_monthsList = [];
            for ($i = 0; $i < 12; $i++) {
                $m  = $start->copy()->addMonths($i);
                $ym = $m->format('Y-m');
                $to_monthsList[$ym] = [
                    'year' => (int)$m->format('Y'),
                    'month' => $m->format('F'),
                    'total_given' => 0,
                    'total_received' => 0,
                ];
            }

            // fill given
            foreach ($to_given_data as $d) {
                if (!empty($d['ym']) && isset($to_monthsList[$d['ym']])) {
                    $to_monthsList[$d['ym']]['total_given'] = (int)($d['total_given'] ?? 0);
                }
            }

            // fill received
            foreach ($to_Received_data as $d) {
                if (!empty($d['ym']) && isset($to_monthsList[$d['ym']])) {
                    $to_monthsList[$d['ym']]['total_received'] = (int)($d['total_received'] ?? 0);
                }
            }
            $to_formatted_combined_data = array_values($to_monthsList);

            // ================================ last 12 months of data =========================  
       
        // Reference count code
            $Reference_Given = Reference::join('users', 'users.id', '=', 'Reference.Reference_from')
            ->join('users as to_user', 'to_user.id', '=', 'Reference.Reference_to')
            ->where('users.id', $session->id)
            ->where([
                'iStatus' => 1,
                'isDelete' => 0
            ])
            ->orderBy('Reference.Reference_id', 'DESC')
            ->count();
         //dd($Reference_Given);
            $Reference_Received = Reference::join('users', 'users.id', '=', 'Reference.Reference_to')
            ->join('users as to_user', 'to_user.id', '=', 'Reference.Reference_from')
            ->where('users.id', $session->id)
            ->where([
                'iStatus' => 1,
                'isDelete' => 0
            ])
            ->whereIn('isapproved_status', [1])
            ->orderBy('Reference.Reference_id', 'DESC')
            ->count();
            // member book podcast date get code start
            $bookspodcast = Members::where('user_id', $session->id)->get();
          
        $BusinesscurrentMonth = Carbon::now()->startOfMonth()->subMonth()->month;
        $monthname =  date("F", mktime(0, 0, 0, $BusinesscurrentMonth, 1));
        if ($BusinesscurrentMonth == '12') {
                $BusinesscurrentYear = Carbon::now()->subYear()->year;
        } else {
                $BusinesscurrentYear = Carbon::now()->year;
        }
        //$BusinesscurrentYear = Carbon::now()->subYear()->year;
        // $BusinesscurrentMonth = Carbon::now()->month;
        //$BusinesscurrentYear = Carbon::now()->year; 
         // Top receivers in the current month and year


         $topDirect = Business::select('Business.business_from', 'members.companyname', DB::raw('SUM(Business_amount) as total_amount'))
         ->leftjoin('members', 'members.user_id', '=', 'Business.business_from_id')
         ->whereYear('business_Date', $BusinesscurrentYear)
         ->whereMonth('business_Date', $BusinesscurrentMonth)
         ->where('Business.business_type', 1)
         ->where('Business.isapproved_status', 1)
         ->where('Business.iStatus', 1)
         ->where('Business.isDelete', 0)
         ->where('Business.business_from_id', '!=', 121)
         ->where('Business.business_from_id', '!=', 137)
         ->groupBy('business_from_id')
         ->orderByDesc('total_amount')
         ->limit(3)
         ->get();
   
        
        $topReference = Business::select('Business.business_from', 'members.companyname', DB::raw('SUM(Business_amount) as total_amount'))
        ->join('members', 'members.user_id', '=', 'Business.business_from_id')
        ->whereYear('business_Date', $BusinesscurrentYear)
        ->whereMonth('business_Date', $BusinesscurrentMonth)
        ->where('Business.business_type', 2)
        ->where('Business.isapproved_status', 1)
        ->where('Business.iStatus', 1)
        ->where('Business.isDelete', 0)
        ->where('Business.business_from_id', '!=', 121)
        ->where('Business.business_from_id', '!=', 137)
        ->groupBy('business_from_id')
        ->orderByDesc('total_amount')
        ->limit(3)
        ->get();

        $Top_Reference_Givers = DB::table('Reference')
            ->select('Reference_from','members.Contact_person','members.companyname', DB::raw('count(*) as total_references'))
            ->leftjoin('members', 'members.user_id', '=', 'Reference.Reference_from')
            ->whereYear('Reference_Date', $BusinesscurrentYear)
            ->whereMonth('Reference_Date', $BusinesscurrentMonth)
            ->where('Reference.isapproved_status', 1)
            ->where('Reference.Reference_from', '!=', 121)
            ->where('Reference.Reference_from', '!=', 137)
            ->where('Reference.iStatus', 1)
            ->where('Reference.isDelete', 0)
            ->groupBy('Reference_from')
            ->orderByDesc('total_references')
            ->limit(3)
            ->get();
        
        $TopReferenceGivers =$Top_Reference_Givers->count();
        $topDirectcount =$topDirect->count();
        $topReferencecount =$topReference->count();
        //search option code in member user 
        $search = DB::table('categories')
        ->select('categories.id', 'categories.name')
        ->where(['iStatus' => 1, 'isDelete' => 0])
        ->get(); 
 
        $Metting_member =DB::table('members')->where('user_id',$session->id)->first();
        $MettingcurrentDate = Carbon::now()->format('d-m-Y');
        
        $pastMeetings = DB::table('Cluster_Meet')
            ->join('Cluster_Meet_Member_meeting as mm', 'mm.meeting_id', '=', 'Cluster_Meet.id')
            ->select('Cluster_Meet.*', 'mm.*', DB::raw("DATE_FORMAT(STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y'), '%d-%m-%Y') as formatted_date"))
            ->where('mm.member_id', $Metting_member->id)
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y'), '%d-%m-%Y')"), '<', $MettingcurrentDate)
            ->orderBy(DB::raw("STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %T')"), 'ASC')
            ->get();
        
        $upcomingMeetings = DB::table('Cluster_Meet')
        ->join('Cluster_Meet_Member_meeting as mm', 'mm.meeting_id', '=', 'Cluster_Meet.id')
        ->select('Cluster_Meet.*', 'mm.*', 
            DB::raw("DATE_FORMAT(STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y'), '%d-%m-%Y') as formatted_date"))
        ->where('mm.member_id', $Metting_member->id)
        ->where(DB::raw("STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y')"), '>=', DB::raw("CURDATE()"))
        ->orderBy(DB::raw("STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y')"), 'ASC')
        ->get();
        
        $previousMeetings = DB::table('Cluster_Meet')
                ->select(
                    'Cluster_Meet.*',
                    DB::raw('GROUP_CONCAT(mm.member_id) AS member_ids'),
                    DB::raw('COUNT(mm.member_id) AS member_count')
                )
                ->join('Cluster_Meet_Member_meeting AS mm', 'mm.meeting_id', '=', 'Cluster_Meet.id')
                ->where('mm.member_id', $Metting_member->id)
                ->whereRaw("STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %H:%i') < ?", [Carbon::today()->format('Y-m-d')])
                ->groupBy('Cluster_Meet.id')
                ->orderByRaw("STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %T') DESC")
                ->get();
        // $meetings = $upcomingMeetings->merge($pastMeetings);
        $meetings = $upcomingMeetings;
        $meetingscount =$meetings->count();
        $Announcement =DB::table('Announcement')->first();
       
            return view('Memberhome', compact('previousMeetings','formatted_combined_data','to_formatted_combined_data','monthname','Announcement','meetingscount','Received_bussiness','topReferencecount','topDirectcount','upcoming', 'Financed', 'active','pending','approvecount','rejectedcount','members','businessData','Reference_Received','Reference_Given','bookspodcast','topDirect','topReference','search','meetings','TopReferenceGivers','Top_Reference_Givers')); 
        }
    }

    /**
     * User Profile
     * @param Nill
     * @return View Profile
     * @author Shani Singh
     */
    public function getProfile()
    {
        $sessionrole = Auth::user();
        $session = Auth::user()->id;
       // access only admin and adminuser and else member user
        if($sessionrole->role_id == 1 || $sessionrole->role_id == 3){
            // dd('call admin');
        $users = User::where('users.id',  $session)->first();
        return view('profile', compact('users'));
        }else{    
           
            $users = User::where('users.id',  $session)->first();
            $member = members::where('user_id',  $session)->first();
            return view('profile', compact('users','member'));
        }


    }

    public function EditProfile()
    {
        $roles = Role::where('id', '!=', '1')->get();
        return view('Editprofile', compact('roles'));
    }
    public function UserEditProfile()
    {
        $userId = Auth::user()->id;
        $member = members::where('user_id', $userId)->first();
        $roles = Role::where('id', '!=', '1')->get();
        return view('UserEditProfile', compact('roles','member'));
    }

    /**
     * Update Profile
     * @param $profileData
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function updateProfile(Request $request)
    { 
        $session = auth()->user()->id;
        $user = User::where(['status' => 1, 'id' => $session])->first();

        $request->validate([
            'email' => 'required|unique:users,email,' . $user->id . ',id',
        ]);

        try {
            DB::beginTransaction();

            #Update Profile Data
            User::whereId(auth()->user()->id)->update([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'mobile_number' => $request->mobile_number,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Profile Updated Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function UserupdateProfile(Request $request)
    { 
        // dd($request);

        $session = auth()->user()->id;
        $user = User::where(['status' => 1, 'id' => $session])->first();

        $request->validate([
            'email' => 'required|unique:users,email,' . $user->id . ',id',
        ]);

        try {
            // image store start
            $img = "";
            if ($request->hasFile('profile_photo')) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('profile_photo');
                $img = time() . '.' . $image->getClientOriginalExtension();
                $destinationpath = $root . '/profile_photo/';
                if (!file_exists($destinationpath)) {
                    mkdir($destinationpath, 0755, true);
                }
                $image->move($destinationpath, $img);
                $oldImg = $request->input('hiddenPhoto_profile_photo') ? $request->input('hiddenPhoto_profile_photo') : null;
    
                if ($oldImg != null || $oldImg != "") {
                    if (file_exists($destinationpath . $oldImg)) {
                        unlink($destinationpath . $oldImg);
                    }
                }
            } else {
                $oldImg = $request->input('hiddenPhoto_profile_photo');
                $img = $oldImg;
            }
      
            $logo = "";
            if ($request->hasFile('Company_logo')) {
                $root = $_SERVER['DOCUMENT_ROOT'];
                $image = $request->file('Company_logo');
                $logo = time() . '.' . $image->getClientOriginalExtension();
                $destinationpath = $root . '/Company_logo/';
                if (!file_exists($destinationpath)) {
                    mkdir($destinationpath, 0755, true);
                }
                $image->move($destinationpath, $logo);
                $oldImg = $request->input('hiddenPhoto_Company_logo') ? $request->input('hiddenPhoto_Company_logo') : null;
    
                if ($oldImg != null || $oldImg != "") {
                    if (file_exists($destinationpath . $oldImg)) {
                        unlink($destinationpath . $oldImg);
                    }
                }
            } else {
                $oldImg = $request->input('hiddenPhoto_Company_logo');
                $logo = $oldImg;
            }


       

            // image store end 
            DB::beginTransaction();

            #Update Profile Data
            User::whereId(auth()->user()->id)->update([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'mobile_number' => $request->mobile_number,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
           
            members::where('user_id', $session)->update([
                'companyname'    => $request->Brand_name ?? '',
                'Brand_name'    =>$request->companyname ?? '',
                'date_of_birth'=>$request->date_of_birth ?? '',
                'work_anniversary_date'=>$request->work_anniversary_date ?? '',
                'profile_photo'    =>$img,
                'Company_logo'    =>$logo,
                'facebook_link'    =>$request->facebook_link,
                'youtube_link'    =>$request->youtube_link,
                'instagram_link'    =>$request->instagram_link,
                'linkedin_link'    =>$request->linkedin_link,
                'google_link'    =>$request->google_link,
                'address'     => $request->address,
            ]);
        
            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return redirect()->route('profile.detail')->with('success', 'Profile Updated Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
    /**
     * Change Password
     * @param Old Password, New Password, Confirm New Password
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function changePassword(Request $request)
    {
            $userrol = Auth::user();   
        
            if($userrol->role_id == 1 || $userrol->role_id == 3)
            {       
                    $session = Auth::user()->id;
                    $user = User::where('id', '=', $session)->where(['status' => 1])->first();

                    if (Hash::check($request->current_password, $user->password)) {
                        $newpassword = $request->new_password;
                        $confirmpassword = $request->new_confirm_password;

                        if ($newpassword == $confirmpassword) {
                            $Student = DB::table('users')
                                ->where(['status' => 1, 'id' => $session])
                                ->update([
                                    'password' => Hash::make($confirmpassword),
                                ]);
                                Auth::logout();
                                Session::flush();
                                return redirect()->route('logout');
                        } else {
                            return back()->with('error', 'password and confirm password does not match');
                        }
                    } else {
                        return back()->with('error', 'Current Password does not match');
                    }
            }else
            {      
                    $session = Auth::user()->id;
                    $user = User::where('id', '=', $session)->where(['status' => 1])->first();

                    if (Hash::check($request->current_password, $user->password)) {
                        $newpassword = $request->new_password;
                        $confirmpassword = $request->new_confirm_password;

                        if ($newpassword == $confirmpassword) {
                            $Student = DB::table('users')
                                ->where(['status' => 1, 'id' => $session])
                                ->update([
                                    'password' => Hash::make($confirmpassword),
                                ]);
                                Auth::logout();
                                Session::flush();
                                return redirect()->route('frontlogout');
                        } else {
                            return back()->with('error', 'password and confirm password does not match');
                        }
                    } else {
                        return back()->with('error', 'Current Password does not match');
                    }
            }
    }       

    public function subindex(Request $request){

        $plans = Membershipplans::select('id', 'plan_name')->get(); 
        $currentDate = now()->toDateString(); 
//         $Subscriptionexpri = DB::table('members')
//         ->where('SubscriptionExpiredDate', '<=', $currentDate)
//         ->where(['members.iStatus' => 1, 'members.isDelete' => 0])
//         ->get();
// dd($Subscriptionexpri);
        $Subscriptionexpri = DB::table('members')
        ->select('members.id as member_id', 'members.*', 'users.first_name', 'membership_plans.*',) 
        ->join('users', 'members.user_id', '=', 'users.id')
        ->join('renewal_history', 'members.renewalhistory_id', '=', 'renewal_history.id')
        ->join('membership_plans', 'renewal_history.plan_id', '=', 'membership_plans.id')
        ->where('members.SubscriptionExpiredDate', '<=', $currentDate)
        ->where(['members.iStatus' => 1, 'members.isDelete' => 0])
        ->paginate(10);

//    dd($Subscriptionexpri);
      return view('Subscriptionexp.index', compact('Subscriptionexpri','plans'));
    }
    

    public function subupdate(Request $request)
    {
        // dd($request);
        $planId = $request->input('plan_id');
        $membershipPlan = MembershipPlans::where('id', $planId)->first();
        $oldplan = DB::table('renewal_history')->where('id', $request->id)->first();
        $oldPlanEndDate =$oldplan->stbenddate;  
        $oldEndDate = strtotime($oldPlanEndDate);
        $newRenewalDate = strtotime($request->renewal_date);
        $oldYear = date('Y', $oldEndDate);
        $oldMonth = date('m', $oldEndDate);
        $subStartDate = Carbon::createFromFormat('Y-m-d', $oldYear . '-' . $oldMonth . '-' . date('d', $newRenewalDate));
        
        $subEndDate = $subStartDate->copy()->addDays($membershipPlan->duration_in_days);
        // dd($subEndDate);
        
        $renewalHistory = DB::table('renewal_history')->where('id', $request->id)->update([
            'plan_id'       => $request->plan_id,
            'renewal_date'  => $request->renewal_date,
            'updated_at'     => now(),
            // 'PaymentRefNo'  => $request->PaymentRefNo,
            'SubStartDate'  => $subStartDate,
            'StbEndDate'    => $subEndDate,
            'updated_by'     => auth()->id(),
        ]);
    
        DB::table('members')->where('id', $request->member_id)->update([
            'SubscriptionExpiredDate' => $subEndDate,
            'renewalhistory_id'       => $renewalHistory,
        ]);
    
        return back()->with('success', 'Subscription Expried update Successfully');

    }
   
}
