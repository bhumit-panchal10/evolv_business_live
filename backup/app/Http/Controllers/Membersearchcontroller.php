<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\members;
use App\Models\Products_service;
use App\Models\User;
use App\Models\City;
use App\Models\City_group;
use App\Models\Categories;
use App\Models\subcategories;
use App\Models\membershipplans;
use App\Models\renewalhistory;
use App\Models\Business;
use App\Models\Reference;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class Membersearchcontroller extends Controller
{
    public function index(Request $request)
    {
       
        $first_name1 = $request->first_name;
        $categoryid = $request->category_id;
        $request->session()->put('first_name1', $first_name1 ?? null);
        $request->session()->put('categoryid', $categoryid ?? null);     
        $membersQuery = members::query();
        $membersQuery->where('Member_status', 1); 
        $membersQuery->whereDate('SubscriptionExpiredDate', '>', now());

        $membersQuery->when($request->first_name, function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('companyname', 'LIKE', '%' . $request->first_name . '%')
                    ->orWhere('Contact_person', 'LIKE', '%' . $request->first_name . '%')
                    ->orWhere('Brand_name', 'LIKE', '%' . $request->first_name . '%');
            });
        });
       
        $membersQuery->when($request->first_name, fn ($query, $first_name) => $query->orWhereIn(
            'members.id',
            function ($query) use ($first_name) {
                $query->select('member_services.member_id')
                    ->from(with(new Products_service)->getTable())
                    ->where('member_services.product_name', 'LIKE', '%' . $first_name . '%')
                    ->orWhere('member_services.hash_tag', 'LIKE', '%' . $first_name . '%');
            }
        ));
        if ($request->category_id && $request->category_id != 0) {
            $membersQuery->where('category_id', $request->category_id);
        }
        $membersQuery->leftJoin('city_groups', 'members.citygroup_id', '=', 'city_groups.id')
        ->leftjoin('categories','members.category_id','=','categories.id')
        ->select('members.*', 'city_groups.group_name','categories.name as categories_name');

        $members = $membersQuery->paginate(15);
        $Count=$members->count(); 
        return view('Membersearch.index',compact('members','Count'));
    }
    public function Detail(Request $request,$id)
    {
      
        $Member = DB::table('members')
        ->where('id',$id)->first();
        // dd($Member);
        $memberproduct = DB::table('member_services')
        ->where('member_id',$id)->paginate(5);
        return view('Membersearch.Detail',compact('memberproduct','Member'));
    }
}
