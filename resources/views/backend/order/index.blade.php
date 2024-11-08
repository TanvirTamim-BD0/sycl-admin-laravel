@extends('backend.master')
@section('title')
    All Order
@endsection
@section('styles')
    
@endsection
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Order</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Order List
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
                                All Order List Here...
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="myTable"
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Order Id</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Total</th>
                                            <th>Payment</th>
                                            <th>Order</th>
                                            <th>Delivery</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($orderData as $item)
                                        @if(isset($item) && $item != null)
                                            <tr style="text-align: center;">
                                                <td>{{ $loop->iteration }}</td>

                                                <td style="font-weight:bold; color: rgb(12, 12, 12);" ><a href="{{route('order-details', $item->id)}}">{{ $item->order_unique_id }}</a></td>
                                                <td>{{ $item->customerData->first_name }} {{ $item->customerData->last_name }}</td>
                                                <td>{{ $item->customerData->phone_number }}</td>
                                                <td>{{ $item->total_amount }} ₦</td>

                                                <td>
                                                    @if($item->payment_status == 'success')
                                                    <span class="text-success text-bold" style="font-weight:bold;">Success</span>
                                                    @endif

                                                    @if($item->payment_status == 'pending')
                                                    <span class="text-warning text-bold"  style="font-weight:bold;" >Pending</span>
                                                    @endif

                                                    @if($item->payment_status == 'canceled')
                                                    <span class="text-danger text-bold"  style="font-weight:bold;">Canceled</span>
                                                    @endif
                                                </td>


                                                <td>
                                                    @if($item->order_status == 'accept')
                                                    <span class="text-success text-bold" style="font-weight:bold;">Accept</span>
                                                    @endif

                                                    @if($item->order_status == 'canceled')
                                                    <span class="text-danger text-bold"  style="font-weight:bold;" >Canceled</span>
                                                    @endif

                                                    @if($item->order_status == 'pending')
                                                    <span class="text-warning text-bold"  style="font-weight:bold;" >Pending</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($item->delivery_status == 'proccess')
                                                    <span class="text-success text-bold" style="font-weight:bold;">Proccessing</span>
                                                    @endif

                                                    @if($item->delivery_status == 'out for delivery')
                                                    <span class="text-success text-bold" style="font-weight:bold;">Out For Delivery</span>
                                                    @endif

                                                    @if($item->delivery_status == 'rejected')
                                                    <span class="text-danger text-bold" style="font-weight:bold;">Rejected</span>
                                                    @endif

                                                    @if($item->delivery_status == 'success')
                                                    <span class="text-success text-bold" style="font-weight:bold;">Success</span>
                                                    @endif

                                                    @if($item->delivery_status == 'pending')
                                                    <span class="text-warning text-bold"  style="font-weight:bold;" >Pending</span>
                                                    @endif
                                                </td>
                                            
                                                <td>
                                                    @if($item->payment_status == 'success')
                                                    <div class="dropdown">
                                                      <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                      </button>
                                                      <div class="dropdown-menu">

                                                            @if($item->order_status == 'accept')
                                                                <a href="{{route('delivery-proccess', $item->id)}}" class="dropdown-item" ><span style="margin-left: 5px;">Proccess</span></a>

                                                                <a href="{{route('out-for-delivery', $item->id)}}" class="dropdown-item" ><span style="margin-left: 5px;">Out For Delivery
                                                                </span></a>

                                                                <a href="{{route('delivery-rejected', $item->id)}}" class="dropdown-item" ><span style="margin-left: 5px;">Rejected
                                                                </span></a>

                                                                <a href="{{route('delivery-success', $item->id)}}" class="dropdown-item" ><span style="margin-left: 5px;">Success</span></a>

                                                            @else
                                                                <a href="{{route('order-accept', $item->id)}}" class="dropdown-item" ><span style="margin-left: 5px;">Accept</span></a>

                                                                <a href="{{route('order-canceled', $item->id)}}" class="dropdown-item" ><span style="margin-left: 5px;">Canceled</span></a>
                                                            @endif

                                                      </div>
                                                    </div>
                                                    @endif
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
            <!-- Responsive tables end -->

        </div>

    </div>



@endsection
@section('scripts')
@endsection
