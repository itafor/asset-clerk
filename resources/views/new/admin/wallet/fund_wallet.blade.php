@extends('new.layouts.app', ['title' => 'Fund Tenant Wallet', 'page' => 'service'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Wallet Management</h1>
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
                <h3 class="dt-entry__title">Fund tenant wallet</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('wallet.fund') }}" autocomplete="off">
                            @csrf
                            <p>Fields marked (<span class="text-danger">*</span>) are required.</p>
                            <input type="hidden" name="tenant_id" id="tenant_id" placeholder="tenant_id">
                           

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

                                        <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('Amount To Deposit') }}<span class="text-danger">*</span></label>
                                        <input type="Number" min="1" name="amount" id="amount" class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}" placeholder="Amount to deposit"  required>
                                        
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                          <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('Previous Amount') }}<span class="text-danger">*</span></label>
                                        <input type="Number" min="0" name="previous_balance" id="previous_balance" class="form-control form-control-alternative{{ $errors->has('previous_balance') ? ' is-invalid' : '' }}" placeholder="Previous Amount" readonly="readonly"  required>
                                        
                                        @if ($errors->has('previous_balance'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('previous_balance') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                         <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-amount">{{ __('New Balance') }}<span class="text-danger">*</span></label>
                                        <input type="text" min="1" name="new_balance" id="new_balance" class="form-control form-control-alternative{{ $errors->has('new_balance') ? ' is-invalid' : '' }}" placeholder="New Balance" readonly="readonly"  required>
                                        
                                        @if ($errors->has('new_balance'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('new_balance') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Make Deposit') }}</button>
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
       $previousBalance = parseFloat(0);
        $newBalance='';
        $('body').on('change', '#tenant', function(){
            var tenant = $(this).val();
            $tenantId=tenant;
            $('#tenant_id').val($tenantId)
            if(tenant){

                $('#input-service_charge').empty();
                $('<option>').val('').text('Loading...').appendTo('#input-service_charge');
                $.ajax({
                    url: baseUrl+'/wallet/fetch-tenant-balance/'+tenant,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if(data.amount){
                         $previousBalance = data.amount;
                          $('#previous_balance').val(data.amount)
                      }else{
                         $('#previous_balance').val(data.balance)
                      }
                    }
                });
            }
        });

    //check if balance is negative
$('body').on('keyup', '#amount', function(){
            var amountPaid = $(this).val();
              $balState = parseFloat($previousBalance) + parseFloat(amountPaid);
              console.log($balState);
            if($balState >= 0){
                  $('#new_balance').val($balState);
            }else{
                  $('#new_balance').val('Invalid Input');
                  // $('#new_balance').val(' ');
            }

            if(amountPaid <= 0){
             $(this).val('');
            }
        });

 
    </script>
@endsection