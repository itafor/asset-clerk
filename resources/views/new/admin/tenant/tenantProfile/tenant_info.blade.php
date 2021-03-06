@extends('new.layouts.app', ['title' => 'Tenant Profile', 'page' => 'profile'])

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
          <h1 class="dt-page__title"><i class="icon icon-user-o"></i> 
        Tenant Details Management
          </h1>
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
                    <h3 class="dt-entry__title">Payment Details</h3>
                </div>
                <!-- /entry heading -->

                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card" style="height: 500px;">

                    <!-- Card Body -->
                    <div class="dt-card__body">
                      <strong> Outstanding Service charge:</strong>
                         <span style="color: red;">
                            &#8358; {{number_format($tenantTotalDebt,2)}} 
                        </span>
                      
                        <hr>
                       <strong> Outstanding Rentals: </strong>
                         <span style="color: red;">
                            &#8358; {{number_format($tenantRentalTotalDebt,2)}}
                        </span>
                        
                        <table class="table align-items-center table-flush">

                            <tr><td>Current Wallet Balance:</td>
                                  @if(isset($tenantWalletBal->amount))
                                <td>
                                 &#8358; {{number_format($tenantWalletBal->amount,2)}}
                                </td>
                                @else
                                <td>
                                <span>  &#8358; 0.0 </span>
                                </td>
                                @endif
                            </tr>

                            <tr><td>Unpaid Service Charges:</td>
                                <td>
                                    <a href="#" class="" data-toggle="modal" data-target=".tenant-service-charges"> 
                                 View details
                             </a>

                            
                                </td>
                            </tr>

                            <tr><td>Service Charge Payment History:</td>
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
                                <td><a href="#" data-toggle="modal" data-target=".tenantRents">   View details</a>
                                </td>
                            </tr>

                            <tr><td>Rental Payment History</td>
                                <td><a href="#" data-toggle="modal" data-target=".rentalPaymentHistory">   View details</a>
                                </td>
                            </tr>

                             <tr><td>Unpaid Rental</td>
                                <td><a href="#" data-toggle="modal" data-target=".unpaidRental">   View details</a>
                                </td>
                            </tr>
<!-- 
                            <tr><td>Tenant Referals:</td>
                                <td><a href="#">   View details</a></td>
                            </tr>

                            <tr><td>Tenant Maintainance:</td>
                                <td><a href="#">   View details</a></td>
                            </tr> -->
                        </table>
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
                    <h3 class="dt-entry__title"> {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}}'s Profile</h3>
                </div>

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                     <a href="{{ route('tenant.edit', ['uuid'=>$tenantDetail->uuid]) }}" class="dropdown-item">

                     <button class="btn btn-xs btn-primary"> Edit Profile</button>

                   </a>

                 <!--  </h3> -->
                </div>
                <!-- /entry heading -->

                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card" style="height: auto;">

                    <!-- Card Body -->
                    <div class="dt-card__body">
                       
<div class="col-md-12 pull-left">
<!--     <div class="tenant-profile-container">
         @if($tenantDetail->photo)
<img src="{{$tenantDetail->photo}}" class="tenant-profile-image">
     @else
      <img src="{{ url('img/defaultprofilePhoto.jpg') }}" class="tenant-profile-image" alt="Tenant Photo">  @endif                        
</div> -->
<div class="row">
   <table class="table align-items-center table-flush">
    <!--  <tr><td><strong>Documents :</strong></td>
        <td>
      <a href="#"  data-toggle="modal" data-target=".tenantdocument">
                                    View documents 
      </a>
        </td>
    </tr> -->
      <tr><td><strong>Full Name :</strong></td>
        <td>
      {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}}
        </td>
    </tr>

<!--  <tr><td><strong>Gender :</strong></td>
        <td>
       {{$tenantDetail->gender}}
        </td>
    </tr> -->

    <!--  <tr><td><strong>Date Of Birth :</strong> </td>
        <td>
      {{\Carbon\Carbon::parse($tenantDetail->date_of_birth)->format('d M Y')}}
        </td>
    </tr> -->

    <tr><td><strong> Phone :</strong> </td>
        <td>
      {{$tenantDetail->phone}}
        </td>
    </tr>
    <tr><td> <strong>Email :</strong> </td>
        <td>
      {{$tenantDetail->email}}
        </td>
    </tr>

    <!-- <tr><td> <strong> Occupation : </strong> </td>
        <td>
    {{$tenantDetail->occupation}}
        </td>
    </tr>
 -->
<!--      <tr><td>  <strong>Address : </strong></td>
        <td>
     {{$tenantDetail->address}}
        </td>
    </tr>

     <tr><td>  <strong>Country :</strong>  </td>
        <td>
    {{$tenantDetail->countryName}}
        </td>
    </tr>
     <tr><td>  <strong>State :</strong>  </td>
        <td>
    {{$tenantDetail->stateName}}
        </td>
    </tr>

     <tr><td> <strong> City :</strong>  </td>
        <td>
   {{$tenantDetail->cityName}}
        </td>
    </tr> -->
   </table>
</div>
</div>

                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->

            </div>
            <!-- /grid item -->

 @include('new.admin.tenant.tenantProfile.partials.tenant_service_charges')
 @include('new.admin.tenant.tenantProfile.partials.tenant_sc_payment_history')
 @include('new.admin.tenant.tenantProfile.partials.tenant_sc_wallet_history')
 @include('new.admin.tenant.tenantProfile.partials.tenantRentalPaymentHistories')
 @include('new.admin.tenant.tenantProfile.partials.tenantRentalDebts')
 @include('new.admin.tenant.tenantProfile.partials.tenantRents')
 @include('new.admin.tenant.tenantProfile.partials.tenantdocument')

        </div>
        <!-- /grid -->
@endsection