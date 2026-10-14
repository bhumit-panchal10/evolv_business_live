@extends('layouts.app')
@section('title', 'Member Visitor List')
@section('content')
    {{-- {{dd($user)}} --}}
    {{-- {{dd($ids)}} --}}
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
                {{-- Tab start  --}}
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-success mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('MemberVisitor.index') ? 'active' : '' }}"
                                        href="{{ route('MemberVisitor.index') }}">
                                        <i class="fas fa-clock"></i> Pending
                                    </a>
                                </li>

                                {{-- Approved --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('MemberVisitor.membervisitor_approved') ? 'active' : '' }}"
                                        href="{{ route('MemberVisitor.membervisitor_approved') }}">
                                        <i class="fas fa-check-circle"></i> Approved
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->routeIs('MemberVisitor.membervisitor_rejectlist') ? 'active' : '' }}"
                                        href="{{ route('MemberVisitor.membervisitor_rejectlist') }}" role="tab"
                                        aria-selected="false" tabindex="-1">
                                        <i class="fas fa-times-circle"></i>Rejected
                                    </a>
                                </li>
                            </ul>
                        </div><!-- end card-body -->
                    </div>
                </div>
                {{-- Tab End  --}}

                {{-- start search  --}}
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <form method="post" id="form"
                                action="{{ route('MemberVisitor.membervisitor_rejectlist') }}">
                                @csrf
                                <div class="row align-items-center">

                                    <div class="col-md-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <select class="form-select select2" id="given_by" name="given_by" data-choices
                                                name="Contact_person">
                                                <option value="">Select Member</option>
                                                @foreach ($members as $businesses1)
                                                    <option value="{{ $businesses1->user_id }}"
                                                        {{ isset($givenby) && $businesses1->user_id == $givenby ? 'selected' : '' }}>
                                                        {{ $businesses1->Contact_person }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- new search add -->
                                    <div class="col-md-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter From Date" type="text" class="form-control"
                                                id="startdatepicker" name="fromdate" autocomplete="off"
                                                value="<?= isset($FromDate) ? $FromDate : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter To Date" type="text" class="form-control "
                                                name="todate" autocomplete="off" id="enddatepicker"
                                                value="<?= isset($ToDate) ? $ToDate : '' ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex align-items-center ">
                                            <div class="input-group d-flex ">
                                                <input type="submit" id="search" class="btn btn-success mx-2"
                                                    name="search" title="Search" value="Search">
                                                <button type="button" id="cancel_search"
                                                    class="btn btn-success">Cancel</button>
                                            </div>
                                            <button class="btn btn-success" type="button" onclick="exportExcel(2);">
                                                <i class="fa-solid fa-file-excel fa-xl"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end search --}}

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Member Visitor List
                                    </h5>
                                </div>
                            </div>
                            <!-- <h5 class="card-title mb-0">Products Service List</h5> -->
                        </div>
                        <div class="card-body">
                            <?php //echo date('ymd');
                            ?>
                            <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                @if ($count > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            {{-- <th scope="col">Member Name</th> --}}
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Member</th>
                                            <th scope="col">Meeting</th>
                                            <th scope="col">Business Name</th>
                                            <th scope="col">Business Category</th>
                                            <th scope="col">Proof of payment</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                            <tr>

                                                <td class="text-center">
                                                    {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                                <td class="text-center">{{ $data->name }}</td>
                                                <td class="text-center">{{ $data->email }}</td>
                                                <td class="text-center">
                                                    {{ date('d-m-Y', strtotime($data->created_at)) }}
                                                </td>
                                                <td class="text-center">{{ $data->phone }}</td>
                                                <td class="text-center">{{ $data->members->Contact_person }}</td>
                                                <td class="text-center">{{ $data->Cluster_metting->Meeting_title ?? '' }}</td>
                                                <td class="text-center">{{ $data->business_name }}</td>
                                                <td class="text-center">{{ $data->business_category->name ?? '' }}</td>
                                                <td class="text-center">
                                                    @if (empty($data->photo))
                                                        <img src="{{ asset('assets/images/noimage.png') }}"
                                                            style="width:50px;height:50px;">
                                                    @else
                                                        <img src="{{ asset('Visitor/' . $data->photo) }}"
                                                            style="width:50px;height:50px;">
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($data->iStatus == 0)
                                                        Pending
                                                    @elseif($data->iStatus == 1)
                                                        Approved
                                                    @elseif($data->iStatus == 2)
                                                        Rejected
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#statusModal"
                                                        onclick="getEditDatastatus({{ $data->id }})"
                                                        title="Change Status">

                                                        <i class="fas fa-user-check text-success"></i>
                                                    </a>
                                                     <form action="{{ route('MemberVisitor.destroy', $data->id) }}"
                                                        method="POST" style="display:inline-block;"
                                                        onsubmit="return confirm('Are you sure you want to delete this visitor?');">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="border-0 bg-transparent p-0"
                                                            title="Delete">

                                                            <i class="fas fa-trash-alt text-danger"></i>

                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                @else
                                    <div class="row">
                                        <div
                                            class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                            <div
                                                class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundgreen">
                                                <h1 class="font-white text-center">No Data Found ! </h1>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $datas->links() }}
                            </div>
                        </div>


                    </div>
                </div>

                <div class="modal fade" id="statusModal" tabindex="-1" role="dialog"
                    aria-labelledby="statusModalLabel" aria-hidden="true">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="statusModalLabel">Change Status
                                    Comments</h5>
                                <button type="button" class="btn btn-success" onclick="$('#statusModal').modal('hide')">
                                    Close
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Add a form for changing status and adding rejected comments -->
                                <form action="{{ route('MemberVisitor.updateStatus') }}" method="post">
                                    @csrf

                                    <input type="hidden" name="id" id="business_id">

                                    <div class="form-group">
                                        <label>Update Status:</label>
                                        <select class="form-control" name="newStatus" id="newStatus"
                                            onchange="toggleRejectedComments()">

                                            <option value="1">Approved</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-2" id="rejectedCommentsDiv" style="display:none;">
                                        <label>Rejected Comments:</label>
                                        <textarea class="form-control" name="comment"></textarea>
                                    </div>

                                    <br>
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        function exportExcel(status) {

            let fromdate = $('#startdatepicker').val();
            let todate = $('#enddatepicker').val();
            let given_by = $('#given_by').val();

            let url = "{{ route('MemberVisitor.export', ':status') }}";
            url = url.replace(':status', status);

            url += `?fromdate=${fromdate}&todate=${todate}&given_by=${given_by}`;

            window.location.href = url;
        }
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
        $(document).ready(function() {
            // Add click event listener to the cancel button
            $('#cancel_search').click(function() {
                // Reset the value of the category_id select element to empty
                $('#startdatepicker').val('');
                $('#enddatepicker').val('');
                $('#business_type').val('');
                $('#given_by').val('');
                $('#form').submit();
            });
        });
    </script>

    <script>
        function getEditDatastatus(id) {

            $('#business_id').val(id);
            $('#newStatus').val(1);
            toggleRejectedComments();

            var url = "{{ route('MemberVisitor.getStatus', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {

                    // direct object use (no JSON.parse needed)
                    if (data.iStatus == 1 || data.iStatus == 2) {
                        $('#newStatus').val(data.iStatus);
                    } else {
                        $('#newStatus').val("1"); // fallback Approved
                    }

                    toggleRejectedComments();
                }
            });
        }

        function toggleRejectedComments() {
            if ($('#newStatus').val() == 2) {
                $('#rejectedCommentsDiv').show();
            } else {
                $('#rejectedCommentsDiv').hide();
            }
        }
    </script>



@endsection
