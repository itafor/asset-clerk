@extends('new.layouts.app', ['title' => 'Tenant\'s Wallets', 'page' => 'landlord'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-company"></i> Wallet Management</h1>
        </div>
        <!-- /page header -->

        <!-- Grid -->
        <div class="row">

          <!-- Grid Item -->
          <div class="col-xl-12">

            <!-- Entry Header -->
            <div class="dt-entry__header">

              <!-- Entry Heading -->
              <div class="dt-entry__heading">
                <h3 class="dt-entry__title">List of Tenant's Wallets</h3>
              </div>
               <div class="dt-entry__heading">
                 <a href="/wallet/wallet-history"> <button type="button" class="btn btn-primary btn-sm"> Wallet Histories  </button>
                 </a>
              </div>
              <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

              <!-- Card Body -->
              <div class="dt-card__body">

                <!-- Tables -->
                <div class="table-responsive">

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th><b>Tenant</b></th>
                          <th><b>Current Balance</b></th>
                          <th><b>Created At</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($tenantWallets as $wallet)
                      <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$wallet->tenantDetail}}</td>
                          <td>&#8358; {{number_format($wallet->amount,2)}}</td>
                          <td>{{ \Carbon\Carbon::parse($wallet->created_at)->format('d M Y')}}</td>
                         
                          <td class="text-center">
                              <div class="dropdown">
                                  <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Action
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                      <!-- <a href="{{ route('landlord.edit', ['id'=>$wallet->id]) }}" class="dropdown-item">Edit</a> -->
                                      <form action="{{ route('landlord.delete', ['id'=>$wallet->id]) }}" method="get">
                                          
                                          <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this landlord?") }}') ? this.parentElement.submit() : ''">
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
                <!-- /tables -->

              </div>
              <!-- /card body -->

            </div>
            <!-- /card -->

          </div>
          <!-- /grid item -->

        </div>
        <!-- /grid -->
@endsection