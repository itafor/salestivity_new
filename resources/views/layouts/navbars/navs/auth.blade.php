<!-- Top navbar -->
<nav class="navbar navbar-auth navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        @if (isset($icon)) 
            <i class="{{ $icon }} header-icon"></i>
        @endif
        <a class="h4 text-white d-none d-lg-inline-block header-title" href="{{ route('home') }}">{{isset($title) ? $title : ''}}</a>


        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex right">
             <span class="text-white" style="font-size: 14px;">
            You are on  {{activeSubscription()['plan']->name}} plan. You can only manage {{activeSubscription()['plan']->number_of_subusers}} users and {{activeSubscription()['plan']->number_of_accounts}} accounts.  <a href="{{route('subcription.plans')}}" class="text-white">Upgrade Now</a>
           </span>
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/user-dummy.jpg">
                        </span>
                        @if(Auth::guard('admin')->check())
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold">{{ auth()->guard('admin')->user()->name }} {{ auth()->guard('admin')->user()->last_name }}</span>
                            </div>
                        @elseif(Auth::guard('sub_user')->check())
                        <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold">{{ auth()->guard('sub_user')->user()->name }} {{ auth()->guard('sub_user')->user()->last_name }}</span>
                            </div>
                        @else
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</span>
                            </div>
                        @endif
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
