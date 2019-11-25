@extends('new.layouts.app', ['title' => 'Add Company Detail', 'page' => 'landlord'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Company Detail</h1>
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
                <h3 class="dt-entry__title">Edit Company Detail</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
<form method="post" action="{{ route('companydetail.update') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="pl-lg-4">
                                <input type="hidden" name="uuid" value="{{$details->uuid}}">
                                <div class="form-group{{ $errors->has('company_name') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-category">{{ __('Company Name') }}</label>
                             
                               <input type="text" name="company_name" id="input-company_name" class="form-control form-control-alternative{{ $errors->has('company_name') ? ' is-invalid' : '' }}" placeholder="Enter Company Name" value="{{$details->name}}" required>

                                    @if ($errors->has('company_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('company_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('company_phone') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-gender">{{ __('Company Phone') }}</label>
                                
                                 <input type="text" name="company_phone" id="input-company_phone" class="form-control form-control-alternative{{ $errors->has('company_phone') ? ' is-invalid' : '' }}" placeholder="Enter Company Phone number" value="{{$details->phone}}" required>

                                    @if ($errors->has('input-company_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('company_phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>

                                <div class="form-group{{ $errors->has('company_email') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-company_email">{{ __('Email') }}</label>
                                    <input type="text" name="company_email" id="input-company_email" class="form-control form-control-alternative{{ $errors->has('company_email') ? ' is-invalid' : '' }}" placeholder="Enter Company Email" value="{{$details->email}}" required>

                                    @if ($errors->has('company_email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('company_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('company_address') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-company_address">{{ __('Company Address') }}</label>
                                    <input type="text" name="company_address" id="input-company_address" class="form-control form-control-alternative{{ $errors->has('lastname') ? ' is-invalid' : '' }}" placeholder="Enter Company addess" value="{{$details->address}}" required>
                                    
                                    @if ($errors->has('company_address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('company_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>         

                                <div style="clear:both"></div>                         
                            </div>

                            <h6 class="heading-small text-muted mb-4">{{ __('Company Logo') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('company_logo') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-company_logo">{{ __('Logo') }}</label>
                                    <input type="file" name="company_logo" id="input-company_logo" class="form-control form-control-alternative{{ $errors->has('company_logo') ? ' is-invalid' : '' }}">
                                    
                                    @if ($errors->has('company_logo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('company_logo') }}</strong>
                                        </span>
                                    @endif

                                    <img src="{{ asset('uploads/'.$details->logo)}}" alt="Logo" title="Company logo" width="200" height="150">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
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