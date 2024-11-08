@extends('backend.master')
@section('title')
    All Users
@endsection
@section('styles')
@endsection
@section('content')

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">User</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Users List
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
                                All User List Here...
                            </h4>
                            <div class="d-flex justify-content-end">
                                    <a href="{{ route('users.create') }}" class="btn btn-primary font-weight-bolder ">
                                        <i class="la la-list"></i>Create User</a>
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                        
                                    </thead>
                                    <tbody>

                                        @foreach($data as $item)
                                        @if(isset($item) && $item != null)
                                            <tr style="text-align: center;">
                                                <td>{{ $loop->iteration }}</td>

                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->mobile }}</td>

                                                <td>
                                                    @if($item->id != Auth::user()->id)
                                                    <div class="dropdown">
                                                      <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                      </button>
                                                      <div class="dropdown-menu">
                                                        
                                                        <a href="{{route('users.edit', $item->id)}}" class="dropdown-item" ><i data-feather="edit" class="me-50"></i><span style="margin-left: 5px;">Edit</span></a>

                                                        <a href="{{route('users.destroy', $item->id)}}" class="dropdown-item" id="delete" ><i data-feather="trash" class="me-50"></i><span style="margin-left: 5px;">Delete</span></a>
                                                        
                                                      
                                                      </div>
                                                    </div>

                                                    @else
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
