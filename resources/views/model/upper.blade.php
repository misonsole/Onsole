<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Item Codes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input hidden type="text" id="counter">
                <input hidden type="text" id="name21">
                <table id="datatable2" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($itemcode as $num)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$num['ITEM_CODE']}}</td>
                            <td>{{$num['ITEM_DESC']}}</td>
                            <td>{{$num['UOM_DESC']}}</td>
                            <td><button class="btn btnSelect py-0 text-white" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;">Select</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter2121" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Article Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input hidden type="text" id="counter">
                <input hidden type="text" id="name21">
                <table id="row_callback" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th hidden class="text-center">No</th>
                            <th class="text-center">Article Code</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                    @for($i=0; $i<$z; $i++)
                        <tr>
                            <td hidden class="text-center">{{$i}}</td>
                            <td class="text-center">{{$articlecode[$i]}}</td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="text-center"><button class="btn btnSelectuser1 py-0 text-white w-50" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;">Select</button></td>
                        </tr>
                     @endfor
                    </tbody>
                </table> 
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>