
@extends('layouts.app')
@section('title', 'Product Inquiry List')
@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            
            {{-- Alert Messages --}}
            @include('common.alert')
          
            <div class="col-md-12 mt-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0" data-anchor="data-anchor"> Visitor registration List
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                    aria-labelledby="tab-dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540"
                                    id="dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540">
                                    <div id="tableExample" data-list='{"valueNames":["name","email","age"]}'>
                                        @if($Count > 0) 
                                        <div class="table-responsive scrollbar">
                                            <table class="table table-bordered table-striped fs--1 mb-0">
                                                <thead class="bg-200 text-900">
                                                    <tr>
                                                        <th scope="col">Sr No</th>
                                                        <th  scop="col">Name</th>                                           
                                                        <th scop="col">Phone number</th> 
                                                        <th scop="col">Email </th>  
                                                        <th  scop="col">Brand Name</th> 
                                                        <th  scop="col">Brand category</th>                                           
                                                        <th scop="col">Referred by</th> 
                                                        <th scop="col">Reference name </th>                                                                                                           
                                                        <th scop="col">Meeting Type</th>
                                                        <th scop="col">Time Slot</th> 
                                                        <th scop="col">Payment Status</th> 
                                                        <!-- <th scop="col">Action</th> -->
                                                    </tr>
                                                    </thead> 
                                                    <tbody class="list">
                                                        <?php $i = 1; ?>
                                         
                                                        @foreach ($induction as $data)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $i + $induction->perPage() * ($induction->currentPage() - 1) }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->contact_person_name ?? '-'}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->Phonenumber ?? '-'}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->email ?? '-'}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->name ?? '-'}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->category_id ?? '-' }}
                                                            </td>
                                                           
                                                            <td class="text-center">
                                                                {{ $data->referred_by ?? '-'}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->reference_name ?? '-'}}
                                                            </td>
                                                           
                                                             <td class="text-center">
                                                                @if($data->Opportunity_meet_flag == 1)
                                                                    Opportunity meet
                                                                @else
                                                                    @if($data->visitor_registration_paid == 1)
                                                                        Visitor registration (Paid)
                                                                    @else
                                                                        Visitor registration
                                                                    @endif
                                                                @endif                                                            
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->checktime ?? $data->type ?? '-'}}
                                                            </td>
                                                            <td class="text-center">
                                                                @if($data->Payment_Status == 0)
                                                                <span style="color: blue;">Pending</span>
                                                                @elseif($data->Payment_Status == 1)
                                                                   <span style="color: green;">Success</span>
                                                                @elseif($data->Payment_Status == 3)
                                                                <span style="color: red;">Fail</span>
                                                                @else
                                                                   <span style="color: gray;">Unknown Status</span>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center mt-3">
                                            {{ $induction->links() }}
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
                </div>
             
  
    
@endsection

