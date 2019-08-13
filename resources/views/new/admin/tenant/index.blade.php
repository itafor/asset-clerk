@extends('new.layouts.app', ['title' => 'List of Tenants', 'page' => 'tenant'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Tenant Management</h1>
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
                <h3 class="dt-entry__title">List of Tenants</h3>
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
                        <th><b>Designation</b></th>
                        <th><b>First Name</b></th>
                        <th><b>Last Name</b></th>
                        <th><b>Occupation</b></th>
                        <th><b>Phone</b></th>
                        <th class="text-center"><b>Action</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tenants as $tenant)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$tenant->designation}}</td>
                            <td>{{$tenant->firstname}}</td>
                            <td>{{$tenant->lastname}}</td>
                            <td>{{$tenant->occupation}}</td>
                            {{-- <td>{{$tenant->occupationName ? $tenant->occupationName->name : 'N/A'}}</td> --}}
                            <td>{{$tenant->phone}}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a href="{{ route('tenant.edit', ['uuid'=>$tenant->uuid]) }}" class="dropdown-item">Edit</a>
                                        <form action="{{ route('tenant.delete', ['uuid'=>$tenant->uuid]) }}" method="get">
                                            
                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this tenant?") }}') ? this.parentElement.submit() : ''">
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