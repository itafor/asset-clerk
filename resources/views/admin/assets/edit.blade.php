@extends('layouts.app', ['title' => __('Edit Asset')])

@section('content')
    @include('admin.assets.partials.header', ['title' => __('Edit Asset')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Asset Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('asset.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('asset.update') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="uuid" value="{{$asset->uuid}}">
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Basic information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Description') }}</label>
                                    <input type="text" name="description" id="input-name" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Description') }}" value="{{ old('description', $asset->description) }}" required autofocus>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-category">{{ __('Category') }}</label>
                                    <select name="category"  class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach (getCategories() as $cat)
                                            <option value="{{$cat->id}}" {{$cat->id == $asset->category_id ? 'selected' : ''}}>{{$cat->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('category'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>
                                    <input type="number" name="quantity" id="input-quantity" class="form-control form-control-alternative{{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="Enter Quantity" value="{{old('quantity', $asset->quantity_added)}}" required>
                                    
                                    @if ($errors->has('quantity'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>

                                <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-standard_price">{{ __('Standard Price') }}</label>
                                    <input type="number" name="standard_price" id="input-standard_price" class="form-control form-control-alternative{{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="Enter Standard Price" value="{{old('standard_price', $asset->price)}}" required>

                                    @if ($errors->has('standard_price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('standard_price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('landlord') ? ' has-danger' : '' }}" style="width:50%; float:right">
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
                                <div style="clear:both"></div>                         
                            </div>


                            <h6 class="heading-small text-muted mb-4">{{ __('Location') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}" style="width:47%; float:left">
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
                                <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}" style="width:50%; float:right">
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
                                <div style="clear:both"></div>                         
                                <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}" style="width:47%; float:left">
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
                                <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-state">{{ __('Address') }}</label>
                                    <input type="text" name="address" id="input-address" class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Enter Address" value="{{old('address',$asset->address)}}" required>
                                    
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>                         
                            </div>

                            <h6 class="heading-small text-muted mb-4">{{ __('Detailed information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('photos') ? ' has-danger' : '' }}">
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
                                <div class="form-group{{ $errors->has('detailed_information') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-detailed_information">{{ __('Detailed Information') }}</label>
                                    <textarea rows="5" name="detailed_information" id="input-detailed_information" class="form-control form-control-alternative{{ $errors->has('detailed_information') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Detailed Information') }}" required autofocus>{{ old('detailed_information', $asset->detailed_information) }}</textarea>

                                    @if ($errors->has('detailed_information'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('detailed_information') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('building_age') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-category">{{ __('Building Age (Optional)') }}</label>
                                    <select class="form-control" name="building_age">
                                        <option value="">Select Building Age</option>
                                        @foreach (getBuildingAges() as $age)
                                            <option value="{{$age->id}}" {{$age->id == $asset->building_age_id ? 'selected' : ''}}>{{$age->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('building_age'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('building_age') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('bedrooms') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-bedrooms">{{ __('Bedrooms (Optional)') }}</label>
                                    <select class="form-control" name="bedrooms">
                                        <option value="">Select Bedrooms</option>
                                        <option {{$asset->bedrooms == 1 ? 'selected' : ''}}>1</option>
                                        <option {{$asset->bedrooms == 2 ? 'selected' : ''}}>2</option>
                                        <option {{$asset->bedrooms == 3 ? 'selected' : ''}}>3</option>
                                        <option {{$asset->bedrooms == 4 ? 'selected' : ''}}>4</option>
                                        <option {{$asset->bedrooms == 5 ? 'selected' : ''}}>5</option>
                                        <option {{$asset->bedrooms == 6 ? 'selected' : ''}}>6</option>
                                    </select>
                                    
                                    @if ($errors->has('bedrooms'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bedrooms') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>
                                <div class="form-group{{ $errors->has('bathrooms') ? ' has-danger' : '' }}" style="width:47%">
                                    <label class="form-control-label" for="input-bathrooms">{{ __('Bathrooms (Optional)') }}</label>
                                    <select class="form-control" name="bathrooms">
                                        <option value="">Select Bathrooms</option>
                                        <option {{$asset->bathrooms == 1 ? 'selected' : ''}}>1</option>
                                        <option {{$asset->bathrooms == 2 ? 'selected' : ''}}>2</option>
                                        <option {{$asset->bathrooms == 3 ? 'selected' : ''}}>3</option>
                                        <option {{$asset->bathrooms == 4 ? 'selected' : ''}}>4</option>
                                        <option {{$asset->bathrooms == 5 ? 'selected' : ''}}>5</option>
                                        <option {{$asset->bathrooms == 6 ? 'selected' : ''}}>6</option>
                                    </select>
                                    
                                    @if ($errors->has('bathrooms'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bathrooms') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>                         
                            </div>

                            <h6 class="heading-small text-muted mb-4">{{ __('Features') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('features') ? ' has-danger' : '' }}">
                                    @foreach (getAssetFeatures() as $feature)
                                        <label style="margin-right:25px">
                                            <input type="checkbox" name="features[]" {{in_array($feature->id,explode(',', $asset->features)) ? 'checked' : ''}} value="{{$feature->id}}"> {{$feature->name}}
                                        </label>
                                    @endforeach
                                    
                                
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save Changes') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
    
@endsection 

@section('script')
    <script>
        
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
        
    </script>
@endsection