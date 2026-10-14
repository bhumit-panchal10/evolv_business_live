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

class memberscontroller extends Controller
{
   public function index(Request $request)
    {
        $firstname = $request->first_name;
        $categorysearch = $request->category_id;
        $citysearch = $request->city_id;
        $groupsearch = $request->group_id;

        $category = Categories::select('id', 'name')->get();
        $cities = DB::table('city')->select('id', 'city_name')->get();
        $groups = DB::table('city_groups')->select('id', 'group_name')->get();

        $datas = members::select(
                'members.id as memberid','users.status','city.id','city_groups.id','categories.id','users.id','users.first_name',
                'city_groups.group_name','city.city_name','categories.name as categoriesname','members.companyname',
                'members.phonenumber','members.email','members.address','members.pincode','members.gstnumber')
            ->orderBy('members.id', 'desc')
            ->leftjoin('city','city.id','members.city_id')
            ->leftjoin('city_groups','city_groups.id','members.citygroup_id')
            ->leftjoin('categories','categories.id','members.category_id') 
            ->leftjoin('users','users.id','members.user_id') 
            ->where(['members.iStatus' => 1, 'members.isDelete' => 0, 'members.Arrival_flag' => 0])
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
            'Count', 'datas', 'category', 'cities', 'groups',
            'firstname', 'categorysearch', 'citysearch', 'groupsearch'
        ));
    }
    
    public function storeview(Request $request)
    {
        $cities = City::select('id', 'city_name')->orderBy('city_name')->get();
        $cityGroups = City_group::select('id', 'group_name')->orderBy('group_name')->get();
        $categories = Categories::select('id', 'name')->orderBy('name')->get();
        $subcategories = subcategories::select('id', 'name')->get();
        $plans = membershipplans::select('id', 'plan_name')->orderBy('plan_name')->get();
       

        return view('members.storeview', compact('cities','cityGroups','categories','subcategories','plans'));
    }


    public function create(Request $request)
    { 
            $request->validate([
                'first_name'    => 'required',
                'phonenumber' => 'required|regex:/^\d{10}$/',
                'email'       => 'required|unique:users',
                'password'       => 'required',
                'address'     => 'required', 
                'city_id'     => 'required',
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
              $subStartDate = now();
              $subEndDate = now()->addDays($days);
        
               $user = DB::table('users')->insertGetId([
                'first_name'     =>  $request->first_name,
                'mobile_number'    => $request->phonenumber,
                'email'          => $request->email,
                'password'      => Hash::make($request['password']),  
                 'role_id'     =>2,
                 'user_type' =>'User',
                 'created_at'     => date('Y-m-d H:i:s'),
            ]);
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
                'gstnumber'      => $request->gstnumber,
                'date_of_birth'      => $request->date_of_birth,
                'brand_establish_year'      => $request->brand_establish_year,
                // 'Book_Your_Podcast'=>$request->Book_Your_Podcast,
                // 'Book_Your_Member_of_the_week'=>$request->Book_Your_Member_of_the_week,
                'created_at'     => date('Y-m-d H:i:s'),
                'strIP'          => $request->ip(),
                'created_by'     => auth()->id(),
            ]);
             $renewalHistory = DB::table('renewal_history')->insertGetId([
                'member_id'     => $member,
                'plan_id'       => $request->plan_id,
                'renewal_date'  => $request->renewal_date,
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
          $sendemaildetails = DB::table('sendemaildetails')->where('id', 3)->first();
               
                $msg = [
                    'FromMail' => $sendemaildetails->strFromMail ??  'support@evolv.co.in',
                    'Title' => $sendemaildetails->strTitle ??  'Evolve Business Community',
                    'ToEmail' => $request->email,
                    'Subject' => $sendemaildetails->strSubject ?? 'Member Login Information' ?? '',
                ];
                
                $data = [
                    'email' => $request->email,
                    'password' => $request->password
                ];
                
                $mail = Mail::send('emails.Loginemail', ['data' => $data], function ($message) use ($msg) {
                    $message->from($msg['FromMail'], $msg['Title']);
                    $message->to($msg['ToEmail'])->subject($msg['Subject']);
                });
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
    $data = Members::select('members.*',db::raw('(select users.first_name from users where    users.id=members.user_id order by users.id desc limit 1 ) as user_id'),db::raw('(select renewal_history.plan_id from renewal_history where    renewal_history.member_id=members.id order by renewal_history.id desc limit 1 ) as plan_id'),db::raw('(select renewal_history.renewal_date from renewal_history where    renewal_history.member_id=members.id order by renewal_history.id desc limit 1 ) as renewal_date'),db::raw('(select renewal_history.paymentrefNo from renewal_history where    renewal_history.member_id=members.id order by renewal_history.id desc limit 1 ) as paymentrefNo'))->where(['members.iStatus' => 1, 'members.isDelete' => 0, 'members.id' => $id ])->first();

    return view('members.edit', compact('cities', 'cityGroups', 'categories', 'subcategories', 'plans', 'data','renewplan'));
}


public function update(Request $request)
{
    $userid = Members::find($request->id);
    // dd($userid);
 
    $existingCount = DB::table('members')
    ->where('category_id', $request->input('category_id'))
    ->where('citygroup_id', $request->input('citygroup_id'))
    ->where('id', '!=', $request->id) 
    ->where('iStatus', 1)
    ->where('isDelete', 0)
    ->count();

if ($existingCount > 0) {
    return redirect()->back()->withErrors(['citygroup_id' => 'This group already exists for the selected category.'])->withInput();
}
    $request->validate([
        // 'companyname' => 'required',
        'phonenumber' => 'required|regex:/^\d{10}$/',
        'email'       => 'required',
        'address'     => 'required', 
        'city_id'     => 'required',
        'citygroup_id' => 'required',
        'pincode' => 'required|regex:/^[0-9]{6}$/',
    ]);
    $planId = $request->input('plan_id');
    $membershipPlan = MembershipPlans::where('id', $planId)->first();
    $days = $membershipPlan->duration_in_days;
    $subStartDate = now();
    $subEndDate = now()->addDays($days);

    $existingUser = DB::table('users')->where('email', $request->email)->first();
    // dd($existingUser);
    if ($existingUser) {
        if ($existingUser->id != $userid->user_id) {
            return redirect()->back()->with('error', 'The email address is already in use by another user.');
        } else {
         
            DB::table('users')
                ->where('id', $existingUser->id)
                ->update([
                    'first_name'     => $request->first_name,
                    'mobile_number'  => $request->phonenumber,
                    'role_id'        => 2,
                    'user_type'      => 'User',
                    'updated_at'     => date('Y-m-d H:i:s'), 
                ]);
        }
    } else {
        DB::table('users')
            ->where('id', $userid->user_id)
            ->update([
                'first_name'     => $request->first_name,
                'mobile_number'  => $request->phonenumber,
                'email'          => $request->email,
                'role_id'        => 2,
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
    }
    DB::table('members')
    ->where('id', $request->id)
    ->update([
        'Contact_person'  =>  $request->first_name,
        'companyname'    => $request->companyname,                                                   
        'phonenumber'    => $request->phonenumber,
        'email'          => $request->email,
        'address'        => $request->address,
        'city_id'        => $request->city_id, 
        'citygroup_id'   => $request->citygroup_id,
        'category_id'    => $request->category_id,
        'subcategories_id' => 0,                                               
        'pincode'        => $request->pincode,
        'gstnumber'      => $request->gstnumber,
        // 'Book_Your_Podcast'=>$request->Book_Your_Podcast,
        // 'Book_Your_Member_of_the_week'=>$request->Book_Your_Member_of_the_week,
        'updated_at'     => now(),
        'strIP'          => $request->ip(),
        'updated_by'     => auth()->id(),
    ]);
    $renewalHistory = DB::table('renewal_history')->where('member_id',$request->id)
    ->update([
        'plan_id'       => $request->plan_id,
        'renewal_date'  => $request->renewal_date,
        'updated_at'     => now(),
        'PaymentRefNo'  => $request->PaymentRefNo,
        'SubStartDate'  => $subStartDate,
        'StbEndDate'    => $subEndDate,
        'updated_by'     => auth()->id(),
    ]);
    DB::table('members')->where('id', $request->id)
    ->update([
        'SubscriptionExpiredDate' => $subEndDate,
        'renewalhistory_id'       => $renewalHistory,
    ]);
     return redirect()->route('members.index')->with('success', 'Member Updated Successfully.');
}
    public function delete(Request $request)
    {
        
        $userid =members::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->first();

        $user_id = $userid->user_id;

        DB::table('members')->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->id])->delete();

        DB::table('users')->where(['status' => 1,'id' => $user_id])->delete();

        DB::table('member_services')->where(['iStatus' => 1,'isDelete' => 0,'member_id' => $request->id])->delete();
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
                    'FromMail' => $sendemaildetails->strFromMail ??  'support@evolv.co.in',
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
            'users.status','city.id',
            'city_groups.id','categories.id',
            'users.id','users.first_name',
            'city_groups.group_name','city.city_name','categories.name as categoriesname','members.companyname','members.phonenumber','members.email','members.address','members.pincode','members.gstnumber','members.SubscriptionExpiredDate','members.facebook_link','members.youtube_link','members.instagram_link','members.linkedin_link','members.google_link','members.date_of_birth','members.work_anniversary_date')->orderBy('members.id', 'desc')
           ->leftjoin('city','city.id','members.city_id')
           ->leftjoin('city_groups','city_groups.id','members.citygroup_id')
           ->leftjoin('categories','categories.id','members.category_id') 
           ->leftjoin('users','users.id','members.user_id') 
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
            ->paginate(env('PAR_PAGE_COUNT',20));

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

}

