@extends('new.layouts.app', ['title' => 'Landlord Report', 'page' => 'Report'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Landlord Report</h1>
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
                <h3 class="dt-entry__title">Landlord</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">

<!-- search description -->
<form action="{{route('report.get_landlord_report')}}" method="post" autocomplete="false">
   @csrf
  <div class="row">
   <div class="form-group col-4">
 <label class="form-control-label" for="input-category">{{ __('Start Date') }}</label>
                                <div>
                                <input type="text" name="startDate" id="startDate" class=" datepicker form-control form-control-alternative{{ $errors->has('startDate') ? ' is-invalid' : '' }} " autocomplete="false" placeholder="Choose Date" value="{{isset($start_date) !=='' ? Carbon\Carbon::parse($start_date)->format('d/m/Y') : ''}}" required>
                                        
                                @if ($errors->has('startDate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('startDate') }}</strong>
                                    </span>
                                @endif
                          </div>
</div>


   <div class="form-group col-4">
 <label class="form-control-label" for="input-category">{{ __('Due Date') }}</label>
                                <div>
                                <input type="text" name="dueDate" id="dueDate" class=" datepicker form-control form-control-alternative{{ $errors->has('dueDate') ? ' is-invalid' : '' }} " placeholder="Choose Date" value="{{isset($end_date) !=='' ? Carbon\Carbon::parse($end_date)->format('d/m/Y') : ''}}" required autocomplete="false">
                                        
                                @if ($errors->has('dueDate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dueDate') }}</strong>
                                    </span>
                                @endif
                          </div>
</div>
  

 <div class="form-group col-2">
 <label class="form-control-label" for="input-category">{{ __('Search') }}</label>
                                <div>
                                    <button class="btn btn-sm btn-primary">Search</button>
                          </div>
</div>

</div>
</form>
                <!-- Tables -->
                <div class="table-responsive">

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th><b>Landlord Name</b></th>
                        <th><b>Asset</b></th>
                        <th><b>Type</b></th>
                        <th><b>Description</b></th>
                        <th><b>Rent Expiry Date</b></th>
                        <th><b>Outstanding Rent</b></th>
                        <th><b>Tenant</b></th>
                        <!-- <th><b>Outstanding Service Charge</b></th> -->
                        <!-- <th><b>qty left</b></th> -->
                        <t
                    </tr>
                    </thead>
                    <tbody>
                      @if(isset($tenant_rentDetails))
                    @foreach ($tenant_rentDetails as $report)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$report->landlordDetail}}</td>
                            <td>{{$report->assetdesc}}</td>
                            <td>{{$report->proptype}}</td>
                            <td>{{$report->apartmentType}}</td>
                            <td> {{formatDate($report->rentExp, 'Y-m-d', 'd M Y')}}</td>
                            <td> &#8358; {{number_format($report->outstandingRent,2)}}</td>
                            <td>{{$report->tenantDetail}}</td>
                        </tr>
                    @endforeach
                    @endif
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
       <!--  -->

@endsection

@section('script')
    <script>


    </script>
@endsection