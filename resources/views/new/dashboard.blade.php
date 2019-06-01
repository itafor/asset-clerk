@extends('new.layouts.app', ['title' => 'Dashboard', 'page' => 'dashboard'])

@section('content')
    <div class="row">

    </div>
    <div class="row">

        <!-- Grid Item -->
        <div class="col-xl-4 col-sm-4">

            <!-- Card -->
            <div class="dt-card dt-card__full-height">

            <!-- Card Body -->
            <div class="dt-card__body bg-gradient-orange text-white">
                <!-- Media -->
                <a href="{{route('asset.index')}}">
                    <div class="media">
                        <i class="icon icon-company text-geekblue icon-5x mr-6 align-self-center"></i>

                        <!-- Media Body -->
                        <div class="media-body">
                            <h2 class="display-3 font-weight-semibold text-white init-counter">{{number_format(getTotalAssets())}}</h2>
                            <span class="d-block text-white">Active Properties</span>
                        </div>
                        <!-- /media body -->
                    </div>
                    <hr>
                    <div class="media">
                        <i class="icon icon-company text-primary icon-5x mr-6 align-self-center"></i>

                        <!-- Media Body -->
                        <div class="media-body">
                            <h2 class="display-3 font-weight-semibold mb-1 text-white init-counter">{{number_format(getSlots()['totalSlots'])}}</h2>
                            <span class="d-block text-white">Total Slots</span>
                        </div>
                        <!-- /media body -->
                    </div>
                    <hr>
                    <div class="media">

                        <i class="icon icon-company text-geekblue icon-5x mr-6 align-self-center"></i>

                        <!-- Media Body -->
                        <div class="media-body">
                            <h2 class="display-3 font-weight-semibold mb-1 text-white init-counter">{{number_format(getSlots()['availableSlots'])}}</h2>
                            <span class="d-block text-white">Available Slots</span>
                        </div>
                        <!-- /media body -->

                    </div>
                </a>
                <!-- /media -->
            </div>
            <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->

        <!-- Grid Item -->
        <div class="col-xl-4 col-sm-4">

            <!-- Card -->
            <div class="dt-card dt-card__full-height bg-gradient-orange">

            <!-- Card Body -->
            <div class="dt-card__body">
                <!-- Media -->
                <a href="{{route('tenant.index')}}">
                <div class="media">

                <i class="icon icon-user-o text-white icon-5x mr-6 align-self-center"></i>

                <!-- Media Body -->
                <div class="media-body">
                    <h2 class="display-3 font-weight-semibold mb-1 text-white init-counter">{{number_format(getTotalTenants())}}</h2>
                    <span class="d-block text-white">Tenants</span>
                </div>
                <!-- /media body -->

                </div>
                </a>
                <hr>
                <a href="{{route('landlord.index')}}">
                <div class="media">

                <i class="icon icon-user-o text-geekblue icon-5x mr-6 align-self-center"></i>

                <!-- Media Body -->
                <div class="media-body">
                    <h2 class="display-3 font-weight-semibold mb-1 text-white init-counter">{{number_format(getTotalLandlords())}}</h2>
                    <span class="d-block text-white">Landlords</span>
                </div>
                <!-- /media body -->

                </div>
                </a>
                <hr>
                <a href="{{route('subs.index')}}">
                <div class="media">

                <i class="icon icon-user-o text-white icon-5x mr-6 align-self-center"></i>

                <!-- Media Body -->
                <div class="media-body">
                    <h2 class="display-3 font-weight-semibold text-white mb-1 init-counter">{{number_format(getTotalAgents())}}</h2>
                    <span class="d-block text-white">Agents</span>
                </div>
                <!-- /media body -->

                </div>
                </a>
                <!-- /media -->
            </div>
            <!-- /card body -->

            </div>
            <!-- /card -->

        </div>

        <!-- Grid Item -->
        <div class="col-xl-4 col-sm-4">

            <!-- Card -->
            <div class="dt-card dt-card__full-height">

                <!-- Card Body -->
                <div class="dt-card__body bg-gradient-orange">
                    <!-- Media -->
                    <div class="media">
                        <i class="icon icon-card display-5 icon-5x mr-6 align-self-center"></i>

                        <!-- Media Body -->
                        <div class="media-body">
                            <div style="float: left">
                                <span class="d-block display-5" style="font-size:16px">Due Payments</span>
                                <h2 class="display-5 text-white font-weight-semibold mb-1 init-counter">{{number_format(getDuePayments(),2)}}</h2>
                                <span class="d-block display-5">No. of Tenants: {{number_format(getDebtors())}}</span>
                            </div>

                            <div style="float:right">
                                <a href="{{route('payment.index')}}" class="btn btn-warning text-white">View Payments</a>
                            </div>
                        </div>
                        <!-- /media body -->
                    </div>
                    <!-- /media -->
                    <hr>
                    <!-- Media -->
                    <div class="media">
                        <i class="icon icon-card display-5 icon-5x mr-6 align-self-center"></i>

                        <!-- Media Body -->
                        <div class=" media-body">
                            <div style="float:left">
                                <span class="d-block display-5" style="font-size:16px">Past Due Payments</span>
                                <h2 class="display-5 text-white font-weight-semibold mb-1 init-counter">{{number_format(getDuePayments(true),2)}}</h2>
                                <span class="d-block display-5">No. of Tenants: {{number_format(getDebtors(true))}}</span>
                            </div>

                            <div style="float:right">
                                <a href="{{route('payment.index')}}" class="btn btn-warning text-white">View Payments</a>
                            </div>
                        </div>
                        <!-- /media body -->
                    </div>
                    <!-- /media -->
                    <hr>
                    <!-- Media -->
                    <div class="media">
                        <i class="icon icon-card display-5 icon-5x mr-6 align-self-center"></i>

                        <!-- Media Body -->
                        <div class=" media-body">
                            <div style="float:left">
                                <span class="d-block display-5" style="font-size:16px"><b>Collections</b></span>
                                <span class="d-block display-5 mb-2">Current Month: &#8358; 34,000,000.00</span>
                                <span class="d-block display-5 mb-2">Commission: &#8358; 1,700,000.00</span>
                            </div>
                        </div>
                        <!-- /media body -->
                    </div>
                    <!-- /media -->
                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->

    </div>
    <div class="row">
        <div class="col-xl-12 col-sm-12">

            <!-- Card -->
            <div class="dt-card dt-card__full-height">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <!-- Media -->
                @include('subscription')
                <!-- /media -->
                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
    </div>

    <div class="row">
         <!-- Grid Item -->
        <div class="col-xl-12 ">

            <!-- Card -->
            <div class="dt-card dt-card__full-height">

            <!-- Card Body -->
            <div class="dt-card__body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th scope="">Tenant</th>
                                <th scope="col">Property</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rentals as $rental)
                                <tr>
                                    <td>{{$rental->tenant->name()}}</td>
                                    <td>{{$rental->asset->description}}</td>
                                    <td>&#8358; {{number_format($rental->price,2)}}</td>
                                    <td>{{getNextRentPayment($rental)['due_date']}}</td>
                                    <td>{{getNextRentPayment($rental)['status']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->
    </div>

    <div class="row">
         <!-- Grid Item -->
        <div class="col-xl-12 ">

            <!-- Card -->
            <div class="dt-card dt-card__full-height">

            <!-- Card Body -->
            <div class="dt-card__body">
                <h3>Recent Activities</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th scope="">Tenant</th>
                                <th scope="col">Property</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rentalsDue as $rental)
                                <tr>
                                    <td>{{$rental->tenant->name()}}</td>
                                    <td>{{$rental->asset->description}}</td>
                                    <td>&#8358; {{number_format($rental->price,2)}}</td>
                                    <td>{{getNextRentPayment($rental)['due_date']}}</td>
                                </tr>
                            @endforeach
                            @foreach ($rentalsDueNotPaid as $rental)
                                <tr>
                                    <td>{{$rental->tenant->name()}}</td>
                                    <td>{{$rental->asset->description}}</td>
                                    <td>&#8358; {{number_format($rental->price,2)}}</td>
                                    <td>{{getNextRentPayment($rental)['due_date']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->
    </div>
@endsection