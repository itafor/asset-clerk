@extends('new.layouts.app', ['title' => 'List of Sub Accounts', 'page' => 'my_account'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-user-o"></i> Sub Accounts</h1>
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
                <h3 class="dt-entry__title">List of Sub Accounts</h3>
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
                          <th scope="col">{{ __('Name') }}</th>
                          <th scope="col">{{ __('Email') }}</th>
                          <th scope="col">{{ __('Asset') }}</th>
                          <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                      <tr>
                          <td>{{ $user->firstname.' '.$user->lastname }}</td>
                          <td>
                              <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                          </td>
                          <td>{{$user->description}}</td>
                          <td class="text-right">
                              <div class="dropdown">
                                  <a class="btn btn-sm btn-success" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Action
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                      <form action="{{ route('subs.destroy', $user) }}" method="post">
                                          @csrf
                                          @method('delete')
                                      
                                          <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this account?") }}') ? this.parentElement.submit() : ''">
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