@extends('layouts.app', ['title' => 'Payments Report'])

@section('content')
@include('admin.rental.partials.header', ['title' => __('Payments Report')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <a href="{{route('report.assets')}}" class="btn btn-secondary">Assets</a>
                                <a href="{{route('report.payments')}}" class="btn btn-primary">Payments</a>
                                <a href="{{route('report.approvals')}}" class="btn btn-secondary">Approvals</a>
                                <a href="{{route('report.maintenance')}}" class="btn btn-secondary">Maintenance</a>
                                <a href="{{route('report.legal')}}" class="btn btn-secondary">Legal</a>
                                <hr>
                                <h3 class="mb-0">{{ __('Payment Report') }}</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th><b>Customer Name</b></th>
                                    <th><b>Description</b></th>
                                    <th><b>Location</b></th>
                                    <th><b>Status</b></th>
                                    <th><b>Due Date</b></th>
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