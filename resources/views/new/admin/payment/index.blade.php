@extends('new.layouts.app', ['title' => 'List of Payments', 'page' => 'payment'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Payment</h1>
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
                <h3 class="dt-entry__title">List of Payments</h3>
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
                          <th><b>Customer Name</b></th>
                          <th><b>Property</b></th>
                          <th><b>Payment Type</b></th>
                          <th><b>Payment Mode</b></th>
                          <th><b>Amount</b></th>
                          <th><b>Description</b></th>
                          <th><b>Payment Date</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($payments as $payment)
                          <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$payment->unit->getTenant()->name()}}</td>
                            <td>{{$payment->unit->getProperty()->description}}</td>
                            <td>{{$payment->paymentType->name}} {{getPaymentServiceCharge($payment)}}</td>
                            <td>{{$payment->paymentMode->name}}</td>
                            <td>&#8358; {{number_format($payment->amount, 2)}}</td>
                            <td>{{$payment->payment_description}}</td>
                            <td>{{$payment->payment_date->format('d M Y')}}</td>
                            <td>
                              <div class="dropdown">
                                    <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        {{-- <a href="{{ route('payment.edit', ['uuid'=>$payment->uuid]) }}" class="dropdown-item">Edit</a> --}}
                                        <form action="{{ route('payment.delete', ['uuid'=>$payment->uuid]) }}" method="get">
                                            
                                            <button type="button" class="dropdown-item" onclick="confirm('Are you sure you want to delete this payment?') ? this.parentElement.submit() : ''">
                                                {{ __('Delete') }}
                                            </button>
                                        </form> 
                                    </div>
                                </div>
                            </td>
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