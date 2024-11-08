@extends('backend.master')
@section('styles')
@endsection
@section('content')

 <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">

        <section id="dashboard-ecommerce">

            <div class="row match-height">
                <!-- Statistics Card -->
                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-success mr-2">
                                <div class="avatar-content">
                                  <i data-feather="dollar-sign" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$todaySellingPrice}} ₦</h4>
                                <p class="card-text font-small-3 mb-0">Today Sell</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-primary mr-2">
                                <div class="avatar-content">
                                  <i data-feather="dollar-sign" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$totalSellingPrice}} ₦</h4>
                                <p class="card-text font-small-3 mb-0">Total Sell</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-primary mr-2">
                                <div class="avatar-content">
                                  <i data-feather="shopping-cart" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$orderPending}}</h4>
                                <p class="card-text font-small-3 mb-0">Order Pending</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-primary mr-2">
                                <div class="avatar-content">
                                  <i data-feather="shopping-cart" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$orderSuccess}}</h4>
                                <p class="card-text font-small-3 mb-0">Order Success</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-danger mr-2">
                                <div class="avatar-content">
                                  <i data-feather="shopping-cart" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$orderCancel}}</h4>
                                <p class="card-text font-small-3 mb-0">Order Cancel</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-info mr-2">
                                <div class="avatar-content">
                                  <i data-feather="users" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$customer}}</h4>
                                <p class="card-text font-small-3 mb-0">Customer</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-warning mr-2">
                                <div class="avatar-content">
                                  <i data-feather="grid" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$primeCategory}}</h4>
                                <p class="card-text font-small-3 mb-0">Prime Category</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-success mr-2">
                                <div class="avatar-content">
                                  <i data-feather="columns" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$middleCategory}}</h4>
                                <p class="card-text font-small-3 mb-0">Middle Category</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-info mr-2">
                                <div class="avatar-content">
                                  <i data-feather="calendar" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$subCategory}}</h4>
                                <p class="card-text font-small-3 mb-0">Sub Category</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-success mr-2">
                                <div class="avatar-content">
                                  <i data-feather="briefcase" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$product}}</h4>
                                <p class="card-text font-small-3 mb-0">Product</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-danger mr-2">
                                <div class="avatar-content">
                                  <i data-feather="box" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$bannerCategory}}</h4>
                                <p class="card-text font-small-3 mb-0">Banner Category</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-warning mr-2">
                                <div class="avatar-content">
                                  <i data-feather="credit-card" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$topBanner}}</h4>
                                <p class="card-text font-small-3 mb-0">Top Banner</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-primary mr-2">
                                <div class="avatar-content">
                                  <i data-feather="layout" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$squareBanner}}</h4>
                                <p class="card-text font-small-3 mb-0">Square Banner</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-info mr-2">
                                <div class="avatar-content">
                                  <i data-feather="server" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$bottomBanner}}</h4>
                                <p class="card-text font-small-3 mb-0">Bottom Banner</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-xl-3 col-md-6 col-12">
                    <div class="card card-statistics">
                      <div class="card-body statistics-body">
                            <div class="media">
                              <div class="avatar bg-light-success mr-2">
                                <div class="avatar-content">
                                  <i data-feather="user" class="avatar-icon"></i>
                                </div>
                              </div>
                              <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{$user}}</h4>
                                <p class="card-text font-small-3 mb-0">User</p>
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>


            {{-- order list --}}
            <div class="row match-height">
              <div class="col-lg-8 col-12">
                <div class="card card-company-table">
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Order Id</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Order</th>
                          </tr>
                        </thead>
                        <tbody>

                          @foreach($orderData as $item)
                          @if(isset($item) && $item != null)
                          <tr>

                            <td>
                              <div class="d-flex align-items-center">
                                <div>
                                  <div class="font-weight-bolder"><a href="{{route('order-details', $item->id)}}">{{ $item->order_unique_id }}</a></div>
                                </div>
                              </div>
                            </td>

                            <td>
                              <div class="d-flex align-items-center">
                                <span>{{ $item->customerData->first_name }} {{ $item->customerData->last_name }}</span>
                              </div>
                            </td>

                            <td>{{ $item->customerData->phone_number }}</td>

                            <td class="text-nowrap">
                              <div class="d-flex flex-column">
                                <span class="font-weight-bolder mb-25">{{ $item->total_amount }} ₦</span>
                              </div>
                            </td>
                            

                            <td>
                              <div class="d-flex align-items-center">
                                <span class="font-weight-bolder text-danger mr-1">Pending</span>
                              </div>
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


          

       

    </div>
</div> 


@endsection