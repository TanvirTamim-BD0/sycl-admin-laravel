@extends('backend.master')
@section('title')
Edit City
@endsection
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">City Edit</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">City Edit
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
                            City Edit Here...
                        </h4>

                        <a href="{{ route('city.index') }}"
                            class="btn btn-primary font-weight-bolder float-right mb-0">
                        <i class="la la-list"></i>City List</a>
                    </div>

                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('city.update',$city->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="city_name" class="control-label">{{ __('City Name') }} <span class=" text-danger">(required)</span></label>
                                            <input id="city_name" type="text" class="form-control" name="city_name"
                                            placeholder="Enter City Name" value="{{ $city->city_name }}">

                                            @error('city_name')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="country_id" class="control-label">{{ __('Country') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select class="form-control select2" name="country_id">
                                                <option selected disabled>Select Country</option>
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{ $country->id == $city->country_id ? 'selected' : '' }} >{{$country->country_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('country_id')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
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