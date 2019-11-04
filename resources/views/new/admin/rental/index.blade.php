@extends('new.layouts.app', ['title' => 'List of Rentals', 'page' => 'rental'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Rental Management</h1>
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
                <h3 class="dt-entry__title">List of Rentals</h3>
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

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th><b>Tenant Name</b></th>
                          <th><b>Property</b></th>
                         <!--  <th><b>Property Estimate</b></th> -->
                          <th><b>Amount</b></th>
                          <th><b>Rental Start Date</b></th>
                          <th><b>Next Due Date</b></th>
                          <th><b>Payment Status</b></th>
                          <th><b>Renewable Status</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($rentals as $rental)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                         
                          <td>{{$rental->tenant->name()}}</td>
                         
                          <td>{{$rental->asset ? $rental->asset->description : ''}}</td>
                         <!--  <td>&#8358; {{number_format($rental->price,2)}}</td> -->
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


      @if($rental->renewable == 'yes')
           <td> 
            <div class="toggle-btn active no" style="font-size: 0;" id="rowNumber{{$rental->uuid}}" data-row=" {{$rental->uuid}}">
              {{$rental->uuid}}
        </div> 
           </td>
           @else
          <td> 
            <div class="toggle-btn yes" style="font-size: 0;" id="rowNumber{{$rental->uuid}}" data-row=" {{$rental->uuid}}">
               {{$rental->uuid}}
        </div> 
         </td>
          @endif


                          

                          <td class="text-center">
                              <div class="dropdown">
                                  <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Action
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                    @if($rental->status !=='Paid')
                                    <a href="{{ route('rentalPayment.create', ['uuid'=>$rental->uuid]) }}" class="dropdown-item">Record Payment</a>
                                    @else
                               <span  class="dropdown-item" style="color: green;">{{$rental->status}}</span>
                                    @endif
                                     <a href="{{ route('rental.view.detail', ['uuid'=>$rental->uuid]) }}" class="dropdown-item">View</a>
                                 <a href="{{ route('rent-payment.payment.record', ['uuid'=>$rental->uuid]) }}" class="dropdown-item">View Payment record </a>


                            @if ($rental->new_rental_status == 'New' )

                                    <a href="{{ route('rental.edit', ['uuid'=>$rental->uuid]) }}" class="dropdown-item">Edit</a>
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
          <!-- /grid item -->
        </div>
        <!-- /grid -->
@endsection