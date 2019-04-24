@extends('layouts.app', ['title' => 'List of Service Charges'])

@section('content')
@include('admin.rental.partials.header', ['title' => __('Service Charges')])  

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Service Charges') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                {{-- <a href="{{ route('landlord.create') }}" class="btn btn-sm btn-primary">{{ __('Add Landlord') }}</a> --}}
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive" style="padding:15px">
                        <table class="table align-items-center table-flush datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th><b>Asset</b></th>
                                    <th><b>Service Charge</b></th>
                                    <th>Type</th>
                                    <th><b>Amount</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($charges as $charge)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$charge->asset->description}}</td>
                                    <td>{{$charge->serviceCharge->name}}</td>
                                    <td>{{ucwords($charge->serviceCharge->type)}}</td>
                                    <td>&#8358; {{number_format($charge->price,2)}}</td>
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