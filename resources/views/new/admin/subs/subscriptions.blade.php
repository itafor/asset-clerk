@extends('new.layouts.app', ['title' => 'List of Sub Accounts', 'page' => 'sub_account'])

@section('content')
    <!-- Page Header -->
    <div class="dt-page__header">
        <h1 class="dt-page__title"><i class="icon icon-user-o"></i> Subscriptions</h1>
    </div>
    <!-- /page header -->

    <!-- Grid -->
    <div class="row">

        <!-- Grid Item -->
        <div class="col-xl-12">

            <!-- Entry Header -->
            <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Compare Packages</h3>
                </div>
                <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">

                    <div class="col-12">

                        <!-- Card -->
                        <div class="card border shadow-none rounded">

                            <!-- Card header -->
                        {{--
                                                  <h3 class="card-header border-bottom bg-transparent">Classic</h3>
                        --}}
                        <!-- /card header -->

                            <!-- Card Body -->
                            <div class="card-body">

                                <!-- Grid -->
                                <div class="row">

                                    <!-- Grid item -->
                                    <div class="col-xl-3">

                                        <!-- Pricing -->
                                        <div class="dt-pricing dt-pricing-classic bg-light-yellow">

                                            <!-- Pricing header -->
                                            <div class="dt-pricing__header bg-yellow">
                                                <h2 class="dt-price">&#x20A6;50,000/ annum</h2>
                                                <p class="dt-letter-spacing-base text-uppercase mb-0">Standard</p>
                                            </div>
                                            <!-- /pricing header -->

                                            <!-- Pricing body -->
                                            <div class="dt-pricing__body">

                                                <ul class="dt-pricing-items">
                                                    <li><i class="icon icon-fw icon-company mr-3"></i>Manage 50
                                                        Properties
                                                    </li>
                                                    <li><i class="icon icon-fw icon-user mr-3"></i>Manage 1
                                                        Sub-Accounts
                                                    </li>
                                                    <li><i class="icon icon-fw icon-user-o mr-3"></i>Manage Unlimited
                                                        Tenants
                                                    </li>
                                                    <li><i class="icon icon-fw icon-company mr-3"></i>Manage Unlimited
                                                        Rents
                                                    </li>
                                                </ul>

                                                <div class="pt-7">
                                                    <a href="{{ url('buy-plan/2312ad45-4c64-46c5-a71e-58f091044927') }}">
                                                        <button class="btn btn-primary" type="button">Upgrade Now
                                                        </button>
                                                    </a>
                                                </div>

                                            </div>
                                            <!-- /pricing body -->

                                        </div>
                                        <!-- /pricing -->

                                    </div>
                                    <!-- /grid item -->

                                    <!-- Grid item -->
                                    <div class="col-xl-3">

                                        <!-- Pricing -->
                                        <div class="dt-pricing dt-pricing-classic bg-light-primary">

                                            <!-- Pricing header -->
                                            <div class="dt-pricing__header bg-primary">
                                                <h2 class="dt-price text-white">&#x20A6;150,000/annum</h2>
                                                <p class="dt-letter-spacing-base text-white text-uppercase mb-0">
                                                    Professional</p>
                                            </div>
                                            <!-- /pricing header -->

                                            <!-- Pricing body -->
                                            <div class="dt-pricing__body text-white">

                                                <ul class="dt-pricing-items">
                                                    <li><i class="icon icon-company icon-fw mr-3"></i>Manage 250
                                                        Properties
                                                    </li>
                                                    <li><i class="icon icon-fw icon-user mr-3"></i>Manage 5
                                                        Sub-Accounts
                                                    </li>
                                                    <li><i class="icon icon-fw icon-user-o mr-3"></i>Manage Unlimited
                                                        Tenants
                                                    </li>
                                                    <li><i class="icon icon-fw icon-company mr-3"></i>Manage Unlimited
                                                        Rents
                                                    </li>
                                                </ul>

                                                <div class="pt-7">
                                                    <a href="{{ url('buy-plan/aee1bfa9-1f68-4036-a602-11dbf7bcdc34') }}">
                                                        <button class="btn btn-primary" type="button">Upgrade Now
                                                        </button>
                                                    </a>
                                                </div>

                                            </div>
                                            <!-- /pricing body -->

                                        </div>
                                        <!-- /pricing -->

                                    </div>
                                    <!-- /grid item -->

                                    <!-- Grid item -->
                                    <div class="col-xl-3">

                                        <!-- Pricing -->
                                        <div class="dt-pricing dt-pricing-classic bg-light-success">

                                            <!-- Pricing header -->
                                            <div class="dt-pricing__header bg-success">
                                                <h2 class="dt-price">&#x20A6;300,000/annum</h2>
                                                <p class="dt-letter-spacing-base text-uppercase mb-0">Premium</p>
                                            </div>
                                            <!-- /pricing header -->

                                            <!-- Pricing body -->
                                            <div class="dt-pricing__body">

                                                <ul class="dt-pricing-items">
                                                    <li><i class="icon icon-company icon-fw mr-3"></i>Manage 750
                                                        Properties
                                                    </li>
                                                    <li><i class="icon icon-fw icon-user mr-3"></i>Manage 10
                                                        Sub-Accounts
                                                    </li>
                                                    <li><i class="icon icon-fw icon-user-o mr-3"></i>Manage Unlimited
                                                        Tenants
                                                    </li>
                                                    <li><i class="icon icon-fw icon-company mr-3"></i>Manage Unlimited
                                                        Rents
                                                    </li>
                                                </ul>

                                                <div class="pt-7">
                                                    <a href="{{ url('buy-plan/5aae1947-eb88-4d18-81d9-7774fdc600ef') }}">
                                                        <button class="btn btn-primary" type="button">Upgrade Now
                                                        </button>
                                                    </a>
                                                </div>

                                            </div>
                                            <!-- /pricing body -->

                                        </div>
                                        <!-- /pricing -->

                                    </div>
                                    <!-- /grid item -->

                                    <!-- Grid item -->
                                    <div class="col-xl-3">

                                        <!-- Pricing -->
                                        <div class="dt-pricing dt-pricing-classic bg-light-success">

                                            <!-- Pricing header -->
                                            <div class="dt-pricing__header bg-success">
                                                <h2 class="dt-price">&#x20A6;500,000/annum</h2>
                                                <p class="dt-letter-spacing-base text-uppercase mb-0">Premium Plus</p>
                                            </div>
                                            <!-- /pricing header -->

                                            <!-- Pricing body -->
                                            <div class="dt-pricing__body">

                                                <ul class="dt-pricing-items">
                                                    <li><i class="icon icon-company icon-fw mr-3"></i>Manage Unlimited
                                                        Properties
                                                    </li>
                                                    <li><i class="icon icon-fw icon-user mr-3"></i>Manage 50
                                                        Sub-Accounts
                                                    </li>
                                                    <li><i class="icon icon-fw icon-user-o mr-3"></i>Manage Unlimited
                                                        Tenants
                                                    </li>
                                                    <li><i class="icon icon-fw icon-company mr-3"></i>Manage Unlimited
                                                        Rents
                                                    </li>
                                                </ul>

                                                <div class="pt-7">
                                                    <a href="{{ url('buy-plan/2618ece9-1f73-4282-9ddc-059c2359d99e') }}">
                                                        <button class="btn btn-primary" type="button">Upgrade Now
                                                        </button>
                                                    </a>
                                                </div>

                                            </div>
                                            <!-- /pricing body -->

                                        </div>
                                        <!-- /pricing -->

                                    </div>
                                    <!-- /grid item -->

                                </div>
                                <!-- /grid -->

                            </div>
                            <!-- /card body -->

                        </div>
                        <!-- /card -->

                    </div>

                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->

    </div>
    <!-- /grid -->
@endsection