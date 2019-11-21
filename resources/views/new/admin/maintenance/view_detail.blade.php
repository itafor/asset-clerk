@extends('new.layouts.app', ['title' => 'Maintenances', 'page' => 'maintenance'])

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
                <h3 class="dt-entry__title">Complaint details</h3>
              </div>

  <div class="dt-entry__heading">
 <a href="{{ route('maintenance.index') }}">
<button class="btn btn-sm btn-primary">
 Back
</button>
</a>
                
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

                  <table class="table table-bordered" id="tbl_id">
           
                    <tbody>
                   <tr>
                     <td>Row Number</td>
                     <td>{{$complaint_row_number}}</td>
                   </tr>

                     <tr>
                     <td>TENANT</td>
                     <td>{{$complaint_detail->tenant->name()}}</td>
                   </tr>

                    <tr>
                     <td>PROPERTY</td>
                <td>{{$complaint_detail->asset_maintenance($complaint_detail->asset_description_uuid)['descriptn']}}</td>           
              </tr>

                 <tr>
                     <td>SECTION</td>
                     <td>{{$complaint_detail->buildingSection->name}}</td>
                </tr>

                 <tr>
                     <td>DESCRIPTION</td>
                     <td>
                      <p>
                      {{$complaint_detail->description}}
                      </p>
                    </td>
                </tr>

                 <tr>
                     <td>REPORTED DATE</td>
                     
                      <td>{{ formatDate($complaint_detail->reported_date, 'Y-m-d', 'd/m/Y') }}</td>
                   
                </tr>
               
                 <tr>
                    <td>{{$complaint_detail->status === 'Fixed' ? 'DATE Fixed': 'DATE Unfixed'}}</td>
                      @if($complaint_detail->status === 'Fixed')
                   <td>{{Carbon\Carbon::parse($complaint_detail->updated_at)->format('d/m/Y')}}</td>
                     @else
                   <td>

                    {{
                     $complaint_detail->updated_at == $complaint_detail->created_at ? 'N/A' : Carbon\Carbon::parse($complaint_detail->updated_at)->format('d/m/Y')
                    }}

                  </td>
                     @endif
                </tr>
              
                 <tr>
                  @if($complaint_detail->status === 'Fixed')
                              <td>STATUS</td>
                              <td class="text-success">{{$complaint_detail->status}}</td>
                              @else
                              <td>STATUS</td>
                              <td class="text-danger">{{$complaint_detail->status}}</td>
                  @endif
                </tr>

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
  
    </script>
@endsection