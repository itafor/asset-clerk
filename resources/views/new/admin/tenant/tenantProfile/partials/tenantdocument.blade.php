<div class="modal fade tenantdocument" tabindex="-1" role="dialog" aria-labelledby="tenantRents" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
     

<style>
img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 150px;
}

img:hover {
  box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}

embed{
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 150px;
}

embed:hover {
  box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>

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
                                                              
                    @if (pathinfo($doc->image_url, PATHINFO_EXTENSION) == 'pdf')
                    <a href="{{$doc->path}}" target="_blank">
                  <embed src="{{$doc->path}}" width="150" height="150" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                </a>
                  @else
                  <a target="_blank" href="{{$doc->path}}">
                 <img src="{{$doc->path}}" class="tenantdocument" height="150" width="150" >
                </a>
                  @endif
                          </td>
                     <td> 
            <p><i class="fa fa-download info"></i><a href="/uploads/{{$doc->image_url}}" download="{{$doc->image_url}}" style="height: 100px; width: 200px;">Download</a> </p>
 
       </td>
                          <td class="text-center">
                                  
                                      <form action="{{ route('delete.doc', ['id'=>$doc->id]) }}" method="get">
                                          
                                          <button type="button" class="btn btn-danger btn-sm" onclick="confirm('{{ __("Are you sure you want to delete?") }}') ? this.parentElement.submit() : ''">
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