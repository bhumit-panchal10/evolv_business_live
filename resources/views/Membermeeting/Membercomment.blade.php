@extends('layouts.app')
@section('title', 'Meeting Member comment add')
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

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Meeting Member List</h5>
                                </div>
                                {{-- <div>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-success open-add-member-modal"
                                        data-meeting_id="{{ $metting_id ?? '' }}">
                                        Add Member
                                    </a>
                                </div> --}}
                            </div>

                        </div>
                        <div class="card-body">
                            <?php //echo date('ymd');
                            ?>

                            <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                @if ($count > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Member Name</th>
                                            <th scope="col">Meeting title</th>
                                            <th scope="col">Meeting start date</th>
                                            <th scope="col">Meeting End date</th>
                                            <th scope="col">Meeting Status</th>
                                            <th scope="col">Substitute Name</th>
                                            <th scope="col">Comment</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                                <td class="text-center">{{ $data->Contact_person }}</td>
                                                <td class="text-center">{{ $data->Meeting_title }}</td>
                                                <td class="text-center">{{ $data->start_date }}</td>
                                                <td class="text-center">{{ $data->End_date }}</td>
                                                <td class="text-center">
                                                    @if ($data->is_approve_meeting == 1)
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif($data->is_approve_meeting == 2)
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $data->substitute_name ?? 'N/A' }}</td>
                                                <td class="text-center"
                                                    style="max-width:250px; white-space:normal; word-wrap:break-word; word-break:break-word;"
                                                    title="{{ $data->comment ?? '' }}">
                                                    {{ \Illuminate\Support\Str::limit($data->comment, 100, '...') ?? 'No Comment' }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-sm btn-outline-primary open-status-modal"
                                                            data-id="{{ $data->Cluster_Meet_Member_meeting_id }}"
                                                            data-status="{{ $data->is_approve_meeting ?? 0 }}"
                                                            data-comment="{{ e($data->comment ?? '') }}"
                                                            data-meeting_id="{{ $data->meeting_id }}"
                                                            data-member_id="{{ $data->user_id }}">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                        {{-- <a href="javascript:void(0);"
                                                            class="btn btn-sm btn-outline-sucess open-comment-modal"
                                                            data-id="{{ $data->Cluster_Meet_Member_meeting_id }}"
                                                            data-member_id="{{ $data->member_id }}"
                                                            data-meeting_id="{{ $data->meeting_id }}">
                                                            <i class="fas fa-comment-dots"></i>
                                                        </a> --}}
                                                    </div>
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

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Brand Showcase Amount</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('Membermeeting.saveBrandAmount') }}">
                            @csrf
                            <input type="hidden" name="meeting_id" value="{{ $metting_id }}">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Meeting</th>
                                        <th>Member Name</th>
                                        <th>Brand Showcase</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @php
                                        $shown = [];
                                    @endphp

                                    @forelse($brandshowcasedata as $data)

                                        {{-- Brand Showcase 1 --}}
                                        @if ($data->brand_showcase_1 == $data->member_id && !in_array('brand1_' . $data->brand_showcase_1, $shown))
                                            @php $shown[] = 'brand1_'.$data->brand_showcase_1; @endphp

                                            <tr>
                                                <td>{{ $data->Meeting_title }}</td>

                                                <td>{{ $data->brand1_name ?? 'N/A' }}</td>

                                                <td>
                                                    <span class="badge bg-success">
                                                        Brand Showcase 1
                                                    </span>
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        name="brand_showcase_1_amount[{{ $data->brand_showcase_1 }}]"
                                                        class="form-control" value="{{ $data->brand_showcase_1_amount }}"
                                                        placeholder="Enter Amount">
                                                </td>
                                                <td>
                                                    @if ($data->is_approve == 1)
                                                        <span class="badge bg-success">
                                                            Approved
                                                        </span>
                                                    @elseif($data->is_approve == 2)
                                                        <span class="badge bg-danger">
                                                            Rejected
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">
                                                            Pending
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif


                                        {{-- Brand Showcase 2 --}}
                                        @if ($data->brand_showcase_2 == $data->member_id && !in_array('brand2_' . $data->brand_showcase_2, $shown))
                                            @php $shown[] = 'brand2_'.$data->brand_showcase_2; @endphp

                                            <tr>
                                                <td>{{ $data->Meeting_title }}</td>

                                                <td>{{ $data->brand2_name ?? 'N/A' }}</td>

                                                <td>
                                                    <span class="badge bg-primary">
                                                        Brand Showcase 2
                                                    </span>
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        name="brand_showcase_2_amount[{{ $data->brand_showcase_2 }}]"
                                                        class="form-control" value="{{ $data->brand_showcase_2_amount }}"
                                                        placeholder="Enter Amount">
                                                </td>
                                                <td>
                                                    @if ($data->is_approve == 1)
                                                        <span class="badge bg-success">
                                                            Approved
                                                        </span>
                                                    @elseif($data->is_approve == 2)
                                                        <span class="badge bg-danger">
                                                            Rejected
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">
                                                            Pending
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif


                                    @empty

                                        <tr>
                                            <td colspan="4" class="text-center">
                                                No Data Found
                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-success">Update Amount</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Comment Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="commentForm" method="POST" action="{{ route('Membermeeting.commentsstore') }}">
                @csrf
                <input type="hidden" name="cluster_meet_member_meeting_id" id="clusterMeetMemberMeetingId">
                <input type="hidden" name="member_id" id="commentMemberId">
                <input type="hidden" name="meeting_id" id="commentMeetingId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="commentText" class="form-label">Comment</label>
                            <textarea class="form-control" name="comment" id="commentText" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit Comment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="meetingStatusModal" tabindex="-1" aria-labelledby="meetingStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="meetingStatusForm" method="POST"
                action="{{ route('pendinglogincheck.meetinglogincheck', ['id' => ':id']) }}">
                @csrf
                <input type="hidden" name="id" id="statusMeetingMemberId">
                <input type="hidden" name="memberid" id="statusMemberId">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="meetingStatusModalLabel">Update Meeting Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="meetingStatusSelect" class="form-label">Status</label>
                            <select class="form-control" name="newStatus" id="meetingStatusSelect"
                                onchange="toggleRejectedComments()" required>
                                <option value="1">Join</option>
                                <option value="3">Absent</option>
                                <option value="4">Substitute</option>
                            </select>
                        </div>
                        <div class="mb-3" id="meetingStatusCommentGroup" style="display:none;">
                            <label for="meetingStatusComment" class="form-label">Substitute Name</label>
                            <input type="text" class="form-control" name="substitute_name"
                                id="meetingStatusSubstitute" placeholder="Enter Substitute Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Status</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- end model comment --}}
    {{-- start add member model --}}
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('Membermeeting.Meeting_add_member') }}">
                @csrf
                <input type="hidden" name="meeting_id" id="modalMeetingId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMemberModalLabel">Add Member to Meeting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="member_id" class="form-label">Select Member</label>
                            <select class="form-select" name="member_id" id="memberDropdown" required>
                                <option value="">Loading...</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Add Member</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- End add member model --}}

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
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <a class="btn btn-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                            Yes,
                            Delete It!
                        </a>
                        <form id="user-delete-form" method="POST" action="{{ route('MemberProducts.delete') }}">
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
        document.addEventListener('DOMContentLoaded', function() {
            window.toggleRejectedComments = function() {

                var statusSelect = document.getElementById('meetingStatusSelect');
                var substituteGroup = document.getElementById('meetingStatusCommentGroup');
                var substituteField = document.getElementById('meetingStatusSubstitute');

                if (statusSelect.value == '4') {

                    substituteGroup.style.display = 'block';
                    substituteField.setAttribute('required', 'required');

                } else {

                    substituteGroup.style.display = 'none';
                    substituteField.removeAttribute('required');
                    substituteField.value = '';
                }
            };
            const addButtons = document.querySelectorAll('.open-add-member-modal');
            const modal = new bootstrap.Modal(document.getElementById('addMemberModal'));

            addButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const meetingId = this.dataset.meeting_id;

                    document.getElementById('modalMeetingId').value = meetingId;

                    const url = `{{ route('Membermeeting.get_available_members', ':id') }}`
                        .replace(':id',
                            meetingId);

                    const dropdown = document.getElementById('memberDropdown');
                    dropdown.innerHTML = `<option value="">Loading...</option>`;

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            dropdown.innerHTML = '';
                            if (data.length > 0) {
                                dropdown.innerHTML =
                                    `<option value="" disabled selected>Select Member</option>`;
                                data.forEach(member => {
                                    dropdown.innerHTML +=
                                        `<option value="${member.id}">${member.name}</option>`;
                                });
                            } else {
                                dropdown.innerHTML =
                                    `<option value="">No available members</option>`;
                            }

                        }).catch(error => {
                            console.error('AJAX error:', error);
                            dropdown.innerHTML =
                                `<option value="">Error loading members</option>`;
                        });

                    modal.show();
                });
            });
        });
    </script>
    {{-- This is comment script start --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentButtons = document.querySelectorAll('.open-comment-modal');
            const statusButtons = document.querySelectorAll('.open-status-modal');
            const commentModal = new bootstrap.Modal(document.getElementById('commentModal'));
            const statusModal = new bootstrap.Modal(document.getElementById('meetingStatusModal'));

            commentButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const clusterMeetMemberMeetingId = this.dataset.id;
                    const memberId = this.dataset.member_id;
                    const meetingId = this.dataset.meeting_id;

                    document.getElementById('clusterMeetMemberMeetingId').value =
                        clusterMeetMemberMeetingId;
                    document.getElementById('commentMemberId').value = memberId;
                    document.getElementById('commentMeetingId').value = meetingId;
                    commentModal.show();
                });
            });

            statusButtons.forEach(button => {
                button.addEventListener('click', function() {

                    const id = this.dataset.id;
                    const status = this.dataset.status;
                    const member_id = this.dataset.member_id;
                    const comment = this.dataset.comment || '';

                    document.getElementById('statusMeetingMemberId').value = id;
                    document.getElementById('meetingStatusSelect').value = status;
                    document.getElementById('meetingStatusSubstitute').value = comment;
                    document.getElementById('statusMemberId').value = member_id;
                    document.getElementById('meetingStatusCommentGroup').style.display = status ===
                        '4' ? 'block' : 'none';
                    statusModal.show();
                });
            });

            const meetingStatusSelect = document.getElementById('meetingStatusSelect');
            const meetingStatusCommentGroup = document.getElementById('meetingStatusCommentGroup');
            meetingStatusSelect.addEventListener('change', function() {
                meetingStatusCommentGroup.style.display = this.value === '4' ? 'block' : 'none';
            });
        });
    </script>

    <script>
        function getEditData(id) {
            var url = "{{ route('MemberProducts.productedit', ':id') }}";
            url = url.replace(":id", id);

            if (id) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        var obj = JSON.parse(data);

                        $("#editproductname").val(obj.product_name);
                        $("#editdescription").val(obj.description);
                        $('#getid').val(obj.memberservices_id);
                        $('#memberid').val(obj.member_id);
                        $("#edit_price_type").val(obj.price_type);
                        if (obj.price_type === 'fixed') {
                            $("#edit_fixed_price_input").show();
                            $("#edit_ranged_price_input").hide();
                            $("#edit_fixed_price").val(obj.price);
                        } else if (obj.price_type === 'ranged') {
                            $("#edit_fixed_price_input").hide();
                            $("#edit_ranged_price_input").show();
                            $("#edit_min_price").val(obj.min_price);
                            $("#edit_max_price").val(obj.max_price);
                        }
                    }
                });
            }
        }
        $("#edit_price_type").on("change", function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'fixed') {
                $("#edit_fixed_price_input").show();
                $("#edit_ranged_price_input").hide();
            } else if (selectedValue === 'ranged') {
                $("#edit_fixed_price_input").hide();
                $("#edit_ranged_price_input").show();
            }
        });
    </script>
    <script>
        function deleteData(id) {
            // alert(id);
            $("#deleteid").val(id);
        }
    </script>

    <script>
        function chkname() {
            var name = $('#companyname').val();
            var url = "{{ route('members.checkserviceprovider') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    name,
                    name
                },
                success: function(data) {
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (data == 1) {

                        alert('Members Already Exist');
                        $('#companyname').val('');
                        $('#companyname').focus();
                        return false;

                    }
                }
            });
        }
    </script>
    <script>
        function editchkname() {
            var name = $('#Editname').val();
            var url = "{{ route('members.editcheckserviceprovider') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    name,
                    name
                },
                success: function(data) {
                    console.log(data);
                    var obj = JSON.parse(data);
                    if (data == 1) {

                        alert('Members Already Exist');
                        $('#Editname').val('');
                        $('#Editname').focus();
                        return false;

                    }
                }
            });
        }
    </script>


@endsection
