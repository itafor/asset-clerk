<div class="modal fade" id="allocationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add tenant to a property</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                        <form method="post" action="{{ route('rent.allocation.store') }}" autocomplete="off">
                            @csrf
                                <input type="hidden" name="user_id" value="">
                                <input type="hidden" name="new_rental_status" value="">
                                <input type="hidden" name="previous_rental_id" value="">
                            <h6 class="heading-small text-muted mb-4">{{ __('Allocate New Tenant') }}</h6>
                            <div class="pl-lg-6">
                               <!--  <div class="row"> -->
                                    <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-4">
                                         <label class="form-control-label" for="input-property">{{ __('Property') }}</label>
                                         <select name="property" id="property" class="form-control propertycount" required autofocus style="width: 300px;">
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
                                    <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-main_unit">{{ __('Property Units') }}</label>
                                        <select name="main_unit" id="main_unit" class="form-control" required style="width: 300px;">
                                            <option value="">Select Unit</option>
                                        </select>
                                        
                                        @if ($errors->has('main_unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('main_unit') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-4">
                                        
                                        <label class="form-control-label" for="input-sub_unit">{{ __('Property Sub Unit') }}</label>
                                        <select name="sub_unit" id="sub_unit" class="form-control" required style="width: 300px;">
                                            <option value="">Select sub unit</option>
                                        </select>
                                        
                                        @if ($errors->has('sub_unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('sub_unit') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 
                                     <div class="form-group{{ $errors->has('tenant') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-tenant">{{ __('Tenant') }} </label>

                        <select name="tenant" id="input_tenant" class="form-control" required autofocus style="width: 300px;">
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


                                <div class="col-4">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div> 

                        </div>
                              </form>
      </div>
      
    </div>
  </div>
</div>

@section('script')

    <script>


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