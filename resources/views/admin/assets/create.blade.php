@extends('layouts.app', ['title' => __('Add Asset')])

@section('content')
    @include('admin.assets.partials.header', ['title' => __('Add Asset')])   

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
                        <form method="post" action="{{ route('asset.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Basic information') }}</h6>
                            <div class="pl-lg-4">
                            <input type="text" name="default_quantity" value="1">
                                
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Description') }}</label>
                                    <textarea rows="5" name="description" id="input-name" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Description') }}" required autofocus>{{ old('description') }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div style="clear:both"></div>       
                                <div class="form-group{{ $errors->has('landlord') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-landlord">{{ __('Landlord') }}</label>
                                    <select name="landlord"  class="form-control" required>
                                        <option value="">Select Landlord</option>
                                        @foreach (getLandlords() as $land)
                                            <option value="{{$land->id}}">{{$land->name()}}</option>
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
                                            <option value="{{$c->id}}">{{$c->name}}</option>
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
                                    </select>

                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-state">{{ __('Address') }}</label>
                                    <input type="text" name="address" id="input-address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Enter Address" value="{{old('address')}}" required>
                                    
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>                         
                            </div>
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Service Charge') }}</h6>
                            @if(count($errors) > 0)
                            <div class="pl-lg-4">
                                @foreach (old('service') as $key => $value)
                                <div class="form-group {{ $errors->has('service.'.$key.'.category') ? 'has-danger':'' }}" style="width:31%; float:left; margin-right:25px">
                                    <label class="form-control-label" for="input-category">{{ __('Type') }}</label>
                                    <select name="service[{{$key}}][type]"  class="form-control sc_type" data-row="{{$key}}" required>
                                        <option value="">Select Type</option>
                                        <option value="fixed" {{old('service.'.$key.'.type') == 'fixed' ? 'selected' : ''}}>Fixed</option>
                                        <option value="variable" {{old('service.'.$key.'.type') == 'variable' ? 'selected' : ''}}>Variable</option>
                                    </select>
                                </div>
                                <div class="form-group {{ $errors->has('service.'.$key.'.service_charge') ? 'has-danger':'' }}" style="width:31%; float:left; margin-right:25px">
                                    <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>
                                    <select name="service[{{$key}}][service_charge]" id="serviceCharge{{$key}}" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach (getServiceCharge(old('service.'.$key.'.type')) as $sc)
                                            <option value="{{$sc->id}}">{{$sc->name}}</option>
                                        @endforeach
                                    </select>
                                </div>                   
                                <div class="form-group {{ $errors->has('service.'.$key.'.price') ? 'has-danger':'' }}" style="width:31%; float:left">
                                    <label class="form-control-label" for="input-standard_price">{{ __('Price') }}</label>
                                    <input type="number" name="service[{{$key}}][price]" id="input-{{$key}}" class="form-control {{ $errors->has('service.'.$key.'.price') ? ' is-invalid' : '' }}" placeholder="Enter Price" value="{{old('service.'.$key.'.price')}}" required>
                                </div>
                                <div style="clear:both"></div>
                                @endforeach
                                <div id="containerSC">
                                </div>   
                                <div class="form-group">
                                    <button type="button" id="addMoreSC" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                                </div> 
                            </div>
                            @else
                            <div class="pl-lg-4">
                                <div class="form-group" style="width:31%; float:left; margin-right:25px">
                                    <label class="form-control-label" for="input-category">{{ __('Type') }}</label>
                                    <select name="service[112211][type]" class="form-control sc_type" data-row="112211" required>
                                        <option value="">Select Type</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="variable">Variable</option>
                                    </select>
                                </div>
                                <div class="form-group" style="width:31%; float:left; margin-right:25px">
                                    <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>
                                    <select name="service[112211][service_charge]" id="serviceCharge112211" class="form-control" required>
                                        <option value="">Select Service Charge</option>
                                    </select>
                                </div>                   
                                <div class="form-group" style="width:31%; float:left">
                                    <label class="form-control-label" for="input-price">{{ __('Price') }}</label>
                                    <input type="number" name="service[112211][price]" id="input-price" class="form-control" placeholder="Enter Price" required>
                                </div>
                                <div style="clear:both"></div>
                                <div id="containerSC">
                                </div>   
                                <div class="form-group">
                                    <button type="button" id="addMoreSC" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                                </div>                         
                            </div>
                            @endif
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Units') }}</h6>
                            @if(count($errors) > 0)
                            <div class="pl-lg-4">
                                @foreach (old('unit') as $key => $value)
                                <div class="form-group {{ $errors->has('unit.'.$key.'.category') ? 'has-danger':'' }}" style="width:31%; float:left; margin-right:25px">
                                    <label class="form-control-label" for="input-category">{{ __('Category') }}</label>
                                    <select name="unit[{{$key}}][category]"  class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach (getCategories() as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>

                                    {{-- @if ($errors->has('unit.'.$key.'.category'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('unit.'.$key.'.category') }}</strong>
                                        </span>
                                    @endif --}}
                                </div>
                                <div class="form-group {{ $errors->has('unit.'.$key.'.quantity') ? 'has-danger':'' }}" style="width:31%; float:left; margin-right:25px">
                                    <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>
                                    <input type="number" name="unit[{{$key}}][quantity]" id="input-quantity{{$key}}" class="form-control {{ $errors->has('unit.'.$key.'.quantity') ? ' is-invalid' : '' }}" placeholder="Enter Quantity" value="{{old('unit.'.$key.'.quantity')}}" required>
                                {{--                                     
                                    @if ($errors->has('unit.'.$key.'.quantity'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('unit.'.$key.'.quantity') }}</strong>
                                        </span>
                                    @endif --}}
                                </div>                   
                                <div class="form-group {{ $errors->has('unit.'.$key.'.standard_price') ? 'has-danger':'' }}" style="width:31%; float:left">
                                    <label class="form-control-label" for="input-standard_price">{{ __('Standard Price') }}</label>
                                    <input type="number" name="unit[{{$key}}][standard_price]" id="input-standard_price{{$key}}" class="form-control {{ $errors->has('unit.'.$key.'.standard_price') ? ' is-invalid' : '' }}" placeholder="Enter Standard Price" value="{{old('unit.'.$key.'.standard_price')}}" required>

                                    {{-- @if ($errors->has('unit.'.$key.'.standard_price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('unit.'.$key.'.standard_price') }}</strong>
                                        </span>
                                    @endif --}}
                                </div>
                                <div style="clear:both"></div>
                                @endforeach
                                <div id="container">
                                </div>   
                                <div class="form-group">
                                    <button type="button" id="addMore" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                                </div> 
                            </div>
                            @else
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}" style="width:31%; float:left; margin-right:25px">
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
                                <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}" style="width:31%; float:left; margin-right:25px">
                                    <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>
                                    <input type="number" name="unit[112211][quantity]" id="input-quantity" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="Enter Quantity" value="{{old('quantity')}}" required>
                                    
                                    @if ($errors->has('quantity'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>                   
                                <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }}" style="width:31%; float:left">
                                    <label class="form-control-label" for="input-standard_price">{{ __('Standard Price') }}</label>
                                    <input type="number" name="unit[112211][standard_price]" id="input-standard_price" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="Enter Standard Price" value="{{old('standard_price')}}" required>

                                    @if ($errors->has('standard_price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('standard_price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>
                                <div id="container">
                                </div>   
                                <div class="form-group">
                                    <button type="button" id="addMore" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                                </div>                         
                            </div>
                            @endif

                            <h6 class="heading-small text-muted mb-4">{{ __('Detailed information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('photos') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-photos">{{ __('Photos of Property') }}</label>
                                    <input type="file" multiple name="photos[]" id="input-photos" class="form-control {{ $errors->has('photos') ? ' is-invalid' : '' }}" required>

                                    @if ($errors->has('photos'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('photos') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('detailed_information') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-detailed_information">{{ __('Detailed Information') }}</label>
                                    <textarea rows="5" name="detailed_information" id="input-detailed_information" class="form-control {{ $errors->has('detailed_information') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Detailed Information') }}" required autofocus>{{ old('detailed_information') }}</textarea>

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
                                            <option value="{{$age->id}}">{{$age->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('building_age'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('building_age') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- <div class="form-group{{ $errors->has('bedrooms') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-bedrooms">{{ __('Bedrooms (Optional)') }}</label>
                                    <select class="form-control" name="bedrooms">
                                        <option value="">Select Bedrooms</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                    </select>
                                    
                                    @if ($errors->has('bedrooms'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bedrooms') }}</strong>
                                        </span>
                                    @endif
                                </div> --}}
                                <div style="clear:both"></div>
                                {{-- <div class="form-group{{ $errors->has('bathrooms') ? ' has-danger' : '' }}" style="width:47%">
                                    <label class="form-control-label" for="input-bathrooms">{{ __('Bathrooms (Optional)') }}</label>
                                    <select class="form-control" name="bathrooms">
                                        <option value="">Select Bathrooms</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                    </select>
                                    
                                    @if ($errors->has('bathrooms'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bathrooms') }}</strong>
                                        </span>
                                    @endif
                                </div> --}}
                                <div style="clear:both"></div>                         
                            </div>

                            <h6 class="heading-small text-muted mb-4">{{ __('Features') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('detailed_information') ? ' has-danger' : '' }}">
                                    @foreach (getAssetFeatures() as $feature)
                                        <label style="margin-right:25px">
                                            <input type="checkbox" name="features[]"  value="{{$feature->id}}"> {{$feature->name}}
                                        </label>
                                    @endforeach
                                    
                                
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
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

        var row = 1;

        $('#addMore').click(function(e) {
            e.preventDefault();

            if(row >= 5){
                alert("You've reached the maximum limit");
                return;
            }

            var rowId = identifier();

            $("#container").append(
                '<div id="rowNumber'+rowId+'" data-row="'+rowId+'">'
                    +'<div style="float:left" class="remove_project_file"><a href="#" class=" btn btn-danger btn-sm"  border="2">Remove</a></div>'
                    +'<div style="clear:both"></div>'
                    +'<div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}" style="width:31%; float:left; margin-right:25px">'
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
                    +'<div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}" style="width:31%; float:left; margin-right:25px">'
                    +'    <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>'
                    +'    <input type="number" name="unit['+rowId+'][quantity]" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="Enter Quantity" value="{{old('quantity')}}" required>' 
                    +'    @if ($errors->has('quantity'))'
                    +'        <span class="invalid-feedback" role="alert">'
                    +'            <strong>{{ $errors->first('quantity') }}</strong>'
                    +'        </span>'
                    +'    @endif'
                    +'</div>         '          
                    +'<div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }}" style="width:31%; float:left">'
                    +'    <label class="form-control-label" for="input-standard_price">{{ __('Standard Price') }}</label>'
                    +'    <input type="number" name="unit['+rowId+'][standard_price]" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="Enter Standard Price" value="{{old('standard_price')}}" required>'

                    +'    @if ($errors->has('standard_price'))'
                    +'        <span class="invalid-feedback" role="alert">'
                    +'            <strong>{{ $errors->first('standard_price') }}</strong>'
                    +'        </span>'
                    +'    @endif'
                    +'</div>'
                    +'<div style="clear:both"></div>'
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
                '<div id="rowNumber'+rowId+'" data-row="'+rowId+'">'
                    +'<div style="float:left" class="remove_project_file"><a href="#x" class=" btn btn-danger btn-sm"  border="2">Remove</a></div>'
                    +'<div style="clear:both"></div>'
                    +'<div class="form-group" style="width:31%; float:left; margin-right:25px">'
                    +'    <label class="form-control-label" for="input-category">{{ __('Type') }}</label>'
                    +'    <select name="service['+rowId+'][type]" class="form-control sc_type select'+rowId+'" data-row="'+rowId+'" required>'
                    +'        <option value="">Select Type</option>'
                    +'        <option value="fixed">Fixed</option>'
                    +'        <option value="variable">Variable</option>'
                    +'    </select>'
                    +'</div>'
                    +'<div class="form-group" style="width:31%; float:left; margin-right:25px">'
                    +'    <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>'
                    +'    <select name="service['+rowId+'][service_charge]" id="serviceCharge'+rowId+'" class="form-control select'+rowId+'" required>'
                    +'        <option value="">Select Service Charge</option>'
                    +'    </select>'
                    +'</div>       '            
                    +'<div class="form-group" style="width:31%; float:left">'
                    +'    <label class="form-control-label" for="input-price">{{ __('Price') }}</label>'
                    +'    <input type="number" name="service['+rowId+'][price]" id="input-price" class="form-control" placeholder="Enter Price" required>'
                    +'</div>'
                    +'<div style="clear:both"></div>'
                +'</div>'
            );
            rowsc++;
            $(".select"+rowId).select2({
                theme: "bootstrap"
            });
        });

        
    </script>
@endsection