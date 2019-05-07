@extends('new.layouts.app', ['title' => 'List of Service Charges', 'page' => 'service'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Service Charges</h1>
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
                <h3 class="dt-entry__title">List of Service Charges</h3>
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
                        <th><b>Asset</b></th>
                        <th><b>Service Charge</b></th>
                        <th>Type</th>
                        <th><b>Amount</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($charges as $charge)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$charge->asset->description}}</td>
                        <td>{{$charge->serviceCharge->name}}</td>
                        <td>{{ucwords($charge->serviceCharge->type)}}</td>
                        <td>&#8358; {{number_format($charge->price,2)}}</td>
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