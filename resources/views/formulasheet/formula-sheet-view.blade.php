@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .borderTop{
        border-top: 1px solid #919191 !important;
        border-bottom: 1px solid #919191 !important;
    }
    .dropify-wrapper 
    {
        height: 130px;
        margin-bottom: 2%;
    }
    .autocomplete{
        position: relative;
        display: inline-block;
    }
    #myInput{
        width: 100%;
        border: 1px solid #bfbfbf;
    }
    .autocomplete-items{
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 5;
        right: 5;
        width: 92%;
        border-radius: 5px;
        overflow-y: scroll;
        height: 330%;
    }
    .autocomplete-items div{
        padding: 10px;
        cursor: pointer;
        background-color: #fff; 
        border-bottom: 1px solid #d4d4d4; 
    }
    .autocomplete-items div:hover{
        background-color: #e9e9e9; 
    }
    .autocomplete-active{
        background-color: DodgerBlue !important; 
        color: #ffffff; 
    }
    .dtp > .dtp-content{
        background: #fff;
        max-width: 300px;
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
        max-height: 100%;
        position: relative;
        left: 50%;
    }
    .dtp .p10 > a{
        color: #fdfdfd;
        text-decoration: none;
    }
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    .displayBadgess{
        text-align :center;
    }
    #loader1 {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('pricing-sheet-table')}}">Pricing Sheet</a></li>
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Formula Sheet</li>
                    </ol>
                </div>
                <h4 class="page-title">Formula Sheet</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-12 mb-5">
            <div class="card">
                <div class="card-body p-5">
                    <div class="form-group row py-0">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="bg-dark rounded">
                                        <tr>
                                            <th class="text-center text-white">Dept. <br> Daily Salary</th>
                                            <th class="text-center text-white">Direct <br> Labor OH</th>
                                            <th class="text-center text-white">Indirect <br> Lab OH</th>
                                            <th class="text-center text-white">Indirect <br> Lab OH</th>
                                            <th class="text-center text-white">Total <br> OH</th>
                                            <th class="text-center text-white">Capacity</th>
                                            <th class="text-center text-white">Direct <br> Lab OH</th>
                                            <th class="text-center text-white">In-Direct <br> Lab OH</th>
                                            <th class="text-center text-white">Direct <br> Lab OH</th>
                                            <th class="text-center text-white">Total <br> OH</th>
                                            <th class="text-center text-white">Un-Absorbed <br> OH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                    <label class="mb-0 text-white" style="font-weight: 600;">Cutting</label>
                                                </div>
                                            </td>                                
                                        </tr>
                                        @if(!$cuttingData)
                                        <tr class="no-data text-center" style="border-top: none;">
                                            <td colspan="12" style="border-top: none;">No Data</td>
                                        </tr>
                                        @else
                                        @foreach($cuttingData as $data)
                                        <tr>
                                            <td class="text-center borderTop">{{$data->pds}}</td>
                                            <td class="text-center borderTop">{{$data->dloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh2}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                            <td class="text-center borderTop">{{$data->capacity}}</td>
                                            <td class="text-center borderTop">{{$data->dloh2}}</td>
                                            <td class="text-center borderTop">{{$data->idloh3}}</td>
                                            <td class="text-center borderTop">{{$data->dloh3}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                            <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                    <label class="mb-0 text-white" style="font-weight: 600;">INSOLE</label>
                                                </div>
                                            </td>
                                        </tr>
                                        @if(!$StitchingData)
                                        <tr class="no-data text-center" style="border-top: none;">
                                            <td colspan="12" style="border-top: none;">No Data</td>
                                        </tr>
                                        @else
                                        @foreach($StitchingData as $data)
                                        <tr>
                                            <td class="text-center borderTop">{{$data->pds}}</td>
                                            <td class="text-center borderTop">{{$data->dloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh2}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                            <td class="text-center borderTop">{{$data->capacity}}</td>
                                            <td class="text-center borderTop">{{$data->dloh2}}</td>
                                            <td class="text-center borderTop">{{$data->idloh3}}</td>
                                            <td class="text-center borderTop">{{$data->dloh3}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                            <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                    <label class="mb-0 text-white" style="font-weight: 600;">Lamination</label>
                                                </div>
                                            </td>
                                        </tr>
                                        @if(!$LastingData)
                                        <tr class="no-data text-center" style="border-top: none;">
                                            <td colspan="12" style="border-top: none;">No Data</td>
                                        </tr>
                                        @else
                                        @foreach($LastingData as $data)
                                        <tr>
                                            <td class="text-center borderTop">{{$data->pds}}</td>
                                            <td class="text-center borderTop">{{$data->dloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh2}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                            <td class="text-center borderTop">{{$data->capacity}}</td>
                                            <td class="text-center borderTop">{{$data->dloh2}}</td>
                                            <td class="text-center borderTop">{{$data->idloh3}}</td>
                                            <td class="text-center borderTop">{{$data->dloh3}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                            <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                    <label class="mb-0 text-white" style="font-weight: 600;">Closing</label>
                                                </div>
                                            </td>
                                        </tr>
                                        @if(!$ClosingData)
                                        <tr class="no-data text-center" style="border-top: none;">
                                            <td colspan="12" style="border-top: none;">No Data</td>
                                        </tr>
                                        @else
                                        @foreach($ClosingData as $data)
                                        <tr>
                                            <td class="text-center borderTop">{{$data->pds}}</td>
                                            <td class="text-center borderTop">{{$data->dloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh2}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                            <td class="text-center borderTop">{{$data->capacity}}</td>
                                            <td class="text-center borderTop">{{$data->dloh2}}</td>
                                            <td class="text-center borderTop">{{$data->idloh3}}</td>
                                            <td class="text-center borderTop">{{$data->dloh3}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                            <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                    <label class="mb-0 text-white" style="font-weight: 600;">Lasting</label>
                                                </div>
                                            </td>
                                        </tr>
                                        @if(!$LaminationData)
                                        <tr class="no-data text-center" style="border-top: none;">
                                            <td colspan="12" style="border-top: none;">No Data</td>
                                        </tr>
                                        @else
                                        @foreach($LaminationData as $data)
                                        <tr>
                                            <td class="text-center borderTop">{{$data->pds}}</td>
                                            <td class="text-center borderTop">{{$data->dloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh2}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                            <td class="text-center borderTop">{{$data->capacity}}</td>
                                            <td class="text-center borderTop">{{$data->dloh2}}</td>
                                            <td class="text-center borderTop">{{$data->idloh3}}</td>
                                            <td class="text-center borderTop">{{$data->dloh3}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                            <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                    <label class="mb-0 text-white" style="font-weight: 600;">Packing</label>
                                                </div>
                                            </td>
                                        </tr>
                                        @if(!$PackingData)
                                        <tr class="no-data text-center" style="border-top: none;">
                                            <td colspan="12" style="border-top: none;">No Data</td>
                                        </tr>
                                        @else
                                        @foreach($PackingData as $data)
                                        <tr>
                                            <td class="text-center borderTop">{{$data->pds}}</td>
                                            <td class="text-center borderTop">{{$data->dloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh1}}</td>
                                            <td class="text-center borderTop">{{$data->idloh2}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                            <td class="text-center borderTop">{{$data->capacity}}</td>
                                            <td class="text-center borderTop">{{$data->dloh2}}</td>
                                            <td class="text-center borderTop">{{$data->idloh3}}</td>
                                            <td class="text-center borderTop">{{$data->dloh3}}</td>
                                            <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                            <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr style="background: #cdd3db;" class="rounded">
                                            <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">Total</th>
                                            <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['dloh1_total'], 2, '.', '')}}</th>
                                            <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['idloh1_total'], 2, '.', '')}}</th>
                                            <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['idloh2_total'], 2, '.', '')}}</th>
                                            <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['t_oh1_total'], 2, '.', '')}}</th>
                                            <th class="text-center py-1" style="color: #586c85; border-top: 2px solid transparent;"></th>
                                            <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['dloh2_total'], 2, '.', '')}}</th>
                                            <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['idloh3_total'], 2, '.', '')}}</th>
                                            <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['dloh3_total'], 2, '.', '')}}</th>
                                            <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['t_oh2_total'], 2, '.', '')}}</th>
                                            <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['un_a_oh_total'], 2, '.', '')}}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row py-0 mt-5">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="bg-dark rounded">
                                        <tr>
                                            <th class="text-center text-white" style="border: 1px solid #1c2d41;">RMC</th>
                                            <th class="text-center text-white" style="border: 1px solid #1c2d41;">Total OH</th>
                                            <th class="text-center text-white" style="border: 1px solid #1c2d41;">Un-Absorbed OH</th>
                                            <th class="text-center text-white" style="border: 1px solid #1c2d41;">Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="color: #5e5e5e; border: 1px solid #919191;" class="text-center"><b>100</b></td>
                                            <td style="color: #5e5e5e; border: 1px solid #919191;" class="text-center"><b>{{number_format((float)$AllData['t_oh1_total'], 2, '.', '')}}</b></td>
                                            <td style="color: #5e5e5e; border: 1px solid #919191;" class="text-center"><b>{{number_format((float)$AllData['un_a_oh_total'], 2, '.', '')}}</b></td>
                                            <?php $result = 100 + $AllData['t_oh1_total'] + $AllData['un_a_oh_total']?> 
                                            <td style="color: #5e5e5e; border: 1px solid #919191;" class="text-center"><b>{{number_format((float)$result, 2, '.', '')}}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
});
</script>
<script>
    $(document).on('click', '.removeRow1', function(){
        var id = $(this).attr("id"); 
        $('#insolerow1'+id+'').remove();
    });
    $(document).on('click', '.removeRow2', function(){
        var id = $(this).attr("id"); 
        $('#insolerow2'+id+'').remove();
    });
    $(document).on('click', '.removeRow3', function(){
        var id = $(this).attr("id"); 
        $('#insolerow3'+id+'').remove();
    });
    $(document).on('click', '.removeRow4', function(){
        var id = $(this).attr("id"); 
        $('#insolerow4'+id+'').remove();
    });
    $(document).on('click', '.removeRow5', function(){
        var id = $(this).attr("id"); 
        $('#insolerow5'+id+'').remove();
    });
    $(document).on('click', '.removeRow6', function(){
        var id = $(this).attr("id"); 
        $('#insolerow6'+id+'').remove();
    });
    $(document).on('click', '.removeRow7', function(){
        var id = $(this).attr("id"); 
        console.log("removeRow7");
        console.log(id);
        console.log("removeRow7");
        $('#insolerow7'+id+'').remove();
    });
</script>
<script>
$(document).ready(function(){
    $(".readonly").prop('readonly',true);
	$(".btnSelect").on('click',function(){
        var count = $("#counter").val();
        var name = $("#name21").val();
		var currentRow = $(this).closest("tr");
		var col2 = currentRow.find("td:eq(1)").html();
        $("#exampleModalCenter").modal('hide');
        if(name == "cutting"){
            $("#cut_item_code"+count).val(col2);
            $("#cut_item_code"+count).prop('readonly', true);
            code = document.getElementById('cut_item_code'+count).value;
        }
        else if(name == "insole"){
            $("#i_item_code"+count).val(col2);
            $("#i_item_code"+count).prop('readonly', true);
            code = document.getElementById('i_item_code'+count).value;
        }
        else if(name == "lamination"){
            $("#lam_item_code"+count).val(col2);
            $("#lam_item_code"+count).prop('readonly', true);
            code = document.getElementById('lam_item_code'+count).value;
        }
        else if(name == "closing"){
            $("#clo_item_code"+count).val(col2);
            $("#clo_item_code"+count).prop('readonly', true);
            code = document.getElementById('clo_item_code'+count).value;
        }
        else if(name == "lasting"){
            $("#last_item_code"+count).val(col2);
            $("#last_item_code"+count).prop('readonly', true);
            code = document.getElementById('last_item_code'+count).value;
        }
        else if(name == "packing"){
            $("#p_item_code"+count).val(col2);
            $("#p_item_code"+count).prop('readonly', true);
            code = document.getElementById('p_item_code'+count).value;
        }
        console.log("Ajax");
        console.log(code);
        $.ajax({
            type: 'GET',
            url: 'itemcode/'+code,
            dataType: "json",
            success: function(data){
                console.log(data);
                console.log(name);
                if(name == "cutting"){
                    $("#cut_description"+count).val(data.desc);
                    $("#cut_uom"+count).val(data.uom);
                    $("#cut_description"+count).prop('readonly', true);
                    $("#cut_uom"+count).prop('readonly', true);
                }
                else if(name == "insole"){
                    $("#i_description"+count).val(data.desc);
                    $("#i_uom"+count).val(data.uom);
                    $("#i_description"+count).prop('readonly', true);
                    $("#i_uom"+count).prop('readonly', true);
                }
                else if(name == "lamination"){
                    $("#lam_description"+count).val(data.desc);
                    $("#lam_uom"+count).val(data.uom);
                    $("#lam_description"+count).prop('readonly', true);
                    $("#lam_uom"+count).prop('readonly', true);
                }                
                else if(name == "closing"){
                    $("#clo_description"+count).val(data.desc);
                    $("#clo_uom"+count).val(data.uom);
                    $("#clo_description"+count).prop('readonly', true);
                    $("#clo_uom"+count).prop('readonly', true);
                }                
                else if(name == "lasting"){
                    $("#last_description"+count).val(data.desc);
                    $("#last_uom"+count).val(data.uom);
                    $("#last_description"+count).prop('readonly', true);
                    $("#last_uom"+count).prop('readonly', true);
                }                
                else if(name == "packing"){
                    $("#p_description"+count).val(data.desc);
                    $("#p_uom"+count).val(data.uom);
                    $("#p_description"+count).prop('readonly', true);
                    $("#p_uom"+count).prop('readonly', true);
                }
            }
        });
	});
    $(".btnSelectArticle").on('click',function(){
        var currentRow = $(this).closest("tr");
		var col2 = currentRow.find("td:eq(1)").html();
        $("#article").val(col2);
        $("#exampleModalCenter21").modal('hide');
    });
});
</script>
<script src="assets/js/costingsheet.js"></script>
<script>
    $(".ModelBtn").click(function(){
        var id = $(this).attr("data-id");
        $("#counter").val(id);
    });
</script>
<script>
    function myFunction1(value,name12){
        console.log("Function");
        if(value == 1){
            $("#counter").val(value);
            $("#name21").val(name12);
        }
        else{
            $("#counter").val(value);
            $("#name21").val(name12.id);
        }
    } 
</script>
<script>
@if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            Swal.fire({
            icon: 'info',
            title: "Error!",
            text: "{{ session('message') }}",
        });
        break;
        case 'warning':
            Swal.fire({
            icon: 'warning',
            text: "{{ session('message') }}",
        });
        break;
        case 'success':
            Swal.fire({
            icon: 'success',
            title: "{{ session('message') }}",
            showConfirmButton: false,
			timer: 2000
        });
        break;
        case 'error':
            Swal.fire({
            icon: 'error',
            title: "{{ session('message') }}",
        });
        break;
    }
@endif
</script>
<script>
function autocomplete(inp, arr){
    var currentFocus;
    inp.addEventListener("input", function(e){
        var a, b, i, val = this.value;
        closeAllLists();
        if(!val){
            return false;
        }
        currentFocus = -1;
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        this.parentNode.appendChild(a);
        for(i=0; i<arr.length; i++){
            if(arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()){
                b = document.createElement("DIV");
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                b.addEventListener("click", function(e) {
                    inp.value = this.getElementsByTagName("input")[0].value;
                    closeAllLists();
                });
            a.appendChild(b);
            }
        }
    });
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if(x) x = x.getElementsByTagName("div");
        if(e.keyCode == 40){
            currentFocus++;
            addActive(x);
        }
        else if(e.keyCode == 38){ 
            currentFocus--;
            addActive(x);
        }  
        else if(e.keyCode == 13){
            e.preventDefault();
            if(currentFocus > -1){
                if(x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        if(!x) return false;
        removeActive(x);
        if(currentFocus >= x.length) currentFocus = 0;
        if(currentFocus < 0) currentFocus = (x.length - 1);
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x){
        for(var i=0; i<x.length; i++){
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for(var i=0; i<x.length; i++){
            if(elmnt != x[i] && elmnt != inp){
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}
</script>
<script>
    let username = document.getElementById('article')
    username.addEventListener("input", () => {
    Username(username.value);
    function Username(usernameVal){
        $.ajax({
                type: 'GET',
                url: 'ArticleCode/'+usernameVal,
                dataType: "json",
                success: function(data){
                    if(data){
                        autocomplete(document.getElementById("article"), data);
                    }
                }
            });
        }
    });
</script>
<script>
    $('#design').on('change', function(){
        var design = $(this).val();
        $("#description").val(design);
    });
    let strengthBadge2 = document.getElementById('StrengthDisp2')
    let strengthBadge3 = document.getElementById('StrengthDisp3')
    $("#selectsequence").on('click',function(){
        var first, seclast, istlast, range, rangefirst, project, projectfirst, category, categoryfirst, solefirst, shapefirst, seasonspace = 0;
        var season = $('#season').val();
        var range = $('#range').val();
        var category = $('#category').val();
        var sole = $('#sole').val();
        var shape = $('#shape').val();
        var project = $('#project').val();
        var sequence = $('#sequence').val();
        if(season!=null){
            first = season.charAt(0);
            seasonspace = season.split(' ').join('')
            seclast = season.charAt(season.length - 2);
            istlast = season.charAt(season.length - 1);
        }
        if(range!=null){
            rangefirst = range.charAt(0);
            rangefirst = rangefirst.toUpperCase();
        }
        if(category!=null){
            categoryfirst = category. slice(0, 3);
            categoryfirst = categoryfirst.toUpperCase();
        }
        if(shape!=null){
            shapefirst = shape. slice(0, 2);
            shapefirst = shapefirst.toUpperCase();
        }
        if(sole!=null){
            solefirst = sole. slice(0, 2);
            solefirst = solefirst.toUpperCase();
        }
        if(project!=null){
            projectfirst = project. slice(0, 3);
            projectfirst = projectfirst.toUpperCase();
        }
        if(season == null && range == null && category == null && shape == null && sole == null && project == null){
            strengthBadge3.style.display = 'block'
            strengthBadge3.style.backgroundColor = '#cd3f3f'
            strengthBadge3.textContent = 'Please Select Season, Range, Category, Shape, Sole, Project for Generate Design No'
            var timer;
            clearTimeout(timer);
            var self = $('#season');
            var range = $('#range');
            var category = $('#category');
            var sole = $('#sole');
            var shape = $('#shape');
            var project = $('#project');
            
            self.css('border-color', 'red');
            range.css('border-color', 'red');
            category.css('border-color', 'red');
            sole.css('border-color', 'red');
            shape.css('border-color', 'red');
            project.css('border-color', 'red');

            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
                range.css('border-color', '#bfbfbf');
                category.css('border-color', '#bfbfbf');
                sole.css('border-color', '#bfbfbf');
                shape.css('border-color', '#bfbfbf');
                project.css('border-color', '#bfbfbf');
            }, 4000);
        }
        else if(season == null){
            var timer;
            clearTimeout(timer);
            var self = $('#season');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Season'
        }
        else if(category == null){
            var timer;
            clearTimeout(timer);
            var self = $('#category');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Category'
        }
        else if(shape == null){
            var timer;
            clearTimeout(timer);
            var self = $('#shape');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Shape'
        }
        else if(sole == null){
            var timer;
            clearTimeout(timer);
            var self = $('#sole');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Category Sole'
        }
        else if(project == null){
            var timer;
            clearTimeout(timer);
            var self = $('#project');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Project'
        }
        else if(range == null){
            var timer;
            clearTimeout(timer);
            var self = $('#range');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Range'
        }
        else if(season && range && category && shape && sole && project){
            strengthBadge2.style.display = 'none'
            $("#design").val(first+seclast+istlast+"-"+rangefirst+"-"+projectfirst+"-"+categoryfirst+"-"+solefirst+"-"+shapefirst+"-"+sequence);
            $("#description").val(seasonspace+"-"+range+"-"+project+"-"+category+"-"+sole+"-"+shape+"-"+sequence);
        }
        $('#StrengthDisp2').delay(3000).fadeOut(600);
        $('#StrengthDisp3').delay(4000).fadeOut(600); 
    });
</script>
@endsection