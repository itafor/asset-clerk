<div class="modal fade" id="unitModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formys" action="{{route('asset.unit.add')}}" method="POST">
                @csrf
                <input type="hidden" name="asset" id="assetU">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Unit(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:left">
                    @csrf
                    <div class="row">
                            <div class="form-group{{ $errors->has('property_type') ? ' has-danger' : '' }} col-3">
                                <label class="form-control-label" for="input-property_type">{{ __('Property Type') }}</label>
                                <select name="unit[112211][property_type]"  class="form-control" required>
                                    <option value="">Select Property Type</option>
                                    @foreach (getPropertyTypes() as $pt)
                                        <option value="{{$pt->id}}">{{$pt->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('property_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('property_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }} col-3">
                                <label class="form-control-label" for="input-category">{{ __('Rooms') }}</label>
                                <div>

                                   <!--  <input type="number" min="1" name="unit[112211][category]"   placeholder="Enter Number of Rooms" class="form-control rooms" required> -->

                                    <select name="unit[112211][category]"  class="form-control" required style="width:100%">
                                    <option value="">Select Category</option>
                                    @foreach (getCategories() as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>

                                </div>
                                @if ($errors->has('category'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }} col-3">
                                <label class="form-control-label" for="input-quantity">{{ __('Unit (Unique Tenant)') }}</label>
                                <input type="number" min="1" name="unit[112211][quantity]" id="input-quantity" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }} quantity" placeholder="Enter number of units" value="{{old('quantity')}}" required>
                                
                                @if ($errors->has('quantity'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>                   
                            <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-3">
                                <label class="form-control-label" for="input-standard_price">{{ __('Standard Price') }}</label>
                                <input type="number" min="1" name="unit[112211][standard_price]" id="input-standard_price" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }} standard_price" placeholder="Enter Standard Price" value="{{old('standard_price')}}" required>

                                @if ($errors->has('standard_price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('standard_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                    </div>
                            <div style="clear:both"></div>
                            <div id="container">
                            </div>   
                            <div class="form-group">
                                <button type="button" id="addMore" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                            </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>