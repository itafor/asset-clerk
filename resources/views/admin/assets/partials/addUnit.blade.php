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
                            <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }} col-4">
                                <label class="form-control-label" for="input-category">{{ __('Category') }}</label>
                                <div>
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
                            <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }} col-4">
                                <label class="form-control-label" for="input-quantity">{{ __('Quantity') }}</label>
                                <input type="number" name="unit[112211][quantity]" id="input-quantity" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="Enter Quantity" value="{{old('quantity')}}" required>
                                
                                @if ($errors->has('quantity'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>                   
                            <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-4">
                                <label class="form-control-label" for="input-standard_price">{{ __('Standard Price') }}</label>
                                <input type="number" name="unit[112211][standard_price]" id="input-standard_price" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="Enter Standard Price" value="{{old('standard_price')}}" required>

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
                                <button type="button" id="addMore" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
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