@extends('new.layouts.app', ['title' => 'Rental', 'page' => 'Rental'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Rental details</h1>
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
                <h3 class="dt-entry__title">Rental details</h3>
              </div>
              <!-- /entry heading -->

              <!-- Entry Heading -->
              <div class="dt-entry__heading">
                <h3 class="dt-entry__title">
                  <a href="{{ route('rental.index') }}"><button class="btn btn-sm btn-primary">Back</button></a>
                </h3>
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
                  <!-- table-bordered  -->
<table class="table table-hover table-bordered">
  <tr>
    <td><b>Tenant Name</b> : </td> <td>{{$rental3->tenant ? $rental3->tenant->name() : ''}}</td>
     <td><b>Unit</b> : </td>  <td>{{$rental3->flat_number ? $rental3->flat_number : 'N/A'}}</td>
 <td><b>Rental Start Date</b> : <td>{{formatDate($rental3->startDate, 'Y-m-d', 'd M Y')}}</td>
  </tr>

   <tr>
                          
    <td><b>Property</b> : <td>{{$rental3->asset ? $rental3->asset->description : ''}}</td>
     <td><b>Property Estimate</b> :  <td>&#8358; {{number_format($rental3->price,2)}}</td>
     <td><b>Next Due Date</b> :  <td>{{getNextRentPayment($rental3)['due_date']}}</td>

  </tr>
  <td><b>Property Type</b> : </td> <td>{{$rental3->unit->propertyType ? $rental3->unit->propertyType->name : ''}}</td>
     <td><b>Amount</b> : </td><td>&#8358; {{number_format($rental3->amount,2)}}</td>
     
     <td><b>Payment Status</b> : </td><td>@if ($rental3->status == 'Partly paid' )
                           <span class="text-warning">{{$rental3->status}}</span>

                           @elseif($rental3->status == 'Paid')
                           <span class="text-success">{{$rental3->status}}</span> 

                            @else
                           <span class="text-danger">{{$rental3->status}}</span>
                           @endif</td>
  </tr>

 <tr>
    <td><b>Renewable Status</b> :  
     @if($rental3->renewable == 'yes')
           <td> 
            <div class="toggle-btn active no" style="font-size: 0;" id="rowNumber{{$rental3->uuid}}" data-row=" {{$rental3->uuid}}">
              {{$rental3->uuid}}
        </div> 
           </td>
           @else
          <td> 
            <div class="toggle-btn yes" style="font-size: 0;" id="rowNumber{{$rental3->uuid}}" data-row=" {{$rental3->uuid}}">
               {{$rental3->uuid}}
        </div> 
         </td>
          @endif
     <td><td></td>
     <td> </td><td></td>
  </tr>
</table>
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
@endsection