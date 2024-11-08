@extends('backend.master')
@section('title')
Edit Country
@endsection
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Country Edit</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Country Edit
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
                            Country Edit Here...
                        </h4>

                        <a href="{{ route('country.index') }}"
                            class="btn btn-primary font-weight-bolder float-right mb-0">
                        <i class="la la-list"></i>Country List</a>
                    </div>

                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('country.update',$country->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-8 col-md-8 col-sm-8 col-12">

                                        <div class="form-group">
                                            <label for="country_name" class="control-label">{{ __('Country Name') }} <span class=" text-danger">(required)</span></label>
                                            <input id="country_name" type="text" class="form-control" name="country_name"
                                            placeholder="Enter Country Name" value="{{$country->country_name}}" required>
                                            @error('country_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">Update</button>
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