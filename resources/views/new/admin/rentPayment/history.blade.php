@extends('new.layouts.app', ['title' => 'Rental Payment History', 'page' => 'Rental'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Rental Payment History</h1>
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
                <h3 class="dt-entry__title">List of Rental Payment History</h3>
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
                          <th><b>Full Name</b></th>
                          <th><b>Asset</b></th>
                          <th><b>Property Estimate</b></th>
                          <th><b>Amount</b></th>
                          <th><b>Amount Paid</b></th>
                          <th><b>Balance</b></th>
                          <th><b>Payment Mode</b></th>
                          <th><b>Payment Date</b></th>
                          <th><b>Created At</b></th>
                          <th><b>Duration paid for</b></th>
                          
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($rentPayments as $rent)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>
                            {{$rent->unitt->getTenant()->designation}}.
                            {{$rent->unitt->getTenant()->firstname}}
                            {{$rent->unitt->getTenant()->lastname}}
                          </td>
                          <td>{{$rent->asset->description}}</td>
                          <td>&#8358;{{number_format($rent->proposed_amount,2)}}</td>
                          <td>&#8358;{{number_format($rent->actual_amount,2)}}</td>
                          <td>&#8358;{{number_format($rent->amount_paid,2)}}</td>
                          <td>&#8358;{{number_format($rent->balance,2)}}</td>
                          <td>{{$rent->paymentMode->name}}</td>
                          <td>{{\Carbon\Carbon::parse($rent->payment_date)->format('d/m/Y')}}</td>
                          <td>{{\Carbon\Carbon::parse($rent->created_at)->format('d/m/Y')}}</td>
                          <td>{{$rent->startDate}} -  {{$rent->due_date}}</td>
                          
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