<?php

namespace App\Http\Controllers;

use App\Models\City_group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberAbsentReportController extends Controller
{
    public function index(Request $request)
    {
        $rules = [
            'city_group_id' => 'nullable|integer|exists:city_groups,id',
            'from_date' => 'nullable|date_format:Y-m-d',
            'to_date' => 'nullable|date_format:Y-m-d',
        ];

        if ($request->filled('from_date')) {
            $rules['to_date'] .= '|after_or_equal:from_date';
        }

        $request->validate($rules);

        $cityGroups = City_group::orderBy('group_name')->get();
        $reports = collect();
        $searched = $request->query('search') === '1';

        if ($searched) {
            $query = DB::table('Cluster_Meet_Member_meeting as attendance')
                ->join(
                    'Cluster_Meet as meeting',
                    'meeting.id',
                    '=',
                    'attendance.meeting_id'
                )
                ->join(
                    'members as member',
                    'member.id',
                    '=',
                    'attendance.member_id'
                )
                ->join(
                    'city_groups as city_group',
                    'city_group.id',
                    '=',
                    'meeting.city_group_id'
                )
                ->where('attendance.is_approve_meeting', 3)
                ->select(
                    'member.id as member_id',
                    'member.Contact_person as member_name',
                    'city_group.id as city_group_id',
                    'city_group.group_name as city_group_name'
                )
                ->selectRaw(
                    'COUNT(DISTINCT attendance.meeting_id) as absent_count'
                );

            if ($request->filled('city_group_id')) {
                $query->where(
                    'meeting.city_group_id',
                    $request->city_group_id
                );
            }

            if ($request->filled('from_date')) {
                $query->whereDate(
                    'attendance.created_at',
                    '>=',
                    $request->from_date
                );
            }

            if ($request->filled('to_date')) {
                $query->whereDate(
                    'attendance.created_at',
                    '<=',
                    $request->to_date
                );
            }

            $reports = $query
                ->groupBy(
                    'member.id',
                    'member.Contact_person',
                    'city_group.id',
                    'city_group.group_name'
                )
                ->orderByDesc('absent_count')
                ->orderBy('member.Contact_person')
                ->get();
        }

        return view('reports.member_absent', compact(
            'cityGroups',
            'reports',
            'searched'
        ));
    }
}
