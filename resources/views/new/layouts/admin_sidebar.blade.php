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
        <ul class="dt-side-nav">

            <!-- Menu Header -->
            <li class="dt-side-nav__item dt-side-nav__header"  style="padding-top:0">
                <span class="dt-side-nav__text">main menu</span>
            </li>
            <!-- /menu header -->
            <li class="dt-side-nav__item {{isset($page) && $page == 'dashboard' ? 'open' : ''}}">
                <a href="{{route('home')}}" class="dt-side-nav__link" title="Dashboard"> <i class="icon icon-dashboard icon-fw icon-xl"></i>
                <span class="dt-side-nav__text">Dashboard</span> </a>
            </li>

            <!-- Menu Item -->
            <li class="dt-side-nav__item {{isset($page) && $page == 'subscription' ? 'open' : ''}}"">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Dashboard">
                <i class="icon icon-company icon-fw icon-xl"></i> <span class="dt-side-nav__text">Subscription Plans</span> </a>

                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{url('subscription_plans')}}" class="dt-side-nav__link" title="Asset List">
                    <i class="icon icon-listing-dbrd icon-fw icon-sm"></i>  <span class="dt-side-nav__text">List Plans</span> </a>
                </li>

                <li class="dt-side-nav__item">
                    <a href="{{url('subscription_plans/add_subscription_plan')}}" class="dt-side-nav__link" title="Listing">
                    <i class="icon icon-listing-dbrd icon-fw icon-sm"></i> <span class="dt-side-nav__text">Add New Plan</span> </a>
                </li>

                </ul>
                <!-- /sub-menu -->
            </li>

            <!-- Menu Item -->
            <li class="dt-side-nav__item {{isset($page) && $page == 'transactions' ? 'open' : ''}}"">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                <i class="icon icon-user-o icon-fw icon-xl"></i> <span class="dt-side-nav__text">Transactions</span> </a>

                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{url('subscription_plans/transactions')}}" class="dt-side-nav__link">
                    <i class="icon icon-listing-dbrd icon-fw icon-sm"></i>  <span class="dt-side-nav__text">Transactions Log</span> </a>
                </li>

                </ul>
                <!-- /sub-menu -->
            </li>
            
            <li class="dt-side-nav__item {{isset($page) && $page == 'subscribers' ? 'open' : ''}}"">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                <i class="icon icon-user-o icon-fw icon-xl"></i> <span class="dt-side-nav__text">Subscribers Management</span> </a>

                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                <li class="dt-side-nav__item">
                    <a href="{{route('plan.subscribers')}}" class="dt-side-nav__link">
                    <i class="icon icon-listing-dbrd icon-fw icon-sm"></i>  <span class="dt-side-nav__text">List Subscribers</span> </a>
                </li>
                </ul>
                <!-- /sub-menu -->
            </li>
          <!-- /menu item -->
        </ul>
        <!-- /sidebar navigation -->

      </div>
    </aside>
    <!-- /sidebar -->
