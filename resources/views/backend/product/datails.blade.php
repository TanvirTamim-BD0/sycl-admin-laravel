@extends('backend.master')
@section('title')
    Product Details
@endsection
@section('styles')
    
@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-body">
            <!-- Responsive tables start -->
            <div class="row" id="table-responsive">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                               Product Information ....
                            </h4>
                            <div class="d-flex justify-content-end">
                                    <a href="{{ route('product.index') }}" class="btn btn-primary font-weight-bolder ">
                                        <i class="la la-list"></i>Product List</a>
                            </div>


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id=""
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Sub Category</th>
                                            <th>Banner Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                            <tr style="text-align: center;">
                                                <td>{{ $product->product_name }}</td>
                                                
                                                @php
                                                $getSubCategoryData = App\Models\Product::getSubCategoryDataProductIdWise($product->id);

                                                $getBannerCategoryData = App\Models\Product::getBannerCategoryDataProductIdWise($product->id);
                                               
                                            @endphp

                                            <td>
                                                @foreach ($getSubCategoryData as $singleSubCategoryData)<span class="badge badge-primary">{{ $singleSubCategoryData->sub_category_name }}</span>,
                                                @endforeach
                                            </td>

                                            <td>
                                                @foreach ($getBannerCategoryData as $singleBannerCategoryData)<span class="badge badge-primary">{{ $singleBannerCategoryData->banner_category_name }}</span>,
                                                @endforeach
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                               Product Color Information ....
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id=""
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

                                                <td>Price - {{ $color->product_price }}</td>

                                                <td>
                                                    @foreach ($getAllImageData as $singleImageData)
                                                        <img src="{{ asset('/uploads/product_images/'.$singleImageData) }}"
                                                        width="80" height="30" style="object-fit: contain;">
                                                    @endforeach
                                                </td>
    
                                            </tr>
                                        @endif
                                        @endforeach
    
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                               Product Details ....
                            </h4>
                        </div>
                        <div class="card-body">
                          
                            <div class="table-responsive mt-2">
                                <table id=""
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Title 1</th>
                                            <th>Description 1</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr style="text-align: center;">
                                                <td>{{ $product->title_1 }}</td>
                                                <td>{{ $product->description_1 }}</td>
                                            </tr>

                                    </tbody>
                                </table>
                            </div>  


                            <div class="table-responsive mt-2">
                                <table id=""
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Title 2</th>
                                            <th>Description 2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr style="text-align: center;">
                                                <td>{{ $product->title_2 }}</td>
                                                <td>{{ $product->description_2 }}</td>
                                            </tr>

                                    </tbody>
                                </table>
                            </div>  


                            <div class="table-responsive mt-2">
                                <table id=""
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Title 3</th>
                                            <th>Description 3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr style="text-align: center;">
                                                <td>{{ $product->title_3 }}</td>
                                                <td>{{ $product->description_3 }}</td>
                                            </tr>

                                    </tbody>
                                </table>
                            </div>  


                            <div class="table-responsive mt-2">
                                <table id=""
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Title 4</th>
                                            <th>Description 4</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr style="text-align: center;">
                                                <td>{{ $product->title_4 }}</td>
                                                <td>{{ $product->description_4 }}</td>
                                            </tr>

                                    </tbody>
                                </table>
                            </div>  
                            


                            <div class="table-responsive mt-2">
                                <table id=""
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Title 5</th>
                                            <th>Description 5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr style="text-align: center;">
                                                <td>{{ $product->title_5 }}</td>
                                                <td>{{ $product->description_5 }}</td>
                                            </tr>

                                    </tbody>
                                </table>
                            </div>  
                            
                            
                            
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                               Product Video ....
                            </h4>
                        </div>
                        <div class="card-body">
                            
                            @if(isset($product->product_video) && $product->product_video != null)
                            <video width="100%" height="500" controls>
                                <source src="{{ asset('/uploads/product_video/'.$product->product_video) }}" type="video/mp4">
                            </video>
                            @else
                            @endif

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
