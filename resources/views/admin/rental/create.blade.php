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
                                <div class="row">
                                    <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-4">
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
                                    <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-4">
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
                                    <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-price">{{ __('Price') }}</label>
                                        <input type="text" name="price" id="price" class="form-control" value="{{old('price')}}" placeholder="Enter Price" required>
                                        
                                        @if ($errors->has('price'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('price') }}</strong>
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
                                    <div class="form-group{{ $errors->has('duration') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-duration">{{ __('Duration') }}</label>
                                        <select name="duration" id="duration" class="form-control" required>
                                            <option value="">Select Duration</option>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="4">4 Years</option>
                                            <option value="5">5 Years</option>
                                        </select>
                                        
                                        @if ($errors->has('duration'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('duration') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-date">{{ __('Rental Date') }}</label>
                                        <input type="text" name="date" id="input-date" class="datepicker form-control form-control-alternative{{ $errors->has('date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('date')}}" required>
                                        
                                        @if ($errors->has('date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('date') }}</strong>
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
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
    
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
    </script>
@endsection