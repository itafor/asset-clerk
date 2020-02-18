
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Rental Management</h1>
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
                <h3 class="dt-entry__title">Add New Rental
Asset: {{$asset_value->description}}, 
Tenant: {{$tenant_value->firstname}} {{$tenant_value->lastname}}
                </h3>
              </div>
              <!-- /entry heading -->
 <!-- Entry Heading -->
              <div class="dt-entry__heading">
  
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" title="Add Tenant to a Property"><i class="fas fa-plus"></i> Add tenant to a property</button>
              </div>
              <!-- /entry heading -->
            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                   <form method="post" action="{{ route('rental.store') }}" autocomplete="off">
                            @csrf
                                <input type="hidden" name="user_id" value="">
                                <input type="hidden" name="new_rental_status" value="">
                                <input type="hidden" name="previous_rental_id" value="">
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Rental') }}</h6>
                            <div class="pl-lg-4">

                                 <div class="row">
                                    <div class="form-group{{ $errors->has('tenant') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-tenant">{{ __('Tenant') }} 


                                        </label>


 <select name="tenant" id="input_tenant" class="form-control" required autofocus>
    <option value="">Select Tenant</option>
    @foreach (getTenants() as $tenant)
        <option value="{{$tenant->uuid}}"
            {{$tenant->uuid == $tenant_value->uuid ? 'selected' : ''}}>
            {{$tenant->name()}}
        </option>
    @endforeach
</select>
                                       

    @if ($errors->has('tenant'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('tenant') }}</strong>
        </span>
    @endif
</div>
                              
                                          <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-property">{{ __('Property') }}</label>
                                        <select name="property" id="property" class="form-control" required autofocus>
                                             <option value="">Select Property</option>
                                        </select>

                                        @if ($errors->has('property'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('property') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                     <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-price">{{ __('Asking Price') }}</label>
                                        <input type="text" name="price" id="price" class="form-control" value="{{old('price')}}" readonly="true" placeholder="Enter Price" required>
                                        
                                        @if ($errors->has('price'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('price') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                <!--     <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-3">
                                        <label class="form-control-label" for="input-unit">{{ __('Unit') }}</label>
                                        <select name="unit" id="unit" class="form-control" required>
                                            <option value="">Select Unit</option>
                                        </select>
                                        
                                        @if ($errors->has('unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('unit') }}</strong>
                                            </span>
                                        @endif
                                    </div> -->


                                </div>

                                <div class="row">


                              


                                   

                                     <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-price">{{ __('Amount') }}</label>
                                        <input type="number" min="1" name="amount" id="amount" class="form-control" value="{{old('amount')}}" placeholder="Enter amount" required>
                                        
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                              <div class="form-group{{ $errors->has('startDate') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-duration">{{ __('Start Date') }}</label>

                                         <input type="text" name="startDate" id="startDate" class="datepicker form-control form-control-alternative{{ $errors->has('startDate') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('startDate')}}" >
                                      
                                        @if ($errors->has('startDate'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('startDate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-date">{{ __('End Date') }}</label>
                                        <input type="text" name="due_date" id="input-date" class="datepicker form-control form-control-alternative{{ $errors->has('due_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('due_date')}}" required>
                                        
                                        @if ($errors->has('due_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('due_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                                               <div style="clear:both"></div>    
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save and Continue') }}</button>
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
                                @include('new.admin.assets.partials.addTenantToProperty')

@section('script')

    <script>
     

   
         let selected_tenant_uuid ='';
        $('#input_tenant').change(function(){
            var tenant_uuid = $(this).val();
            selected_tenant_uuid = tenant_uuid;
            console.log('selected:',selected_tenant_uuid);
            if(tenant_uuid){
                $('#property').empty();
                $('<option>').val('').text('Loading...').appendTo('#property');
                $.ajax({
                    url: baseUrl+'/fetch-tenants-assigned-to-asset/'+tenant_uuid,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if(data !=''){
                        $('#property').empty();
                        $('<option>').val('').text('Select Property').appendTo('#property');
                        $.each(data, function(k, v) {
                            $('<option>').attr('selected',true).val(v.propertyUuid).text(v.propertyName).attr('data-price',v.propertyProposedPice).appendTo('#property');
                            $('#price').attr('selected',true).val(v.propertyProposedPice);
                        });
                    
                    }else{
                    toast({
                        type: 'warning',
                        title: 'Ooops!! Selected tenant has not been added to a property'
                  })
            }
        }
    });
            }
            else{
                $('#property').empty();
                 $('#price').empty();
                $('<option>').val('').text('Select Property').appendTo('#property');
                
            }
        });

        
        $('#property').change(function(){
            var unit = $(this).val();
            if(unit){
                var price = $(this).find(':selected').attr('data-price')
                $('#price').val(price);
            }
            else{
                $('#price').val('');
            }
        });


$(document).on('keyup', '#amount', function(e){
    e.preventDefault();
    let value = e.target.value;
if(value <= 0){
     $(this).val('');
    $('#balance').val(' ')
}
 });
    </script>
   
@endsection