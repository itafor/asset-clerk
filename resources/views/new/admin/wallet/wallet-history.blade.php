@extends('new.layouts.app', ['title' => 'Wallet Histories', 'page' => 'Wallet'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Wallet Transaction History Management</h1>
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
                <h3 class="dt-entry__title">Wallet Transaction Histories</h3>
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
                           <th><b>Transaction Type</b></th>
                          <th><b>Amount</b></th>
                          <th><b>Previous Balance</b></th>
                          <th><b>New Balance</b></th>
                          <th><b>Created At</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($tenantWalletsHistories as $history)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$history->tenantDetail}}</td>
                          <td>{{$history->transaction_type}}</td>
                          <td>&#8358; {{number_format($history->amount,2)}}</td>
                          <td>&#8358; {{number_format($history->previous_balance,2)}}</td>
                          <td> &#8358; {{number_format($history->new_balance,2)}}</td>
                          <td>{{\Carbon\Carbon::parse($history->created_at)->format('d M Y')}}</td>
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