@extends('new.layouts.app', ['title' => 'Add New Service Charge', 'page' => 'service'])

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
                <h3 class="dt-entry__title">Add Service Charge</h3>
              </div>
              <!-- /entry heading -->
                <!-- Entry Heading -->
              <div class="dt-entry__heading">
  
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" title="Add Tenant to a Property"><i class="fas fa-plus"></i> Allocate tenants to properties</button>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                     <form id="forms" action="{{ route('addserviceCharge') }}" method="post" autocomplete="off">
                    @csrf
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel">Add Service Charge</h5> -->

                </div>
                <div class="modal-body" style="text-align:left">
                          <div class="row">

                             <div class="form-group col-4">
                                <label class="form-control-label" for="input-category">{{ __('Property (Asset)') }}</label>
                                <div>
                                    <select name="asset" id="asset" class="form-control asset" style="width:100%" required>
                                    <option value="">Select Property</option>
                                    @foreach(getAssets() as $asset)
                                    <option value="{{$asset->uuid}}">{{$asset->description}}</option>
                                    @endforeach
                                    
                                </select>
                                </div>
                            </div>
                               <!--  <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-3">
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


                                <div class="form-group col-4">
                                <label class="form-control-label" for="input-price">{{ __('Start Date') }}</label>
                                <input type="text" name="startDate" id="input-startDate" class="datepicker form-control" placeholder="Enter Date" autocomplete="off" required>
                            </div>

                             <div class="form-group col-4">
                                <label class="form-control-label" for="input-price">{{ __('Due Date') }}</label>
                                <input type="text" name="dueDate" id="input-dueDate" class="datepicker form-control" placeholder="Enter Date" autocomplete="off" required>
                            </div>

                          </div>

                          
                     <!--      <div class="row">

                            <div class="form-group col-12">
                                <label class="form-control-label" for="input-category">{{ __('Tenants: ') }}
                                 <button type="button" class="btn btn-xs btn-default" onclick="selectAllTenants()">Select all</button>  <button type="button" class="btn btn-xs btn-default" onclick="deSelectAllTenants()">Deselect all</button></label>
                                <div>
                                    <select name="tenant_id[]" id="tenant_id" class="form-control chzn-select tenant" style="width:100%" multiple="true" required>
                                    <option value="" selected="selected">Select Tenants</option>
                                </select>
                                </div>
                            </div>
                          </div> -->
                        <div class="row">
                            <div class="form-group col-3">
                                <label class="form-control-label" for="input-category">{{ __('Type') }}</label>
                                <div>
                                    <select name="service[112211][type]" class="form-control sc_type" data-row="112211" style="width:100%" required>
                                    <option value="">Select Type</option>
                                    <option value="fixed">Fixed</option>
                                    <option value="variable">Variable</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-3">
                                <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>
                                <div>
                                    <select name="service[112211][service_charge]" id="serviceCharge112211" style="width:100%" class="form-control serviceDiv serviceDiv112211" data-row="112211" required>
                                    <option value="">Select Service Charge</option>
                                </select>
                                </div>
                            </div>                   
                            <div class="form-group col-3">
                                <label class="form-control-label" for="input-price">{{ __('Price') }}</label>
                                <input type="number" name="service[112211][price]" id="input-price" class="form-control" placeholder="Enter Price" required>
                            </div>
                             <div class="form-group col-3">
                                <label class="form-control-label" for="input-price">{{ __('Description') }}</label>
                                <input type="text" name="service[112211][description]" id="input-price" class="form-control" placeholder="Enter description" >
                            </div>
                        </div>

                        <div id="list_allocated_tenants"></div>

                            <div style="clear:both"></div>
                          <!--   <div id="containerSC">
                            </div>   
                            <div class="form-group">
                                <button type="button" id="addMoreSC" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                            </div>  --> 
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
        @include('new.admin.assets.partials.addTenantToProperty')
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



            $('.asset').change(function(){
   
          var asset = $(this).val();

           if(asset !=''){
            
      var _token = $('input[name="_token"').val();
      $.ajax({
        url: baseUrl+'/fetch-tenants-added-to-rental/'+asset,
        method:"get",
        data:{asset:asset, _token:_token},
        success:function(data){
           if(data === 'No tenant allocated to the selected property'){

           $('#list_allocated_tenants').fadeIn();
            $('#list_allocated_tenants').html(data);
                       alert('No tenant allocated to the selected property')
          }else{
               $('#list_allocated_tenants').fadeIn();
               $('#list_allocated_tenants').html(data);
          }
        }
      })
    }else{
         //$('#post_data').html('');
    }
          
        });

 function selectAllAllocation() {
  $(':checkbox').each(function() {
    this.checked  = true;
    $('#selectAll').hide()
    $('#selectAllTest').hide()
    $('#deselectAll').show()
    $('#deselectAllTest').show()

});
}

function unSelectAllAllocation() {
   $(':checkbox').each(function() {
    this.checked  = false;
    $('#selectAll').show()
    $('#selectAllTest').show()
    $('#deselectAll').hide()
    $('#deselectAllTest').hide()
});
}


 // check whether to select all tenants or not ends

        $('body').on('change', '#asset', function(){

            var asset = $(this).val();
            console.log(asset);
            if(asset){
                $('#tenant_id').empty();
                $('<option>').val('').text('Loading...').appendTo('#tenant_id');
                $.ajax({
                    url: baseUrl+'/fetch-tenants-added-to-rental/'+asset,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if(data !=''){
                        $('#tenant_id').empty();
                        $('<option>').attr('selected', true).val('').text('Select Tenants').appendTo('#tenant_id');
                       localStorage.setItem('assignedTenants',JSON.stringify(data));
                        $.each(data, function(k, v) {
                                $('<option>').val(v.id).text(v.designation + '.'+ v.firstname + ' - ' + v.lastname).appendTo('#tenant_id');
                        });
                          }else{
                        $('#tenant_id').empty();
                        toast({
                        type: 'warning',
                        title: 'Ooops!! No tenant in the selected property'
                    })
                         $('<option>').attr('selected', true).val(' ').text('No Tenant found').appendTo('#tenant_id');
                      localStorage.removeItem('assignedTenants');
                      }
                    }

                });
            }  else{
                $('#tenant_id').empty();
                $('<option>').attr('selected', true).val('').text('Select Tenant').appendTo('#tenant_id');
            }
        });


  function selectAllTenants(){
      var tenants = localStorage.getItem('assignedTenants');
        $('#tenant_id').empty();
               $.each(JSON.parse(tenants), function(k, v) {
    $('<option>').attr('selected', true).val(v.id).text(v.firstname + ' - ' + v.lastname).appendTo('#tenant_id');
        
     });
  }

  function deSelectAllTenants(){
        $('#tenant_id').empty();
       $('<option>').attr('selected', true).val('').text('Select Tenants').appendTo('#tenant_id');
     
     var tenants = localStorage.getItem('assignedTenants');
        $.each(JSON.parse(tenants), function(k, v) {
        $('<option>').val(v.id).text(v.designation + '.'+ v.firstname + ' - ' + v.lastname).appendTo('#tenant_id');
     });

  }
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
                    +'<div class="form-group col-3" style="width:36%; float:left; margin-left:-20px">'
                    +'    <label class="form-control-label" for="input-category">{{ __('Type') }}</label>'
                    +'    <select name="service['+rowId+'][type]" class="form-control sc_type select'+rowId+'" data-row="'+rowId+'" required>'
                    +'        <option value="">Select Type</option>'
                    +'        <option value="fixed">Fixed</option>'
                    +'        <option value="variable">Variable</option>'
                    +'    </select>'
                    +'</div>'
                    +'<div class="form-group col-3" style="width:36%; float:left; margin-right:10px">'
                    +'    <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>'
                    +'    <select name="service['+rowId+'][service_charge]" id="serviceCharge'+rowId+'" class="form-control select'+rowId+' serviceDiv serviceDiv'+rowId+'" data-row="'+rowId+'" required>'
                    +'        <option value="">Select Service Charge</option>'
                    +'    </select>'
                    +'</div>       '            
                    +'<div class="form-group col-3" style="width:36%; float:left">'
                    +'    <label class="form-control-label" for="input-price">{{ __('Price') }}</label>'
                    +'    <input type="number" name="service['+rowId+'][price]" id="input-price" class="form-control" placeholder="Enter Price" required>'
                    +'</div>'

                     +'<div class="form-group col-3" style="width:36%; float:left">'
                    +'    <label class="form-control-label" for="input-price">{{ __('Description') }}</label>'
                    +'    <input type="text" name="service['+rowId+'][description]" id="input-price" class="form-control" placeholder="Enter description" >'
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

    $( function() {
            $( ".datepick" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
        </script>
@endsection