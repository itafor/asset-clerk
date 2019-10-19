
<!-- Large modal -->


<div class="modal fade tenant-service-charges" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
     
            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">


 @if(isset($tenantsAssignedScs))
           
  <div class="modal-header ">
<div class="row col-md-12">
  <h5 class="modal-title col-md-6" id="tenantServiceCharges"> {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}}'s Unpaid Service Charges 
                             </h5>

   <h5 class="modal-title col-md-6" id="tenantServiceCharges"> 
    OUTSTANDING BALANCE:  &#8358; {{number_format($tenantTotalDebt,2)}}
 </h5>
</div>
                

            
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
                        <th><b>Updated At</b></th>
                        <th><b>Start Date</b></th>
                        <th><b>Due Date</b></th>
                    </tr>
                    </thead>
                    <tbody>
                       
                                
                    @foreach ($tenantsAssignedScs as $tenant)
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
                            
                            <td>   {{  \Carbon\Carbon::parse($tenant->updated_at)->format('d M Y')}}</td>
                             <td>   {{  \Carbon\Carbon::parse($tenant->dueDate)->format('d M Y')}}</td>
                             <td>   {{  \Carbon\Carbon::parse($tenant->dueDate)->format('d M Y')}}</td>
    
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
  </div>
</div>
<!-- modal end -->