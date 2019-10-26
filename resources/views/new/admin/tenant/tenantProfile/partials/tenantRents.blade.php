<div class="modal fade tenantRents" tabindex="-1" role="dialog" aria-labelledby="tenantRents" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
     



            <!-- Card -->
            <div class="dt-card">
  <div class="modal-header ">
<div class="row col-md-12">
  <h5 class="modal-title col-md-6" id="tenantServiceCharges"> {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}} Rents
                             </h5>
</div>
                

            
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                          <th><b>Tenant Name</b></th>
                          <th><b>Unit</b></th>
                          <th><b>Description</b></th>
                          <th><b>Proposed Price</b></th>
                          <th><b>Amount</b></th>
                          <th><b>Rental Start Date</b></th>
                          <th><b>Next Due Date</b></th>
                          <th><b>Status</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($tenantRents as $rental)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$rental->tenant->name()}}</td>
                          <td>{{$rental->unit->category->name}}</td>
                          <td>{{$rental->asset->description}}</td>
                          <td>&#8358; {{number_format($rental->price,2)}}</td>
                          <td>&#8358; {{number_format($rental->amount,2)}}</td>
                          <td>{{formatDate($rental->startDate, 'Y-m-d', 'd M Y')}}</td>
                          <td>{{getNextRentPayment($rental)['due_date']}}</td>
                          
                          <td>
                            
                           @if ($rental->status == 'Partly paid' )
                           <span class="text-warning">{{$rental->status}}</span>

                           @elseif($rental->status == 'Paid')
                           <span class="text-success">{{$rental->status}}</span> 

                            @else
                           <span class="text-danger">{{$rental->status}}</span>
                           @endif

                          </td>

                          <td class="text-center">
                              <div class="dropdown">
                                  <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Action
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                    @if($rental->status !=='Paid')
                                    <a href="{{ route('rentalPayment.create', ['uuid'=>$rental->uuid]) }}" class="dropdown-item">Pay</a>
                                    @else
                               <span  class="dropdown-item" style="color: green;">{{$rental->status}}</span>
                                    @endif
                                      <form action="{{ route('rental.delete', ['uuid'=>$rental->uuid]) }}" method="get">
                                          
                                          <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete?") }}') ? this.parentElement.submit() : ''">
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
  </div>
</div>