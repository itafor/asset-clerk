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

<!-- search description -->
<form action="{{route('search.service.charge')}}" method="post">
   @csrf
  <div class="row">
     <div class="form-group col-2">
      <label class="form-control-label" for="input-category">{{ __('Property') }}</label>
          
              <select name="asset" id="asset" class="form-control {{$errors->has('asset') ? ' is-invalid' : ''}} asset" style="width:100%" required>
              <option value="">Select Property</option>
              @foreach(getAssets() as $asset)
              <option value="{{$asset->id}}">{{$asset->description}}</option>
              @endforeach
              
          </select>
          
             @if ($errors->has('asset'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('asset') }}</strong>
                      </span>
                @endif               
</div>
<div class="form-group col-2">
              <label class="form-control-label" for="input-category">{{ __('Location') }}</label>
              <div>
                  <select name="location" id="searchlocation" class="form-control {{$errors->has('location') ? ' is-invalid' : ''}}" style="width:100%" required>
                  <option value="" selected="selected">Select Location</option>
              </select>
               @if ($errors->has('location'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('location') }}</strong>
                                        </span>
                @endif
              </div>
  </div>

   <div class="form-group col-2">
 <label class="form-control-label" for="input-category">{{ __('Type') }}</label>
                                <div>
                                    <select name="type" class="form-control {{$errors->has('type') ? ' is-invalid' : ''}} sc_type" style="width:100%" >
                                    <option value="">Select Type</option>
                                    <option value="fixed">Fixed</option>
                                    <option value="variable">Variable</option>
                                </select>
                    @if ($errors->has('type'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('type') }}</strong>
                      </span>
                @endif   
                                </div>
</div>

   <div class="form-group col-2">
  <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>
                  <div>
                      <select name="service_name" id="service_name" style="width:100%" class="form-control {{$errors->has('service_name') ? ' is-invalid' : ''}}">
                      <option value="">Select Service Charge</option>
                  </select>
                   @if ($errors->has('service_name'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('service_name') }}</strong>
                      </span>
                @endif   
                  </div>
</div>

   <div class="form-group col-2">
   <label class="form-control-label" for="input-quantity">{{ __('Min Amt') }}</label>

     <input type="number" min="1" class="form-control {{$errors->has('minAmt') ? ' is-invalid' : ''}}" name="minAmt" id="minAmt" placeholder="Min. Amount" autocomplete="off">
  @if ($errors->has('minAmt'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('minAmt') }}</strong>
                      </span>
                @endif   
</div>

 <div class="form-group col-2">
   <label class="form-control-label" for="input-quantity">{{ __('Max Amt') }}</label>

     <input type="number" min="1" name="maxAmt" id="maxAmt" class="form-control {{$errors->has('maxAmt') ? ' is-invalid' : ''}}"  placeholder="Max. Amount" autocomplete="off">
   @if ($errors->has('maxAmt'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('maxAmt') }}</strong>
                      </span>
                @endif   
</div>

  <div class="form-group col-2">
  <div class="text-center">
    <button type="submit" value="Search" class="btn-sm btn-info"> Search</button>
  </div>
</div>
</div>
</form>
<!-- search description ends-->

@if(isset($assetsServiceCharges))
  @if(count($assetsServiceCharges) >=1)
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
                        <th><b>Start Date</b></th>
                        <th><b>Due Date</b></th>
                        <th class="text-center"><b>Action</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($assetsServiceCharges as $asset)
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
                                      
                                            <a href="/asset/tenants-service-charge/{{$asset->id}}" target="_blank|_parent" class="dropdown-item" >Tenants</a>
                                      
                                       <!--  <a href="{{ route('asset.service.charge.edit', ['id'=>$asset->id]) }}" class="dropdown-item">Edit</a> -->
                                        
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
                                    @else
  <tr><td style="text-align: center;" colspan="19">No matching records found</td></tr>
    @endif
                  </table>

                </div>
                <!-- /tables -->


@else



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