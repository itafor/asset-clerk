<div class="modal fade unpaidRental" tabindex="-1" role="dialog" aria-labelledby="unpaidRental" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
     



            <!-- Card -->
            <div class="dt-card">
  <div class="modal-header ">
<div class="row col-md-12">
  <h5 class="modal-title col-md-6" id="tenantServiceCharges"> {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}} unpaid Rentals
                             </h5>

     @if(isset($tenantRentalTotalDebt))
   <h5 class="modal-title col-md-6" id="tenantServiceCharges"> 
   Sum of unpaid rentals:  &#8358; {{number_format($tenantRentalTotalDebt,2)}}
 </h5>
 @endif
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
                          <th><b>Full Name</b></th>
                          <th><b>Asset</b></th>
                          <th><b>Property Estimate</b></th>
                          <th><b>Amount</b></th>
                          <th><b>Balance</b></th>
                          <th><b>Payment Date</b></th>
                          <th><b>Created At</b></th>
                          <th><b>Duration paid for</b></th>
                          
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($tenantRentalDebts as $rent)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>
                            {{$rent->unit->getTenant()->designation}}.
                            {{$rent->unit->getTenant()->firstname}}
                            {{$rent->unit->getTenant()->lastname}}
                          </td>
                          <td>{{$rent->asset->description}}</td>
                          <td>&#8358;{{number_format($rent->proposed_price,2)}}</td>
                          <td>&#8358;{{number_format($rent->actual_amount,2)}}</td>
                          <td>&#8358;{{number_format($rent->balance,2)}}</td>
                          <td>{{\Carbon\Carbon::parse($rent->payment_date)->format('d/m/Y')}}</td>
                          <td>{{\Carbon\Carbon::parse($rent->created_at)->format('d/m/Y')}}</td>
                          <td>{{$rent->startDate}} -  {{$rent->due_date}}</td>
                          
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