<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
     



            <!-- Card -->
            <div class="dt-card">
  <div class="modal-header ">
<div class="row col-md-12">
  <h5 class="modal-title col-md-6" id="tenantServiceCharges"> {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}} Service Charge Wallet's Transaction History
                             </h5>
     @if(isset($tenantWalletBal->amount))
   <h5 class="modal-title col-md-6" id="tenantServiceCharges"> 
   Current Wallet BALANCE:  &#8358; {{number_format($tenantWalletBal->amount,2)}}
 </h5>
 @else
  <h5 class="modal-title col-md-6" id="tenantServiceCharges"> 
   Current Wallet BALANCE:  <span>Wallet Account not found</span>
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
                          <th><b>Tenant</b></th>
                           <th><b>Transaction Type</b></th>
                          <th><b>Amount</b></th>
                          <th><b>Previous Balance</b></th>
                          <th><b>New Balance</b></th>
                          <th><b>Created At</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($tenantWalletsHistories as $history)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$history->tenantDetail}}</td>
                          <td>{{$history->transaction_type}}</td>
                          <td>&#8358; {{number_format($history->amount,2)}}</td>
                          <td>&#8358; {{number_format($history->previous_balance,2)}}</td>
                          <td> &#8358; {{number_format($history->new_balance,2)}}</td>
                          <td>{{\Carbon\Carbon::parse($history->created_at)->format('d M Y')}}</td>
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