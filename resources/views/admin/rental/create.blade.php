@extends('layouts.app', ['title' => __('Add Rental')])

@section('content')
    @include('admin.rental.partials.header', ['title' => __('Add Rental')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Rental Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('rental.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('rental.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Rental') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('tenant') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-tenant">{{ __('Tenant') }}</label>
                                    <select name="tenant" id="" class="form-control" required autofocus>
                                        <option value="">Select Tenant</option>
                                        @foreach (getTenants() as $tenant)
                                            <option value="{{$tenant->id}}">{{$tenant->name()}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('tenant'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tenant') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-category">{{ __('Asset Category') }}</label>
                                    <select name="category" id="" class="form-control" required>
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
                                <div style="clear:both"></div>

                                <div class="form-group{{ $errors->has('asset_description') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-asset_description">{{ __('Asset Description') }}</label>
                                    <select name="asset_description" id="asset_description" class="form-control" required>
                                        <option value="">Select Asset</option>
                                    </select>

                                    @if ($errors->has('asset_description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('asset_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('location') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-location">{{ __('Location') }}</label>
                                    <select name="location" id="location" class="form-control" required>
                                        <option value="">Select Location</option>
                                    </select>
                                    
                                    @if ($errors->has('location'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('location') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>         

                                <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-standard_price">{{ __('Standard Price') }}</label>
                                    <input type="text" name="standard_price" id="input-standard_price" class="datepicker form-control form-control-alternative{{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="&#8358; 0.00" value="{{old('standard_price')}}" required>

                                    @if ($errors->has('standard_price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('standard_price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('date') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-date">{{ __('Rental Date') }}</label>
                                    <input type="text" name="date" id="input-date" class="datepicker form-control form-control-alternative{{ $errors->has('date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('date')}}" required>
                                    
                                    @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>    
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

        
    </script>
@endsection