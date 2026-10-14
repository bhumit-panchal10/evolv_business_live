@extends('layouts.app')
@section('title', 'Products Service ')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <?php  $user = Auth::user(); ?>
            <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
                {{-- Alert Messages --}}
                @include('common.alert')
                <div class="row">

                    <div class="col-md-12">
                        <div class="card mt-3 mb-3">
                            <div class="card-header">
                                <div class="row flex-between-end">
                                    <div class="col-auto align-self-center">
                                        <h5 class="card-title mb-0">Add Blog</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body bg-light">
                                <div class="tab-content">
                                    <div class="tab-pane preview-tab-pane active" role="tabpanel"
                                        aria-labelledby="tab-dom-160a4566-7e94-45a2-bf04-b36ef49d954f"
                                        id="dom-160a4566-7e94-45a2-bf04-b36ef49d954f">
                                        <form action="{{ route('Blog.add') }}"  method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">   
                                                {{-- {{dd($user)}} --}}
                                               

                                                <div class="col-md-4 mt-2">
                                                    <span style="color:red;">*</span>Article title </label>
                                                    <input class="form-control" id="basic-form-name" name="blogTitle" type="text"
                                                        placeholder="e.g Why networking required for any business" value="{{ old('blogTitle') }}" required>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span style="color:red;">
                                                        *</span>Article image</label>
                                                    <input class="form-control" type="file" name="blogImage" id="photovalidate"
                                                        value="{{ old('blogImage') }}" required>
                                                    <div id="viewimg">

                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-2">
                                                    <span style="color:red;">*</span>Article content (Upto 850 to 1000 words)</label>
                                                 
                                                    <textarea class="form-control" id="description" name="blogDescription" placeholder="Article content or long discription of the title" ></textarea>
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <span style="color:red;">*</span>Title for search (Upto 45 to 60 words) <br>e.g persolized busniess networking platform for all business owners</label>
                                                   
                                                    <textarea class="form-control" id="metaTitle" rows="5" name="metaTitle" placeholder="e.g persolized busniess networking platform for all business owners"></textarea>
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <span style="color:red;">*</span>Keyword to search this article (, separated) <br>e.g business networking in ahmedabad,business community, best connection build networking platform in ahmedabad</label>
                                                    <textarea class="form-control" id="metaKeyword" rows="5" name="metaKeyword" placeholder=""></textarea>
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <span style="color:red;">*</span>Description about article (Upto 150 to 160 words) <br>e.g Gorath is the best business networking platform in ahmedabad</label>
                                                    <textarea class="form-control" id="metaDescription" rows="5" name="metaDescription" placeholder=""></textarea>
                                                </div>

                                               
                                            </div>
                                            <div class="row">
                                                <div style="margin-top: 10px;text-align: right;">
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
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    

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
