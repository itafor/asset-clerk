<div class="modal fade" id="unitModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="formys" action="{{route('asset.unit.add')}}" method="POST">
                @csrf
                <input type="hidden" name="asset" id="assetU" value="{{$asset->id}}">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Unit(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:left">
                    @csrf
                <div class="row">
     <div class="form-group{{ $errors->has('number_of_flat') ? ' has-danger' : '' }} col-3">
                                    <label class="form-control-label" for="input-property_type">{{ __('Property Type') }}</label>
                                    <select name="unit[12345678][property_type]" id="property_type_id" class="form-control" required>
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

                                 <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }} col-3">
                                    <label class="form-control-label" for="input-quantity">{{ __('Units') }}</label>
                                    <input type="number" name="unit[12345678][quantity]" min="1" class="form-control" placeholder="Enter number of unit" required>

                                    @if ($errors->has('quantity'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>

     
                                <div class="form-group{{ $errors->has('number_of_room') ? ' has-danger' : '' }} col-3">
                                    <label class="form-control-label" for="input-property_type">{{ __('Rooms') }}</label>
                                    <input type="number" name="unit[12345678][number_of_room]" min="1" class="form-control" placeholder="Enter number of room" required>

                                    @if ($errors->has('number_of_room'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('number_of_room') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                
                           
                             
                                <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-3">
                                    <label class="form-control-label" for="input-standard_price">{{ __('Asking Price') }}</label>
                                    <input type="number" min="1" name="unit[12345678][standard_price]" id="input-standard_price" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }} standard_price" placeholder="Enter Property Estimate" value="{{old('standard_price')}}" required>

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


@section('script')
    <script>
     
        function identifier(){
            return Math.floor(Math.random() * (99999999 - 10000000 + 1)) + 10000000;
        }

        var row = 1;

        $('#addMore').click(function(e) {
            e.preventDefault();

            if(row >= 5){
                alert("You've reached the maximum limit");
                return;
            }

            var rowId = identifier();

            $("#container").append(
                '<div>'
                    +'<div style="float:right" class="remove_project_file"><span style="cursor:pointer" class="badge badge-danger" border="2">Remove</span></div>'
                    +'<div style="clear:both"></div>'
                       +'<div class="row" id="rowNumber'+rowId+'" data-row="'+rowId+'">'


                         +'<div class="form-group{{ $errors->has('property_type') ? ' has-danger' : '' }} col-3">'
                        +'    <label class="form-control-label" for="input-flatname">{{ __('Property Type') }}</label>'

                         + '<select name="unit['+rowId+'][property_type]" id="property_type_id"  class="form-control" required>'
                        +'<option value="">Select Property Type</option>'
                                +' @foreach(getPropertyTypes() as $pt)'
                            +'<option value="{{$pt->id}}">{{$pt->name}}</option>'
                                        +'@endforeach'
                                    +'</select>'
                       

                        +'    @if ($errors->has('property_type'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('property_type') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'

                        +'<div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }} col-3">'
                        +'    <label class="form-control-label" for="input-quantity">{{ __('Units') }}</label>'
                        +'    <input type="number" name="unit['+rowId+'][quantity]" min="1" placeholder="Enter number of unit"  class="form-control select'+rowId+'" required>'
                       

                        +'    @if ($errors->has('quantity'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('quantity') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'
                        

                    
                        +'<div class="form-group{{ $errors->has('number_of_room') ? ' has-danger' : '' }} col-3">'
                        +'    <label class="form-control-label" for="input-number_of_room">{{ __('Rooms') }}</label>'
                        +'    <input type="number" name="unit['+rowId+'][number_of_room]" min="1" placeholder="Enter number of rooms"  class="form-control select'+rowId+'" required>'
                       

                        +'    @if ($errors->has('number_of_room'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('number_of_room') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'

                               
                        +'<div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-3">'
                        +'    <label class="form-control-label" for="input-standard_price">{{ __('Asking Price') }}</label>'
                +'    <input type="number" min="1" name="unit['+rowId+'][standard_price]" class="standard_price form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }} standard_price" placeholder="Enter unit price" value="{{old('standard_price')}}" required>'

                        +'    @if ($errors->has('standard_price'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('standard_price') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'
                        
                        +'<div style="clear:both"></div>'
                    +'</div>'
                +'</div>'
            );            row++;
            $(".select"+rowId).select2({
                    theme: "bootstrap"
                });
        });

        // Remove parent of 'remove' link when link is clicked.
        $('#container').on('click', '.remove_project_file', function(e) {
            e.preventDefault();
            $(this).parent().remove();
            row--;
        });
    </script>
@endsection