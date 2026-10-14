@extends('layouts.app')
@section('title', 'Announcement List')
@section('content')
    <style>
        .box {
            border: 2px solid #78c046;
            border-radius: 10px;
            text-align: center;
            padding: 20px;
            margin-bottom: 25px;
            transition: 0.3s;
            background: #fff;
            height: 100%;
        }

        .box:hover {
            transform: translateY(-5px);
        }

        .box .image {
            height: 220px;
            width: 100%;
            background: #78c046;
            padding: 5px;
            border-radius: 10px;
            overflow: hidden;
        }

        .box .image img {
            object-position: top;
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 10px;
        }

        .box .name_job {
            margin-top: 15px;
            color: #78c046;
            font-size: 18px;
            font-weight: 600;
            text-align: center;
        }
    </style>
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

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0" data-anchor="data-anchor">Announcement List
                                    </h5>
                                </div>

                            </div>
                            <!-- <h5 class="card-title mb-0">Products Service List</h5> -->
                        </div>

                        <div class="card-body">

                            @if ($count > 0)

                                <div class="row">

                                    @foreach ($datas as $data)
                                        <div class="col-lg-4 col-md-6 col-12">

                                            <div class="box">

                                                <div class="image">
                                                    @if (empty($data->photos))
                                                        <img src="{{ asset('assets/images/noimage.png') }}" alt="No Image">
                                                    @else
                                                        <img src="{{ asset('MemberAnnouncement/' . $data->photos) }}"
                                                            alt="Announcement">
                                                    @endif
                                                </div>

                                                <div class="name_job">
                                                    {{ $data->title }}
                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $datas->links() }}
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="alert alert-info text-center">
                                            No Data Found !
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
@endsection

@section('scripts')

    <script>
        function deleteData(id) {
            // alert(id);
            $("#deleteid").val(id);
        }
    </script>

@endsection
