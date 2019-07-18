<div class="modal fade" id="serviceModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="forms" action="{{route('asset.service.add')}}" method="POST">
                    @csrf
                    <input type="hidden" name="asset" id="asset">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Service Charge</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:left">
                        @csrf
                        <div class="row">
                            <div class="form-group col-4">
                                <label class="form-control-label" for="input-category">{{ __('Type') }}</label>
                                <div>
                                    <select name="service[112211][type]" class="form-control sc_type" data-row="112211" style="width:100%" required>
                                    <option value="">Select Type</option>
                                    <option value="fixed">Fixed</option>
                                    <option value="variable">Variable</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label class="form-control-label" for="input-quantity">{{ __('Service Charge') }}</label>
                                <div>
                                    <select name="service[112211][service_charge]" id="serviceCharge112211" style="width:100%" class="form-control" required>
                                    <option value="">Select Service Charge</option>
                                </select>
                                </div>
                            </div>                   
                            <div class="form-group col-4">
                                <label class="form-control-label" for="input-price">{{ __('Price') }}</label>
                                <input type="number" name="service[112211][price]" id="input-price" class="form-control" placeholder="Enter Price" required>
                            </div>
                        </div>
                            <div style="clear:both"></div>
                            <div id="containerSC">
                            </div>   
                            <div class="form-group">
                                <button type="button" id="addMoreSC" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
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