@extends('new.layouts.app', ['title' => 'List of Service Charges', 'page' => 'service'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Assets Report</h1>
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
                <h3 class="dt-entry__title">Assets</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">

<!-- search description -->
<form action="{{route('report.get_asset_report')}}" method="post">
   @csrf
  <div class="row">
     <div class="form-group col-3">
      <label class="form-control-label" for="input-category">{{ __('Property') }}</label>
          
              <select name="asset_id" id="asset" class="form-control {{$errors->has('asset') ? ' is-invalid' : ''}} asset" style="width:100%" required>
              <option value="">Select Property</option>
               @if(isset($selected_asset) !== '')
              <option value="{{$selected_asset}}" {{$selected_asset !== '' ? 'selected': '' }} >{{$asset_name}}</option>
               @endif

              @foreach(getAssets() as $asset)
              <option value="{{$asset->id}}">{{$asset->description}}</option>
              @endforeach
              
          </select>
          
             @if ($errors->has('asset'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('asset') }}</strong>
                      </span>
                @endif               
</div>

   <div class="form-group col-2">
 <label class="form-control-label" for="input-category">{{ __('Occupancy') }}</label>
                                <div>
                                    <select  name="occupancy" id="occupancy" class="form-control" style="width:100%" required>
                                    <option value="">Select</option>
                                  @if(isset($occupancy) !== '')
                                  <option value="{{$occupancy}}" {{$occupancy !== '' ? 'selected': '' }} > {{$occupancy }}</option>
                                  @endif
                                    <option value="All">All</option>
                                    <option value="Occupied">Occupied</option>
                                    <option value="Vacant">Vacant</option>
                                </select>
                          </div>
</div>


   <div class="form-group col-2">
 <label class="form-control-label" for="input-category">{{ __('Payment') }}</label>
                                <div>
                                    <select name="payment" id="payment" class="form-control" style="width:100%" required>
                                    <option value="">Select</option>
                                       @if(isset($payment) !== '')
                                  <option value="{{$payment}}" {{$payment !== '' ? 'selected': '' }} > {{$payment }}</option>
                                  @endif
                                    <option value="All">All</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Partly">Partly</option>
                                    <option value="Unpaid">Unpaid</option>

                                </select>
                          </div>
</div>
  
   <div class="form-group col-3">
 <label class="form-control-label" for="input-category">{{ __('Type') }}</label>
                                <div>
                                    <select name="apartment_type" id="type" class="form-control " style="width:100%" required>
                                    <option value="">Select</option>
                                      @if(isset($apartment_type) !== '')
                                  <option value="{{$apartment_type}}" {{$apartment_type !== '' ? 'selected': '' }} > {{$apartment_type }}</option>
                                  @endif
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                </select>
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
<div id="payment_status"></div>


                <!-- Tables -->
                <div class="table-responsive">

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th><b>Asset Name</b></th>
                        <th><b>Tenant</b></th>
                        <th><b>Location</b></th>
                        <th><b>Landlord</b></th>
                        <th><b>Occupancy</b></th>
                        <th><b>Payment Status</b></th>
                        <th><b>Property Type</b></th>
                        <th><b>Apartment Type</b></th>
                        <!-- <th><b>qty left</b></th> -->
                        <t
                    </tr>
                    </thead>
                    <tbody>
                      @if(isset($asset_reports))
                    @foreach ($asset_reports as $report)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$report->assetName}}</td>
                            <td>{{$report->tenantDetail}}</td>
                           
                            <td>{{$report->locatn}}</td>
                            <td>{{$report->landlordDetail}}</td>
                          
                            <td>{{$report->qty_left <= 0 ? 'Occupied':'Vacant'}}</td>
                            <td>{{$report->payment_status}}</td>
                            <td>{{$report->proptype}}</td>
                            <td>{{$report->apartmentType}}</td>
                           <!--  <td>{{$report->qty_left}}</td> -->
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