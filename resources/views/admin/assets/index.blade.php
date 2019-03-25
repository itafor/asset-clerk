@extends('layouts.app', ['title' => 'List Assets'])

@section('content')
    @include('layouts.headers.asset_cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Assets') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('asset.create') }}" class="btn btn-sm btn-primary">{{ __('Add Asset') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
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
                                @foreach ($assetsCategories as $asset)
                                    <tr>
                                        <td>
                                           {{$loop->iteration}} 
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
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection