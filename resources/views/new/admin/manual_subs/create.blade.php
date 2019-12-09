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
                    <h3 class="dt-entry__title">Buy plan</h3>
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
                                <label class="form-control-label" for="input-name">{{ __('User') }}</label>
                               <select name="user_name" id="input-user_name" class="form-control form-control-alternative{{ $errors->has('user_name') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('User') }}" required>
                                   <option value="">Select user</option>
                                    @foreach (getUsers() as $user)
        <option value="{{$user->id}}">{{$user->firstname}} {{$user->lastname}}</option>
                            @endforeach
                               </select>
                                @if ($errors->has('user_name'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('user_name') }}</strong>
                                        </span>
                                @endif
                            </div>

                               <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                <input type="email" name="email" id="input-email"
                                       class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Email') }}" readonly required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('Plan') }}</label>
                              
                        <select name="name" id="input-plan_name" class="form-control form-control-alternative{{ $errors->has('plan_name') ? ' is-invalid' : '' }}" required>
                                   <option value="">Select plan</option>
                                    @foreach (getAllPlans() as $plan)
        <option value="{{$plan->name}}">{{$plan->name}}</option>
                            @endforeach
                               </select>
                                @if ($errors->has('plan_name'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('plan_name') }}</strong>
                                        </span>
                                @endif
                            </div>
                         
                            <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Price') }}</label>
                              
                            <input type="text" name="amount" id="amount"
                                       class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                       placeholder="{{ __('Amount') }}"  readonly required>
                            <input type="hidden" name="plan_id" id="input-plan_id"
                                       class="form-control form-control-alternative{{ $errors->has('plan_id') ? ' is-invalid' : '' }}"
                                        required="">

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


        //select user email
      $('body').on('change', '#input-user_name', function(){
            var user_id = $(this).val();
//console.log(user_id)
            if(user_id){
                $('#input-email').empty();
                $('<option>').val('').text('Loading...').appendTo('#input-email');
                $.ajax({
                    url: baseUrl+'/manual_subscription/fetch-user-email/'+user_id,  
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log('user detail:',data)
                        $('#input-amount').empty();
                       if(data){
                        $('#input-email').val(data.email);
                       }
                    }
                });
            }else{
                 $('#input-email').val('');
            }
        });

       //select plan price and plan_id
      $('body').on('change', '#input-plan_name', function(){
            var plan_name = $(this).val();
            if(plan_name){
                $('#amount').empty();
                $('<option>').val('').text('Loading...').appendTo('#amount');
                $.ajax({
                    url: baseUrl+'/manual_subscription/fetch-plan-price-id/'+plan_name,  
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log('user detail:',data)
                        $('#amount').empty();
                       if(data){
                        $('#amount').val(data.amount);
                        $('#input-plan_id').val(data.uuid);
                        $('#input-planname').val(data.name);
                       }
                    }
                });
            }else{
                 $('#amount').val('');
                 $('#input-plan_id').val('');
                 $('#input-planname').val('');
            }
        });
    </script>
@endsection