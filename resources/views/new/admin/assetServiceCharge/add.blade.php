@extends('new.layouts.app', ['title' => 'Add Service Charge', 'page' => 'service'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Service Charges  </h1>
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
                <h3 class="dt-entry__title">Service Charges <strong></h3>
              </div>
              <!-- /entry heading -->

              <div class="dt-entry__heading">
             
              </div>

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">
              	 <div class="pl-lg-4">
              	<div class="row">
              		
<div class="form-group{{ $errors->has('payment_date') ? ' has-danger' : '' }} col-6">
        <label class="form-control-label" for="input-payment_date">{{ __('Use this if you are managing rentals') }}</label>
      <div class="dt-entry__heading">
                <a href="{{ route('asset.service.create.rental')}}"> <button type="button" class="btn btn-primary btn-sm"> Add Service Charge  </button>
                 </a>
              </div>
    </div>

    <div class="form-group{{ $errors->has('payment_date') ? ' has-danger' : '' }} col-6">
        <label class="form-control-label" for="input-payment_date">{{ __('Use this if you are not managing rentals') }}</label>
      <div class="dt-entry__heading">
                <a href="{{ route('asset.service.create')}}"> <button type="button" class="btn btn-primary btn-sm"> Add Service Charge  </button>
                 </a>
              </div>
    </div>
              	</div>
 
              </div>
                </div>
                <!-- /tables -->
              
   

              </div>
              <!-- /card body -->

            </div>
            <!-- /card -->

          </div>
          <!-- /grid item -->



@endsection

@section('script')
    <script>
        $('body').on('change', '.sc_type', function(){
            var sc_type = $(this).val();
            var row = $(this).data('row');
            if(sc_type){

                $('#service_name').empty();
                $('<option>').val('').text('Loading...').appendTo('#service_name');
                $.ajax({
                    url: baseUrl+'/fetch-service-charge/'+sc_type,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#service_name').empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#service_name');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.name).text(v.name).appendTo('#service_name');
                        });
                    }
                });
            }
        });



 $('body').on('change', '.asset', function(){

            var asset = $(this).val();
            if(asset){

                $('#searchlocation').empty();
                $('<option>').val('').text('Loading...').appendTo('#searchlocation');
                $.ajax({
                    url:"{{URL::to('asset/get-asset-location')}}/"+asset,
                    type: "GET",
                    data: {'asset':asset},
                    success: function(data) {
                      console.log(data)
                        $('#searchlocation').empty();
                        
                        $('<option>').attr('selected', true).val('').text('Select Location').appendTo('#searchlocation');

                        $.each(data, function(k, v) {
                                $('<option>').val(v.address).text(v.address).appendTo('#searchlocation');
                            
                        });
                    }
                });
            }
        });




    </script>
@endsection