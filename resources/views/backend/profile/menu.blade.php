                        <ul class="nav nav-pills mb-2">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="{{route('profile')}}">
                                        <i data-feather="user" class="font-medium-3 me-50"></i>
                                        <span class="fw-bold">Account</span></a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('security') ? 'active' : '' }}" href="{{route('security')}}">
                                        <i data-feather="lock" class="font-medium-3 me-50"></i>
                                        <span class="fw-bold">Security</span></a>
                                </li>
                            </ul>