@extends('layouts.app', ['title' => __('Add Customer')])

@section('content')
    @include('admin.tenant.partials.header', ['title' => __('Add Customer')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Customer Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('customer.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('customer.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Customer') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('designation') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-category">{{ __('Designation') }}</label>
                                    <select name="designation" id="" class="form-control" required autofocus>
                                        <option value="">Select Designation</option>
                                        <option>Mr</option>
                                        <option>Mrs</option>
                                        <option>Miss</option>
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
                                        <option>Male</option>
                                        <option>Female</option>
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
                                    <input type="text" name="firstname" id="input-firstname" class="form-control form-control-alternative{{ $errors->has('firstname') ? ' is-invalid' : '' }}" placeholder="Enter First Name" value="{{old('firstname')}}" required>

                                    @if ($errors->has('firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('lastname') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-lastname">{{ __('Last Name') }}</label>
                                    <input type="text" name="lastname" id="input-lastname" class="form-control form-control-alternative{{ $errors->has('lastname') ? ' is-invalid' : '' }}" placeholder="Enter Last Name" value="{{old('lastname')}}" required>
                                    
                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>         

                                <div class="form-group{{ $errors->has('date_of_birth') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-date_of_birth">{{ __('Date of Birth') }}</label>
                                    <input type="text" name="date_of_birth" id="input-date_of_birth" class="datepicker form-control form-control-alternative{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" placeholder="Select Date of Birth" value="{{old('date_of_birth')}}" required>

                                    @if ($errors->has('date_of_birth'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date_of_birth') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('occupation') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-occupation">{{ __('Occupation') }}</label>
                                    <select name="occupation" class="form-control" required>
                                        <option value="">Select Occupation</option>
                                    </select>
                                    
                                    @if ($errors->has('occupation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('occupation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>                         
                            </div>

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-address">{{ __('Address') }}</label>
                                    <input type="text" name="address" id="input-address" class="datepicker form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Enter Address" value="{{old('address')}}" required>

                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('office_state') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-state">{{ __('State') }}</label>
                                    <select name="office_state" class="form-control state" required>
                                        <option value="">Select State</option>
                                    </select>
                                    
                                    @if ($errors->has('office_state'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('office_state') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>  
                                
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter Email" value="{{old('email')}}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('contact_number') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-contact_number">{{ __('Contact Number') }}</label>
                                    <input type="text" name="contact_number" id="input-contact_number" class="form-control form-control-alternative{{ $errors->has('contact_number') ? ' is-invalid' : '' }}" placeholder="Enter Contact Number" value="{{old('contact_number')}}" required>
                                    
                                    @if ($errors->has('contact_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('contact_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>    
                                
                                <div class="form-group{{ $errors->has('income_range') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-income_range">{{ __('Income Range') }}</label>
                                    <select name="income_range" class="form-control " required>
                                        <option value="">Select Income Range</option>
                                    </select>

                                    @if ($errors->has('income_range'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('income_range') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('identification') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-identification">{{ __('Identification') }}</label>
                                    <select name="identification" class="form-control" required>
                                        <option value="">Select Identification</option>
                                    </select>
                                    
                                    @if ($errors->has('identification'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('identification') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>  
                            </div>

                            <h6 class="heading-small text-muted mb-4">{{ __('Next of Kin Section') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('nok_firstname') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-nok_firstname">{{ __('First Name') }}</label>
                                    <input type="text" name="nok_firstname" id="input-nok_firstname" class="form-control form-control-alternative{{ $errors->has('nok_firstname') ? ' is-invalid' : '' }}" placeholder="Enter First Name" value="{{old('nok_firstname')}}" required>

                                    @if ($errors->has('nok_firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nok_firstname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('nok_lastname') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-nok_lastname">{{ __('Last Name') }}</label>
                                    <input type="text" name="nok_firstname" id="input-nok_lastname" class="form-control form-control-alternative{{ $errors->has('nok_lastname') ? ' is-invalid' : '' }}" placeholder="Enter Last Name" value="{{old('nok_lastname')}}" required>
                                    
                                    @if ($errors->has('nok_lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nok_lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>
                                <div class="form-group{{ $errors->has('nok_address') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-nok_address">{{ __('Address') }}</label>
                                    <input type="text" name="nok_address" id="input-nok_address" class="form-control form-control-alternative{{ $errors->has('nok_address') ? ' is-invalid' : '' }}" placeholder="Enter Address" value="{{old('nok_address')}}" required>

                                    @if ($errors->has('nok_address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nok_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('nok_contact_number') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-nok_contact_number">{{ __('Contact Number') }}</label>
                                    <input type="text" name="nok_contact_number" id="input-nok_contact_number" class="form-control form-control-alternative{{ $errors->has('nok_contact_number') ? ' is-invalid' : '' }}" placeholder="Enter Contact Number" value="{{old('nok_contact_number')}}" required>
                                    
                                    @if ($errors->has('nok_contact_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nok_contact_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>
                            </div>

                            <h6 class="heading-small text-muted mb-4">{{ __('Guarantor Section') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('g_designation') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-g_designation">{{ __('Designation') }}</label>
                                    <select name="g_designation" id="" class="form-control" required>
                                        <option value="">Select Title</option>
                                        <option>Mr</option>
                                        <option>Mrs</option>
                                        <option>Miss</option>
                                    </select>

                                    @if ($errors->has('g_designation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('g_designation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('occupation') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-occupation">{{ __('Occupation') }}</label>
                                    <input type="text" name="occupation" id="input-occupation" class="form-control form-control-alternative{{ $errors->has('occupation') ? ' is-invalid' : '' }}" placeholder="Enter Occupation" value="{{old('occupation')}}" required>
                                    
                                    @if ($errors->has('occupation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('occupation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>
                                <div class="form-group{{ $errors->has('g_firstname') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-g_firstname">{{ __('First Name') }}</label>
                                    <input type="text" name="g_firstname" id="input-g_firstname" class="form-control form-control-alternative{{ $errors->has('g_firstname') ? ' is-invalid' : '' }}" placeholder="Enter First Name" value="{{old('g_firstname')}}" required>

                                    @if ($errors->has('g_firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('g_firstname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('g_lastname') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-g_lastname">{{ __('Last Name') }}</label>
                                    <input type="text" name="g_firstname" id="input-g_lastname" class="form-control form-control-alternative{{ $errors->has('g_lastname') ? ' is-invalid' : '' }}" placeholder="Enter Last Name" value="{{old('g_lastname')}}" required>
                                    
                                    @if ($errors->has('g_lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('g_lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>
                                <div class="form-group{{ $errors->has('g_address') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-g_address">{{ __('Address') }}</label>
                                    <input type="text" name="g_address" id="input-g_address" class="form-control form-control-alternative{{ $errors->has('g_address') ? ' is-invalid' : '' }}" placeholder="Enter Address" value="{{old('g_address')}}" required>

                                    @if ($errors->has('g_address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('g_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('g_contact_number') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-g_contact_number">{{ __('Contact Number') }}</label>
                                    <input type="text" name="g_contact_number" id="input-g_contact_number" class="form-control form-control-alternative{{ $errors->has('g_contact_number') ? ' is-invalid' : '' }}" placeholder="Enter Contact Number" value="{{old('g_contact_number')}}" required>
                                    
                                    @if ($errors->has('g_contact_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nok_contact_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>
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