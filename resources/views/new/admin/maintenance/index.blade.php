@extends('new.layouts.app', ['title' => 'List of Maintenances', 'page' => 'maintenance'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-setting"></i> Maintenance Management</h1>
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
                <h3 class="dt-entry__title">List of Maintenances</h3>
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
                          <th><b>Category</b></th>
                          <th><b>Section</b></th>
                          <th><b>Fault Description</b></th>
                          <th><b>Date Reported</b></th>
                          <th><b>Status</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($maintenances as $m)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$m->tenant->name()}}</td>
                              <td>{{$m->categoryy->name}}</td>
                              <td>{{$m->buildingSection->name}}</td>
                              <td>{{$m->description}}</td>
                              <td>{{ formatDate($m->reported_date, 'Y-m-d', 'd/m/Y') }}</td>
                              <td>{{$m->status}}</td>
                              <td class="text-center">
                                      <div class="dropdown">
                                          <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Action
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                              <a href="{{ route('maintenance.edit', ['uuid'=>$m->uuid]) }}" class="dropdown-item">Edit</a>
                                              <form action="{{ route('maintenance.delete', ['uuid'=>$m->uuid]) }}" method="get">
                                                  
                                                  <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this maintenance?") }}') ? this.parentElement.submit() : ''">
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