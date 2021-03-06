@extends('new.layouts.app', ['title' => 'Add New Service Charge', 'page' => 'Service Charge'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Service Charge Management</h1>
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
                <h3 class="dt-entry__title">Edit Service Charge</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                     <form id="forms" action="{{route('asset.service.charge.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$service_charge->id}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Service Charge</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" style="text-align:left">
                        @csrf

                          <div class="row">

                             <div class="form-group col-4">
                                <label class="form-control-label" for="input-category">{{ __('Property (Asset)') }}</label>
                                <div>
                                    <select name="asset_id" id="asset" class="form-control" style="width:100%" required>
                                    <option value="">Select Asset</option>
                                    @foreach(getAssets() as $asset)

                                    <option value="{{$asset->id}}" {{ $asset->id == $service_charge->asset_id  ? 'selected' : '' }}>

                                        {{$asset->description}}

                                    </option>

                                    @endforeach
                                    
                                </select>
                                </div>
                            </div>


                            <div class="form-group col-8">
                                <label class="form-control-label" for="input-category">{{ __('Tenants (Select Tenant)') }}</label>
                                <div>
                                    <select name="tenant_id[]" id="tenant_id" class="form-control {{$errors->has('tenant_id') ? ' is-invalid' : ''}} chzn-select" style="width:100%" required multiple="true">
                                  @foreach( $tenantsDetails as $detail)
                                    <option value="{{$detail->id}}" selected="true">{{$detail->firstname}}  {{$detail->lastname}}</option>
                                    @endforeach

                                    @foreach( getTenants() as $tenant)
                                    <option value="{{$tenant->id}}">{{$tenant->firstname}}  {{$tenant->lastname}}</option>
                                    @endforeach
                                    
                                </select>
                                 @if ($errors->has('tenant_id'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('tenant_id') }}</strong>
                      </span>
                @endif    
                                </div>
                            </div>

                          </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label class="form-control-label" for="input-category">{{ __('Type') }}</label>
                                <div>
                                    <select name="type" class="form-control sc_type" data-row="112211" style="width:100%" required>
                                    <option value="">Select Type</option>
                                    <option value="{{$serviceChType}}" selected="true">
                                        {{$serviceChType}}
                                    </option>

                                    <option value="fixed">Fixed</option>
                                    <option value="variable">Variable</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>
                                <div>
                                    <select name="service_charge_id" id="serviceCharge112211" style="width:100%" class="form-control {{$errors->has('service_charge_id') ? ' is-invalid' : ''}}" >
                                    <option value="">Select Service Charge</option>
                                     @foreach(getServiceCharge() as $sc)

                                    <option value="{{$sc->id}}" {{ $sc->id == $service_charge->service_charge_id  ? 'selected' : '' }}>
                                        {{$sc->name}}
                                @endforeach
                                    </option>
                                </select>

                                 @if ($errors->has('service_charge_id'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('service_charge_id') }}</strong>
                      </span>
                @endif    
                                </div>
                            </div>                   
                            <div class="form-group col-4">
                                <label class="form-control-label" for="input-price">{{ __('Price') }}</label>
                                <input type="number" name="price" id="input-price" class="form-control {{$errors->has('price') ? ' is-invalid' : ''}}" placeholder="Enter Price"  value="{{$service_charge->price}}">
                                 @if ($errors->has('price'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('price') }}</strong>
                      </span>
                @endif    
                            </div>
                        </div>
                            <div style="clear:both"></div>
                           
                </div>
               <div class="text-center">
                <button type="submit" class="btn btn-success mt-4">{{ __('Save Service Charge') }}</button>
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


        $('body').on('change', '.sc_type', function(){
            var sc_type = $(this).val();
            var row = $(this).data('row');
            if(sc_type){

                $('#serviceCharge'+row).empty();
                $('<option>').val('').text('Loading...').appendTo('#serviceCharge'+row);
                $.ajax({
                    url: baseUrl+'/fetch-service-charge/'+sc_type,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#serviceCharge'+row).empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#serviceCharge'+row);
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#serviceCharge'+row);
                        });
                    }
                });
            }
        });


        // Remove parent of 'remove' link when link is clicked.
        $('#containerSC').on('click', '.remove_project_file', function(e) {
            e.preventDefault();
            $(this).parent().remove();
            rowsc--;
        });
        function identifier(){
            return Math.floor(Math.random() * (99999999 - 10000000 + 1)) + 10000000;
        }
        var rowsc = 1;

        $('#addMoreSC').click(function(e) {
            e.preventDefault();

            if(rowsc >= 12){
                alert("You've reached the maximum limit");
                return;
            }

            var rowId = identifier();

            $("#containerSC").append(
                '<div id="rowNumber'+rowId+'" data-row="'+rowId+'">'
                    +'<div style="float:right" class="remove_project_file"><span style="cursor:pointer" class="badge badge-danger" border="2">Remove</span></div>'
                    +'<div style="clear:both"></div>'
                    +'<div class="form-group" style="width:31%; float:left; margin-right:25px">'
                    +'    <label class="form-control-label" for="input-category">{{ __('Type') }}</label>'
                    +'    <select name="service['+rowId+'][type]" class="form-control sc_type select'+rowId+'" data-row="'+rowId+'" required>'
                    +'        <option value="">Select Type</option>'
                    +'        <option value="fixed">Fixed</option>'
                    +'        <option value="variable">Variable</option>'
                    +'    </select>'
                    +'</div>'
                    +'<div class="form-group" style="width:31%; float:left; margin-right:25px">'
                    +'    <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>'
                    +'    <select name="service['+rowId+'][service_charge]" id="serviceCharge'+rowId+'" class="form-control select'+rowId+'" required>'
                    +'        <option value="">Select Service Charge</option>'
                    +'    </select>'
                    +'</div>       '            
                    +'<div class="form-group" style="width:31%; float:left">'
                    +'    <label class="form-control-label" for="input-price">{{ __('Price') }}</label>'
                    +'    <input type="number" name="service['+rowId+'][price]" id="input-price" class="form-control" placeholder="Enter Price" required>'
                    +'</div>'
                    +'<div style="clear:both"></div>'
                +'</div>'
            );
            rowsc++;
            $(".select"+rowId).select2({
                theme: "bootstrap"
            });
        });


        $('.addService').click(function(){
            var asset = $(this).data('asset');
            $('#asset').val(asset);
        })
        $('.addUnit').click(function(){
            var asset = $(this).data('asset');
            $('#assetU').val(asset);
        })

// remove duplicate option from dropdown
   //  $(".chzn-select option").val(function(idx, val) {
   //    $(this).siblings('[value="'+ val +'"]').remove();
   // });

    
        </script>
@endsection