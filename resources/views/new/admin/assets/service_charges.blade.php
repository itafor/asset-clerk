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
                <a href="/asset/add-service-charge"> <button type="button" class="btn btn-primary btn-sm"> Add Service Charge  </button>
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
                <h5 class="modal-title" id="exampleModalLabel">List of Tenants added to <strong>{{$asset->description}} asset</strong> service Charge</h5>
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
                        <th class="text-center"><b>Action</b></th>
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
                            <td class="text-center">

                                        <form action="{{ route('remove.tenant.from.sc', ['id'=>$tenant->id,request()->route('id')]) }}" method="get">
                                            
                                            <button type="button" class="btn-danger" onclick="confirm('{{ __("Are you sure you want to remove this tenant from this service charge?") }}') ? this.parentElement.submit() : ''">
                                                {{ __('Remove Tenant') }}
                                            </button>
                                        </form> 
                                 
                             
                            </td>
                        </tr>
                    @endforeach
                  
                    
                    </tbody>
                  </table>

                </div>
                <!-- /tables -->
                @endif
  @endif
<!-- search description -->
  <div class="row">
     <div class="form-group col-2">
  <div>
    <input type="text" class="form-control" name="search" id="search" placeholder="&#128269 Description" autocomplete="false">
    
  </div>
</div>
     <div class="form-group col-2">
  <div>
     <input type="text"class="form-control" name="searchlocation" id="searchlocation" placeholder="&#128269 Location">
  </div>
</div>

   <div class="form-group col-2">
  <div>
      <input type="text" class="form-control" name="searchName" id="searchlocation" placeholder="&#128269 Name">
  </div>
</div>

   <div class="form-group col-2">
  <div>
     <input type="text" class="form-control" name="searchCategory" id="searchlocation" placeholder="&#128269 Category">
  </div>
</div>

   <div class="form-group col-2">
  <div>
     <input type="text"class="form-control" name="searchlocation" id="searchlocation" placeholder="&#128269 Location">
  </div>
</div>

  <div class="form-group col-2">
  <div>
     <input type="text" class="form-control" name="searchAmount" id="searchlocation" placeholder="&#128269 Amount">
  </div>
</div>
</div>
<!-- search description ends-->


                <!-- Tables -->
                <div class="table-responsive">

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th><b>Description</b></th>
                        <th><b>Location</b></th>
                        <th><b>Name</b></th>
                        <th><b>Category</b></th>
                        <th><b>Amount</b></th>
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
                            <td class="text-center">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>
                                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                      
                                            <a href="{{route('asset.tenants.service',['id'=>$asset->id])}}" class="dropdown-item">Tenants</a>
                                      
                                        <a href="{{ route('asset.service.charge.edit', ['id'=>$asset->id]) }}" class="dropdown-item">Edit</a>
                                        
                                        <form action="{{ route('asset.delete.service', ['id'=>$asset->id]) }}" method="get">
                                            
                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this Service Charge?") }}') ? this.parentElement.submit() : ''">
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
        @include('admin.assets.partials.service')
        @include('new.admin.assets.partials.tenants-service-charge')

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

            if(rowsc >= 5){
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



 $(document).on('keyup', '#search', function(){
  var $value = $(this).val();
    $.ajax({
   type:'GET',
   url:"{{URL::to('asset/search')}}",
   data:{'search':$value},
   success:function(data)
   {
    if(data){
   $('tbody').html(data);
   }else{
    $('tbody').html('<tr><td style="text-align: center;" colspan="19">No matching records found</td></tr>');
   }
}
  })

 });


    </script>
@endsection