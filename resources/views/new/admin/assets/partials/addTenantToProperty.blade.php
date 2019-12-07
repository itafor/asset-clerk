<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add tenant to a property</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                          <form method="post" action="{{ route('tenant.to.asset.store') }}" autocomplete="off">
                            @csrf
                                <input type="hidden" name="new_rental_status" value="">
                                <input type="hidden" name="previous_rental_id" value="">
                            <div class="pl-lg-6">
                               <!--  <div class="row"> -->
                                    <div class="form-group{{ $errors->has('property') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-property">{{ __('Property') }}</label>
                                        <select name="property" id="input-property" class="form-control" required autofocus style="width: 300px;">
                                            <option value="">Select Property</option>
                                            @foreach (getAssets() as $asset)
                                                <option value="{{$asset->uuid}}">{{$asset->description}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('property'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('property') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-unit">{{ __('Unit') }}</label>
                                        <select name="unit" id="input-unit" class="form-control" required style="width: 300px;">
                                            <option value="">Select Unit</option>
                                        </select>
                                        
                                        @if ($errors->has('unit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('unit') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-price">{{ __('Property Estimate') }}</label>
                                        <input type="text" name="price" id="input-price" class="form-control" value="{{old('price')}}" readonly="true" placeholder="Enter Price" required style="width: 300px;">
                                        
                                        @if ($errors->has('price'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('price') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 
                                     <div class="form-group{{ $errors->has('tenant') ? ' has-danger' : '' }} col-4">
                                        <label class="form-control-label" for="input-tenant">{{ __('Tenant') }}</label>
                                        <select name="tenant" id="" class="form-control" required autofocus style="width: 300px;">
                                            <option value="">Select Tenant</option>
                                            @foreach (getTenants() as $tenant)
                                                <option value="{{$tenant->uuid}}">{{$tenant->name()}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('tenant'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tenant') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                <div class="col-4">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div> 

                        </div>
                              </form>
      </div>
      
    </div>
  </div>
</div>
