<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function Inquirydelete(Request $request)
    { 
        DB::table('ProductInquiry')->where('id',$request->id)->delete();
        return back()->with('success', 'Product Inquiry Deleted Successfully!.'); 
    }

    public function Inquirylist(Request $request){
    // dd($request);
        $firstname = $request->first_name;
        $productname = $request->product_name;

        $Members = DB::table('members')->orderBy('Contact_person', 'asc')->get();
        $product=DB::table('ProductInquiry')->select('ProductInquiry.created_at','ProductInquiry.id as product_inq_id','ProductInquiry.Member_id','ProductInquiry.Product_id','ProductInquiry.Name','ProductInquiry.email','ProductInquiry.Phone_Number','member_services.product_name','members.id as member_id','members.Contact_person')
        ->join('member_services','ProductInquiry.Product_id','=','member_services.id')
        ->join('members','ProductInquiry.Member_id','=','members.id')
        ->when($request->first_name, function ($query) use ($firstname) {
            $query->where('members.id', 'LIKE', '%' . $firstname . '%');
        })
        ->orderBy('ProductInquiry.id','desc')
        ->paginate(env('PAR_PAGE_COUNT',20));
        $Count=$product->count();
        return view('product.ProductInquirylist', compact('product','Count','firstname','productname','Members'));
    }
    public function index(Request $request)
    {
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $Location = $request->serviceproviderid;
        $SerialNo = $request->serial_no;
        $ModelNo = $request->model_code;
        $DealerCode = $request->dealer_code;
        $InvoiceNo = $request->invoice_no;

        $ServiceProvider = ServiceProvider::orderBy('id', 'desc')->get();
        $Product = Product::orderBy('productId', 'desc')
            ->where(['product.status' => 0])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
                ->where('product.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
                ->where('product.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
            ->when($request->location, fn ($query, $Location) => $query
                ->Where('product.location', 'LIKE', '%' . $Location . '%'))
            ->when($request->serial_no, fn ($query, $SerialNo) => $query
                ->Where('product.serial_no', 'LIKE', '%' . $SerialNo . '%'))
            ->when($request->model_code, fn ($query, $ModelNo) => $query
                ->Where('product.model_code', 'LIKE', '%' . $ModelNo . '%'))
            ->when($request->dealer_code, fn ($query, $DealerCode) => $query
                ->Where('product.dealer_code', 'LIKE', '%' . $DealerCode . '%'))
            ->when($request->invoice_no, fn ($query, $InvoiceNo) => $query
                ->Where('product.invoice_no', 'LIKE', '%' . $InvoiceNo . '%'))
            ->paginate(env('PAR_PAGE_COUNT',20));
        //dd($Product);

        return view('product.index', compact('Product', 'FromDate', 'ToDate', 'Location'));
    }


    public function create(Request $request)
    {
        $request->validate([
            'serial_no' => 'required|unique:product,serial_no',
        ]);


        $Data = array(
            'model_code' => $request->model_code,
            'serial_no' => $request->serial_no,
            'dealer_code' => $request->dealer_code,
            'invoice_no' => $request->invoice_no,
            'location' => $request->location,
            'serviceproviderid' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'strIP' => $request->ip()
        );
        DB::table('product')->insert($Data);

        return back()->with('success', 'Product Created Successfully.');
    }

    public function editview(Request $request, $id)
    {
        $data = Product::where(['status' => 0, 'productId' => $id])->first();

        echo json_encode($data);
    }

    public function update(Request $request)
    {
        $id = $request->productId;
        $request->validate([
            'serial_no' => 'required|unique:product,serial_no,' . $id . ',productId',
        ]);
        $update = DB::table('product')
            ->where(['status' => 0, 'productId' => $request->productId])
            ->update([
                'model_code' => $request->model_code,
                'serial_no' => $request->serial_no,
                'dealer_code' => $request->dealer_code,
                'invoice_no' => $request->invoice_no,
                'location' => $request->location,
                'updated_at' => date('Y-m-d H:i:s')

            ]);
        //dd($update);

        return back()->with('success', 'Category Updated Successfully.');
    }


    public function delete(Request $request)
    {
        DB::table('product')->where(['status' => 0, 'productId' => $request->productId])->delete();

        return back()->with('success', 'Category Deleted Successfully!.');
    }

    public function checkserialno(Request $request)
    {
        $data = Product::where(['status' => 0, 'serial_no' => $request->SerialNo])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function editcheckserialno(Request $request)
    {
        $data = Product::where(['status' => 0, 'serial_no' => $request->editSerialNo])->count();
        if ($data > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
