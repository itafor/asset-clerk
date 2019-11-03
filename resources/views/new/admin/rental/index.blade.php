@extends('new.layouts.app', ['title' => 'List of Rentals', 'page' => 'rental'])

@section('content')
    <!-- Page Header -->
    <style type="text/css">
      
      @import url(https://fonts.googleapis.com/css?family=Ubuntu);

.toggle-btn{
  width: 80px;
  height: 40px;
  margin: 10px;
  border-radius: 50px;
  display: inline-block;
  position: relative;
  background : url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAyklEQVQ4T42TaxHCQAyENw5wAhLACVUAUkABOCkSwEkdhNmbpHNckzv689L98toIAKjqGcAFwElEFr5ln6ruAMwA7iLyFBM/TPDuQSrxwf6fCKBoX2UMIYGYkg8BLOnVg2RiAEexGaQQq4w9e9klcxGLLAUwgDAcihlYAR1IvZA1sz/+AAaQjXhTQQVoe2Yo3E7UQiT2ijeQdojRtClOfVKvMVyVpU594kZK9zzySWTlcNqZY9tjCsUds00+A57z1e35xzlzJjee8xf0HYp+cOZQUQAAAABJRU5ErkJggg==') no-repeat 50px center #e74c3c;
  cursor: pointer;
  -webkit-transition: background-color .40s ease-in-out;
  -moz-transition: background-color .40s ease-in-out;
  -o-transition: background-color .40s ease-in-out;
  transition: background-color .40s ease-in-out;
  cursor:pointer;

}

  .active{
    background : url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAmUlEQVQ4T6WT0RWDMAhFeZs4ipu0mawZpaO4yevBc6hUIWLNd+4NeQDk5sE/PMkZwFvZywKSTxF5iUgH0C4JHGyF97IggFVSqyCFga0CvQSg70Mdwd8QSSr4sGBMcgavAgdvwQCtApvA2uKr1x7Pu++06ItrF5LXPB/CP4M0kKTwYRIDyRAOR9lJTuF0F0hOAJbKopVHOZN9ACS0UgowIx8ZAAAAAElFTkSuQmCC') no-repeat 10px center #2ecc71;
  }

   /* .round-btn{
      left: 45px;
    }*/
    .cb-value{
    position: absolute;
    left:0;
    right:0;
    width: 100%;
    height: 100%;
    opacity: 0;
    z-index: 9;
    cursor:pointer;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  }

    /*.round-btn{
    width: 30px;
    height: 30px;
    background-color: #fff;
    border-radius: 50%;
    display: inline-block;
    position: absolute;
    left: 5px;
    top: 50%;
    margin-top: -15px;
    -webkit-transition: all .30s ease-in-out;
  -moz-transition: all .30s ease-in-out;
  -o-transition: all .30s ease-in-out;
  transition: all .30s ease-in-out;
  }*/



    </style>
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
                          <th><b>Unit</b></th>
                          <th><b>Property</b></th>
                          <th><b>Property Estimate</b></th>
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
                          <td>{{$rental->unit->category->name}}</td>
                          <td>{{$rental->asset ? $rental->asset->description : ''}}</td>
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


      @if($rental->renewable == 'yes')
           <td> <a href="{{ route('renewable.no', ['uuid'=>$rental->uuid]) }}" class="text-success no"> 
            <div class="toggle-btn active">
  <span class="round-btn"></span>
</div> 
           </a></td>
           @else
          <td id="disapprove"> <a href="{{ route('renewable.yes', ['uuid'=>$rental->uuid]) }}" class="text-danger"> 
            <div class="toggle-btn">
  <span class="round-btn"></span>
</div> 
          </a></td>
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
<script type="text/javascript">

 $('.no').click(function() {

var sc_type = $(this).val();
 var mainParent = $(this).parent('.no').val();
console.log(mainParent);
            // if(sc_type){

            //     $('#serviceCharge').empty();
            //     $('<option>').val('').text('Loading...').appendTo('#serviceCharge');
            //     $.ajax({
            //         url: baseUrl+'/rental/no-renew-rental/'+sc_type,
            //         type: "GET",
            //         dataType: 'json',
            //         success: function(data) {
                      
            //         }
            //     });
            // }

});



 $('.cb-value').click(function() {
  
  var mainParent = $(this).parent('.toggle-btn');
  if($(mainParent).find('input.cb-value').is(':checked')) {
    $(mainParent).addClass('active');
  } else {
    $(mainParent).removeClass('active');
  }

});

</script>
        </div>
        <!-- /grid -->
@endsection