@extends('backend.master')
@section('title')
Create Product
@endsection
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Product Create</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Product Create
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
                            Product Create Here...
                        </h4>

                        <a href="{{ route('product.index') }}"
                            class="btn btn-primary font-weight-bolder float-right mb-0">
                        <i class="la la-list"></i>Product List</a>

                    </div>
                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('product.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="product_name" class="control-label">{{ __('Product Name') }} <span class=" text-danger">(required)</span></label>
                                            <input id="product_name" type="text" class="form-control" name="product_name"
                                            placeholder="Enter Product Name" value="{{ old('product_name') }}">

                                            @error('product_name')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>    
                                    
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="banner_category_id" class="control-label">{{ __('Banner Category') }} </label>
                                            
                                            <select class="form-control select2" name="banner_category_id[]" multiple data-placeholder="Select Banner Category" >
                                                <option disabled>Select Banner Category</option>
                                                @foreach($bannerCategories as $bannerCategory)
                                                <option value="{{$bannerCategory->id}}">{{$bannerCategory->banner_category_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('banner_category_id')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="category_id" class="control-label">{{ __('Category') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select id="categoryId" class="form-control select2" name="category_id">
                                                <option selected disabled>Select Category</option>
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('category_id')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="middle_category_id" class="control-label">{{ __('Middle Category') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select class="form-control select2" name="middle_category_id" id="middle_category_id" data-placeholder="Select Sub Category" >
                                                <option disabled>Select Middle Category</option>
                                               
                                            </select>

                                            @error('middle_category_id')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="sub_category_id" class="control-label">{{ __('Sub Category') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select class="form-control select2" name="sub_category_id[]" id="sub_category_id" multiple data-placeholder="Select Sub Category" >
                                                <option disabled>Select Sub Category</option>
                                               
                                            </select>

                                            @error('sub_category_id')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="keyword" class="control-label">{{ __('Keyword') }}  <span class=" text-danger">(required)</span>  </label>
                                            
                                            <select class="form-control select2" name="keyword[]" multiple data-placeholder="Select Keyword" >
                                                <option disabled>Select Keyword</option>
                                                @foreach($productKeywords as $keyword)
                                                <option value="{{$keyword->id}}">{{$keyword->keyword_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('keyword')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="product_video" class="control-label">{{ __('Product Video') }}</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="product_video" id="customFile" />
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
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

<script src="{{asset('backend')}}/app-assets/vendors/js/vendors.min.js"></script>

<script> 
    $(document).ready(function(){
     $('select[name="category_id"]').on('change',function(){
        var categoryId = $(this).val();

        var url = "{{ route('get-middle-category-category-wise') }}";

        if (categoryId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    categoryId: categoryId
                },

                success: function (data) {
                    //For Section...
                    $("#middle_category_id").empty();
                    $("#middle_category_id").append('<option value="" selected disabled>Select Middle Category </option>');

                    $.each(data, function(key,value){
                        $("#middle_category_id").append('<option value="'+value.id+'">'+ value.middle_category_name +'</option>');
                    });

                }

            });
        }
 
    }); 
        
    });
 </script> 


<script> 
    $(document).ready(function(){
     $('select[name="middle_category_id"]').on('change',function(){
        var middleCategoryId = $(this).val();

        var url = "{{ route('get-sub-category-middle-category-wise') }}";

        if (middleCategoryId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    middleCategoryId: middleCategoryId
                },

                success: function (data) {
                    //For Section...
                    $("#sub_category_id").empty();
                    $("#sub_category_id").append('<option value="" disabled>Select Sub Category </option>');

                    $.each(data, function(key,value){
                        $("#sub_category_id").append('<option value="'+value.id+'">'+ value.sub_category_name +'</option>');
                    });

                }

            });
        }
 
    }); 
        
    });
 </script> 


@endsection


