@extends('layouts.app')

@section('title', 'Add CSV')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                @if (!empty($invalidData))
                    <h2>Import Errors</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Row</th>
                                <th>Errors</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invalidData as $invalidRow)
                                <tr>
                                    <td>{{ $invalidRow['row_index'] }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($invalidRow['errors'] as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No import errors.</p>
                @endif

                {{--  @if ($errors->any())
                    <h5 style="color:red">Following errors exists in your excel file</h5>
                    <ol>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ol>
                @endif  --}}


                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Upload CSV</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="live-preview">
                                    <form action="{{ route('csvupload.store') }}" method="post"
                                        onsubmit="return validateFile()" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4" style="align-items: end;">
                                            <div class="col-lg-3 col-md-3">
                                                <div>
                                                    <span style="color:red;">*</span>Upload CSV File
                                                    <input type="file" class="form-control" name="csvfile" id="csvfile"
                                                        autocomplete="off" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-3">
                                                <button type="submit" class="btn btn-success btn-user float-right">Save
                                                </button>
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



@endsection

@section('scripts')

    <script>
        function validateFile() {
            var allowedExtension = ['xlsx', 'xls', 'csv'];
            var fileExtension = document.getElementById('csvfile').value.split('.').pop().toLowerCase();
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
@endsection
