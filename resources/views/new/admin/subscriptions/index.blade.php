@extends('new.layouts.app', ['title' => 'Subscriptions History', 'page' => 'my_account'])

@section('content')
    <!-- Page Header -->
        <div class="dt-page__header">
          <h1 class="dt-page__title"><i class="icon icon-user-o"></i> Package Subscriptions History</h1>
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
                <h3 class="dt-entry__title">Subscriptions History</h3>
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

                  <table class="table table-striped table-bordered table-hover datatable" id="table-1">
                    <thead>
                      <tr>
                          <th scope="col">{{ __('S/N') }}</th>
                          <th scope="col">{{ __('Plan') }}</th>
                          <th scope="col">{{ __('Total Slot') }}</th>
                          <th scope="col">{{ __('Slot Used') }}</th>
                          <th scope="col">{{ __('Availble Slot') }}</th>
                          <th scope="col">{{ __('Price') }}</th>
                          <th scope="col">{{ __('Name') }}</th>
                          <th scope="col">{{ __('Phone') }}</th>
                          <th scope="col">{{ __('Email') }}</th>
                          <th scope="col">{{ __('Status') }}</th>
                          <th scope="col">{{ __('Date Subscribed') }}</th>
                          <th scope="col">{{ __('Expiry Date') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach ($subs as $user)
                      <tr>
                          @php $p = getSubscriptionByUUid($user->plan_id); @endphp
                          <td>{{ $i++ }}</td>
                          <td>{{ $p->name }}</td>
                          <td>{{ $p->properties }}</td>
                          <td>{{number_format(getTotalAssets($user->user->id))}}</td>
                          @if (getSlots($user->user->id)['availableSlots'] == 'Unlimited')
                       <td>{{getSlots($user->user->id)['availableSlots']}}</td>
                    @else
                        <td>{{number_format(getSlots($user->user->id)['availableSlots'])}}</td>
                    @endif
                          <td>&#8358;{{ number_format($p->amount, 2) }}</td>
                          <td>{{ $user->user->firstname }} {{ $user->user->lastname }} </td>
                          <td>{{ $user->user->phone }}</td>
                          <td>{{ $user->user->email }}</td>
                          <td>{{ $user->substatus }}</td>
                          <td>{{ \Carbon\Carbon::parse($user->start)->format('d M, Y') }}</td>
                          <td>{{ \Carbon\Carbon::parse($user->end)->format('d M, Y') }}</td>
                      </tr>
                  @endforeach
                    </tbody>
                  </table>
                  <table id="header-fixed"></table>
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
