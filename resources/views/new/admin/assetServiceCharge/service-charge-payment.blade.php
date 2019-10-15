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
                            <p>Fields marked (<span class="text-danger">*</span>) are required.</p>
                            <div class="pl-lg-4">
                                <div class="row">
                                    
                                    <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-property">{{ __('Tenant') }}<span class="text-danger">*</span></label>
                                        <select name="tenant" id="tenant" class="form-control" required>
                                            <option value="">Select tenant</option>
                                            @foreach(getTenants() as $tenant)
                                            <option value="{{$tenant->id}}">{{$tenant->firstname}} {{$tenant->lastname}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @if ($errors->has('tenant'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tenant') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-unit">{{ __('Service Charge') }}<span class="text-danger">*</span></label>
                                        <select name="service_charge" id="input-service_charge" class="form-control" required>
                                            <option value="">Select Service</option>
                                        </select>
                                        
                                        @if ($errors->has('service_charge'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('service_charge') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                              
                         
                                    <div class="hide col-6 service">
                                        <div class="form-group{{ $errors->has('service_charge') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-service_charge">{{ __('Service Charge') }}<span class="text-danger">*</span></label>
                                            <select name="service_charge" id="input-service_charge" class="form-control">
                                                <option value="">Select Service Charge</option>
                                            </select>

                                            @if ($errors->has('service_charge'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('service_charge') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                        <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('Amount') }}<span class="text-danger">*</span></label>
                                        <select  name="amount" id="input-amount" class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}" required>
                                            <option>Select AMOUNT</option>
                                            </select>
                                        
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                         <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('Balance') }}<span class="text-danger">*</span></label>
                                        <select  name="balance" id="input-balance" class="form-control form-control-alternative{{ $errors->has('balance') ? ' is-invalid' : '' }}" required>
                                            <option>Select Balance</option>
                                            </select>
                                        
                                        @if ($errors->has('balance'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('balance') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('payment_date') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-payment_date">{{ __('Payment Date') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="payment_date" id="input-payment_date" class="datepicker form-control form-control-alternative{{ $errors->has('payment_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('payment_date')}}" required>
                                        
                                        @if ($errors->has('payment_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('payment_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                

                                    <div class="form-group{{ $errors->has('payment_mode') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-payment_mode">{{ __('Payment Mode') }}<span class="text-danger">*</span></label>
                                        <select name="payment_mode" id="payment_mode" class="form-control" required>
                                            <option value="">Select Payment Mode</option>
                                            @foreach (getPaymentModes() as $pm)
                                                <option value="{{$pm->id}}" {{old('payment_mode') == $pm->id ? 'selected' : ''}}>{{$pm->name}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('payment_mode'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('payment_mode') }}</strong>
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
        $tenantId =0;
        $('body').on('change', '#tenant', function(){
            var tenant = $(this).val();
            $tenantId=tenant;
            if(tenant){

                $('#input-service_charge').empty();
                $('<option>').val('').text('Loading...').appendTo('#input-service_charge');
                $.ajax({
                    url: baseUrl+'/service-charge/fetch-tenant-service-charge/'+tenant,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#input-service_charge').empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#input-service_charge');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name +' '+v.type).appendTo('#input-service_charge');
                        });
                    }
                });
            }
        });

        $('body').on('change', '#input-service_charge', function(){
            var price = $("#input-service_charge option:selected").attr('data-price');
            $('#input-amount').val(price);
        });

      $('body').on('change', '#input-service_charge', function(){
            var service_charge = $(this).val();
            if(service_charge){

                $('#input-amount').empty();
                $('<option>').val('').text('Loading...').appendTo('#input-amount');
                $.ajax({
                    url: baseUrl+'/service-charge/fetch-service-charge-amount/'+service_charge +'/'+$tenantId,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $('#input-amount').empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#input-amount');
                        $.each(data, function(k, v) {
                            $('<option>').attr('selected', true).val(v.id).text(v.price).appendTo('#input-amount');
                        });
                    }
                });
            }
        });

       $('body').on('change', '#input-service_charge', function(){
            var service_charge = $(this).val();
            if(service_charge){

                $('#input-balance').empty();
                $('<option>').val('').text('Loading...').appendTo('#input-balance');
                $.ajax({
                    url: baseUrl+'/service-charge/fetch-service-charge-amount/'+service_charge +'/'+$tenantId,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $('#input-balance').empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#input-balance');
                        $.each(data, function(k, v) {
                            $('<option>').attr('selected', true).val(v.id).text(v.bal).appendTo('#input-balance');
                        });
                    }
                });
            }
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