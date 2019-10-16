@extends('new.layouts.app', ['title' => 'List of Service Charges', 'page' => 'service'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Service Charges Debtors </h1>
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
                <h3 class="dt-entry__title">Debtors <strong></h3>
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


 @if(isset($debtors))
           @if(count($debtors) >=1)
  <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List of Tenants added </h5>
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
                        <th><b>Tenant</b></th>
                        <th><b>Asset</b></th>
                        <th><b>Service Type</b></th>
                        <th><b>Service Name</b></th>
                        <th><b>Amount</b></th>
                        <th><b>Balance</b></th>
                        <th><b>Start Date</b></th>
                        <th><b>Due Date</b></th>
                        <th class="text-center"><b>Action</b></th>
                    </tr>
                    </thead>
                    <tbody>
                       
                                
                    @foreach ($debtors as $tenant)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$tenant->designation}}
                           {{$tenant->firstname}}
                            {{$tenant->lastname}}</td>
                            <td>{{$tenant->assetName}}</td>
                            <td>{{$tenant->type}}</td>
                            <td>{{$tenant->name}}</td>
                            {{-- <td>{{$tenant->occupationName ? $tenant->occupationName->name : 'N/A'}}</td> --}}
                            <td>&#8358;{{number_format($tenant->price,2)}}</td>
                            <td>&#8358;{{number_format($tenant->bal,2)}}</td>
                            
                            <td>   {{  \Carbon\Carbon::parse($tenant->dueDate)->format('d M Y')}}</td>
                             <td>   {{  \Carbon\Carbon::parse($tenant->dueDate)->format('d M Y')}}</td>
                          <td class="text-center">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>
                                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        
                                        <form action="{{ route('asset.delete.service', ['id'=>$tenant->id]) }}" method="get">
                                            
                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this Service Charge?") }}') ? this.parentElement.submit() : ''">
                                                {{ __('Delete') }}
                                            </button>
                                        </form> 
                                    </div>

                                </div>
</td>
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