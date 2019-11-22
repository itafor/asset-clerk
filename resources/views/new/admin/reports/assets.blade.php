@extends('new.layouts.app', ['title' => 'List of Service Charges', 'page' => 'service'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Assets Report</h1>
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
                <h3 class="dt-entry__title">Assets</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">

<!-- search description -->
<form action="{{route('search.service.charge')}}" method="post">
   @csrf
  <div class="row">
     <div class="form-group col-3">
      <label class="form-control-label" for="input-category">{{ __('Property') }}</label>
          
              <select name="asset" id="asset" class="form-control {{$errors->has('asset') ? ' is-invalid' : ''}} asset" style="width:100%" required>
              <option value="">Select Property</option>
              @foreach(getAssets() as $asset)
              <option value="{{$asset->id}}">{{$asset->description}}</option>
              @endforeach
              
          </select>
          
             @if ($errors->has('asset'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('asset') }}</strong>
                      </span>
                @endif               
</div>

   <div class="form-group col-3">
 <label class="form-control-label" for="input-category">{{ __('Occupancy') }}</label>
                                <div>
                                    <select name="type" id="occupancy" class="form-control" style="width:100%" >
                                    <option value="">Select</option>
                                </select>
                          </div>
</div>


   <div class="form-group col-3">
 <label class="form-control-label" for="input-category">{{ __('Payment') }}</label>
                                <div>
                                    <select name="type" id="payment" class="form-control" style="width:100%" >
                                    <option value="">Select</option>
                                </select>
                          </div>
</div>
  
   <div class="form-group col-3">
 <label class="form-control-label" for="input-category">{{ __('Type') }}</label>
                                <div>
                                    <select name="type" id="type" class="form-control " style="width:100%" >
                                    <option value="">Select</option>
                                    
                                </select>
                          </div>
</div>

</div>
</form>
<div id="payment_status"></div>

 <!-- Tables -->
<div class="table-responsive">
 <!--  <div id="all"></div> -->

      <table class="table table-striped table-bordered table-hover" id="occupancy_table">
       <thead>
      <tr>
    <th><b>Name</b></th>
    <th>Location</th>
    <th>Landlord</th>
    <th class="occupancy_th">Occupancy</th>
    <th>Payment Status</th>
    <th>Type</th>
    <th>Description</th>
    <th class="units">Units Added</th>
    <th class="units">Units Left</th>
   </tr>
   </thead>
    <tbody>
    </tbody>

  </table>

  </div>


              </div>
              <!-- /card body -->

            </div>
            <!-- /card -->

          </div>
          <!-- /grid item -->


        </div>
        <!-- /grid -->
       <!--  -->

@endsection

@section('script')
    <script>
//  var asset = ''
// $(document).ready(function(){


//   $('body').on('change', '.asset', function(){
//             asset = $(this).val();
//             console.log(asset)
//             if(asset){

//             $('#occupancy').empty();
//            $('<option>').attr('selected', true).val('').text('Select Occupancy').appendTo('#occupancy');
//             $.each(['All','Occupied','Vacant'], function(k, v) {
//                $('<option>').val(v).text(v).appendTo('#occupancy');
//                         })


//              $('#payment').empty();
//            $('<option>').attr('selected', true).val('').text('Select Payment').appendTo('#payment');
//             $.each(['All','Paid','Partly','Unpaid'], function(k, v) {
//                $('<option>').val(v).text(v).appendTo('#payment');
//                         })

//              $('#type').empty();
//            $('<option>').attr('selected', true).val('').text('Select Payment').appendTo('#type');
//             $.each(['Residential','Commercial'], function(k, v) {
//                $('<option>').val(v).text(v).appendTo('#type');
//                         })
//           }

//         });
// })

// $(document).ready(function(){
//  $('body').on('change', '#occupancy', function(){
//             var occupancy = $(this).val();
//             $('.occupancy_th').show()
//             $('.units').show()

//             if(occupancy ==''){
//             $('tbody').html('');
//             }
//               $('#payment').empty();
//              $('<option>').attr('selected', true).val('').text('Select payment').appendTo('#payment');

//              $('#type').empty();
//              $('<option>').attr('selected', true).val('').text('Select Type').appendTo('#type');

//              if(occupancy == ''){
//             $('#payment').empty();
//            $('<option>').attr('selected', true).val('').text('Select Payment').appendTo('#payment');
//             $.each(['All','Paid','Partly','Unpaid'], function(k, v) {
//                $('<option>').val(v).text(v).appendTo('#payment');
//                         })

//              $('#type').empty();
//            $('<option>').attr('selected', true).val('').text('Select Payment').appendTo('#type');
//             $.each(['Residential','Commercial'], function(k, v) {
//                $('<option>').val(v).text(v).appendTo('#type');
//                         })
//              }

//             if(asset && occupancy == 'All'){
//                 $.ajax({
//                     url:"{{URL::to('report/get-asset-occupancy')}}/"+asset+'/'+occupancy,
//                     type: "GET",
//                     data: {'asset':asset},
//                     success: function(data) {
//                       console.log('all occupancies',data)
//                       // window.localStorage.setItem('all', data);
//                       // $('tbody').html(window.localStorage.getItem('all'));
//                       $('tbody').html(data);
//                     }
//                 });
//             }else 
//             if(asset && occupancy == 'Occupied'){
//                 console.log('all occupancy', occupancy, asset)
//                 $.ajax({
//                     url:"{{URL::to('report/get-asset-occupancy')}}/"+asset+'/'+occupancy,
//                     type: "GET",
//                     data: {'asset':asset},
//                     success: function(data) {
//                       console.log('all occupancies',data)
//                       $('tbody').html(data);
//                     }
//                 });
//             }else 
//             if(asset && occupancy == 'Vacant'){
//                 console.log('all occupancy', occupancy, asset)
//                 $.ajax({
//                     url:"{{URL::to('report/get-asset-occupancy')}}/"+asset+'/'+occupancy,
//                     type: "GET",
//                     data: {'asset':asset},
//                     success: function(data) {
//                       console.log('all occupancies',data)
//                       $('tbody').html(data);
//                     }
//                 });
//             }
//         });
// })

 
// $(document).ready(function(){

//         $('body').on('change', '#payment', function(){

//             var payment = $(this).val();
//             $('.units').hide()
//             $('.occupancy_th').hide()
//              $('#occupancy').empty();
//              $('<option>').attr('selected', true).val('').text('Select payment').appendTo('#occupancy');

//              $('#type').empty();
//              $('<option>').attr('selected', true).val('').text('Select Type').appendTo('#type');

//              if(payment == ''){
//                  $('#occupancy').empty();
//            $('<option>').attr('selected', true).val('').text('Select Occupancy').appendTo('#occupancy');
//             $.each(['All','Occupied','Vacant'], function(k, v) {
//                $('<option>').val(v).text(v).appendTo('#occupancy');
//                         })

//              $('#type').empty();
//            $('<option>').attr('selected', true).val('').text('Select Payment').appendTo('#type');
//             $.each(['Residential','Commercial'], function(k, v) {
//                $('<option>').val(v).text(v).appendTo('#type');
//                         })

//              }

//             if(asset && payment == 'All'){
//                    $.ajax({
//                     url:"{{URL::to('report/get-asset-payment')}}/"+asset+'/'+payment,
//                     type: "GET",
//                     data: {'asset':asset},
//                     success: function(data) {
//                       console.log('all occupancies',data)
//                       $('tbody').html(data);
//                     }
//                 });

//             }else 
//             if(asset && payment == 'Paid'){
//                    $.ajax({
//                     url:"{{URL::to('report/get-asset-payment')}}/"+asset+'/'+payment,
//                     type: "GET",
//                     data: {'asset':asset},
//                     success: function(data) {
//                       console.log('all occupancies',data)
//                       $('tbody').html(data);
//                     }
//                 });

//             }else 
//             if(asset && payment == 'Partly'){
//                    $.ajax({
//                     url:"{{URL::to('report/get-asset-payment')}}/"+asset+'/'+payment,
//                     type: "GET",
//                     data: {'asset':asset},
//                     success: function(data) {
//                       console.log('all occupancies',data)
//                       $('tbody').html(data);
//                     }
//                 });

//             }else 
//             if(asset && payment == 'Unpaid'){
//                    $.ajax({
//                     url:"{{URL::to('report/get-asset-payment')}}/"+asset+'/'+payment,
//                     type: "GET",
//                     data: {'asset':asset},
//                     success: function(data) {
//                       console.log('all occupancies',data)
//                       $('tbody').html(data);
//                     }
//                 });

//             }


//         });
// })


// $('body').on('change', '#type', function(){

//             var type = $(this).val();
//             console.log('type asset',asset)
//             console.log('type',type)

//              $('#occupancy').empty();
//              $('<option>').attr('selected', true).val('').text('Select Occupancy').appendTo('#occupancy');

//              $('#payment').empty();
//              $('<option>').attr('selected', true).val('').text('Select payment').appendTo('#payment');

//              if(type == ''){
//               $('#occupancy').empty();
//            $('<option>').attr('selected', true).val('').text('Select Occupancy').appendTo('#occupancy');
//             $.each(['All','Occupied','Vacant'], function(k, v) {
//                $('<option>').val(v).text(v).appendTo('#occupancy');
//                         })
//              $('#payment').empty();
//            $('<option>').attr('selected', true).val('').text('Select Payment').appendTo('#payment');
//             $.each(['All','Paid','Partly','Unpaid'], function(k, v) {
//                $('<option>').val(v).text(v).appendTo('#payment');
//                         })
//              }

//             if(type){

//                 // $('#type').empty();
//                 // $('<option>').val('').text('Loading...').appendTo('#service_name');
//                 $.ajax({
//                     url: baseUrl+'/fetch-service-charge/'+asset,
//                     type: "GET",
//                     dataType: 'json',
//                     success: function(data) {
//                         $('#service_name').empty();
//                         $('<option>').val('').text('Select Service Charge').appendTo('#service_name');
//                         $.each(data, function(k, v) {
//                             $('<option>').val(v.name).text(v.name).appendTo('#service_name');
//                         });
//                     }
//                 });
//             }
//         });





//   $(document).on('keyup', '#minAmt, #maxAmt', function(e){
//     e.preventDefault();
//     let $value = e.target.value;
// if($value <= 0){
//     // alert('Invalid input');
//      $(this).val('');
// }
//  });

//  public function rentalPaymentStatus($unit_uuid){
//         $rentals = TenantRent::where('user_id', getOwnerUserID())
//                     ->where('unit_uuid',$unit_uuid)
//         ->orderBy('id', 'desc')->get();
//         return view('new.admin.reports.rental_payment_status', compact('rentals'));
//     }


//     public function asset_payment($asset_id,$payment_status = '')
//     {
//        if($payment_status == 'All'){
//     $asset = Asset::where('id',$asset_id)->first();
    
//     $all = TenantRent::where('tenant_rents.asset_uuid',$asset->uuid)
//         ->where('user_id',getOwnerUserID())
//         ->get();
//        // return  $all;
//         $output = '
    
//      ';  
//      foreach($all as $allasset)
//      {
//       $output .= '
   
//       <tr>
//        <td>'.$allasset->asset->description.'</td>
//        <td>'.$allasset->asset->address.'</td>
//        <td>'.$allasset->asset->Landlord->designation. ' '. $allasset->asset->Landlord->firstname. ' '. $allasset->asset->Landlord->lastname. '</td>
//        <td class="text-secondary">'.$allasset->status.'</a>'.'</td>
      
//        <td>'.$allasset->unit->propertyType->name.'</td>

//        <td>'.$allasset->unit->category->name.' Bedroom'.'</td>

//       </tr>
//       ';
//      }
  
//      return $output;

// }elseif($payment_status == 'Paid'){
//     $asset = Asset::where('id',$asset_id)->first();
    
//     $all = TenantRent::where('tenant_rents.asset_uuid',$asset->uuid)
//         ->where('status', 'Paid')
//         ->where('user_id',getOwnerUserID())
//         ->get();
//        // return  $all;
//         $output = '
    
//      ';  
//      foreach($all as $allasset)
//      {
//       $output .= '
   
//       <tr>
//        <td>'.$allasset->asset->description.'</td>
//        <td>'.$allasset->asset->address.'</td>
//        <td>'.$allasset->asset->Landlord->designation. ' '. $allasset->asset->Landlord->firstname. ' '. $allasset->asset->Landlord->lastname. '</td>
//        <td class="text-success">'.$allasset->status.'</a>'.'</td>
      
//        <td>'.$allasset->unit->propertyType->name.'</td>

//        <td>'.$allasset->unit->category->name.' Bedroom'.'</td>
       

       
//       </tr>
//       ';
//      }
  
//      return $output;

// }elseif($payment_status == 'Partly'){
//     $asset = Asset::where('id',$asset_id)->first();
    
//     $all = TenantRent::where('tenant_rents.asset_uuid',$asset->uuid)
//         ->where('status', 'Partly paid')
//         ->where('user_id',getOwnerUserID())
//         ->get();
//        // return  $all;
//         $output = '
    
//      ';  
//      foreach($all as $allasset)
//      {
//       $output .= '
   
//       <tr>
//        <td>'.$allasset->asset->description.'</td>
//        <td>'.$allasset->asset->address.'</td>
//        <td>'.$allasset->asset->Landlord->designation. ' '. $allasset->asset->Landlord->firstname. ' '. $allasset->asset->Landlord->lastname. '</td>
//        <td class="text-warning">'.$allasset->status.'</a>'.'</td>
      
//        <td>'.$allasset->unit->propertyType->name.'</td>

//        <td>'.$allasset->unit->category->name.' Bedroom'.'</td>
       

       
//       </tr>
//       ';
//      }
  
//      return $output;

// }elseif($payment_status == 'Unpaid'){
//     $asset = Asset::where('id',$asset_id)->first();
    
//     $all = TenantRent::where('tenant_rents.asset_uuid',$asset->uuid)
//         ->where('status', 'Pending')
//         ->where('user_id',getOwnerUserID())
//         ->get();
//        // return  $all;
//         $output = '
    
//      ';  
//      foreach($all as $allasset)
//      {
//       $output .= '
   
//       <tr>
//        <td>'.$allasset->asset->description.'</td>
//        <td>'.$allasset->asset->address.'</td>
//        <td>'.$allasset->asset->Landlord->designation. ' '. $allasset->asset->Landlord->firstname. ' '. $allasset->asset->Landlord->lastname. '</td>
//        <td class="text-danger">'.$allasset->status.'</a>'.'</td>
      
//        <td>'.$allasset->unit->propertyType->name.'</td>

//        <td>'.$allasset->unit->category->name.' Bedroom'.'</td>
       

       
//       </tr>
//       ';
//      }
  
//      return $output;

// }


//     }

    </script>
@endsection