@extends('layouts.app')
@section('title', 'Young leaders')
@section('content')
    <style>
        .joining-reason {
            max-width: 220px;
            /* adjust width as needed */
            max-height: 60px;
            /* row height control */
            overflow-y: auto;
            /* vertical scroll */
            overflow-x: hidden;
            white-space: normal;
            /* allow wrapping */
            word-break: break-word;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="col-md-12 mt-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row flex-between-end">
                                <div class="col-auto align-self-center">
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Young leaders List
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                    aria-labelledby="tab-dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540"
                                    id="dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540">
                                    <div id="tableExample" data-list='{"valueNames":["name","email","age"]}'
                                        style="max-height: 500px; overflow: auto;">
                                        @if ($count > 0)
                                            <table class="table table-bordered table-striped fs--1 mb-0">
                                                <thead class="bg-200 text-900">
                                                    <tr>
                                                        <th width="2%" data-sort="Title">Sr No</th>
                                                        <th width="2%" data-sort="Title">Name</th>
                                                        <th width="5%" data-sort="Date">Email</th>
                                                        <th width="2%" data-sort="Title">Phone Number</th>
                                                        <th width="2%" data-sort="Title">Profession</th>
                                                        <th width="1%" data-sort="Action">Industry Type</th>
                                                        <th width="2%" data-sort="Title">Company / Brand Name</th>
                                                        <th width="2%" data-sort="Title">Business Category</th>
                                                        <th width="2%" data-sort="Title">Company Type</th>
                                                        <th width="2%" data-sort="Title">City of Work</th>
                                                        <th width="2%" data-sort="Title">community participation</th>
                                                        <th width="2%" data-sort="Title">Community Name</th>
                                                        <th width="2%" data-sort="Title">Entry date</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    <?php $i = 1; ?>
                                                    @foreach ($Data as $inquiry1)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $i + $Data->perPage() * ($Data->currentPage() - 1) }}
                                                            </td>
                                                            <td class="text-center">{{ $inquiry1->name }}</td>
                                                            <td class="text-center">{{ $inquiry1->email }}</td>
                                                            <td class="text-center">{{ $inquiry1->mobile }}</td>
                                                            <td class="text-center">{{ $inquiry1->profession }}</td>
                                                            <td class="text-center">{{ $inquiry1->industry_type }}</td>
                                                            <td class="text-center">{{ $inquiry1->company_name }}</td>
                                                            <td class="text-center">{{ $inquiry1->categories_name }}</td>
                                                            <td class="text-center">{{ $inquiry1->company_type }}</td>
                                                            <td class="text-center">{{ $inquiry1->city }}</td>
                                                            <td class="text-center">
                                                                {{ $inquiry1->community_participation == 1 ? 'Yes' : 'No' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $inquiry1->community_participation == 1 ? $inquiry1->community_name : '-' }}
                                                            </td>

                                                            <td class="text-center">
                                                                {{ date('d-m-Y', strtotime($inquiry1->created_at)) }}</td>

                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div class="d-flex justify-content-center mt-3">
                                                {{ $Data->links() }}
                                            </div>
                                        @else
                                            <div class="row">
                                                <div
                                                    class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                                    <div
                                                        class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                                        <h1 class="font-white text-center"> No Data Found ! </h1>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
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
                                <form id="user-delete-form" method="POST" action="{{ route('Contactinquiry.delete') }}">
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
                                    html = '<img src="/Groath/event/' + obj.photo +
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

        @endsection
