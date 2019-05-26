@extends('new.layouts.app', ['title' => 'Edit Payment', 'page' => 'payment'])

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
                <h3 class="dt-entry__title">Edit Payment</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('payment.update') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="payment" value="{{$payment->uuid}}">
                            <p>Fields marked (<span class="text-danger">*</span>) are required.</p>
                            <div class="pl-lg-4">
                                <div class="row">
                                    
                                    <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-property">{{ __('Property') }}<span class="text-danger">*</span></label>
                                        <select name="property" id="property" class="form-control" required>
                                            <option value="">Select Property</option>
                                            @foreach ($properties as $p)
                                                <option value="{{$p->uuid}}" {{$payment->unit->getRental()->asset_uuid == $p->uuid ? 'selected' : ''}}>{{$p->description}}</option>
                                            @endforeach
                                        </select>
                                        
                                        @if ($errors->has('property'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('property') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-unit">{{ __('Unit') }}<span class="text-danger">*</span></label>
                                        <select name="unit" id="unit" class="form-control" required>
                                            <option value="">Select Unit</option>
                                        </select>
                                        
                                        @if ($errors->has('unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('unit') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('payment_type') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-pt">{{ __('Payment Type') }}<span class="text-danger">*</span></label>
                                        <select name="payment_type" id="input-pt" class="form-control" required autofocus>
                                            <option value="">Select Payment Type</option>
                                            @foreach (getPaymentTypes() as $type)
                                                <option value="{{$type->id}}" {{$payment->payment_type_id == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('payment_type'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('payment_type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    @if ($payment->serviceCharge)
                                        <div class="hide col-6 service">
                                          <div class="form-group">
                                              <label class="form-control-label" for="input-category">{{ __('Type') }}<span class="text-danger">*</span></label>
                                              <div>
                                                  <select id="sc_type" name="service" class="form-control sc_type">
                                                      <option value="">Select Type</option>
                                                      <option value="fixed" {{$payment->serviceCharge->type == 'fixed' ? 'selected' : ''}}>Fixed</option>
                                                      <option value="variable" {{$payment->serviceCharge->type == 'fixed' ? 'selected' : ''}}>Variable</option>
                                                  </select>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="hide col-6 service">
                                          <div class="form-group{{ $errors->has('service_charge') ? ' has-danger' : '' }}">
                                              <label class="form-control-label" for="input-service_charge">{{ __('Service Charge') }}<span class="text-danger">*</span></label>
                                              <select name="service_charge" id="input-service_charge" class="form-control">
                                                  <option value="">Select Service Charge</option>
                                                  @foreach (getServiceCharge($payment->serviceCharge->type) as $sc)
                                                      <option value="{{$sc->id}}" {{$payment->service_charge_id == $sc->id ? 'selected' : ''}}>{{$sc->name}}</option>
                                                  @endforeach
                                              </select>

                                              @if ($errors->has('service_charge'))
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $errors->first('service_charge') }}</strong>
                                                  </span>
                                              @endif
                                          </div>
                                      </div>
                                    @else
                                        <div class="hide col-6 service">
                                          <div class="form-group">
                                              <label class="form-control-label" for="input-category">{{ __('Type') }}<span class="text-danger">*</span></label>
                                              <div>
                                                  <select id="sc_type" name="service" class="form-control sc_type">
                                                      <option value="">Select Type</option>
                                                      <option value="fixed">Fixed</option>
                                                      <option value="variable">Variable</option>
                                                  </select>
                                              </div>
                                          </div>
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
                                    @endif
                                    <div class="form-group{{ $errors->has('payment_date') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-payment_date">{{ __('Payment Date') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="payment_date" id="input-payment_date" class="datepicker form-control form-control-alternative{{ $errors->has('payment_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{$payment->payment_date->format('m/d/Y')}}" required>
                                        
                                        @if ($errors->has('payment_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('payment_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('Amount') }}<span class="text-danger">*</span></label>
                                        <input type="integer" name="amount" id="input-amount" class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}" placeholder="Enter Amount" value="{{$payment->amount}}" required>
                                        
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('payment_mode') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-payment_mode">{{ __('Payment Mode') }}<span class="text-danger">*</span></label>
                                        <select name="payment_mode" id="payment_mode" class="form-control" required>
                                            <option value="">Select Payment Mode</option>
                                            @foreach (getPaymentModes() as $pm)
                                                <option value="{{$pm->id}}" {{$payment->payment_mode_id == $pm->id ? 'selected' : ''}}>{{$pm->name}}</option>
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
                                        <textarea rows="5" name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="Enter Description" required>{{$payment->payment_description}}</textarea>
                                        
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save Changes') }}</button>
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
          $.ajax({
              url: baseUrl+'/fetch-rented-units/{{$payment->unit->getRental()->asset_uuid}}',
              type: "GET",
              dataType: 'json',
              success: function(data) {
                  $('#unit').empty();
                  $('<option>').val('').text('Select Unit').appendTo('#unit');
                  $.each(data, function(k, v) {
                      $('<option>').val(v.uuid).text(v.name+' - '+v.tenant).appendTo('#unit');
                  });
                  $('#unit').val("{{$payment->asset_unit_uuid}}");
              }
          });

          var type = $("#input-pt option:selected").text();
          if(type == 'Service Charge'){
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

        $('#input-pt').change(function() {
            var type = $("#input-pt option:selected").text();
            if(type == 'Service Charge'){
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