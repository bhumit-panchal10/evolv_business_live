<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MetaData;
use App\Models\Categories;
use App\Models\Customer;
use App\Models\CustomerCouponApplyed;
use App\Models\Gallery;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Models\Productphotos;
use App\Models\Testimonial;
use App\Models\Shipping;
use App\Models\State;
use App\Models\Wishlist;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Calculation\Token\Stack;
use Gregwar\Captcha\CaptchaBuilder;
use Auth;
use Razorpay\Api\Api;

class FrontController extends Controller
{
     public function Announcement_delete(Request $request)
    {
        try {
            // $delete = DB::table('Announcement')->where(['id' => $request->id])->first();
            // $root = $_SERVER['DOCUMENT_ROOT'];
            // $destinationpath = $root . '/Announcement/';
            // unlink($destinationpath . $delete->photo);
    
            DB::table('Announcement')->where(['id' => $request->id])->delete();
            return redirect()->route('Announcement.index')->with('success', 'Announcement Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
    public function Announcement_create(Request $request)
    {
        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/Announcement/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }
        $slug=Str::slug($request->Title);
        $Data = array(
            'Title' => $request->Title,
            'photo' => $img,
            'Announcement_slug'=>$slug,
            'description' => $request->description,
            );
        DB::table('Announcement')->insert($Data);
        return redirect()->route('Announcement.index')->with('success', 'Announcement create successfully.');
    }

    public function Announcement_storeview(Request $request)
    {
       return view('Announcement.storeview');
    }
      public function checkDate(Request $request)
    {
       
        $isBooked = DB::table('members')
        ->where('Book_Your_Podcast', $request->input('date'))
        ->exists();
        return response()->json(['isBooked' => $isBooked]);

    }
    public function Announcement_Detail(Request $request,$id)
    {

         $Announcement = DB::table('Announcement')->where('Announcement_slug',$id)->orderBy('id', 'DESC')->first();
         return view('frontview.AnnouncementDetail', compact('Announcement'));
   
    }
   public function Announce_index(Request $request)
   {

        $Events = DB::table('Announcement')->orderBy('id', 'DESC')->paginate(20);
        $Count=$Events->count();
        
        return view('Announcement.index', compact('Events','Count'));
  
   }
   public function Announcement_editview(Request $request,$id)
   {
     
        $Data = DB::table('Announcement')->where('id',$id)->first();
   
        return view('Announcement.edit', compact('Data'));
  
   }
   public function Announcement_update(Request $request)
   {  
        // dd($request);
        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/Announcement/';
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
        $slug=Str::slug($request->Title);
        $Student = DB::table('Announcement')
        ->where('id', $request->id)
        ->update([
            'Title' => $request->Title,
            'photo' => $img,
            'Announcement_slug'=>$slug,
            'description' => $request->description,
        ]);

        return redirect()->route('Announcement.index')->with('success', 'Announcement Updated successfully.');
   }
 
    public function Activity_update(Request $request)
    {
      //    dd($request);

        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            //dd($img);
            $destinationpath = $root . '/Activity/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
            $oldImg = $request->input('hiddenPhoto') ? $request->input('hiddenPhoto') : null;
            //dd($oldImg);

            if ($oldImg != null || $oldImg != "") {
                if (file_exists($destinationpath . $oldImg)) {
                    unlink($destinationpath . $oldImg);
                }
            }
        } elseif ($request->input('hiddenPhoto')) {
            $oldImg = $request->input('hiddenPhoto');
            $img = $oldImg;
        } else {
            // $root = $_SERVER['DOCUMENT_ROOT'];
            // $img = $root . '/images/noimage.jpg';
            //   $img = null;
        }
        $Active = DB::table('Member_Activity')
            ->where(['id' => $request->activity_id])
            ->update([
                'photo' => $img,
                'description' => $request->description,
                "strIP" => $_SERVER['REMOTE_ADDR']
            ]);
      
        return redirect()->route('Activity.index')->with('success', 'Activity Updated Successfully.');
    }
    public function Activity_editview(Request $request,$id=null)
    {
  
        $data = DB::table('Member_Activity')->where(['id' => $id])->first();
        // dd($data);
        echo json_encode($data);
   
    }
    public function Activity_delete(Request $request)
    {
        DB::table('Member_Activity')->where('id',$request->id)->delete();
        return back()->with('success', 'Activity Deleted Successfully!.'); 
   
    }
    public function activity_index(Request $request)
    {
        // $session=auth::user();
        $activity= DB::table('Member_Activity')->paginate(env('PAR_PAGE_COUNT',20));
        $Count=$activity->count();
        return view('Activity.index',compact('Count','activity'));
    }
    public function activity_create(Request $request)
    {
        
        // $session=auth::user();
        $img = "";
        if ($request->hasFile('photo')) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            $image = $request->file('photo');
            $img = time() . '.' . $image->getClientOriginalExtension();
            $destinationpath = $root . '/Activity/';
            if (!file_exists($destinationpath)) {
                mkdir($destinationpath, 0755, true);
            }
            $image->move($destinationpath, $img);
        }
        
        $Data = array(
            // 'user_id'=> 0,
            'photo' => $img,
            'description' => $request->description,
            'created_at'  => date('Y-m-d H:i:s'),
            "strIP" => $_SERVER['REMOTE_ADDR']
        );
        // dd($Data);
        DB::table('Member_Activity')->insert($Data);

        return redirect()->route('Activity.index')->with('success', 'Activity Created Successfully.');
       
    }
   
    public function Admin_induction_index(Request $request)
    {
       $induction =DB::table('induction_meet')
       ->select('induction_meet.*','categories.name as cat_name','categories.id as cat_id')
       ->leftjoin('categories','induction_meet.category_id','=','categories.id')
       ->where('cluster_meet','!=',1)
       ->orderBy('induction_meet.id', 'desc')->paginate(3000);
    
       $Count =$induction->count();
        return view('induction.index', compact('induction','Count'));
    }
    public function clustermetting(Request $request)
    {
      
       $clustermeet =DB::table('induction_meet')
       ->where('cluster_meet','!=',0)
       ->orderBy('induction_meet.checktime', 'asc')->paginate(3000);
       $Count =$clustermeet->count();
  
        return view('induction.clustermetting', compact('clustermeet','Count'));
    }
    public function clustermeet_delete(Request $request)
    {
        DB::table('induction_meet')->where('id',$request->id)->delete();
        return back()->with('success', 'Cluster Meet Deleted Successfully!.');
    }
    public function induction_morning_index(Request $request)
    {
        try {
            $seo = MetaData::where(['id' => 1])->first();
            $category=DB::table('categories')->orderBy('name','asc')->get();
            return view('frontview.induction-morning', compact('category','seo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function induction_morning_index_paid(Request $request)
    {
        try {
             $seo = MetaData::where(['id' => 1])->first();
            $category = DB::table('categories')->orderBy('name', 'asc')->get();
            return view('frontview.induction-morning-paid', compact('category','seo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function visitor_index(Request $request)
    {
        $category=DB::table('categories')->orderBy('name','asc')->get();
        return view('frontview.visitor-cluster', compact('category'));
    }
    public function cluster_visitor_store(Request $request)
    {
    
       // $checktimeString ='';// implode(', ', $request->checktime);
        $data = [
            "type" => $request->type,
            "name" => $request->name,
            "category_id" => $request->category_id,
            "contact_person_name" => $request->contact_person_name,
            "Phonenumber" => $request->Phonenumber,
            "referred_by" => $request->referred_by,
            "reference_name" => $request->reference_name,
            "email" => $request->email,
            "checktime" => $request->check_time,
            "Gst_numbar"=>$request->gstnumber ?? 0,
            "created_at" => date('Y-m-d H:i:s')
        ];
       
        $Data =DB::table('induction_meet')->insertGetId($data);
        //paid
        $getdeta =DB::table('induction_meet')->where('id',$Data)->first();
        $Net_Amount =1499;
    
    $razorpayKey = config('services.razorpay.key');
$api = new Api(
    config('services.razorpay.key'),
    config('services.razorpay.secret')
);

        $order = $api->order->create([
            'receipt'         => 'order_rcptid_' . rand(),
            'amount'          => $Net_Amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 
        ]);
        
         return view('frontview.razorpayView' ,compact('Data','Net_Amount','razorpayKey','getdeta','order'));
        
        //Free
       // return back()->with('success', 'thank you, Your registration done Successfully!.'); 
        
     }
    public function induction_evening_index(Request $request)
    {
        try {
                $seo = MetaData::where(['id' => 1])->first();
                $dates = [
                 
                ];
            
                
                $booked_dates = DB::table('induction_meet')
                              ->select('checktime', DB::raw('count(*) as total'))
                              ->groupBy('checktime')
                              ->pluck('total', 'checktime') 
                              ->toArray();
                $citygroup =DB::table('city_groups')->orderBy('group_name','asc')->get();
           
            $available_dates = array_filter($dates, function($date) use ($booked_dates) {
              
                return !isset($booked_dates[$date]) || $booked_dates[$date] < 9;
            });
        
                return view('frontview.induction-evening', compact('available_dates','citygroup','seo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }        
    }

    public function induction_store(Request $request)
    {
      
       // $checktimeString ='';// implode(', ', $request->checktime);
        $data = [
            "type" => $request->type,
            "name" => $request->name,
            "category_id" => $request->category_id,
            "contact_person_name" => $request->contact_person_name,
            "Phonenumber" => $request->Phonenumber,
            "referred_by" => $request->referred_by,
            "reference_name" => $request->reference_name,
            "email" => $request->email,
            "checktime" => $request->check_time,
            "Gst_numbar"=>$request->gstnumber ?? 0,
            "created_at" => date('Y-m-d H:i:s')
        ];
        // dd($data);
        $Data =DB::table('induction_meet')->insertGetId($data);
        if($request->amount_fee >0 ){
        $getdeta =DB::table('induction_meet')->where('id',$Data)->first();
        $Net_Amount =$request->amount_fee;
        
        $razorpayKey = config('app.RAZORPAY_KEY');
        $api = new Api(config('app.RAZORPAY_KEY'), config('app.RAZORPAY_SECRET'));
        
        $order = $api->order->create([
            'receipt'         => 'order_rcptid_' . rand(),
            'amount'          => $Net_Amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 
        ]);
        
         return view('frontview.razorpayView' ,compact('Data','Net_Amount','razorpayKey','getdeta','order'));
        }else{
          return view('frontview.thankyou');  
        }
     }
     
    public function induction_store_paid(Request $request)
    {
        try {
                $data = [
                    "type" => $request->type,
                    "name" => $request->name,
                    "category_id" => $request->category_id,
                    "contact_person_name" => $request->contact_person_name,
                    "Phonenumber" => $request->Phonenumber,
                    "referred_by" => $request->referred_by,
                    "reference_name" => $request->reference_name,
                    "email" => $request->email,
                    "checktime" => $request->type,
                    "Gst_numbar" => $request->gstnumber ?? 0,
                    "created_at" => date('Y-m-d H:i:s'),
                    "visitor_registration_paid" => 1,
                ];
                $Data = DB::table('induction_meet')->insertGetId($data);
                $getdeta = DB::table('induction_meet')->where('id', $Data)->first();
                $Net_Amount = $request->amount_fee;
                if ($Net_Amount < 1) {
                    return back()->with('error', 'Minimum payment amount must be ₹1 or more.');
                }
        
                $razorpayKey = config('app.RAZORPAY_KEY');
                $api = new Api(config('app.RAZORPAY_KEY'), config('app.RAZORPAY_SECRET'));
                $order = $api->order->create([
                    'receipt'         => 'order_rcptid_' . rand(),
                    'amount'          => $Net_Amount * 100,
                    'currency'        => 'INR',
                    'payment_capture' => 1
                ]);
                return view('frontview.razorpayView_paid', compact('Data', 'Net_Amount', 'razorpayKey', 'getdeta', 'order'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    } 
     public function clustermeet_store(Request $request)
     {    
         $data = [
             "type" => $request->type,
             "name" => $request->name,
             "Phonenumber" => $request->Phonenumber,
             "checktime" => $request->droup_down,
             "cluster_meet"=>1,
             "created_at" => date('Y-m-d H:i:s')
         ];
         $Data =DB::table('induction_meet')->insertGetId($data);
         return back()->with('success', 'Thank you for intrest.Registred in Cluster meet successfully.'); 
      }
    public function ProductInquiry_delete(Request $request)
    {
       
        DB::table('ProductInquiry')->where('id',$request->id)->delete();
        return back()->with('success', 'Product Inquiry Deleted Successfully!.'); 
    }

    public function ProductInquiry_list(Request $request)
    {
        $session = auth::user();
        $member=DB::table('members')->where('user_id',$session->id)->first();
        $product=DB::table('ProductInquiry')->select('ProductInquiry.created_at','ProductInquiry.id as product_inq_id','ProductInquiry.Member_id','ProductInquiry.Product_id','ProductInquiry.Name','ProductInquiry.email','ProductInquiry.Phone_Number','member_services.product_name')
        ->leftjoin('member_services','ProductInquiry.Product_id','=','member_services.id')
        ->where('ProductInquiry.Member_id',$member->id)->orderBy('ProductInquiry.id','desc')->paginate(env('PAR_PAGE_COUNT',20));
        
        $Count=$product->count();

        return view('frontview.Inquirylist', compact('product','Count'));
    }
    // Book Your Podcast
    public function podcastindex(Request $request)
    {
        return view('podcast.podcastindex');
    }
   
    public function podcaststore(Request $request)
   {
        try {
            $session = auth::user();
            $podcastDate = $request->input('Book_Your_Podcast');
            $emaildate = date('d-m-Y', strtotime($podcastDate));
            $year = date('Y', strtotime($podcastDate));
            $month = date('m', strtotime($podcastDate));
            $monthName = strftime('%B', strtotime($podcastDate));
            $existingBooking = DB::table('members')
                ->where('Book_Your_Podcast', $podcastDate)
                ->exists();   
            if ($existingBooking) {
                return redirect()->back()->with('error', 'This podcast date is already booked.');
            }
            $bookingCount = DB::table('members')
                ->whereYear('Book_Your_Podcast', $year)
                ->whereMonth('Book_Your_Podcast', $month)
                ->count();    
            if ($bookingCount >= 9) {
                return redirect()->back()->with('error', 'Bookings for ' . $monthName . ' are full. Please book next month.');
            }
            DB::table('members')->where('user_id', $session->id)->update([
                'Book_Your_Podcast' => $podcastDate,   
            ]);
            
            $sendemaildetails = DB::table('sendemaildetails')->where('id', 5)->first();
        
            $msg = [
                'FromMail' => $sendemaildetails->strFromMail ??  'support@evolv.co.in',
                'Title' => $sendemaildetails->strTitle ??  'Evolve Business Community',
                'ToEmail' => $sendemaildetails->ToMail ?? 'support@evolv.co.in',
                'Subject' => $sendemaildetails->strSubject ?? 'Book Your Podcast' ?? '',
            ];
            
            $data = [
                'Book_Your_Podcast' => $emaildate ?? '',
                'membername' => $session->first_name ?? '',
                'memberemail' => $session->email ?? '',
                'memberphonenumber' => $session->mobile_number ?? ''
            ];
           
            $mail = Mail::send('emails.BookYourPodcast', ['data' => $data], function ($message) use ($msg) {
                $message->from($msg['FromMail'], $msg['Title']);
                $message->to($msg['ToEmail'])->subject($msg['Subject']);
            });
            
            return redirect()->route('Memberhome')->with('success', 'Podcast Created successfully.');  
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
   }
    //Book Member of the week
    public function memberweek(Request $request) 
    {
        return view('podcast.memberweek');
    }
    public function weekstore(Request $request)
   {
       
        try {
    
            $session = auth::user();
            $bookweek = $request->input('Book_Your_Member_of_the_week');
            $Book_week_time = $request->input('Book_week_time');
            $emaildate = date('d-m-Y', strtotime($bookweek));
            
            $existingBooking = DB::table('members')
                            ->where('Book_Your_Member_of_the_week', $request->input('Book_Your_Member_of_the_week'))
                            ->exists();
                            
            if ($existingBooking) {
                return redirect()->back()->with('error', 'This Member of the week already booked.');
            }

            $startDate = new \DateTime($request->Book_Your_Member_of_the_week);
            $endDate = clone $startDate; 
            $endDate->modify('+6 days');
            $endDateFormatted = $endDate->format('Y-m-d');
            $emailenddate=$endDate->format('d-m-Y');
            DB::table('members')->where('user_id', $session->id)->update([
                'Book_Your_Member_of_the_week' => $request->Book_Your_Member_of_the_week,
                'Book_week_time'=>$request->Book_week_time,
                'Member_of_the_week_enddate' => $endDateFormatted,
            ]);
            
           $sendemaildetails = DB::table('sendemaildetails')->where('id', 6)->first();
         
            $msg = [
                'FromMail' => $sendemaildetails->strFromMail ??  'support@evolv.co.in',
                'Title' => $sendemaildetails->strTitle ??  'Evolve Business Community',
                'ToEmail' => $sendemaildetails->ToMail ?? 'support@evolv.co.in',
                'Subject' => $sendemaildetails->strSubject ?? 'Book Your Podcast' ?? '',
            ];
            
            $data = [
                'Bookweekstart' => $emaildate ?? '',
                'Bookweekend' => $emailenddate ?? '',
                'Book_week_time' => $Book_week_time ?? '',
                'membername' =>  $session->first_name ?? '',
                'memberemail' => $session->email ?? '',
                'memberphonenumber' => $session->mobile_number ?? ''
            ];
          
            $mail = Mail::send('emails.BookMemberoftheweek', ['data' => $data], function ($message) use ($msg) {
                $message->from($msg['FromMail'], $msg['Title']);
                $message->to($msg['ToEmail'])->subject($msg['Subject']);
            });
            
            return redirect()->route('Memberhome')->with('success', 'Book Your Member of the week Created Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        try {
               $seo = MetaData::where(['id' => 1])->first();
               $active_member_count = DB::table('members')
               ->where('iStatus', 1)
               ->where('isDelete', 0)
               ->where('arrival_flag', 0)
               ->count();
                $group_count =DB::table('city_groups')
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->count();       
                $total_business_amount = DB::table('Business')
                ->where('isapproved_status', 1)
                ->sum('business_amount');
                $active =DB::table('Member_Activity')->orderBy('id','DESC')->get();
                // dd($active);
                $Ourteem = DB::table('Overteem')
                ->select('Overteem_id','Overteem_name','Overteem_photo', 'description','designation')
                ->where(['iStatus' => 1, 'isDelete' => 0])
               ->paginate(20);

                $service = DB::table('categories')
                ->select('categories.id', 'categories.name', 'categories.photo','categories.category_slug')
                ->join('members', 'categories.id', '=', 'members.category_id')
                ->where('categories.iStatus', 1)
                ->where('categories.isDelete', 0)
                ->paginate(env('PAR_PAGE_COUNT',20));
            
                $Blog = DB::table('blogs')
                ->select('id','user_id', 'blogTitle','content','blogImage','blogDescription','metaTitle','metaKeyword','blogDate','blog_slug')
                ->where(['iStatus' => 1, 'isDelete' => 0 , 'status' => 1])
                ->orderBy('id','desc')->first();

                $Blogs = DB::table('blogs')
                ->select('id','user_id', 'blogTitle','content','blogImage','blogDescription','metaTitle','metaKeyword','blogDate','blog_slug')
                ->where(['iStatus' => 1, 'isDelete' => 0 , 'status' => 1])
                ->orderBy('id','desc')
                ->paginate(env('PAR_PAGE_COUNT',20));

                $Image = DB::table('Adminfrontimage')
                ->select('id','Title','photo', 'button_link')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->paginate(env('PAR_PAGE_COUNT',20));

                $latestEvent = DB::table('news_and_events')
                ->select('event_id', 'user_id', 'name', 'photo', 'description', 'eventstart_date', 'eventend_date', 'ispaid', 'price', 'limitedset', 'setnumber','event_slug')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->orderBy('eventstart_date', 'desc')
                ->first();


                $videos = DB::table('video_gallery')
                ->select('video_id', 'name', 'vidoeurl', 'comments')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->orderBy('video_id', 'desc')
                ->limit(1)
                ->paginate(1);
                // dd($Videos);

                //  dd($Ourteem);
                return view('frontview.index', compact('seo','total_business_amount','group_count','active_member_count','Ourteem','service','Blog','Blogs','Image','latestEvent','active','videos'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        
    }
    public function about(Request $request)
    {
        try {
            $seo = MetaData::where(['id' => 2])->first();
              $Ourteem = DB::table('Overteem')
                ->select('Overteem_id','Overteem_name','Overteem_photo', 'description','designation')
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->where('isteam', 1)
                ->paginate(env('PAR_PAGE_COUNT',20));
        return view('frontview.about', compact('Ourteem','seo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function contactus(Request $request)
    {
        return view('frontview.contact');
    }
    public function explore(Request $request)
    {
        try {
                //  dd($request);
                $seo = MetaData::where(['id' => 2])->first();
                $Ourteem = DB::table('Overteem')
                ->select('Overteem_id','Overteem_name','Overteem_photo', 'description','designation')
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->paginate(env('PAR_PAGE_COUNT',20));
                return view('frontview.exploreus', compact('Ourteem','seo'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
      
    }
       public function tcf(Request $request)
    {
        try {
                //  dd($request);
                $seo = MetaData::where(['id' => 18])->first();
              
                return view('frontview.tcf', compact('seo'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
      
    }
        public function learning(Request $request)
    {
        try {
                //  dd($request);
                $seo = MetaData::where(['id' => 2])->first();
                return view('frontview.learning', compact('seo'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
      
    }
    public function dicover(Request $request)
    {
        try {
                $seo = MetaData::where(['id' => 3])->first();
                return view('frontview.dicoverus', compact('seo'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }
    public function product(Request $request)
    {

        return view('frontview.product');
    }
    public function news(Request $request)
    {
        try {
                $seo = MetaData::where(['id' => 4])->first();
                $News = DB::table('news_and_events')
                ->select('event_id','user_id','name', 'description','photo','eventstart_date','eventend_date','ispaid','price','limitedset','setnumber','event_slug')
                ->where('iStatus', 1)
                ->where('isDelete', 0)
                ->orderBy('event_id','desc')
                ->paginate(env('PAR_PAGE_COUNT',20));
               
                return view('frontview.news', compact('News','seo'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
       
    }
    public function newsdetail(Request $request,$Id)
    {
        // dd($Id);
        try {
                $seo = MetaData::where(['id' => 6])->first();
                $slug_to_id =DB::table('news_and_events')->where('event_slug',$Id)->first();

                $news = $slug_to_id->event_id;
                $Newsdetail = DB::table('news_and_events')
                ->select('event_id','user_id','name', 'description','photo','eventstart_date','eventend_date','ispaid','price','limitedset','setnumber')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'event_id' => $slug_to_id->event_id ])
                ->first(10);
                $users =$Newsdetail->user_id;
                $user =DB::table('users')
                ->select('*')
                ->where(['Status' => 1,'id' => $users])->first();

                $resentpost = DB::table('news_and_events')
                ->select('event_id','user_id','name', 'description','photo','eventstart_date','eventend_date','ispaid','price','limitedset','setnumber')
                ->where(['iStatus' => 1, 'isDelete' => 0 ,'user_id' =>$users ])
                ->paginate(10);

                $comment =DB::table('member_news_comment')
                ->select('id','news_id')
                ->where(['iStatus' => 1, 'isDelete' => 0 ,'news_id' =>$news ])->get();

                $newscountcount =$comment->count();
                // dd('call');
                //  dd($Newsdetail);
                return view('frontview.news-detail', compact('Newsdetail','resentpost','news','newscountcount','seo'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
       
    }
    public function photoalbum(Request $request)
    {
        //  dd('call');
        try {
                $seo = MetaData::where(['id' => 5])->first();
                $photos = DB::table('photo_gallery')
                    ->select('gallery_id', 'eventId', 'photo','name','photo_slug')
                    ->where('iStatus', 1)
                    ->where('isDelete', 0)
                    ->paginate(env('PAR_PAGE_COUNT',20));

                return view('frontview.photo-album', compact('photos','seo'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }
    public function photogallery(Request $request,$Id)
    {
        try {
            $seo = MetaData::where(['id' => 7])->first();
                $slug_to_id =DB::table('photo_gallery')->where('photo_slug',$Id)->first();
                $photosgallery = DB::table('photo_gallery_detail')
                ->select('gallery_detail_id', 'photo')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'gallery_id' => $slug_to_id->gallery_id])
                ->paginate(12);

                // dd($slug_to_id);
                return view('frontview.photo-gallery', compact('photosgallery','slug_to_id','seo'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
    }
    public function videogallery(Request $request)
    {
        //  dd($request);
        try {
              $seo = MetaData::where(['id' => 8])->first();
                $videos = DB::table('video_gallery')
                ->select('video_id', 'name', 'vidoeurl','eventid','comments','date')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->orderBy('video_id','desc')
                ->paginate(env('PAR_PAGE_COUNT',20));
                
                // dd($video);
                return view('frontview.video-gallery', compact('videos','seo'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        
    }
    public function frontblog(Request $request)
    {
        try { 
                // $Blog = DB::table('blogs')
                // ->select('id','user_id', 'blogTitle','content','blogImage','blogDescription','metaTitle','metaKeyword','blogDate','blog_slug')
                // ->where(['iStatus' => 1, 'isDelete' => 0 , 'status' => 1])
                // ->orderBy('id','desc')
                // ->paginate(env('PAR_PAGE_COUNT'));
                $seo = MetaData::where(['id' => 9])->first();
                $Blog = DB::table('blogs')
                ->select(
                    'blogs.id as blog_id',
                    'blogs.user_id as blog_user_id',
                    'blogs.blogTitle',
                    'blogs.content',
                    'blogs.blogImage',
                    'blogs.blogDescription',
                    'blogs.metaTitle',
                    'blogs.metaKeyword',
                    'blogs.blogDate',
                    'blogs.blog_slug',
                    'members.user_id as member_user_id',
                    'members.category_id as member_category_id',
                    'categories.id as categoriesmaster_id',
                    'categories.name as category_name',
                    'members.Contact_person'
                )
                ->leftJoin('members', 'blogs.user_id', '=', 'members.user_id')
                ->leftJoin('categories', 'members.category_id', '=', 'categories.id')
                ->where(['blogs.iStatus' => 1, 'blogs.isDelete' => 0, 'blogs.status' => 1])
                ->orderBy('blogs.id','desc')
                ->paginate(env('PAR_PAGE_COUNT',20));
            
                return view('frontview.blog', compact('Blog','seo'));
            } catch (Exception $e){
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage()); 
            }
        
    }
    public function blogdetail(Request $request,$Id)
    {
        try { 
                $seo = MetaData::where(['id' => 10])->first();
                $slug_to_id =DB::table('blogs')->where('blog_slug',$Id)->first();

                $blogid = $slug_to_id->id;
                $Blogdetail = DB::table('blogs')
                ->select('id','user_id', 'blogTitle','content','blogImage','blogDescription','metaTitle','metaKeyword','blogDate')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'id' => $slug_to_id->id ,'status' => 1])
                ->first();
                $users =$Blogdetail->user_id;
                $Member =DB::table('members')->select('members.id as member_id','members.category_id','categories.id as categoriesmaster_id','categories.name')
                ->leftjoin('categories','members.category_id','=','categories.id')
                ->where('members.user_id',$users)->first();
                $user =DB::table('users')
                ->select('*')
                ->where(['Status' => 1,'id' => $users])->first();
                $resentpost = DB::table('blogs')
                ->select('id','user_id', 'blogTitle','content','blogImage','blogDescription','metaTitle','metaKeyword','blogDate')
                ->where(['iStatus' => 1, 'isDelete' => 0 , 'status' => 1 ,'user_id' =>$users ])
                ->paginate(env('PAR_PAGE_COUNT',20));
                $comment =DB::table('memberblog_comment')
                ->select('id','blog_id')
                ->where(['iStatus' => 1, 'isDelete' => 0 ,'blog_id' =>$blogid ])->get();
                $blogcountcount =$comment->count();

            return view('frontview.blog-detail', compact('Blogdetail','user','resentpost','blogid','blogcountcount','Member','slug_to_id','seo'));
            } catch (Exception $e){
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage()); 
            }
       
    }
    public function contactusindex(Request $request)
    {
        try { 
                $seo = MetaData::where(['id' => 11])->first();
                return view('frontview.contact-us',compact('seo'));
            } catch (Exception $e){
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage()); 
            }
    }
    public function frontlogin(Request $request)
    {
        $seo = MetaData::where(['id' => 12])->first();
        return view('frontview.front-login',compact('seo'));
    }
    public function contectthankyou(Request $request)
    {
       
        return view('frontview.front-login');
    }
    public function blogcomment(Request $request)
    {
       $data = array(
        'blog_id' => $request->blog_id,
        'name' => $request->name,
        'email' => $request->email,
        'message' => $request->message,
        "strIp" => $request->ip(),
        "created_at" => date('Y-m-d H:i:s')
        );
            // dd($data);
            DB::table('memberblog_comment')->insert($data);
            return back();
                // return view('frontview.front-login');
    }
    public function newscomment(Request $request)
    {
        if($request->ispaid == 1){
          
             $data = array(
                'news_id' => $request->news_id,
                'name' => $request->name,
                'email' => $request->email,
                'companyname'=>$request->companyname,
                'businesscategory'=>$request->businesscategory,
                'phonenumber'=>$request->number,
                'message' => $request->message,
                'referred_by' => $request->referred_by ?? '',
                'reference_name' => $request->reference_name ?? '',
                "strIp" => $request->ip(),
                "amount"=>$request->amount ?? 0,
                "ispaid"=> 1,
                "created_at" => date('Y-m-d H:i:s')
              );
                 $Data = DB::table('member_news_comment')->insertGetId($data);
                 $getdeta = DB::table('member_news_comment')->where('id', $Data)->first();
                 $Net_Amount = $request->amount ?? 0 ;
                 
                $razorpayKey = config('app.RAZORPAY_KEY');
                $api = new Api(config('app.RAZORPAY_KEY'), config('app.RAZORPAY_SECRET'));
                 
               
                 $order = $api->order->create([
                    'receipt'         => 'order_rcptid_' . rand(),
                    'amount'          => $Net_Amount * 100, 
                    'currency'        => 'INR',
                    'payment_capture' => 1 
                ]);
                return view('frontview.event_razorpayView' ,compact('Data','Net_Amount','razorpayKey','getdeta','order'));
            
        }else{
             $data = array(
                'news_id' => $request->news_id,
                'name' => $request->name,
                'email' => $request->email,
                'companyname'=>$request->companyname,
                'businesscategory'=>$request->businesscategory,
                'phonenumber'=>$request->number,
                'message' => $request->message,
                'referred_by' => $request->referred_by ?? '',
                'reference_name' => $request->reference_name ?? '',
                "strIp" => $request->ip(),
                "created_at" => date('Y-m-d H:i:s')
              );
            DB::table('member_news_comment')->insert($data);
            return back();
        }
                // return view('frontview.front-login');
    }
    public function frontregister(Request $request)
    { 
        try {  
                $seo = MetaData::where(['id' => 18])->first();
                $category = Categories::select('id', 'name')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->get();
                $citygroup =DB::table('city_groups')->orderBy('group_name','asc')->get();
            //    dd($category);
            return view('frontview.frontregister', compact('category','citygroup','seo'));    
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }  
    } 
   public function getNewsData(Request $request,$id)
    {
        // dd($id);
        $data =DB::table('member_news_comment')
        ->select('id','news_id','name','email','message')
        ->where(['iStatus' => 1,'isDelete' => 0,'news_id' => $id])->get();

        echo json_encode($data);    
    }
    public function registerstore1(Request $request)
    {
        // dd($request);
        try {  
                $request->validate([
                    'documents'    => 'required|file|mimes:doc,docx,pdf,jpeg,jpg',
                    'business_establishment_year' => 'required|file|mimes:doc,docx,pdf,jpeg,jpg',
                ]);
        
                $img = "";
                if ($request->hasFile('documents')) {
                    $root = $_SERVER['DOCUMENT_ROOT'];
                    $image = $request->file('documents');
                    $img = time() . '.' . $image->getClientOriginalExtension();
                    $destinationpath = $root . '/registerdocuments/';
                    if (!file_exists($destinationpath)) {
                        mkdir($destinationpath, 0755, true);
                    }
                    $image->move($destinationpath, $img);
                }
                $doc = "";
                if ($request->hasFile('business_establishment_year')) {
                    $root = $_SERVER['DOCUMENT_ROOT'];
                    $image = $request->file('business_establishment_year');
                    $doc = time() . '.' . $image->getClientOriginalExtension();
                    $destinationpath = $root . '/business_establishment_year/';
                    if (!file_exists($destinationpath)) {
                        mkdir($destinationpath, 0755, true);
                    }
                    $image->move($destinationpath, $doc);
                }
                // dd($doc);
                $data = array(
                    'reg_name'                => $request->name,
                    'email'                   => $request->email,
                    'Phonenumber'             => $request->Phonenumber,
                    'reg_business_segment'    => $request->business_segment,
                    'reg_category'            => $request->category,
                    'reg_businessFirm'        => $request->businessFirm,
                    'reg_OfficeAddress'       => $request->RegisteredOfficeAddress,
                    'reg_Other_Address'       => $request->Other_Address,
                    'reg_designation'         => $request->designation,
                    'reg_Inceptionyear'       => $request->Business_Inception_year,
                    'reg_annual_turnover'     => $request->annual_turnover,
                    'business_documents_brand' => $request->business_documents_brand,
                    'industry'                => $request->industry,
                    'industry_subcategory'    => $request->industry_subcategory,
                    'representative_name'     => $request->representative_name,
                    'chapter'                 => $request->chapter,
                    'payment_mode'            => $request->payment_mode,
                    'documents'               => $img,
                    'business_establishment_year' => $doc,
                    "strIp"                   => $request->ip(),
                    "created_at"              => date('Y-m-d H:i:s')
                );
                // dd($data);
                DB::table('Register_frontview')->insert($data);
                return back()->with('success', 'Your Register Inquiry Create Successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
            }       
    }
    public function category_detail(Request $request,$id)
    {
     return view('frontview.category-detail');
        
    }
    public function contact_us(Request $request)
    {
        $request->validate([
                'contact_name' => 'required',
                'contact_email' => 'required',
                'contact_phone' => 'required|digits:10',
                'captcha' => 'required|captcha',
                ]
                ,
                [
                    // 'captcha.captcha' => 'Invalid captcha code.'
                    'captcha.required' => 'Captcha is required.',
                    'captcha.captcha' => 'Invalid captcha code.',
                ]
                
            );
            $data = array(
                'name' => $request->contact_name,
                'email' => $request->contact_email,
                'mobileNumber' => $request->contact_phone,
                'message' => $request->contact_message,
                "strIp" => $request->ip(),
                "created_at" => date('Y-m-d H:i:s')
            );
           
            DB::table('inquiry')->insert($data);

            $sendemaildetails = DB::table('sendemaildetails')->where('id', 4)->first();
      
            $msg = [
                'FromMail' => $sendemaildetails->strFromMail ??  'support@evolv.co.in',
                'Title' => $sendemaildetails->strTitle ??  'Evolve Business Community',
                'ToEmail' =>$sendemaildetails->ToMail ?? 'support@evolv.co.in',
                'Subject' => $sendemaildetails->strSubject ?? 'contact us' ?? '',
            ];
    
            $Maildata = [
                'name' => $request->contact_name ?? '',
                'email' => $request->contact_email ?? '',
                'mobile' =>  $request->contact_phone ?? '',
                'message' => $request->contact_message ?? ''
            ];
          
            $mail = Mail::send('emails.contactus', ['data' => $Maildata], function ($message) use ($msg) {
                $message->from($msg['FromMail'], $msg['Title']);
                $message->to($msg['ToEmail'])->subject($msg['Subject']);
            });

            DB::commit();
            // return back();
            return view('frontview.ContactThankyou');
          
    }
    public function frontlogout(Request $request)
    {
        Auth::logout();
        Session::flush(); // Clear all session data
        return view('frontview.frontlogout');
    } 
    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
    public function productpopupview(Request $request, $id)
    {
        echo $this->ProductDetails($id);
    }
    public function ProductDetails($id)
    {
        $Product = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isStock',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
        )
            ->orderBy('productId', 'desc')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'productId' => $id])
            ->first();
        // dd($Product);
        $Attribute = ProductAttributes::select(
            'product_attributes.id',
            'product_attributes.product_id',
            'product_attributes.product_attribute_id',
            'product_attributes.product_attribute_weight',
            // 'product.productId',
        )
            ->where(['product_attributes.product_id' => $Product->productId])
            ->get();

        $Productphotos = Productphotos::where(['iStatus' => 1, 'isDelete' => 0, 'productid' => $id])->get();
        DB::commit();
        return view('frontview.productpopupview', compact('Product', 'Productphotos', 'Attribute'));
    }
    public function checkout(Request $request)
    {
        $Coupon = $request->session()->get('data');

        $session = Session::get('customerid');

        $cartItems = \Cart::getContent();
        $Shipping = Shipping::orderBy('id', 'desc')->first();
        // $Coupon = CustomerCouponApplyed::where('customerId', "=", $id)->first();
        // dd($Coupon);
        DB::commit();
        $State = State::orderBy('stateName', 'asc')->get();

        return view('frontview.checkout', compact('Shipping', 'Coupon', 'State'));
    }
    public function checkoutstore(Request $request)
    {
        // dd($request);
        $random = Str::random(8);
        $password = Hash::make($random);;
        $cartItems = \Cart::getContent();
        // dd($cartItems);
        $Shipping = Shipping::orderBy('id', 'desc')->first();
        $ShippingCharges = $Shipping->rate;
        $amount = \Cart::getTotal();
        $netamount = $amount + $ShippingCharges;
        $Mobile = Customer::where(['isDelete' => 0, 'iStatus' => 1, 'customeremail' => $request->billEmail])->first();

        $customerid = 0;
        if ($Mobile == null) {
            $Order = array(
                'customername' => $request->billFirstName . ' ' . $request->billLastName,
                'password' => $password,
                'customermobile' => $request->billPhone,
                'customeremail' => $request->billEmail,
                'created_at' => date('Y-m-d H:i:s'),
                'strIP' => $request->ip()
            );
            $customerid = DB::table('customer')->insertGetId($Order);
        } else {
            $customerid = $Mobile->customerid;
        }




        $Order = array(
            'customerid' => $customerid,
            'shipping_cutomerName' => $request->billFirstName . ' ' . $request->billLastName,
            'shipping_companyName' => $request->billCompanyName,
            'shipping_mobile' => $request->billPhone,
            'shipping_email' => $request->billEmail,
            'shiiping_address1' => $request->billStreetAddress1,
            'shiiping_address2' => $request->billStreetAddress2,
            'shipping_city' => $request->billCity,
            'shiiping_state' => $request->billState,
            'shipping_pincode' => $request->billPinCode,
            'orderNote' => $request->billNotes,
            'amount' => $amount,
            'discount' => $request->discount,
            'shipping_Charges' => $request->shippingcharges,
            'netAmount' => $request->netamount,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        $OrderId = DB::table('order')->insertGetId($Order);

        foreach ($cartItems as $cartItem) {
            $OrderDetail = array(
                'orderID' => $OrderId,
                'customerid' => $customerid,
                'productId' => $cartItem->id,
                'quantity' => $cartItem->quantity,
                'weight' => $cartItem->weight,
                'rate' => $cartItem->price,
                'amount' => $cartItem->price * $cartItem->quantity,
                'isPayment' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                "strIP" => $request->ip()
            );
            DB::table('orderdetail')->insert($OrderDetail);
        }

        // $SendEmailDetails = DB::table('sendemaildetails')
        //     ->where(['id' => 9])
        //     ->first();

        // $msg = array(
        //     'FromMail' => $SendEmailDetails->strFromMail,
        //     'Title' => $SendEmailDetails->strTitle,
        //     'ToEmail' => "dev2.apolloinfotech@gmail.com",
        //     'Subject' => $SendEmailDetails->strSubject
        // );
        // // dd($msg);

        // $mail = Mail::send('emails.checkoutmail', ['Order' => $Order], function ($message) use ($msg) {
        //     $message->from($msg['FromMail'], $msg['Title']);
        //     $message->to($msg['ToEmail'])->subject($msg['Subject']);
        // });
        $state = State::select('stateName')->where(['stateId' => $request->billState])->orderBy('stateName', 'asc')->first();
        $Order['stateName'] = $state->stateName ?? '';
        \Cart::clear();

        // return back();
        return view('frontview.dataFrom', compact('Order', 'OrderId'));
    }
    public function couponcodeapply(Request $request)
    {
        // dd($request);
        $session = Session::get('customerid');
        // dd($session);
        $Offer = Offer::where(['iStatus' => 1, 'isDelete' => 0, 'offercode' => $request->coupon])->first();
        // dd($Offer);
        $CouponApply = CustomerCouponApplyed::where(['customerId' => $session, 'offerId' => $Offer->id])->count();
        // dd($CouponApply);
        $Today = date('Y-m-d');
        // dd($Today);
        $Coupon = $request->coupon ?? "";
        $Total = $request->totalAmount ?? 0;
        $Percentage = $Offer->type ?? null;
        $OfferCode = $Offer->offercode ?? null;
        // echo $Offer->startdate;
        // echo $Offer->enddate;
        // dd([$Coupon, $OfferCode]);

        // if ($CouponApply <= 0) {
        if ($Coupon == $OfferCode) {
            if ($Total >= $Offer->minvalue) {
                // dd('mainif');
                // 2023-10-05 >= 2023-10-02 && 2023-10-05  <= 2023-10-07
                if (($Today >= $Offer->startdate) && ($Today <= $Offer->enddate)) {

                    $result = (($Total * 1)) * (($Percentage * 1) / (100 * 1));
                    $resultround = round($result);
                    $data = array(
                        'offerId' => $Offer->id,
                        'customerId' => $session ?? 0,
                        'result' => $resultround,
                        'created_at' => date('Y-m-d H:i:s'),
                        "strIP" => $request->ip()
                    );
                    $Coupon = CustomerCouponApplyed::create($data);

                    return redirect()->route('checkout')->with([
                        'couponapply' => 'Coupon Code Apply Successfully!',
                        'data' => $Coupon
                    ]);
                } else {
                    return redirect()->back()->with('couponexpire', 'Coupon is expired!');
                }
            } else {
                return redirect()->back()->with('minvalue', 'Please Enter Min Value!');
            }
        } else {
            return redirect()->back()->with('couponnotmatch', 'Coupon Code Not Match!');
        }
        // } else {
        //     return redirect()->back()->with('couponused', 'Coupon Code Already Used!');
        // }
    }
    public function ccavRequestHandler()
    {
        return view('frontview.ccavRequestHandler');
    }
    public function payment_success()
    {
        return view('frontview.payment_success');
    }
    public function payment_fail()
    {
        return view('frontview.payment_fail');
    }
    public function frontloginstore(Request $request)
    {
        $request->validate(
            [
                'customeremail' => 'required',
                'password' => 'required',
            ],
            [
                'customeremail.required' => 'Email is required!',
                'password.required' => 'Password is required!',
            ]
        );

        $credentials = $request->only('customeremail', 'password');
        $Customer = Customer::where('customeremail', $request->get('customeremail'))->first();

        if (isset($Customer) && (!empty($Customer))) {
            if (Hash::check($request->password, $Customer->password)) {
                $request->session()->put('customerid', $Customer->customerid);
                $request->session()->put('customername', $Customer->customername);
                $request->session()->put('customermobile', $Customer->customermobile);
                $request->session()->put('customeremail', $Customer->customeremail);
                return redirect()->route('FrontIndex');
            } else {
                return back()->with('error', 'Password Not Match');
            }
        } else {
            return back()->with('error', 'Email Is Not Registered');
        }
    }
    public function register(Request $request)
    {
        // dd('register');
        return view('frontview.register');
    }
    public function registerstore(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                'customername' => 'required',
                'customeremail' => 'required|unique:customer,customeremail',
                'customermobile' => 'required|unique:customer,customermobile|numeric|digits:10',
                'captcha' => 'required',
                // 'password' => 'required|confirmed',
                // 'confirmpassword' => 'required',
            ],
            [
                'captcha.required' => 'Captcha is required!',
                // 'captcha.captcha' => 'Invalid captcha code!',
                'customername.required' => 'Name is required!',
                'customeremail.required' => 'Email is required!',
                'customeremail.unique'    => 'Email is already used!',
                'customermobile.required' => 'Mobile is required!',
                'customermobile.unique'    => 'Mobile is already used!',
                'customermobile.numeric'    => 'Mobile is only numeric allowed!',
                'customermobile.digits'    => 'Mobile is only 10 digits allowed!',
                // 'password.required' => 'Password is required!',
                // 'password.confirmed' => 'Password And Confirm Password Not Match!',
                // 'confirmpassword.required' => 'Confirm Password is required!',
            ]
        );

        $password = $request->password;
        $confirmpass = $request->confirmpassword;

        $userInput = $request->input('captcha');
        $captcha = session('captcha');

        if ($userInput === $captcha) {
            if ($password == $confirmpass) {
                $Data = array(
                    'customername' => $request->customername,
                    'customermobile' => $request->customermobile,
                    'customeremail' => $request->customeremail,
                    'password' => Hash::make($password),
                    'created_at' => date('Y-m-d H:i:s'),
                    "strIP" => $request->ip()
                );
                DB::table('customer')->insert($Data);

                return redirect()->route('FrontLogin')->with('success', 'Register Successfully!');
            } else {
                return back()->with('error', 'Something Went Wrong!');
            }
        } else {
            // return back()->with('invalidcaptcha', 'Invalid captcha code!');
            return redirect()->route('register')->with('invalidcaptcha', 'Invalid captcha code!');
        }
    }
    //Forgot Password Page
    public function forgotpassword(Request $request)
    {
        return view('frontview.forgotpassword');
    }
    //send mail for new pass
    public function forgotpasswordsubmit(Request $request)
    {
        $Customer = DB::table('customer')->where(['customeremail' => $request->customeremail, 'iStatus' => 1, 'isDelete' => 0])->first();

        if (!empty($Customer)) {
            $token = Str::random(64);
            $data = array(
                'customeremail' => $request->customeremail,
                'fetch' => $Customer,
                'token' => $token,
            );
            $update = DB::table('customer')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $Customer->customerid])
                ->update([
                    'token' => $token,
                ]);

            $SendEmailDetails = DB::table('sendemaildetails')
                ->where(['id' => 8])
                ->first();
            $sendmail = $request->customeremail;
            $msg = array(
                'FromMail' => $SendEmailDetails->strFromMail,
                'Title' => $SendEmailDetails->strTitle,
                'ToEmail' => $request->customeremail,
                'Subject' => $SendEmailDetails->strSubject
            );

            $root = $_SERVER['DOCUMENT_ROOT'];
            $file = file_get_contents($root . '/mailers/forgetpassword.html', 'r');
            $file = str_replace('#name', $data['fetch']->customername, $file);
            $file = str_replace('#email', 'https://www.mbherbals.com/New-Password/' . $token, $file);
            // dd($file);
            $setting = DB::table("setting")->select('email')->first();
            $toMail = $sendmail; //$setting->email;// "shahkrunal83@gmail.com";//
            // dd($toMail);
            $to = $toMail;
            $subject = $SendEmailDetails->strSubject;
            $message = $file;
            $header = "From:" . $SendEmailDetails->strFromMail . "\r\n";
            //$header .= "Cc:afgh@somedomain.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $message, $header);


            // $mail = Mail::send('emails.forgetpassword', ['data' => $data], function ($message) use ($msg) {
            //     $message->from($msg['FromMail'], $msg['Title']);
            //     $message->to($msg['ToEmail'])->subject($msg['Subject']);
            // });

            return back()->with('success', 'We have emailed your password reset link!');
        } else {
            return back()->with('error', 'Email Is Not Registered');
        }
    }
    public function newpassword(Request $request, $token)
    {
        return view('frontview.newpassword', ['token' => $token]);
    }
    public function newpasswordsubmit(Request $request)
    {
        $newpassword = $request->newpassword;
        $confirmpassword = $request->confirmpassword;

        $Customer = DB::table('customer')->where(['token' => $request->token, 'iStatus' => 1, 'isDelete' => 0])->first();


        if ($Customer->token == $request->token) {
            if ($newpassword == $confirmpassword) {
                $Student = DB::table('customer')
                    ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $Customer->customerid])
                    ->update([
                        'password' => Hash::make($request->confirmpassword),
                        'token' => null,
                    ]);
                return redirect()->route('FrontLogin')->with('success', 'Your password has been successfully changed!');
            } else {
                return back()->with('error', 'Password And Confirm Password Does Not Match.');
            }
        } else {
            return back()->with('error', 'Token Not Match.');
        }
    }
    public function profile(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            return view('frontview.profile');
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }
    public function myaccount(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            return view('frontview.myaccount');
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }
    public function myaccountedit(Request $request)
    {
        $session = Session::get('customerid');
        $request->session()->forget('customername');
        $request->session()->forget('customeremail');
        $request->session()->forget('customermobile');
        // dd($session);

        // $request->validate(
        //     [
        //         'customeremail' => 'unique:customer,customeremail,' . $session . ',customerid',
        //         'customermobile' => 'unique:customer,customermobile' . $session . ',customerid',
        //     ],
        //     [
        //         'customeremail.unique'    => 'Email is already used!',
        //         'customermobile.unique'    => 'Mobile is already used!',
        //     ]
        // );

        $update = DB::table('customer')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $session])
            ->update([
                'customername' => $request->customername,
                'customeremail' => $request->customeremail,
                'customermobile' => $request->customermobile,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        // dd($update);
        $request->session()->put('customername', $request->customername);
        $request->session()->put('customeremail', $request->customeremail);
        $request->session()->put('customermobile', $request->customermobile);

        return back()->with('myaccountupdatesuccess', 'Profile Updated Successfully!');
    }
    public function changepassword(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            return view('frontview.changepassword');
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }
    public function changepasswordsubmit(Request $request)
    {
        $session = Session::get('customerid');
        $newpassword = $request->newpassword;
        $confirmpassword = $request->confirmpassword;

        if ($newpassword == $confirmpassword) {
            $Student = DB::table('customer')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'customerid' => $session])
                ->update([
                    'password' => Hash::make($request->confirmpassword),
                ]);
            return back()->with('passwordsuccess', 'Change Password Successfully!');
        } else {
            return back()->with('passworderror', 'Password And Confirm Password Not Match!');
        }
    }
    public function myorders(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            $session = Session::get('customerid');
            $Order = Order::where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.customerid' => $session])
                // ->join('product', 'orderdetail.productId', '=', 'product.productId')
                ->paginate(10);
            // dd($Order);
            return view('frontview.myorders', compact('Order'));
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }
    public function myordersdetails(Request $request, $id)
    {
        // dd($request->session());
        if ($request->session()->get('customerid') != "") {
            $session = Session::get('customerid');
            $Order = OrderDetail::select(
                'orderdetail.orderID',
                'orderdetail.created_at',
                'orderdetail.quantity',
                'orderdetail.weight',
                'orderdetail.rate',
                'orderdetail.amount',
                'product.productname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo')
            )
                ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.customerid' => $session, 'orderdetail.orderID' => $id])
                ->join('product', 'orderdetail.productId', '=', 'product.productId')
                ->get();
            // dd($Order);
            return view('frontview.myordersdetails', compact('Order'));
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }
    public function mywishlistpage(Request $request)
    {
        if ($request->session()->get('customerid') != "") {
            $session = Session::get('customerid');
            $wishlist = wishlist::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBY('id', 'desc')
                ->where(['wishlist.iStatus' => 1, 'wishlist.isDelete' => 0, 'wishlist.customerid' => $session])
                ->join("product", "wishlist.productid", '=', 'product.productId')
                ->get();
            // dd($wishlist);

            return view('frontview.mywishlist', compact('wishlist'));
        } else {
            return redirect()->route('FrontLogin')->with('error', 'Invalid Email or Password');
        }
    }
    public function addwishlist(Request $request)
    {
        $session = Session::get('customerid');
        $wishlist = Wishlist::where(['wishlist.iStatus' => 1, 'wishlist.isDelete' => 0, 'wishlist.customerid' => $session, 'productid' => $request->productid])
            ->count();

        if (isset($session) && (!empty($session))) {
            if ($wishlist == 0) {
                $data = array(
                    "customerid" => $session,
                    "productid" => $request->productid,
                );
                wishlist::create($data);
                return back()->with('wishlistsuccess', 'Product Added To Wishlist!');
            } else {
                return back()->with('wishlisterror', 'Product Is Already In Your Wishlist');
            }
        } else {
            return redirect()->route('FrontLogin');
        }
    }
    public function isfeatures(Request $request, $id = null)
    {
        $Category = Category::orderBy('categoryId', 'desc')->get();
        // dd($id);
        if ($id == null) {
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1])
                ->paginate(10);

            $ProductCount = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1])
                ->count();
        } else {
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1, 'category.slugname' => $id])
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                ->paginate(16);
            $ProductCount = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1, 'category.slugname' => $id])
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                ->count();
        }

        // dd($Product);

        return view('frontview.isFeatures', compact('Product', 'Category', 'ProductCount', 'id'));
    }
    public function searchfeaturesproduct(Request $request)
    {
        // dd($request);
        $product = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isFeatures',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
            DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
            DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
        )
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1])
            ->paginate(16);

        if ($request->keyword != '') {
            $product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->where('productname', 'LIKE', '%' . $request->keyword . '%')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1])
                ->get();
        }
        return response()->json([
            'product' => $product
        ]);
    }
    public function searchproduct(Request $request)
    {
        // dd($request);
        $perPage = 16; // Number of items per page

        $product = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isFeatures',
            'product.slugname',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
            DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
            DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
        )
            ->orderBy('productId', 'desc')
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
            ->paginate(16);

        if ($request->keyword != '') {
            $product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where('productname', 'LIKE', '%' . $request->keyword . '%')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                ->paginate(16); // ->get();
            // dd($product);
        }
        return response()->json([
            'product' => $product,

        ]);
    }
    public function searchhomeproduct(Request $request)
    {
        // dd($request);
        $product = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isFeatures',
            'product.slugname',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
            DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
            DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
        )
            ->orderBy('productId', 'desc')->take(8)
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
            ->get();



        if ($request->keyword != '') {
            $product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT slugname FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryslug'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')->take(8)
                ->where('productname', 'LIKE', '%' . $request->keyword . '%')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0])
                ->get();
            // dd($product);
        }
        return response()->json([
            'product' => $product
        ]);
    }
    public function category(Request $request, $id = null)
    {
        // dd($id);
        if ($id == null) {
            // dd('if');
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                ->paginate(10);
        } else {
            // dd('else');

            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0, 'category.categoryname' => $id])
                ->join('category', 'product.categoryId', '=', 'category.categoryId')
                ->paginate(10);
            // dd($Product);
        }

        return view('frontview.product', compact('Product'));
    }
    public function productdetail(Request $request, $category = null, $id = null)
    {
        // dd($category);
        // dd($id);
        $ProductDetail = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isStock',
            'product.categoryId',
            'product.isFeatures',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
        )
            ->orderBy('productId', 'DESC')
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.slugname' => $id])
            ->first();
        // dd($ProductDetail);
        $Category = Category::where(['slugname' => $category])->first();

        $Photos = Productphotos::where(['productphotos.iStatus' => 1, 'productphotos.isDelete' => 0, 'productphotos.productid' => $ProductDetail->productId])
            ->get();

        $Attribute = ProductAttributes::select(
            'product_attributes.id',
            'product_attributes.product_id',
            'product_attributes.product_attribute_id',
            'product_attributes.product_attribute_weight',
            // 'product.productId',

        )
            ->where(['product_attributes.product_id' => $ProductDetail->productId])
            ->get();

        if ($ProductDetail->isFeatures == 1) {
            $RelatedProduct = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isStock',
                'product.slugname',
                'product.categoryId',
                'product.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'DESC')
                ->take(4)
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 1])
                ->where('product.slugname', '!=', $id)
                ->get();
            // dd($RelatedProduct);
        } else {

            $RelatedProduct = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isStock',
                'product.slugname',
                'product.categoryId',
                'product.isFeatures',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('product.productId', 'DESC')
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                ->where('multiplecategory.categoryid', '=', $Category->categoryId)
                ->where('product.slugname', '!=', $id)
                ->get();
            // dd($RelatedProduct);
        }

        return view('frontview.productdetail', compact('ProductDetail', 'Photos', 'RelatedProduct', 'Attribute', 'category', 'id'));
    }
    public function privacypolicy()
    {
        return view('frontview.privacypolicy');
    }
    public function refundpolicy()
    {
        return view('frontview.refundpolicy');
    }
    public function delivery_Policy()
    {
        $seo = MetaData::where(['id' => 17])->first();
        return view('frontview.delivery_Policy', compact('seo'));
    }
    public function termandcondition()
    {
        return view('frontview.termandcondition');
    }
     public function Refund_Policy()
    {
        $seo = MetaData::where(['id' => 16])->first();
        return view('frontview.Refund_Policy', compact('seo'));
    }
    
    
    
    
    public function logout()
    {
        $session = Session::get('customerid');
        $session;
        session()->flush('customerid' . $session);
        return redirect()->route('FrontIndex');
    }
    public function weightBind(Request $request)
    {
        // dd($request->all());
        if ($request->Weight == 0) {
            $Data = Product::where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.productId' => $request->productid])
                ->first();
        } else {
            $Data = ProductAttributes::orderBy('id', 'DESC')
                ->where(['product_id' => $request->productid, 'id' => $request->Weight])
                ->first();
        }

        return  json_encode($Data);
    }
    public function contactthankyou()
    {
        return view('frontview.contactthankyou');
    }
    public function FrontCategory(Request $request, $id)
    {
        // dd($id);
        $HeaderSearch = $request->headersearch;
        $Category = Category::orderBy('categoryId', 'desc')->get();

        if ($id == null) {
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                ->when($HeaderSearch, fn ($query, $HeaderSearch) => $query
                    ->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
                ->paginate(16);
            // dd($Product);
            $ProductCount = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                ->when($HeaderSearch, fn ($query, $HeaderSearch) => $query
                    ->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
                ->count();
            // dd($Product);
        } else {
            $Product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0, 'category.slugname' => $id])
                ->when($HeaderSearch, fn ($query, $HeaderSearch) => $query
                    ->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                ->paginate(16);
            // dd($Product);
            $ProductCount = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.isStock',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto'),
                DB::raw('(SELECT category.categoryId FROM category inner join multiplecategory on category.categoryId=multiplecategory.categoryid where multiplecategory.productid=product.productId ORDER BY product.productId  LIMIT 1) as categoryId'),
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0, 'category.slugname' => $id])
                ->when($HeaderSearch, fn ($query, $HeaderSearch) => $query
                    ->where('product.productname', 'LIKE', '%' . $HeaderSearch . '%'))
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                ->count();
            // dd($Product);
            // dd($ProductCount);
        }
        // dd($Product);
        DB::commit();
        return view('frontview.category', compact('Product', 'Category', 'id', 'ProductCount'));
        // return view('frontview.product');
    }
    public function searchproductincategory(Request $request)
    {

        $product = Product::select(
            'product.productId',
            'product.productname',
            'product.rate',
            'product.weight',
            'product.description',
            'product.isFeatures',
            'product.slugname',
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto')
        )
            ->orderBy('productId', 'desc')
            ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0, 'category.slugname' => $request->categoryId])
            ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
            ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
            ->paginate(16);
        if ($request->keyword != '') {
            $product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto')
            )
                ->orderBy('productId', 'desc')
                ->where('productname', 'LIKE', '%' . $request->keyword . '%')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0])
                ->paginate(16); // ->get();
            // dd($product);
        } else {
            $product = Product::select(
                'product.productId',
                'product.productname',
                'product.rate',
                'product.weight',
                'product.description',
                'product.isFeatures',
                'product.slugname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId LIMIT 1,1) as backphoto')
            )
                ->orderBy('productId', 'desc')
                ->where(['product.iStatus' => 1, 'product.isDelete' => 0, 'product.isFeatures' => 0, 'category.slugname' => $request->categoryId])
                ->join('multiplecategory', 'product.productId', '=', 'multiplecategory.productid')
                ->join('category', 'multiplecategory.categoryid', '=', 'category.categoryId')
                ->paginate(16);
            // dd($product);
        }
        return response()->json([
            'product' => $product,

        ]);
    }
    public function membersub(Request $request)
    {
        $session =Auth::user();
        $member = DB::table('members')->where('members.user_id', '=', $session->id)
        ->first();
        $renewalhistory = DB::table('renewal_history')
        ->where('renewal_history.id', '=', $member->renewalhistory_id)
        ->join('membership_plans', 'renewal_history.plan_id','membership_plans.id')
        ->get();
        $Count = $renewalhistory->count();
        // dd($renewalhistory);
        return view('Membersub.index', compact('Count','renewalhistory'));
    }
   // product search in front 
    public function adminsearch(Request $request,$id = null)
    {

        $seo = MetaData::where(['id' => 13])->first();
        $cat_id=$request->categories_id; 
        $categories_id =$request->categoriesid;
        $keyup=$request->first_name1;   
         if(isset($categories_id))
         {
            $seo = MetaData::where(['id' => 13])->first();
            $service = DB::table('categories')
            ->select('categories.id', 'categories.name', 'categories.photo','categories.category_slug')
            ->join('members', 'categories.id', '=', 'members.category_id')
            ->where('categories.iStatus', 1)
            ->where('categories.isDelete', 0)
            ->paginate(env('PAR_PAGE_COUNT',20));

            $categorys= DB::table('categories')->orderBy('name', 'asc')
            ->get();
            $Products = DB::table('members')
            ->join('member_services', 'members.id', '=', 'member_services.member_id')
            ->where('members.category_id', $categories_id)
            ->paginate(env('PAR_PAGE_COUNT',20));
            $Count=$Products->count();

            return view('frontview.Search', compact('Products','categorys','categories_id','service','Count','seo'));
         }
         if(isset($cat_id))
         {
            $seo = MetaData::where(['id' => 13])->first();
            $service = DB::table('categories')
            ->select('categories.id', 'categories.name', 'categories.photo','categories.category_slug')
            ->join('members', 'categories.id', '=', 'members.category_id')
            ->where('categories.iStatus', 1)
            ->where('categories.isDelete', 0)
            ->paginate(env('PAR_PAGE_COUNT',20));

            $categorys= DB::table('categories')->orderBy('name', 'asc')
            ->get();
            $Products = DB::table('members')
            ->join('member_services', 'members.id', '=', 'member_services.member_id')
            ->where('members.category_id', $cat_id)
            ->paginate(env('PAR_PAGE_COUNT',20));

                $data = [
                    'service' => $service,
                    'categorys' => $categorys,
                    'Products' => $Products
                ];
            return response()->json($data);

         }
         if(isset($keyup))
         {
           
            $service = DB::table('categories')
            ->select('categories.id', 'categories.name', 'categories.photo','categories.category_slug')
            ->join('members', 'categories.id', '=', 'members.category_id')
            ->where('categories.iStatus', 1)
            ->where('categories.isDelete', 0)
            ->paginate(env('PAR_PAGE_COUNT',20));
          
            $categorys= DB::table('categories')->orderBy('name', 'asc')
            ->get();
            $Adminfirst_name = $request->first_name1;
            $request->session()->put('Adminfirst_name', $Adminfirst_name ?? null);
    
            // Start a new query builder instance
            $membersQuery = DB::table('member_services');
            $membersQuery->when($request->first_name1, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('product_name', 'LIKE', '%' . $request->first_name1 . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->first_name1 . '%')
                    ->orWhere('Hash_Tag', 'LIKE', '%' . $request->first_name1 . '%')
                    ->orWhere('price', 'LIKE', '%' . $request->first_name1 . '%');
                });
            });
            $data = $membersQuery->paginate(10);
            return response()->json($data);
            
         }
         if($id === null)
        {
            
            $service = DB::table('categories')
            ->select('categories.id', 'categories.name', 'categories.photo','categories.category_slug')
            ->join('members', 'categories.id', '=', 'members.category_id')
            ->where('categories.iStatus', 1)
            ->where('categories.isDelete', 0)
            ->paginate(env('PAR_PAGE_COUNT',20));
          
            $categorys= DB::table('categories')->orderBy('name', 'asc')
            ->get();
            $Adminfirst_name = $request->first_name;
            $request->session()->put('Adminfirst_name', $Adminfirst_name ?? null);
    
            // Start a new query builder instance
            $membersQuery = DB::table('member_services');
            $membersQuery->when($request->first_name, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('product_name', 'LIKE', '%' . $request->first_name . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->first_name . '%')
                        ->orWhere('Hash_Tag', 'LIKE', '%' . $request->first_name . '%')
                        ->orWhere('price', 'LIKE', '%' . $request->first_name . '%');
                });
            });
            $Products = $membersQuery->paginate(10);
            $Count=$Products->count();

        }else{
           
            $Adminfirst_name= '';
            $slug_to_get_id =DB::table('categories')->where('category_slug',$id)->first();
            $categories_id =$slug_to_get_id->id;
            $categorys= DB::table('categories')->orderBy('name', 'asc')
            ->get();
            $Products = DB::table('members')
            ->join('member_services', 'members.id', '=', 'member_services.member_id')
            ->where('members.category_id', $slug_to_get_id->id)
            ->paginate(env('PAR_PAGE_COUNT',20));

            $service = DB::table('categories')
            ->select('categories.id', 'categories.name', 'categories.photo','categories.category_slug')
            ->join('members', 'categories.id', '=', 'members.category_id')
            ->where('categories.iStatus', 1)
            ->where('categories.isDelete', 0)
            ->paginate(env('PAR_PAGE_COUNT',20));

             $Count=$Products->count();
             
        }

        return view('frontview.Search', compact('Products','categorys','categories_id','Adminfirst_name','service','Count','seo'));
    
    }
    public function ProductInquiry(Request $request){
      
        $user = DB::table('ProductInquiry')->insert([

            'Member_id'     =>  $request->memberid,
            'Product_id'    => $request->productid,
            'Name'          => $request->Name,
            'email'         => $request->email, 
            'Phone_Number'  =>$request->Phone_Number,
            'Comment'       =>$request->Comment,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        $Product_user_email = DB::table('members')
        ->select('email')
        ->where('id', $request->memberid)
        ->first();
       
        $productdetail =DB::table('member_services')->select('product_name')
        ->where('id', $request->productid)
        ->first();
         
        $sendemaildetails = DB::table('sendemaildetails')->where('id', 7)->first();

        $msg = [
            'FromMail' => $sendemaildetails->strFromMail ??  'support@evolv.co.in',
            'Title' => $sendemaildetails->strTitle ??  'Evolve Business Community',
            'ToEmail' =>$Product_user_email->email ?? '',
            'CCEmail' =>$sendemaildetails->strCC ?? 'support@evolv.co.in',
            'Subject' => $sendemaildetails->strSubject ?? 'Product Inquiry' ?? '',
        ];

        $data = [
            'Name' => $request->Name ?? '',
            'email' => $request->email ?? '',
            'phone' => $request->Phone_Number ?? '',
            'Comment' => $request->Comment ?? '',
            'product_name' => $productdetail->product_name ?? 'NO Data'
        ];
       
        $mail = Mail::send('emails.ProductInquiry', ['data' => $data], function ($message) use ($msg) {
            $message->from($msg['FromMail'], $msg['Title']);
            $message->to($msg['ToEmail'])->subject($msg['Subject']);
            if (!empty($msg['CCEmail'])) {
                $message->cc($msg['CCEmail']);
            }
        });

        return back()->with('success', 'Product Inquiry successfully Submit');
    }
    public function Privacy_Policy(Request $request){

        $seo = MetaData::where(['id' => 14])->first();
        return view('frontview.Privacy-Policy',compact('seo'));
    }

    public function TermCondition(Request $request){

        $seo = MetaData::where(['id' => 15])->first();
        return view('frontview.TermCondition', compact('seo'));
    }

    public function THANK_YOU(Request $request){

        return view('frontview.thankyou');
    }
    
    public function Clusterfish_index(Request $request)
    {
        try {
            $seo = MetaData::where(['id' => 1])->first();
            $category = DB::table('members')->orderBy('Contact_person', 'asc')->get();
           return view('frontview.Clusterfish', compact('category','seo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function Clusterfish_store(Request $request)
    {
        try {
            $currentdate = date('Y-m-d');
            $data = [
                "Eventtype" => "Clusterfish",
                "name" => $request->contact_person_name,
                "email"=>$request->email ?? '',
                "Brand_name" => $request->Brand_name,
                "City" => $request->City,
                "Phonenumber" => $request->Phonenumber,
                "Buisness_Category" => $request->Business_Category,
                "Buisness_Profile_in_Brief_" => $request->Business_Profile_in_Brief_,
                "Buisness_Model" => $request->Business_Model,
                "Referred_By" => $request->referred_by,
                "reference_name" => $request->reference_name,
                "created_at" => date('Y-m-d H:i:s')
            ];
            $Data = DB::table('Clusterfish')->insertGetId($data);
            $getdeta = DB::table('Clusterfish')->where('id', $Data)->first();
            $currentdate = date('Y-m-d');

            if ($currentdate <= '2025-09-20') {
                $Net_Amount = 1799;
            } elseif ($currentdate <= '2025-09-20') {
                $Net_Amount = 2499;
            }else{
                $Net_Amount = 5000;
            }
            
            $api = new Api(config('app.RAZORPAY_KEY'), config('app.RAZORPAY_SECRET'));
          
            $razorpayKey = config('app.RAZORPAY_KEY');
           
            $order = $api->order->create([
                'receipt'         => 'order_rcptid_' . rand(),
                'amount'          => $Net_Amount * 100,
                'currency'        => 'INR',
                'payment_capture' => 1
            ]);

            return view('frontview.Clusterfishstore', compact('Data', 'Net_Amount', 'razorpayKey', 'getdeta', 'order'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    public function Admin_Clusterfish_index(Request $request)
    {
        $FromDate = $request->fromdate ?? '';
        $ToDate = $request->todate ?? '';
        try {
            $Clusterfish = DB::table('Clusterfish')
                ->orderBy('Clusterfish.id', 'desc')
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('Clusterfish.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('Clusterfish.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->paginate(4000);
            $Count = $Clusterfish->count();
            return view('Clusterfish.index', compact('Clusterfish', 'Count', 'FromDate', 'ToDate'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function ClusterfesteToexcel(Request $request,$fromdate = null, $todate = null,)
    {
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        try {
            $Clusterfish = DB::table('Clusterfish')
                ->orderBy('Clusterfish.id', 'desc')
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('Clusterfish.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('Clusterfish.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->get();
            return view('Clusterfish.Clusterfestexportdata', compact('Clusterfish','FromDate', 'ToDate'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function Clusterfish_delete(Request $request)
    {
        try {
            DB::table('Clusterfish')->where(['id' => $request->id])->delete();
            return redirect()->route('Clusterfish.index')->with('success', 'Clusterfest Deleted Successfully!.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
     public function Clusterfest_paymentStatus(Request $request)
    {
       
        try {
            $payment_status_update = DB::table('Clusterfish')->where('id', $request->paymentRecordId)->update([
                'Payment_Status' => $request->payment_status,
            ]);
            return redirect()->back()->with('success', 'Payment status update Successfully!.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
     public function Opportunity_meet(Request $request)
    {
         try {
              $seo = MetaData::where(['id' => 1])->first();
                $category=DB::table('categories')->orderBy('name','asc')->get();
                return view('frontview.Opportunitymeet', compact('category','seo'));
         } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function Opportunity_meet_store(Request $request)
    {
         try {
        $data = [
            "contact_person_name" => $request->contact_person_name,  #name
            "Phonenumber" => $request->Phonenumber,                  #phonenumber
            "email" => $request->email,
            "name" => $request->name,                                # brand name
            "Gst_numbar"=>$request->gstnumber ?? 0,                  #gst number
            "category_id" => $request->category_id,                  #category name
            "type" => $request->type,                                #select time
            "referred_by" => $request->referred_by,                  #reference name  
            "reference_name" => $request->reference_name,
            "checktime" => $request->type,
            "Opportunity_meet_flag" => 1,
            "created_at" => date('Y-m-d H:i:s')
        ];
        $Data =DB::table('induction_meet')->insertGetId($data);
        $getdeta =DB::table('induction_meet')->where('id',$Data)->first();
        $Net_Amount =$request->amount_fee;
        $razorpayKey = config('app.RAZORPAY_KEY');
        $api = new Api(config('app.RAZORPAY_KEY'), config('app.RAZORPAY_SECRET'));
        
        $order = $api->order->create([
            'receipt'         => 'order_rcptid_' . rand(),
            'amount'          => $Net_Amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 
        ]);
      
         return view('frontview.Opportunity_razorpayView' ,compact('Data','Net_Amount','razorpayKey','getdeta','order'));
         } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
     }
     
      public function emailer(Request $request){

        return view('emailmarketing.emailer');
    }
     public function Youngleaders(Request $request)
    {
        try {
            $category = DB::table('categories')->orderBy('name', 'asc')->get();
            return view('frontview.Youngleaders', compact('category'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function Young_leaders_store(Request $request)
    {
        try {
            $data = array(
                'name'                    => $request->name ?? '',
                'mobile'                  => $request->mobile ?? '',
                'email'                   => $request->email ?? '',
                'profession'              => $request->profession ?? '',
                'industry_type'            => $request->industry_type ?? '',
                'company_name'            => $request->company_name ?? '',
                'business_category_id'    => $request->business_category_id ?? '',
                'company_type'            => $request->company_type ?? '',
                'city'                    => $request->city ?? '',
                'community_participation' => $request->community === 'yes' ? 1 : 0,
                'community_name'          => $request->community_name ?? '',
                'joining_reason'          => $request->joining_reason ?? '',
                'vibe_1'          => $request->vibe_1 ?? '',
                'vibe_2'          => $request->vibe_2 ?? '',
                'vibe_3'          => $request->vibe_3 ?? '',
                'vibe_4'          => $request->vibe_4 ?? '',
                'vibe_5'          => $request->vibe_5 ?? '',
                'vibe_6'          => $request->vibe_6 ?? '',
                'created_at'              => now(),
            );
            DB::table('youngleaders')->insert($data);
            return back()->with('success', 'Thank you! Your details were submitted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }
     public function Young_leaders_index(Request $request)
    {
        try {
            $Data = DB::table('youngleaders')
                ->select('youngleaders.*', 'categories.name as categories_name')
                ->leftJoin('categories', 'youngleaders.business_category_id', '=', 'categories.id')
                ->orderBy('youngleaders.id', 'DESC')
                ->paginate(20);

            $count = $Data->count();

            return view('Youngleaders.index', compact('Data', 'count'));
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

}
