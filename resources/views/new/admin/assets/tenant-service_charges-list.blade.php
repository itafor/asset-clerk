@extends('new.layouts.app', ['title' => 'List of Service Charges', 'page' => 'service'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Service Charges</h1>
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
                @if(isset($tenantsDetails))
                 @if(count($tenantsDetails) >=1)
                <h3 class="dt-entry__title">Tenants assigned to <strong>{{$serviceChargeName}} </strong> service Charge in {{$asset ? $asset->description : ''}}'s property </h3>
                @endif
                @endif
              </div>
              <!-- /entry heading -->

              <div class="dt-entry__heading">
                <a href="/asset/service-charges"> <button type="button" class="btn btn-primary btn-sm"> Back  </button>
                 </a>
              </div>

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">


 @if(isset($tenantsDetails))
           @if(count($tenantsDetails) >=1)
  <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List of Tenants added to <strong> {{$serviceChargeName}} </strong> service Charge (&#8358; {{number_format($amount,2)}}) </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <br>
                <!-- Tables -->
                <div class="table-responsive">

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th><b>Designation</b></th>
                        <th><b>First Name</b></th>
                        <th><b>Last Name</b></th>
                        <th><b>Occupation</b></th>
                        <th><b>Phone</b></th>
                    </tr>
                    </thead>
                    <tbody>
                       
                                
                    @foreach ($tenantsDetails as $tenant)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$tenant->designation}}</td>
                            <td>{{$tenant->firstname}}</td>
                            <td>{{$tenant->lastname}}</td>
                            <td>{{$tenant->occupation}}</td>
                            {{-- <td>{{$tenant->occupationName ? $tenant->occupationName->name : 'N/A'}}</td> --}}
                            <td>{{$tenant->phone}}</td>
                       
                        </tr>
                    @endforeach

                   @else
  <tr><td style="text-align: center;" colspan="19">No matching records found</td></tr>
    @endif
                    
                    </tbody>
                  </table>

                </div>
                <!-- /tables -->
              
        @endif

              </div>
              <!-- /card body -->

            </div>
            <!-- /card -->

          </div>
          <!-- /grid item -->


        </div>
        <!-- /grid -->
       <!--  -->

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