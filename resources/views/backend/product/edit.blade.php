@extends('backend.master')
@section('title')
Edit Product
@endsection
@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Product Edit</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Product Edit
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
                            Product Edit Here...
                        </h4>

                        <a href="{{ route('product.index') }}"
                            class="btn btn-primary font-weight-bolder float-right mb-0">
                        <i class="la la-list"></i>Product List</a>

                    </div>
                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('product.update',$product->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="product_name" class="control-label">{{ __('Product Name') }} <span class=" text-danger">(required)</span></label>
                                            <input id="product_name" type="text" class="form-control" name="product_name"
                                            placeholder="Enter Product Name" value="{{ $product->product_name }}">

                                            @error('product_name')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    @php
                                    $arraySubCategoryIds = json_decode($product->sub_category_id);
                                    @endphp

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="sub_category_id" class="control-label">{{ __('Sub Category') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select class="form-control select2" name="sub_category_id[]" id="sub_category_id" multiple>
                                                <option disabled>Select Sub Category</option>

                                                @foreach($subCategories as $subCategory)
                                                <option value="{{$subCategory->id}}" {{ in_array($subCategory->id, $arraySubCategoryIds) ? 'selected' : ''}} >{{$subCategory->sub_category_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('sub_category_id')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>


                                    @php
                                    $arrayBannerCategoryIds = json_decode($product->banner_category_id);
                                    @endphp
                                    
                                    @if(isset($arrayBannerCategoryIds) && $arrayBannerCategoryIds != null)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="banner_category_id" class="control-label">{{ __('Banner Category') }} </label>
                                            
                                            <select class="form-control select2" name="banner_category_id[]" multiple>
                                                <option disabled>Select Banner Category</option>
                                                
                                                @foreach($bannerCategories as $bannerCategory)
                                                @if(isset($arrayBannerCategoryIds) && $arrayBannerCategoryIds != null)
                                                <option value="{{$bannerCategory->id}}" {{ in_array($bannerCategory->id, $arrayBannerCategoryIds) ? 'selected' : ''}}  >{{$bannerCategory->banner_category_name}}</option>
                                                @else
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
                                    @else 
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="banner_category_id" class="control-label">{{ __('Banner Category') }} </label>
                                            
                                            <select class="form-control select2" name="banner_category_id[]" multiple>
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
                                    @endif


                                    @php
                                    $arrayKeyword = json_decode($product->product_keyword);
                                    @endphp

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="keyword" class="control-label">{{ __('Keyword') }}  <span class=" text-danger">(required)</span>  </label>
                                            
                                            <select class="form-control select2" name="keyword[]" multiple data-placeholder="Select Keyword" >
                                                <option disabled>Select Keyword</option>
                                                @foreach($productKeywords as $keyword)
                                                <option value="{{$keyword->id}}" {{ in_array($keyword->id, $arrayKeyword) ? 'selected' : ''}} >{{$keyword->keyword_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('keyword')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>


                                    <div class="col-lg-8 col-md-8">
                                        <div class="form-group">
                                            <label for="product_video" class="control-label">{{ __('Product Video') }}</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="product_video" id="customFile" />
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 col-md-12">
                                        @if(isset($product->product_video) && $product->product_video != null)
                                            <video width="400" height="150" autoplay muted>
                                                <source src="{{ asset('/uploads/product_video/'.$product->product_video) }}" type="video/mp4">
                                            </video>
                                        @else
                                        @endif
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


                {{-- Product Tile Add --}}
                <div class="card">
                    
                    <div class="card-header">
                        <h4 class="card-title">
                            Product Tile Add ....
                        </h4>
                    </div>

                    <div class="card-body">

                        <form  action="{{ route('product-tile-add') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <input type="hidden" value="{{$product->id}}" name="product_id">

                                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="title" class="control-label">{{ __('Title') }}</label>
                                        <input id="title" type="text" class="form-control" name="title"
                                        placeholder="Enter Title" value="{{ old('title') }}" style="padding: 45px;" required>
        
                                        @error('title')
                                        <span>
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                    <div class="form-group">
                                        <label for="description" class="control-label">{{ __('Description') }}</label>
                                        <textarea name="description" class="form-control" id="description" rows="3" value="{{ old('description') }}" placeholder="Enter Description" required></textarea>
                                        @error('description')
                                        <span>
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>

                        </form>

                        
                    </div>

                    

                </div>

    
                {{-- Product Tile Update --}}
                <div class="card">
                    
                    <div class="card-header">
                        <h4 class="card-title">
                            Product Tile Edit ....
                        </h4>
                    </div>

                    <div class="card-body">

                        @foreach($productTiles as $productTile)
                        @if(isset($productTile) && $productTile != null)

                        <form action="{{ route('product-tile-update',$productTile->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="title" class="control-label">{{ __('Title') }}</label>
                                        <input id="title" type="text" class="form-control" name="title"
                                        placeholder="Enter Title" value="{{ $productTile->title }}" style="padding: 45px;" required >
        
                                        @error('title')
                                        <span>
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="description" class="control-label">{{ __('Description') }}</label>
                                        
                                        <textarea name="description" class="form-control" id="description" rows="3" value="{{ old('description') }}" placeholder="Enter Description" required>{{ $productTile->description }}</textarea>

                                        @error('description')
                                        <span>
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-2 col-12 mt-1">
                                    <button type="submit" class="btn btn-sm" style="padding: 45px; background-color:#f2efef">Save</button>
                                </div>

                            </div>
                        </form>

                        @endif
                        @endforeach
                    </div>
                </div>

                {{-- Product Color Varient Add --}}
                <div class="card">
                    
                    <div class="card-header">
                        <h4 class="card-title">
                          Add New Color Varient...
                        </h4>

                    </div>
                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('color-management-submit') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <input type="hidden" value="{{$product->id}}" name="product_id">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="color_code" class="control-label">{{ __('Color Code') }} <span class=" text-danger">(required)</span></label>
                                            <input id="color_code" type="color" class="form-control" name="color_code"
                                            value="{{ old('color_code') }}" required>

                                            @error('color_code')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="color_name" class="control-label">{{ __('Color Name') }} <span class=" text-danger">(required)</span></label>
                                            <input id="color_name" type="text" class="form-control" name="color_name"
                                            placeholder="Enter Color Name" value="{{ old('color_name') }}" required >

                                            @error('color_name')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="size_id" class="control-label">{{ __('Size') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select id="size_id" class="form-control select2" name="size_id[]" multiple data-placeholder="Select Size" >
                                                <option disabled>Select Size</option>
                                                @foreach($sizes as $size)
                                                <option value="{{$size->size_name}}">{{$size->size_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('size_id')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="product_price" class="control-label">{{ __('Product Price') }} <span class=" text-danger">(required)</span></label>
                                            <input id="product_price" type="text" class="form-control" name="product_price"
                                            placeholder="Enter Product Price" value="{{ old('product_price') }}" required >

                                            @error('product_price')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="product_images" class="control-label">{{ __('Product Images') }} <span class=" text-danger">(required)</span> </label>
                                            <div class="custom-file">
                                                <input type="file" class="form-control"  name="product_images[]"  multiple required />
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">Add</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>

                {{-- Product Color Varient Update --}}
                <div class="card">
                    
                    <div class="card-header">
                        <h4 class="card-title">
                          Color Varient Edit ...
                        </h4>

                    </div>
                    <div class="card-body">

                        @foreach($productColors as $productColor)
                        @if(isset($productColor) && $productColor != null)

                        <form id="jquery-val-form" action="{{ route('color-management-update',$productColor->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <input type="hidden" value="{{$product->id}}" name="product_id">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="color_code" class="control-label">{{ __('Color Code') }} <span class=" text-danger">(required)</span></label>
                                            <input id="color_code" type="color" class="form-control" name="color_code"
                                            value="{{ $productColor->color_code }}" required >

                                            @error('color_code')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="color_name" class="control-label">{{ __('Color Name') }} <span class=" text-danger">(required)</span></label>
                                            <input id="color_name" type="text" class="form-control" name="color_name"
                                            placeholder="Enter Color Name" value="{{ $productColor->color_name }}" required >

                                            @error('color_name')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    @php
                                    $arraySizeIds = json_decode($productColor->product_size);
                                    @endphp

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="size_id" class="control-label">{{ __('Size') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select id="sizes_id{{$productColor->id}}" class="form-control select2" name="size_id[]" multiple data-placeholder="Select Size"  >
                                                <option disabled>Select Size</option>
                                                @if(isset($arraySizeIds) && $arraySizeIds != null)
                                                @foreach($sizes as $size)
                                                <option value="{{$size->size_name}}" {{ in_array($size->size_name, $arraySizeIds) ? 'selected' : ''}} >{{$size->size_name}}</option>
                                                @endforeach
                                                @else
                                                 @foreach($sizes as $size)
                                                <option value="{{$size->size_name}}">{{$size->size_name}}</option>
                                                @endforeach
                                                @endif
                                                
                                            </select>

                                            @error('size_id')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="product_price" class="control-label">{{ __('Product Price') }} <span class=" text-danger">(required)</span></label>
                                            <input id="product_price" type="text" class="form-control" name="product_price"
                                            placeholder="Enter Product Price" value="{{ $productColor->product_price }}" required >

                                            @error('product_price')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="product_images" class="control-label">{{ __('Product Images') }} <span class=" text-danger">(required)</span> </label>
                                            <div class="custom-file">
                                                <input type="file" class="form-control"  name="product_images[]"  multiple  />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="btn btn-sm btn-primary" >Update</button>
                                    </div>


                                </div>
                            </div>
                           
                        </form>
                        
                        @endif
                        @endforeach

                        <!--end::Form-->
                    </div>
                </div>


                <!-- product color & size wise quantity add -->
                <div class="card">
                    
                    <div class="card-header">
                        <h4 class="card-title">
                          Add product Quantity...
                        </h4>

                    </div>

                    <div class="card-body">
                        <form id="jquery-val-form" action="{{ route('add-product-quantity') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <input type="hidden" value="{{$product->id}}" name="product_id" id="productData">

                                     @php
                                        $getColorData = App\Models\ProductColorManage::getAllColorDataProductIdWise($product->id);
                                        $getSingleColorData = App\Models\ProductColorManage::getSingleColorData($product->id);
                                    @endphp

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="color_name" class="control-label">{{ __('Color Name') }} <span class=" text-danger">(required)</span></label>
                                            
                                            <select id="color_name" class="form-control select2" name="color_name" id="colorName" data-placeholder="Select Color" onchange="getSizeColorWise(this)" required>
                                                <option selected disabled>Select Color</option>
                                                @foreach($getColorData as $color)
                                                <option value="{{$color->color_name}}">{{$color->color_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('color_name')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                   @if(isset($getSingleColorData->product_size) && $getSingleColorData->product_size != 'null')  
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="sizeName" class="control-label">{{ __('Size') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select class="form-control select2" name="size_name" id="sizeName"  data-placeholder="Select Size" required>
                                                <option disabled>Select Size</option>
                                                
                                            </select>

                                            @error('size_name')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="quantity" class="control-label">{{ __('Quantity') }} <span class=" text-danger">(required)</span></label>
                                            <input id="quantity" type="text" class="form-control" name="quantity"
                                            placeholder="Enter Quantity" value="{{ old('quantity') }}" required >

                                            @error('quantity')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">Add</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>

                </div>


                <!-- product color & size wise quantity update -->
                <div class="card">
                    
                    <div class="card-header">
                        <h4 class="card-title">
                          Update product Quantity...
                        </h4>

                    </div>

                    <div class="card-body">
                        @foreach($productQuantitys as $quantity)
                        @if(isset($quantity) && $quantity != null)
                        <form id="jquery-val-form" action="{{ route('update-product-quantity',$quantity->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <input type="hidden" value="{{$product->id}}" name="product_id" id="productData">

                                     @php
                                        $getColorData = App\Models\ProductColorManage::getAllColorDataProductIdWise($product->id);
                                        $getSingleColorData = App\Models\ProductColorManage::getSingleColorData($product->id);
                                    @endphp

                                    <div class="col-lg-5 col-md-5 col-sm-5 col-12">
                                        <div class="form-group">
                                            <label for="color_name" class="control-label">{{ __('Color Name') }} <span class=" text-danger">(required)</span></label>
                                            
                                            <select id="color_name" class="form-control select2" name="color_name" id="colorName" data-placeholder="Select Color" onchange="getSizeColorWise(this)" required>
                                                <option selected disabled>Select Color</option>
                                                @foreach($getColorData as $color)
                                                <option value="{{$color->color_name}}" {{ $color->color_name == $quantity->color_name ? 'selected' : '' }} >{{$color->color_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('color_name')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    @if(isset($getSingleColorData->product_size) && $getSingleColorData->product_size != 'null')  
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-12">
                                        <div class="form-group">
                                            <label for="sizeName" class="control-label">{{ __('Size') }} <span class=" text-danger">(required)</span> </label>
                                            
                                            <select class="form-control select2" name="size_name" id="sizeName"  data-placeholder="Select Size" required>
                                                <option selected disabled>Select Size</option>
                                                @foreach($sizes as $size)
                                                <option value="{{$size->size_name}}" {{ $size->size_name == $quantity->size_name ? 'selected' : '' }} >{{$size->size_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('size_name')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-lg-5 col-md-5 col-sm-5 col-12">
                                        <div class="form-group">
                                            <label for="quantity" class="control-label">{{ __('Quantity') }} <span class=" text-danger">(required)</span></label>
                                            <input id="quantity" type="text" class="form-control" name="quantity"
                                            placeholder="Enter Quantity" value="{{ $quantity->quantity }}" required >

                                            @error('quantity')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-lg-2 col-md-2 col-sm-2 col-12">
                                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                                    </div>

                                    

                                </div>
                            </div>
                            
                        </form>
                        @endif
                        @endforeach
                        <!--end::Form-->
                    </div>

                </div>


                {{-- Product Color Varient List --}}
                <div class="card">
                    
                    <div class="card-header">
                        <h4 class="card-title">
                            Product Color Details ....
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table table-striped text-center table-bordered dt-responsive nowrap"
                                style="100%">
                                <tbody>
                                    @foreach($productColors as $color)
                                    @if(isset($color) && $color != null)
                                        <tr style="text-align: center;">
                                            <td><input type="color" value="{{$color->color_code}}" disabled></td>
                                            <td>{{ $color->color_name }}</td>
                                            
                                            @php
                                                $getAllSizeData = App\Models\ProductColorManage::getAllSizeDataProductIdWise($color->id);

                                                $getAllImageData = App\Models\ProductColorManage::getAllImageProductIdWise($color->id);
                                            @endphp

                                            <td>
                                                @foreach ($getAllSizeData as $singleSectionData)
                                                    <span class="badge badge-primary">{{$singleSectionData->size_name}}</span>
                                                @endforeach
                                            </td>


                                            <td>
                                                @foreach ($getAllImageData as $singleImageData)
                                                    <img src="{{ asset('/uploads/product_images/'.$singleImageData) }}"
                                                    width="80" height="30" style="object-fit: contain;">
                                                @endforeach
                                            </td>

                                            <td>
                                                <a href="{{ route('product-color-delete',$color->id) }}" id="delete" ><i data-feather="trash" class="me-50"></i><span style="margin-left: 5px;"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </section>
    <!-- Tooltip validations end -->
</div>
</div>

<script>
     //For purchase product add to the list...
    function getSizeColorWise(data){
        colorName = $(data).val();
        productId = $("#productData").val();

        var url = "{{ route('get-size-color-wise') }}";
        if(colorName != ''){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    colorName: colorName,
                    productId: productId,
                },
                success: function (data) {
                    $("#sizeName").html(data);
                }
            });
        }else{
            $('#sizeName').html('');
        }

    }
 </script>

@endsection




