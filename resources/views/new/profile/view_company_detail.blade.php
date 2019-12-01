@extends('new.layouts.app', ['title' => 'Company Profile', 'page' => 'Company Profile'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-setting"></i> Company Profile</h1>
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
                <h3 class="dt-entry__title">Company Profile</h3>
              </div>

  <div class="dt-entry__heading">
 <a href="{{ route('companydetail.edit',['uuid'=>$details->uuid]) }}">
<button class="btn btn-sm btn-primary">
 Edit
</button>
</a>
                
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

                  <table class="table table-bordered" id="tbl_id">
           
                    <tbody>
                   <tr>
                     <td style="width: 60px;">Reference</td>
                     <td>{{$details->uuid}}</td>
                   </tr>

                     <tr>
                     <td style="width: 60px;">COMPANY NAME</td>
                     <td>{{$details->name}}</td>
                   </tr>

                    <tr>
                     <td style="width: 60px;">COMPANY PHONE</td>
                <td>{{$details->phone}}</td>           
              </tr>

                 <tr>
                     <td style="width: 60px;">COMPANY EMAIL</td>
                     <td>{{$details->email}}</td>
                </tr>

                 <tr>
                     <td style="width: 60px;">COMPANY ADDRESS</td>
                     <td>
                      <p>
                      {{$details->address}}
                      </p>
                    </td>
                </tr>

                 <tr>
                     <td style="width: 60px;">COMPANY LOGO</td>
                      <td>
      <img src="{{ asset('uploads/'.$details->logo)}}" alt="Logo" title="Company logo" width="200" height="150">
                        </td>
                </tr>
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



@section('script')
    <script>
  
    </script>
@endsection