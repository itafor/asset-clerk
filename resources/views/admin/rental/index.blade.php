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