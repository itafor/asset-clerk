@extends('new.layouts.app', ['title' => 'Transactions History', 'page' => 'my_account'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
{{--
          <h1 class="dt-page__title"><i class="icon icon-user-o"></i> Package Subscriptions History</h1>
--}}
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
                <h3 class="dt-entry__title">Transactions History</h3>
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
                          <th scope="col">{{ __('S/N') }}</th>
                          <th scope="col">{{ __('Plan') }}</th>
                          <th scope="col">{{ __('Amount') }}</th>
                          <th scope="col">{{ __('Status') }}</th>
                          <th scope="col">{{ __('Channel') }}</th>
                          <th scope="col">{{ __('Date') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach ($subs as $user)
                      <tr>
                          @php $p = getSubscriptionByUUid($user->plan_id); @endphp
                          <td>{{ $i++ }}</td>
                          <td>{{ $p->name }}</td>
                          <td>{{ number_format($p->amount, 2) }}</td>
                          <td>{{ $user->status }}</td>
                          <td>{{ $user->channel }}</td>
                          <td>{{ $user->created_at }}</td>
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