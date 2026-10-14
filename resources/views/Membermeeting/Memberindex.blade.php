@extends('layouts.app')
@section('title', 'Admin user List')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li class="mb-5" style="color:red">{{ $error }}</li>
                    @endforeach
                @endif
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Member Select</div>
                                <div class="card-body">
                                    <form action="{{ route('Membermeeting.memberstore') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="meetingid" value="{{ $meetingid }}">
                                        <div class="mb-3">
                                            <label>
                                                <input type="checkbox" id="select-all">
                                                <strong>Select All Members</strong>
                                            </label>
                                        </div>

                                        <div class="">
                                            <div class="row">
                                                @foreach ($members as $member)
                                                    <div class="col-lg-2 mb-2">
                                                        <div class="form-check" style="white-space: normal;">
                                                            <input type="checkbox" class="form-check-input" name="members[]"
                                                                value="{{ $member->member_id }}"
                                                                id="member-{{ $member->member_id }}"
                                                                {{ in_array($member->member_id, $meetingdata->pluck('member_id')->toArray()) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="member-{{ $member->member_id }}">
                                                                {{ $member->Contact_person }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="row">
                                                    <div class="col-lg-3 mb-2">
                                                        <div class="form-check" style="white-space: normal;">
                                                            <label for="Ppttaken_1">PPT taken 1</label>
                                                            <select name="ppt_taken_1" class="form-control">
                                                                <option value="">--please select--</option>
                                                                @foreach ($members as $member)
                                                                    <option value="{{ $member->member_id }}"
                                                                        {{ in_array($member->member_id, $pptTaken1) ? 'selected' : '' }}>
                                                                        {{ $member->Contact_person }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 mb-2">
                                                        <div class="form-check" style="white-space: normal;">
                                                            <label for="Ppttaken_1">PPT Taken 2</label>
                                                            <select name="ppt_taken_2" class="form-control">
                                                                <option value="">--please select--</option>
                                                                @foreach ($members as $member)
                                                                    <option value="{{ $member->member_id }}"
                                                                        {{ in_array($member->member_id, $pptTaken2) ? 'selected' : '' }}>
                                                                        {{ $member->Contact_person }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 mb-2">
                                                        <div class="form-check" style="white-space: normal;">
                                                            <label for="Ppttaken_1">Brand Showcase 1</label>
                                                            <select name="brand_showcase_1" class="form-control">
                                                                <option value="">--please select--</option>
                                                                @foreach ($members as $member)
                                                                    <option value="{{ $member->member_id }}"
                                                                        {{ in_array($member->member_id, $brand_showcase_1) ? 'selected' : '' }}>
                                                                        {{ $member->Contact_person }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 mb-2">
                                                        <div class="form-check" style="white-space: normal;">
                                                            <label for="Ppttaken_1">Brand Showcase 2</label>
                                                            <select name="brand_showcase_2" class="form-control">
                                                                <option value="">--please select--</option>
                                                                @foreach ($members as $member)
                                                                    <option value="{{ $member->member_id }}"
                                                                        {{ in_array($member->member_id, $brand_showcase_2) ? 'selected' : '' }}>
                                                                        {{ $member->Contact_person }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <button class="btn btn-success" type="submit">Submit</button>
                                                    <button type="button" class="btn btn-danger btn-user float-right"
                                                        onclick="cancelForm()">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
        function cancelForm() {
            window.location.reload();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('input[name="members[]"]');

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
            });
        });
    </script>


@endsection
