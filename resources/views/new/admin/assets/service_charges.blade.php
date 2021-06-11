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
                <h3 class="dt-entry__title">List of Service Charges</h3>
              </div>
              <!-- /entry heading -->

              <div class="dt-entry__heading">
                <a href="{{ route('asset.service.create.rental')}}"> <button type="button" class="btn btn-primary btn-sm"> Add Service Charge  </button>
                 </a>
              </div>

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">


                <!-- Tables -->
                <div class="table-responsive">

                @if(isset($charges))
           @if(count($charges) >=1)
        <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th><b>Tenant</b></th>
                        <th><b>Property</b></th>
                        <th><b>Property Type</b></th>
                        <th><b>Service Charge</b></th>
                        <th><b>Amount</b></th>
                        <th><b>Start Date</b></th>
                        <th><b>End Date</b></th>
                        <th><b>Payment Status</b></th>
                    </tr>
                    </thead>
                    <tbody>
                       
                                
                    @foreach ($charges as $tenant)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$tenant->designation}}
                           {{$tenant->firstname}}
                            {{$tenant->lastname}}</td>
                            <td>{{$tenant->assetName}}</td>
                            
                            <td>{{ fetchRental($tenant->tenantRentId)->unit->propertyType ? fetchRental($tenant->tenantRentId)->unit->propertyType->name : 'N/A'}}</td>

                            <td>{{$tenant->name === 'Other' ? $tenant->asc->description : $tenant->name}}</td>
                            
                            <td>&#8358;{{number_format($tenant->price,2)}}</td>
                            
                             <td>   {{  \Carbon\Carbon::parse($tenant->startDate)->format('d M Y')}}</td>
                             <td>   {{  \Carbon\Carbon::parse($tenant->dueDate)->format('d M Y')}}</td>
                            <td>{{$tenant->paymentStatus}}</td>

                        </tr>
                    @endforeach

                   @else
  <tr><td style="text-align: center;" colspan="19">No matching records found</td></tr>
    @endif
    @endif
                    
                    </tbody>
                  </table>

                </div>
                <!-- /tables -->

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


  $(document).on('keyup', '#minAmt, #maxAmt', function(e){
    e.preventDefault();
    let $value = e.target.value;
if($value <= 0){
    // alert('Invalid input');
     $(this).val('');
}
 });

$(document).ready(function() {
    var table = $('#table-1').DataTable( {
        fixedHeader: {
            header: true,
            footer: true
        },
    } );
} );

    </script>
@endsection