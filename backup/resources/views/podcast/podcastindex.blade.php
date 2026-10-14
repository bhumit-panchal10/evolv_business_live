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
                                <h5 class="card-title mb-0">Book Your Podcast</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('podcast.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-3 mb-3">
                                        <div class="col-lg-4 col-md-6">
                                                <span style="color: red;">*</span>Book Your Podcast                                                
                                                <span style="color:red;" class="error-message">{{ $errors->first('Book_Your_Podcast ') }}</span> 
                                                <input type="date" class="form-control" name="Book_Your_Podcast" id="Book_Your_Podcast"
                                                placeholder="Select a date (Tuesday or Friday)" value="{{old('Book_Your_Podcast')}}" required>
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
//     document.addEventListener("DOMContentLoaded", function() {
//         var inputField = document.getElementById("Book_Your_Podcast");
        
//         // Function to check if the selected date is Tuesday or Friday
//         function isTuesdayOrFriday(dateString) {
//             var selectedDate = new Date(dateString);
//             var dayOfWeek = selectedDate.getDay();
//             return (dayOfWeek === 2 || dayOfWeek === 5); // Tuesday is 2, Friday is 5
//         }

//         // Event listener to check the day of the week when the input changes
//         inputField.addEventListener("change", function() {
//             if (!isTuesdayOrFriday(this.value)) {
//                 alert("Please select a Tuesday or Friday.");
//                 this.value = ""; // Clear the input field
//             }
//         });
//     });
// </script>

<script>
     function cancelForm() {
         window.location.reload(); 
     }
 </script>
 
 <script>
        document.addEventListener("DOMContentLoaded", function() {
            var inputField = document.getElementById("Book_Your_Podcast");

            // Set the minimum date to today
            var today = new Date().toISOString().split('T')[0];
            inputField.setAttribute('min', today);

            // Function to check if the selected date is Monday, Wednesday, or Friday
            function isMondayWednesdayFriday(dateString) {
                var selectedDate = new Date(dateString);
                var dayOfWeek = selectedDate.getDay();
                return (dayOfWeek === 1 || dayOfWeek === 3); // Monday is 1, Wednesday is 3, Friday is 5
            }

            // Disable dates that are not Monday, Wednesday, or Friday
            function disableInvalidDates() {
                var datePicker = inputField;
                var today = new Date();
                var minDate = new Date(today.setHours(0, 0, 0, 0)); // Set to start of today
                var maxDate = new Date(today.getFullYear(), today.getMonth() + 1, 0); // End of current month
                
                for (var d = minDate; d <= maxDate; d.setDate(d.getDate() + 1)) {
                    var dayOfWeek = d.getDay();
                    if (dayOfWeek !== 1 && dayOfWeek !== 3) {
                        var dateStr = d.toISOString().split('T')[0];
                        var option = document.createElement("option");
                        option.value = dateStr;
                        datePicker.appendChild(option);
                    }
                }
            }

            // Event listener to check the day of the week when the input changes
            inputField.addEventListener("change", function() {
                if (!isMondayWednesdayFriday(this.value)) {
                    alert("Please select a Monday, Wednesday,");
                    this.value = ""; // Clear the input field
                }
            });

            disableInvalidDates();
        });
    </script>
@endsection



