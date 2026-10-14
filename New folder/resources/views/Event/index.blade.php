@extends('layouts.app')
@section('title', 'Events List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
            <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                {{-- Alert Messages --}}
                @include('common.alert')
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('Event.storeview') }}" class="btn btn-success">Add Events</a>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row flex-between-end">
                                <div class="col-auto align-self-center">
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Events List
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
                                        <div class="table-responsive scrollbar">
                                            <table class="table table-bordered table-striped fs--1 mb-0">
                                                <thead class="bg-200 text-900">
                                                    <tr>
                                                        <th width="2%" data-sort="Title">Sr No</th>
                                                        <th width="2%" data-sort="Title">Events Name</th>
                                                        <th width="2%" data-sort="Title">Photo</th>
                                                        <th width="5%" data-sort="Date">Events start Date</th>
                                                        <th width="5%" data-sort="Date">Events End Date</th>
                                                        <th width="5%" data-sort="Date">IS Paid</th>
                                                        <th width="5%" data-sort="Date">Price</th>
                                                        <th width="5%" data-sort="Date">Limited Set</th>
                                                        <th width="5%" data-sort="Date">Set Number
                                                        </th>
                                                        <th width="5%" data-sort="Action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    <?php $i = 1; ?>
                                                    @foreach ($Events as $Event)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $i + $Events->perPage() * ($Events->currentPage() - 1) }}
                                                            </td>
                                                            <td class="text-center">{{ $Event->name }}</td>
                                                            <td class="text-center">
                                                                 <img src="{{ asset('event') . '/' . $Event->photo }}"
                                                                                style="width: 50px;height: 50px;">
                                                            </td>
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($Event->eventstart_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($Event->eventend_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="text-center">{{ $Event->ispaid }}</td>
                                                            <td class="text-center">
                                                                @if (isset($Event->price))
                                                                    {{ $Event->price }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td class="text-center">{{ $Event->limitedset }}</td>
                                                            <td class="text-center">
                                                                @if (isset($Event->setnumber))
                                                                    {{ $Event->setnumber }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td class="d-flex gap-2 justify-content-center">
                                                                <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#EditModal"
                                                                    onclick="getEditData(<?= $Event->event_id ?>)"
                                                                    class="" title="Edit">
                                                                    <span class="text-500 fas fa-edit"></span>
                                                                </a>
                                                                <a class="" href="#" data-bs-toggle="modal"
                                                                    title="Delete" data-bs-target="#deleteRecordModal"
                                                                    onclick="deleteData(<?= $Event->event_id ?>);">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                                <a class="" href="{{ route('Eventinquiry.index', $Event->event_id) }}" title="Event Inquiry">
                                                                    <i class="fa fa-question-circle" aria-hidden="true"></i> 
                                                                </a>

                                                            </td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                   
                                      {{ $Events->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " style="background-color: white;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Events</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </button>
                        </div>
                        <form method="post" action="{{ route('Event.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="modal-body">

                                <input type="hidden" name="event_id" id="event_id" value="">

                                <div class="row">
                                    <div class="form-group">
                                        <span style="color:red;">*</span>Events Name</label>
                                        <input class="form-control" id="Editname" name="name" type="text"
                                            placeholder="Enter Name" value="{{ old('name') }}" required>
                                    </div><br>
                                    <div class="mb-3">
                                         <span style="color:red;">*</span>Photo</label>
                                         <input type="file" name="photo" class="form-control" id="Editphoto" >
                                         <input type="hidden" name="hiddenPhoto" class="form-control" id="hiddenPhoto">
                                         <div id="PHOTOID">
                                         </div>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Events start Date
                                        <input type="date" class="form-control" name="eventstart_date"
                                            id="Editeventstart_date" placeholder="Enter Event Start Date"
                                            value="{{ old('eventstart_date') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Events End Date
                                        <input type="date" class="form-control" name="eventend_date"
                                            id="Editeventend_date" placeholder="Enter Event End Date"
                                            value="{{ old('eventend_date') }}" required>
                                    </div>
                                    {{-- NEW START --}}
                                    <div class="mb-3">
                                        <span style="color:red;">*</span> IS Paid
                                        <select class="form-control" name="ispaid" id="Editispaid"
                                            value="{{ old('ispaid') }}" required>
                                            <option value="No" {{ old('ispaid') == 'No' ? 'selected' : '' }}>No
                                            </option>
                                            <option value="Yes" {{ old('ispaid') == 'Yes' ? 'selected' : '' }}>Yes
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="priceField"
                                        style="{{ old('ispaid') == 'Yes' ? '' : 'display:none;' }}">
                                        <label for="price">Price:</label>
                                        <input type="number" class="form-control" name="price" id="Editprice"
                                            placeholder="Enter Price" value="{{ old('price') }}">
                                    </div>
                                    <div class="mb-3">
                                        <span style="color:red;">*</span> Limited set
                                        <select class="form-control" name="limitedset" id="Editlimitedset"
                                            value="{{ old('limitedset') }}" required>
                                            <option value="No" {{ old('limitedset') == 'No' ? 'selected' : '' }}>No
                                            </option>
                                            <option value="Yes" {{ old('limitedset') == 'Yes' ? 'selected' : '' }}>Yes
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="setnumber"
                                        style="{{ old('limitedset') == 'Yes' ? '' : 'display:none;' }}">
                                        <label for="setnumber">Set Number:</label>
                                        <input type="number" class="form-control" name="setnumber" id="Editsetnumber"
                                            placeholder="Enter setnumber" value="{{ old('setnumber') }}">
                                    </div>

                                    {{-- NEW END  --}}
                                    <div class="mb-3 w-100">
                                        <label for="description">
                                            <span style="color:red;">*</span>Description
                                        </label>
                                        <textarea style="width:100%;"  class="form-control" name="description" id="Editdescription" placeholder="Enter Description"
                                            rows="4" maxlength="500" autocomplete="off" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-success">

                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                </div>
                        </form>
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
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <a class="btn btn-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                            Yes,
                            Delete It!
                        </a>
                        <form id="user-delete-form" method="POST" action="{{ route('Event.delete') }}">
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
    {{-- @endforeach --}}
@endsection

@section('scripts')
    {{-- <script>
        function getEditData(id) {
            // alert(id);
            var url = "{{ route('Event.edit', ':id') }}";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id,
                        id
                    },
                    success: function(data) {
                        alert();
                        // console.log(data);
                        var obj = JSON.parse(data);
                        $("#Editname").val(obj.name);
                        $("#Editeventstart_date").val(obj.eventstart_date);
                        $("#Editeventend_date").val(obj.eventend_date);
                        $("#Editispaid").val(obj.ispaid);
                        $("#Editprice").val(obj.price);
                        $("#Editlimitedset").val(obj.limitedset);
                        $("#Editsetnumber").val(obj.setnumber);
                        $("#Editdescription").val(obj.description);
                        $('#hiddenPhoto').val(obj.photo);
                        var html = "";
                        if (obj.photo) {
                            html = '<img src="/event/' + obj.photo +
                                '" id="hiddenPhoto" width="50px" height = "50px" > ';
                        }
                        $('#event_id').val(id);
                    }
                });
            }
        }
    </script> --}}

    <script>
        function getEditData(id) {
            // alert(id);
            var url = "{{ route('Event.edit', ':id') }}";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id,
                        id
                    },
                    success: function(data) {
                        // console.log(data);
                        var obj = JSON.parse(data);
                        $("#Editname").val(obj.name);
                        $("#Editeventstart_date").val(obj.eventstart_date);
                        $("#Editeventend_date").val(obj.eventend_date);
                        $("#Editispaid").val(obj.ispaid);
                        $("#Editprice").val(obj.price);
                        $("#Editlimitedset").val(obj.limitedset);
                        $("#Editsetnumber").val(obj.setnumber);
                        $("#Editdescription").val(obj.description);
                        // alert(obj.photo);
                        $('#hiddenPhoto').val(obj.photo);
                        var html = "";
                        if (obj.photo) {
                            html = '<img src="/event/' + obj.photo +
                                '" id="hiddenPhoto" width="50px" height = "50px" > ';
                        }
                        $('#event_id').val(id);
                        $('#PHOTOID').html(html);

                        // Toggle visibility based on ispaid value
                        if (obj.ispaid == 'Yes') {
                            $("#priceField").show();
                        } else {
                            $("#priceField").hide();
                        }

                        // Toggle visibility based on limitedset value
                        if (obj.limitedset == 'Yes') {
                            $("#setnumber").show();
                        } else {
                            $("#setnumber").hide();
                        }
                    }
                });
            }
        }

        // Add change event listeners to ispaid and limitedset select elements
        $("#Editispaid").change(function() {
            if ($(this).val() == 'Yes') {
                $("#priceField").show();
            } else {
                $("#priceField").hide();
            }
        });

        $("#Editlimitedset").change(function() {
            if ($(this).val() == 'Yes') {
                $("#setnumber").show();
            } else {
                $("#setnumber").hide();
            }
        });
    </script>

    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png',
                'webp'
            ];
            var fileExtension = document.getElementById('photovalidate').value.split('.').pop().toLowerCase();
            var isValidFile = false;

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }

            if (!isValidFile) {
                alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
            }

            return isValidFile;
        }
    </script>

    <script>
        function EditvalidateFile() {
            //alert('hello');
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
            var fileExtension = document.getElementById('Editphoto').value.split('.').pop().toLowerCase();
            var isValidFile = false;
            var image = document.getElementById('Editphoto').value;
            for (var index in allowedExtension) {
                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }
            if (image != "") {
                if (!isValidFile) {
                    alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
                }
                return isValidFile;
            }
            return true;
        }
    </script>

    {{-- Add photo --}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#hello').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#photovalidate").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#viewimg').html(html);
        });
    </script>

    {{-- Edit photo --}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#hello').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#Editphoto").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#PHOTOID').html(html);
        });
    </script>
    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>


    <script>
        $(document).ready(function() {
            getEditData();
            // Initial state based on existing values
            if ($("#Editispaid").val() === "Yes") {
                $("#priceField").show();
            } else {
                $("#priceField").hide();
            }

            if ($("#Editlimitedset").val() === "Yes") {
                $("#setnumber").show();
            } else {
                $("#setnumber").hide();
            }

            // Trigger change event to apply initial state
            $("#Editispaid").trigger('change');
            $("#Editlimitedset").trigger('change');

            // Event listeners
            $("#Editispaid").on('change', function() {
                if ($(this).val() === "Yes") {
                    $("#priceField").show();
                } else {
                    $("#priceField").hide();
                }
            });

            $("#Editlimitedset").on('change', function() {
                if ($(this).val() === "Yes") {
                    $("#setnumber").show();
                } else {
                    $("#setnumber").hide();
                }
            });
        });
    </script>
    
    
    <script>
        $(document).ready(function() {
            // Function to initialize NicEdit within the modal
            function initNicEdit() {
                new nicEditor({ fullPanel: true }).panelInstance('Editdescription');
            }

            // Attach NicEdit initialization to modal shown event
            $('#EditModal').on('shown.bs.modal', function () {
                initNicEdit();
            });
        });
    </script>

@endsection
