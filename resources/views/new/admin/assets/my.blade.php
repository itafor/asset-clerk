@extends('new.layouts.app', ['title' => 'My Assets', 'page' => 'asset'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Asset Management</h1>
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
                <h3 class="dt-entry__title">Assigned Assets</h3>
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
                        <th><b>Location</b></th>
                        <th><b>Units</b></th>
                        <th class="text-center"><b>Action</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($assets as $assigned)
                        <tr>
                            <td>
                                @php
                                    $i = $loop->iteration;
                                    $asset = $assigned->asset;
                                @endphp
                            {{$i}} 
                            </td>
                            <td>{{ $asset->description }}</td>
                            <td>{{ $asset->address }}</td>
                            <td>
                                <a href="#x" data-toggle="modal" data-target="#unit{{$i}}" class="text-underline">{{ $asset->units ? $asset->units->count() : 0 }}</a>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a href="#x" data-toggle="modal" data-target="#assignModal{{$i}}" class="dropdown-item">Assign</a>
                                        <a href="#x" data-toggle="modal" data-target="#serviceModal" data-asset="{{$asset->id}}" class="dropdown-item addService">Add Service Charge</a>
                                        <a href="#x" data-toggle="modal" data-target="#unitModal" data-asset="{{$asset->id}}" class="dropdown-item addUnit">Add Unit(s)</a>
                                        <a href="{{ route('asset.edit', ['uuid'=>$asset->uuid]) }}" class="dropdown-item">Edit</a>
                                        <form action="{{ route('asset.delete', ['uuid'=>$asset->uuid]) }}" method="get">
                                            
                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this asset?") }}') ? this.parentElement.submit() : ''">
                                                {{ __('Delete') }}
                                            </button>
                                        </form> 
                                    </div>
                                </div>
                                @include('admin.assets.partials.assign')
                                @include('admin.assets.partials.units')
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
        @include('admin.assets.partials.service')
        @include('admin.assets.partials.addUnit')
@endsection

@section('script')
    <script>
        $('.user').select2({
            placeholder: 'Type user email or name here',
            ajax: {
                url: baseUrl+'/search-users',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.firstname + ' '+item.lastname,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('body').on('change', '.sc_type', function(){
            var sc_type = $(this).val();
            var row = $(this).data('row');
            if(sc_type){

                $('#serviceCharge'+row).empty();
                $('<option>').val('').text('Loading...').appendTo('#serviceCharge'+row);
                $.ajax({
                    url: baseUrl+'/fetch-service-charge/'+sc_type,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#serviceCharge'+row).empty();
                        $('<option>').val('').text('Select Service Charge').appendTo('#serviceCharge'+row);
                        $.each(data, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#serviceCharge'+row);
                        });
                    }
                });
            }
        });

        // Remove parent of 'remove' link when link is clicked.
        $('#containerSC').on('click', '.remove_project_file', function(e) {
            e.preventDefault();
            $(this).parent().remove();
            rowsc--;
        });
        function identifier(){
            return Math.floor(Math.random() * (99999999 - 10000000 + 1)) + 10000000;
        }
        var rowsc = 1;

        $('#addMoreSC').click(function(e) {
            e.preventDefault();

            if(rowsc >= 5){
                alert("You've reached the maximum limit");
                return;
            }

            var rowId = identifier();

            $("#containerSC").append(
                '<div id="rowNumber'+rowId+'" data-row="'+rowId+'">'
                    +'<div style="float:right" class="remove_project_file"><span style="cursor:pointer" class="badge badge-danger" border="2">Remove</span></div>'
                    +'<div style="clear:both"></div>'
                    +'<div class="form-group" style="width:31%; float:left; margin-right:25px">'
                    +'    <label class="form-control-label" for="input-category">{{ __('Type') }}</label>'
                    +'    <select name="service['+rowId+'][type]" class="form-control sc_type select'+rowId+'" data-row="'+rowId+'" required>'
                    +'        <option value="">Select Type</option>'
                    +'        <option value="fixed">Fixed</option>'
                    +'        <option value="variable">Variable</option>'
                    +'    </select>'
                    +'</div>'
                    +'<div class="form-group" style="width:31%; float:left; margin-right:25px">'
                    +'    <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>'
                    +'    <select name="service['+rowId+'][service_charge]" id="serviceCharge'+rowId+'" class="form-control select'+rowId+'" required>'
                    +'        <option value="">Select Service Charge</option>'
                    +'    </select>'
                    +'</div>       '            
                    +'<div class="form-group" style="width:31%; float:left">'
                    +'    <label class="form-control-label" for="input-price">{{ __('Price') }}</label>'
                    +'    <input type="number" name="service['+rowId+'][price]" id="input-price" class="form-control" placeholder="Enter Price" required>'
                    +'</div>'
                    +'<div style="clear:both"></div>'
                +'</div>'
            );
            rowsc++;
            $(".select"+rowId).select2({
                theme: "bootstrap"
            });
        });


        $('.addService').click(function(){
            var asset = $(this).data('asset');
            $('#asset').val(asset);
        })
        $('.addUnit').click(function(){
            var asset = $(this).data('asset');
            $('#assetU').val(asset);
        })

        var row = 1;

        $('#addMore').click(function(e) {
            e.preventDefault();

            if(row >= 5){
                alert("You've reached the maximum limit");
                return;
            }

            var rowId = identifier();

            $("#container").append(
                '<div id="rowNumber'+rowId+'" data-row="'+rowId+'">'
                    +'<div style="float:right" class="remove_project_file"><span style="cursor:pointer" class="badge badge-danger" border="2">Remove</span></div>'
                    +'<div style="clear:both"></div>'
                    +'<div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}" style="width:31%; float:left; margin-right:25px">'
                    +'    <label class="form-control-label" for="input-category">{{ __('Category') }}</label>'
                    +'    <select name="unit['+rowId+'][category]"  class="form-control select'+rowId+'" required>'
                    +'        <option value="">Select Category</option>'
                    +'        @foreach (getCategories() as $cat)'
                    +'            <option value="{{$cat->id}}">{{$cat->name}}</option>'
                    +'        @endforeach'
                    +'    </select>'

                    +'    @if ($errors->has('category'))'
                    +'        <span class="invalid-feedback" role="alert">'
                    +'            <strong>{{ $errors->first('category') }}</strong>'
                    +'        </span>'
                    +'    @endif'
                    +'</div>'
                    +'<div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}" style="width:31%; float:left; margin-right:25px">'
                    +'    <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>'
                    +'    <input type="number" name="unit['+rowId+'][quantity]" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="Enter Quantity" value="{{old('quantity')}}" required>' 
                    +'    @if ($errors->has('quantity'))'
                    +'        <span class="invalid-feedback" role="alert">'
                    +'            <strong>{{ $errors->first('quantity') }}</strong>'
                    +'        </span>'
                    +'    @endif'
                    +'</div>         '          
                    +'<div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }}" style="width:31%; float:left">'
                    +'    <label class="form-control-label" for="input-standard_price">{{ __('Standard Price') }}</label>'
                    +'    <input type="number" name="unit['+rowId+'][standard_price]" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="Enter Standard Price" value="{{old('standard_price')}}" required>'

                    +'    @if ($errors->has('standard_price'))'
                    +'        <span class="invalid-feedback" role="alert">'
                    +'            <strong>{{ $errors->first('standard_price') }}</strong>'
                    +'        </span>'
                    +'    @endif'
                    +'</div>'
                    +'<div style="clear:both"></div>'
                +'</div>'
            );
            row++;
            $(".select"+rowId).select2({
                    theme: "bootstrap"
                });
        });

        $('#container').on('click', '.remove_project_file', function(e) {
            e.preventDefault();
            $(this).parent().remove();
            row--;
        });
    </script>
@endsection