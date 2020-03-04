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
     
                                <div class="form-group{{ $errors->has('unitname') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label" for="input-property_type">{{ __('Name') }}</label>
                                    <input name="unit[112211][unitname]"  class="form-control" placeholder="Enter Flat Name" required>

                                    @if ($errors->has('unitname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('unitname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                           
                             
                                <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label" for="input-standard_price">{{ __('Asking Price') }}</label>
                                    <input type="number" min="1" name="unit[112211][standard_price]" id="input-standard_price" class="form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }} standard_price" placeholder="Enter Property Estimate" value="{{old('standard_price')}}" required>

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
                        

                    
                        +'<div class="form-group{{ $errors->has('flatname') ? ' has-danger' : '' }} col-6">'
                        +'    <label class="form-control-label" for="input-flatname">{{ __('Flat name') }}</label>'
                        +'    <input name="unit['+rowId+'][unitname]" placeholder="Enter flat name"  class="form-control select'+rowId+'" required>'
                       

                        +'    @if ($errors->has('flatname'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('flatname') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'
                               
                        +'<div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }} col-6">'
                        +'    <label class="form-control-label" for="input-standard_price">{{ __('Asking Price') }}</label>'
                +'    <input type="number" min="1" name="unit['+rowId+'][standard_price]" class="standard_price form-control {{ $errors->has('standard_price') ? ' is-invalid' : '' }} standard_price" placeholder="Enter flat price" value="{{old('standard_price')}}" required>'

                        +'    @if ($errors->has('standard_price'))'
                        +'        <span class="invalid-feedback" role="alert">'
                        +'            <strong>{{ $errors->first('standard_price') }}</strong>'
                        +'        </span>'
                        +'    @endif'
                        +'</div>'
                        
                        +'<div style="clear:both"></div>'
                    +'</div>'
                +'</div>'
            );
            row++;
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