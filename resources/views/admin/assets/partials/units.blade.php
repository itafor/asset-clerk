<div class="modal fade" id="unit{{$i}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Available Units</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:left">
                <table class="table table-responsive">
                    <thead>
                        <th>S/N</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Standard Price</th>
                    </thead>
                    <tbody>
                        @foreach ($asset->units as $unit)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$unit->category->name}}</td>
                                <td>{{$unit->quantity}}</td>
                                <td>&#8358; {{number_format($unit->standard_price, 2)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>