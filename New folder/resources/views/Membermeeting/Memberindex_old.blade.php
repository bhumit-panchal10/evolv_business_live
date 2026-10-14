
@extends('layouts.app')
@section('title', 'Admin user List')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Member Select</div>
                            <div class="card-body">
                            <form action="{{route('Membermeeting.memberstore')}}" method="POST">
                                @csrf
                                <input type="hidden" name="meetingid" value="{{$meetingid}}">
                                <div class="">
                                   <div class="row">
                                       @foreach($members as $member)
                                    <div class="col-lg-2">
                                    <label>     
                                        <input type="checkbox" name="members[]" value="{{ $member->member_id }}" {{ (in_array($member->member_id, $meetingdata->pluck('member_id')->toArray()))  ? 'checked' : '' }}>
                                        {{ $member->Contact_person }} 
                                    </label>
                                </div>
                                @endforeach              
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-4">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                    <button type="button" class="btn btn-danger btn-user float-right" onclick="cancelForm()">Cancel</button>
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

@endsection