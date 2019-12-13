@extends('new.layouts.app', ['title' => 'Add New Rental', 'page' => 'rental'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Tenant Management</h1>
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
                <h3 class="dt-entry__title">Add Tenant to Property</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                   <form method="post" action="{{ route('tenant.to.asset.store') }}" autocomplete="off">
                            @csrf
                                <input type="hidden" name="new_rental_status" value="">
                                <input type="hidden" name="previous_rental_id" value="">
                            <h6 class="heading-small text-muted mb-4">{{ __('Add tenant to a property') }}</h6>
                            <div class="pl-lg-6">
                               <!--  <div class="row"> -->
                                    <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-property">{{ __('Property') }}</label>
                                        <select name="property" id="input-property" class="form-control" required autofocus>
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
                                    <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-unit">{{ __('Unit') }}</label>
                                        <select name="unit" id="input-unit" class="form-control" required>
                                            <option value="">Select Unit</option>
                                        </select>
                                        
                                        @if ($errors->has('unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('unit') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-4">
                                        
                                        <input type="hidden" name="price" id="input_price" class="form-control" value="{{old('price')}}" readonly="true" placeholder="Enter Price" required>
                                        
                                        @if ($errors->has('price'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('price') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 
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


                                <div class="col-4">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div> 

                               <!--  </div> -->
                                <div class="row">
                                    
                                                   
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
