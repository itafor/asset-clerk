<div class="modal fade" id="tenantServiceChargeModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
               


                <!-- Tables -->
                <div class="table-responsive">

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
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
                        @if(isset($tenantsDetails))
                    @foreach ($tenantsDetails as $tenant)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$tenant->designation}}</td>
                            <td>{{$tenant->firstname}}</td>
                            <td>{{$tenant->lastname}}</td>
                            <td>{{$tenant->occupation}}</td>
                            {{-- <td>{{$tenant->occupationName ? $tenant->occupationName->name : 'N/A'}}</td> --}}
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
                    @endif
                    </tbody>
                  </table>

                </div>
                <!-- /tables -->





            </div>
        </div>
    </div>