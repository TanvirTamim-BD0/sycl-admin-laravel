@extends('backend.master')
@section('content')

        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="app-user-view-account">
                    <div class="row">
                        <!-- User Sidebar -->
                        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                            <!-- User Card -->
                             @include('backend.profile.sidebar')
                            <!-- /User Card -->
                        </div>
                        <!--/ User Sidebar -->

                        <!-- User Content -->
                        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                            <!-- User Pills -->
                            @include('backend.profile.menu')
                            <!--/ User Pills -->

                            <!-- Project table -->
                            <!-- Project table -->
                            <div class="card">
                                <h4 class="card-header">Security Settings</h4>
                                            <div class="card-body">
                                                <form action="{{route('security.update')}}" method="post">
                                                    @csrf
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <div class="row">
                                                            
                                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                                <div class="form-group">
                                                                    <label for="old_password">Old Password</label>
                                                                    <input type="password" name="old_password" class="form-control" placeholder="Old Password">

                                                                    @error('old_password')
                                                                        <span class=text-danger>{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 ">
                                                                <div class="form-group">
                                                                    <label for="new_password">New Password</label>
                                                                    <input type="password" name="new_password" class="form-control" placeholder="New Password">

                                                                    @error('new_password')
                                                                     <span class=text-danger>{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                                
                                                            </div>

                                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 ">
                                                                <div class="form-group">
                                                                    <label for="confirm_password">Confirm Password</label>
                                                                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">

                                                                    @error('confirm_password')
                                                                        <span class=text-danger>{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div><br>

                                                            
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center" >
                                                                <input type="submit" name="submit" class="btn btn btn-primary" value="Update">
                                                            </div>

                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                           </div>
                            <!-- /Project table -->
                            <!-- /Project table -->


                           
                        </div>
                        <!--/ User Content -->
                    </div>
                </section>
                
               

            </div>
        </div>

@endsection