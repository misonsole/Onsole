<div class="modal fade bd-example-modal-lg" id="exampleModalCenter212" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Onsole Users</h5>
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
                            <th>Name</th>
                            <th>Employee Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($name as $names)
                        <tr>
                            <td>{{$i++}}</td>
                            <td style="text-transform: capitalize;">{{$names[0]['name']}}</td>
                            <td style="text-transform: capitalize;">{{$names[0]['code']}}</td>
                            <td><button class="btn btnSelectuser py-0 text-white" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;">Select</button></td>
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