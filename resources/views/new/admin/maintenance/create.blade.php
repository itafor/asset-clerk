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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" title="Add Tenant to a Property"><i class="fas fa-plus"></i> Add tenant to a property</button>
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
                                
<div class="form-group{{ $errors->has('tenant_uuid') ? ' has-danger' : '' }} col-4">
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

  <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-4">
<label class="form-control-label" for="input-property">{{ __('Property') }}</label>
<select name="asset_description" id="property" class="form-control" required autofocus>
     <option value="">Select Property</option>
</select>

@if ($errors->has('asset_description'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('asset_description') }}</strong>
    </span>
@endif
</div>
<div class="form-group{{ $errors->has('unit_uuid') ? ' has-danger' : '' }} col-4">
<label class="form-control-label" for="input-unit">{{ __('Unit') }}</label>
<select name="unit_uuid" id="unit" class="form-control" required>
    <option value="">Select Unit</option>
</select>

@if ($errors->has('unit_uuid'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('unit_uuid') }}</strong>
    </span>
@endif
</div>


                                    <div class="form-group{{ $errors->has('reported_date') ? ' has-danger' : '' }} col-12">
                                        <label class="form-control-label" for="input-reported_date">{{ __('Reported Date') }}</label>
                                        <input type="text" name="reported_date" id="input-reported_date" class="datepicker form-control form-control-alternative{{ $errors->has('reported_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('reported_date')}}" required>
                                        
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
                                @include('new.admin.assets.partials.addTenantToProperty')
        
@endsection

@section('script')
    <script>
         $('#category').change(function(){
            var category = $(this).val();
            if(category){
                $('#asset_description').empty();
                $('<option>').val('').text('Loading...').appendTo('#asset_description');
                $.ajax({
                    url: baseUrl+'/fetch-assets/'+category,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
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

         let selected_tenant_uuid ='';
        $('#input_tenant').change(function(){
            var tenant_uuid = $(this).val();
            selected_tenant_uuid = tenant_uuid;
            console.log('selected:',selected_tenant_uuid);
            if(tenant_uuid){
                $('#property').empty();
                $('<option>').val('').text('Loading...').appendTo('#property');
                $.ajax({
                    url: baseUrl+'/fetch-tenants-assigned-to-asset/'+tenant_uuid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if(data !=''){
                        $('#property').empty();
                        $('<option>').val('').text('Select Property').appendTo('#property');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.propertyUuid).text(v.propertyName).attr('data-price',v.propertyProposedPice).appendTo('#property');
                        });
                    }else{
                    toast({
                        type: 'warning',
                        title: 'Ooops!! Selected tenant has not been added to a property'
                  })
            }
        }
    });
            }
            else{
                $('#property').empty();
                $('<option>').val('').text('Select Property').appendTo('#property');
                
            }
        });


        $('#property').change(function(){
            var property = $(this).val();
            if(property && selected_tenant_uuid !=''){
                $('#unit').empty();
                $('<option>').val('').text('Loading...').appendTo('#unit');
                $.ajax({
                    url: baseUrl+'/fetch-units-assigned-to-tenant/'+property+'/'+selected_tenant_uuid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#unit').empty();
                        $('<option>').val('').text('Select Unit').appendTo('#unit');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.uuid).text(v.name+' Bedroom | Qty Left: '+v.quantity_left).attr('data-price',v.standard_price).appendTo('#unit');
                        });
                    }
                });
            }
            else{
                $('#unit').empty();
                $('<option>').val('').text('Select Unit').appendTo('#unit');
            }
        });

        
        $('#unit').change(function(){
            var unit = $(this).val();
            if(unit){
                var price = $(this).find(':selected').attr('data-price')
                $('#price').val(price);
            }
            else{
                $('#price').val('');
            }
        });
    </script>
@endsection