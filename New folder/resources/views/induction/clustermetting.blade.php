
@extends('layouts.app')
@section('title', 'Cluster meet List')
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
                                <h5 class="card-title mb-0" data-anchor="data-anchor"> Cluster Meet List
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
                                                        <!-- <th scop="col">Chapter</th>  -->
                                                        <th scop="col">Time Slot</th> 
                                                        <th scop="col">Action</th>
                                                    </tr>
                                                    </thead> 
                                                    <tbody class="list">
                                                        <?php $i = 1; ?>                                         
                                                        @foreach ($clustermeet as $data)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $i + $clustermeet->perPage() * ($clustermeet->currentPage() - 1) }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->name }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $data->Phonenumber }}
                                                            </td>                                                            
                                                            <!-- <td class="text-center">
                                                                {{ $data->type }}
                                                            </td> -->
                                                            <td class="text-center">
                                                                {{ $data->checktime }}
                                                            </td>
                                                            <td>
                                                                <div class="d-flex gap-2 justify-content-center">
                                                                   
                                                                    <a class="" href="#" data-bs-toggle="modal"
                                                                        title="Delete" data-bs-target="#deleteRecordModal"
                                                                        onclick="deleteData(<?= $data->id ?>);">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </a>
                                                                </div>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center mt-3">
                                            {{ $clustermeet->links() }}
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
                                            action="{{ route('induction.clustermeetdelete') }}">
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
        <script>
            function deleteData(id) {
                $("#deleteid").val(id);
            }
        </script>
  
    
@endsection

