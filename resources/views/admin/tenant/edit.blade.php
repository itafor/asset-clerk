@extends('layouts.app', ['title' => __('Edit Tenant')])

@section('content')
    @include('admin.tenant.partials.header', ['title' => __('Edit Tenant')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Tenant Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('tenant.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('tenant.update') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="uuid" value="{{$tenant->uuid}}">
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Tenant') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('designation') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-category">{{ __('Designation') }}</label>
                                    <select name="designation" id="" class="form-control" required autofocus>
                                        <option value="">Select Designation</option>
                                        <option {{$tenant->designation == 'Mr' ? 'selected' : ''}}>Mr</option>
                                        <option {{$tenant->designation == 'Mrs' ? 'selected' : ''}}>Mrs</option>
                                        <option {{$tenant->designation == 'Miss' ? 'selected' : ''}}>Miss</option>
                                    </select>

                                    @if ($errors->has('designation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('designation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-gender">{{ __('Gender') }}</label>
                                    <select name="gender" id="" class="form-control" required>
                                        <option value="">Select Gender</option>
                                        <option {{$tenant->gender == 'Male' ? 'selected' : ''}}>Male</option>
                                        <option {{$tenant->gender == 'Female' ? 'selected' : ''}}>Female</option>
                                    </select>
                                    
                                    @if ($errors->has('gender'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>

                                <div class="form-group{{ $errors->has('firstname') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-firstname">{{ __('First Name') }}</label>
                                    <input type="text" name="firstname" id="input-firstname" class="form-control form-control-alternative{{ $errors->has('firstname') ? ' is-invalid' : '' }}" placeholder="Enter First Name" value="{{old('firstname', $tenant->firstname)}}" required>

                                    @if ($errors->has('firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('lastname') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-lastname">{{ __('Last Name') }}</label>
                                    <input type="text" name="lastname" id="input-lastname" class="form-control form-control-alternative{{ $errors->has('lastname') ? ' is-invalid' : '' }}" placeholder="Enter Last Name" value="{{old('lastname', $tenant->lastname)}}" required>
                                    
                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>         

                                <div class="form-group{{ $errors->has('date_of_birth') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-date_of_birth">{{ __('Date of Birth') }}</label>
                                    <input type="text" name="date_of_birth" id="input-date_of_birth" class="datepicker form-control form-control-alternative{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" placeholder="Select Date of Birth" value="{{old('date_of_birth', formatDate($tenant->date_of_birth,'Y-m-d','m/d/Y'))}}" required>

                                    @if ($errors->has('date_of_birth'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date_of_birth') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('occupation') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-occupation">{{ __('Occupation') }}</label>
                                    <input type="text" name="occupation" id="input-occupation" class="form-control form-control-alternative{{ $errors->has('occupation') ? ' is-invalid' : '' }}" placeholder="Enter Occupation" value="{{old('occupation', $tenant->occupation)}}" required>
                                    
                                    @if ($errors->has('occupation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('occupation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>                         
                            </div>


                            <h6 class="heading-small text-muted mb-4">{{ __('Office Location') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('office_country') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-country">{{ __('Country') }}</label>
                                    <select name="office_country" class="form-control country" required>
                                        <option value="">Select Country</option>
                                        @foreach (getCountries() as $c)
                                            <option value="{{$c->id}}" {{$c->id == $tenant->office_country_id ? 'selected' : ''}}>{{$c->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('office_country'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('office_country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('office_state') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-state">{{ __('State') }}</label>
                                    <select name="office_state" class="form-control state" required>
                                        <option value="">Select State</option>
                                        @foreach (getStates($tenant->office_country_id) as $state)
                                            <option value="{{$state->id}}" {{$state->id == $tenant->office_state_id ? 'selected' : ''}}>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                    @if ($errors->has('office_state'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('office_state') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>                         
                                <div class="form-group{{ $errors->has('office_city') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-city">{{ __('City') }}</label>
                                    <select name="office_city" class="form-control city" required>
                                        <option value="">Select City</option>
                                        @foreach (getCities($tenant->office_state_id) as $city)
                                            <option value="{{$city->id}}" {{$city->id == $tenant->office_city_id ? 'selected' : ''}}>{{$city->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('office_city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('office_city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>                         
                            </div>

                            <h6 class="heading-small text-muted mb-4">{{ __('Contact Address') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-country">{{ __('Country') }}</label>
                                    <select name="country" class="form-control country1" required>
                                        <option value="">Select Country</option>
                                        @foreach (getCountries() as $c)
                                            <option value="{{$c->id}}" {{$c->id == $tenant->country_id ? 'selected' : ''}}>{{$c->name}}</option>
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
                                    <select name="state" class="form-control state1" required>
                                        <option value="">Select State</option>
                                        @foreach (getStates($tenant->country_id) as $state)
                                            <option value="{{$state->id}}" {{$state->id == $tenant->state_id ? 'selected' : ''}}>{{$state->name}}</option>
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
                                    <select name="city" class="form-control city1" required>
                                        <option value="">Select City</option>
                                        @foreach (getCities($tenant->state_id) as $city)
                                            <option value="{{$city->id}}" {{$city->id == $tenant->city_id ? 'selected' : ''}}>{{$city->name}}</option>
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
                                    <input type="text" name="address" id="input-address" class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Enter Address" value="{{old('address',$tenant->address)}}" required>
                                    
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>                           
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter Email" value="{{old('email',$tenant->email)}}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('contact_number') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-contact_number">{{ __('Contact Number') }}</label>
                                    <input type="text" name="contact_number" id="input-contact_number" class="form-control form-control-alternative{{ $errors->has('contact_number') ? ' is-invalid' : '' }}" placeholder="Enter Contact Number" value="{{old('contact_number',$tenant->phone)}}" required>
                                    
                                    @if ($errors->has('contact_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('contact_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>                         
                            </div>

                            <h6 class="heading-small text-muted mb-4">{{ __('Passport') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('passport') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-passport">{{ __('Passport') }}</label>
                                    <input type="file" name="passport" id="input-passport" class="form-control form-control-alternative{{ $errors->has('passport') ? ' is-invalid' : '' }}">
                                    
                                    @if ($errors->has('passport'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('passport') }}</strong>
                                        </span>
                                    @endif
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
        
        $('.country').change(function(){
            var country = $(this).val();
            if(country){
                $('.state').empty();
                $('<option>').val('').text('Loading...').appendTo('.state');
                $.ajax({
                    url: baseUrl+'/fetch-states/'+country,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('.state').empty();
                        $('<option>').val('').text('Select State').appendTo('.state');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('.state');
                        });
                    }
                });
            }
        });

        $('.state').change(function(){
            var state = $(this).val();
            if(state){
                $('.city').empty();
                $('<option>').val('').text('Loading...').appendTo('.city');
                $.ajax({
                    url: baseUrl+'/fetch-cities/'+state,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('.city').empty();
                        $('<option>').val('').text('Select City').appendTo('.city');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('.city');
                        });
                    }
                });
            }
        });

        $('.country1').change(function(){
            var country = $(this).val();
            if(country){
                $('.state1').empty();
                $('<option>').val('').text('Loading...').appendTo('.state1');
                $.ajax({
                    url: baseUrl+'/fetch-states/'+country,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('.state1').empty();
                        $('<option>').val('').text('Select State').appendTo('.state1');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('.state1');
                        });
                    }
                });
            }
        });

        $('.state1').change(function(){
            var state = $(this).val();
            if(state){
                $('.city1').empty();
                $('<option>').val('').text('Loading...').appendTo('.city1');
                $.ajax({
                    url: baseUrl+'/fetch-cities/'+state,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('.city1').empty();
                        $('<option>').val('').text('Select City').appendTo('.city1');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('.city1');
                        });
                    }
                });
            }
        });
        
    </script>
@endsection