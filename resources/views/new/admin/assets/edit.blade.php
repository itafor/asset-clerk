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
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Basic information') }}</h6>
                            <div class="row">
                            <input type="text" name="default_quantity" value="1">
                                
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} col-12">
                                    <label class="form-control-label" for="input-name">{{ __('Description') }}</label>
                                    <textarea rows="5" name="description" id="input-name" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Description') }}" required autofocus>{{ old('description', $asset->description) }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('landlord') ? ' has-danger' : '' }} col-12">
                                    <label class="form-control-label" for="input-landlord">{{ __('Landlord') }}</label>
                                    <select name="landlord"  class="form-control" required>
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

                            <h6 class="heading-small text-muted mb-4">{{ __('Property Type') }}</h6>
                            @if(count($errors) > 0)
                                @foreach (old('unit') as $key => $value)
                                <div style="float:right"><a href="{{route('asset.delete.unit', ['id' => $key])}}" class=" badge badge-danger btn-sm" data-confirm border="2">Remove</a></div>
                                <div style="clear:both"></div>
                                <div class="row">
                                    <div dfdd="{{$key}}" class="form-group {{ $errors->has('unit.'.$key.'.property_type') ? 'has-danger':'' }} col-3">
                                        <label class="form-control-label" for="input-property_type">{{ __('Property Type') }}</label>
                                        <select name="unit[{{$key}}][property_type]"  class="form-control" required>
                                            <option value="">Select Property Thype</option>
                                            @foreach (getPropertyTypes() as $pt)
                                                <option value="{{$pt->id}}" {{$pt->id == old("unit.{$key}.property_type") ? 'selected' : ''}}>{{$pt->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group {{ $errors->has('unit.'.$key.'.category') ? 'has-danger':'' }} col-3">
                                        <label class="form-control-label" for="input-category">{{ __('Category') }}</label>
                                        <select name="unit[{{$key}}][category]"  class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach (getCategories() as $cat)
                                                <option value="{{$cat->id}}" {{$cat->id == old("unit.{$key}.category") ? 'selected' : ''}}>{{$cat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group {{ $errors->has('unit.'.$key.'.quantity') ? 'has-danger':'' }} col-3">
                                        <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>
                                        <input type="number" name="unit[{{$key}}][quantity]" id="input-quantity{{$key}}" class="form-control {{ $errors->has('unit.'.$key.'.quantity') ? ' is-invalid' : '' }}" placeholder="Enter Quantity" value="{{old('unit.'.$key.'.quantity')}}" required>

                                        </div>                   
                                    <div class="form-group {{ $errors->has('unit.'.$key.'.standard_price') ? 'has-danger':'' }} col-3">
                                        <label class="form-control-label" for="input-standard_price">{{ __('Property Estimate') }}</label>
                                        <input type="number" name="unit[{{$key}}][standard_price]" id="input-standard_price{{$key}}" class="form-control {{ $errors->has('unit.'.$key.'.standard_price') ? ' is-invalid' : '' }}" placeholder="Enter Standard Price" value="{{old('unit.'.$key.'.standard_price')}}" required>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                                @endforeach
                            <!--     <div id="container">
                                </div>   
                                <div class="form-group">
                                    <button type="button" id="addMore" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                                </div> -->
                            @else
                                @if ($asset->units->count() > 0)
                                    @foreach ($asset->units as $unit)
                                    <div style="float:right"><a href="{{route('asset.delete.unit', ['id' => $unit->id])}}" class=" badge badge-danger btn-sm" data-confirm border="2">Remove</a></div>
                                    <div style="clear:both"></div>
                                    <div class="row">

<div class="form-group{{ $errors->has('apartment_type') ? ' has-danger' : '' }} col-2">
    <label class="form-control-label" for="input-property_type">{{ __('Property Used') }}</label>
                                      
    <div class="form-check">
      <label class="form-check-label" for="radio1">
        <input type="radio" name="unit[{{$unit->uuid}}][apartment_type]" class="form-check-input" placeholder="Enter Apartment Type" value="{{old('apartment_type', $unit->apartment_type == 'Residential' ? 'Residential':'Residential')}}" required {{$unit->apartment_type == 'Residential'? 'checked':''}} > Residential
      </label>
    </div>
    <div class="form-check">
      <label class="form-check-label" for="radio2">
       <input type="radio" name="unit[{{$unit->uuid}}][apartment_type]" class="form-check-input" placeholder="Enter Apartment Type" value="{{old('apartment_type', $unit->apartment_type == 'Commercial'?'Commercial':'Commercial')}}"  required {{$unit->apartment_type == 'Commercial'? 'checked':''}} >Commercial
      </label>
    </div>

    @if ($errors->has('apartment_type'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('apartment_type') }}</strong>
            </span>
    @endif
</div>




                                        <div class="form-group{{ $errors->has('property_type') ? ' has-danger' : '' }} col-2">
                                            <label class="form-control-label" for="input-property_type">{{ __('Property Type') }}</label>
                                            <select name="unit[{{$unit->uuid}}][property_type]"  class="form-control" required>
                                                <option value="">Select Property Type</option>
                                                @foreach (getPropertyTypes() as $pt)
                                                    <option value="{{$pt->id}}" {{$pt->id == $unit->property_type_id ? 'selected' : ''}}>{{$pt->name}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('property_type'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('property_type') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }} col-2">
                                            <label class="form-control-label" for="input-category">{{ __('Category') }}</label>
                                            <select name="unit[{{$unit->uuid}}][category]"  class="form-control" required>
                                                <option value="">Select Category</option>
                                                @foreach (getCategories() as $cat)
                                                    <option value="{{$cat->id}}" {{$cat->id == $unit->category_id ? 'selected' : ''}}>{{$cat->name}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('category'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('category') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }} col-2">
                                            <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>
                                            <input type="number" name="unit[{{$unit->uuid}}][quantity]" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="Enter Quantity" value="{{old('quantity', $unit->quantity)}}"  readonly="readonly">
                                            
                                            @if ($errors->has('quantity'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('quantity') }}</strong>
                                                </span>
                                            @endif
                                        </div>                   
                                        <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-2">
                                            <label class="form-control-label" for="input-standard_price">{{ __('Property Estimate') }}</label>
                                            <input type="number" name="unit[{{$unit->uuid}}][standard_price]" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="Enter Standard Price" value="{{old('standard_price', $unit->standard_price)}}" required>

                                            @if ($errors->has('standard_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('standard_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div style="clear:both"></div>
                                                <div class="form-group{{ $errors->has('rent_commission') ? ' has-danger' : '' }} col-2">
                                    <label class="form-control-label" for="input-standard_price">{{ __('Rent Commission') }}</label>
                                    <input type="number" min="1" name="unit[{{$unit->uuid}}][rent_commission]" id="input-rent_commission" class="form-control {{ $errors->has('rent_commission') ? ' is-invalid' : '' }} rent_commission" placeholder="Enter Rent Commission" value="{{old('rent_commission', $unit->rent_commission)}}" required>

                                    @if ($errors->has('rent_commission'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('rent_commission') }}</strong>
                                        </span>
                                    @endif
                                </div>                           
                                    </div>
                                    @endforeach
                                 <!--    <div id="container">
                                        </div>  
                                    <div class="form-group">
                                        <button type="button" id="addMore" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                                    </div> --> 
                                @else
                                <div class="row">
                                    <!-- Apartment types -->

<div class="form-group{{ $errors->has('apartment_type') ? ' has-danger' : '' }} col-2">
<label class="form-control-label" for="input-property_type">{{ __('Property Used') }}</label>
                                      
    <div class="form-check">
      <label class="form-check-label" for="radio1">
        <input type="radio" name="unit[{{$unit->uuid}}][apartment_type]" class="form-check-input" placeholder="Enter Apartment Type" value="{{old('apartment_type', $unit->apartment_type == 'Residential' ? 'Residential':'Residential')}}" required {{$unit->apartment_type == 'Residential'? 'checked':''}} > Residential
      </label>
    </div>
    <div class="form-check">
      <label class="form-check-label" for="radio2">
       <input type="radio" name="unit[{{$unit->uuid}}][apartment_type]" class="form-check-input" placeholder="Enter Apartment Type" value="{{old('apartment_type', $unit->apartment_type == 'Commercial'?'Commercial':'Commercial')}}"  required {{$unit->apartment_type == 'Commercial'? 'checked':''}} >Commercial
      </label>
    </div>

    @if ($errors->has('apartment_type'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('apartment_type') }}</strong>
            </span>
    @endif
</div>

                                        <div class="form-group{{ $errors->has('property_type') ? ' has-danger' : '' }} col-2">
                                            <label class="form-control-label" for="input-property_type">{{ __('Property Type') }}</label>
                                            <select name="unit[{{$unit->uuid}}][property_type]"  class="form-control" required>
                                                <option value="">Select Property Type</option>
                                                @foreach (getPropertyTypes() as $pt)
                                                    <option value="{{$pt->id}}">{{$pt->name}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('property_type'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('property_type') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }} col-2">
                                            <label class="form-control-label" for="input-category">{{ __('Category') }}</label>
                                            <select name="unit[112211][category]"  class="form-control" required>
                                                <option value="">Select Category</option>
                                                @foreach (getCategories() as $cat)
                                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                @endforeach
                                            </select>
        
                                            @if ($errors->has('category'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('category') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }} col-2">
                                            <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>
                                            <input type="number" name="unit[112211][quantity]" id="input-quantity" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="Enter Quantity" value="{{old('quantity')}}" >
                                            
                                            @if ($errors->has('quantity'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('quantity') }}</strong>
                                                </span>
                                            @endif
                                        </div>                   
                                        <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-2">
                                            <label class="form-control-label" for="input-standard_price">{{ __('Standard Price') }}</label>
                                            <input type="number" name="unit[112211][standard_price]" id="input-standard_price" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="Enter Standard Price" value="{{old('standard_price')}}" required>
        
                                            @if ($errors->has('standard_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('standard_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    <div class="form-group{{ $errors->has('rent_commission') ? ' has-danger' : '' }} col-2">
                                    <label class="form-control-label" for="input-standard_price">{{ __('Rent Commission') }}</label>
                                    <input type="number" min="1" name="unit[112211][rent_commission]" id="input-rent_commission" class="form-control {{ $errors->has('rent_commission') ? ' is-invalid' : '' }} rent_commission" placeholder="Enter Rent Commission" value="{{old('rent_commission')}}" required>

                                    @if ($errors->has('rent_commission'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('rent_commission') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                </div>
                                        <div style="clear:both"></div>
                                 <!--        <div id="container">
                                        </div>   
                                        <div class="form-group">
                                            <button type="button" id="addMore" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                                        </div> --> 
                                @endif  
                            @endif

                            <h6 class="heading-small text-muted mb-4">{{ __('Additional information') }}</h6>
                            <div class="row">
                                <div class="form-group{{ $errors->has('photos') ? ' has-danger' : '' }} col-12">
                                    <label class="form-control-label" for="input-photos">{{ __('Photos of Property') }}</label>
                                    <input type="file" multiple name="photos[]" id="input-photos" class="form-control form-control-alternative{{ $errors->has('photos') ? ' is-invalid' : '' }}">
                                    
                                    @if ($errors->has('photos'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('photos') }}</strong>
                                        </span>
                                    @endif

                                    @foreach ($asset->photos as $photo)
                                        <div class="card" style="width: 18rem; margin-top:15px; float:left; margin-right:15px">
                                            <img class="card-img-top" src="{{$photo->image_url}}">
                                            <div class="card-body">
                                                <a href="{{route('asset.delete.image', ['id' => $photo->id])}}" class="btn btn-danger btn-sm" onclick="confirm('{{ __("Are you sure you want to delete this photo?") }}') ? true : false">Remove</a>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div style="clear:both"></div>
                                </div>
                                <div class="form-group{{ $errors->has('detailed_information') ? ' has-danger' : '' }} col-12">
                                    <label class="form-control-label" for="input-detailed_information">{{ __('Detailed Information') }}</label>
                                    <textarea rows="5" name="detailed_information" id="input-detailed_information" class="form-control form-control-alternative{{ $errors->has('detailed_information') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Detailed Information') }}" required autofocus>{{ old('detailed_information', $asset->detailed_information) }}</textarea>

                                    @if ($errors->has('detailed_information'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('detailed_information') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('construction_year') ? ' has-danger' : '' }} col-4">
                                    <label class="form-control-label" for="input-category">{{ __('Year of Construction (Optional)') }}</label>
                                    <select class="form-control" name="construction_year">
                                        <option value="">Select Year</option>
                                        @for ($i = date('Y'); $i > (date('Y') - 50) ; $i--)
                                            <option value="{{$i}}" {{old('construction_year',$asset->construction_year) == $i ? 'selected' : ''}}>{{$i}}</option>
                                        @endfor
                                    </select>

                                    @if ($errors->has('construction_year'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('construction_year') }}</strong>
                                        </span>
                                    @endif
                                </div>
                             <!--    <div class="form-group{{ $errors->has('commission') ? ' has-danger' : '' }} col-4">
                                    <label class="form-control-label" for="input-commission">{{ __('Commission (%)') }}</label>
                                    <input type="text"  name="commission" id="input-commission" class="form-control {{ $errors->has('commission') ? ' is-invalid' : '' }}" placeholder="Enter Commission" value="{{old('commission', $asset->commission)}}" required>

                                    @if ($errors->has('commission'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('commission') }}</strong>
                                        </span>
                                    @endif
                                </div> -->
                                <div style="clear:both"></div>                         
                            </div>

                            <h6 class="heading-small text-muted mb-4">{{ __('Features') }}</h6>
                            <div class="row">
                                <div class="form-group{{ $errors->has('features') ? ' has-danger' : '' }} col-12">
                                    @foreach (getAssetFeatures() as $feature)
                                        <div class="custom-control custom-checkbox custom-control-inline" style="margin-right:25px; float:left">
                                            <input type="checkbox" id="customcheckboxInline{{$loop->iteration}}" name="features[]" value="{{$feature->id}}"
                                                class="custom-control-input"  {{in_array($feature->id,explode(',', $asset->features)) ? 'checked' : ''}}>
                                            <label class="custom-control-label" for="customcheckboxInline{{$loop->iteration}}">{{$feature->name}}</label>
                                        </div>
                                    @endforeach
                                    
                                
                                </div>
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
        {{-- @include('admin.assets.partials.addUnit') --}}
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

        
    </script>
@endsection