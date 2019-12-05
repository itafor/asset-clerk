@extends('new.layouts.app', ['title' => 'Service Charge Report', 'page' => 'Report'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Service Charge Report</h1>
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
                <h3 class="dt-entry__title">Service Charge Report</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">

<!-- search description -->
<form action="{{route('report.get_servicecharge_report')}}" method="post" autocomplete="false">
   @csrf
  <div class="row">
   <div class="form-group col-3">
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


   <div class="form-group col-3">
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


   <div class="form-group col-3">
 <label class="form-control-label" for="input-rental">{{ __('Payment') }}</label>
                                <div>
                                    <select name="payment" id="payment" class="form-control" style="width:100%">
                                    <option value="">Select</option>
                                       @if(isset($selected_payment) !== '')
                            <option value="{{$selected_payment}}" {{$selected_payment !== '' ? 'selected': '' }} > {{$selected_payment }}</option>
                                  @endif
                                    <option value="All">All</option>
                                    <option value="Paid">Paid </option>
                                    <option value="Partly">Partly Paid </option>
                                    <option value="Pending">Pending </option>
                                </select>
                          </div>
</div>
  
<!--    <div class="form-group col-2">
 <label class="form-control-label" for="input-category">{{ __('Type') }}</label>
                                <div>
                                    <select name="apartment_type" id="apartment_type" class="form-control " style="width:100%" >
                                    <option value="">Select</option>
                                      @if(isset($service_charge) !== '')
                                  <option value="{{$apartment_type}}" {{$apartment_type !== '' ? 'selected': '' }} > {{$apartment_type}}</option>
                                  @endif
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                </select>
                          </div>
</div> -->
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
                        <th><b>Asset</b></th>
                         <th><b>Landlord</b></th>
                        <th><b>Tenant</b></th>
                        <th><b>Service Charge</b></th>
                        <th><b>Total</b></th>
                        <th><b>Status</b></th>
                        <th><b>Outstanding Service Charge</b></th>

                    </tr>
                    </thead>
                    <tbody>
                      @if(isset($service_charges))
                    @foreach ($service_charges as $report)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$report->assetName}}</td>
                            <td>{{$report->landlordDetail}}</td>
                            <td>{{$report->tenantDetail}}</td>
                            <td>{{$report->serviceCharge}}</td>
                            <td> &#8358; {{number_format($report->total,2)}}</td>
                            <td>{{$report->paymentStatus}}</td>
                            <td> &#8358; {{number_format($report->asc_bal,2)}}</td>
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