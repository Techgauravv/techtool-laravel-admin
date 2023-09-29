@extends('layouts.app')

@section('title', 'Add Users')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $heading }}</h1>
            <a href="{{ route('users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>
        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $sub_heading }}</h6>
            </div>
            <form method="POST"
                @if ($formType == 'edit') action="{{ action([\App\Http\Controllers\UserController::class, 'update'], $user->id) }}" @else action="{{ action([\App\Http\Controllers\UserController::class, 'store']) }}" @endif
                enctype="multipart/form-data">
                @csrf
                @if ($formType == 'edit')
                    <input name="_method" type="hidden" value="PATCH">
                @endif
                <div class="card-body">
                    <div class="form-group row">
                        {{-- Name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Name</label>
                            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                                id="exampleName" placeholder="Name" name="name"
                                value="{{ $errors->any() ? old('name') : $user->name ?? '' }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Email</label>
                            <input type="email"
                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                id="exampleEmail" placeholder="Email" name="email"
                                value="{{ $errors->any() ? old('email') : $user->email ?? '' }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        @if ($formType != 'edit')
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Password</label>
                                <input type="password"
                                    class="form-control form-control-user @error('password') is-invalid @enderror"
                                    id="examplePassword" placeholder="Password" name="password"
                                    value="{{ $errors->any() ? old('password') : $user->password ?? '' }}">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                        @endif
                        {{-- Image --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Image</label>
                            {{-- <div class="image_outer">
                                <input class="form-control" name="image" type="file"
                                    value="{{ $errors->any() ? old('image') : $user->image ?? '' }}">
                                @if ($formType == 'edit' && $user->image)
                                    <div class="image_outer">
                                        <img src="{{ asset(auth()->user()->image) }}" width="150px">
                                        @if ($user->image != 'assets/admin/img/user_placeholder.jpg')
                                            <div data-id="{{ $user->id }}" data-name="image"
                                                class="btn btn-danger imagedelete">Delete Image</div>
                                        @endif
                                    </div>
                                @endif
                            </div> --}}

                            <div class="image_outer">
                                <input class="form-control" name="image" type="file" value="{{ old('image') }}">
                                @if ($formType == 'edit')
                                    @if ($user->image)
                                        <div class="image_outer">
                                            <img src="{{ asset($user->image) }}" width="150px">
                                            @if ($user->image != 'assets/admin/img/user_placeholder.jpg')
                                                <div data-id="{{ $user->id }}" data-name="image"
                                                    class="btn btn-danger imagedelete">Delete Image</div>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            </div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Mobile Number --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Mobile Number</label>
                            <input type="text"
                                class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                                id="exampleMobile" placeholder="Mobile Number" name="mobile_number"
                                value="{{ $errors->any() ? old('mobile_number') : $user->mobile_number ?? '' }}">
                            @error('mobile_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Role</label>
                            <select class="form-control form-control-user @error('role_id') is-invalid @enderror"
                                name="role_id">
                                {{-- selected disabled --}}
                                <option value='0'>Select Role</option>
                                @foreach ($roles as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ ($user->role_id ?? '') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>

                            @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <span style="color:red;">*</span>Status</label>
                            <select class="form-control form-control-user @error('status') is-invalid @enderror"
                                name="status">
                                <option selected disabled>Select Status</option>
                                @foreach ([1 => 'Active', 0 => 'Inactive'] as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ ($user->status ?? '') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('users.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
