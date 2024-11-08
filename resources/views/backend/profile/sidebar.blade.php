                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="user-avatar-section">
                                        <div class="d-flex align-items-center flex-column">
                                            <img class="img-fluid rounded mt-3 mb-2" src="{{asset('backend')}}/app-assets/images/portrait/small/img_avatar.png" height="110" width="110" alt="User avatar" />
                                            <div class="user-info text-center">
                                                <h4>{{ Auth::guard()->user()->name}}</h4>
                                                <span class="badge bg-light-secondary">Admin</span>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                                    <div class="info-container">
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Username: </span>
                                                <span>{{ Auth::guard()->user()->name}}</span>
                                            </li>
                                            
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Email: </span>
                                                <span>{{ Auth::user()->email }}</span>
                                            </li>

                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Mobile: </span>
                                                <span>{{ Auth::user()->mobile }}</span>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>