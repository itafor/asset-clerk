@extends('layouts.app', ['title' => 'List Maintenances'])

@section('content')
@include('admin.rental.partials.header', ['title' => __('Maintenances')])  

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('List of Maintenances') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('maintenance.create') }}" class="btn btn-sm btn-primary">{{ __('Add Maintenance') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th><b>Customer Name</b></th>
                                    <th><b>Category</b></th>
                                    <th><b>Section</b></th>
                                    <th><b>Fault Description</b></th>
                                    <th><b>Date Reported</b></th>
                                    <th><b>Status</b></th>
                                    <th class="text-center"><b>Action</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($maintenances as $m)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$m->tenant->name()}}</td>
                                        <td>{{$m->categoryy->name}}</td>
                                        <td>{{$m->buildingSection->name}}</td>
                                        <td>{{$m->description}}</td>
                                        <td>{{ formatDate($m->reported_date, 'Y-m-d', 'd/m/Y') }}</td>
                                        <td>{{$m->status}}</td>
                                        <td class="text-center">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a href="{{ route('maintenance.edit', ['uuid'=>$m->uuid]) }}" class="dropdown-item">Edit</a>
                                                        <form action="{{ route('maintenance.delete', ['uuid'=>$m->uuid]) }}" method="get">
                                                            
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this maintenance?") }}') ? this.parentElement.submit() : ''">
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