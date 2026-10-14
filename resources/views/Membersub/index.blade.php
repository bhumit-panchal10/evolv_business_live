@extends('layouts.app')
@section('title', 'Member Subscription expried on')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                        <li class="mb-5" style="color:red">{{ $error }}</li>
                    @endforeach
                @endif

                {{-- Alert Messages --}}
                @include('common.alert')
                <div class="d-flex justify-content-end mb-3">
   
                    </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Subscription Expried Detail
                                    </h5>
                                </div>    
                            </div>
                       
                        </div>
                        <div class="card-body">
                            <?php //echo date('ymd');
                            ?>
                            @if($Count > 0)
                            <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Plan Name</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th> 
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($renewalhistory as $row)
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">{{ $row->plan_name ?? '' }}</td>
                                            <td class="text-center">{{ $row->substartdate ?? '' }}</td> 
                                            <td class="text-center">{{ $row->stbenddate ?? '' }}</td> 
                                            <td class="text-center">{{ $row->amount ?? '' }}</td>                                        
                                        </tr>
                                    @endforeach
                                </tbody>                   
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                
                                </div>
                                @else 
                                <div class="row">
                                    <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                        <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                            <h1 class="font-white text-center"> No Data Found ! </h1>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                </div>
            </div>

            

            

        </div>
    </div>


    
    @endsection


    
    

