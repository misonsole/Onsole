<div class="modal fade bd-example-modal-lg" id="exampleModalCenter212" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Transfer No</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <table id="row_callback" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th hidden class="text-center">No</th>
                                            <th class="text-center">Transfer No</th>
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
                                            <td class="text-center">{{$transfer[$i]}}</td>
                                            <td hidden>Edinburgh</td>
                                            <td hidden></td>
                                            <td hidden></td>
                                            <td class="text-center"><button class="btn btnSelectuser py-0 text-white w-50" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;">Select</button></td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>        
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>