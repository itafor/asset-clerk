@extends('new.layouts.app', ['title' => 'Dashboard', 'page' => 'dashboard'])

@section('content')
<style type="text/css">
/*basic reset*//*
* {margin: 0; padding: 0;}*/

/*form styles*/
#msform {
    width: 800px;
    margin: 5px auto;
    text-align: center;
    position: relative;
}
/*progressbar*/
#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    /*CSS counters to number the steps*/
    counter-reset: step;
}
#progressbar li {
    list-style-type: none;
    color: #003366;
    /*text-transform: uppercase;*/
    font-size: 14px;
    width: 15%;
    float: left;
    position: relative;
}
#progressbar li:before {
    content: counter(step);
    counter-increment: step;
    width: 20px;
    line-height: 20px;
    display: block;
    font-size: 10px;
    color: #333;
    /*background: white;*/
    border-radius: 3px;
    margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: white;
    position: absolute;
    left: -50%;
    top: 9px;
    z-index: -1; /*put it behind the numbers*/
}
#progressbar li:first-child:after {
    /*connector not needed before the first step*/
    content: none; 
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
    background: #27AE60;
    color: white;
}

a { color: inherit; } 

.activ{
    background: #003366;
    border-radius: 5px;
}

#progressbar .activ:before {
    color: #ffffff;
}
.recordButtons{
  background: #524FEC;
  width: auto;
  height: 40px;
}
</style>
<div style="text-align: center; margin-bottom: 10px;">
               <a href="{{route('landlord.create')}}"> <button class="btn btn-success recordButtons">Add Landlord</button></a>
              <a href="{{route('asset.create')}}">  <button class="btn btn-success recordButtons">Add Asset</button></a>
              <a href="{{route('tenant.create')}}">   <button class="btn btn-success recordButtons">Add Tenants</button></a>
               <a href="{{route('allocation.create')}}">   <button class="btn btn-success recordButtons">Add Allocation</button></a>
              <a href="{{route('allocation.view')}}">  <button class="btn btn-success recordButtons">Add Rental</button></a>
               <a href="{{route('asset.service.create.rental')}}">  <button class="btn btn-success recordButtons">Add Service Charge</button></a>
          </div>


    <div class="row">

        <div class="col-xl-4 col-sm-6">

            <div class="dt-card text-white bg-gradient-blue">
			
						  <!-- Card Body -->
                <div class="dt-card__body p-4">
                
                <!-- Media -->
               
                <div class="media">

                    <i class="icon icon-company icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getTotalAssets())}}</h2>
                    <p class="mb-0">Active Tenants</p>
                    </div>
                    <!-- /media body -->

                </div>
              
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
              
                <div class="media">

                    <i class="icon icon-card icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                        <p class="mb-0">Due Payments</p>
                    <h2 class="mb-1 h1 font-weight-semibold text-white">
                        {{number_format(getDuePayments(false),2)}}
                    </h2>
                    <!-- <p class="mb-0">No. of Tenants: {{number_format(getDebtors())}}</p> -->
                    </div>
                    <!-- /media body -->

                </div>
               
                <hr>
               
                <div class="media">

                    <i class="icon icon-card icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                        <p class="mb-0">Past Due Payments</p>
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getDuePayments(true),2)}}</h2>
                    <!-- <p class="mb-0">No. of Tenants: {{number_format(getDebtors(true))}}</p> -->
                    </div>
                    <!-- /media body -->

                </div>
              
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

   <!--  <div class="row"> -->
         <!-- Grid Item -->
        <!-- <div class="col-xl-12 ">
 -->
            <!-- Card -->
        <!--     <div class="dt-card dt-card__full-height">
            
            <div class="dt-card__body">
                <div class="table-responsive">
                    <h2>Upcoming Due Rents</h2>
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th scope="">NO.</th>
                                <th scope="">Tenant</th>
                                <th scope="col">Property</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Days Left</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rentalsDueInNextThreeMonths as $rental)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$rental->tenant ? $rental->tenant->name() : ''}}</td>
                                    <td>{{$rental->asset ? $rental->asset->description : ''}}</td>
                                    <td>&#8358; {{number_format($rental->price,2)}}</td>
                                    <td>&#8358; {{number_format($rental->balance,2)}}</td>
                                    <td>{{getNextRentPayment($rental)['due_date']}}</td>
                                     <td>{{$rental->remaingdays}} {{$rental->remaingdays > 1 ? 'days' : 'day'}}</td>
                                    

                            <td>
                           @if ($rental->status == 'Partly paid' )
                           <span class="text-warning">{{$rental->status}}</span>

                           @elseif($rental->status == 'Paid')
                           <span class="text-success">{{$rental->status}}</span> 

                            @else
                           <span class="text-danger">{{$rental->status}}</span>
                           @endif

                          </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
           

            </div>
 -->            <!-- /card -->

        <!-- </div> -->
        <!-- /grid item -->
   <!--  </div> -->






    <div class="row">
         <!-- Grid Item -->
        <div class="col-xl-12 ">

            <!-- Card -->
            <div class="dt-card dt-card__full-height">

          
            <!-- Card Body -->
            <div class="dt-card__body">
                <div class="table-responsive">
                    <h2>Upcoming Rents</h2>
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th scope="">Tenant</th>
                                <th scope="col">Property</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">State</th>
                                <th class="text-center"><b>Action</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($renewedRentals as $rental)
                                <tr>
                                    <td>{{$rental->tenant ? $rental->tenant->name() : ''}}</td>
                                    <td>{{$rental->asset ? $rental->asset->description : ''}}</td>
                                    <td>&#8358; {{number_format($rental->amount,2)}}</td>
                                    <td>{{getNextRentPayment($rental)['due_date']}}</td>
                                        <td>
                            
                           @if ($rental->status == 'Partly paid' )
                           <span class="text-warning">{{$rental->status}}</span>

                           @elseif($rental->status == 'Paid')
                           <span class="text-success">{{$rental->status}}</span> 

                            @else
                           <span class="text-danger">{{$rental->status}}</span>
                           @endif

                          </td>
                          <td>
                              @if ($rental->new_rental_status == 'New' )
                           <span class="text-success">{{$rental->new_rental_status}}</span>
                            @elseif ($rental->new_rental_status == 'Cancelled' )
                           <span class="text-danger">{{$rental->new_rental_status}}</span>
                           @else
                           <span class="text-white"></span>
                           @endif 

                          </td>


                          <td class="text-center">
                              <div class="dropdown">
                                  <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Action
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">


                            @if ($rental->new_rental_status == 'New' )

                                    <a href="{{ route('rental.edit', ['uuid'=>$rental->uuid]) }}" class="dropdown-item">Edit</a>
                                    @endif
                                    <!--   <form action="{{ route('rental.delete', ['uuid'=>$rental->uuid]) }}" method="get">
                                          
                                          <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete?") }}') ? this.parentElement.submit() : ''">
                                              {{ __('Delete') }}
                                          </button>
                                      </form> 
 -->                                  </div>
                              </div>
                          </td>
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
<!-- jQuery -->
<script src="http://thecodeplayer.com/uploads/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<!-- jQuery easing plugin -->
<script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>