@extends('backend.master')
@section('title')
Create User
@endsection
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">User Create</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">User Create
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <!-- Tooltip validations start -->
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    <div class="card-header">
                        <h4 class="card-title">
                            User Create Here...
                        </h4>

                        <a href="{{ route('users.index') }}"
                            class="btn btn-primary font-weight-bolder float-right mb-0">
                        <i class="la la-list"></i>User List</a>

                    </div>
                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('users.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="name" class="control-label">{{ __('Name') }} <span class=" text-danger">(required)</span></label>
                                            <input id="name" type="text" class="form-control" name="name"
                                            placeholder="Enter Name" value="{{ old('name') }}">
                                            @error('name')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="email" class="control-label">{{ __('Email') }} <span class=" text-danger">(required)</span></label>
                                            <input id="email" type="email" class="form-control" name="email"
                                            placeholder="Enter Email" value="{{ old('email') }}">
                                            @error('email')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="mobile" class="control-label">{{ __('Phone Number') }} <span class=" text-danger">(required)</span></label>
                                            <input id="mobile" type="number" class="form-control" name="mobile"
                                            placeholder="Enter Phone Number" value="{{ old('mobile') }}">
                                            @error('mobile')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password" class="control-label">{{ __('Password') }} <span class=" text-danger">(required)</span></label>
                                            <input id="password" type="password" class="form-control" name="password"
                                            placeholder="........" value="{{ old('password') }}">
                                            @error('password')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="control-label">{{ __('Confirm Password') }} <span class=" text-danger">(required)</span></label>
                                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"
                                            placeholder="........" value="{{ old('password_confirmation') }}">
                                            @error('password_confirmation')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Tooltip validations end -->
</div>
</div>
@endsection
@section('scripts')
{{-- Partial Script path... --}}

@endsection