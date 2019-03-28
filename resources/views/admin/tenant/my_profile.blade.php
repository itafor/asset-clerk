@extends('layouts.app', ['title' => __('My Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' John Doe',
        'description' => __('This is your profile page. You can update your information here.'),
        'class' => 'col-lg-12'
    ])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-between">
                            {{-- <a href="#" class="btn btn-sm btn-info mr-4">{{ __('Connect') }}</a>
                            <a href="#" class="btn btn-sm btn-default float-right">{{ __('Message') }}</a> --}}
                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4 mt-6">
                        <div class="text-center">
                            <h3>
                                Mr John Doe<span class="font-weight-light"></span>
                            </h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>{{ __('Accountant') }}
                            </div>
                            <div class="h5 mt-2">
                                <i class="ni business_briefcase-24 mr-2"></i>{{ __('08012345679') }}
                            </div>
                            <div class="h5 mt-2">
                                <i class="ni business_briefcase-24 mr-2"></i>{{ __('john@example.com') }}
                            </div>
                            {{-- <hr class="my-4" />
                            <p>{{ __('Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music.') }}</p>
                            <a href="#">{{ __('Show more') }}</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Your Information') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Next of Kin Details') }}</h6>
                            
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

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

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save Changes') }}</button>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4" />
                        <form autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Guarantor\'s Details') }}</h6>

                            @if (session('password_status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('password_status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

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