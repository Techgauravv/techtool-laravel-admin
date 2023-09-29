@extends('layouts.app')

@section('title', 'Add Projects')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Projects</h1>
            <a href="{{ route('projects.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
            </div>
            <form method="POST" action="#" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        {{-- Project Name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Project Name</label>
                            <input type="text"
                                class="form-control form-control-user @error('project_name') is-invalid @enderror"
                                id="exampleFirstName" placeholder="Project Name" name="project_name"
                                value="{{ old('project_name') }}">

                            @error('project_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Client Name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Clients</label>
                            <select class="form-control form-control-user @error('client_id') is-invalid @enderror"
                                name="client_id">
                                <option selected disabled>Select Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Details --}}
                        <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Details</label>
                            <input type="text"
                                class="form-control form-control-user @error('details') is-invalid @enderror"
                                id="exampleLastName" placeholder="Details" name="details" value="{{ old('details') }}">

                            @error('details')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Start Date --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Start Date</label>
                            {{-- <input type="email"
                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                id="exampleEmail" placeholder="Email" name="email" value="{{ old('email') }}"> --}}
                            <input type="text" id="start_datetime" placeholder="Start Anytime" name="start_datetime"
                                autocomplete="off"
                                value="{{ $errors->any() ? old('start_datetime') : $project->start_datetime ?? '' }}">
                            @error('start_datetime')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- End Date --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>End Date</label>
                            <input type="text" id="end_datetime" placeholder="End Anytime" name="end_datetime"
                                autocomplete="off"
                                value="{{ $errors->any() ? old('end_datetime') : $project->end_datetime ?? '' }}">

                            @error('end_datetime')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Project Status --}}
                        <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Status</label>
                            <select class="form-control form-control-user @error('status') is-invalid @enderror"
                                name="status">
                                <option selected disabled>Select Status</option>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('projects.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-datetimepicker@4.17.47/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('summary-ckeditor');
    </script>
    <script type="text/javascript">
        $("#start_datetime").datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss"
        });
        $("#end_datetime").datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss"
        });
    </script>
@endsection
