@extends('backend.master')
@section('title')
Create Bottom Banner
@endsection
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Bottom Banner Create</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Bottom Banner Create
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
                            Bottom Banner Create Here...
                        </h4>

                        <a href="{{ route('bottom-banner.index') }}"
                            class="btn btn-primary font-weight-bolder float-right mb-0">
                        <i class="la la-list"></i>Bottom Banner List</a>

                    </div>
                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('bottom-banner.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-5 col-md-5 col-sm-5 col-12">
                                        <div class="media">
                                            <a href="javascript:void(0);" class="mr-25">
                                                <img src="{{ asset('backend/default.png') }}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="90" width="160" style="object-fit: contain;" />
                                            </a>
                                            <!-- upload and reset button -->
                                            <div class="media-body mt-75 ml-1">
                                                <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Choose File</label>
                                                <input type="file" id="account-upload" name="bottom_banner_image" hidden accept="image/*"  />
                                                <p>Allowed JPG, JPEG or PNG.</p>
                                            </div>
                                        </div>

                                        @error('bottom_banner_image')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="col-lg-7 col-md-7 col-sm-7 col-12">
                                        <div class="form-group">
                                            <label for="banner_category_id" class="control-label">{{ __('Banner Category') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select class="form-control select2" name="banner_category_id">
                                                <option selected disabled>Select Banner Category</option>
                                                @foreach($bannerCategories as $bannerCategory)
                                                @if(isset($bannerCategory) && $bannerCategory != null)
                                                <option value="{{$bannerCategory->id}}">{{$bannerCategory->banner_category_name}}</option>
                                                @endif
                                                @endforeach
                                            </select>

                                            @error('banner_category_id')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12 mt-2">
                                        <div class="form-group">
                                            <label for="bottom_banner_text_1" class="control-label">{{ __('Bottom Banner Text 1') }} <span class=" text-danger">(required)</span></label>
                                            <input id="bottom_banner_text_1" type="text" class="form-control" name="bottom_banner_text_1"
                                            placeholder="Enter Bottom Banner Text 1" value="{{ old('bottom_banner_text_1') }}">
                                            @error('bottom_banner_text_1')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12 mt-2">
                                        <div class="form-group">
                                            <label for="bottom_banner_text_2" class="control-label">{{ __('Bottom Banner Text 2') }}</label>
                                            <input id="bottom_banner_text_2" type="text" class="form-control" name="bottom_banner_text_2"
                                            placeholder="Enter Bottom Banner Text 2" value="{{ old('bottom_banner_text_2') }}">
                                            @error('bottom_banner_text_2')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12 mt-2">
                                        <div class="form-group">
                                            <label for="bottom_banner_text_3" class="control-label">{{ __('Bottom Banner Text 3') }}</label>
                                            <input id="bottom_banner_text_3" type="text" class="form-control" name="bottom_banner_text_3"
                                            placeholder="Enter Bottom Banner Text 3" value="{{ old('bottom_banner_text_3') }}">
                                            @error('bottom_banner_text_3')
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