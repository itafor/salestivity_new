<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->

        <ul class="nav align-items-center d-md-none">
         
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
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
                    
                   
                    
                   <!--  <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a> -->
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#navbar-accounts" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                    <i class="fa fa-university text-primary" aria-hidden="true"></i>{{ __('Account') }}
                    </a>

                    <div class="collapse " id="navbar-accounts">
                        <ul class="nav nav-sm flex-column">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('customer.index') }}">
                                        {{ __('List Accounts') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-addproducts" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                                        <span class="nav-link-text">{{ __('Add Account') }}</span>
                                    </a>

                                    <div class="collapse" id="navbar-addproducts">
                                        <ul class="nav nav-sm flex-column">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('customer.corporate.create') }}">
                                                        {{ __('Corporate') }}
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('customer.individual.create') }}">
                                                        {{ __('Individual') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('import.customers.form') }}">
                                        {{ __('Import Accounts') }}
                                    </a>
                                </li>
                            </ul>        
                        </ul>
                    </div> 
                            
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#navbar-products" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-briefcase text-primary" aria-hidden="true"></i>{{ __('Product') }}
                    </a>

                    <div class="collapse " id="navbar-products">
                        <ul class="nav nav-sm flex-column">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('product.index') }}">
                                        {{ __('List Products') }}
                                    </a>
                                </li>
                                @if(!auth()->guard('sub_user')->check())
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('product.category.index') }}">
                                            {{ __('Category') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('product.subcategory.index') }}">
                                            {{ __('Sub Category') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('product.create') }}">
                                            {{ __('Add Product') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#navbar-project" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="ni ni-paper-diploma text-primary"></i>
                        <span class="nav-link-text">{{ __('Project') }}</span>
                    </a>

                    <div class="collapse" id="navbar-project">
                        <ul class="nav nav-sm flex-column">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('project.index') }}">
                                        {{ __('List Projects') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('project.create') }}">
                                        {{ __('Add Projects') }}
                                    </a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-retail" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-calculator text-primary" aria-hidden="true"></i>
                        <span class="nav-link-text">{{ __('Retail Field Sales') }}</span>
                    </a>

                    <div class="collapse" id="navbar-retail">
                        <ul class="nav nav-sm flex-column">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('sales.index') }}">
                                        {{ __('List Sales') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('sales.create') }}">
                                        {{ __('Add Sales') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('sales.location.create') }}">
                                        {{ __('Add Sales Location') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('sales.location.index') }}">
                                        {{ __('List Sales Location') }}
                                    </a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-target" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-bullseye text-primary" aria-hidden="true"></i>
                        <span class="nav-link-text">{{ __('Target') }}</span>
                    </a>

                    <div class="collapse" id="navbar-target">
                        <ul class="nav nav-sm flex-column">
                            <ul class="nav nav-sm flex-column">
                               
                                 <li class="nav-item">
                                    <a class="nav-link" href="{{ route('target.sales.persons') }}">
                                        {{ __('List Targets') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('target.create') }}">
                                        {{ __('Build Target') }}
                                    </a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-opportunity" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-compass text-primary" aria-hidden="true"></i>
                        <span class="nav-link-text">{{ __('Opportunities') }}</span>
                    </a>

                    <div class="collapse" id="navbar-opportunity">
                        <ul class="nav nav-sm flex-column">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('opportunity.index') }}">
                                        {{ __('List Opportunities') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('opportunity.create') }}">
                                        {{ __('Add Opportunity') }}
                                    </a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#navbar-billing" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="ni ni-money-coins text-primary "></i>
                        <span class="nav-link-text">{{ __('Billing') }}</span>
                    </a>
            
                    <div class="collapse" id="navbar-billing">
                        <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-invoicing-billing" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                                <i class="fa fa-recycle text-primary" aria-hidden="true"></i>
                                <span class="nav-link-text">{{ __('Invoicing') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="collapse" id="navbar-invoicing-billing">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('billing.invoice.index') }}">
                                            {{ __('List Invoice') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('billing.invoice.create') }}">
                                            {{ __('Add Invoice') }}
                                        </a>
                                    </li> 
                                </ul>  
                            </div>
                        <a class="nav-link" href="#navbar-invoicing-renewals" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                            <i class="fa fa-recycle text-primary" aria-hidden="true"></i>
                          
                            <span class="nav-link-text">{{ __('Recurring') }}</span>
                              &nbsp;
                        </a>
                        <div class="collapse" id="navbar-invoicing-renewals">
                            <ul class="nav nav-sm flex-column">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                            <a class="nav-link" href="{{ route('billing.renewal.index') }}">
                                                {{ __('List Recurring') }}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('billing.renewal.create') }}">
                                                {{ __('Add Recurring') }}
                                            </a>
                                        </li> 
                                </ul>
                                
                                </ul>  
                        </div>
                     
                        </ul>
                    </div>
                  </li>
<!-- 

                   <li class="nav-item">
                    <a class="nav-link" href="#navbar-email-marking" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-bullseye text-primary" aria-hidden="true"></i>
                        <span class="nav-link-text">{{ __('Email-Marketing') }}</span>
                    </a>

                    <div class="collapse" id="navbar-email-marking">
                        <ul class="nav nav-sm flex-column">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('email.marketing.create') }}">
                                        {{ __('Create') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('email.marketing.list') }}">
                                        {{ __('List') }}
                                    </a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                </li> -->


                 <li class="nav-item">
                    <a class="nav-link" href="#navbar-opportunity-report" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-compass text-primary" aria-hidden="true"></i>
                        <span class="nav-link-text">{{ __('Reporting') }}</span>
                    </a>

                    <div class="collapse" id="navbar-opportunity-report">
                        <ul class="nav nav-sm flex-column">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('opportunity.create.report') }}">
                                        {{ __('Opportunities') }}
                                    </a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                </li>

                 @if(auth()->user()->role_id == 1)
                      <li class="nav-item">
                    <a class="nav-link" href="#navbar-get-plans" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-compass text-primary" aria-hidden="true"></i>
                        <span class="nav-link-text">{{ __('Plan') }}</span>
                    </a>

                    <div class="collapse" id="navbar-get-plans">
                        <ul class="nav nav-sm flex-column">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('subcription.plans') }}">
                                        {{ __('List Plans') }}
                                    </a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                </li>

                @endif
                @if(auth()->user()->role_id == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-parameters" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fa fa-university text-primary" aria-hidden="true"></i>{{ __('Parameters') }}
                        </a>

                        <div class="collapse " id="navbar-parameters">
                            <ul class="nav nav-sm flex-column">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-user" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                                            <span class="nav-link-text">{{ __('User') }}</span>
                                        </a>
                                        <ul class="flex-column">
                                            <div class="collapse" id="navbar-user">
                                                <ul class="nav nav-sm flex-column" >
                                                    <ul class="nav nav-sm flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="{{ route('allSubUsers') }}">
                                                                {{ __('List User') }}
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="{{ route('newSubUser') }}">
                                                                {{ __('Add User') }}
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </ul>
                                            </div>
                                        </ul>
                                    </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="#navbar-team" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                                            <span class="nav-link-text">{{ __('Teams') }}</span>
                                        </a>
                                        <ul class="flex-column">
                                            <div class="collapse" id="navbar-team">
                                                <ul class="nav nav-sm flex-column" >
                                                    <ul class="nav nav-sm flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="{{ route('team.index') }}">
                                                                {{ __('List Teams') }}
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="{{ route('newSubUser') }}">
                                                                {{ __('Create Team') }}
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </ul>
                                            </div>
                                        </ul>
                                    </li>
                                        <li class="nav-item">
                                        <a class="nav-link" href="{{ route('company_details.index') }}" >
                                            <span class="nav-link-text">{{ __('Company Details') }}</span>
                                        </a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('company.email.index') }}" >
                                            <span class="nav-link-text">{{ __('Company Emails') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('bank.account.index') }}" >
                                            <span class="nav-link-text">{{ __('Bank Account') }}</span>
                                        </a>
                                    </li>
                                     <li class="nav-item">
                                        <a class="nav-link" href="{{ route('currency.index') }}" >
                                            <span class="nav-link-text">{{ __(' Currency') }}</span>
                                        </a>
                                    </li>
                                </ul>        
                            </ul>
                        </div>   
                                
                    </li>
                @endif
        </div>
    </div>
</nav>