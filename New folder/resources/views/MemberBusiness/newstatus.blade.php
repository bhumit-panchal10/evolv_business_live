
@extends('layouts.app2')
@section('title', 'Member Status')
@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
                @include('common.alert')
            <form action="{{ route('statusadd') }}" method="post">
                @csrf
                <input type="hidden" name="id" id="" value="{{$gu_id}}">
                <div class="form-group col-md-4">
                    <label for="newStatus">Update Status:</label>
                    <select class="form-control" name="newStatus" id="newStatus" onchange="toggleRejectedComments()">
                        <option value="1" {{ isset($Business1->isapproved_status) && $Business1->isapproved_status == 1 ? 'selected' : '' }}>Approved</option>
                        <option value="2" {{ isset($Business1->isapproved_status) && $Business1->isapproved_status == 2 ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="form-group rejectedComments col-md-4" style="display: {{ isset($Business1->isapproved_status) && $Business1->isapproved_status == 2 ? 'block' : 'none' }}">
                    <label for="rejectedComments">Rejected Comments:</label>
                    <textarea class="form-control" name="businesscomment"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleRejectedComments() {
        var statusSelect = document.getElementById('newStatus');
        var rejectedComments = document.querySelector('.form-group.rejectedComments');

        rejectedComments.style.display = (statusSelect.value == 2) ? 'block' : 'none';
    }
</script>

@endsection
