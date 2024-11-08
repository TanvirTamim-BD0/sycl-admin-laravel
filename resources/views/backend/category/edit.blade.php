@extends('backend.master')
@section('title')
Edit Prime Category
@endsection
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Prime Category Edit</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Prime Category Edit
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
                            Prime Category Edit Here...
                        </h4>

                        <a href="{{ route('category.index') }}"
                            class="btn btn-primary font-weight-bolder float-right mb-0">
                        <i class="la la-list"></i>Prime Category List</a>
                    </div>

                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('category.update',$category->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">

                                        <div class="form-group">
                                            <label for="category_name" class="control-label">{{ __('Category Name') }} <span class=" text-danger">(required)</span></label>
                                            <input id="category_name" type="text" class="form-control" name="category_name"
                                            placeholder="Enter Category Name" value="{{$category->category_name}}" required>
                                            @error('category_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">

                                        <div class="media">
                                            <a href="javascript:void(0);" class="mr-25">

                                                @if(isset($category->category_image) && $category->category_image != null)
                                                <img src="{{ asset('/uploads/category_image/'.$category->category_image) }}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" style="object-fit: contain;" />
                                                @else
                                                <img src="{{ asset('backend/default.png') }}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" />
                                                @endif

                                            </a>
                                            <!-- upload and reset button -->
                                            <div class="media-body mt-75 ml-1">
                                                <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Choose File</label>
                                                <input type="file" id="account-upload" name="category_image" hidden accept="image/*" />
                                                <p>Allowed JPG, JPEG or PNG.</p>
                                            </div>

                                            @error('category_image')
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