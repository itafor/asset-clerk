@extends('layouts.app', ['title' => 'List Assets'])

@section('content')
@include('admin.rental.partials.header', ['title' => __('Assets')])  

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Assets') }}</h3>
                            </div>
                            <div class="col-md-3">
                                <form method="GET" action="{{ route('asset.index') }}" accept-charset="UTF-8" id="users-form">
                                    <div class="input-group custom-search-form" style="float:right">
                                        <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="Search for assets...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit" id="search-users-btn">
                                                <span class="fas fa-search"></span>
                                            </button>
                                            @if (Input::has('search') && Input::get('search') != '')
                                                <a href="{{ route('asset.index') }}" class="btn btn-danger" type="button" >
                                                    <span class="far fa-times-circle"></span>
                                                </a>
                                            @endif
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-1 text-right">
                                <a href="{{ route('asset.create') }}" class="btn btn-primary">{{ __('Add Asset') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th><b>Description</b></th>
                                    <th><b>Location</b></th>
                                    <th><b>Units</b></th>
                                    <th class="text-center"><b>Action</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($assetsCategories))

                                    @php
                                        $page = request()->has('page') ? request()->page : 1;
                                        $i = $page > 1 ? ((($page - 1) * 10) + 1) : 1;
                                    @endphp

                                    @foreach ($assetsCategories as $asset)
                                        <tr>
                                            <td>
                                            {{$i}} 
                                            </td>
                                            <td>{{ $asset->description }}</td>
                                            <td>{{ $asset->address }}</td>
                                            <td>
                                                <a href="#x" data-toggle="modal" data-target="#unit{{$i}}" class="text-underline">{{ $asset->units->count() }}</a>
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
                                                
                                            </td>
                                        </tr>
                                    <?php $i++ ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6"><em>No record(s) found</em></td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                        
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {!! $assetsCategories->appends(['search'=> $term])->render() !!}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.assets.partials.service')
        @include('admin.assets.partials.addUnit')
            
        @include('layouts.footers.auth')
    </div>
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
                    +'<div style="float:left" class="remove_project_file"><a href="#x" class=" btn btn-danger btn-sm"  border="2">Remove</a></div>'
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
                    +'<div style="float:left" class="remove_project_file"><a href="#" class=" btn btn-danger btn-sm"  border="2">Remove</a></div>'
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