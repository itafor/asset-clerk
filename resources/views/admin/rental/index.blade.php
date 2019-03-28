@extends('layouts.app', ['title' => 'List Rentals'])

@section('content')
    @include('layouts.headers.rental_cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Rentals') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('rental.create') }}" class="btn btn-sm btn-primary">{{ __('Add Rental') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th><b>Tenant Name</b></th>
                                    <th><b>Asset Category</b></th>
                                    <th><b>Description</b></th>
                                    <th><b>Location</b></th>
                                    <th><b>Rental Start Date</b></th>
                                    <th class="text-center"><b>Action</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rentals as $rental)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$rental->tenant->name()}}</td>
                                    <td>{{$rental->asset->category->name}}</td>
                                    <td>{{$rental->asset->description}}</td>
                                    <td></td>
                                    <td>{{formatDate($rental->rental_date, 'Y-m-d', 'd/m/Y')}}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
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