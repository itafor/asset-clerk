@extends('layouts.app', ['title' => __('Add Maintenance')])

@section('content')
    @include('admin.rental.partials.header', ['title' => __('Add Maintenance')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Maintenance Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('tenant.maintenance') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('maintenance.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Maintenance') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('building_section') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-building_section">{{ __('Building Section') }}</label>
                                    <select name="building_section" id="building_section" class="form-control" required>
                                        <option value="">Select Building Section</option>
                                        @foreach (getBuildingSections() as $b)
                                            <option value="{{$b->id}}">{{$b->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('building_section'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('building_section') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('reported_date') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-reported_date">{{ __('Reported Date') }}</label>
                                    <input type="text" name="reported_date" id="input-reported_date" class="datepicker form-control form-control-alternative{{ $errors->has('reported_date') ? ' is-invalid' : '' }}" placeholder="Choose Date" value="{{old('reported_date')}}" required>
                                    
                                    @if ($errors->has('reported_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('reported_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>         

                                <div class="form-group{{ $errors->has('fault_description') ? ' has-danger' : '' }}" style="width:47%; float:left">
                                    <label class="form-control-label" for="input-fault_description">{{ __('Fault Description') }}</label>
                                    <textarea rows="5" name="fault_description" id="input-fault_description" class="form-control form-control-alternative{{ $errors->has('fault_description') ? ' is-invalid' : '' }}" placeholder="Enter Fault Description" required>{{old('fault_description')}}</textarea>

                                    @if ($errors->has('fault_description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fault_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}" style="width:50%; float:right">
                                    <label class="form-control-label" for="input-date">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option>Fixed</option>
                                        <option>Unfixed</option>
                                    </select>
                                    
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div style="clear:both"></div>    
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>                     
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
    
@endsection 

@section('script')
    <script>

        
    </script>
@endsection