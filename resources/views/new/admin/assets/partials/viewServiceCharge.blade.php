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
                <h3 class="dt-entry__title">List of Service Charges in <strong>{{$asset}}</strong> Property</h3>
              </div>
              <!-- /entry heading -->

              <div class="dt-entry__heading">
                <a href="{{ route('asset.service.create')}}"> <button type="button" class="btn btn-primary btn-sm"> Add Service Charge  </button>
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

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th><b>Property</b></th>
                        <th><b>Location</b></th>
                        <th><b>Name</b></th>
                        <th><b>Category</b></th>
                        <th><b>Amount</b></th>
                        <th><b>Start date</b></th>
                        <th><b>Due date</b></th>
                        <th class="text-center"><b>Action</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($charges as $asset)
                        <tr>
                            <td>
                                @php
                                    $i = $loop->iteration;
                                @endphp
                            {{$i}} 
                            </td>
                            <td>{{ $asset->asset->description }}</td>
                            <td>{{ $asset->asset->address }}</td>
                            <td>{{$asset->serviceCharge->name}}</td>
                            <td>{{ucwords($asset->serviceCharge->type)}}</td>
                            <td>&#8358; {{number_format($asset->price,2)}}</td>
                             <td> {{ \Carbon\Carbon::parse($asset->startDate)->format('d M Y')}}</td>
                            <td> {{ \Carbon\Carbon::parse($asset->dueDate)->format('d M Y')}}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>
                                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                      
                                            <a href="{{route('asset.tenants.service',['id'=>$asset->id])}}" target="_blank" class="dropdown-item">Tenants</a>
                                           
                                        
                                        <form action="{{ route('asset.delete.service', ['id'=>$asset->id]) }}" method="get">
                                            
                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this Service Charge? This action will also remove tenants assigned to this Service Charge") }}') ? this.parentElement.submit() : ''">
                                                {{ __('Delete') }}
                                            </button>
                                        </form> 
                                    </div>

                                </div>
</td>
                        </tr>
                    @endforeach
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



    </script>
@endsection