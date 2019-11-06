<div class="modal fade tenantdocument" tabindex="-1" role="dialog" aria-labelledby="tenantRents" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
     



            <!-- Card -->
            <div class="dt-card">
  <div class="modal-header ">
<div class="row col-md-12">
  <h5 class="modal-title col-md-6" id="tenantServiceCharges"> {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}} documents
                             </h5>
</div>
                

            
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">x
                </button>
            </div>
              <!-- Card Body -->
              <div class="dt-card__body">


                <!-- Tables -->
                <div class="table-responsive">

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th><b>Name</b></th>
                          <th><b>Document</b></th>
                          <th><b>Download</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($tenantDocuments as $doc)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$doc->name}}</td>
                          <td>
                 <img src="{{$doc->path}}" class="tenantdocument">
                          </td>
                     <td> 
            <p><i class="fa fa-download info"></i><a href="/uploads/{{$doc->image_url}}" download="{{$doc->image_url}}" style="height: 100px; width: 200px;">Download</a> </p>
 
       </td>
                          <td class="text-center">
                                  
                                      <form action="#" method="get">
                                          
                                          <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete?") }}') ? this.parentElement.submit() : ''">
                                              {{ __('Delete') }}
                                          </button>
                                      </form> 
                                  
                              
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
  </div>
</div>