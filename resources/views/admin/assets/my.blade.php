@extends('layouts.app', ['title' => 'My Assets'])

@section('content')
@include('admin.rental.partials.header', ['title' => __('Assets')])  

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('My Assets') }}</h3>
                            </div>
                            <div class="col-md-3">
                                <form method="GET" action="{{ route('asset.my') }}" accept-charset="UTF-8" id="users-form">
                                    <div class="input-group custom-search-form" style="float:right">
                                        <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="Search for assets...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit" id="search-users-btn">
                                                <span class="fas fa-search"></span>
                                            </button>
                                            @if (Input::has('search') && Input::get('search') != '')
                                                <a href="{{ route('asset.my') }}" class="btn btn-danger" type="button" >
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
                                    <th><b>Category</b></th>
                                    <th><b>Location</b></th>
                                    <th><b>Quantity</b></th>
                                    <th><b>Rent</b></th>
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
                                            <td>{{ $asset->name }}</td>
                                            <td>{{ $asset->address }}</td>
                                            <td>{{ $asset->quantity_added }}</td>
                                            <td>&#8358; {{ number_format($asset->price,2) }}</td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a href="{{ route('asset.edit', ['uuid'=>$asset->uuid]) }}" class="dropdown-item">Edit</a>
                                                        <form action="{{ route('asset.delete', ['uuid'=>$asset->uuid]) }}" method="get">
                                                            
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this asset?") }}') ? this.parentElement.submit() : ''">
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form> 
                                                    </div>
                                                </div>
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
    </script>
@endsection