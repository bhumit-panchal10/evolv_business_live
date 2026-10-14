<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products_service;
use App\Models\MemberAnnouncement;
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

class MemberAnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::User();
        $memberData = members::select('*')
            ->where('user_id', $user->id)
            ->first();

        $id = $memberData->id;
        $datas = MemberAnnouncement::paginate(env('PAR_PAGE_COUNT', 20));
        $count = $datas->count();
        // dd($datas);
        return view('MemberAnnouncement.index', compact('datas', 'user', 'id', 'count'));
    }
    
    public function otherMemberAnnouncements(Request $request)
    {
        $user = Auth::user();
        $memberData = members::where('user_id', $user->id)->first();
        $id = $memberData->id;
        $datas = MemberAnnouncement::where('member_id', '!=', $id)
            ->paginate(env('PAR_PAGE_COUNT', 20));

        $count = $datas->count();

        return view('MemberAnnouncement.MemberAnnouncement', compact('datas', 'user', 'id', 'count'));
    }
    
    public function adminAllAnnouncements(Request $request)
    {
        $user = Auth::user();
        $datas = MemberAnnouncement::with('member')
            ->orderBy('created_at', 'desc')
            ->paginate(env('PAR_PAGE_COUNT', 20));

        $count = $datas->count();

        return view('MemberAnnouncement.admin-index', compact('datas', 'user', 'count'));
    }

    public function createnew(Request $request, $id)
    {
        $memberid = $id;
        return view('MemberAnnouncement.create', compact('memberid'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'memberid' => 'required',
            'title' => 'required',
        ]);
        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/evolv_business/MemberAnnouncement/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }
        $Data = array(
            'member_id' => $request->memberid,
            'title'    => $request->title,
            'photos'    => $img,
            'description'    => $request->description,
            'created_at' => date('Y-m-d H:i:s'),
        );
        DB::table('MemberAnnouncement')->insert($Data);

        return redirect()->route('MemberAnnouncement.index')->with('success', 'Announcement Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        // dd($request);
        $memberid = $id;
        $data = MemberAnnouncement::where(['id' => $id])
            ->first();
        // echo json_encode($data);

        return view('MemberAnnouncement.edit', compact('data', 'memberid'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',

        ]);

        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/evolv_business/MemberAnnouncement/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
            $oldImg = $request->input('hiddenPhoto') ? $request->input('hiddenPhoto') : null;

            if ($oldImg != null || $oldImg != "") {
                if (file_exists($destinationpath . $oldImg)) {
                    unlink($destinationpath . $oldImg);
                }
            }
        } else {
            $oldImg = $request->input('hiddenPhoto');
            $img = $oldImg;
        }

        $Data = array(
            'member_id' => $request->member_id,
            'title'    => $request->title,
            'description'    => $request->description,
            'photos'    => $img,
            'updated_at' => date('Y-m-d H:i:s'),
            //'updated_by'     => auth()->id()

        );
        //  dd($Data);
        DB::table('MemberAnnouncement')->where('id', $request->awardid)->update($Data);

        return redirect()->route('MemberAnnouncement.index')->with('success', 'Announcement update Successfully.');
    }

    public function delete(Request $request)
    {
        DB::table('MemberAnnouncement')->where(['id' => $request->id])->delete();
        return back()->with('success', 'Announcement Deleted Successfully!.');
    }
}
