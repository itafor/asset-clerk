@extends('new.layouts.app', ['title' => 'Add New Payment', 'page' => 'payment'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Rent Payment Management</h1>
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
                <h3 class="dt-entry__title">Add New Rent Payment</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('rentalPayment.store') }}" autocomplete="off">
                            @csrf
                           <div class="row">
                             <div class="col-md-12">
                                <input type="hidden" name="proposed_amount" value="{{$tenantRent->price}}">
                                <input type="hidden" name="tenantRent_uuid" value="{{$tenantRent->uuid}}">
                                
                               <div class="float-left"> <p>Fields marked (<span class="text-danger">*</span>) are required.</p></div>
                               <div class="float-right"><span></span>Landlord (
                                {{$tenantRent->asset->Landlord->designation}}.
                                {{$tenantRent->asset->Landlord->firstname}}
                                {{$tenantRent->asset->Landlord->lastname}}
                                ) Property Estimate : &#8358; {{number_format($tenantRent->price,2)}} </div>
                           </div>
                           </div>
                            <div class="pl-lg-4">
                                <div class="row">
                                    
                                    <div class="form-group{{ $errors->has('asset_uuid') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="asset_uuid">{{ __('Property') }}<span class="text-danger">*</span></label>
                                        <select name="asset_uuid" id="asset_uuid" class="form-control" required>
                                           
                                                <option value="{{$tenantRent->asset_uuid}}" selected="true">
                                                     {{$tenantRent->unit->getProperty()->description}} 
                                                </option>
                                           
                                        </select>
                                        
                                        @if ($errors->has('asset_uuid'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('asset_uuid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('unit_uuid') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-unit">{{ __('Unit') }}<span class="text-danger">*</span></label>
                                        <select name="unit_uuid" id="unit_uuid" class="form-control" required>
                                            <option value="{{$tenantRent->unit_uuid}}">{{$tenantRent->unit->category->name}}
                                            </option>
                                        </select>
                                       
                                        @if ($errors->has('unit_uuid'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('unit_uuid') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                     <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-tenant_uuid">{{ __('Tenant') }}<span class="text-danger">*</span></label>
                                        <select name="tenant_uuid" id="tenant_uuid" class="form-control" required>
                                            <option value="{{$tenantRent->tenant_uuid}}">{{$tenantRent->tenant->name()}}
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
                                        <input type="integer" name="actual_amount" id="actual_amount"  value="{{$tenantRent->amount}}"  class="form-control form-control-alternative{{ $errors->has('actual_amount') ? ' is-invalid' : '' }}" readonly="readonly" placeholder="Enter Actual price" value="{{old('actual_amount')}}" required>
                                        
                                        @if ($errors->has('actual_amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('actual_amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                     <div class="form-group{{ $errors->has('Amount Price') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-amount">{{ __('Amount Paid') }}<span class="text-danger">*</span></label>
                                        <input type="number" min="1" name="amount_paid" id="amount_paid"   class="form-control form-control-alternative{{ $errors->has('actual_amount') ? ' is-invalid' : '' }}" placeholder="Enter amount Paid" value="{{old('amount_paid')}}" required>
                                        
                                        @if ($errors->has('amount_paid'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount_paid') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                  
                                     <div class="form-group{{ $errors->has('balance') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-amount">{{ __('Balance') }}<span class="text-danger">*</span></label>
                                        <input type="integer"   name="currentBalance" id="currentBalance"  class="form-control form-control-alternative{{ $errors->has('balance') ? ' is-invalid' : '' }}"  value="{{$tenantRent->balance}}" readonly="readonly" >
                                       
                                    </div>

                                    
                                       
                                        <input type="hidden" name="balance" id="balance"   class="form-control form-control-alternative{{ $errors->has('balance') ? ' is-invalid' : '' }}" placeholder="Enter balance" value="{{old('balance')}}" readonly="readonly" required>
                                        
                                        @if ($errors->has('balance'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('balance') }}</strong>
                                            </span>
                                        @endif
                                    
                                 
                               
                                    <div class="form-group{{ $errors->has('payment_date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-payment_date">{{ __('Payment Date') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="payment_date" id="payment_date" class="datepicker form-control form-control-alternative{{ $errors->has('payment_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('payment_date')}}" required>
                                        
                                        @if ($errors->has('payment_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('payment_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                      <div class="form-group{{ $errors->has('payment_date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-payment_date">{{ __('Start Date') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="startDate" id="startDate" class=" form-control form-control-alternative{{ $errors->has('startDate') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{\Carbon\Carbon::parse($tenantRent->startDate)->format('d M Y')}}" readonly="readonly" required>
                                        
                                        @if ($errors->has('startDate'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('startDate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 

                                    <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-due_date">{{ __('Due Date') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="due_date" value="{{\Carbon\Carbon::parse($tenantRent->due_date)->format('d M Y')}}" class="form-control" readonly="readonly">

                                        @if ($errors->has('due_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('due_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                <div class="form-group{{ $errors->has('payment_mode_id') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-payment_mode">{{ __('Payment Mode') }}<span class="text-danger">*</span></label>
                                        <select name="payment_mode_id" id="payment_mode_id" class="form-control" required>
                                            <option value="">Select Payment Mode</option>
                                            @foreach (getPaymentModes() as $pm)
                                                <option value="{{$pm->id}}" {{old('payment_mode') == $pm->id ? 'selected' : ''}}>{{$pm->name}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('payment_mode_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('payment_mode_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('payment_description') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-date">{{ __('Payment Description') }}<span class="text-danger">*</span></label>
                                        <textarea rows="5" name="payment_description" id="input-description" class="form-control form-control-alternative{{ $errors->has('payment_description') ? ' is-invalid' : '' }}" placeholder="Enter Description" required>{{old('payment_description')}}</textarea>
                                        
                                        @if ($errors->has('payment_description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('payment_description') }}</strong>
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
$('body').on('keyup', '#amount_paid', function(){
            let amountPaid = $(this).val();
           
            let balance = 0;
            let currentBalance = $('#currentBalance').val();



            if( parseFloat(amountPaid) > parseFloat(currentBalance) ){
                toast({
                        type: 'info',
                        title: 'Ooops!! Amount paid exceed expected amount, please check and try again'
                    })
              $('#balance').val('')
            }else{
                 balance = currentBalance - amountPaid;
              $('#balance').val(balance)
              
            }
        })


  $(document).on('keyup', '#amount_paid', function(e){
    e.preventDefault();
    let value = e.target.value;
if(value <= 0){
     $(this).val('');
    $('#balance').val(' ')
}
 });






    
    </script>
@endsection