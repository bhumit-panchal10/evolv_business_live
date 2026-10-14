@extends('layouts.app')
@section('title', 'Products Service ')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

            <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

{{-- {{dd($Data)}} --}}
                @include('common.alert')
                <div class="row">

                    <div class="col-md-12">
                        <div class="card mt-3 mb-3">
                            <div class="card-header">
                                <div class="row flex-between-end">
                                    <div class="col-auto align-self-center">
                                        <h5 class="card-title mb-0">Edit Blog</h5>
                                    </div>
                                </div>
                            </div>
                            {{-- {{dd($Data)}} --}}
                            <div class="card-body bg-light">
                                <div class="tab-content">
                                    <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                        aria-labelledby="tab-dom-160a4566-7e94-45a2-bf04-b36ef49d954f"
                                        id="dom-160a4566-7e94-45a2-bf04-b36ef49d954f">
                                        <form onsubmit="return EditvalidateFile()" method="post" action="{{route('Usermember.update')}}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('post')
                                            <input type="hidden" name="blogId" id="getid" value="{{$Data->blogsid}}">
                                            <div class="row">
                                                {{-- <div class="col-md-4 mt-2">
                                                    <label for="user_id"><span style="color:red;">*</span> User Name</label>
                                                    <select class="form-control" name="user_id" id="user_id" required>
                                                        <option value="" disabled>Select User Name</option>
                                                        @foreach($alluser as $allusers)
                                                            <option value="{{ $allusers->id }}" {{ $allusers->id == $Data->user_id ? 'selected' : '' }}>
                                                                {{ $allusers->first_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                <div class="col-md-4 mt-2">
                                                    <span style="color:red;">*</span>Article title</label>
                                                    <input class="form-control" id="basic-form-name" name="blogTitle"
                                                        type="text" placeholder="Enter Title"
                                                        value="{{ $Data->blogTitle ?? '' }}" required>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                        <span style="color:red;">
                                                            *</span>Article image</label>
                                                        <input class="form-control" type="file" name="blogImage" id="photovalidate"
                                                            value="{{ $Data->blogImage ?? '' }}">
                                                        <input type="hidden" name="hiddenPhoto" class="form-control"
                                                            value="{{ old('photo') ? old('photo') : $Data->blogImage }}" id="hiddenPhoto">
                                                        <div id="viewimg">
                                                            <img src="{{ asset('Blog') . '/' . $Data->blogImage }}" alt=""
                                                                height="70" width="70">
                                                        </div>
                                                    </div>
                                                  

                                                <div class="col-md-12 mt-2">
                                                    <span style="color:red;">*</span>Article content (Upto 850 to 1000 words)</label>
                                                    <textarea class="form-control" id="description" name="blogDescription" required>{{ $Data->blogDescription }}</textarea>
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <span style="color:red;">*</span>Title for search (Upto 45 to 60 words)</label>
                                                    <textarea class="form-control" id="metaTitle" rows="5" name="metaTitle">{{ $Data->metaTitle }}</textarea>
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <span style="color:red;">*</span>Keyword to search this article (, separated)</label>
                                                    <textarea class="form-control" id="metaKeyword" rows="5" name="metaKeyword">{{ $Data->metaKeyword }}</textarea>
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <span style="color:red;">*</span>Description about article (Upto 150 to 160 words)</label>
                                                    <textarea class="form-control" id="metaDescription" rows="5" name="metaDescription">{{ $Data->metaDescription }}</textarea>
                                                </div>

                                               
                                            </div>
                                            <div class="row">
                                                <div style="margin-top: 10px;text-align: right;">
                                                <button type="submit" class="btn btn-success btn-user float-right">Submit
                                                </button>
                                                <button type="button" class="btn btn-danger btn-user" style="width:
                                                    81px; height: 37px;" onclick="cancelForm()">Cancel</button>
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
