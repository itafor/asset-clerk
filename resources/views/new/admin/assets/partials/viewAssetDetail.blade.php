@extends('new.layouts.app', ['title' => 'List of Assets', 'page' => 'asset'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Asset Management</h1>
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
                <h3 class="dt-entry__title">List of Assets</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">

                <!-- Tables -->
                <div class="table-responsive">
                        <div class="card">
              <div class="card-header">
        General Info
              </div>
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                  <p>
                      
                      <table class="table table-hover ">
  <tr>
    <td >Property Name  :</td><td>{{$asset->description}}</td>
     <td>Property Type :</td>  <td>{{$asset->propertyType ? $asset->propertyType->name : 'N/A'}}</td>
  </tr>

  <tr>
 <td>Landlord :</td> <td>{{$asset->Landlord ? $asset->Landlord->firstname.' '.$asset->Landlord->lastname : 'N/A'}}</td>

 <td>Country :</td> <td>{{$asset->country ? $asset->country->name : 'N/A'}}</td>
  </tr>

   <tr>
 <td>State :</td> <td>{{$asset->state ? $asset->state->name : 'N/A'}}</td>

 <td>City :</td> <td>{{$asset->city ? $asset->city->name : 'N/A'}}</td>
  </tr>

</table>
                  </p>


                  <footer class="blockquote-footer">{{$asset->description}} <cite title="Source Title">general info</cite></footer>
                </blockquote>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="float-left">Units</h3>
                    <button type="button" class="btn btn-default btn-xs float-right"> 
                        <a href="#x" data-toggle="modal" data-target="#unitModal" class="addUnit text-white">
                       <i class="fa fa-plus-circle"></i> Add Unit(s)</a>

                    </button>
                
              </div>
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                    
                    <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th><b>Name</b></th>
                          <th><b>Price</b></th>
                          <th><b>Status</b></th>
                          <th><b>Tenant</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($units as $unit)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$unit->unitname}}</td>
                          <td>{{$unit->standard_price}}</td>
                          <td>{{$unit->status}}</td>
                          <td>{{$unit->getTenant() ? $unit->getTenant()->firstname.' '.$unit->getTenant()->lastname:'N/A'}}</td>
                          <td class="text-center">
                              <div class="dropdown">
                                  <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Action
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                      <form  method="get">
                                          
                                          <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this landlord?") }}') ? this.parentElement.submit() : ''">
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
                  

                  <footer class="blockquote-footer">Units in <cite title="Source Title">{{$asset->description}}</cite></footer>
                </blockquote>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                Tenants
              </div>
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                  <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                </blockquote>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="float-left">Photos</h3>
                    <button type="button" class="btn btn-default btn-xs float-right"> 
                        <a href="#x" data-toggle="modal" data-target="#photoModal" class="addUnit text-white">
                       <i class="fa fa-plus-circle"></i> Add Photo(s)</a>

                    </button>
              </div>
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                    @if(isset($photos) && $photos !='')
                    @foreach ($photos as $photo)

                   <a target="_blank" href="{{$photo->image_url}}">
                 <img src="{{$photo->image_url}}" class="tenantdocument" height="150" width="150" >
                </a>

                  @endforeach
                  @else
                  <span>No photo found</span>
                  @endif
                  <br>
                  <br>
                  <footer class="blockquote-footer">{{$asset->description}} <cite title="Source Title">photos</cite></footer>
                </blockquote>
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

        </div>
        <!-- /grid -->
        @include('new.admin.assets.partials.addUnit')
        @include('new.admin.assets.partials.addPhotos')
@endsection


@section('script')
    <script>
     
        function identifier(){
            return Math.floor(Math.random() * (99999999 - 10000000 + 1)) + 10000000;
        }

        var row = 1;

        $('#addMore').click(function(e) {
            e.preventDefault();

            if(row >= 5){
                alert("You've reached the maximum limit");
                return;
            }

            var rowId = identifier();

            $("#container").append(
                '<div>'
                    +'<div style="float:right" class="remove_project_file"><span style="cursor:pointer" class="badge badge-danger" border="2">Remove</span></div>'
                    +'<div style="clear:both"></div>'
                       +'<div class="row" id="rowNumber'+rowId+'" data-row="'+rowId+'">'
                        

                    
                        +'<div class="form-group{{ $errors->has('flatname') ? ' has-danger' : '' }} col-6">'
                        +'    <label class="form-control-label" for="input-flatname">{{ __('Flat name') }}</label>'
                        +'    <input name="unit['+rowId+'][unitname]" placeholder="Enter flat name"  class="form-control select'+rowId+'" required>'
                       

                        +'    @if ($errors->has('flatname'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('flatname') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'
                               
                        +'<div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-6">'
                        +'    <label class="form-control-label" for="input-standard_price">{{ __('Asking Price') }}</label>'
                +'    <input type="number" min="1" name="unit['+rowId+'][standard_price]" class="standard_price form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }} standard_price" placeholder="Enter flat price" value="{{old('standard_price')}}" required>'

                        +'    @if ($errors->has('standard_price'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('standard_price') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'
                        
                        +'<div style="clear:both"></div>'
                    +'</div>'
                +'</div>'
            );
            row++;
            $(".select"+rowId).select2({
                    theme: "bootstrap"
                });
        });

        // Remove parent of 'remove' link when link is clicked.
        $('#container').on('click', '.remove_project_file', function(e) {
            e.preventDefault();
            $(this).parent().remove();
            row--;
        });
    </script>
@endsection