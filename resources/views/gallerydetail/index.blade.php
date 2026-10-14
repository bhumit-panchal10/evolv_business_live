@extends('layouts.app')
@section('title', 'Album Detail List')
@section('content')
        <div class="main-content">
           <div class="page-content">
                <div class="container-fluid">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    {{-- Alert Messages --}}
                    @include('common.alert')
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-end">
                                        <div class="col-auto align-self-center">
                                            <h5 class="card-title mb-0">Add Album Detail </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light">
                                    <div class="tab-content">
                                        <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                            aria-labelledby="tab-dom-160a4566-7e94-45a2-bf04-b36ef49d954f"
                                            id="dom-160a4566-7e94-45a2-bf04-b36ef49d954f">
                                            <form onsubmit="return validateFile()" method="POST" id="myForm"
                                                action="{{ route('gallerydetail.create') }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="gallery_id" value="{{ $id }}">
                                                <div class="mb-3">
                                                    <span style="color:red;">*</span>Photo</label>
                                                    <input class="form-control" type="file" name="photo[]" multiple id="photovalidate"
                                                        value="{{ old('photo') }}" required>
                                                </div>
                                                <div class="col-lg-3 col-md-3">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button type="submit" class="btn btn-success btn-user float-right">Submit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-user float-right" onclick="cancelForm()">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 mt-3">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-end align-items-center">    
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title mb-0">Album Detail List</h5>
                                            <a class="btn btn-success" href="{{ route('gallery.index') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="tab-content">
                                        <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                            aria-labelledby="tab-dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540"
                                            id="dom-dcc399ed-d1d3-44f8-99e0-31c1d0b7b540">
                                            <div id="tableExample" data-list='{"valueNames":["name","email","age"]}'>
                                                <div class="">

                                                    <form role="form" method="POST" action="" name="frmparameter" id="frmparameter"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('post')
                                                        <div class="form-group row">
                                                            <div class="col-md-1">
                                                                <input style="display: inline-block;margin-left: 17px;width: 165px;"
                                                                    id="Btnmybtn" class="btn btn-xs btn-danger mt-2 "
                                                                    onclick="multiDelete()" value="Delete Selected" readonly  name="submit" />
                                                            </div>
                                                        </div>
                                                        <hr />

                                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th width="33.3%">
                                                                        <input type="checkbox" onclick="javascript:CheckAll();"
                                                                            id="check_listall" class="md-check" value="">
                                                                        <label for="check_listall">
                                                                           
                                                                            <span class="check"></span>
                                                                            <span class="box"></span>
                                                                        </label>
                                                                    </th>
                                                                    <th width="33.3">Photos</th>
                                                                    <th width="33.3">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i = 0; ?>
                                                                @foreach ($Data as $data)
                                                                    <?php
                                                                    $i++;
                                                                    ?>
                                                                    <tr>
                                                                        <td data-label="id">
                                                                            <input type="checkbox" name="check_list[]"
                                                                                id="check_list<?php echo $i; ?>" class="md-check"
                                                                                value="<?php echo $data->gallery_detail_id; ?> ">
                                                                            <label for="check_list<?php echo $i; ?>">
                                                                                <span></span>
                                                                                <span class="check"></span>
                                                                                <span class="box"></span></label>
                                                                        </td>
                                                                        <td ><img src="{{ asset('GalleryDetail') . '/' . $data->photo }}"
                                                                                style="width: 50px;height: 50px;">
                                                                        </td>
                                                                        <td>
                                                                            <a class="" href="#"
                                                                                data-bs-toggle="modal" title="Delete"
                                                                                data-bs-target="#deleteRecordModal"
                                                                                onclick="deleteData(<?= $data->gallery_detail_id ?>);">
                                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                                            </a>
                                                                        </td>
                                                                     
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="d-flex justify-content-center mt-3">
                                                            {{$Data->links()}}
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
                        <form id="user-delete-form" method="POST" action="{{ route('gallerydetail.delete') }}">
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
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
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
        function CheckAll() {
            if ($('#check_listall').is(":checked")) {
                $('input[type=checkbox]').each(function() {
                    $(this).prop('checked', true);
                });
            } else {
                $('input[type=checkbox]').each(function() {
                    $(this).prop('checked', false);
                });
            }
        }
    </script>

    <script>
        function multiDelete() {
            //alert('hello');
            if (confirm('Are You Sure You want to Delete?')) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('gallerydetail.deleteselected') }}",
                    data: $('#frmparameter').serialize(),
                    success: function(response) {
                        //alert(response);
                        if (response == 1) {
                            $('#loading').css("display", "none");
                            $("#Btnmybtn").attr('disabled', 'disabled');
                            alert('Album Detail Deleted Sucessfully.');
                            window.location.href = '';
                        } else {
                            $('#loading').css("display", "none");
                            $("#Btnmybtn").attr('disabled', 'disabled');
                            alert('Something want wrong,Please Try Again.');
                            window.location.href = '';
                        }
                        //return false;
                    }
                });
            }
            //});
            //return false;
        }
    </script>

    <script>
        function deletephoto(id) {
            var ID = id;
            var url = "{{ route('gallerydetail.delete') }}";
            if (confirm('Are you Sure You wanted to  Delete?')) {
                if (ID) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: ID
                        },
                        success: function(data) {

                            if (data == 1) {
                                $('#loading').css("display", "none");
                                $("#Btnmybtn").attr('disabled', 'disabled');
                                alert('Album Detail Deleted Sucessfully.');
                                window.location.href = '';
                            }

                        }
                    });
                    //return false;
                }
            }
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
 <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>
<script>
        function cancelForm() {
            window.location.reload(); 
        }
    </script>
@endsection
