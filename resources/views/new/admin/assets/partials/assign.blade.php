<div class="modal fade" id="assignModal{{$i}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="form{{$i}}" action="{{route('asset.assign')}}" method="POST">
                    @csrf
                    <input type="hidden" name="asset" value="{{$asset->id}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Asset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:left">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <div>
                                <select required style="width:100%; padding:5px" name="user" class="user" class="form-control"></select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" onclick="event.preventDefault();
                    document.getElementById('form{{$i}}').submit();" class="btn btn-primary">Assign</button>
                </div>
                </form>
            </div>
        </div>
    </div>