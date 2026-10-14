<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class RazorpayPaymentController extends Controller
{
      /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {       
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));
        $order = $api->order->create([
            'receipt'         => 'order_rcptid_' . rand(),
            'amount'          => $request->amount * 100, 
            'currency'        => 'INR',
            'payment_capture' => 1 
        ]);
        return view('frontview.razorpayView',compact('order'));
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    //payment success then call this method 
    public function razorPaySuccess(Request $request)
    {
        try {
            $input = $request->all();
            
            $orderId = $request->orderId;
            $stringdata = $orderId . '|' . $request->razorpay_payment_id;
            $generated_signature = hash_hmac('sha256', $stringdata, config('app.RAZORPAY_SECRET'));
            $razorpay_signature = $request->razorpay_signature;
            if ($generated_signature == $razorpay_signature) {
                DB::table('induction_meet')
                    ->where('id', $request->iOrderId)
                    ->update(['Payment_Status' => 1]);

                return 1;
            } else {
                DB::table('induction_meet')
                    ->where('id', $request->iOrderId)
                    ->update(['Payment_Status' => 3]);

                return 0;
            }
        } catch (Exception $e) {
            return 3;
            //return redirect()->route('induction')->with('error', 'Payment Failed');
        }
    }
    public function RazorThankYou()
    {
        return view('thankyouPage');
    }

    public function RazorFail(Request $request)
    {
        try {
                $orderId = $request->query('order_id');
                DB::table('induction_meet')
                            ->where('id', $orderId)
                            ->update(['Payment_Status' => 3]);
                
                return view('paymentFail');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function event_payment_Fail(Request $request)
    {
        try {
                $orderId = $request->query('order_id');
                DB::table('member_news_comment')
                            ->where('id', $orderId)
                            ->update(['Payment_Status' => 3]);
                
                return view('paymentFail');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
        
    }
    public function clusterfish_payment_Fail(Request $request)
    {
        try {
                $orderId = $request->query('order_id');
                DB::table('Clusterfish')
                            ->where('id', $orderId)
                            ->update(['Payment_Status' => 3]);
                
                return view('paymentFail');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
        
    }
      public function Clusterfishsuccess(Request $request)
    {
        try {
            $input = $request->all();
            //dd($request);
            $orderId = $request->orderId;
            $stringdata = $orderId . '|' . $request->razorpay_payment_id;
            $generated_signature = hash_hmac('sha256', $stringdata, config('app.RAZORPAY_SECRET'));
            $razorpay_signature = $request->razorpay_signature;
            
            if ($generated_signature == $razorpay_signature) {
                DB::table('Clusterfish')
                    ->where('id', $request->iOrderId)
                    ->update(['Payment_Status' => 1]);

                return 1;
            } else {
                DB::table('Clusterfish')
                    ->where('id', $request->iOrderId)
                    ->update(['Payment_Status' => 3]);

                return 0;
            }
        } catch (Exception $e) {
            return 3;
        }
    }
     public function event_payment_success(Request $request)
    {
        try {
            $input = $request->all();
            //dd($request);
            $orderId = $request->orderId;
            $stringdata = $orderId . '|' . $request->razorpay_payment_id;
            $generated_signature = hash_hmac('sha256', $stringdata, config('app.RAZORPAY_SECRET'));
            $razorpay_signature = $request->razorpay_signature;
            if ($generated_signature == $razorpay_signature) {
                DB::table('member_news_comment')
                    ->where('id', $request->iOrderId)
                    ->update(['Payment_Status' => 1]);

                return 1;
            } else {
                DB::table('member_news_comment')
                    ->where('id', $request->iOrderId)
                    ->update(['Payment_Status' => 3]);

                return 0;
            }
        } catch (Exception $e) {
            return 3;
        }
    }
     public function Opportunity_PaySuccess(Request $request)
    {
        try {
            $input = $request->all();
            $orderId = $request->orderId;
            $stringdata = $orderId . '|' . $request->razorpay_payment_id;
            $generated_signature = hash_hmac('sha256', $stringdata, config('app.RAZORPAY_SECRET'));
            $razorpay_signature = $request->razorpay_signature;
            
            if ($generated_signature == $razorpay_signature) {
                DB::table('induction_meet')
                    ->where('id', $request->iOrderId)
                    ->update(['Payment_Status' => 1]);
                return 1;
            } else {
                DB::table('induction_meet')
                    ->where('id', $request->iOrderId)
                    ->update(['Payment_Status' => 3]);
                return 0;
            }
        } catch (Exception $e) {
            return 3;
        }
    }
    public function Opportunity_Fail(Request $request)
    {
        try {
                $orderId = $request->query('order_id');
                DB::table('induction_meet')
                            ->where('id', $orderId)
                            ->update(['Payment_Status' => 3]);
                
                return view('paymentFail');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
        
    }
      
}