@extends('new.layouts.app', ['title' => 'Add New Maintenance', 'page' => 'maintenance'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-setting"></i> Maintenance Management</h1>
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
                <h3 class="dt-entry__title">Add New Maintenance</h3>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('maintenance.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Maintenance') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-tenant">{{ __('Customer') }}</label>
                                    <select name="customer" id="" class="form-control" required autofocus>
                                        <option value="">Select Customer</option>
                                        @foreach (getTenants() as $tenant)
                                            <option value="{{$tenant->id}}">{{$tenant->name()}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('customer'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('customer') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-category">{{ __('Asset Category') }}</label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach (getCategories() as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                    @if ($errors->has('category'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>

                                <div class="form-group{{ $errors->has('asset_description') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-tenant">{{ __('Asset Description') }}</label>
                                    <select name="asset_description" id="asset_description" class="form-control" required>
                                        <option value="">Select Asset Description</option>
                                    </select>

                                    @if ($errors->has('asset_description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('asset_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- <div class="form-group{{ $errors->has('location') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-location">{{ __('Location') }}</label>
                                    <select name="location" id="" class="form-control" required>
                                        <option value="">Select Location</option>
                                    </select>
                                    
                                    @if ($errors->has('location'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('location') }}</strong>
                                        </span>
                                    @endif
                                </div> --}}
                                {{-- <div style="clear:both"></div> --}}

                                <div class="form-group{{ $errors->has('building_section') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-building_section">{{ __('Building Section') }}</label>
                                    <select name="building_section" id="building_section" class="form-control" required>
                                        <option value="">Select Building Section</option>
                                        @foreach (getBuildingSections() as $b)
                                            <option value="{{$b->id}}">{{$b->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('building_section'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('building_section') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>
                                <div class="form-group{{ $errors->has('reported_date') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-reported_date">{{ __('Reported Date') }}</label>
                                    <input type="text" name="reported_date" id="input-reported_date" class="datepicker form-control form-control-alternative{{ $errors->has('reported_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('reported_date')}}" required>
                                    
                                    @if ($errors->has('reported_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('reported_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- <div style="clear:both"></div>          --}}

                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-date">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option>Fixed</option>
                                        <option>Unfixed</option>
                                    </select>
                                    
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>

                               
                                <div style="clear:both"></div>
                                <div class="form-group{{ $errors->has('fault_description') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-fault_description">{{ __('Fault Description') }}</label>
                                    <textarea rows="5" name="fault_description" id="input-fault_description" class="form-control form-control-alternative{{ $errors->has('fault_description') ? ' is-invalid' : '' }}" placeholder="Enter Fault Description" required>{{old('fault_description')}}</textarea>

                                    @if ($errors->has('fault_description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fault_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>    
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
         $('#category').change(function(){
            var category = $(this).val();
            if(category){
                $('#asset_description').empty();
                $('<option>').val('').text('Loading...').appendTo('#asset_description');
                $.ajax({
                    url: baseUrl+'/fetch-assets/'+category,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#asset_description').empty();
                        $('<option>').val('').text('Select Asset').appendTo('#asset_description');
                        $.each(data, function(k, v) {
                            $('<option>').val(v.uuid).text(v.description).attr('data-price',v.price).appendTo('#asset_description');
                        });
                    }
                });
            }
            else{
                $('#asset_description').empty();
                $('<option>').val('').text('Select Asset').appendTo('#asset_description');
            }
        });

    </script>
@endsection