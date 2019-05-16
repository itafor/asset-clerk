@extends('new.layouts.app', ['title' => 'Add New Rental', 'page' => 'rental'])

@section('content')
    <!-- Page Header -->
    <div class="dt-page__header">
        <h1 class="dt-page__title"><i class="icon icon-company"></i> Plans Management</h1>
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
                    <h3 class="dt-entry__title">Add New Plan</h3>
                </div>
                <!-- /entry heading -->

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form method="post" action="{{ route('plan.save') }}" autocomplete="off">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">{{ __('Add Plan') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-4">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('Name of Plan') }}</label>
                                    <input type="text" name="name"
                                           class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="Name" value="{{old('name')}}" required>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }} col-4">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('Price') }}</label>
                                    <input type="number" name="amount"
                                           class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                           placeholder="Name" value="{{old('amount')}}" required>
                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} col-4">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}"></textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-4">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('Number of Properties') }}</label>
                                    <input type="number" name="properties"
                                           class="form-control form-control-alternative{{ $errors->has('properties') ? ' is-invalid' : '' }}"
                                           placeholder="Properties" value="{{old('properties')}}" required>
                                    @if ($errors->has('properties'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('properties') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('sub_accounts') ? ' has-danger' : '' }} col-4">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('No of Sub-Accounts') }}</label>
                                    <input type="text" name="sub_accounts"
                                           class="form-control form-control-alternative{{ $errors->has('sub_accounts') ? ' is-invalid' : '' }}"
                                           placeholder="Name" value="{{old('sub_accounts')}}" required>
                                    @if ($errors->has('sub_accounts'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('sub_accounts') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('service_charge') ? ' has-danger' : '' }} col-4">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('Allow Service Charge?') }}</label>
                                    <select name="service_charge" id="service_charge" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    @if ($errors->has('service_charge'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('service_charge') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save Plan Data') }}</button>
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
        $('#category').change(function () {
            var category = $(this).val();
            if (category) {
                $('#asset_description').empty();
                $('<option>').val('').text('Loading...').appendTo('#asset_description');
                $.ajax({
                    url: baseUrl + '/fetch-assets/' + category,
                    type: "GET",
                    dataType: 'json',
                    success: function (data) {
                        $('#asset_description').empty();
                        $('<option>').val('').text('Select Asset').appendTo('#asset_description');
                        $.each(data, function (k, v) {
                            $('<option>').val(v.uuid).text(v.description).attr('data-price', v.price).appendTo('#asset_description');
                        });
                    }
                });
            }
            else {
                $('#asset_description').empty();
                $('<option>').val('').text('Select Asset').appendTo('#asset_description');
            }
        });

        $('#property').change(function () {
            var property = $(this).val();
            if (property) {
                $('#unit').empty();
                $('<option>').val('').text('Loading...').appendTo('#unit');
                $.ajax({
                    url: baseUrl + '/fetch-units/' + property,
                    type: "GET",
                    dataType: 'json',
                    success: function (data) {
                        $('#unit').empty();
                        $('<option>').val('').text('Select Unit').appendTo('#unit');
                        $.each(data, function (k, v) {
                            $('<option>').val(v.uuid).text(v.name + ' | Qty Left: ' + v.quantity_left).attr('data-price', v.standard_price).appendTo('#unit');
                        });
                    }
                });
            }
            else {
                $('#unit').empty();
                $('<option>').val('').text('Select Unit').appendTo('#unit');
            }
        });

        $('#unit').change(function () {
            var unit = $(this).val();
            if (unit) {
                var price = $(this).find(':selected').attr('data-price')
                $('#price').val(price);
            }
            else {
                $('#price').val('');
            }
        });

        $('#asset_description').change(function () {
            var value = $(this).val();
            if (value) {

                var price = $(this).find(':selected').data('price')

                $('#input-standard_price').val(price)
            }
        })
    </script>
@endsection