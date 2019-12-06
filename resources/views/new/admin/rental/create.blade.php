@extends('new.layouts.app', ['title' => 'Add New Rental', 'page' => 'rental'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Rental Management</h1>
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
                <h3 class="dt-entry__title">Add New Rental</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                   <form method="post" action="{{ route('rental.store') }}" autocomplete="off">
                            @csrf
                                <input type="hidden" name="user_id" value="">
                                <input type="hidden" name="new_rental_status" value="">
                                <input type="hidden" name="previous_rental_id" value="">
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Rental') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-3">
                                        <label class="form-control-label" for="input-property">{{ __('Property') }}</label>
                                        <select name="property" id="property" class="form-control" required autofocus>
                                            <option value="">Select Property</option>
                                            @foreach (getAssets() as $asset)
                                                <option value="{{$asset->uuid}}">{{$asset->description}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('property'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('property') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-3">
                                        <label class="form-control-label" for="input-unit">{{ __('Unit') }}</label>
                                        <select name="unit" id="unit" class="form-control" required>
                                            <option value="">Select Unit</option>
                                        </select>
                                        
                                        @if ($errors->has('unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('unit') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-3">
                                        <label class="form-control-label" for="input-price">{{ __('Property Estimate') }}</label>
                                        <input type="text" name="price" id="price" class="form-control" value="{{old('price')}}" readonly="true" placeholder="Enter Price" required>
                                        
                                        @if ($errors->has('price'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('price') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                     <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-3">
                                        <label class="form-control-label" for="input-price">{{ __('Amount') }}</label>
                                        <input type="number" min="1" name="amount" id="amount" class="form-control" value="{{old('amount')}}" placeholder="Enter amount" required>
                                        
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group{{ $errors->has('tenant') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-tenant">{{ __('Tenant') }}</label>
                                        <select name="tenant" id="" class="form-control" required autofocus>
                                            <option value="">Select Tenant</option>
                                            @foreach (getTenants() as $tenant)
                                                <option value="{{$tenant->uuid}}">{{$tenant->name()}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('tenant'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tenant') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('startDate') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-duration">{{ __('Start Date') }}</label>

                                         <input type="text" name="startDate" id="startDate" class="datepicker form-control form-control-alternative{{ $errors->has('startDate') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('startDate')}}" >
                                      
                                        @if ($errors->has('startDate'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('startDate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-date">{{ __('End Date') }}</label>
                                        <input type="text" name="due_date" id="input-date" class="datepicker form-control form-control-alternative{{ $errors->has('due_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('due_date')}}" required>
                                        
                                        @if ($errors->has('due_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('due_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div style="clear:both"></div>    
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

        $('#property').change(function(){
            var property = $(this).val();
            if(property){
                $('#unit').empty();
                $('<option>').val('').text('Loading...').appendTo('#unit');
                $.ajax({
                    url: baseUrl+'/fetch-units/'+property,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#unit').empty();
                        $('<option>').val('').text('Select Unit').appendTo('#unit');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.uuid).text(v.name+' | Qty Left: '+v.quantity_left).attr('data-price',v.standard_price).appendTo('#unit');
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

        $('#asset_description').change(function(){
            var value = $(this).val();
            if(value){

                var price = $(this).find(':selected').data('price')

                $('#input-standard_price').val(price)
            }
        })

$(document).on('keyup', '#amount', function(e){
    e.preventDefault();
    let value = e.target.value;
if(value <= 0){
     $(this).val('');
    $('#balance').val(' ')
}
 });
    </script>
@endsection