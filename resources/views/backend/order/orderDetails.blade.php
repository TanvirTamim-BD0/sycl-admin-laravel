@extends('backend.master')
@section('title')
     Order Details
@endsection
@section('styles')
    
@endsection
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Order Details - {{ $orderData->order_unique_id }}</h2>
                        <div class="breadcrumb-wrapper">
                           {{--  <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Order Details
                                </li>
                            </ol> --}}
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
                                Order Product Details...
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id=""
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orderProductData as $item)
                                        @if(isset($item) && $item != null)
                                            <tr style="text-align: center;">
                                                
                                                @php
                                                    $getAllImageData = App\Models\Order::getAllImageProductIdWise($item->product_id,$item->color);
                                                @endphp

                                                <td>
                                                    @foreach ($getAllImageData as $singleImageData)
                                                        <img src="{{ asset('/uploads/product_images/'.$singleImageData) }}"
                                                        width="80" height="30" style="object-fit: contain;">
                                                    @endforeach
                                                </td>
                                                <td>{{ $item->productData->product_name }}</td>
                                                <td>{{ $item->color }}</td>
                                                <td>{{ $item->size }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->price }} ₦</td>
                                            </tr>
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Address Details...
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id=""
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Address Type</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr style="text-align: center;">
                                                <td>{{ $addressData->first_name }} {{ $addressData->last_name }}</td>
                                                <td>{{ $addressData->mobile_number }}</td>
                                                <td>
                                                    @if($addressData->address_type == 'Institution Address')
                                                    Address Type - {{ $addressData->address_type }}<br>
                                                    Institution - {{ $addressData->universityData->university_name }}
                                                    @else
                                                    Address Type - {{ $addressData->address_type }}<br>
                                                    Country - {{ $addressData->countryData->country_name }}<br>
                                                    City - {{ $addressData->cityData->city_name }}<br>
                                                    Post Code - {{ $addressData->post_code }}<br>
                                                    @endif
                                                </td>

                                                <td>{{ $addressData->address }}</td>
                                            </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                            Payment History...
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id=""
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Sub Total</th>
                                            <th>Shipping Fee</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr style="text-align: center;">
                                                <td>{{ $orderData->subtotal_amount }} ₦</td>
                                                <td>{{ $orderData->shipping_fee }} ₦</td>
                                                <td>{{ $orderData->total_amount }} ₦</td>
                                            </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                            Customer Details...
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id=""
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr style="text-align: center;">
                                                <td>{{ $orderData->customerData->first_name }} {{ $orderData->customerData->last_name }}</td>
                                                <td>{{ $orderData->customerData->phone_number }}</td>
                                                <td>{{ $orderData->customerData->email }}</td>
                                            </tr>

                                    </tbody>
                                </table>
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
