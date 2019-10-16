@extends('new.layouts.app', ['title' => 'List of Landlords', 'page' => 'landlord'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Service Charge Payment History Management</h1>
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
                <h3 class="dt-entry__title">Service Service Payment Histories</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">

                <!-- Tables -->
                <div class="table-responsive">

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th><b>Tenant</b></th>
                          <th><b>Service Charge</b></th>
                          <th><b>Actual Amount</b></th>
                          <th><b>Amount Paid</b></th>
                          <th><b>Balance</b></th>
                          <th><b>Property</b></th>
                          <th><b>Payment Mode</b></th>
                          <th><b>Payment Date</b></th>
                          <th><b>Duration Paid For</b></th>
                          <th><b>Description</b></th>
                          <th><b>Created At</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($service_charge_payment_histories as $pay)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$pay->tenantDetail}}</td>
                          <td>{{$pay->name}}</td>
                          <td>{{$pay->actualAmount}}</td>
                          <td>{{$pay->amountPaid}}</td>
                          <td>{{$pay->balance}}</td>
                          <td>{{$pay->property}}</td>
                          <td>{{$pay->payment_mode}}</td>
                          <td>{{ \Carbon\Carbon::parse($pay->payment_date)->format('d M Y')}}</td>
                          <td> {{$pay->durationPaidFor}}</td>
                          <td>{{$pay->description}}</td>
                          <td>{{ \Carbon\Carbon::parse($pay->created_at)->format('d M Y')}}</td>
                      
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>
                <!-- /tables -->

              </div>
              <!-- /card body -->

            </div>
            <!-- /card -->

          </div>
          <!-- /grid item -->

        </div>
        <!-- /grid -->
@endsection