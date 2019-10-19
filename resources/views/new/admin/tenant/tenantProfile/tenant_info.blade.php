@extends('new.layouts.app', ['title' => 'Update Profile', 'page' => 'profile'])

@section('content')
<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 100%;
 margin-top: -15px;
  height: 50px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
  }
}
</style>
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-user-o"></i> {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}}'s Profile</h1>
        </div>
        <!-- /page header -->

        <!-- Grid -->
        <div class="row">

            <!-- Grid Item -->
            <div class="col-xl-6">

                <!-- Entry Header -->
                <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Tenant Profile</h3>
                </div>
                <!-- /entry heading -->

                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card" style="height: auto;">

                    <!-- Card Body -->
                    <div class="dt-card__body">
                       
<div class="col-md-12 pull-left">
    <div class="image-container">
<img src="{{$tenantDetail->photo}}}}" class="profile-image">
<div class="title">
<h2>{{$tenantDetail->firstname}}</h2>
</div>
</div>
<div class="row">
   <table class="table align-items-center table-flush">
      <tr><td>Full Name:</td>
        <td>
      {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}}
        </td>
    </tr>

 <tr><td>Gender:</td>
        <td>
       {{$tenantDetail->gender}}
        </td>
    </tr>

     <tr><td> Date Of Birth:</td>
        <td>
      {{$tenantDetail->date_of_birth}}
        </td>
    </tr>

    <tr><td> Phone: </td>
        <td>
      {{$tenantDetail->phone}}
        </td>
    </tr>
    <tr><td> Email: </td>
        <td>
      {{$tenantDetail->email}}
        </td>
    </tr>

    <tr><td>  Occupation:  </td>
        <td>
    {{$tenantDetail->occupation}}
        </td>
    </tr>

     <tr><td>  Address:  </td>
        <td>
     {{$tenantDetail->address}}
        </td>
    </tr>

     <tr><td>  Country:  </td>
        <td>
    {{$tenantDetail->countryName}}
        </td>
    </tr>
     <tr><td>  State:  </td>
        <td>
    {{$tenantDetail->stateName}}
        </td>
    </tr>

     <tr><td>  City:  </td>
        <td>
   {{$tenantDetail->cityName}}
        </td>
    </tr>
   </table>
</div>
</div>

                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->

            </div>
            <!-- /grid item -->
            <!-- Grid Item -->
            <div class="col-xl-6">

                <!-- Entry Header -->
                <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Other Details</h3>
                </div>
                <!-- /entry heading -->

                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card" style="height: 500px;">

                    <!-- Card Body -->
                    <div class="dt-card__body">
                       <h4>Outstanding Asset Service Charge balance:
                         <span style="color: gray; font-family: monospace; font-size: 16px;">
                            &#8358; {{number_format($tenantTotalDebt,2)}}
                        </span>
                        </h4> 
                        <table class="table align-items-center table-flush">
                            <tr><td>Unpaid Service Charges:</td>
                                <td>
                                    <a href="#" class="" data-toggle="modal" data-target=".tenant-service-charges"> 
                                 View details
                             </a>

                            
                                </td>
                            </tr>

                            <tr><td>Service Charge Payment Histories:</td>
                                <td>
                                    <a href="#"  data-toggle="modal" data-target=".tenantSCPaymentHistory">
                                    View details 
                                      </a>
                                
                              </td>
                            </tr>

                             <tr><td>Service Charge Wallet History:</td>
                                <td><a href="#" data-toggle="modal" data-target=".bd-example-modal-xl">   View details</a>
                                </td>
                            </tr>

                            <tr><td>Tenant Rents:</td>
                                <td><a href="#">   View details</a></td>
                            </tr>

                            <tr><td>Tenant Referals:</td>
                                <td><a href="#">   View details</a></td>
                            </tr>

                            <tr><td>Tenant Maintaince:</td>
                                <td><a href="#">   View details</a></td>
                            </tr>
                        </table>
                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->

            </div>
            <!-- /grid item -->
 @include('new.admin.tenant.tenantProfile.partials.tenant_service_charges')
 @include('new.admin.tenant.tenantProfile.partials.tenant_sc_payment_history')
 @include('new.admin.tenant.tenantProfile.partials.tenant_sc_wallet_history')



        </div>
        <!-- /grid -->
@endsection