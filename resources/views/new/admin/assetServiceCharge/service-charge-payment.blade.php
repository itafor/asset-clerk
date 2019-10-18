@extends('new.layouts.app', ['title' => 'Record New Service Charge Payment', 'page' => 'Service Charge'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Service Charge Payment</h1>
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
                <h3 class="dt-entry__title"> Record New Service Charge Payment</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('store.service.charge.payment.history') }}" autocomplete="off">
                            @csrf
                            <div class="row">
                               <div class="col-md-12">
                                    <p class="float-left">Fields marked (<span class="text-danger">*</span>) are required.</p>

                                 <p class="float-right" id="tenant_wallet_balance"></p>
                                
                               </div>
                             </div>
                            <input type="hidden" name="tenant_id" id="tenant_id" >
                            <input type="hidden" name="service_charge_id" id="input-service_charge_id" >
                            <input type="hidden" name="previous_balance" id="input-previous_balance" placeholder="previous_balance">

                             <input type="hidden" name="new_balance" id="input-new_balance" placeholder="new balance">

                              <input type="hidden" name="new_wallet_amount" id="input-new_wallet_amount" placeholder="new wallet Amount">

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

                                        <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('Actual Amount') }}<span class="text-danger">*</span></label>
                                        <select  name="actualAmount" min="1" id="input-amount" class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}"  required>
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
                                        <select  name="balance" min="1" id="input-balance" class="form-control form-control-alternative{{ $errors->has('balance') ? ' is-invalid' : '' }}" required>
                                            <option>Select Balance</option>
                                            </select>
                                        @if ($errors->has('balance'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('balance') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                           <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('Property') }}<span class="text-danger">*</span></label>
                                        <select  name="property" id="input-property" class="form-control form-control-alternative{{ $errors->has('property') ? ' is-invalid' : '' }}" required>
                                            <option>Select Property</option>
                                            </select>
                                        
                                        @if ($errors->has('property'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('property') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                        <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('Amount Paid') }}<span class="text-danger">*</span></label>
                                        <input type="number" min="1" name="amountPaid" id="amountPaid" class="form-control form-control-alternative{{ $errors->has('amountPaid') ? ' is-invalid' : '' }}" placeholder="Amount Paid"  required>
                                            
                                        
                                        @if ($errors->has('amountPaid'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amountPaid') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                            <div class="form-group{{ $errors->has('payment_mode') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-payment_mode">{{ __('Payment Mode') }}<span class="text-danger">*</span></label>
                                        <select name="payment_mode" id="payment_mode" class="form-control" required>
                                            <option value="">Select Payment Mode</option>
                                            @foreach (getPaymentModes() as $pm)
                                                <option value="{{$pm->name}}" {{old('payment_mode') == $pm->id ? 'selected' : ''}}>{{$pm->name}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('payment_mode'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('payment_mode') }}</strong>
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

                                            <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('Duration Paid For') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="durationPaidFor" id="durationPaidFor" class="form-control form-control-alternative{{ $errors->has('durationPaidFor') ? ' is-invalid' : '' }}" placeholder="Duration Paid For"  required>
                                        
                                        @if ($errors->has('durationPaidFor'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('durationPaidFor') }}</strong>
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
        //select tenant
        $tenantId =0;
        $balance =0;
        $newBalance='';
        $amountPaid =0;
        $('body').on('change', '#tenant', function(){
            var tenant = $(this).val();
            $tenantId=tenant;
            $('#tenant_id').val($tenantId)
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
                           
                            $('<option>').val(v.id).text(v.name +', Type: ' + v.type + '  - Duration: ' + v.expireingDate).appendTo('#input-service_charge');
                        
                        });
                    }
                });
            }
        });

    
//select actual price
      $('body').on('change', '#input-service_charge', function(){
            var service_charge = $(this).val();

            if(service_charge){
                $('#service_charge_id').val(service_charge)
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
                            $('<option>').attr('selected', true).val(v.price).text(v.price).appendTo('#input-amount');
                        });
                    }
                });
            }
        });

//select balance
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
                        $('#input-balance').empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#input-balance');
                        $.each(data, function(k, v) {
                            
                            $balance = v.bal
                            if($newBalance ==''){
                            $('<option>').attr('selected', true).val(v.bal).text(v.bal).appendTo('#input-balance');
                        }else{
                            $newBalance;
                        }
                       

                        });
                    }
                });
            }
        });

//select property
  $('body').on('change', '#input-service_charge', function(){
            var service_charge = $(this).val();
            if(service_charge){

                $('#input-property').empty();
                $('<option>').val('').text('Loading...').appendTo('#input-property');
                $.ajax({
                    url: baseUrl+'/service-charge/fetch-service-charge-amount/'+service_charge +'/'+$tenantId,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $('#input-property').empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#input-property');
                        $.each(data, function(k, v) {
                            $('<option>').attr('selected', true).val(v.property).text(v.property + ' ' + v.asset_id).appendTo('#input-property');
                        });
                    }
                });
            }
        });


  //select Duration paid for
      $('body').on('change', '#input-service_charge', function(){
            var service_charge = $(this).val();
            if(service_charge){

                $('#durationPaidFor').empty();
                 $('#durationPaidFor').val('').text('Loading...').appendTo('#durationPaidFor');
                $.ajax({
                    url: baseUrl+'/service-charge/fetch-service-charge-amount/'+service_charge +'/'+$tenantId,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        $('#durationPaidFor').empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#durationPaidFor');
                        $.each(data, function(k, v) {
                           var formattedDate = new Date(v.expireingDate);
                            var d = formattedDate.getDate();
                            var m =  formattedDate.getMonth();
                            m += 1;  // JavaScript months are 0-11
                            var y = formattedDate.getFullYear();
                            startdate = d + "/" + m + "/" + y
                            $('#durationPaidFor').val( startdate + ' - '+ startdate)
                        });
                    }
                });
            }
        });


//get tenant wallet details

        $('body').on('change', '#tenant', function(){
            var tenant = $(this).val();
            if(tenant){

                $('#input-previous_balance').empty();
                $('<option>').val('').text('Loading...').appendTo('#input-previous_balance');
                $.ajax({
                    url: baseUrl+'/wallet/tenant-wallet-balance/'+tenant,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#input-previous_balance').empty();
                        if(data.amount){
                        $('#tenant_wallet_balance').html(data.tenantDetail + ' wallet\'s Balance: &#8358; ' + data.amount)
                        $('#input-previous_balance').val(data.amount)
                    }else{
                        $('#input-previous_balance').val(data.balance)
                        $('#tenant_wallet_balance').text('This tenant has not created a wallet')
                    }
                    }
                });
            }
        });
 

//check if balance is negative
$('body').on('keyup', '#amountPaid', function(){
             amountPaid = $(this).val();
              $balState = $balance - amountPaid;
            if($balState >= 0){
                  $newBalance = $('<option>').attr('selected', true).val($balState).text($balState).appendTo('#input-balance');
            }else{
                  $newBalance = $('<option>').attr('selected', true).val('').text('Invalid Balance').appendTo('#input-balance');
            }
        });

$('body').on('keyup', '#amountPaid', function(){
//get new wallet amount
            // amountPaid = $(this).val();
            let newWalletBalance = 0;
            let previousWalletbalance = $('#input-previous_balance').val();
            if(parseFloat(amountPaid) > parseFloat(previousWalletbalance) || parseFloat(previousWalletbalance) ==0){
               alert('Insufficient wallet balance, please fund this tenant\'s wallet to continue')
            }else{
                 newWalletBalance = previousWalletbalance - amountPaid;
              $('#input-new_balance').val(newWalletBalance)
              $('#input-new_wallet_amount').val(newWalletBalance)
            }
        })


    </script>
@endsection