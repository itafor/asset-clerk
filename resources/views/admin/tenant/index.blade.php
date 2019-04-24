@extends('layouts.app', ['title' => 'List Tenants'])

@section('content')
@include('admin.rental.partials.header', ['title' => __('Tenants')])  

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('List of Tenants') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('tenant.create') }}" class="btn btn-sm btn-primary">{{ __('Add Tenant') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th><b>Designation</b></th>
                                    <th><b>First Name</b></th>
                                    <th><b>Last Name</b></th>
                                    <th><b>Occupation</b></th>
                                    <th><b>Phone</b></th>
                                    <th class="text-center"><b>Action</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tenants as $tenant)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$tenant->designation}}</td>
                                        <td>{{$tenant->firstname}}</td>
                                        <td>{{$tenant->lastname}}</td>
                                        <td>{{$tenant->occupation}}</td>
                                        <td>{{$tenant->phone}}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a href="{{ route('tenant.edit', ['uuid'=>$tenant->uuid]) }}" class="dropdown-item">Edit</a>
                                                    <form action="{{ route('tenant.delete', ['uuid'=>$tenant->uuid]) }}" method="get">
                                                        
                                                        <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this tenant?") }}') ? this.parentElement.submit() : ''">
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