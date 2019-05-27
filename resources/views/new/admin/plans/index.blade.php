@extends('new.layouts.app', ['title' => 'List of Rentals', 'page' => 'subscription'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Plans Management</h1>
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
                <h3 class="dt-entry__title">List of Plans</h3>
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
                          <th><b>Plan Name</b></th>
                          <th><b>Price</b></th>
                          <th><b>No of Properties Allowed</b></th>
                          <th><b>No of Sub-Accounts Allowed</b></th>
                          <th><b>Service Allowed</b></th>
                          <th><b>Status</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @php $i=1 @endphp
                    @foreach ($plans as $rental)
                      <tr>
                          <td>{{$i++}}</td>
                          <td>{{$rental->name}}</td>
                          <td>{{number_format($rental->amount)}}</td>
                          <td>{{$rental->properties}}</td>
                          <td>{{$rental->sub_accounts}}</td>
                          <td>{{$rental->service_charge}}</td>
                          <td>{{$rental->status}}</td>
                          <td class="text-center">
                              <div class="dropdown">
                                  <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Action
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                      <form action="{{ route('rental.delete', ['uuid'=>$rental->uuid]) }}" method="get">
                                          
                                          <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete?") }}') ? this.parentElement.submit() : ''">
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