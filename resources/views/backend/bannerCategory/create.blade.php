@extends('backend.master')
@section('title')
Create Banner Category
@endsection
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Banner Category Create</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Banner Category Create
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
                            Banner Category Create Here...
                        </h4>

                        <a href="{{ route('banner-category.index') }}"
                            class="btn btn-primary font-weight-bolder float-right mb-0">
                        <i class="la la-list"></i>Banner Category List</a>

                    </div>
                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('banner-category.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-8 col-md-8 col-sm-8 col-12">

                                        <div class="form-group">
                                            <label for="banner_category_name" class="control-label">{{ __('Banner Category Name') }} <span class=" text-danger">(required)</span></label>
                                            <input id="banner_category_name" type="text" class="form-control" name="banner_category_name"
                                            placeholder="Enter Banner Category Name" value="{{ old('banner_category_name') }}">
                                            @error('banner_category_name')
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