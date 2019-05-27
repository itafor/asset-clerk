<!-- Header -->
  <header class="dt-header">

    <!-- Header container -->
    <div class="dt-header__container">

      <!-- Brand -->
      <div class="dt-brand" style="background: #ffffff">

        <!-- Brand tool -->
        <div class="dt-brand__tool" data-toggle="main-sidebar">
          <i class="icon icon-xl icon-menu-fold d-none d-lg-inline-block"></i>
          <i class="icon icon-xl icon-menu d-lg-none"></i>
        </div>
        <!-- /brand tool -->

        <!-- Brand logo -->
        <span class="dt-brand__logo">
        <a class="dt-brand__logo-link" href="{{route('home')}}">
          <img class="dt-brand__logo-img d-none d-lg-inline-block" src="{{url('img/logo.png')}}" alt="Asset Clerk">
          <img class="dt-brand__logo-symbol d-lg-none" src="{{url('img/logo.png')}}" alt="Asset Clerk">
        </a>
      </span>
        <!-- /brand logo -->

      </div>
      <!-- /brand -->

      <!-- Header toolbar-->
      <div class="dt-header__toolbar">

        <!-- Search box -->
        {{-- <form class="search-box d-none d-lg-block">
          <input class="form-control border-0" placeholder="Search in app..." value="" type="search">
          <span class="search-icon text-light-gray"><i class="icon icon-search icon-lg"></i></span>
        </form> --}}
        <!-- /search box -->

        <!-- Header Menu Wrapper -->
        <div class="dt-nav-wrapper">
          <!-- Header Menu -->
          <ul class="dt-nav d-lg-none">
            {{-- <li class="dt-nav__item dt-notification-search dropdown">

              <!-- Dropdown Link -->
              <a href="#" class="dt-nav__link dropdown-toggle no-arrow" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false"> <i class="icon icon-search-new icon-fw icon-lg"></i> </a>
              <!-- /dropdown link -->

              <!-- Dropdown Option -->
              <div class="dropdown-menu">

                <!-- Search Box -->
                <form class="search-box right-side-icon">
                  <input class="form-control form-control-lg" type="search" placeholder="Search in app...">
                  <button type="submit" class="search-icon"><i class="icon icon-search icon-lg"></i></button>
                </form>
                <!-- /search box -->

              </div>
              <!-- /dropdown option -->

            </li> --}}
          </ul>
          <!-- /header menu -->

          <!-- Header Menu -->
          {{-- <ul class="dt-nav d-lg-none">
            <li class="dt-nav__item dt-notification dropdown">

              <!-- Dropdown Link -->
              <a href="#" class="dt-nav__link dropdown-toggle no-arrow" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false"> <i class="icon icon-notification icon-fw dt-icon-alert"></i>
              </a>
              <!-- /dropdown link -->

              <!-- Dropdown Option -->
              <div class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                <!-- Dropdown Menu Header -->
                <div class="dropdown-menu-header">
                  <h4 class="title">Notifications (9)</h4>

                  <div class="ml-auto action-area">
                    <a href="javascript:void(0)">Mark All Read</a> <a class="ml-2" href="javascript:void(0)">
                    <i class="icon icon-setting icon-lg text-light-gray"></i> </a>
                  </div>
                </div>
                <!-- /dropdown menu header -->

                <!-- Dropdown Menu Body -->
                <div class="dropdown-menu-body ps-custom-scrollbar">

                  <div class="h-auto">
                    <!-- Media -->
                    <a href="javascript:void(0)" class="media">

                      <!-- Avatar -->
                      <img class="dt-avatar mr-3" src="https://via.placeholder.com/150x150" alt="User">
                      <!-- avatar -->

                      <!-- Media Body -->
                      <span class="media-body">
                    <span class="message">
                      <span class="user-name">Stella Johnson</span> and <span class="user-name">Chris Harris</span>
                      have birthdays today. Help them celebrate!
                    </span>
                    <span class="meta-date">8 hours ago</span>
                  </span>
                      <!-- /media body -->

                    </a>
                    <!-- /media -->

                    <!-- Media -->
                    <a href="javascript:void(0)" class="media">

                      <!-- Avatar -->
                      <img class="dt-avatar mr-3" src="https://via.placeholder.com/150x150" alt="User">
                      <!-- avatar -->

                      <!-- Media Body -->
                      <span class="media-body">
                    <span class="message">
                      <span class="user-name">Jonathan Madano</span> commented on your post.
                    </span>
                    <span class="meta-date">9 hours ago</span>
                  </span>
                      <!-- /media body -->

                    </a>
                    <!-- /media -->

                    <!-- Media -->
                    <a href="javascript:void(0)" class="media">

                      <!-- Avatar -->
                      <img class="dt-avatar mr-3" src="https://via.placeholder.com/150x150" alt="User">
                      <!-- avatar -->

                      <!-- Media Body -->
                      <span class="media-body">
                    <span class="message">
                      <span class="user-name">Chelsea Brown</span> sent a video recomendation.
                    </span>
                    <span class="meta-date">
                      <i class="icon icon-menu-right text-primary icon-fw mr-1"></i>
                      13 hours ago
                    </span>
                  </span>
                      <!-- /media body -->

                    </a>
                    <!-- /media -->

                    <!-- Media -->
                    <a href="javascript:void(0)" class="media">

                      <!-- Avatar -->
                      <img class="dt-avatar mr-3" src="https://via.placeholder.com/150x150" alt="User">
                      <!-- avatar -->

                      <!-- Media Body -->
                      <span class="media-body">
                    <span class="message">
                      <span class="user-name">Alex Dolgove</span> and <span class="user-name">Chris Harris</span>
                      like your post.
                    </span>
                    <span class="meta-date">
                      <i class="icon icon-like text-light-blue icon-fw mr-1"></i>
                      yesterday at 9:30
                    </span>
                  </span>
                      <!-- /media body -->

                    </a>
                    <!-- /media -->
                  </div>

                </div>
                <!-- /dropdown menu body -->

                <!-- Dropdown Menu Footer -->
                <div class="dropdown-menu-footer">
                  <a href="javascript:void(0)" class="card-link"> See All <i class="icon icon-arrow-right icon-fw"></i>
                  </a>
                </div>
                <!-- /dropdown menu footer -->
              </div>
              <!-- /dropdown option -->

            </li>

            <li class="dt-nav__item dt-notification dropdown">

              <!-- Dropdown Link -->
              <a href="#" class="dt-nav__link dropdown-toggle no-arrow" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false"> <i class="icon icon-chat-new icon-fw"></i> </a>
              <!-- /dropdown link -->

              <!-- Dropdown Option -->
              <div class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                <!-- Dropdown Menu Header -->
                <div class="dropdown-menu-header">
                  <h4 class="title">Messages (6)</h4>

                  <div class="ml-auto action-area">
                    <a href="javascript:void(0)">Mark All Read</a> <a class="ml-2" href="javascript:void(0)">
                    <i class="icon icon-setting icon-lg text-light-gray"></i></a>
                  </div>
                </div>
                <!-- /dropdown menu header -->

                <!-- Dropdown Menu Body -->
                <div class="dropdown-menu-body ps-custom-scrollbar">

                  <div class="h-auto">

                    <!-- Media -->
                    <a href="javascript:void(0)" class="media">

                      <!-- Avatar -->
                      <img class="dt-avatar mr-3" src="https://via.placeholder.com/150x150" alt="User">
                      <!-- avatar -->

                      <!-- Media Body -->
                      <span class="media-body text-truncate">
                    <span class="user-name mb-1">Chris Mathew</span>
                    <span class="message text-light-gray text-truncate">Okay.. I will be waiting for your...</span>
                  </span>
                      <!-- /media body -->

                      <span class="action-area h-100 min-w-80 text-right">
                      <span class="meta-date mb-1">8 hours ago</span>
                        <!-- Toggle Button -->
                      <span class="toggle-button" data-toggle="tooltip" data-placement="left" title="Mark as read">
                        <span class="show"><i class="icon icon-circle-o icon-fw f-10 text-light-gray"></i></span>
                        <span class="hide"><i class="icon icon-circle icon-fw f-10 text-light-gray"></i></span>
                      </span>
                        <!-- /toggle button -->
                    </span> </a>
                    <!-- /media -->

                    <!-- Media -->
                    <a href="javascript:void(0)" class="media">

                      <!-- Avatar -->
                      <img class="dt-avatar mr-3" src="https://via.placeholder.com/150x150" alt="User">
                      <!-- avatar -->

                      <!-- Media Body -->
                      <span class="media-body text-truncate">
                    <span class="user-name mb-1">Alia Joseph</span>
                    <span class="message text-light-gray text-truncate">
                      Alia Joseph just joined Messenger! Be the first to send a welcome message or sticker.
                    </span>
                  </span>
                      <!-- /media body -->

                      <span class="action-area h-100 min-w-80 text-right">
                    <span class="meta-date mb-1">9 hours ago</span>
                        <!-- Toggle Button -->
                      <span class="toggle-button" data-toggle="tooltip" data-placement="left" title="Mark as read">
                        <span class="show"><i class="icon icon-circle-o icon-fw f-10 text-light-gray"></i></span>
                        <span class="hide"><i class="icon icon-circle icon-fw f-10 text-light-gray"></i></span>
                      </span>
                        <!-- /toggle button -->
                  </span> </a>
                    <!-- /media -->

                    <!-- Media -->
                    <a href="javascript:void(0)" class="media">

                      <!-- Avatar -->
                      <img class="dt-avatar mr-3" src="https://via.placeholder.com/150x150" alt="User">
                      <!-- avatar -->

                      <!-- Media Body -->
                      <span class="media-body text-truncate">
                    <span class="user-name mb-1">Joshua Brian</span>
                    <span class="message text-light-gray text-truncate">
                      Alex will explain you how to keep the HTML structure and all that.
                    </span>
                  </span>
                      <!-- /media body -->

                      <span class="action-area h-100 min-w-80 text-right">
                    <span class="meta-date mb-1">12 hours ago</span>
                        <!-- Toggle Button -->
                      <span class="toggle-button" data-toggle="tooltip" data-placement="left" title="Mark as read">
                        <span class="show"><i class="icon icon-circle-o icon-fw f-10 text-light-gray"></i></span>
                        <span class="hide"><i class="icon icon-circle icon-fw f-10 text-light-gray"></i></span>
                      </span>
                        <!-- /toggle button -->
                  </span> </a>
                    <!-- /media -->

                    <!-- Media -->
                    <a href="javascript:void(0)" class="media">

                      <!-- Avatar -->
                      <img class="dt-avatar mr-3" src="https://via.placeholder.com/150x150" alt="User">
                      <!-- avatar -->

                      <!-- Media Body -->
                      <span class="media-body text-truncate">
                    <span class="user-name mb-1">Domnic Brown</span>
                    <span class="message text-light-gray text-truncate">Okay.. I will be waiting for your...</span>
                  </span>
                      <!-- /media body -->

                      <span class="action-area h-100 min-w-80 text-right">
                    <span class="meta-date mb-1">yesterday</span>
                        <!-- Toggle Button -->
                      <span class="toggle-button" data-toggle="tooltip" data-placement="left" title="Mark as read">
                        <span class="show"><i class="icon icon-circle-o icon-fw f-10 text-light-gray"></i></span>
                        <span class="hide"><i class="icon icon-circle icon-fw f-10 text-light-gray"></i></span>
                      </span>
                        <!-- /toggle button -->
                  </span> </a>
                    <!-- /media -->

                  </div>

                </div>
                <!-- /dropdown menu body -->

                <!-- Dropdown Menu Footer -->
                <div class="dropdown-menu-footer">
                  <a href="javascript:void(0)" class="card-link"> See All <i class="icon icon-arrow-right icon-fw"></i>
                  </a>
                </div>
                <!-- /dropdown menu footer -->
              </div>
              <!-- /dropdown option -->

            </li>
          </ul> --}}
          <!-- /header menu -->

          <!-- Header Menu -->
          <ul class="dt-nav">
            <li class="dt-nav__item dropdown">

              <!-- Dropdown Link -->
              <a href="#" class="dt-nav__link dropdown-toggle" data-toggle="dropdown"
                 aria-haspopup="true"
                 aria-expanded="false">
                <i class=""></i><span>Hi {{auth()->user()->fullname()}}</span> </a>
              <!-- /dropdown link -->

              <!-- Dropdown Option -->
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                  <i class="mr-2"></i><span>My Profile</span> </a>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                  <i class="mr-2"></i><span>Change Password</span> </a>
                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                  <i class="mr-2"></i><span>Sign Out</span> </a>
              </div>
              <!-- /dropdown option -->

            </li>
          </ul>
          <!-- /header menu -->

          <!-- Header Menu -->
          <ul class="dt-nav d-lg-none">
            <li class="dt-nav__item dropdown">

              <!-- Dropdown Link -->
              <a href="#" class="dt-nav__link dropdown-toggle no-arrow dt-avatar-wrapper"
                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="dt-avatar size-40" src="{{auth()->user()->image ? auth()->user()->image : 'https://via.placeholder.com/150x150'}}" alt="{{auth()->user()->fullname()}}">
              </a>
              <!-- /dropdown link -->

              <!-- Dropdown Option -->
              <div class="dropdown-menu dropdown-menu-right">
                <div class="dt-avatar-wrapper flex-nowrap p-6 mt--5 bg-gradient-purple text-white rounded-top">
                  <img class="dt-avatar" src="{{auth()->user()->image ? auth()->user()->image : 'https://via.placeholder.com/150x150'}}" alt="{{auth()->user()->fullname()}}">
                  <span class="dt-avatar-info">
                  <span class="dt-avatar-name">{{auth()->user()->fullname()}}</span>
                  <span class="f-12">{{ucwords(auth()->user()->role)}}</span>
                </span>
                </div>
                <a class="dropdown-item" href="{{ route('profile.edit') }}"> <i class="icon icon-user-o icon-fw mr-2 mr-sm-1"></i>Account
                </a> <a class="dropdown-item" href="javascript:void(0)">
                <i class="icon icon-setting icon-fw mr-2 mr-sm-1"></i>Setting </a>
                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"> <i class="icon icon-edit icon-fw mr-2 mr-sm-1"></i>Logout
                </a>
              </div>
              <!-- /dropdown option -->

            </li>
          </ul>
          <!-- /header menu -->

        </div>
        <!-- Header Menu Wrapper -->

      </div>
      <!-- /header toolbar -->

    </div>
    <!-- /header container -->

  </header>
  <!-- /header -->
