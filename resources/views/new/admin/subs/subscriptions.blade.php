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
                                    <div class="col-xl-4">

                                        <!-- Pricing -->
                                        <div class="dt-pricing dt-pricing-classic bg-light-yellow">

                                            <!-- Pricing header -->
                                            <div class="dt-pricing__header bg-yellow">
                                                <h2 class="dt-price">&#x20A6;5,000/month</h2>
                                                <p class="dt-letter-spacing-base text-uppercase mb-0">Silver</p>
                                            </div>
                                            <!-- /pricing header -->

                                            <!-- Pricing body -->
                                            <div class="dt-pricing__body">

                                                <ul class="dt-pricing-items">
                                                    <li><i class="icon icon-fw icon-company mr-3"></i>Manage 20
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
                                                    <a href="{{ url('buy-plan/5ca8edad-1878-47f2-a868-8af143b06212') }}">
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
                                    <div class="col-xl-4">

                                        <!-- Pricing -->
                                        <div class="dt-pricing dt-pricing-classic dt-highlight bg-light-primary">

                                            <!-- Pricing header -->
                                            <div class="dt-pricing__header bg-primary">
                                                <h2 class="dt-price text-white">&#x20A6;10,000/month</h2>
                                                <p class="dt-letter-spacing-base text-white text-uppercase mb-0">
                                                    Gold</p>
                                            </div>
                                            <!-- /pricing header -->

                                            <!-- Pricing body -->
                                            <div class="dt-pricing__body text-white">

                                                <ul class="dt-pricing-items">
                                                    <li><i class="icon icon-company icon-fw mr-3"></i>Manage 50
                                                        Properties
                                                    </li>
                                                    <li><i class="icon icon-fw icon-user mr-3"></i>Manage 20
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
                                                    <a href="{{ url('buy-plan/32abf0fb-0511-41d9-9065-bfd09a6d5dc8') }}">
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
                                    <div class="col-xl-4">

                                        <!-- Pricing -->
                                        <div class="dt-pricing dt-pricing-classic bg-light-success">

                                            <!-- Pricing header -->
                                            <div class="dt-pricing__header bg-success">
                                                <h2 class="dt-price">&#x20A6;20,000/month</h2>
                                                <p class="dt-letter-spacing-base text-uppercase mb-0">Platinum</p>
                                            </div>
                                            <!-- /pricing header -->

                                            <!-- Pricing body -->
                                            <div class="dt-pricing__body">

                                                <ul class="dt-pricing-items">
                                                    <li><i class="icon icon-company icon-fw mr-3"></i>Manage 100
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
                                                    <a href="{{ url('buy-plan/3de72654-dbab-469f-b550-1b6860950e1e') }}">
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