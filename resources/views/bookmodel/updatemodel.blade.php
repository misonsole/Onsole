<div class="modal fade bd-example-modal-xl" id="9" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel9"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username9">
                    <input hidden name="bookname" type="text" id="bookname9">
                    <p>Sale Order</p>
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($SalesOrder as $value)
                            @if(isset($SalesOrderVal))
                                @if(!$SalesOrderVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($SalesOrderVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="16" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel16"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username16">
                    <input hidden name="bookname" type="text" id="bookname16">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>             
                    <?php $count = count($PurchaseReturns); ?>
                    @foreach($PurchaseReturns as $val1)
                        @for($i=0; $i<$count; $i++)
                            @if($val1[0]['book'] == $PurchaseReturns[$i])
                                <option selected value="{{$val1[0]['book']}}">{{$val1[0]['book']}}</option>  
                            @else
                                <option value="{{$val1[0]['book']}}">{{$val1[0]['book']}}</option> 
                            @endif
                            $tmp = 2;
                        @endfor 
                    @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="7" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel7"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username7">
                    <input hidden name="bookname" type="text" id="bookname7">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($PurchaseInvoice as $value)
                            @if(isset($PurchaseInvoiceVal))
                                @if(!$PurchaseInvoiceVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($PurchaseInvoiceVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel3"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username3">
                    <input hidden name="bookname" type="text" id="bookname3">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($PurchaseOrder as $value)
                            @if(isset($PurchaseOrderVal))
                                @if(!$PurchaseOrderVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($PurchaseOrderVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="15" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel15"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username15">
                    <input hidden name="bookname" type="text" id="bookname15">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($SalesReturns as $value)
                            @if(isset($SalesReturnsVal))
                                @if(!$SalesReturnsVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($SalesReturnsVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel6"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username6">
                    <input hidden name="bookname" type="text" id="bookname6">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($SalesInvoice as $value)
                            @if(isset($SalesInvoiceVal))
                                @if(!$SalesInvoiceVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($SalesInvoiceVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel5"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username5">
                    <input hidden name="bookname" type="text" id="bookname5">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($StoreIssueNote as $value)
                            @if(isset($StoreIssueNoteVal))
                                @if(!$StoreIssueNoteVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($StoreIssueNoteVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="310" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel310"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username310">
                    <input hidden name="bookname" type="text" id="bookname310">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($StoreIssueNoteOnsole as $value)
                            @if(isset($StoreIssueNoteOnsoleVal))
                                @if(!$StoreIssueNoteOnsoleVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($StoreIssueNoteOnsoleVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="312" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel312"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username312">
                    <input hidden name="bookname" type="text" id="bookname312">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($StoreIssueNoteOutSource as $value)
                            @if(isset($StoreIssueNoteOutSourceVal))
                                @if(isset($StoreIssueNoteOutSourceVal))
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($StoreIssueNoteOutSourceVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="4" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel4"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username4">
                    <input hidden name="bookname" type="text" id="bookname4">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($GoodsReceiptNote as $value)
                            @if(isset($GoodsReceiptNoteVal))
                                @if(!$GoodsReceiptNoteVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($GoodsReceiptNoteVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="11" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel11"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username11">
                    <input hidden name="bookname" type="text" id="bookname11">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($IssueReturns as $value)
                            @if(isset($IssueReturnsVal))
                                @if(!$IssueReturnsVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($IssueReturnsVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="23" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel23"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username23">
                    <input hidden name="bookname" type="text" id="bookname23">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($ItemAdjustments as $value)
                            @if(isset($ItemAdjustmentsVal))
                                @if(!$ItemAdjustmentsVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>                             
                                @else
                                    @foreach($ItemAdjustmentsVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="57" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel57"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username57">
                    <input hidden name="bookname" type="text" id="bookname57">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($OtherPayment as $value)
                            @if(isset($OtherPaymentVal))
                                @if(!$OtherPaymentVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>                                
                                @else
                                    @foreach($OtherPaymentVal as $data)
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="58" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel58"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username58">
                    <input hidden name="bookname" type="text" id="bookname58">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($OtherReceipt as $value)
                            @if(isset($OtherReceiptVal))
                                @if(!$OtherReceiptVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($OtherReceiptVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="17" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel17"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books-update')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username17">
                    <input hidden name="bookname" type="text" id="bookname17">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($Payments as $value)
                            @if(isset($PaymentsVal))
                                @if(!$PaymentsVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($PaymentsVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="12" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel12"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username12">
                    <input hidden name="bookname" type="text" id="bookname12">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($RMAOutwards as $value)
                            @if(isset($RMAOutwardsVal))
                                @if(!$RMAOutwardsVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($RMAOutwardsVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="19" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel19"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username19">
                    <input hidden name="bookname" type="text" id="bookname19">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($RMAInwards as $value)
                            @if(isset($RMAInwardsVal))
                                @if(!$RMAInwardsVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($RMAInwardsVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="18" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel18"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username18">
                    <input hidden name="bookname" type="text" id="bookname18">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($Receipts as $value)
                            @if(isset($ReceiptsVal))
                                @if(!$ReceiptsVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($ReceiptsVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="21" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel21"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username21">
                    <input hidden name="bookname" type="text" id="bookname21">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required> 
                        @foreach($TransferIssues as $value)
                            @if(isset($TransferIssuesVal))
                                @if(!$TransferIssuesVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($TransferIssuesVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="22" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel22"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username22">
                    <input hidden name="bookname" type="text" id="bookname22">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($TransferReceipts as $value)
                            @if(isset($TransferReceiptsVal))
                                @if(!$TransferReceiptsVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($TransferReceiptsVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="311" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel311"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username311">
                    <input hidden name="bookname" type="text" id="bookname311">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($OutSourceJobCard as $value)
                            @if(isset($OutSourceJobCardVal))
                                @if(!$OutSourceJobCardVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($OutSourceJobCardVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="45" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="modellabel45"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('assign-books')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <input hidden name="username" type="text" id="username45">
                    <input hidden name="bookname" type="text" id="bookname45">
                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books" required>
                        @foreach($WorkInProcess as $value)
                            @if(isset($WorkInProcessVal))
                                @if(!$WorkInProcessVal)
                                    <option value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                @else
                                    @foreach($WorkInProcessVal as $data)                      
                                        <option <?php if($value[0]['book'] == $data) echo 'selected="selected"'; ?> value="{{$value[0]['book']}}">{{$value[0]['book']}}</option>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-4 text-center">
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" style="float: right; border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white mt-3">Update Books</button>  
                        </div>
                        <div class="col-4 text-center">
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>