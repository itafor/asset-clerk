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
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format($data['properties'])}}</h2>
                    <p class="mb-0">Active Properties</p>
                    </div>
                    <!-- /media body -->

                </div>
                </a>
                <hr>
                <a href="{{route('landlord.index')}}">
                <div class="media">

                    <i class="icon icon-user-o icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format($data['landlords'])}}</h2>
                    <p class="mb-0">Total Landlords</p>
                    </div>
                    <!-- /media body -->

                </div>
                </a>
                <!-- /media -->
                <hr>
                <div class="media">

                    <i class="icon icon-card icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{$data['active_subscriptions']}}</h2>
                    <p class="mb-0">Active Subscriptions</p>
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
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format($data['tenants'])}}</h2>
                    <p class="mb-0">Tenants</p>
                    </div>
                    <!-- /media body -->

                </div>
                </a>
                <hr>
                <div class="media">

                    <i class="icon icon-user-o icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format($data['transactions']['total'])}}</h2>
                    <p class="mb-0">Total Subscriptions</p>
                    </div>
                    <!-- /media body -->

                </div>
                <!-- /media -->
                <hr>
                <a href="{{route('subs.index')}}" style="color:#fff">
                <div class="media">

                    <i class="icon icon-user-o icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format($data['users'])}}</h2>
                    <p class="mb-0">Users</p>
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
        <!-- /grid item -->
    <div class="row">
        <!-- Grid Item -->
        <div class="col-xl-6 ">

            <!-- Card -->
            <div class="dt-card dt-card__full-height">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover datatable">
                            <thead>
                            <tr>
                                <th scope="">Date</th>
                                <th scope="col">Reference</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Channel</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data['transactions']['list'] as $rental)
                                <tr>
                                    <td>{{$rental->created_at}}</td>
                                    <td>{{$rental->reference}}</td>
                                    <td>&#8358; {{number_format($rental->amount,2)}}</td>
                                    <td>{{$rental->status}}</td>
                                    <td>{{$rental->channel}}</td>
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
        <!-- Grid Item -->
        <div class="col-xl-6 ">

            <!-- Card -->
            <div class="dt-card dt-card__full-height">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover datatable">
                            <thead>
                            <tr>
                                <th scope="">S/N</th>
                                <th scope="col">Subscription Plan</th>
                                <th scope="col">No of Users</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i=1 @endphp
                            @foreach ($data['groupings'] as $rental)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$rental->plan}}</td>
                                    <td>{{number_format($rental->count)}}</td>
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