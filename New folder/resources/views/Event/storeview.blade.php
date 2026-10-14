@extends('layouts.app')
@section('title', 'Events')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
            <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>

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
                            <h5 class="card-title mb-0">Add Events</h5>
                        </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('Event.create') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-3 mb-3">
                                                 <div class="col-lg-4 col-md-6">
                                                    <span style="color:red;">*</span>Events Name
                                                    <input class="form-control" id="basic-form-name" name="name" type="text"
                                                        placeholder="Enter Name" value="{{ old('name') }}" required>
                                                </div>
                                                <!-- new -->
                                                <div class="col-lg-4 col-md-6">
                                                <span style="color:red;">*</span>Photo
                                                    <input class="form-control" type="file" name="photo" id="photovalidate"
                                                        value="{{ old('photo') }}" required>
                                                </div>
                                                <!-- new -->
                                            
                                                <div class="col-lg-4 col-md-6">
                                                    <span style="color:red;">*</span>Events start Date
                                                    <input type="date" class="form-control" name="eventstart_date"
                                                    id="" placeholder="Enter Event Start Date" value="{{ old('eventstart_date') }}" required>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <span style="color:red;">*</span>Events End Date
                                                    <input type="date" class="form-control" name="eventend_date"
                                                    id="" placeholder="Enter Event End Date" value="{{ old('eventend_date') }}" required>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <span style="color:red;">*</span> IS Paid
                                                    <select class="form-control" name="ispaid" id="ispaid" value="{{ old('ispaid') }}"  required>
                                                        <option value="No">No</option>
                                                        <option value="Yes">Yes</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-md-6" id="priceField" style="display:none;">
                                                    <span style="color:red;">*</span> Price
                                                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price" value="{{ old('price') }}">
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <span style="color:red;">*</span> Limited set
                                                    <select class="form-control" name="limitedset" id="limitedset" value="{{ old('limitedset') }}" required>
                                                        <option value="No">No</option>
                                                        <option value="Yes">Yes</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-md-6" id="setnumber" style="display:none;">
                                                    <span style="color:red;">*</span>Set Number: 
                                                    <input type="number" class="form-control" name="setnumber" id="setnumber" placeholder="Enter setnumber" value="{{ old('setnumber') }}">
                                                </div>
                                                <div>                                                   
                                                    <span style="color:red;">*</span>Description                                                
                                                    <textarea class="form-control" name="description" id="description" placeholder="Enter Description" rows="4" maxlength="500" autocomplete="off"></textarea>
                                                </div>
                                            <div class="text-center">
                                            <button type="submit" class="btn btn-success btn-user"
                                                    style="width:
                                                    81px; height: 36px;">Submit</button>
                                                <button type="button" class="btn btn-danger btn-user" style="width:
                                                    81px; height: 34px;" onclick="cancelForm()">Cancel</button>
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
    <script>
        function getEditData(id) {
            //alert(id);
            var url = "{{ route('gallery.edit', ':id') }}";
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
                        //console.log(data);
                        var obj = JSON.parse(data);
                        $("#Editname").val(obj.name);
                        $('#event_id').val(id);
                    }
                });
            }
        }
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
    $(document).ready(function(){
        $("#priceField").hide();
        $("#ispaid").change(function(){
            if($(this).val() === "Yes"){
                $("#priceField").show();
            } else {
                $("#priceField").hide();
            }
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("#setnumber").hide();
        $("#limitedset").change(function(){
            if($(this).val() === "Yes"){
                $("#setnumber").show();
            } else {
                $("#setnumber").hide();
            }
        });
    });
</script>
<script>
        $(window).on('load', function() {
            $('#description').ckeditor();
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

