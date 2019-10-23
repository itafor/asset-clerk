@extends('new.layouts.app', ['title' => 'Add New Payment', 'page' => 'payment'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Payments</h1>
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
                <h3 class="dt-entry__title">Add New Payment</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('payment.store') }}" autocomplete="off">
                            @csrf
                           <div class="row">
                             <div class="col-md-12">
                                <input type="text" name="proposed_amount" value="{{$tenantRent->price}}">
                                <input type="text" name="tenantRent_uuid" value="{{$tenantRent->uuid}}">
                               <div class="float-left"> <p>Fields marked (<span class="text-danger">*</span>) are required.</p></div>
                               <div class="float-right"><span></span>Landlord (
                                {{$tenantRent->asset->Landlord->designation}}.
                                {{$tenantRent->asset->Landlord->firstname}}
                                {{$tenantRent->asset->Landlord->lastname}}
                                ) Proposed Price : &#8358; {{number_format($tenantRent->price,2)}} </div>
                           </div>
                           </div>
                            <div class="pl-lg-4">
                                <div class="row">
                                    
                                    <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-property">{{ __('Property') }}<span class="text-danger">*</span></label>
                                        <select name="property" id="property" class="form-control" required>
                                           
                                                <option value="{{$tenantRent->asset_uuid}}" selected="true">
                                                     {{$tenantRent->unit->getProperty()->description}} 
                                                </option>
                                           
                                        </select>
                                        
                                        @if ($errors->has('property'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('property') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-unit">{{ __('Unit') }}<span class="text-danger">*</span></label>
                                        <select name="unit" id="unit" class="form-control" required>
                                            <option value="{{$tenantRent->unit_uuid}}">{{$tenantRent->unit->category->name}}
                                            </option>
                                        </select>
                                       
                                        @if ($errors->has('unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('unit') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                     <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-unit">{{ __('Tenant') }}<span class="text-danger">*</span></label>
                                        <select name="tenant_uuid" id="tenant_uuid" class="form-control" required>
                                            <option value="{{$tenantRent->unit_uuid}}">{{$tenantRent->tenant->name()}}
                                            </option>
                                        </select>
                                       
                                        @if ($errors->has('tenant_uuid'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tenant_uuid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                      <div class="form-group{{ $errors->has('actual_amount') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-amount">{{ __('Amount') }}<span class="text-danger">*</span></label>
                                        <input type="integer" name="actual_amount" id="actual_amount"  value="{{$tenantRent->amount}}"  class="form-control form-control-alternative{{ $errors->has('actual_amount') ? ' is-invalid' : '' }}" placeholder="Enter Actual price" value="{{old('actual_amount')}}" required>
                                        
                                        @if ($errors->has('actual_amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('actual_amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                     <div class="form-group{{ $errors->has('Amount Price') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-amount">{{ __('Amount Paid') }}<span class="text-danger">*</span></label>
                                        <input type="integer" name="amount_paid" id="actual_amount"   class="form-control form-control-alternative{{ $errors->has('actual_amount') ? ' is-invalid' : '' }}" placeholder="Enter amount Paid" value="{{old('amount_paid')}}" required>
                                        
                                        @if ($errors->has('amount_paid'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount_paid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                     <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-amount">{{ __('Balance') }}<span class="text-danger">*</span></label>
                                        <input type="integer" name="balance" id="balance"   class="form-control form-control-alternative{{ $errors->has('balance') ? ' is-invalid' : '' }}" placeholder="Enter balance" value="{{old('balance')}}" required>
                                        
                                        @if ($errors->has('balance'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('balance') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 
                               
                                    <div class="form-group{{ $errors->has('payment_date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-payment_date">{{ __('Payment Date') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="payment_date" id="input-payment_date" class="datepicker form-control form-control-alternative{{ $errors->has('payment_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('payment_date')}}" required>
                                        
                                        @if ($errors->has('payment_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('payment_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                      <div class="form-group{{ $errors->has('payment_date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-payment_date">{{ __('Start Date') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="payment_date" id="startDate" class="datepicker form-control form-control-alternative{{ $errors->has('startDate') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{$tenantRent->startDate}}" required>
                                        
                                        @if ($errors->has('startDate'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('startDate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 

                                    <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-due_date">{{ __('Due Date') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="due_date" value="{{$tenantRent->due_date}}" class="form-control">

                                        @if ($errors->has('due_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('due_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-date">{{ __('Payment Description') }}<span class="text-danger">*</span></label>
                                        <textarea rows="5" name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="Enter Description" required>{{old('description')}}</textarea>
                                        
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save Payment') }}</button>
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
                    url: baseUrl+'/fetch-rented-units/'+property,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#unit').empty();
                        $('<option>').val('').text('Select Unit').appendTo('#unit');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.uuid).text(v.name+' - '+v.tenant).appendTo('#unit');
                        });
                    }
                });
            }
            else{
                $('#unit').empty();
                $('<option>').val('').text('Select Unit').appendTo('#unit');
            }
        });

        $(document).ready(function(){
            @if(old('property'))
                $.ajax({
                    url: baseUrl+'/fetch-rented-units/{{old('property')}}',
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#unit').empty();
                        $('<option>').val('').text('Select Unit').appendTo('#unit');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.uuid).text(v.name+' - '+v.tenant).appendTo('#unit');
                        });
                        @if(!empty(old('unit')))
                        $('#unit').val("{{old('unit')}}");
                        @endif
                    }
                });
            @endif

            @if(old('service') != null && old('service_charge') != null)
                $.ajax({
                    url: baseUrl+'/fetch-service-charge/{{old('service')}}',
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#input-service_charge').empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#input-service_charge');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#input-service_charge');
                        });
                        $('#input-service_charge').val("{{old('service_charge')}}");
                    }
                });

                $('.service').removeClass('hide');
                $("#input-service_charge, .sc_type").select2({
                    theme: "bootstrap"
                });
            @endif
        })

        $('body').on('change', '.sc_type', function(){
            var sc_type = $(this).val();
            if(sc_type){

                $('#input-service_charge').empty();
                $('<option>').val('').text('Loading...').appendTo('#input-service_charge');
                $.ajax({
                    url: baseUrl+'/fetch-service-charge/'+sc_type,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#input-service_charge').empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#input-service_charge');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#input-service_charge');
                        });
                    }
                });
            }
        });

        $('body').on('change', '#input-service_charge', function(){
            var price = $("#input-service_charge option:selected").attr('data-price');
            $('#input-amount').val(price);
        });

        $('#input-pt').change(function() {
            var type = $("#input-pt option:selected").text();
            if(type == 'Service Charge'){
                var property = $('#property').val();
                if(property){
                    $('#input-service_charge').empty();
                    $('<option>').val('').text('Loading...').appendTo('#input-service_charge');
                    $.ajax({
                        url: baseUrl+'/fetch-service-charge-by-property/'+property,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                            $('#input-service_charge').empty();
                            $('<option>').val('').text('Select Service Charge').appendTo('#input-service_charge');
                            $.each(data, function(k, v) {
                                $('<option>').val(v.id).text(v.name).appendTo('#input-service_charge').attr('data-price', v.price);
                            });
                        }
                    });
                } else {
                    toast({
                        type: 'info',
                        title: 'Please select property'
                    })
                }
                $('.service').removeClass('hide');
                $("#input-service_charge, .sc_type").select2({
                    theme: "bootstrap"
                });
                $('#sc_type').prop('required', true);
                $('#input-service_charge').prop('required', true);
            }
            else{
                $('.service').addClass('hide');
                $('#sc_type').prop('required', false);
                $('#input-service_charge').prop('required', false);
            }
        })
    </script>
@endsection