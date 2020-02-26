 <!-- Grid -->
        <div class="row">

          <!-- Grid Item -->
          <div class="col-xl-12">

            <!-- Entry Header -->
            <div class="dt-entry__header">

              <!-- Entry Heading -->
              <div class="dt-entry__heading">
                <h3 class="dt-entry__title">Summary</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <h5 class="card-title">Summary Message</h5>
    <p class="card-text">
      
      You have successfully added (<strong>{{$tenant_record->firstname}} {{$tenant_record->lastname}}</strong>) to your property, (<strong>{{$asset_record->description}}</strong>)  
      @if(isset($landlord_record))
      @if($landlord_record !=null)
      belong to
      (<strong>
        {{$landlord_record->firstname}} {{$landlord_record->lastname}}</strong>)
      @endif
 @endif
         with a rental value of <strong>&#8358;{{number_format($rental_record->amount,2)}}</strong> 
      @if(isset($payment) && $payment !='')
         and
<strong>&#8358;{{number_format($payment->amount_paid,2)}}</strong> 
paid.
 @endif

<br>
<br>

A notification with the details has been sent to <strong>{{$tenant_record->email}}</strong> and <strong>{{auth()->user()->email}}</strong>
<br>
<br>
To add payment to current rent records please click here <a href="{{ route('rentalPayment.create', ['uuid'=>$rental_record->uuid]) }}" class="btn btn-xs btn-primary ">Add Payment</a>
<br>
<br>
Rent renewal notifications of <strong>&#8358;{{number_format($rental_record->amount,2)}}</strong> will be sent out on the
following dates to <strong>{{$tenant_record->email}}</strong> and <strong>{{auth()->user()->email}}</strong>
<br>
<br>

<table>
  <tr>
    <td style="width: 100px;">Date 1:</td>
    <td>25%</td>
  </tr>
  <tr>
    <td style="width: 100px;">Date 2:</td>
    <td>12.5%</td>
  </tr>
  <tr>
    <td style="width: 100px;">Date 3:</td>
    <td>6.5%</td>
  </tr>
  <tr>
    <td style="width: 100px;">Date 5:</td>
    <td>0%</td>
  </tr>
</table>
<br>
<br>
To make changes to the next rental amount please click here.
    </p>

    <div class="text-center">
         <a href="{{ route('multi-step.done') }}">
     <button type="submit" class="btn btn-success mt-4">{{ __('Done') }}</button>
     </a>
                </div>
        </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

          </div>
          <!-- /grid item -->

        </div>
        <!-- /grid -->
