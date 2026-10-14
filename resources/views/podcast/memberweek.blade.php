@extends('layouts.app')
@section('title', ' Book Your Podcast')
@section('content')
<?php $session = auth()->user(); ?>

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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Book Your Member of the week </h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('podcast.weekstore') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-3 mb-3">
                                           <div class="col-lg-4 col-md-6">
                                                <span style="color: red;">*</span>Book Your Member of the week                                                
                                                <span style="color:red;" class="error-message">{{ $errors->first('Book_Your_Member_of_the_week') }}</span> 
                                                <input type="date" class="form-control" name="Book_Your_Member_of_the_week" id="Book_Your_Member_of_the_week"
                                                    placeholder="Enter Book Your Member of the week" value="{{old('Book_Your_Member_of_the_week')}}" required>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <span style="color: red;">*</span>Available time                                             
                                                <span style="color:red;" class="error-message">{{ $errors->first('Book_Your_Member_of_the_week') }}</span> 
                                                <input type="text" class="form-control" name="Book_week_time" id=""
                                                    placeholder="Enter available time" value="{{old('Book_week_time')}}" required>
                                            </div>
                                            <p><strong>Disclaimer -</strong><br>
                                            Member of the week slot is subject to availability. Core team decision will be final in case of any discrepancy.</p>

                                            <div class="text-center">
                                            <button type="submit" class="btn btn-success btn-user"
                                                    style="width:
                                                    81px; height: 40px;">Submit</button>
                                                    <button type="button" class="btn btn-danger btn-user" style="width:
                                                    81px; height: 38px;" onclick="cancelForm()">Cancel</button>
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
@endsection
@section('scripts')
// <script>
//     // Get the input field
//     var input = document.getElementById("Book_Your_Member_of_the_week");
//     input.addEventListener("change", function() {
//         var selectedDate = new Date(this.value);
//         var dayOfWeek = selectedDate.getDay(); 
//         if (dayOfWeek !== 1) {
//             this.value = '';
//             alert('Please select only Monday.');
//         }
//     });
// </script>

<script>
     function cancelForm() {
         window.location.reload(); 
     }
 </script>
 
<script>
    var input = document.getElementById("Book_Your_Member_of_the_week");

    var today = new Date().toISOString().split('T')[0];
    input.setAttribute('min', today);

    input.addEventListener("change", function() {
        var selectedDate = new Date(this.value);
        var dayOfWeek = selectedDate.getDay();
        if (dayOfWeek !== 1) { 
            this.value = '';
            alert('Please select only Monday.');
        }
    });
</script>
@endsection

