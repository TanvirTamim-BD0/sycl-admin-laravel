@extends('backend.master')
@section('title')
Edit Keyword
@endsection
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Keyword Edit</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Keyword Edit
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
                            Keyword Edit Here...
                        </h4>

                        <a href="{{ route('keyword.index') }}"
                            class="btn btn-primary font-weight-bolder float-right mb-0">
                        <i class="la la-list"></i>Keyword List</a>
                    </div>

                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('keyword.update',$keyword->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-8 col-md-8 col-sm-8 col-12">

                                        <div class="form-group">
                                            <label for="keyword_name" class="control-label">{{ __('Keyword Name') }} <span class=" text-danger">(required)</span></label>
                                            <input id="keyword_name" type="text" class="form-control" name="keyword_name"
                                            placeholder="Enter Keyword Name" value="{{$keyword->keyword_name}}" required>
                                            @error('keyword_name')
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