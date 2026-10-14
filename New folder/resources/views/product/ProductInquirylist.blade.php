
@extends('layouts.app')
@section('title', 'Product Inquiry List')
@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            
            {{-- Alert Messages --}}
            @include('common.alert')

                 <!-- Page Heading -->
                 <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" id="form" action="{{ route('product.ProductInquirylist') }}">
                                    @csrf
                                    <div class="row align-items-center">

                                        <div class="col-md-3 mb-2">
                                            <div class="input-group">
                                            <select class="form-select" id="first_name" name="first_name">
                                                    <option value="">Select Member Name</option>
                                                    @foreach ($Members as $Member)
                                                        <option value="{{ $Member->id }}" {{isset($firstname) && $Member->id == $firstname ? 'selected' : '' }}>{{ $Member->Contact_person }}</option>
                                                    @endforeach
                                                </select>

                                                <!-- <input type="text" class="form-control" name="first_name"
                                                    placeholder="Search by Member name" id="first_name"
                                                    value="<?= isset($firstname) ? $firstname : '' ?>"> -->
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="col-md-3 mb-2">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="product_name"
                                                    placeholder="Search by Inquiry Product Name" id="product_name"
                                                    value="<?= isset($productname) ? $productname : '' ?>">
                                            </div>
                                        </div> -->
                                        <div class="col-md-3 mb-2">
                                            <div>
                                                <input type="submit" id="search" class="btn btn-success" name="search"
                                                    title="Search" value="Search">
                                                <button type="button" id="cancel_search" class="btn btn-success">Cancel</button>    
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                

                {{-- This is search field end --}}
            
            <div class="col-md-12 mt-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0" data-anchor="data-anchor">Product Inquiry List
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
                                                        <th  scop="col">Member Name</th>                                             
                                                        <th scop="col">Inquiry Product Name</th> 
                                                        <th  scop="col">Name</th>                                             
                                                        <th scop="col">Email</th>
                                                        <th scop="col">Phone Number</th> 
                                                        <th scop="col">Inquiry Date</th>
                                                        <th scop="col">Action</th>
                                                    </tr>
                                                    </thead> 
                                                    <tbody class="list">
                                                        <?php $i = 1; ?>
                                         
                                                        @foreach ($product as $data)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $i + $product->perPage() * ($product->currentPage() - 1) }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->Contact_person }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->product_name }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->Name }}
                                                            </td>
                                                            
                                                            <td class="text-center">
                                                                {{ $data->email }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->Phone_Number }}
                                                            </td>
                                                            <td class="text-center">                                                             
                                                                {{date('d-m-Y', strtotime($data->created_at))}}
                                                            </td>
                                                            
                                                            <td class="d-flex gap-2 justify-content-center">
                                                            <a class="" href="#" data-bs-toggle="modal"
                                                                title="Delete" data-bs-target="#deleteRecordModal"
                                                                onclick="deleteData(<?= $data->product_inq_id ?>);">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </a>
                                                            </td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center mt-3">
                                            {{$product->links()}}
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
             
     <!--Delete Modal Start -->
     <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mt-2 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                                </lord-icon>
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Are you Sure ?</h4>
                                    <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record
                                        ?</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                    <button type="button" class="btn w-sm btn-light"
                                    data-bs-dismiss="modal">Close</button>
                                    <a class="btn btn-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                                        Yes,
                                        Delete It!
                                    </a>
                                    <form id="user-delete-form" method="POST"
                                        action="{{ route('product.Inquirydelete') }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" id="deleteid" value="">
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Delete modal End -->
    
@endsection

@section('scripts')

    <script>
        function deleteData(id) {
            // alert(id);
            $("#deleteid").val(id);
        }
    </script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
    $(function() {
        $("#startdatepicker").datepicker({
            dateFormat: 'd-m-yy',
            //minDate: 0
        });

        $("#enddatepicker").datepicker({
            dateFormat: 'd-m-yy',
            //minDate: 0
        });
    });
</script>
<script>
    $(document).ready(function(){
        // Add click event listener to the cancel button
        $('#cancel_search').click(function(){
            // Reset the value of the category_id select element to empty
            $('#first_name').val('');
            // Submit the form to fetch all data
            $('#product_name').val('');
            
            $('#form').submit();
        });
    });
</script>

@endsection
