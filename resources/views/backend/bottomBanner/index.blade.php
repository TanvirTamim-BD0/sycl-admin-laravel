@extends('backend.master')
@section('title')
    All Bottom Banners
@endsection
@section('styles')
    
@endsection
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Bottom Banner</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Bottom Banner List
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
                                All Bottom Banners List Here...
                            </h4>
                            <div class="d-flex justify-content-end">
                                    <a href="{{ route('bottom-banner.create') }}" class="btn btn-primary font-weight-bolder ">
                                        <i class="la la-list"></i>Create Bottom Banner</a>
                            </div>


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="myTable"
                                    class="table table-striped text-center table-bordered dt-responsive nowrap"
                                    style="100%">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Text 1</th>
                                            <th>Text 2</th>
                                            <th>Text 3</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($bottomBanners as $item)
                                        @if(isset($item) && $item != null)
                                            <tr style="text-align: center;">
                                                <td>{{ $loop->iteration }}</td>

                                                @if(isset($item->bottom_banner_image) && $item->bottom_banner_image != null)
                                                <td><img src="{{ asset('/uploads/bottom_banner_image/'.$item->bottom_banner_image) }}"
                                                        width="150" height="70" style="object-fit: contain;"></td>
                                                @else
                                                <td><img src="{{ asset('backend/default.png') }}"
                                                        width="150" height="70"></td>
                                                @endif
                                                <td>{{ $item->bannerCategoryData->banner_category_name }}</td>
                                                <td>{{ $item->bottom_banner_text_1 }}</td>
                                                <td>{{ $item->bottom_banner_text_2 }}</td>
                                                <td>{{ $item->bottom_banner_text_3 }}</td>

                                                   <td>
                                                    <div class="dropdown">
                                                      <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                      </button>
                                                      <div class="dropdown-menu">
                                                        
                                                        <a href="{{route('bottom-banner.edit', $item->id)}}" class="dropdown-item" ><i data-feather="edit" class="me-50"></i><span style="margin-left: 5px;">Edit</span></a>

                                                        <a href="{{route('bottom-banner.destroy', $item->id)}}" class="dropdown-item" id="delete" ><i data-feather="trash" class="me-50"></i><span style="margin-left: 5px;">Delete</span></a>
                                                        
                                                      
                                                      </div>
                                                    </div>

                                                </td>
                                                        
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
        </div>

    </div>

@endsection
@section('scripts')
@endsection
