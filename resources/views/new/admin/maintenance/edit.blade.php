@extends('new.layouts.app', ['title' => 'Edit Maintenance', 'page' => 'maintenance'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Maintenance Management</h1>
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
                <h3 class="dt-entry__title">Edit Maintenance</h3>
              </div>
              <!-- /entry heading -->
  <div class="dt-entry__heading">
 <a href="{{ route('maintenance.index') }}">
<button class="btn btn-sm btn-primary">
 Back
</button>
</a>
                
              </div>
            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('maintenance.update') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="uuid" value="{{$maintenance->uuid}}">
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Maintenance') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">

                                    <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-tenant">{{ __('Tenant') }}</label>
                                        <select name="customer" id="tenant" class="form-control" required autofocus>
                                            <option value="{{$maintenance->tenant->id}}">{{$maintenance->tenant->name()}}</option>
                                           
                                        </select>

                                        @if ($errors->has('customer'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('customer') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('asset_description') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-tenant">{{ __('Asset Description') }}</label>
                                    
                                        <select name="asset_description" id="asset_description" class="form-control" required>
                                            <option value="{{$maintenance->asset_description_uuid}}">{{$maintenance->asset_maintenance($maintenance->asset_description_uuid)['descriptn']}}</option>
                                            
                                        </select>
                                        @if ($errors->has('asset_description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('asset_description') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('building_section') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-building_section">{{ __('Building Section') }}</label>
                                        <select name="building_section" id="building_section" class="form-control" required>
                                            <option value="">Select Building Section</option>
                                            @foreach (getBuildingSections() as $b)
                                                <option value="{{$b->id}}" {{$b->id == $maintenance->building_section ? 'selected' : ''}}>{{$b->name}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('building_section'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('building_section') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('reported_date') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-reported_date">{{ __('Reported Date') }}</label>
                                        <input type="text" name="reported_date" id="input-reported_date" class="datepicker form-control form-control-alternative{{ $errors->has('reported_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('reported_date', formatDate($maintenance->reported_date, 'Y-m-d', 'd/m/Y'))}}" required>
                                        
                                        @if ($errors->has('reported_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('reported_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    {{-- <div style="clear:both"></div>          --}}

                                    <div class="form-group{{ $errors->has('fault_description') ? ' has-danger' : '' }} col-12">
                                        <label class="form-control-label" for="input-fault_description">{{ __('Fault Description') }}</label>
                                        <textarea rows="5" name="fault_description" id="input-fault_description" class="form-control form-control-alternative{{ $errors->has('fault_description') ? ' is-invalid' : '' }}" placeholder="Enter Fault Description" required>{{old('fault_description', $maintenance->description)}}</textarea>

                                        @if ($errors->has('fault_description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fault_description') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                    <div class="col-12" align="center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save Changes') }}</button>
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
         $('#category').change(function(){
        //     var category = $(this).val();
        //     if(category){
        //         $('#asset_description').empty();
        //         $('<option>').val('').text('Loading...').appendTo('#asset_description');
        //         $.ajax({
        //             url: baseUrl+'/fetch-assets/'+category,
        //             type: "GET",
        //             dataType: 'json',
        //             success: function(data) {
        //                 $('#asset_description').empty();
        //                 $('<option>').val('').text('Select Asset').appendTo('#asset_description');
        //                 $.each(data, function(k, v) {
        //                     $('<option>').val(v.uuid).text(v.description).attr('data-price',v.price).appendTo('#asset_description');
        //                 });
        //             }
        //         });
        //     }
        //     else{
        //         $('#asset_description').empty();
        //         $('<option>').val('').text('Select Asset').appendTo('#asset_description');
        //     }
        // });

        // $('#tenant').change(function(){
        //     var tenant = $(this).val();
        //     loadAssets(tenant);
        });

        // $(document).ready(function(){
        //     var tenant = "{{$maintenance->tenant_id}}";
        //     loadAssets(tenant);
        // });

        function loadAssets(tenant) {
            // if(tenant){
            //     $('#asset_description').empty();
            //     $('<option>').val('').text('Loading...').appendTo('#asset_description');
            //     $.ajax({
            //         url: baseUrl+'/fetch-tenant-asset/'+tenant,
            //         type: "GET",
            //         dataType: 'json',
            //         success: function(data) {
            //             $('#asset_description').empty();
            //             $('<option>').val('').text('Select Asset').appendTo('#asset_description');
            //             $.each(data, function(k, v) {
            //                 if(v.uuid == '{{$maintenance->asset_description_uuid}}') {
            //                     $('<option>').val(v.uuid).text(v.asset+' - '+v.unit).prop('selected', true).appendTo('#asset_description');
            //                 } else {
            //                     $('<option>').val(v.uuid).text(v.asset+' - '+v.unit).appendTo('#asset_description');
            //                 }
            //             });
            //         }
            //     });
            // }
            // else{
            //     $('#asset_description').empty();
            //     $('<option>').val('').text('Select Asset').appendTo('#asset_description');
            // }
        }

    </script>
@endsection