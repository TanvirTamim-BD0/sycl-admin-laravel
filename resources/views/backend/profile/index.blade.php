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
                        <h4 class="card-header">User Details Edit</h4>
                        <div class="card-body">
                            <form
                                action="{{ route('profile.update', Auth::user()->id ) }}"
                                method="post">
                                @csrf
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="row">

                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label for="name">Username: <span class=" text-danger">(required)</span></label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ Auth::user()->name }}" placeholder="Username" required>
                                            </div>

                                            @error('name')
                                                <span class=text-danger>{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label for="email">Email: <span class=" text-danger">(required)</span></label>
                                                <input type="text" name="email" class="form-control"
                                                    value="{{ Auth::user()->email }}" placeholder="Email" required>
                                            </div>

                                            @error('email')
                                                <span class=text-danger>{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="form-group">
                                                <label for="mobile">Phone Number:</label>
                                                <input type="text" id="mobile" name="mobile" class="form-control"
                                                    value="{{ Auth::user()->mobile }}" placeholder="Phone Number">
                                            </div>

                                            @error('mobile')
                                                <span class=text-danger>{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center">
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
