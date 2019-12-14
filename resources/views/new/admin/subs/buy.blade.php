@extends('new.layouts.app', ['title' => 'Buy a New Package', 'page' => 'my_account'])

@section('content')
    <!-- Page Header -->
    <div class="dt-page__header">
        <h1 class="dt-page__title"><i class="icon icon-user-o"></i> Subscription</h1>
    </div>
    <!-- /page header -->

    <!-- Grid -->
    <div class="row">

        <!-- Grid Item -->
        <div class="col-xl-6">

            <!-- Entry Header -->
            <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Buy {{ $plan->name }} Package online</h3>
                </div>
                <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('do.buy.plan') }}" autocomplete="off" id="purchase_form">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('Plan') }}</label>
                                <input type="text" name="name" id="input-firstname"
                                       class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       value="{{ $plan->name }}" required readonly>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                <input type="email" name="email" id="input-email"
                                       class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Email') }}" value="{{ \Illuminate\Support\Facades\Auth::user()->email }}" readonly>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Price') }}</label>
                                <input type="email" name="amount_not_real" id="amount_not_real"
                                       class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Amount') }}" value="{{ $plan->amount }}" readonly>
                            <input type="hidden" name="amount" id="amount"
                                       class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Amount') }}" value="{{ $plan_amount }}" readonly>
                            <input type="hidden" name="plan_id" id="input-email"
                                       class="form-control form-control-alternative{{ $errors->has('plan_id') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Amount') }}" value="{{ $plan->uuid }}" >

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('period') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Period') }}</label>
                                <select name="period" class="form-control" id="period" onchange="calculate_total()" required>
                                    <option value="">Select Period</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{$i}} Year(s)</option>
                                    @endfor
                                </select>

                                @if ($errors->has('period'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('period') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Total Amount Payable') }}</label>
                                <div class="form-control">
                                    <div class="total" id="total">0.00</div>
                                </div>
                            </div>
                            <div>
                                <img src="{{ url('img/paystack.png') }}" class="img-center offset-3" width="350px">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Buy this Package Now!') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->


        <!-- Direct payment -->
 <!-- Grid Item -->
        <div class="col-xl-6">

            <!-- Entry Header -->
            <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Buy {{ $plan->name }} Package (Bank transfer)</h3>
                </div>
                <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('buy.plan.by.bank.transfer') }}" autocomplete="off" id="purchase_form">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('Plan') }}</label>
                                <input type="text" name="name" id="input-firstname"
                                       class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       value="{{ $plan->name }}" required readonly>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                <input type="email" name="email" id="input-email"
                                       class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Email') }}" value="{{ \Illuminate\Support\Facades\Auth::user()->email }}" readonly>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Price') }}</label>
                                <input type="email" name="amount_not_real" id="amount_not_real"
                                       class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Amount') }}" value="{{ $plan->amount }}" readonly>
                            <input type="hidden" name="amount" id="amount"
                                       class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Amount') }}" value="{{ $plan_amount }}" readonly>
                            <input type="hidden" name="plan_id" id="input-email"
                                       class="form-control form-control-alternative{{ $errors->has('plan_id') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Amount') }}" value="{{ $plan->uuid }}" >

                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('period') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Period') }}</label>
                                <select name="period" class="form-control" id="period" onchange="calculate_total()" required>
                                    <option value="">Select Period</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{$i}} Year(s)</option>
                                    @endfor
                                </select>

                                @if ($errors->has('period'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('period') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">{{ __('Total Amount Payable') }}</label>
                                <div class="form-control">
                                    <div class="total" id="total">0.00</div>
                                </div>
                            </div>
                            <div style="height: 100px;">
                                <!-- <img src="{{ url('img/paystack.png') }}" class="img-center offset-3" width="350px"> -->
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Direct Bank Transfer!') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->
    </div>
    <!-- /grid -->
@endsection
@section('script')
    <script>
        function calculate_total() {
            var price = document.getElementById('amount').value;
            var period = document.getElementById('period').value;
            var tot = price * period;
            var total = numberWithCommas(tot);
            document.getElementById('total').innerHTML = total;
        }
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endsection