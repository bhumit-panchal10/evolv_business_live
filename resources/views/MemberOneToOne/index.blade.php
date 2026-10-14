@extends('layouts.app')
@section('title', 'Member One To One List')
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

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">One To One Receive
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
                                            <th scope="col">Given By</th>
                                            <th scope="col">Place</th>
                                            <th scope="col">Business date</th>
                                            <th scope="col">Comment</th>
                                            <th scope="col">Photo</th>
                                            <th scope="col">Rejected Comment</th>
                                            <th scope="col">Status</th>
                                            {{-- <th scope="col">Action</th> --}}
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                            <tr>

                                                <td class="text-center">
                                                    {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                                <td class="text-center">{{ $data->from }}</td>
                                                <td class="text-center">{{ $data->place }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($data->date)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ $data->comment }}</td>
                                                <td class="text-center">
                                                    @if (empty($data->photo))
                                                        <img src="{{ asset('assets/images/noimage.png') }}"
                                                            style="width:50px;height:50px;">
                                                    @else
                                                        <img src="{{ asset('OneToOne/' . $data->photo) }}"
                                                            style="width:50px;height:50px;">
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $data->reject_comment ?? '' }}</td>
                                                <td class="text-center">
                                                    @if ($data->isapproved_status == 0)
                                                        Pending
                                                    @elseif($data->isapproved_status == 1)
                                                        Approved
                                                    @elseif($data->isapproved_status == 2)
                                                        Rejected
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                {{-- <td class="text-center">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#statusModal"
                                                        onclick="getEditDatastatus({{ $data->id }})"
                                                        title="Change Status">

                                                        <i class="fas fa-user-check text-success"></i>
                                                    </a>
                                                </td> --}}

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

                <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
                    aria-hidden="true">

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
                                <form action="{{ route('MemberOneToOne.updateStatus') }}" method="post">
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

    <script>
        function getEditDatastatus(id) {

            $('#business_id').val(id);
            $('#newStatus').val(1);
            toggleRejectedComments();

            var url = "{{ route('MemberOneToOne.getStatus', ':id') }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    // direct object use (no JSON.parse needed)
                    if (data.isapproved_status == 1 || data.isapproved_status == 2) {
                        $('#newStatus').val(data.isapproved_status);
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
