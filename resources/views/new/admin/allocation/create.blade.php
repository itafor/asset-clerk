@extends('new.layouts.app', ['title' => 'Allocate Tenant to property', 'page' => 'allocation'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Property Allocation Management</h1>
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
                <h3 class="dt-entry__title">Allocate New Tenant</h3>
              </div>
              <!-- /entry heading -->
 <!-- Entry Heading -->
              <div class="dt-entry__heading">
  
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" title="Add Tenant to a Property"><i class="fas fa-plus"></i> Add tenant to a property</button> -->
              </div>
              <!-- /entry heading -->
            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                   <form method="post" action="{{ route('rent.allocation.store') }}" autocomplete="off">
                            @csrf
                                <input type="hidden" name="user_id" value="">
                                <input type="hidden" name="new_rental_status" value="">
                                <input type="hidden" name="previous_rental_id" value="">
                            <h6 class="heading-small text-muted mb-4">{{ __('Allocate New Tenant') }}</h6>
                            <div class="pl-lg-4">
                              <div class="row">
                                    <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-property">{{ __('Property') }}</label>
                                         <select name="property" id="property" class="form-control propertycount" required autofocus>
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

                                       <div class="form-group{{ $errors->has('main_unit') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-main_unit">{{ __('Property Units') }}</label>
                                        <select name="main_unit" id="main_unit" class="form-control" required>
                                            <option value="">Select Unit</option>
                                        </select>
                                        
                                        @if ($errors->has('main_unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('main_unit') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('') ? ' has-danger' : '' }} col-6">
                                        <label class="form-control-label" for="input-sub_unit">{{ __('Property Sub Unit') }}</label>
                                        <select name="sub_unit" id="sub_unit" class="form-control" required>
                                            <option value="">Select sub unit</option>
                                        </select>
                                        
                                        @if ($errors->has('sub_unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('sub_unit') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                 

                        <div class="form-group{{ $errors->has('tenant') ? ' has-danger' : '' }} col-6">
                        <label class="form-control-label" for="input-tenant">{{ __('Tenant') }} </label>

                        <select name="tenant" id="input_tenant" class="form-control" required autofocus>
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
                              
                </div>
                                              
                        <div style="clear:both"></div>    
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
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

@endsection

@section('script')

    <script>
     

    //      let selected_tenant_uuid ='';
    //     $('#input_tenant').change(function(){
    //         var tenant_uuid = $(this).val();
    //         selected_tenant_uuid = tenant_uuid;
    //         console.log('selected:',selected_tenant_uuid);
    //         if(tenant_uuid){
    //             $('#property').empty();
    //             $('<option>').val('').text('Loading...').appendTo('#property');
    //             $.ajax({
    //                 url: baseUrl+'/fetch-tenants-assigned-to-asset/'+tenant_uuid,
    //                 type: "GET",
    //                 dataType: 'json',
    //                 success: function(data) {
    //                     if(data !=''){
    //                     $('#property').empty();
    //                     $('<option>').val('').text('Select Property').appendTo('#property');
    //                     $.each(data, function(k, v) {
    //                         $('<option>').attr('selected',true).val(v.propertyUuid).text(v.propertyName).attr('data-price',v.propertyProposedPice).appendTo('#property');
    //                         $('#price').attr('selected',true).val(v.propertyProposedPice);
    //                     });
                    
    //                 }else{
    //                 toast({
    //                     type: 'warning',
    //                     title: 'Ooops!! Selected tenant has not been added to a property'
    //               })
    //         }
    //     }
    // });
    //         }
    //         else{
    //             $('#property').empty();
    //              $('#price').empty();
    //             $('<option>').val('').text('Select Property').appendTo('#property');
                
    //         }
    //     });



$(document).on('keyup', '#amount', function(e){
    e.preventDefault();
    let value = e.target.value;
if(value <= 0){
     $(this).val('');
    $('#balance').val(' ')
}
 });

    $('.propertycount').change(function(){
            var property = $(this).val();
            if(property){

               $('#main_unit').empty();
                $('<option>').val('').text('Loading...').appendTo('#main_unit');
                $.ajax({
                    url: baseUrl+'/fetch-units/'+property,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        if(data !=''){
                     $('#main_unit').empty();
                     $('<option>').val('').text('Select Unit').appendTo('#main_unit');
                        $.each(data, function(k, v) {
                            $('<option>').attr('selected',false).val(v.unitUuid).text(v.propertyType +' - '+ v.qty+'units, '+v.qty_left+' left').appendTo('#main_unit');

                        });

                    }
                }
                });
                
            }
        });


    $('#main_unit').change(function(){
            var property = $(this).val();
            if(property){
               let vacantFlatCount = [];
              let occupiedFlatCount=[];

               $('#sub_unit').empty();
                $('<option>').val('').text('Loading...').appendTo('#sub_unit');
                $.ajax({
                    url: baseUrl+'/analyse-property/'+property,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if(data !=''){
                     $('#sub_unit').empty();
                     $('<option>').val('').text('Select sub unit').appendTo('#sub_unit');
                        $.each(data.flats, function(k, v) {
                            // console.log('asskingPrice',data.asskingPrice);
                            $('<option>').attr('selected',false).val(v).text(v).appendTo('#sub_unit');
                             $('#asking_price').attr('selected',true).val(data.asskingPrice);

                        });

                    }
                }
                });
                
            }
        });
    
    </script>
   
@endsection