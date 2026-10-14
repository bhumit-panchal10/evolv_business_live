<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;



class CSVUploadController extends Controller
{
    public function index(Request $request)
    {
        return view('csvupload.index');
    }


    public function create(Request $request)
    {
        $import = new UsersImport();
        Excel::import($import, request()->file('csvfile'));

        return view('csvupload.index', ['invalidData' => UsersImport::getInvalidData()]);
    }

    // public function create(Request $request)
    // {
    //     //dd($request);
    //     Excel::import(new UsersImport, request()->file('csvfile'));

    //     return back()->with('success', 'CSV Uploaded Successfully');
    // }
}
