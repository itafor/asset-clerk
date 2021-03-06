<div class="modal fade" id="photoModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formys" action="{{route('asset.add.photos')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="asset" id="assetU" value="{{$asset->id}}">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Photo(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:left">
                    @csrf
                <div class="form-group col-12 row">
     
                                <div class="form-group{{ $errors->has('unitname') ? ' has-danger' : '' }} col-12">
                                    <label class="form-control-label" for="input-property_type">{{ __('Photo') }}</label>
                                    <input type="file" name="photos[112211][image_url]"  class="form-control" required>

                                    @if ($errors->has('unitname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('unitname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                                  <div style="clear:both"></div>
                                <div id="photoContainer">
                                </div>   
                                <div class="form-group">
                                    <button type="button" id="addMorePhoto" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
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

