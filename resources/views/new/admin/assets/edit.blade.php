@extends('new.layouts.app', ['title' => 'Edit Asset', 'page' => 'asset'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Asset Management</h1>
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
                <h3 class="dt-entry__title">Edit Asset</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">

                    <form method="post" action="{{ route('asset.update') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="uuid" value="{{$asset->uuid}}">
                            <input type="hidden" name="default_quantity" value="1">
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Basic information') }}</h6>
                            <div class="row">
                                
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label" for="input-name">{{ __('Description') }}</label>
                                    <input rows="5" name="description" id="input-name" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description', $asset->description) }}" placeholder="{{ __('Enter Description') }}" required autofocus >

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{--<div class="form-group {{ $errors->has('property_type') ? 'has-danger':'' }} col-4">
                                    <label class="form-control-label" for="input-property_type">{{ __('Property Type') }}</label>
                                    <select name="property_type"  class="form-control" required>
                                        <option value="">Select Property Type</option>
                                        @foreach (getPropertyTypes() as $pt)
                                            <option value="{{$pt->id}}" {{$pt->id == $asset->property_type ? 'selected' : ''}}>
                                                {{$pt->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('property_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('property_type') }}</strong>
                                        </span>
                                    @endif
                                </div>--}}

                                 {{--<div class="form-group {{ $errors->has('asking_price') ? 'has-danger':'' }} col-4">
                                    <label class="form-control-label" for="input-asking_price">{{ __('Asking Price') }} </label>
                                    <input type="number" min="1" rows="5" name="asking_price" id="input-asking_price" class="form-control {{ $errors->has('asking_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Property Price') }}" value="{{ old('asking_price',$asset->price) }}" required autofocus>
                                     @if ($errors->has('asking_price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('asking_price') }}</strong>
                                        </span>
                                    @endif
                                </div>--}}
                                <div class="form-group{{ $errors->has('landlord') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label" for="input-landlord">{{ __('Landlord') }}</label>
                                    <select name="landlord"  class="form-control" >
                                        <option value="">Select Landlord</option>
                                        @foreach (getLandlords() as $land)
                                            <option value="{{$land->id}}" {{$land->id == $asset->landlord_id ? 'selected' : ''}}>{{$land->name()}}</option>
                                        @endforeach
                                    </select>
                                    
                                    @if ($errors->has('landlord'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('landlord') }}</strong>
                                        </span>
                                    @endif
                                </div>                       
                            </div>


                            <h6 class="heading-small text-muted mb-4">{{ __('Location') }}</h6>
                            <div class="row">
                                <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label" for="input-country">{{ __('Country') }}</label>
                                    <select name="country" id="country" class="form-control" required>
                                        <option value="">Select Country</option>
                                        @foreach (getCountries() as $c)
                                            <option value="{{$c->id}}" {{$c->id == $asset->country_id ? 'selected' : ''}}>{{$c->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('country'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label" for="input-state">{{ __('State') }}</label>
                                    <select name="state" id="state" class="form-control" required>
                                        <option value="">Select State</option>
                                        @foreach (getStates($asset->country_id) as $state)
                                            <option value="{{$state->id}}" {{$state->id == $asset->state_id ? 'selected' : ''}}>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                    @if ($errors->has('state'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </span>
                                    @endif
                                </div>                     
                                <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label" for="input-city">{{ __('City') }}</label>
                                    <select name="city" id="city" class="form-control" required>
                                        <option value="">Select City</option>
                                        @foreach (getCities($asset->state_id) as $city)
                                            <option value="{{$city->id}}" {{$city->id == $asset->city_id ? 'selected' : ''}}>{{$city->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label" for="input-state">{{ __('Address') }}</label>
                                    <input type="text" name="address" id="input-address" class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Enter Address" value="{{old('address',$asset->address)}}" required>
                                    
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>                      
                            </div>



                                 <h6 class="heading-small text-muted mb-4">{{ __('Property Units') }}</h6>


                                 @if($asset->units)
                                 @foreach ($asset->units as $key => $unit)
                         
                  <div class="row">
                            <input type="hidden" name="unit[{{$key}}][unit_uuid]" value="{{old('unit_uuid',$unit->uuid)}}">
                      <div class="form-group{{ $errors->has('number_of_flat') ? ' has-danger' : '' }} col-3">
                                    <label class="form-control-label" for="input-property_type">{{ __('Property Type') }}</label>
                                    <select name="unit[{{$key}}][property_type]" id="property_type_id" class="form-control" required>
                                        <option value="">Select Property Type</option>
                                        @foreach (getPropertyTypes() as $pt)
                                            <option value="{{$pt->id}}" {{$pt->id==$unit->property_type_id ? 'selected' : 'Select Property Type'}}>{{$pt->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('property_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('property_type') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                 <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }} col-3">
                                    <label class="form-control-label" for="input-quantity">{{ __('Units') }}</label>
                                    <input type="number" name="unit[{{$key}}][quantity]" min="1" class="form-control" placeholder="Enter number of unit" value="{{old('quantity',$unit->quantity)}}" required>

                                    @if ($errors->has('quantity'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>

     
                                <div class="form-group{{ $errors->has('number_of_room') ? ' has-danger' : '' }} col-3">
                                    <label class="form-control-label" for="input-property_type">{{ __('Rooms') }}</label>
                                    <input type="number" name="unit[{{$key}}][number_of_room]" min="1" class="form-control" value="{{old('number_of_room',$unit->number_of_room)}}" placeholder="Enter number of room" required>

                                    @if ($errors->has('number_of_room'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('number_of_room') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                
                           
                             
                                <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-3">
                                    <label class="form-control-label" for="input-standard_price">{{ __('Asking Price') }}</label>
                                    <input type="number" min="1" name="unit[{{$key}}][standard_price]" id="input-standard_price" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }} standard_price" placeholder="Enter Property Estimate" value="{{old('standard_price',$unit->standard_price)}}" required>

                                    @if ($errors->has('standard_price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('standard_price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                                @endforeach

                                @endif







                            <!-- old codes removed from here -->
                         
                            <div class="row">
                            <!--     <div class="form-group{{ $errors->has('features') ? ' has-danger' : '' }} col-12">
                                    @foreach (getAssetFeatures() as $feature)
                                        <div class="custom-control custom-checkbox custom-control-inline" style="margin-right:25px; float:left">
                                            <input type="checkbox" id="customcheckboxInline{{$loop->iteration}}" name="features[]" value="{{$feature->id}}"
                                                class="custom-control-input"  {{in_array($feature->id,explode(',', $asset->features)) ? 'checked' : ''}}>
                                            <label class="custom-control-label" for="customcheckboxInline{{$loop->iteration}}">{{$feature->name}}</label>
                                        </div>
                                    @endforeach
                                    
                                
                                </div> -->
                                <div class="clearfix"></div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save Changes') }}</button>
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
        {{-- @include('admin.assets.partials.service') --}}
        <!-- {{-- @include('admin.assets.partials.addUnit') --}} -->
@endsection

@section('script')
    <script>

        $('body').on('change', '.sc_type', function(){
            var sc_type = $(this).val();
            var row = $(this).data('row');
            if(sc_type){

                $('#serviceCharge'+row).empty();
                $('<option>').val('').text('Loading...').appendTo('#serviceCharge'+row);
                $.ajax({
                    url: baseUrl+'/fetch-service-charge/'+sc_type,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#serviceCharge'+row).empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#serviceCharge'+row);
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#serviceCharge'+row);
                        });
                    }
                });
            }
        });
        
        $('#country').change(function(){
            var country = $(this).val();
            if(country){
                $('#state').empty();
                $('<option>').val('').text('Loading...').appendTo('#state');
                $.ajax({
                    url: baseUrl+'/fetch-states/'+country,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#state').empty();
                        $('<option>').val('').text('Select State').appendTo('#state');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#state');
                        });
                    }
                });
            }
        });

        $('#state').change(function(){
            var state = $(this).val();
            if(state){
                $('#city').empty();
                $('<option>').val('').text('Loading...').appendTo('#city');
                $.ajax({
                    url: baseUrl+'/fetch-cities/'+state,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#city').empty();
                        $('<option>').val('').text('Select City').appendTo('#city');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#city');
                        });
                    }
                });
            }
        });

        function identifier(){
            return Math.floor(Math.random() * (99999999 - 10000000 + 1)) + 10000000;
        }

        var row = {{$asset->units->count()}};

        $('#addMore').click(function(e) {
            e.preventDefault();

            if(row >= 5){
                alert("You've reached the maximum limit");
                return;
            }

            var rowId = identifier();

    $("#container").append(
    '<div>'
    +'<div style="float:right" class="remove_project_file"><span style="cursor:pointer" class="badge badge-danger" border="2">Remove</span></div>'
    +'<div style="clear:both"></div>'
    +'<div class="row" id="rowNumber'+rowId+'" data-row="'+rowId+'">'

    +'<div class="col-2">'
    +'<label class="form-control-label" for="input-category">{{ __('Property Used') }}</label>'
    +'<div class="form-check">'
    +'<label class="form-check-label" for="radio1">'
    +'<input type="radio" class="form-check-input" id="radio1"  name="unit['+rowId+'][apartment_type]" value="Residential" required>Residential'
    +'</label>'
    +'</div>'
    +'<div class="form-check">'
    +'<label class="form-check-label" for="radio2">'
    +'<input type="radio" class="form-check-input" id="radio2" name="unit['+rowId+'][apartment_type]" value="Commercial" required>Commercial'
    +'</label>'
    +'</div>'
    +' @if ($errors->has('apartment_type'))'
    +'        <span class="invalid-feedback" role="alert">'
    +'            <strong>{{ $errors->first('apartment_type') }}</strong>'
    +'        </span>'
    +'    @endif'
    +'</div>'

                        +'<div class="form-group{{ $errors->has('property_type') ? ' has-danger' : '' }} col-3">'
                        +'    <label class="form-control-label" for="input-property_type">{{ __('Property Type') }}</label>'
                        +'    <select name="unit['+rowId+'][property_type]"  class="form-control select'+rowId+'" required>'
                        +'        <option value="">Select Property Type</option>'
                        +'        @foreach (getPropertyTypes() as $pt)'
                        +'            <option value="{{$pt->id}}">{{$pt->name}}</option>'
                        +'        @endforeach'
                        +'    </select>'

                        +'    @if ($errors->has('property_type'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('property_type') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'
                        +'<div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }} col-2">'
                        +'    <label class="form-control-label" for="input-category">{{ __('Category') }}</label>'
                        +'    <select name="unit['+rowId+'][category]"  class="form-control select'+rowId+'" required>'
                        +'        <option value="">Select Category</option>'
                        +'        @foreach (getCategories() as $cat)'
                        +'            <option value="{{$cat->id}}">{{$cat->name}}</option>'
                        +'        @endforeach'
                        +'    </select>'

                        +'    @if ($errors->has('category'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('category') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'
                        +'<div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }} col-2">'
                        +'    <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>'
                        +'    <input type="number" name="unit['+rowId+'][quantity]" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="Enter Quantity" value="{{old('quantity')}}"  readonly="readonly">' 
                        +'    @if ($errors->has('quantity'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('quantity') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>         '          
                        +'<div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-2">'
                        +'    <label class="form-control-label" for="input-standard_price">{{ __('Standard Price') }}</label>'
                        +'    <input type="number" name="unit['+rowId+'][standard_price]" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="Enter Standard Price" value="{{old('standard_price')}}" required>'

                        +'    @if ($errors->has('standard_price'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('standard_price') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'
                        +'<div style="clear:both"></div>'
                                  +'<div class="form-group{{ $errors->has('rent_commission') ? ' has-danger' : '' }} col-2">'
                                    +'<label class="form-control-label" for="input-standard_price">{{ __('Rent Commission') }}</label>'
                                   +'<input type="number" min="1" name="unit['+rowId+'][rent_commission]" id="input-rent_commission" class="form-control {{ $errors->has('rent_commission') ? ' is-invalid' : '' }} rent_commission" placeholder="Enter Rent Commission" value="{{old('rent_commission')}}" required>'

                                    @if ($errors->has('rent_commission'))
                                        +'<span class="invalid-feedback" role="alert">'
                                           +'<strong>{{ $errors->first('rent_commission') }}</strong>'
                                        +'</span>'
                                    @endif
                                +'</div>' 
                    +'</div>'
                +'</div>'
            );
            row++;
            $(".select"+rowId).select2({
                    theme: "bootstrap"
                });
        });

        // Remove parent of 'remove' link when link is clicked.
        $('#container').on('click', '.remove_project_file', function(e) {
            e.preventDefault();
            $(this).parent().remove();
            row--;
        });
        $('#containerSC').on('click', '.remove_project_file', function(e) {
            e.preventDefault();
            $(this).parent().remove();
            rowsc--;
        });

        var rowsc = 1;

        $('#addMoreSC').click(function(e) {
            e.preventDefault();

            if(rowsc >= 5){
                alert("You've reached the maximum limit");
                return;
            }

            var rowId = identifier();

            $("#containerSC").append(
                '<div>'
                    +'<div style="float:right" class="remove_project_file"><span style="cursor:pointer" class="badge badge-danger" border="2">Remove</span></div>'
                    +'<div style="clear:both"></div>'
                    +'<div class="row" id="rowNumber'+rowId+'" data-row="'+rowId+'">'
                        +'<div class="form-group col-4">'
                        +'    <label class="form-control-label" for="input-category">{{ __('Type') }}</label>'
                        +'    <select name="service['+rowId+'][type]" class="form-control sc_type select'+rowId+'" data-row="'+rowId+'" required>'
                        +'        <option value="">Select Type</option>'
                        +'        <option value="fixed">Fixed</option>'
                        +'        <option value="variable">Variable</option>'
                        +'    </select>'
                        +'</div>'
                        +'<div class="form-group col-4">'
                        +'    <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>'
                        +'    <select name="service['+rowId+'][service_charge]" id="serviceCharge'+rowId+'" class="form-control select'+rowId+'" required>'
                        +'        <option value="">Select Service Charge</option>'
                        +'    </select>'
                        +'</div>       '            
                        +'<div class="form-group col-4">'
                        +'    <label class="form-control-label" for="input-price">{{ __('Price') }}</label>'
                        +'    <input type="number" name="service['+rowId+'][price]" id="input-price" class="form-control" placeholder="Enter Price" required>'
                        +'</div>'
                        +'<div style="clear:both"></div>'
                    +'</div>'
                +'</div>'
            );
            rowsc++;
            $(".select"+rowId).select2({
                theme: "bootstrap"
            });
        });

          $(document).on('keyup', '#input-asking_price', function(e){
    e.preventDefault();
    let value = e.target.value;
if(value <= 0){
     $(this).val('');
}
 });
        
    </script>
@endsection