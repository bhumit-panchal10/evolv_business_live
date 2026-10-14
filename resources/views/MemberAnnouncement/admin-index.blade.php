@extends('layouts.app')
@section('title', 'Member Announcements - Admin')
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
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">All Member Announcements
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                @if ($count > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Member Name</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Photo</th>
                                            <th scope="col">Created Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                                <td class="text-center">
                                                    {{ $data->member->Contact_person ?? 'N/A' }}
                                                </td>
                                                <td class="text-center">{{ $data->title }}</td>
                                                <td class="text-center">
                                                    @if (strlen($data->description) > 50)
                                                        {{ substr($data->description, 0, 50) }}...
                                                    @else
                                                        {{ $data->description }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if (empty($data->photos))
                                                        <img src="{{ asset('assets/images/noimage.png') }}"
                                                            style="width:50px;height:50px;">
                                                    @else
                                                        <img src="{{ asset('MemberAnnouncement/' . $data->photos) }}"
                                                            style="width:50px;height:50px;">
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ $data->created_at->format('d-m-Y H:i') }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="#" class="text-danger" data-bs-toggle="modal"
                                                            data-bs-target="#deleteRecordModal"
                                                            onclick="deleteData({{ $data->id }})" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                @else
                                    <div class="row">
                                        <div
                                            class="col-lg-12 col-md-12 col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                            <div
                                                class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundgreen">
                                                <h1 class="font-white text-center">No Data Found! </h1>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </table>
                        </div>

                        @if ($count > 0)
                            <div class="card-footer">
                                <nav aria-label="Page navigation example">
                                    {!! $datas->links() !!}
                                </nav>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteRecordModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h5 class="modal-title">Delete Announcement</h5>
                    <p class="mt-2">Are you sure you want to delete this announcement?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <form method="post" action="{{ route('MemberAnnouncement.delete') }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" id="delete_id">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteData(id) {
            document.getElementById('delete_id').value = id;
        }
    </script>
@endsection
