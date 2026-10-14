
@extends('layouts.app')
@section('title', 'Announcement Edit')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

            <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

                @include('common.alert')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-3 mb-3">
                            <div class="card-header">
                                <div class="row flex-between-end">
                                    <div class="col-auto align-self-center">
                                        <h5 class="card-title mb-0">Edit Announcement</h5>
                                    </div>
                                </div>
                            </div>
                         
                            <div class="card-body bg-light">
                                <div class="tab-content">
                                    <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                        aria-labelledby="tab-dom-160a4566-7e94-45a2-bf04-b36ef49d954f"
                                        id="dom-160a4566-7e94-45a2-bf04-b36ef49d954f">
                                        <form  method="post" action="{{route('Announcement.update')}}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('post')
                                        <input type="hidden" name="id" value="{{$Data->id}}">
                                            <div class="row">
                                                
                                                <div class="col-md-4 mt-2">
                                                    <span style="color:red;">*</span>Title</label>
                                                    <input class="form-control" id="basic-form-name" name="Title"
                                                        type="text" placeholder="Enter Title"
                                                        value="{{ $Data->Title ?? '' }}" required>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                        <span style="color:red;">
                                                            *</span>Photo</label>
                                                        <input class="form-control" type="file" name="photo" id="photovalidate"
                                                            value="{{ $Data->photo ?? '' }}">
                                                        <input type="hidden" name="hiddenPhoto" class="form-control"
                                                            value="{{ old('photo') ? old('photo') : $Data->photo }}" id="hiddenPhoto">
                                                        <div id="viewimg">
                                                            <img src="{{ asset('Announcement') . '/' . $Data->photo }}" alt=""
                                                                height="70" width="70">
                                                        </div>
                                                    </div>
                                                  

                                                <div class="col-md-12 mt-2">
                                                    <span style="color:red;">*</span>Description</label>
                                                    <textarea class="form-control" id="description" name="description">{{ $Data->description }}</textarea>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div style="margin-top: 10px;text-align: right;">
                                                    <button 
                                                        type="submit" class="btn btn-success btn-user float-right">Submit</button>
                                                        <button type="button" class="btn btn-danger btn-user float-right" onclick="cancelForm()">Cancel</button>

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
    </div>

            @endsection

            @section('scripts')
                <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>

                <script>
                    $(window).on('load', function() {
                        $('#description').ckeditor();
                    });
                </script>

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

            <script type="text/javascript">
            
                bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
            </script>
<script>
        function cancelForm() {
            window.location.reload(); 
        }
    </script>
            @endsection
