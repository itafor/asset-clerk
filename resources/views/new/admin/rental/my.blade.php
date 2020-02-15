@extends('new.layouts.app', ['title' => 'My Rented Apartments', 'page' => 'rental'])

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
                <h3 class="dt-entry__title">My Rented Apartments</h3>
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
                          <th><b>Description</b></th>
                          <!-- <th><b>Unit</b></th>  -->
                          <th><b>Price</b></th>
                          <th><b>Rental Start Date</b></th>
                          <th><b>Rental Due Date</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($rentals as $rental)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$rental->asset ? $rental->asset->description : ''}}</td>
                          <!-- <td>{{$rental->unit->category ? $rental->unit->category->name : ''}}</td> -->
                          <td>&#8358; {{number_format($rental->price,2)}}</td>
                          <td>{{formatDate($rental->startDate, 'Y-m-d', 'd M Y')}}</td>
                          <td>{{formatDate($rental->due_date, 'Y-m-d', 'd M Y')}}</td>
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