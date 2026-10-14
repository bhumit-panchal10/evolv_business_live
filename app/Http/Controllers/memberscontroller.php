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
use validate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Services\AuthkeyWhatsAppService;
use Carbon\Carbon;

//Groath.network_25- info@getdemo.in
class memberscontroller extends Controller
{
    public function index(Request $request)
    {
        $firstname = $request->first_name;
        $categorysearch = $request->category_id;
        $citysearch = $request->city_id;
        $groupsearch = $request->group_id;
        $status = $request->status;

        $category = Categories::select('id', 'name')->get();
        $cities = DB::table('city')->select('id', 'city_name')->get();
        $groups = DB::table('city_groups')->select('id', 'group_name')->get();

        $datas = members::select(
            'members.id as memberid',
            'users.status',
            'city.id',
            'city_groups.id',
            'categories.id',
            'users.id',
            'users.first_name',
            DB::raw("
            CASE 
                WHEN members.from = 1 THEN 'Social Media'
                WHEN members.from = 2 THEN 'Committee Member'
                WHEN members.from = 3 THEN 'Website'
                WHEN members.from REGEXP '^[0-9]+$' THEN ref_user.first_name
                ELSE '-'
            END as from_display
            "),
            'city_groups.group_name',
            'city.city_name',
            'categories.name as categoriesname',
            'members.companyname',
            'members.phonenumber',
            'members.email',
            'members.address',
            'members.pincode',
            'members.gstnumber',
            DB::raw('COALESCE(mp.points_total, 0) AS points_total'),
            'ref_user.first_name as referred_by_name'
        )
            ->orderBy('users.first_name', 'asc')
            //->orderBy('members.id', 'desc')
            ->leftjoin('city', 'city.id', 'members.city_id')
            ->leftjoin('city_groups', 'city_groups.id', 'members.citygroup_id')
            ->leftjoin('categories', 'categories.id', 'members.category_id')
            ->leftjoin('users', 'users.id', 'members.user_id')
            ->leftJoin(DB::raw('(SELECT member_id, SUM(points) AS points_total FROM member_points GROUP BY member_id) AS mp'), 'mp.member_id', '=', 'users.id')
            ->leftJoin('users as ref_user', function ($join) {
                $join->on('ref_user.id', '=', 'members.from')
                    ->whereRaw('members.from REGEXP "^[0-9]+$"');
            })
            ->where(['members.iStatus' => 1, 'members.isDelete' => 0, 'members.Arrival_flag' => 0])
             ->when($status === null || $status === '', function ($query) {
                $query->where('users.status', 1);
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('users.status', $status);
            })
            ->when($firstname, function ($query) use ($firstname) {
                $query->where('users.first_name', 'LIKE', '%' . $firstname . '%');
            })
            ->when($categorysearch, function ($query) use ($categorysearch) {
                $query->where('members.category_id', '=', $categorysearch);
            })
            ->when($citysearch, function ($query) use ($citysearch) {
                $query->where('members.city_id', '=', $citysearch);
            })
            ->when($groupsearch, function ($query) use ($groupsearch) {
                $query->where('members.citygroup_id', '=', $groupsearch);
            })
            ->paginate(env('PAR_PAGE_COUNT', 20));

        $Count = $datas->count();

        return view('members.index', compact(
            'Count',
            'datas',
            'category',
            'cities',
            'groups',
            'firstname',
            'categorysearch',
            'citysearch',
            'groupsearch',
            'status'
        ));
    }
    
    public function planRenewal($id)
    {
        $member = members::findOrFail($id);
    
        if (!$member->SubscriptionExpiredDate) {
            return redirect()->back()->with('error', 'Subscription expiry date not found.');
        }
        $expiryDate = Carbon::createFromFormat('Y-m-d',$member->SubscriptionExpiredDate);        
        $member->SubscriptionExpiredDate = $expiryDate->addDays(365)->format('Y-m-d');
        $member->save();
    
        return redirect()->back()->with('success', 'Plan renewed successfully for 365 days.');
    }

    public function memberCalendar()
    {
        $members = DB::table('members')
            ->leftJoin('users', 'members.user_id', '=', 'users.id')
            ->leftJoin('renewal_history', 'members.id', '=', 'renewal_history.member_id')
            ->select(
                'members.id',
                'users.first_name as member_name',
                'members.date_of_birth',
                'renewal_history.renewal_date as work_anniversary_date'
            )
            ->where('members.iStatus', 1)
            ->where('members.isDelete', 0)
            ->orderBy('users.first_name')
            ->paginate(env('PAR_PAGE_COUNT', 20));
            
        // Calendar ke liye all members
        $calendarMembers = DB::table('members')
            ->leftJoin('users', 'members.user_id', '=', 'users.id')
            ->leftJoin('renewal_history', 'members.id', '=', 'renewal_history.member_id')
            ->select(
                'members.id',
                'users.first_name as member_name',
                'members.date_of_birth',
                'renewal_history.renewal_date as work_anniversary_date'
            )
            ->where('Member_status', 1)
            ->where('members.iStatus', 1)
            ->where('members.isDelete', 0)
            ->orderBy('users.first_name')
            ->get();

        return view('members.member-calendar', compact('members','calendarMembers'));
    }

    public function storeview(Request $request)
    {
        $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
            ->where('users.status', 1)
            //->where('users.role_id', 2)
            ->where('members.Arrival_flag', 0)
            ->orderBy('users.first_name')
            ->select('users.*')
            ->get();
        $cities = City::select('id', 'city_name')->orderBy('city_name')->get();
        $cityGroups = City_group::select('id', 'group_name')->orderBy('group_name')->get();
        $categories = Categories::select('id', 'name')->orderBy('name')->get();
        $subcategories = subcategories::select('id', 'name')->get();
        $plans = membershipplans::select('id', 'plan_name')->orderBy('plan_name')->get();

        return view('members.storeview', compact('Data', 'cities', 'cityGroups', 'categories', 'subcategories', 'plans'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'first_name'    => 'required',
            'phonenumber' => 'required|regex:/^\d{10}$/|unique:members',
            'email'       => 'required|unique:users',
            'password'       => 'required',
            'address'     => 'required',
            'city_id'     => 'required',
            'referred_to'   => 'required',
            'referred_to_type' => 'required|in:member,other',
            'citygroup_id'  => [
                'required',
                Rule::unique('members')
                    ->where(function ($query) use ($request) {
                        $query->where('category_id', $request->input('category_id'))
                            ->where('Arrival_flag', 0);
                    }),
            ],
            'pincode' => 'required|regex:/^[0-9]{6}$/',
        ], [
            'citygroup_id.unique' => 'This group already exists for the selected category.',
        ]);
        $planId = $request->input('plan_id');

        $membershipPlan = membershipplans::where('id', $planId)->first();
        $days = $membershipPlan->duration_in_days;
        $originalDate = Carbon::parse($request->renewal_date);

        $subStartDate = $originalDate->copy()->year(now()->year);
        $subEndDate = $subStartDate->copy()->addDays($days);
        
        // $subStartDate = $request->renewal_date;
        // $subEndDate = $request->renewal_date->addDays($days);

        $user = DB::table('users')->insertGetId([
            'first_name'     =>  $request->first_name,
            'mobile_number'    => $request->phonenumber,
            'email'          => $request->email,
            'password'      => Hash::make($request['password']),
            'role_id'     => 2,
            'user_type' => 'User',
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
        $pin = strtoupper(trim($request->pin));
        $member = DB::table('members')->insertGetId([
            'Contact_person'  =>  $request->first_name,
            'user_id'        => $user,
            'companyname'    => $request->companyname,
            'phonenumber'    => $request->phonenumber,
            'email'          => $request->email,
            'address'        => $request->address,
            'city_id'        => $request->city_id,
            'citygroup_id'   => $request->citygroup_id,
            'category_id'    => $request->category_id,
            // 'subcategories_id' => 0,                                               
            'pincode'        => $request->pincode,
            'from'        => $request->referred_to,
            //'referred_to_type' => $request->referred_to_type,
            'priority_club' => $request->priority_club,
            'pin'                   => $pin,
            'gstnumber'      => $request->gstnumber,
            'date_of_birth'      => $request->date_of_birth,
            'brand_establish_year'      => $request->brand_establish_year,
            // 'Book_Your_Podcast'=>$request->Book_Your_Podcast,
            // 'Book_Your_Member_of_the_week'=>$request->Book_Your_Member_of_the_week,
            'product_service'      => $request->product_service,
            'created_at'     => date('Y-m-d H:i:s'),
            'strIP'          => $request->ip(),
            'created_by'     => auth()->id(),
        ]);
        if (
            $request->filled('referred_to') &&
            $request->filled('referred_to_type') &&
            $request->referred_to_type == 'member'
        ) {
            $referredMember = User::leftJoin('members', 'members.user_id', '=', 'users.id')
                ->where('users.id', $request->referred_to)
                ->where('users.status', 1)
                ->where('members.Arrival_flag', 0)
                ->select('users.id')
                ->first();

            if ($referredMember) {
                DB::table('member_points')->insert([
                    'business_id' => 0,
                    'member_id'   => $referredMember->id,
                    'points_id'   => 1,
                    'points'      => 20,
                    'status'      => 0,
                    'description' => 'New Member Induction',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
        $renewalDate = null;

        if ($request->filled('renewal_date')) {
            $renewalDate = Carbon::createFromFormat(
                'd-m-Y',
                $request->renewal_date
            )->format('Y-m-d');
        }

        $renewalHistory = DB::table('renewal_history')->insertGetId([
            'member_id'     => $member,
            'plan_id'       => $request->plan_id,
            'renewal_date'  => $renewalDate,
            'created_at'     => date('Y-m-d H:i:s'),
            'paymentrefNo'  => $request->PaymentRefNo,
            'SubStartDate'  => $subStartDate,
            'StbEndDate'    => $subEndDate,
            'created_by'     => auth()->id(),
        ]);
        DB::table('members')->where('id', $member)->update([
            'SubscriptionExpiredDate' => $subEndDate,
            'renewalhistory_id'       => $renewalHistory,
        ]);
        
        $name = trim($request->first_name);
        if (in_array((int) $request->priority_club, [3, 5, 7])) {
            $name .= '-' . $request->priority_club . 'p';
        }
        if (in_array(strtoupper($request->pin), ['SL', 'GL', 'PL'])) {
            $name .= '-' . strtolower($request->pin);
        }
        DB::table('members')
            ->where('id', $member)
            ->update([
                'Contact_person' => $name
            ]);

        DB::table('users')
            ->where('id', $user)
            ->update([
                'first_name' => $name
            ]);
        // $sendemaildetails = DB::table('sendemaildetails')->where('id', 3)->first();

        // $msg = [
        //     'FromMail' => $sendemaildetails->strFromMail ??  'info@getdemo.in',
        //     'Title' => $sendemaildetails->strTitle ??  'Evolve Business Community',
        //     'ToEmail' => $request->email,
        //     'Subject' => $sendemaildetails->strSubject ?? 'Member Login Information' ?? '',
        // ];

        // $data = [
        //     'email' => $request->email,
        //     'password' => $request->password
        // ];

        // $mail = Mail::send('emails.Loginemail', ['data' => $data], function ($message) use ($msg) {
        //     $message->from($msg['FromMail'], $msg['Title']);
        //     $message->to($msg['ToEmail'])->subject($msg['Subject']);
        // });
        $whatsappService = new AuthkeyWhatsAppService();
        $wid = "39441"; // template id
        $mobileNo = $request->phonenumber;
        $statusofMessage = $whatsappService->sendText($mobileNo, $wid);
        DB::commit();
        // return view('frontview.contactthankyou');
        // return redirect()->route('contactthankyou');

        return redirect()->route('members.index')->with('success', 'Members Created Successfully.');
    }

    public function editview(Request $request, $id)
    {

        $cities = City::select('id', 'city_name')->orderBy('city_name')->get();
        $cityGroups = City_group::select('id', 'group_name')->orderBy('group_name')->get();
        $categories = Categories::select('id', 'name')->orderBy('name')->get();
        $subcategories = Subcategories::select('id', 'name')->get();
        $plans = Membershipplans::select('id', 'plan_name')->orderBy('plan_name')->get();
        $renewplan = renewalhistory::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $id])->first();
        $data = Members::select('members.*', db::raw('(select users.first_name from users where    users.id=members.user_id order by users.id desc limit 1 ) as user_id'), db::raw('(select renewal_history.plan_id from renewal_history where    renewal_history.member_id=members.id order by renewal_history.id desc limit 1 ) as plan_id'), db::raw('(select renewal_history.renewal_date from renewal_history where    renewal_history.member_id=members.id order by renewal_history.id desc limit 1 ) as renewal_date'), db::raw('(select renewal_history.paymentrefNo from renewal_history where    renewal_history.member_id=members.id order by renewal_history.id desc limit 1 ) as paymentrefNo'))->where(['members.iStatus' => 1, 'members.isDelete' => 0, 'members.id' => $id])->first();
        $Data = User::leftjoin('members', 'members.user_id', '=', 'users.id')
            ->where('users.status', 1)
            //->where('users.role_id', 2)
            ->where('members.Arrival_flag', 0)
            ->orderBy('users.first_name')
            ->select('users.*')
            ->get();
        return view('members.edit', compact('Data', 'cities', 'cityGroups', 'categories', 'subcategories', 'plans', 'data', 'renewplan', 'Data'));
    }


    // public function update(Request $request)
    // {
    //     $userid = Members::find($request->id);
    //     // dd($userid);

    //     $existingCount = DB::table('members')
    //         ->where('category_id', $request->input('category_id'))
    //         ->where('citygroup_id', $request->input('citygroup_id'))
    //         ->where('id', '!=', $request->id)
    //         ->where('iStatus', 1)
    //         ->where('isDelete', 0)
    //         ->count();

    //     if ($existingCount > 0) {
    //         return redirect()->back()->withErrors(['citygroup_id' => 'This group already exists for the selected category.'])->withInput();
    //     }
    //     $request->validate([
    //         // 'companyname' => 'required',
    //         'phonenumber' => 'required|regex:/^\d{10}$/',
    //         'email'       => 'required',
    //         'address'     => 'required',
    //         'city_id'     => 'required',
    //         'citygroup_id' => 'required',
    //         'pincode' => 'required|regex:/^[0-9]{6}$/',
    //     ]);
    //     $planId = $request->input('plan_id');
    //     $membershipPlan = MembershipPlans::where('id', $planId)->first();
    //     $days = $membershipPlan->duration_in_days;
    //     $subStartDate = now();
    //     $subEndDate = now()->addDays($days);

    //     $existingUser = DB::table('users')->where('email', $request->email)->first();
    //     // dd($existingUser);
    //     if ($existingUser) {
    //         if ($existingUser->id != $userid->user_id) {
    //             return redirect()->back()->with('error', 'The email address is already in use by another user.');
    //         } else {

    //             DB::table('users')
    //                 ->where('id', $existingUser->id)
    //                 ->update([
    //                     'first_name'     => $request->first_name,
    //                     'mobile_number'  => $request->phonenumber,
    //                     'role_id'        => 2,
    //                     'user_type'      => 'User',
    //                     'updated_at'     => date('Y-m-d H:i:s'),
    //                 ]);
    //         }
    //     } else {
    //         DB::table('users')
    //             ->where('id', $userid->user_id)
    //             ->update([
    //                 'first_name'     => $request->first_name,
    //                 'mobile_number'  => $request->phonenumber,
    //                 'email'          => $request->email,
    //                 'role_id'        => 2,
    //                 'updated_at'     => date('Y-m-d H:i:s'),
    //             ]);
    //     }
    //     if ($request->priority_club == 3 || $request->priority_club == 5 || $request->priority_club == 7) {

    //         $name = $request->first_name;

    //         // check karo already 'p' se start to nahi ho raha
    //         if (!str_starts_with($name, 'P-')) {
    //             $name = 'P-' . $name;
    //         }

    //         DB::table('members')
    //             ->where('id', $request->id)
    //             ->update([
    //                 'Contact_person' => $name
    //             ]);

    //         DB::table('users')
    //             ->where('id', $userid->user_id)
    //             ->update([
    //                 'first_name' => $name
    //             ]);
    //     }
    //     DB::table('members')
    //         ->where('id', $request->id)
    //         ->update([
    //             'Contact_person'  =>  $request->first_name,
    //             'companyname'    => $request->companyname,
    //             'phonenumber'    => $request->phonenumber,
    //             'email'          => $request->email,
    //             'address'        => $request->address,
    //             'city_id'        => $request->city_id,
    //             'citygroup_id'   => $request->citygroup_id,
    //             'category_id'    => $request->category_id,
    //             'subcategories_id' => 0,
    //             'pincode'        => $request->pincode,
    //             'priority_club' => $request->priority_club,
    //             'from'        => $request->referred_to,
    //             'gstnumber'      => $request->gstnumber,
    //             'date_of_birth'      => $request->date_of_birth,
    //             // 'Book_Your_Podcast'=>$request->Book_Your_Podcast,
    //             // 'Book_Your_Member_of_the_week'=>$request->Book_Your_Member_of_the_week,
    //             'updated_at'     => now(),
    //             'product_service'      => $request->product_service,
    //             'strIP'          => $request->ip(),
    //             'updated_by'     => auth()->id(),
    //         ]);
    //     $renewalHistory = DB::table('renewal_history')->where('member_id', $request->id)
    //         ->update([
    //             'plan_id'       => $request->plan_id,
    //             'renewal_date'  => $request->renewal_date,
    //             'updated_at'     => now(),
    //             'PaymentRefNo'  => $request->PaymentRefNo,
    //             'SubStartDate'  => $subStartDate,
    //             'StbEndDate'    => $subEndDate,
    //             'updated_by'     => auth()->id(),
    //         ]);
    //     DB::table('members')->where('id', $request->id)
    //         ->update([
    //             'SubscriptionExpiredDate' => $subEndDate,
    //             'renewalhistory_id'       => $renewalHistory,
    //         ]);
    //     return redirect()->route('members.index')->with('success', 'Member Updated Successfully.');
    // }
    
    public function update(Request $request)
    {
        $userid = Members::find($request->id);

        if (!$userid) {
            return redirect()
                ->back()
                ->with('error', 'Member not found.');
        }

        $existingCount = DB::table('members')
            ->where('category_id', $request->input('category_id'))
            ->where('citygroup_id', $request->input('citygroup_id'))
            ->where('id', '!=', $request->id)
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->count();

        if ($existingCount > 0) {
            return redirect()
                ->back()
                ->withErrors([
                    'citygroup_id' => 'This group already exists for the selected category.'
                ])
                ->withInput();
        }

        $request->validate([
            'phonenumber' => 'required|regex:/^\d{10}$/',
            'email'        => 'required',
            'address'      => 'required',
            'city_id'      => 'required',
            'citygroup_id' => 'required',
            'pincode'      => 'required|regex:/^[0-9]{6}$/',
        ]);
        $planId = $request->input('plan_id');

        $membershipPlan = MembershipPlans::where('id', $planId)->first();

        if (!$membershipPlan) {
            return redirect()
                ->back()
                ->with('error', 'Membership plan not found.')
                ->withInput();
        }

        $days = $membershipPlan->duration_in_days;

        // $subStartDate = Carbon::parse($request->renewal_date);
        // $subEndDate = $subStartDate->copy()->addDays($days);
        
        $originalDate = Carbon::parse($request->renewal_date);

        $subStartDate = $originalDate->copy()->year(now()->year);
        $subEndDate = $subStartDate->copy()->addDays($days);

        $priorityClub = $request->has('priority_club')
            ? $request->priority_club
            : $userid->priority_club;

        $pin = $request->has('pin')
            ? strtoupper(trim($request->pin))
            : strtoupper(trim($userid->pin ?? ''));
        $name = trim($request->first_name);

        // Remove old "P-" prefix
        $name = preg_replace('/^P-\s*/i', '', $name);

        // Remove existing priority + pin suffix
        // Example: Kriti Shah-3p-sl => Kriti Shah
        $name = preg_replace(
            '/-(3p|5p|7p)(-(sl|gl|pl))?$/i',
            '',
            $name
        );

        // Remove only pin suffix
        // Example: Kriti Shah-sl => Kriti Shah
        $name = preg_replace(
            '/-(sl|gl|pl)$/i',
            '',
            $name
        );

        $name = trim($name);
        if (in_array((int) $priorityClub, [3, 5, 7])) {
            $name .= '-' . (int) $priorityClub . 'p';
        }
        if (in_array($pin, ['SL', 'GL', 'PL'])) {
            $name .= '-' . strtolower($pin);
        }
        $existingUser = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if ($existingUser) {

            if ($existingUser->id != $userid->user_id) {

                return redirect()
                    ->back()
                    ->with('error', 'The email address is already in use by another user.')
                    ->withInput();
            } else {

                DB::table('users')
                    ->where('id', $existingUser->id)
                    ->update([
                        'first_name'    => $name,
                        'mobile_number' => $request->phonenumber,
                        'email'         => $request->email,
                        'role_id'       => 2,
                        'user_type'     => 'User',
                        'updated_at'    => now(),
                    ]);
            }
        } else {

            DB::table('users')
                ->where('id', $userid->user_id)
                ->update([
                    'first_name'    => $name,
                    'mobile_number' => $request->phonenumber,
                    'email'         => $request->email,
                    'role_id'       => 2,
                    'user_type'     => 'User',
                    'updated_at'    => now(),
                ]);
        }
        DB::table('members')
            ->where('id', $request->id)
            ->update([
                'Contact_person'   => $name,
                'companyname'      => $request->companyname,
                'phonenumber'      => $request->phonenumber,
                'email'            => $request->email,
                'address'          => $request->address,
                'city_id'          => $request->city_id,
                'citygroup_id'     => $request->citygroup_id,
                'category_id'      => $request->category_id,
                'subcategories_id' => 0,
                'pincode'          => $request->pincode,

                // Priority preserve/update
                'priority_club'    => $priorityClub,

                // IMPORTANT: Pin database me save hoga
                'pin'              => $pin,

                'from'             => $request->referred_to,
                'gstnumber'        => $request->gstnumber,
                'date_of_birth'    => $request->date_of_birth,
                'product_service'  => $request->product_service,
                'updated_at'       => now(),
                'strIP'            => $request->ip(),
                'updated_by'       => auth()->id(),
            ]);
        // DB::table('renewal_history')
        //     ->where('member_id', $request->id)
        //     ->update([
        //         'plan_id'      => $request->plan_id,
        //         'renewal_date' => $request->renewal_date,
        //         'updated_at'   => now(),
        //         'PaymentRefNo' => $request->PaymentRefNo,
        //         'SubStartDate' => $subStartDate,
        //         'StbEndDate'   => $subEndDate,
        //         'updated_by'   => auth()->id(),
        //     ]);
        // $renewalHistory = DB::table('renewal_history')
        //     ->where('member_id', $request->id)
        //     ->value('id');

        $renewalDate = null;

        if ($request->filled('renewal_date')) {
            $renewalDate = Carbon::createFromFormat(
                'd-m-Y',
                $request->renewal_date
            )->format('Y-m-d');
        }
        $renewalHistory = DB::table('renewal_history')
            ->where('member_id', $request->id)
            ->orderBy('id', 'desc')
            ->first();
        if ($renewalHistory) {

            DB::table('renewal_history')
                ->where('id', $renewalHistory->id)
                ->update([
                    'plan_id'       => $request->plan_id,
                    'renewal_date' => $renewalDate,
                    'paymentrefNo'  => $request->PaymentRefNo,
                    'SubStartDate'  => $subStartDate,
                    'StbEndDate'    => $subEndDate,
                    'updated_at'    => now(),
                    'updated_by'    => auth()->id(),
                ]);

            $renewalHistoryId = $renewalHistory->id;
        } else {

            $renewalHistoryId = DB::table('renewal_history')
                ->insertGetId([
                    'member_id'     => $request->id,
                    'plan_id'       => $request->plan_id,
                    'renewal_date'  => $renewalDate,
                    'paymentrefNo'  => $request->PaymentRefNo,
                    'SubStartDate'  => $subStartDate,
                    'StbEndDate'    => $subEndDate,
                    'created_at'    => now(),
                    'created_by'    => auth()->id(),
                ]);
        }

        DB::table('members')
            ->where('id', $request->id)
            ->update([
                'SubscriptionExpiredDate' => $subEndDate,
                'renewalhistory_id'       => $renewalHistoryId,
            ]);
        return redirect()
            ->route('members.index')
            ->with('success', 'Member Updated Successfully.');
    }
    
    public function delete(Request $request)
    {

        $userid = members::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->first();

        $user_id = $userid->user_id;

        DB::table('members')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();

        DB::table('users')->where(['status' => 1, 'id' => $user_id])->delete();

        DB::table('member_services')->where(['iStatus' => 1, 'isDelete' => 0, 'member_id' => $request->id])->delete();
        return back()->with('success', 'Members Deleted Successfully!.');
    }

    public function checkserviceprovider(Request $request)
    {

        $data = members::where(['iStatus' => 1, 'isDelete' => 0, 'companyname' => $request->companyname])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function cityid(Request $request)
    {
        $Mapping = City_group::where(['city_id' => $request->city_id])->get();

        $html = "";
        $html .= "<option value=''>Select group</option>";
        foreach ($Mapping as $mapping) {
            $html .= "<option value='" . $mapping->id . "'>" . $mapping->group_name . "</option>";
        }

        return $html;
    }

    public function categoryid(Request $request)
    {
        $Mapping = subcategories::where(['category_id' => $request->category_id])->get();
        //  dd($Mapping);

        $html = "";
        $html .= "<option value=''>Select Subcategory</option>";
        foreach ($Mapping as $mapping) {
            $html .= "<option value='" . $mapping->id . "'>" . $mapping->name . "</option>";
        }

        return $html;
    }
    public function changePassword(Request $request)
    {

        $newpassword = ($request->newpassword);
        $confirmpassword = ($request->confirmpassword);

        if ($newpassword == $confirmpassword) {
            $user = User::find($request->id);

            $Password = DB::table('users')
                ->where(['id' => $request->id])
                ->update([
                    'password' => Hash::make($request->confirmpassword),
                ]);
            $sendemaildetails = DB::table('sendemaildetails')->where('id', 3)->first();
            $msg = [
                'FromMail' => $sendemaildetails->strFromMail ??  'info@getdemo.in',
                'Title' => $sendemaildetails->strTitle ??  'Evolve Business Community',
                'ToEmail' => $user->email,
                'Subject' => $sendemaildetails->strSubject ?? 'Member Login Information' ?? '',
            ];
            $data = [
                'email' => $user->email,
                'password' => $request->confirmpassword
            ];

            $mail = Mail::send('emails.Loginemail', ['data' => $data], function ($message) use ($msg) {
                $message->from($msg['FromMail'], $msg['Title']);
                $message->to($msg['ToEmail'])->subject($msg['Subject']);
            });

            return back()->with('success', 'User Password Updated Successfully.');
        } else {
            // dd('eles');
            return back()->with('error', 'password and confirm password does not match');
        }
    }

    public function updateStatus($user_id, $status)
    {
        // dd($user_id ,$status);
        // Validation
        $validate = Validator::make([
            'user_id'   => $user_id,
            'status'    => $status
        ], [
            'user_id'   =>  'required|exists:users,id',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('members.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            User::whereId($user_id)->update(['status' => $status]);
            // Update Status in Member table
            members::where('user_id', $user_id)->update(['Member_status' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('members.index')->with('success', 'User Status Updated Successfully');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function MemberexportToexcel(Request $request, $first_name = null, $category_id = null)
    {
        try {
            $firstname = $request->first_name;
            $categorysearch = $request->category_id;
            $category = Categories::select('id', 'name')->get();

            $datas = members::select(
                'members.id as memberid',
                'users.status',
                'city.id',
                'city_groups.id',
                'categories.id',
                'users.id',
                'users.first_name',
                'city_groups.group_name',
                'city.city_name',
                'categories.name as categoriesname',
                'members.companyname',
                'members.phonenumber',
                'members.email',
                'members.address',
                'members.pincode',
                'members.gstnumber',
                'members.SubscriptionExpiredDate',
                'members.facebook_link',
                'members.youtube_link',
                'members.instagram_link',
                'members.linkedin_link',
                'members.google_link',
                'members.date_of_birth',
                'members.work_anniversary_date'
            )->orderBy('members.id', 'desc')
                ->leftjoin('city', 'city.id', 'members.city_id')
                ->leftjoin('city_groups', 'city_groups.id', 'members.citygroup_id')
                ->leftjoin('categories', 'categories.id', 'members.category_id')
                ->leftjoin('users', 'users.id', 'members.user_id')
                ->where(['members.iStatus' => 1, 'members.isDelete' => 0])
                ->when($request->first_name, function ($query) use ($firstname) {
                    $query->where('users.first_name', 'LIKE', '%' . $firstname . '%');
                })
                ->when($request->category_id, function ($query) use ($categorysearch) {
                    $query->where('members.category_id', '=',  $categorysearch);
                })
                ->get();

            return view('members.Memberexportdata', compact('datas', 'firstname', 'categorysearch'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function Arrival($user_id)
    {
        try {
            DB::beginTransaction();
            $data = DB::table('members')->where('user_id', $user_id)->update([
                'Arrival_flag' => 1,
            ]);
            DB::commit();
            return redirect()->route('members.index')->with('success', 'User Archive Status Updated Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function Archive_index(Request $request)
    {

        $firstname = $request->first_name;
        $categorysearch = $request->category_id;
        //  $subcategories = $request->subcategories_id;

        $category = Categories::select('id', 'name')->get();

        $datas = members::select('members.id as memberid', 'users.status', 'city.id', 'city_groups.id', 'categories.id', 'users.id', 'users.first_name', 'city_groups.group_name', 'city.city_name', 'categories.name as categoriesname', 'members.companyname', 'members.phonenumber', 'members.email', 'members.address', 'members.pincode', 'members.gstnumber')->orderBy('members.id', 'desc')
            ->leftjoin('city', 'city.id', 'members.city_id')
            ->leftjoin('city_groups', 'city_groups.id', 'members.citygroup_id')
            ->leftjoin('categories', 'categories.id', 'members.category_id')
            ->leftjoin('users', 'users.id', 'members.user_id')
            ->where(['members.iStatus' => 1, 'members.isDelete' => 0, 'members.Arrival_flag' => 1])
            ->when($request->first_name, function ($query) use ($firstname) {
                $query->where('users.first_name', 'LIKE', '%' . $firstname . '%');
            })
            ->when($request->category_id, function ($query) use ($categorysearch) {
                $query->where('members.category_id', '=',  $categorysearch);
            })
            // dd($datas);
            ->paginate(env('PAR_PAGE_COUNT', 20));

        $Count = $datas->count();
        return view('members.Archive', compact('Count', 'datas', 'category', 'firstname', 'categorysearch'));
    }
    public function Arrival_member_back($user_id)
    {

        try {
            DB::beginTransaction();
            $data = DB::table('members')->where('user_id', $user_id)->update([
                'Arrival_flag' => 0,
            ]);
            DB::commit();
            return redirect()->route('members.Archive')->with('success', 'User Archive Status Updated Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



    public function activity(Request $request, $id = null)
    {
        $member = members::select(
            'members.id',
            'members.user_id',
            'members.companyname',
            'users.first_name',
            'users.email'
        )
            ->leftJoin('users', 'users.id', '=', 'members.user_id')
            ->where([
                'members.iStatus' => 1,
                'members.isDelete' => 0,
                'members.id' => $id,
            ])
            ->firstOrFail();

        $fromDate = $request->filled('from_date') ? date('Y-m-d', strtotime($request->from_date)) : null;
        $toDate = $request->filled('to_date') ? date('Y-m-d', strtotime($request->to_date)) : null;

        $directBusinesses = DB::table('Business')
            ->where([
                'iStatus' => 1,
                'isDelete' => 0,
                'business_type' => 1,
                'business_from_id' => $member->user_id,
            ])
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('business_Date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('business_Date', '<=', $toDate);
            })
            ->orderByDesc('business_id')
            ->get();

        $referenceBusinesses = DB::table('Business')
            ->where([
                'iStatus' => 1,
                'isDelete' => 0,
                'business_type' => 2,
                'business_from_id' => $member->user_id,
            ])
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('business_Date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('business_Date', '<=', $toDate);
            })
            ->orderByDesc('business_id')
            ->get();

        $references = DB::table('Reference')
            ->where([
                'iStatus' => 1,
                'isDelete' => 0,
                'Reference_from' => $member->user_id,
            ])
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('Reference_Date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('Reference_Date', '<=', $toDate);
            })
            ->orderByDesc('Reference_id')
            ->get();

        $visitors = DB::table('visitors')
            ->where('created_by', $member->user_id)
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('created_at', '<=', $toDate);
            })
            ->orderByDesc('id')
            ->get();

        $events = DB::table('news_and_events')
            ->where('created_by', $member->user_id)
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('eventstart_date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('eventstart_date', '<=', $toDate);
            })
            ->orderByDesc('event_id')
            ->get();
        $attendedEvents = DB::table('event_members as em')
            ->select(
                'em.id',
                'em.created_at as attended_at',
                'ne.event_id',
                'ne.name',
                'ne.eventstart_date',
                'ne.isapproved_status'
            )
            ->leftJoin('news_and_events as ne', 'ne.event_id', '=', 'em.event_id')
            ->where('em.member_id', $member->user_id)
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('em.created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('em.created_at', '<=', $toDate);
            })
            ->orderByDesc('em.id')
            ->get();

        $oneToOnes = DB::table('one_to_one_detail')
            ->where([
                'iStatus' => 1,
                'isDelete' => 0,
               
            ])
             ->where(function ($query) use ($member) {
                    $query->where('from_id', $member->user_id)
                          ->orWhere('to_id', $member->user_id);
                })
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('date', '<=', $toDate);
            })
            ->orderByDesc('id')
            ->get();
        $directBusinessTotal = $directBusinesses->sum('Business_amount');

        $referenceBusinessTotal = $referenceBusinesses->sum('Business_amount');

        $memberMeetingCount = DB::table('Cluster_Meet_Member_meeting')
            ->where('member_id', $member->id)
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->count();
        $memberPointCount = DB::table('member_points')
            ->where('member_id', $member->user_id)
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('created_at', '<=', $toDate);
            })
            ->sum('points');

        $memberMeetings = DB::table('Cluster_Meet_Member_meeting as mm')
            ->select('mm.*', 'Cluster_Meet.Meeting_title', 'Cluster_Meet.start_date', 'Cluster_Meet.End_date')
            ->leftJoin('Cluster_Meet', 'mm.meeting_id', '=', 'Cluster_Meet.id')
            ->where('mm.member_id', $member->id)
            ->where('mm.iStatus', 1)
            ->where('mm.isDelete', 0)
            ->orderBy(DB::raw("STR_TO_DATE(Cluster_Meet.start_date, '%d.%m.%y %H:%i')"), 'DESC')
            ->get();

        $memberPoints = DB::table('member_points')
            ->where('member_id', $member->user_id)
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('created_at', '<=', $toDate);
            })
            ->orderByDesc('id')
            ->get();

        return view('members.activity', compact(
            'member',
            'directBusinesses',
            'referenceBusinesses',
            'references',
            'visitors',
            'events',
            'attendedEvents',
            'oneToOnes',
            'directBusinessTotal',
            'referenceBusinessTotal',
            'memberMeetingCount',
            'memberPointCount',
            'memberMeetings',
            'memberPoints',
            'fromDate',
            'toDate'
        ));
    }
}
