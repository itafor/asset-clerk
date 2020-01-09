
@extends('new.layouts.app', ['title' => 'Portfolio Report', 'page' => 'portfolio'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-card"></i> Portfolio Report</h1>
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
                <h3 class="dt-entry__title">Portfolio</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">

<!-- search description -->
<form action="{{route('report.search_gen_portfolio')}}" method="post">
   @csrf
  <div class="row">
     <div class="form-group col-3">
      <label class="form-control-label" for="input-country">{{ __('Country') }}</label>
      <select name="country" id="country" class="form-control" required>
        <option value="">Select Country</option>
             @if(isset($country))
              <option value="{{$country->id}}" {{$country !== '' ? 'selected': '' }} >{{$country->name}}</option>
               @endif
        @foreach (getCountries() as $c)
            <option value="{{$c->id}}">{{$c->name}}</option>
        @endforeach
      </select>

      @if ($errors->has('country'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('country') }}</strong>
        </span>
      @endif
      </div>
     <div class="form-group col-3">
          <label class="form-control-label" for="input-state">{{ __('State') }}</label>
          <select name="state" id="state" class="form-control" required>
              <option value="">Select State</option>
              @if(isset($state))
              <option value="{{$state->id}}" {{$state !== '' ? 'selected': '' }} >{{$state->name}}</option>
               @endif
          </select>
          
          @if ($errors->has('state'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('state') }}</strong>
              </span>
          @endif
      </div>
                       
      <div class="form-group col-3">
          <label class="form-control-label" for="input-city">{{ __('City') }}</label>
          <select name="city" id="city" class="form-control" required>
              <option value="">Select City</option>
              @if(isset($city))
              <option value="{{$city->id}}" {{$city !== '' ? 'selected': '' }} >{{$city->name}}</option>
               @endif
          </select>

          @if ($errors->has('city'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('city') }}</strong>
              </span>
          @endif
      </div>
  
   <div class="form-group col-3">
 <label class="form-control-label" for="input-category">{{ __('Property Used') }}</label>
                                <div>
                                    <select name="property_used" id="property_used" class="form-control " style="width:100%" required>
                                    <option value="">Select</option>
                                      @if(isset($propertyUsed))
                                  <option value="{{$propertyUsed}}" {{$propertyUsed !== '' ? 'selected': '' }} > {{$propertyUsed }}</option>
                                  @endif
                                    <option value="All">All</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                </select>
                          </div>
</div>

<div class="form-group col-3">
          <label class="form-control-label" for="input-property_type">{{ __('Property Type') }}</label>

                                    <select name="property_type"  class="form-control" required>
                                        <option value="">Select Property Type</option>
                                        <option value="All">All</option>
                                         @foreach (getPropertyTypes() as $pt)
                                         @if(isset($propertyType))
                                  <option value="{{$propertyType}}" {{$pt->id == $propertyType ? 'selected': '' }} > {{$pt->name }}</option>
                                  @endif
                                        @endforeach

                                        @foreach (getPropertyTypes() as $pt)
                                            <option value="{{$pt->id}}">{{$pt->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('property_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('property_type') }}</strong>
                                        </span>
                                    @endif
                                </div>

                              <div class="form-group col-3">
 <label class="form-control-label" for="input-category">{{ __('Start Date') }}</label>
                                <div>
                                <input type="text" name="startDate" id="startDate" class=" datepicker form-control form-control-alternative{{ $errors->has('startDate') ? ' is-invalid' : '' }} " autocomplete="false" placeholder="Choose Date" value="{{isset($start_date) !=='' ? Carbon\Carbon::parse($start_date)->format('d/m/Y') : ''}}" required>
                                        
                                @if ($errors->has('startDate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('startDate') }}</strong>
                                    </span>
                                @endif
                          </div>
</div>


   <div class="form-group col-3">
 <label class="form-control-label" for="input-category">{{ __('End Date') }}</label>
                                <div>
                                <input type="text" name="dueDate" id="dueDate" class=" datepicker form-control form-control-alternative{{ $errors->has('dueDate') ? ' is-invalid' : '' }} " placeholder="Choose Date" value="{{isset($end_date) !=='' ? Carbon\Carbon::parse($end_date)->format('d/m/Y') : ''}}" required autocomplete="false">
                                        
                                @if ($errors->has('dueDate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dueDate') }}</strong>
                                    </span>
                                @endif
                          </div>
</div>
 <div class="form-group col-3">
 <label class="form-control-label" for="input-category">{{ __('Search') }}</label>
                                <div>
                                    <button class="btn btn-sm btn-primary">Search</button>
                          </div>
</div>

</div>
</form>
<div id="payment_status"></div>


          
                  <table class="table table-bordered" id="tbl_id">
           @if(isset($portfolio_reportDetails))
                @if(count($portfolio_reportDetails) >=1)
                    <tbody>
                   <tr>
                     <td style="width: 200px;">Lowest Price</td>
                     <td>&#8358;{{number_format($min_amt,2)}}</td>
                   </tr>

                     <tr>
                     <td style="width: 200px;">Highest Price</td>
                     <td>&#8358;{{number_format($max_amt,2)}}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;">Average Price</td>
                <td>&#8358;{{number_format($averageAmt,2)}}</td>           
              </tr>
              <tr>
                     <td style="width: 200px;">Property Count</td>
                <td>{{$property_count}}</td>           
              </tr>
               <tr>
                     <td style="width: 200px;">Rents Count</td>
                <td>{{$rents_count}}</td>           
              </tr>
               <tr>
                     <td style="width: 200px;">Occupancy Rate</td>
                <td>{{$occupancyRate}} %</td>           
              </tr>

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                    @endif
                  </table>



      

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
$('#country').change(function(){
            var country = $(this).val();
            if(country){
                $('#state').empty();
                $('<option>').val('').text('Loading...').appendTo('#state');
                $.ajax({
                    url: baseUrl+'/fetch-states/'+country,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#state').empty();
                        $('<option>').val('').text('Select State').appendTo('#state');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#state');
                        });
                    }
                });
            }
        });

        $('#state').change(function(){
            var state = $(this).val();
            if(state){
                $('#city').empty();
                $('<option>').val('').text('Loading...').appendTo('#city');
                $.ajax({
                    url: baseUrl+'/fetch-cities/'+state,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#city').empty();
                        $('<option>').val('').text('Select City').appendTo('#city');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#city');
                        });
                    }
                });
            }
        });

    </script>
@endsection