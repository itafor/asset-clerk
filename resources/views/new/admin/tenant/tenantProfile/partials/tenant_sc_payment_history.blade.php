<div class="modal fade tenantSCPaymentHistory" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">


 <!-- Card -->
            <div class="dt-card">

 <div class="modal-header ">
<div class="row col-md-12">

  <h5 class="modal-title " id="tenantServiceCharges"> {{$tenantDetail->designation}}. {{$tenantDetail->firstname}} {{$tenantDetail->lastname}}'s Service Charges Payment History
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
                          <th><b>Tenant</b></th>
                          <th><b>Service Charge</b></th>
                          <th><b>Actual Amount</b></th>
                          <th><b>Amount Paid</b></th>
                          <th><b>Balance</b></th>
                          <th><b>Property</b></th>
                          <th><b>Payment Mode</b></th>
                          <th><b>Payment Date</b></th>
                          <th><b>Duration Paid For</b></th>
                          <th><b>Description</b></th>
                          <th><b>Created At</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($tenantSCHs as $pay)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$pay->tenantDetail}}</td>
                          <td>{{$pay->asset_service_charge ? $pay->asset_service_charge->description : $pay->name}}</td>
                          <td>&#8358;{{number_format($pay->actualAmount,2)}}</td>
                          <td>&#8358;{{number_format($pay->amountPaid,2)}}</td>
                          <td>&#8358;{{number_format($pay->balance,2)}}</td>
                          <td>{{$pay->property}}</td>
                          <td>{{$pay->payment_mode}}</td>
                          <td>{{ \Carbon\Carbon::parse($pay->payment_date)->format('d M Y')}}</td>
                          <td> {{$pay->durationPaidFor}}</td>
                          <td>{{$pay->description}}</td>
                          <td>{{ \Carbon\Carbon::parse($pay->created_at)->format('d M Y')}}</td>
                      
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