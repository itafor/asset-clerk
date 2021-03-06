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

                  <table class="table table-striped table-bordered table-hover datatable" id="tbl_id">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th><b>Tenant</b></th>
                          <th><b>Property</b></th>
                          <th><b>Fault Description</b></th>
                          <th><b>Date Reported</b></th>
                          <th><b>Status</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($maintenances as $m)
                          <tr id="{{$loop->iteration}}">

                              <td>{{$loop->iteration}}</td>
                              <td> {{$m->tenant ? $m->tenant->designation : ''}}
                            {{$m->tenant ? $m->tenant->firstname : ''}}
                            {{$m->tenant ? $m->tenant->lastname : ''}}</td>
                              <td>{{$m->asset_maintenance($m->asset_description_uuid)['descriptn']}}</td>
                              <td class="complaint_description{{$loop->iteration}}">{{$m->description}}</td>
                              <td>{{ formatDate($m->reported_date, 'Y-m-d', 'd/m/Y') }}</td>
                              @if($m->status === 'Fixed')
                              <td class="text-success">{{$m->status}}</td>
                              @else
                              <td class="text-danger">{{$m->status}}</td>
                              @endif
                              <td class="text-center">
                                      <div class="dropdown">
                                          <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Action
                                          </a>
                                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            
                                                 <a href="{{ route('maintenance.view', ['uuid'=>$m->uuid,'complaint_row_number'=>$loop->iteration]) }}" class="dropdown-item">View</a>

                                                @if($m->status === 'Fixed')
                                                 <form action="{{ route('maintenance.status', ['uuid'=>$m->uuid,'status'=>$m->status]) }}" method="get">
                                                  
                                                  <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to set this maintenance\'s complaint status to Unfixed?") }}') ? this.parentElement.submit() : ''">
                                                      {{ __('Unfix') }}
                                                  </button>
                                              </form>
                                              @else
                                               <form action="{{ route('maintenance.status', ['uuid'=>$m->uuid,'status'=>$m->status]) }}" method="get">
                                                  
                                                  <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to set this maintenance\'s complaint status to Fixed?") }}') ? this.parentElement.submit() : ''">
                                                      {{ __('Fix') }}
                                                  </button>
                                              </form>
                                              @endif

                                             <!--  <a href="{{ route('maintenance.edit', ['uuid'=>$m->uuid]) }}" class="dropdown-item">Edit</a>
 -->
                                         

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



@section('script')
    <script>
let last_row = $('#tbl_id tr:last').attr('id');
   for (var i = 1; i<=last_row; i++) {
     var txt= $('.complaint_description'+i).text();
    if(txt.length > 50)
   $('.complaint_description'+i).text(txt.substring(0,50) + '...');
   }

  
    </script>
@endsection