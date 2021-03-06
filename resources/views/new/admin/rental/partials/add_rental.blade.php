@extends('new.layouts.app', ['title' => 'Add Rental', 'page' => 'Add Rental'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Add Rental Management</h1>
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
                <h3 class="dt-entry__title">Add Rental</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('rental.save') }}" autocomplete="off">
                            @csrf
                           <div class="row">
                             <div class="col-md-12">
                                <input type="hidden" name="proposed_amount" value="{{$tenantRent->price}}">
                                <input type="hidden" name="tenantRent_uuid" value="{{$tenantRent->uuid}}">
                                
                               <div class="float-left"> <p>Fields marked (<span class="text-danger">*</span>) are required.</p></div>
                               <div class="float-right"><span></span>Landlord (
                                {{$tenantRent->asset->Landlord ? $tenantRent->asset->Landlord->designation : ''}}
                                {{$tenantRent->asset->Landlord ? 
                                  $tenantRent->asset->Landlord->firstname : ''}}
                                {{$tenantRent->asset->Landlord ? 
                                  $tenantRent->asset->Landlord->lastname : ''}}
                                ) Asking Price : &#8358;{{ $tenantRent->unit ? number_format($tenantRent->unit->standard_price,2) : 'N/A' }} </div>
                           </div>
                           </div>
                            <div class="pl-lg-4">
                                <div class="row">
                                    
                                    <div class="form-group{{ $errors->has('asset_uuid') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="asset_uuid">{{ __('Property') }}<span class="text-danger">*</span></label>
                                        <select name="asset_uuid" id="asset_uuid" class="form-control" required disabled>
                                           
                                                <option value="{{$tenantRent->asset_uuid}}" selected="true">
                                                     {{$tenantRent->unit->getProperty() ? $tenantRent->unit->getProperty()->description : ''}} 
                                                </option>
                                           
                                        </select>
                                        
                                        @if ($errors->has('asset_uuid'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('asset_uuid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('unit_uuid') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-unit">{{ __('Property Unit') }}<span class="text-danger">*</span></label>
                                        <select name="unit_uuid" id="unit_uuid" class="form-control" required disabled>
                                            <option value="{{$tenantRent->unit_uuid}}">
                                        @if($tenantRent->unit)
                                         @if($tenantRent->unit->propertyType)
                                         {{$tenantRent->unit->propertyType->name}}
                                         @endif
                                         @else
                                         <span>N/A</span>
                                         @endif
                                            </option>
                                        </select>
                                       
                                        @if ($errors->has('unit_uuid'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('unit_uuid') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                     <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-tenant_uuid">{{ __('Tenant') }}<span class="text-danger">*</span></label>
                                        <select name="tenant_uuid" id="tenant_uuid" class="form-control" required readonly>
                                            <option value="{{$tenantRent->tenant_uuid}}">{{$tenantRent->tenant ? $tenantRent->tenant->name() : ''}}
                                            </option>
                                        </select>
                                       
                                        @if ($errors->has('tenant_uuid'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tenant_uuid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                      <div class="form-group{{ $errors->has('actual_amount') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('Property Sub unit') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="sub_unit" id="sub_unit"  value="{{$tenantRent->flat_number}}"  class="form-control form-control-alternative{{ $errors->has('sub_unit') ? ' is-invalid' : '' }}" readonly   required>
                                        
                                        @if ($errors->has('sub_unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('sub_unit') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                           <div class="form-group{{ $errors->has('actual_amount') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-amount">{{ __('Amount') }}<span class="text-danger">*</span></label>
                                        <input type="number" min="1" name="actual_amount" id="actual_amount"  value="{{$tenantRent->amount}}"  class="form-control form-control-alternative{{ $errors->has('actual_amount') ? ' is-invalid' : '' }}"  placeholder="Enter Actual Amount" required>
                                        
                                        @if ($errors->has('actual_amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('actual_amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                      <div class="form-group{{ $errors->has('payment_date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-payment_date">{{ __('Start Date') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="startDate" id="startDate" class=" datepicker form-control form-control-alternative{{ $errors->has('startDate') ? ' is-invalid' : '' }} " placeholder="Choose Date" value="{{\Carbon\Carbon::parse($tenantRent->startDate)->format('d/m/Y')}}" required>
                                        
                                        @if ($errors->has('startDate'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('startDate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 

                                    <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-due_date">{{ __('End Date') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="due_date" value="{{\Carbon\Carbon::parse(Carbon\Carbon::now()->addYear(1))->format('d/m/Y')}}" class=" datepicker form-control form-control-alternative{{ $errors->has('due_date') ? ' is-invalid' : '' }}" required="required">

                                        @if ($errors->has('due_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('due_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>                     
                            </div>

                        </form>
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

$(document).on('keyup', '#actual_amount', function(e){
    e.preventDefault();
    let value = e.target.value;
if(value <= 0){
     $(this).val('');
}
 });

    </script>
@endsection