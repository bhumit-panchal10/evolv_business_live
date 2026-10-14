<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Models\MetaData;

class ClusterfestFeedbackController extends Controller
{
    
    public function Admin_Clusterfishfeedback_index(Request $request)
    {
        // Read filters
        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');

        // Query builder
        $query = DB::table('clusterfest_feedback');

        // Filter by date range if provided
        if (!empty($fromDate) && !empty($toDate)) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [
                \Carbon\Carbon::createFromFormat('d-m-y', $fromDate)->format('Y-m-d'),
                \Carbon\Carbon::createFromFormat('d-m-y', $toDate)->format('Y-m-d'),
            ]);
        } elseif (!empty($fromDate)) {
            $query->whereDate('created_at', \Carbon\Carbon::createFromFormat('d-m-y', $fromDate)->format('Y-m-d'));
        } elseif (!empty($toDate)) {
            $query->whereDate('created_at', \Carbon\Carbon::createFromFormat('d-m-y', $toDate)->format('Y-m-d'));
        }

        // Paginate results
        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('ClusterfestFeedback.index', compact('feedbacks', 'fromDate', 'toDate'));
    }

    public function destroy($id)
    {
        $feedback = DB::table('clusterfest_feedback')->where('id', $id)->first();

        if (!$feedback) {
            return redirect()->back()->with('error', 'Feedback not found.');
        }

        DB::table('clusterfest_feedback')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Feedback deleted successfully.');
    }

    public function feedbackCount()
    {
        try {
        // Count total feedbacks from your table
        $seo = MetaData::where(['id' => 1])->first();
        $feedbackCount = \DB::table('clusterfest_feedback')->count();

        return view('frontview.ClusterfestFeedbackCount', compact('feedbackCount','seo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
     public function Clusterfishfeedback_thankyou()
    {
         try {
        // Count total feedbacks from your table
     //   $feedbackCount = \DB::table('clusterfest_feedback')->count();
         $seo = MetaData::where(['id' => 1])->first();

        return view('frontview.ClusterfestThankyou',compact('seo'));
         } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    public function Clusterfishfeedback_index()
    {
        try { 
        $seo = MetaData::where(['id' => 1])->first();
        $dates = [
            "23 September, 4:00 PM to 6:00 PM",
            "24 September, 8:15 AM to 9:15 AM", 
            "25 September, 5:30 PM to 7:30 PM",
        ];

        $booked_dates = DB::table('clusterfest_feedback')
            ->select('preferred_date', DB::raw('COUNT(*) as total'))
            ->whereNotNull('preferred_date')
            ->groupBy('preferred_date')
            ->pluck('total', 'preferred_date')
            ->toArray();

        $available_dates = array_values(array_filter($dates, function ($date) use ($booked_dates) {
            return !isset($booked_dates[$date]) || $booked_dates[$date] < 8;
        }));

        return view('frontview.ClusterfestFeedback', compact('available_dates','seo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function Clusterfestfeedback_store(Request $request)
{
    try {
        $dates = [
            "23 September, 4:00 PM to 6:00 PM",
            "24 September, 8:15 AM to 9:15 AM",
            "25 September, 5:30 PM to 7:30 PM",
        ];

        $booked_dates = DB::table('clusterfest_feedback')
            ->select('preferred_date', DB::raw('COUNT(*) as total'))
            ->whereNotNull('preferred_date')
            ->groupBy('preferred_date')
            ->pluck('total', 'preferred_date')
            ->toArray();

        $available_dates = array_values(array_filter($dates, function ($date) use ($booked_dates) {
            return !isset($booked_dates[$date]) || $booked_dates[$date] < 8;
        }));

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'brand_name' => 'required|string|max:100',
            'business_category' => 'nullable|string|max:100',
            'email' => 'required|email|max:150|unique:clusterfest_feedback,email',
            'first_experience' => 'required|in:Yes,No',
            'experience_feedback' => 'required|in:Beyond Expectation,As Per Expectation,Below Expectation',
            'join_next_meet' => 'required|in:Yes,No',
            'preferred_date' => [
                'nullable',
                'required_if:join_next_meet,Yes',
                Rule::in($available_dates),
            ],
        ], [
            'email.unique' => 'This email is already used. Please enter a different one.',
            'preferred_date.required_if' => 'Please select a preferred date if you said "Yes".',
            'preferred_date.in' => 'This date is no longer available. Please choose another one.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Insert into database
        DB::table('clusterfest_feedback')->insert([
            "name" => $request->name,
            "brand_name" => $request->brand_name,
            "business_category" => $request->business_category,
            "email" => $request->email,
            "first_experience" => $request->first_experience,
            "experience_feedback" => $request->experience_feedback,
            "join_next_meet" => $request->join_next_meet,
            "preferred_date" => $request->join_next_meet === 'Yes' ? $request->preferred_date : null,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        
        $sendemaildetails = DB::table('sendemaildetails')->where('id', 2)->first();

        $msg = [
            'FromMail' => $sendemaildetails->strFromMail ?? 'support@evolv.co.in',
            'Title' => $sendemaildetails->strTitle ?? 'Cluster Fest',
            'ToEmail' => $request->email,
            'Subject' => 'Evolve Business Community - Experince Cluster Meeting',
        ];

        $data = [
            'name' => $request->name,
            'brand_name' => $request->brand_name,
            'business_category' => $request->business_category,
            'first_experience' => $request->first_experience,
            'experience_feedback' => $request->experience_feedback,
            'join_next_meet' => $request->join_next_meet,
            'preferred_date' => $request->join_next_meet === 'Yes' ? $request->preferred_date : 'N/A',
        ];
if($request->join_next_meet=='Yes'){
        Mail::send('emails.clusterfestfeedback', ['data' => $data], function ($message) use ($msg) {
            $message->from($msg['FromMail'], $msg['Title']);
            $message->to($msg['ToEmail'])->subject($msg['Subject']);
        });
}
        return view('frontview.ClusterfestThankyou');
        //return redirect()->back()->with('success', 'Thank you for your feedback! We have also sent you a confirmation email.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}
}