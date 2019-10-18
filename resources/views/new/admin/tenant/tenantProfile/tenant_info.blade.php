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
          <h1 class="dt-page__title"><i class="icon icon-user-o"></i> Tenant Profile</h1>
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
                <div class="dt-card" style="height: 500px;">

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
  <div class="column" style="background-color:#fff;">
    <h2>Full Name: {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}}</h2>
  </div>
  <div class="column" style="background-color:#fff;">
   <h2>Gender: {{$tenantDetail->gender}}</h2>
  </div>
  <div class="column" style="background-color:#fff;">
   <h2>Date Of Birth: {{$tenantDetail->date_of_birth}}</h2>
  </div>

  <div class="column" style="background-color:#fff;">
   <h2>Phone: {{$tenantDetail->phone}}</h2>
  </div>
  <div class="column" style="background-color:#fff;">
   <h2>Email: {{$tenantDetail->email}}</h2>
  </div>

  <div class="column" style="background-color:#fff;">
   <h2>occupation: {{$tenantDetail->occupation}}</h2>
  </div>

  <div class="column" style="background-color:#fff;">
   <h2>address: {{$tenantDetail->address}}</h2>
  </div>

  <div class="column" style="background-color:#fff;">
   <h2>Country: {{$tenantDetail->countryName}}</h2>
  </div>
   <div class="column" style="background-color:#fff;">
   <h2>State: {{$tenantDetail->stateName}}</h2>
  </div>
   <div class="column" style="background-color:#fff;">
   <h2>City: {{$tenantDetail->cityName}}</h2>
  </div>
  
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
                    <h3 class="dt-entry__title">Change Password</h3>
                </div>
                <!-- /entry heading -->

                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card" style="height: 500px;">

                    <!-- Card Body -->
                    <div class="dt-card__body">
                        {{$tenantId}}
                        <table class="table align-items-center table-flush">
                            <tr><td>Assigned Service Charges:</td>
                                <td><a href="#"> View details</a></td>
                            </tr>

                            <tr><td>Service Charge Payment Histories:</td>
                                <td><a href="#">   View details</a></td>
                            </tr>

                             <tr><td>Wallet History:</td>
                                <td><a href="#">   View details</a></td>
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

        </div>
        <!-- /grid -->
@endsection