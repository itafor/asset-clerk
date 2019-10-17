@php
    $user = auth()->user();
    $plan = getUserPlan();
@endphp
<!-- Sidebar -->
<aside id="main-sidebar" class="dt-sidebar">
    <div class="dt-sidebar__container container-fluid">

        <!-- Sidebar Notification -->
        {{-- <div class="dt-sidebar__notification  d-none d-lg-block"> --}}
            <!-- Dropdown -->
            {{-- <div class="dropdown mb-6" id="user-menu-dropdown">

                <!-- Dropdown Link -->
                <a href="#" class="dropdown-toggle dt-avatar-wrapper text-body"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="dt-avatar" src="{{auth()->user()->image ? auth()->user()->image : 'https://via.placeholder.com/150x150'}}" alt="{{auth()->user()->fullname()}}">
                    <span class="dt-avatar-info">
            <span class="dt-avatar-name">{{auth()->user()->fullname()}}</span>
          </span> </a>
                <!-- /dropdown link -->

                <!-- Dropdown Option -->
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dt-avatar-wrapper flex-nowrap p-6 mt--5 bg-gradient-purple text-white rounded-top">
                        <img class="dt-avatar" src="{{auth()->user()->image ? auth()->user()->image : 'https://via.placeholder.com/150x150'}}" alt="Domnic Harris">
                        <span class="dt-avatar-info">
                  <span class="dt-avatar-name">{{auth()->user()->fullname()}}</span>
                  <span class="f-12">{{ucwords(auth()->user()->role)}}</span>
                </span>
                    </div>
                    <a class="dropdown-item" href="{{ route('profile.upgrade') }}"> <i class="icon icon-user-o icon-fw mr-2 mr-sm-1"></i>Upgrade
                    </a>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"> <i class="icon icon-user-o icon-fw mr-2 mr-sm-1"></i>Account
                    </a>
                    <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"> <i class="icon icon-edit icon-fw mr-2 mr-sm-1"></i>Logout
                    </a>
                </div>
                <!-- /dropdown option -->

            </div> --}}
            <!-- /dropdown -->


            {{-- <ul class="dt-list dt-list-xl">
              <li class="dt-list__item pl-5 pr-5">
                <a href="javascript:void(0)" class="dt-list__link"><i class="icon icon-search-new icon-xl"></i></a>
              </li>
              <li class="dt-list__item pl-5 pr-5">
                <a href="javascript:void(0)" class="dt-list__link"><i class="icon icon-notification icon-xl"></i></a>
              </li>
              <li class="dt-list__item pl-5 pr-5">
                <a href="javascript:void(0)" class="dt-list__link"><i class="icon icon-chat-new icon-xl"></i></a>
              </li>
            </ul> --}}
        {{-- </div> --}}
        <!-- /sidebar notification -->

        <!-- Sidebar Navigation -->
        <ul class="dt-side-nav" style="margin-bottom:150px">

            <!-- Menu Header -->
            <li class="dt-side-nav__item dt-side-nav__header"  style="padding-top:0">
                <span class="dt-side-nav__text">main menu</span>
            </li>
            <!-- /menu header -->
            <li class="dt-side-nav__item {{isset($page) && $page == 'dashboard' ? 'open' : ''}}">
                <a href="{{route('home')}}" class="dt-side-nav__link" title="Dashboard"> <i class="icon icon-dashboard icon-fw icon-xl text-white"></i>
                    <span class="dt-side-nav__text text-white">Dashboard</span> </a>
            </li>

            <li class="dt-side-nav__item {{isset($page) && $page == 'landlord' ? 'open' : ''}} text-white">
            <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Landlord Management">
                <i class="icon icon-user-o icon-fw icon-xl text-white"></i> <span class="dt-side-nav__text text-white">Landlord Management</span> </a>

            <!-- Sub-menu -->
            <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{route('landlord.index')}}" class="dt-side-nav__link" title="List">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>  <span class="dt-side-nav__text text-white">List</span> </a>
                </li>

                <li class="dt-side-nav__item">
                    <a href="{{route('landlord.create')}}" class="dt-side-nav__link" title="Add New">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Add New</span> </a>
                </li>

            </ul>
            <!-- /sub-menu -->
            </li>

            <!-- Menu Item -->
            <li class="dt-side-nav__item {{isset($page) && $page == 'asset' ? 'open' : ''}}">
            <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Asset Management">
                <i class="icon icon-company icon-fw icon-xl text-white"></i> <span class="dt-side-nav__text text-white">Asset Management</span> </a>

            <!-- Sub-menu -->
            <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{route('asset.index')}}" class="dt-side-nav__link" title="Asset List">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>  <span class="dt-side-nav__text text-white">List Assets</span> </a>
                </li>
                <li class="dt-side-nav__item">
                    <a href="{{route('asset.my')}}" class="dt-side-nav__link" title="My Assets">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>  <span class="dt-side-nav__text text-white">My Assets</span> </a>
                </li>

                <li class="dt-side-nav__item">
                    <a href="{{route('asset.create')}}" class="dt-side-nav__link" title="Listing">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Add New</span> </a>
                </li>

            </ul>
            <!-- /sub-menu -->
            </li>

            <!-- Menu Item -->
            <li class="dt-side-nav__item {{isset($page) && $page == 'tenant' ? 'open' : ''}}">
            <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Tenant Management">
                <i class="icon icon-user-o icon-fw icon-xl text-white"></i> <span class="dt-side-nav__text text-white">Tenant Management</span> </a>

            <!-- Sub-menu -->
            <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{route('tenant.index')}}" class="dt-side-nav__link" title="List">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white" ></i>  <span class="dt-side-nav__text text-white">List</span> </a>
                </li>

                <li class="dt-side-nav__item">
                    <a href="{{route('tenant.create')}}" class="dt-side-nav__link" title="Add New">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Add New</span> </a>
                </li>

            </ul>
            <!-- /sub-menu -->
            </li>

            
            <li class="dt-side-nav__item {{isset($page) && $page == 'rental' ? 'open' : ''}}">
            <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Rentals">
                <i class="icon icon-card icon-fw icon-xl text-white"></i> <span class="dt-side-nav__text text-white">Rentals</span> </a>

            <!-- Sub-menu -->
            <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{route('rental.my')}}" title="My Rented Apartments" class="dt-side-nav__link">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>  <span class="dt-side-nav__text text-white">My Rented Apartments</span> </a>
                </li>
                <li class="dt-side-nav__item">
                    <a href="{{route('rental.index')}}" class="dt-side-nav__link">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>  <span class="dt-side-nav__text text-white">List</span> </a>
                </li>

                <li class="dt-side-nav__item">
                    <a href="{{route('rental.create')}}" class="dt-side-nav__link">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Add New</span> </a>
                </li>

            </ul>
            <!-- /sub-menu -->
            </li>
            <li class="dt-side-nav__item {{isset($page) && $page == 'maintenance' ? 'open' : ''}}">
            <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Maintenance Management">
                <i class="icon icon-setting icon-fw icon-xl text-white"></i> <span class="dt-side-nav__text text-white">Maintenance Management</span> </a>

            <!-- Sub-menu -->
            <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{route('maintenance.index')}}" class="dt-side-nav__link">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>  <span class="dt-side-nav__text text-white">List</span> </a>
                </li>

                <li class="dt-side-nav__item">
                    <a href="{{route('maintenance.create')}}" class="dt-side-nav__link">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Add New</span> </a>
                </li>

            </ul>
            <!-- /sub-menu -->
            </li>

            <li class="dt-side-nav__item {{isset($page) && $page == 'debt' ? 'open' : ''}}">
                <a href="{{route('debt.debt')}}" class="dt-side-nav__link">
                    <i class="icon icon-card icon-fw icon-xl text-white"></i>
                    <span class="dt-side-nav__text text-white">Debts</span>
                </a>
            </li>

            <li class="dt-side-nav__item {{isset($page) && $page == 'payment' ? 'open' : ''}}">
            <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                <i class="icon icon-card icon-fw icon-xl text-white"></i> <span class="dt-side-nav__text text-white">Payments</span> </a>

            <!-- Sub-menu -->
            <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{route('payment.index')}}" class="dt-side-nav__link">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>  <span class="dt-side-nav__text text-white">List</span> </a>
                </li>

                <li class="dt-side-nav__item">
                    <a href="{{route('payment.create')}}" class="dt-side-nav__link">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Add New</span> </a>
                </li>

            </ul>
            <!-- /sub-menu -->
            </li>

      

                <li class="dt-side-nav__item {{isset($page) && $page == 'service' ? 'open' : ''}}">
            <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Service Charge">
                <i class="icon icon-card icon-fw icon-xl text-white"></i> <span class="dt-side-nav__text text-white">Service Charges</span> </a>

            <!-- Sub-menu -->
            <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{ route('service.charges') }}" class="dt-side-nav__link" title="List">
                    <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>
                    <span class="dt-side-nav__text text-white">List</span>
                </a>
                </li>

                <li class="dt-side-nav__item">
                    <a href="{{route('pay.service.charge')}}" class="dt-side-nav__link" title="Service Charge Payment">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Payment</span> </a>
                </li>

                 <li class="dt-side-nav__item">
                    <a href="{{route('debtors.get')}}" class="dt-side-nav__link" title="Debtors" title="Debtors">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Debtors</span> </a>
                </li>

                 <li class="dt-side-nav__item">
                    <a href="{{route('fetch.service.charge.payment.history')}}" class="dt-side-nav__link" title="Service Charge Payment History">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">History</span> </a>
                </li>

            <li class="dt-side-nav__item {{isset($page) && $page == 'payment' ? 'open' : ''}}">
            <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Tenant's Service Charge Wallet">
                <i class="icon icon-card icon-fw icon-xl text-white"></i> <span class="dt-side-nav__text text-white">Wallet</span> </a>

            <!-- Sub-menu -->
            <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{route('tenant.wallet')}}" class="dt-side-nav__link" title="Tenant's Service Charge Wallet Details">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>  <span class="dt-side-nav__text text-white">List</span> </a>
                </li>

                <li class="dt-side-nav__item">
                    <a href="{{route('wallet.index')}}" class="dt-side-nav__link" title="Fund Tenant's Wallet">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Fund Wallet</span> </a>
                </li>

                 <li class="dt-side-nav__item">
                    <a href="{{route('wallet.history')}}" class="dt-side-nav__link" title="Tenant's Wallet Transactions History">
                        <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Wallet History</span> </a>
                </li>

            </ul>
            <!-- /sub-menu -->
            </li>

            </ul>
            <!-- /sub-menu -->
            </li>


            @if(!$user->sub_account && $plan['details']->name != 'Free')
                <li class="dt-side-nav__item {{isset($page) && $page == 'sub_account' ? 'open' : ''}}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Sub Accounts">
                    <i class="icon icon-user-o icon-fw icon-xl text-white"></i> <span class="dt-side-nav__text text-white">Sub Accounts</span> </a>

                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{route('subs.index')}}" class="dt-side-nav__link" title="List">
                            <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>  <span class="dt-side-nav__text text-white">List</span> </a>
                    </li>

                    <li class="dt-side-nav__item">
                        <a href="{{route('subs.create')}}" class="dt-side-nav__link" title="Add New">
                            <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Add New</span> </a>
                    </li>

                </ul>
                <!-- /sub-menu -->
                </li>
                <li class="dt-side-nav__item {{isset($page) && $page == 'my_account' ? 'open' : ''}}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                    <i class="icon icon-user-o icon-fw icon-xl"></i> <span class="dt-side-nav__text">My Account</span> </a>

                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{route('transactions.history')}}" class="dt-side-nav__link">
                            <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i>  <span class="dt-side-nav__text text-white">Transactions</span> </a>
                    </li>

                    <li class="dt-side-nav__item">
                        <a href="{{route('subscription.history')}}" class="dt-side-nav__link">
                            <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Subscription History</span> </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{route('profile.upgrade')}}" class="dt-side-nav__link" title="Buy A Plan">
                            <i class="icon icon-listing-dbrd icon-fw icon-sm text-white"></i> <span class="dt-side-nav__text text-white">Buy A Plan</span> </a>
                    </li>

                </ul>
                <!-- /sub-menu -->
                </li>
        @endif
        <!-- /menu item -->
        </ul>
        <!-- /sidebar navigation -->

    </div>
</aside>
<!-- /sidebar -->