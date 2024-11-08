@extends('backend.master')
@section('title')
    All Products
@endsection
@section('styles')
@endsection
@section('content')


    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Product</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Product List
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="content-body">
            <!-- Responsive tables start -->
            <div class="row" id="table-responsive">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                All Product List Here...
                            </h4>
                            <div class="d-flex justify-content-end">
                                    <a href="{{ route('product.create') }}" class="btn btn-primary font-weight-bolder ">
                                        <i class="la la-list"></i>Create Product</a>
                            </div>


                        </div>
                        <div class="card-body">

                            <form id="jquery-val-form" action="{{ route('product.search') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="category_id" class="control-label">{{ __('Sub Category') }} </label>
                                            
                                            <select id="sub_category_id" class="form-control select2" name="sub_category_id">
                                                <option selected disabled>Select Sub Category</option>
                                                @foreach($subCategories as $subCategory)
                                                <option value="{{$subCategory->id}}">{{$subCategory->sub_category_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('category_id')
                                            <span>
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-md-2 ">
                                        <button type="submit" class="btn btn-primary mr-2">Search</button>
                                    </div><br><br>
                                </div>
                        </form>

                            <div class="table-responsive">
                                <form action="{{ route('multiple-product-delete') }}" method="post">
                                @csrf

                                <table id="myTable"
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Sl</th>
                                            <th>Name</th>
                                            <th>Color</th>
                                            <th>Sub Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($products as $item)
                                        @if(isset($item) && $item != null)
                                       
                                            <tr style="text-align: center;">
                                                <td><input type="checkbox" name="productIds[{{$item->id}}]" value="{{$item->id}}"></td>
                                                <td>{{ $loop->iteration }}</td>

                                                <td><a href="{{route('product.edit', $item->id)}}" style="font-weight:bold; color: rgb(12, 12, 12);"> {{ Str::limit($item->product_name, 40) }}</a></td>
                                         

                                                @php
                                                    $getAllColorData = App\Models\ProductColorManage::getAllColorDataProductIdWise($item->id);

                                                    $getSubCategoryData = App\Models\Product::getSubCategoryDataProductIdWise($item->id);

                                                    $getKeywordData = App\Models\Product::getKeywordDataProductIdWise($item->id);
                                                   
                                                @endphp

                                                <td>
                                                    @foreach ($getAllColorData as $singleColorData)
                                                    <input type="color" value="{{ $singleColorData->color_code }}" disabled>
                                                    @endforeach
                                                </td>


                                                <td>
                                                    @foreach ($getSubCategoryData as $singleSubCategoryData)<span class="">{{ $singleSubCategoryData->sub_category_name }}</span>,
                                                    @endforeach
                                                </td>

                                                {{-- <td>
                                                    @foreach ($getKeywordData as $singleKeywordData)<span class="">{{ $singleKeywordData->keyword_name }}</span>,
                                                    @endforeach
                                                </td> --}}

                                                <td>
                                                    @if($item->status == true)
                                                    <span class="badge badge-success">Active</span>
                                                    @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>


                                         
                                                   <td>
                                                    <div class="dropdown">
                                                      <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                      </button>
                                                      <div class="dropdown-menu">
                                                        
                                                        @if($item->status == true)
                                                        <a href="{{route('product.inactive', $item->id)}}" class="dropdown-item" ><i data-feather='arrow-down'></i><span style="margin-left: 5px;">Inactive</span></a>
                                                        @else

                                                        <a href="{{route('product.active', $item->id)}}" class="dropdown-item" ><i data-feather='arrow-up'></i><span style="margin-left: 5px;">Active</span></a>

                                                        @endif

                                                        <a href="{{route('product.destroy', $item->id)}}" class="dropdown-item" id="delete" ><i data-feather="trash" class="me-50"></i><span style="margin-left: 5px;">Delete</span></a>
                                                        
                                                      
                                                      </div>
                                                    </div>

                                                </td>
                                                        
                                                </td>
                                            
                                            </tr>
                                        @endif
                                        @endforeach

                                        <button type="submit" class="btn btn-danger float-right" style="margin-top: 7px;">Delete</button>
                                    
                                    </tbody>
                                </table>

                            </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Responsive tables end -->
        </div>

    </div>

@endsection
@section('scripts')
@endsection
