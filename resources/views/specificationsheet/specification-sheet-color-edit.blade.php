@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .dropify-wrapper{
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
    <div class="row px-1">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Pricing Sheet</li>
                    </ol>
                </div>
                <h4 class="page-title">Specification Sheet Edit (Colors)</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-12 mb-5">
            <div class="card">
                <div class="card-body p-5">
                    <form id="myForm">
                    @csrf
                        <div class="form-group row mb-1">
                            <div class="col-sm-12 col-md-12 py-0">
                                <div class="form-group row py-2 px-3 mb-1 mt-1">
                                    <div class="col-sm-10 col-md-10 py-0">
                                        <div class="form-group row py-1 mb-0">                                            
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Design No</b></label>
                                                <p style="font-family: 'Poppins', sans-serif; text-transform: capitalize;">{{$data1['design_no']}}</p>                                      
                                            </div>
                                            <div class="col-sm-6 col-md-6 py-1">
                                                <label><b style="color: #6c757d">Design Description</b></label>
                                                <p style="font-family: 'Poppins', sans-serif; text-transform: capitalize;">{{$data1['description']}}</p>                                      
                                            </div>                                            
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <input type="text" name="id" id="idd" value="{{$id}}" hidden>
                                                <label><b style="color: #6c757d">Season</b></label>      
                                                <p style="font-family: 'Poppins', sans-serif;">{{$data1['season']}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Profit</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{number_format($data1['profit'],2)}} PKR</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Price</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{number_format($data1['price'],2)}} PKR</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Profit Margin</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$data1['profit_price']}} %</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Sole</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$data1['sole']}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Date</b></label>      
                                                <p style="font-family: 'Poppins', sans-serif;">{{$data1['date']}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Shape</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$data1['shape']}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Sale Order No</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$data1['sono']}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Category</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$data1['category']}}</p>                                      
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-3">                                       
                                        @if(isset($data1['image']) && !empty($data1['image'])) 
                                            <br><img src="{{ asset('uploads/appsetting/' . $data1['image']) }}" alt="profile-user" height="100" class="rounded">
                                        @else
                                            <br><img src="{{asset('img/photos/10.jpg')}}" alt="profile-user" height="100" class="rounded">
                                        @endif                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row px-0 mb-0">
                            <div class="col-sm-12 col-md-12 py-0">
                                <div class="form-group row py-2 px-3 mb-1">
                                    <div class="col-sm-10 col-md-10 py-0">
                                        <div class="form-group row mb-0"> 
                                            <div class="col-sm-3 col-md-3 text-center py-1">                        
                                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                                    <label class="mb-0 text-white" style="font-weight: 500;">Color Division</label>
                                                </div>  
                                            </div>
                                            <div class="col-sm-1 col-md-1 text-center">
                                                <button id="cutting" type="button" class="btn btn-outline-primary btn-round px-4 w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="cuttingrow">
                            <div class="form-group px-0 row mb-1">
                                <div class="col-sm-12 col-md-12 py-0">
                                    <div class="form-group row py-0 px-3 mb-1">
                                        <div class="col-sm-10 col-md-10 py-0">
                                        @if(!$data)
                                            <div class="form-group row mb-0"> 
                                                <div class="col-sm-3 col-md-3 py-1">
                                                    <select id="colors" name="colors[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select division" data-id="cutting">
                                                        @foreach($color as $names)
                                                            <option style="text-transform: capitalize" value="{{$names}}">{{$names}}</option>
                                                        @endforeach     
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 py-1 text-center">
                                                    <button id="cutting" type="button" class="btn btn-outline-primary btn-round px-4 w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                                </div>
                                            </div>
                                        @else
                                        @foreach($data as $value)
                                            <div id="cutting{{$a1++}}" class="form-group row mb-0"> 
                                                <div class="col-sm-3 col-md-3 py-1">
                                                    <input hidden value="{{$value['id']}}" type="text" style="border: 1px solid #bfbfbf;" name="color_id[]" class="form-control py-2" placeholder="Code" required>                                        
                                                    <select id="colorSelect{{$a3++}}" name="colors[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select division" data-id="cutting">
                                                        @foreach($color as $names)
                                                            <option <?php if($value['color'] == $names) echo "selected"; ?> style="text-transform: capitalize" value="{{$names}}">{{$names}}</option>
                                                        @endforeach     
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 py-1 text-center">
                                                    <button id="{{$a2++}}" data-id="{{$value['id']}}" name="{{$value['costing_id']}}" type="button" class="btn btn-outline-danger btn-round px-4 w-100 cutting_remove1" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div name="cutting">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row mt-5">
                            <div class="col-sm-3 mb-1 mb-sm-0">
                            </div>
                            <div class="col-sm-6">
                                <a id="Check" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer;" class="btn px-5 py-1 btn-lg btn-block text-white">Update</a>
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
                    </form>
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
    var costing_id = $('#idd').val();
    $("#Check").on('click',function(){
        if(colorValueArr.length > 0){
            $.ajax({
                type: "POST",
                url: "removeColors",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "data" : JSON.stringify(colorValueArr),
                    "id" : costing_id,
                }
            });
        }
        $("#myForm").attr("method", "post");
        $("#myForm").attr("enctype", "multipart/form-data");
        $("#myForm").attr("action", "duplicatePSSEdit");
        document.getElementById("myForm").submit();
    }); 
});
</script>
<script>
    var i = 1;
    $('#cutting').click(function(){
        var typee = "cutting";
        i++;
        $('#cuttingrow').append('<div id="cuttingrow'+i+'" name="cutting" class="form-group row mb-1">'+      
                                    '<div class="col-sm-12 col-md-12 py-0">'+
                                        '<div class="form-group row py-0 px-3 mb-1">'+
                                            '<div class="col-sm-10 col-md-10 py-0">'+
                                                '<div class="form-group row mb-0"> '+                         
                                                    '<div class="col-sm-3 py-1">'+
                                                        '<select id="colors" name="colors[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionsValue'+i+'" data-id="cutting1">'+                                    
                                                        '</select>'+
                                                    '</div>'+
                                                    '<div class="col-sm-1 py-1 text-center">'+
                                                        '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 cutting_remove w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
        $.ajax({
            type: 'GET',
            url: 'GetColor',
            dataType: "json",
            success: function(data){
                if(data){
                    for(z=0; z<data.length; z++){
                        if(data[z].includes(' ') === true){
                            var val = data[z].split(/[ ,]+/).join('-');
                        }
                        else{
                            var val = data[z];
                        }
                        var $dataToBeAppended1 = `<option value=`+val+`>`+data[z]+`</option>`;
                        $(".divisionsValue"+i).append($dataToBeAppended1);
                    }
                }
            }
        });
    });

    $(document).on('click', '.cutting_remove', function(){
        var id = $(this).attr("id"); 
        $('#cuttingrow'+id+'').remove();
    });

    const colorValueArr = [];
    $(document).on('click', '.cutting_remove1', function(){
        var id = $(this).attr("id");
        var colorValue = $('#colorSelect'+id).find(":selected").val();     
        var dataId = $(this).attr("data-id");
        var costingId = $(this).attr("name");
        colorValueArr.push(colorValue);
        $('#cutting'+id+'').remove();
    });
</script>
<script>
    $(".ModelBtn").click(function(){
        var id = $(this).attr("data-id");
        $("#counter").val(id);
    });
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
@endsection