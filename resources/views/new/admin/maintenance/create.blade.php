@extends('new.layouts.app', ['title' => 'Add New Maintenance', 'page' => 'maintenance'])

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
                <h3 class="dt-entry__title">Add New Maintenance</h3>
              </div>
              <!-- /entry heading -->
               <!-- Entry Heading -->
              <div class="dt-entry__heading">
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" title="Add Tenant to a Property"><i class="fas fa-plus"></i> Add tenant to a property</button> -->
              </div>
              <!-- /entry heading -->
            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('maintenance.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Maintenance') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                
<div class="form-group{{ $errors->has('tenant_uuid') ? ' has-danger' : '' }} col-6">
    <label class="form-control-label" for="input-tenant">{{ __('Tenant') }} 
    </label>
<select name="tenant_uuid" id="input_tenant" class="form-control" required autofocus>
<option value="">Select Tenant</option>
@foreach (getTenants() as $tenant)
<option value="{{$tenant->uuid}}">{{$tenant->name()}}</option>
@endforeach
</select>

@if ($errors->has('tenant_uuid'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('tenant_uuid') }}</strong>
</span>
@endif
</div>

  <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-6">
<label class="form-control-label" for="input-property">{{ __('Property') }}</label>
<select name="asset_description" id="asset_description" class="form-control" required autofocus>
     <option value="">Select Property</option>
</select>

@if ($errors->has('asset_description'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('asset_description') }}</strong>
    </span>
@endif
</div>

<div class="form-group{{ $errors->has('unit_uuid') ? ' has-danger' : '' }} col-6">
<label class="form-control-label" for="input-unit_uuid">{{ __('Property Type') }}</label>
<select name="unit_uuid" id="unit_uuid" class="form-control" required>
    <option value="">Select Property Type</option>
</select>

@if ($errors->has('unit_uuid'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('unit_uuid') }}</strong>
    </span>
@endif
</div>

<!-- <div class="form-group{{ $errors->has('property_uuid') ? ' has-danger' : '' }} col-6">
<label class="form-control-label" for="input-unit">{{ __('Unit') }}</label>
<select name="property_uuid" id="property_uuid" class="form-control" required>
    <option value="">Select Property Unit</option>
</select>

@if ($errors->has('property_uuid'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('property_uuid') }}</strong>
    </span>
@endif
</div> -->


                                    <div class="form-group{{ $errors->has('reported_date') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-reported_date">{{ __('Reported Date') }}</label>
                                        <input type="text" name="reported_date" id="payment_date" class="datepicker form-control form-control-alternative{{ $errors->has('reported_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('reported_date')}}" required>
                                        
                                        @if ($errors->has('reported_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('reported_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                   

                                    <div class="form-group{{ $errors->has('fault_description') ? ' has-danger' : '' }} col-12">
                                        <label class="form-control-label" for="input-fault_description">{{ __('Fault Description') }}</label>
                                        <textarea rows="5" name="fault_description" id="input-fault_description" class="form-control form-control-alternative{{ $errors->has('fault_description') ? ' is-invalid' : '' }}" placeholder="Enter Fault Description" required>{{old('fault_description')}}</textarea>

                                        @if ($errors->has('fault_description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fault_description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                

                                    <div style="clear:both"></div>    
                                    <div class="col-12" align="center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save Maintenance') }}</button>
                                    </div> 
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
         $('#input_tenant').change(function(){
            var tenant_uuid = $(this).val();
            console.log(tenant_uuid)
            if(tenant_uuid){
                $('#asset_description').empty();
                $('<option>').val('').text('Loading...').appendTo('#asset_description');
                $.ajax({
                    url: baseUrl+'/fetch-allocated-property/'+tenant_uuid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $('#asset_description').empty();
                        $('<option>').val('').text('Select Asset').appendTo('#asset_description');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.uuid).text(v.description).attr('data-price',v.price).appendTo('#asset_description');
                        });
                    }
                });
            }
            else{
                $('#asset_description').empty();
                $('<option>').val('').text('Select Asset').appendTo('#asset_description');
            }
        });

         $('#asset_description').change(function(){
            var unit_uuid = $(this).val();
            console.log(unit_uuid)
            if(unit_uuid){
                $('#unit_uuid').empty();
                $('<option>').val('').text('Loading...').appendTo('#unit_uuid');
                $.ajax({
                    url: baseUrl+'/fetch-property-type/'+unit_uuid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log('test',data)
                        $('#unit_uuid').empty();
                        $('<option>').val('').text('Select Property Type').appendTo('#unit_uuid');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.unitUuid).text(v.name).attr('data-price',v.price).appendTo('#unit_uuid');
                            $('#property_uuid')
                $('<option>').val(v.flat_number).text(v.flat_number).appendTo('#property_uuid');

                        });
                    }
                });
            }
            else{
                $('#unit_uuid').empty();
                $('<option>').val('').text('Select Asset').appendTo('#unit_uuid');
            }
        });

     


     
    </script>
@endsection