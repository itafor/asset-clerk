@extends('new.layouts.app', ['title' => 'List of Allocated Properties', 'page' => 'allocation'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Property Allocation Management
        <!-- /page header -->

        <!-- Grid -->
        <div class="row">

          <!-- Grid Item -->
          <div class="col-xl-12">

            <!-- Entry Header -->
            <div class="dt-entry__header">

              <!-- Entry Heading -->
              <div class="dt-entry__heading">
                <h3 class="dt-entry__title">Allocate New Tenant</h3>
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
                          <th><b>Tenant Name</b></th>
                          <th><b>Property</b></th>
                          <th><b>Property Type</b></th>
                          <th><b>Unit</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($rentals as $rental)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                         
                          <td>

                            {{$rental->tenant ? $rental->tenant->designation : ''}}
                            {{$rental->tenant ? $rental->tenant->firstname : ''}}
                            {{$rental->tenant ? $rental->tenant->lastname : ''}}

                          </td>
                          <td>{{$rental->asset ? $rental->asset->description : ''}}</td>
                           <td>
                             @if($rental->unit)
                             @if($rental->unit->propertyType)
                             {{$rental->unit->propertyType->name}}
                             @endif
                             @else
                             <span>N/A</span>
                             @endif
                           </td>
                        <td>{{$rental->flat_number ? $rental->flat_number : 'N/A'}}</td>

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