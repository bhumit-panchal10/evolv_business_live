
@extends('layouts.app')
@section('title', 'Member Meeting List')
@section('content')

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
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Add Member Meeting</h5>
                            </div>
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('Membermeeting.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="row gy-4" style="align-items: end;">
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="city_id"><span style="color:red;">*</span> City
                                                        Name</label>
                                                        <select class="form-control" name="city_id" id="city_id" required onchange="updateCityGroups()">
                                                    <option value="" selected>Select City Name</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                            {{ $city->city_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                </div>
                                                <div class="mt-3">
                                                <label for="citygroup_id"><span style="color:red;">*</span> City Group Name</label>
                                                <select class="form-control" name="citygroup_id" id="citygroup_id" required>
                                                    <option value="">Select City Group Name</option>
                                                    @foreach ($cityGroups as $group)
                                                        <option value="{{ $group->id }}" {{ old('citygroup_id') == $group->id ? 'selected' : '' }}>
                                                            {{ $group->group_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('citygroup_id')
                                                    <span style="color: red;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mt-3">
                                               <span style="color:red;">*</span>Meeting Title
                                                <input type="text" class="form-control" 
                                                name="Meetingtitle" id="Meetingtitle" maxlength="100" autocomplete="off" placeholder="Cluster Meet"
                                                    required>
                                             </div>
                                             <div class="mt-3">
                                                 <span style="color: red;">*</span>Start Date & Time                                   
                                                <span style="color:red;" class="error-message">{{ $errors->first('start_date') }}</span> 
                                                <!-- <input type="datetime" class="form-control" name="start_date"
                                                    id="start_date" placeholder="Enter Start Date & Time"  value="{{old('start_date')}}" required> -->
                                            <input type="text" name="start_date" class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="d.m.y" data-enable-time=""placeholder="Enter Start Date & Time"  value="{{old('start_date')}}" required>
                                            </div>
                                            <div class="mt-3">
                                                 <span style="color: red;">*</span>End Date & Time                                   
                                                <span style="color:red;" class="error-message">{{ $errors->first('End_date') }}</span> 
                                                <!-- <input type="datetime" class="form-control" name="End_date"
                                                    id="End_date" placeholder="Enter End Date & Time"   value="{{old('End_date')}}" required> -->
                                                <input type="text" class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="d.m.y" data-enable-time="" name="End_date" placeholder="Enter End Date & Time"   value="{{old('End_date')}}" required>
                                            </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button type="submit" class="btn btn-success btn-user float-right">Submit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-user float-right" onclick="cancelForm()">Cancel</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Member Meeting List</h5>
                            </div>
                            <div class="card-body table-responsive table-card">
                                <?php //echo date('ymd');
                                ?>
                                @if($Count > 0 )
                                
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No</th>
                                            <th scope="col">Meeting Title</th>
                                            <th scope="col">City Name</th>
                                            <th scope="col">City Group name</th>                                          
                                            <th scope="col">Start Date & Time</th>
                                            <th scope="col">End Date & Time</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                      
                                        <?php $i = 1; ?>
                                        @foreach ($datas as $data)
                                         @php
                                                    $meetingStart = \Carbon\Carbon::createFromFormat(
                                                        'd.m.y H:i',
                                                        $data->start_date,
                                                    );
                                                    $isPastMeeting = $meetingStart->lt(\Carbon\Carbon::now());
                                                @endphp
                                            <tr>
                                                <td class="text-center"> {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                                <td class="text-center">{{$data->Meeting_title }}</td>
                                                <td class="text-center"> {{ optional($cities->firstWhere('id', $data->city_id))->city_name }}</td>
                                                <td class="text-center">
                                                    {{ optional($cityGroups->firstWhere('id', $data->city_group_id))->group_name }}
                                                </td>
                                              
                                                <td class="text-center">{{$data->start_date }}</td>
                                                <td class="text-center">{{$data->End_date}}</td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a class="mx-1" title="Edit" href="#"
                                                            onclick="getEditData(<?= $data->id ?>)" data-bs-toggle="modal"
                                                            data-bs-target="#showModal">
                                                            <i class="far fa-edit"></i>
                                                        </a>

                                                        <a class="" href="#" data-bs-toggle="modal"
                                                            title="Delete" data-bs-target="#deleteRecordModal"
                                                            onclick="deleteData(<?= $data->id ?>);">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                        <a class="" href="{{ route('Membermeeting.Memberindex',$data->id) }}" title="Add Member">
                                                            <i class="fas fa-plus-square" aria-hidden="true"></i>
                                                        </a>
                                                         @if ($isPastMeeting)
                                                                <a class=""
                                                                    href="{{ route('Membermeeting.Membercomment', $data->id) }}"
                                                                    title="Add Comment">
                                                                    <i class="fa fa-comment" aria-hidden="true"></i>
                                                                </a>
                                                            @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $datas->links() }}
                                </div>
                                @else 
                                <div class="row">
                                    <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                        <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                            <h1 class="font-white text-center"> No Data Found ! </h1>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
               
                <!--Edit Modal Start-->
                <div class="modal fade flip" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Member Meeting</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form method="POST" 
                                action="{{route('Membermeeting.update')}}" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="getid">

                                <div class="modal-body">
                                           <div>
                                                <label for="city_id"><span style="color:red;">*</span> City Name</label>
                                                <select class="form-control" name="city_id" id="Editcity" required
                                                    onchange="editupdateCityGroups()">
                                                    <option value="" selected>Select City Name</option>
                                                    @foreach ($cities as $city)
                                                        <option
                                                            value="{{ $city->id }}">
                                                            {{ $city->city_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 pt-3">
                                                <label for="citygroup_id"><span style="color:red;">*</span> City Group
                                                    Name</label>
                                                <select class="form-control" name="citygroup_id" id="Editcitygroup_id" required>
                                                    @foreach ($cityGroups as $cityGroup)
                                                        <option
                                                            value="{{ $cityGroup->id }}">
                                                            {{ $cityGroup->group_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        <div class="mb-3 pt-3">
                                               <span style="color:red;">*</span>Meeting Title
                                                <input type="text" class="form-control" 
                                                name="Meeting_title" id="EditMeetingtitle" maxlength="100" autocomplete="off" placeholder="Cluster Meet"
                                                    required>
                                             </div>
                                             <div class="mb-3 pt-3">
                                                 <span style="color: red;">*</span>Start Date & Time                                   
                                                <span style="color:red;" class="error-message">{{ $errors->first('start_date') }}</span> 
                                                <!-- <input type="text" class="form-control" name="start_date"
                                                    id="Editstart_date" placeholder="Enter Start Date & Time"  value="{{old('start_date')}}" required> -->
                                                    <input type="text" class="form-control flatpickr-input active"  name="start_date"  id="Editstart_date" placeholder="Enter Start Date & Time"  value="{{old('start_date')}}"  data-provider="flatpickr" data-date-format="d.m.y" data-enable-time="" required>
                                            </div>
                                            <div class="mb-3 pt-3">
                                                 <span style="color: red;">*</span>End Date & Time                                   
                                                <span style="color:red;" class="error-message">{{ $errors->first('End_date') }}</span> 
                                                <!-- <input type="text" class="form-control" name="End_date"
                                                    id="EditEnd_date" placeholder="Enter End Date & Time"   value="{{old('End_date')}}" required> -->
                                                    <input type="text" class="form-control flatpickr-input active"  name="End_date"   id="EditEnd_date" placeholder="Enter End Date & Time"   value="{{old('End_date')}}"  data-provider="flatpickr" data-date-format="d.m.y" data-enable-time="" required>    
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-success" id="add-btn">Update</button>
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--Edit Modal End -->

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
                                        <button type="button" class="btn w-sm btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <a class="btn btn-danger" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                                            Yes,
                                            Delete It!
                                        </a>
                                        <form id="user-delete-form" method="POST"
                                            action="{{ route('Membermeeting.delete') }}">
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

                </div>
            </div>
        </div>
@endsection

@section('scripts')


  <script>
             function getEditData(id) {
                //  alert(id);
                 var url = "{{ route('Membermeeting.edit', ':id') }}";
                 url = url.replace(":id", id);
                 if (id) {
                     $.ajax({
                         url: url,
                         type: 'GET',
                         data: {
                             id: id
                         },
                         success: function(data) {
                             // console.log(data);
                             var obj = JSON.parse(data);
                             // alert(obj);
                             $("#EditMeetingtitle").val(obj.Meeting_title);
                             $('#getid').val(obj.id);
                             $('#Editcity').val(obj.city_id);
                             $('#Editcitygroup_id').val(obj.city_group_id);
                             $('#Editstart_date').val(obj.start_date);
                             $('#EditEnd_date').val(obj.End_date);

                         }
                     });
                 }
             }
         </script>

        <script>
            function deleteData(id) {
                $("#deleteid").val(id);
            }
        </script>

        <script>
            function chkname() {
                var name = $('#group_name').val();
                var url = "{{ route('serviceprovider.citygroupcheckserviceprovider') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        name,
                        name
                    },
                    success: function(data) {
                        console.log(data);
                        var obj = JSON.parse(data);
                        if (data == 1) {

                            alert('CityGroup Name Already Exist');
                            $('#group_name').val('');
                            $('#group_name').focus();
                            return false;

                        }
                    }
                });
            }
        </script>
        <script>
            function editchkname() {
                var name = $('#Editname').val();
                var id = $('#getid').val();
                var url = "{{ route('serviceprovider.citygroupeditcheckserviceprovider') }}";

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        name: name,
                        id: id
                    },
                    success: function(data) {
                        console.log(data);
                        if (data == 1) {
                            alert('CityGroup Name Already Exists');
                            $('#Editname').val('');
                            $('#Editname').focus();
                            return false;
                        }
                    }
                });
            }
        </script>

{{-- city based display group --}}
    <script>
        function updateCityGroups() {
            var city_id = $("#city_id").val();
            var url = "{{ route('members.cityid', ':city_id') }}";
            url = url.replace(":city_id", city_id);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    city_id: city_id,
                },
                success: function(data) {
                    $("#citygroup_id").html('');
                    $("#citygroup_id").append(data);
                }
            });
        }
    </script>
 <script>
        function editupdateCityGroups() {
            var city_id = $("#Editcity").val();
            var url = "{{ route('members.cityid', ':city_id') }}";
            url = url.replace(":city_id", city_id);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    city_id: city_id,
                },
                success: function(data) {
                    $("#Editcitygroup_id").html('');
                    $("#Editcitygroup_id").append(data);
                }
            });
        }
    </script>

<script>
        function cancelForm() {
            window.location.reload(); 
        }
    </script>

@endsection