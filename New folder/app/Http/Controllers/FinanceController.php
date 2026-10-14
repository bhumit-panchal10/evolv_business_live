<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function Financed(Request $request)
    {
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $Location = $request->location;
        $SerialNo = $request->serial_no;
        $ModelNo = $request->model_code;
        $DealerCode = $request->dealer_code;
        $InvoiceNo = $request->invoice_no;

        $ServiceProvider = ServiceProvider::orderBy('id', 'desc')->get();
        $Product = Product::orderBy('productId', 'desc')
            ->where(['product.status' => 1])
            ->when($request->fromdate, fn ($query, $FromDate) => $query
                ->where('product.financedate', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
            ->when($request->todate, fn ($query, $ToDate) => $query
                ->where('product.financedate', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
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
            ->paginate(100);
        //dd($Product);

        return view('finance.financed', compact('Product', 'FromDate', 'ToDate', 'ServiceProvider', 'Location', 'SerialNo', 'ModelNo', 'DealerCode', 'InvoiceNo'));
    }

    public function NonFinanced(Request $request)
    {
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $ServiceProviderId = $request->serviceproviderid;
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
            ->when($request->serviceproviderid, fn ($query, $ServiceProviderId) => $query
                ->Where('product.serviceproviderid', '=',  $ServiceProviderId))
            ->when($request->serial_no, fn ($query, $SerialNo) => $query
                ->Where('product.serial_no', 'LIKE', '%' . $SerialNo . '%'))
            ->when($request->model_code, fn ($query, $ModelNo) => $query
                ->Where('product.model_code', 'LIKE', '%' . $ModelNo . '%'))
            ->when($request->dealer_code, fn ($query, $DealerCode) => $query
                ->Where('product.dealer_code', 'LIKE', '%' . $DealerCode . '%'))
            ->when($request->invoice_no, fn ($query, $InvoiceNo) => $query
                ->Where('product.invoice_no', 'LIKE', '%' . $InvoiceNo . '%'))
            ->paginate(100);
        //dd($Product);

        return view('finance.nonfinanced', compact('Product', 'FromDate', 'ToDate', 'ServiceProvider', 'ServiceProviderId', 'SerialNo', 'ModelNo', 'DealerCode', 'InvoiceNo'));
    }

    public function NonFinancedToFinanced(Request $request)
    {
        $data = array(
            'status' => 1,
            'serviceproviderid' => $request->serviceproviderid,
            'financedate' => date('Y-m-d', strtotime($request->fromdate)),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $update = DB::table('product')
            ->where(['productId' => $request->productId])
            ->update($data);
        return back()->with('success', 'Updated Successfully.');
    }

    public function FinancedToNonFinanced(Request $request, $id)
    {
        $data = array(
            'status' => 0,
            'serviceproviderid' => 0,
            'financedate' => null,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $update = DB::table('product')
            ->where(['productId' => $id])
            ->update($data);

        return back()->with('success', 'Updated Successfully.');
    }

    public function exportToexcelnonfinanced(Request $request)
    {
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $ServiceProvider = $request->serviceproviderid;
        $SerialNo = $request->serial_no;

        if ($FromDate != "" || $ToDate != "" || $ServiceProvider != "" || $SerialNo != "") {
            $Product = Product::orderBy('productId', 'desc')
                ->where(['product.status' => 0])
                ->when($request->fromdate, fn ($query, $FromDate) => $query
                    ->where('product.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn ($query, $ToDate) => $query
                    ->where('product.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->when($request->serviceproviderid, fn ($query, $ServiceProviderId) => $query
                    ->Where('product.serviceproviderid', '=',  $ServiceProviderId))
                ->when($request->serial_no, fn ($query, $SerialNo) => $query
                    ->Where('product.serial_no', 'LIKE', '%' . $SerialNo . '%'))
                ->get();
        } else {
            $Product = Product::orderBy('productId', 'desc')
                ->where(['product.status' => 0])
                ->get();
        }

        return view('finance.nonfinancedexcel', compact('Product'));
    }

    public function exportToexcelfinanced(Request $request)
    {
        // dd($request);
        $FromDate = $request->fromdate;
        $ToDate = $request->todate;
        $ServiceProvider = $request->serviceproviderid;
        $SerialNo = $request->serial_no;

        if ($FromDate != "" || $ToDate != "" || $ServiceProvider != "" || $SerialNo != "") {
            // dd('if');
            $Product = Product::orderBy('productId', 'desc')
                ->where(['product.status' => 1])
                ->when($request->fromdate, fn ($query, $FromDate) => $query
                    ->where('product.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn ($query, $ToDate) => $query
                    ->where('product.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->when($request->serviceproviderid, fn ($query, $ServiceProviderId) => $query
                    ->Where('product.serviceproviderid', '=',  $ServiceProviderId))
                ->when($request->serial_no, fn ($query, $SerialNo) => $query
                    ->Where('product.serial_no', 'LIKE', '%' . $SerialNo . '%'))
                // ->toSql();
                ->get();
            // dd($Product);
        } else {
            // dd('else');
            $Product = Product::orderBy('productId', 'desc')
                ->where(['product.status' => 1])
                ->get();
        }

        return view('finance.financedexcel', compact('Product'));
    }
}
