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
                <h3 class="dt-entry__title">Add New Service Charge</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                     <form id="forms" action="{{route('asset.service.add')}}" method="POST">
                    @csrf
                    <!-- <input type="hidden" name="asset" id="asset"> -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Service Charge</h5>
                   <section>


      <div class="input-group mb-2 mr-sm-2">
    <div class="input-group-prepend">
      <div class="input-group-text all-tenant-label">Add all tenants</div>
    </div>

        <div class="checkboxFour">
        <input type="checkbox" value="1" id="checkboxFourInput" name="" />
        <label for="checkboxFourInput"></label>
    </div>

  </div>

</section>
                </div>
                <div class="modal-body" style="text-align:left">
                        @csrf

                          <div class="row">

                             <div class="form-group col-4">
                                <label class="form-control-label" for="input-category">{{ __('Property (Asset)') }}</label>
                                <div>
                                    <select name="asset" id="asset" class="form-control asset" style="width:100%" required>
                                    <option value="">Select Property</option>
                                    @foreach(getAssets() as $asset)
                                    <option value="{{$asset->id}}">{{$asset->description}}</option>
                                    @endforeach
                                    
                                </select>
                                </div>
                            </div>


                            <div class="form-group col-8">
                                <label class="form-control-label" for="input-category">{{ __('Tenant') }}</label>
                                <div>
                                    <select name="tenant_id[]" id="tenant_id" class="form-control chzn-select tenant" style="width:100%" multiple="true" required>
                                    <option value="" selected="selected">Select Tenants</option>
                                </select>
                                </div>
                            </div>

                          </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label class="form-control-label" for="input-category">{{ __('Type') }}</label>
                                <div>
                                    <select name="service[112211][type]" class="form-control sc_type" data-row="112211" style="width:100%" required>
                                    <option value="">Select Type</option>
                                    <option value="fixed">Fixed</option>
                                    <option value="variable">Variable</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>
                                <div>
                                    <select name="service[112211][service_charge]" id="serviceCharge112211" style="width:100%" class="form-control" required>
                                    <option value="">Select Service Charge</option>
                                </select>
                                </div>
                            </div>                   
                            <div class="form-group col-4">
                                <label class="form-control-label" for="input-price">{{ __('Price') }}</label>
                                <input type="number" name="service[112211][price]" id="input-price" class="form-control" placeholder="Enter Price" required>
                            </div>
                        </div>
                            <div style="clear:both"></div>
                            <div id="containerSC">
                            </div>   
                            <div class="form-group">
                                <button type="button" id="addMoreSC" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                            </div>  
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

        // check whether to select all tenants or not begins
                $allTenants = false;
                 $("#checkboxFourInput").change(function() {
                    if($(this).prop('checked')) {
                       $allTenants = true
                    } else {
                        $allTenants = false
                    }
                });
 // check whether to select all tenants or not ends

        $('body').on('change', '.asset', function(){

            var asset = $(this).val();
            if(asset){

                $('#tenant_id').empty();
                $('<option>').val('').text('Loading...').appendTo('#tenant_id');
                $.ajax({
                    url:"{{URL::to('tenant/fetch-tenants')}}/"+asset,
                    type: "GET",
                    data: {'asset':'json'},
                    success: function(data) {
                        $('#tenant_id').empty();

                         if($allTenants==true){
                             $('<option>').val('').text('Select tenant').appendTo('#tenant_id');
                         }else{

                        $('<option>').attr('selected', true).val('').text('Select tenant').appendTo('#tenant_id');
                         }


                        $.each(data, function(k, v) {
                            if($allTenants==true){
                                $('<option>').attr('selected', true).val(v.tenantId).text(v.tenant + ' - ' + v.name).appendTo('#tenant_id');
                            }else{
                                $('<option>').val(v.tenantId).text(v.tenant + ' - ' + v.name).appendTo('#tenant_id');
                            }
                            
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


        </script>
@endsection