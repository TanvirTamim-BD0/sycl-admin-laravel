@extends('backend.master')
@section('title')
Edit Square Banner
@endsection
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Square Banner Edit</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Square Banner Edit
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
                            Square Banner Edit Here...
                        </h4>

                        <a href="{{ route('square-banner.index') }}"
                            class="btn btn-primary font-weight-bolder float-right mb-0">
                        <i class="la la-list"></i>Square Banner List</a>

                    </div>
                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('square-banner.update',$squareBanner->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="card-body">
                                <div class="row">


                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="media">
                                            <a href="javascript:void(0);" class="mr-25">
                                                @if(isset($squareBanner->square_banner_image) && $squareBanner->square_banner_image != null)
                                                <img src="{{ asset('/uploads/square_banner_image/'.$squareBanner->square_banner_image) }}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="90" width="160" style="object-fit: contain;" />
                                                @else
                                                <img src="{{ asset('backend/default.png') }}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="90" width="160" />
                                                @endif
                                            </a>

                                            <!-- upload and reset button -->
                                            <div class="media-body mt-75 ml-1">
                                                <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Choose File</label>
                                                <input type="file" id="account-upload" name="square_banner_image" hidden accept="image/*"  />
                                                <p>Allowed JPG, JPEG or PNG.</p>
                                            </div>
                                        </div>

                                        @error('square_banner_image')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 mt-1">
                                        <div class="form-group">
                                            <label for="square_banner_title" class="control-label">{{ __('Square Banner Title') }} <span class=" text-danger">(required)</span></label>
                                            <input id="square_banner_title" type="text" class="form-control" name="square_banner_title"
                                            placeholder="Enter Square Banner Title" value="{{$squareBanner->square_banner_title}}">
                                            @error('square_banner_title')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 mt-1">
                                        <div class="form-group">
                                            <label for="banner_category_id" class="control-label">{{ __('Banner Category') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select class="form-control select2" name="banner_category_id">
                                                <option selected disabled>Select Banner Category</option>
                                                @foreach($bannerCategories as $bannerCategory)
                                                @if(isset($bannerCategory) && $bannerCategory != null)
                                                <option value="{{$bannerCategory->id}}" {{ $bannerCategory->id == $squareBanner->banner_category_id ? 'selected' : '' }} >{{$bannerCategory->banner_category_name}}</option>
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


                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-1">
                                        <div class="form-group">
                                            <label for="square_banner_description" class="control-label">{{ __('Square Banner Description') }} <span class=" text-danger">(required)</span></label>
                                    
                                            <textarea class="form-control" name="square_banner_description" id="square_banner_description" cols="30" value="{{ old('square_banner_description') }}" >{{$squareBanner->square_banner_description}} </textarea>
                                            @error('square_banner_description')
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