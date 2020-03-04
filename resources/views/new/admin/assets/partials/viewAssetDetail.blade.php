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
                                      Manage
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                         <a class="dropdown-item">Edit</a>
                                          
                      <button type="button" class="dropdown-item" onclick="deleteData('asset','delete','unit',{{$unit->id}})">
                          {{ __('Delete') }}
                      </button>
                                    
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
               <h3 class="float-left">Features</h3>
                    <button type="button" class="btn btn-default btn-xs float-right"> 
                        <a href="#x" data-toggle="modal" data-target="#featureModal" class=" text-white">
                       <i class="fa fa-plus-circle"></i> Add Feature(s)</a>

                    </button>
              </div>
              <div class="card-body">
                <blockquote class="blockquote mb-0">
                     @if(isset($features) && $features !='')
                    @foreach ($features as $feature)
    
        {{$feature->propFeature->name}}
    

        <a onclick="deleteData('asset','delete','feature',{{$feature->id}})"><i class="fa fa-times text-danger" style="font-size: 12px;"></i></a>


                  @endforeach
                  @else
                  <span>No Features found</span>
                  @endif
                  <br>
                  <br>
                  <footer class="blockquote-footer">{{$asset->description}} <cite title="Source Title">features</cite></footer>
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
                <blockquote class="blockquote mb-0" style="display: inline; position: relative; ">
                    @if(isset($photos) && $photos !='')
                    @foreach ($photos as $photo)
         
    
       

                   <a target="_blank" href="{{$photo->image_url}}">
                 <img src="{{$photo->image_url}}" class="tenantdocument" height="150" width="150" > 
                </a>
      
        <a onclick="deleteData('asset','delete','image',{{$photo->id}})"><i class="fa fa-times text-danger" style="font-size: 12px;"></i></a>

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
        @include('new.admin.assets.partials.addfeature')
@endsection

