@extends('new.layouts.app', ['title' => 'Dashboard', 'page' => 'dashboard'])

@section('content')
    <div class="row">

        <div class="col-xl-4 col-sm-6">

            <div class="dt-card text-white bg-gradient-blue">
			
						  <!-- Card Body -->
                <div class="dt-card__body p-4">
                
                <!-- Media -->
                <a href="{{route('asset.index')}}" style="color:#fff">
                <div class="media">

                    <i class="icon icon-company icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getTotalAssets())}}</h2>
                    <p class="mb-0">Active Tenants</p>
                    </div>
                    <!-- /media body -->

                </div>
                </a>
                <hr>
                <div class="media">

                    <i class="icon icon-company icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    @if (getSlots()['totalSlots'] == 'Unlimited')
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{getSlots()['totalSlots']}}</h2>
                    @else
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getSlots()['totalSlots'])}}</h2>
                    @endif
                    <p class="mb-0">Total Assets</p>
                    </div>
                    <!-- /media body -->

                </div>
                <!-- /media -->
                <hr>
                <div class="media">

                    <i class="icon icon-company icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    @if (getSlots()['availableSlots'] == 'Unlimited')
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{getSlots()['availableSlots']}}</h2>
                    @else
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getSlots()['availableSlots'])}}</h2>
                    @endif
                    <p class="mb-0">Available Assets</p>
                    </div>
                    <!-- /media body -->

                </div>
                <!-- /media -->

                </div>
                <!-- /card body -->
            </div>
        </div>

        <div class="col-xl-4 col-sm-6">

            <div class="dt-card text-white bg-gradient-purple">
			
						  <!-- Card Body -->
                <div class="dt-card__body p-4">
                
                <!-- Media -->
                <a href="{{route('tenant.index')}}" style="color:#fff">
                <div class="media">

                    <i class="icon icon-user-o icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getTotalTenants())}}</h2>
                    <p class="mb-0">Tenants</p>
                    </div>
                    <!-- /media body -->

                </div>
                </a>
                <hr>
                <a href="{{route('landlord.index')}}" style="color:#fff">
                <div class="media">

                    <i class="icon icon-user-o icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getTotalLandlords())}}</h2>
                    <p class="mb-0">Landlords</p>
                    </div>
                    <!-- /media body -->

                </div>
                </a>
                <!-- /media -->
                <hr>
                <a href="{{route('subs.index')}}" style="color:#fff">
                <div class="media">

                    <i class="icon icon-user-o icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getTotalAgents())}}</h2>
                    <p class="mb-0">Agents</p>
                    </div>
                    <!-- /media body -->

                </div>
                </a>
                <!-- /media -->

                </div>
                <!-- /card body -->
            </div>
        </div>

        <div class="col-xl-4 col-sm-6">

            <div class="dt-card text-white bg-gradient-blueberry" style="min-height:242px">
			
						  <!-- Card Body -->
                <div class="dt-card__body p-4">
                
                <!-- Media -->
                <a href="{{route('payment.index')}}" style="color:#fff">
                <div class="media">

                    <i class="icon icon-card icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                        <p class="mb-0">Due Payments</p>
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getTotalTenants())}}</h2>
                    <p class="mb-0">No. of Tenants: {{number_format(getDebtors())}}</p>
                    </div>
                    <!-- /media body -->

                </div>
                </a>
                <hr>
                <a href="{{route('landlord.index')}}" style="color:#fff">
                <div class="media">

                    <i class="icon icon-card icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                        <p class="mb-0">Past Due Payments</p>
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getDuePayments(true),2)}}</h2>
                    <p class="mb-0">No. of Tenants: {{number_format(getDebtors(true))}}</p>
                    </div>
                    <!-- /media body -->

                </div>
                </a>
                <!-- /media -->

                </div>
                <!-- /card body -->
            </div>
        </div>
        

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