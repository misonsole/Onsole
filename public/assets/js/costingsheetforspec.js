$(document).ready(function(){
    var i = 1;
    //Cutting
    $('.cutting').click(function(){
        var Dataid = $(this).attr("data-id"); 
        var typee = "cutting";
        i++;
        $('#cuttingrow'+Dataid).append(
                            '<div id="cuttingrow'+i+'" name="cutting" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span class="w-100">'+
                                        '<input readonly id="cut_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="cut_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description'+i+'" name="cut_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_uom'+i+'" name="cut_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="cut_division" name="cut_division[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionsValue'+i+'" onchange="getval('+i+','+typee+',this.value);" data-id="cutting1">'+                                    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1" id="divisioncutting1div'+i+'">'+
                                    '<select id="cut_subdivision" name="cut_subdivision[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisioncutting1'+i+'" required>'+                                    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_output" name="cut_output[]" placeholder="Output">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_cut_code" name="cut_cut_code[]" placeholder="Code">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_fac" name="cut_fac[]" placeholder="Factor">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_qty" name="cut_qty[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input step="0.1" min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_process" name="cut_process[]" placeholder="%">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_total_con" name="cut_total_con[]" placeholder="Total">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 cutting_remove w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');

        $.ajax({
            type: 'GET',
            url: 'GetDivision',
            dataType: "json",
            success: function(data){
                if(data){
                    for(z=0; z<data.length; z++){
                        var $dataToBeAppended1 = `<option value=`+data[z].id+`>`+data[z].description+`</option>`;
                        $(".divisionsValue"+i).append($dataToBeAppended1);
                    }
                }
            }
        });
    });

    $(document).on('click', '.cutting_remove', function(){
        var id = $(this).attr("id");
        console.log("Remove Cutting 1");
        console.log(id); 
        $('#cuttingrow'+id+'').remove();
    });

    //Insole
    $('.insole').click(function(){
        var typee = "insole";
        var Dataid = $(this).attr("data-id"); 
        i++;
        $('#insolerow'+Dataid).append(
                            '<div id="insolerow'+i+'" name="insole" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span class="w-100">'+
                                        '<input readonly id="i_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="i_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description'+i+'" name="i_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_uom'+i+'" name="i_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="i_division" name="i_division[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionsValue'+i+'" onchange="getval('+i+','+typee+',this.value);" data-id="insole1">'+ 
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1" id="divisioninsole1div'+i+'">'+
                                    '<select id="i_subdivision" name="i_subdivision[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisioninsole1'+i+'" required>'+                                    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_output" name="i_output[]" placeholder="Output">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_cut_code" name="i_cut_code[]" placeholder="Code">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_fac" name="i_fac[]" placeholder="Factor">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_qty" name="i_qty[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input step="0.1" min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_process" name="i_process[]" placeholder="%">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_total_con" name="i_total_con[]" placeholder="Total">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 insole_remove w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');

        $.ajax({
            type: 'GET',
            url: 'GetDivision',
            dataType: "json",
            success: function(data){
                if(data){
                    for(z=0; z<data.length; z++){
                        var $dataToBeAppended1 = `<option value=`+data[z].id+`>`+data[z].description+`</option>`;
                        $(".divisionsValue"+i).append($dataToBeAppended1);
                    }
                }
            }
        });
    });

    $(document).on('click', '.insole_remove', function(){
        var id = $(this).attr("id"); 
        $('#insolerow'+id+'').remove();
    });

    //Lamination
    $('.lamination').click(function(){
        var Dataid = $(this).attr("data-id"); 
        var typee = "lamination";
        i++;
        $('#laminationrow'+Dataid).append(
                            '<div id="laminationrow'+i+'" name="lamination" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span class="w-100">'+
                                        '<input readonly id="lam_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="lam_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_description'+i+'" name="lam_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_uom'+i+'" name="lam_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="lam_division" name="lam_division[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionsValue'+i+'" onchange="getval('+i+','+typee+',this.value);" data-id="lamination1">'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1" id="divisionlamination1div'+i+'">'+
                                    '<select id="lam_subdivision" name="lam_subdivision[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionlamination1'+i+'" required>'+                                    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_output" name="lam_output[]" placeholder="Output">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_cut_code" name="lam_cut_code[]" placeholder="Code">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_fac" name="lam_fac[]" placeholder="Factor">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_qty" name="lam_qty[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input step="0.1" min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_process" name="lam_process[]" placeholder="%">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_total_con" name="lam_total_con[]" placeholder="Total">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 lam_remove w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');

        $.ajax({
            type: 'GET',
            url: 'GetDivision',
            dataType: "json",
            success: function(data){
                if(data){
                    for(z=0; z<data.length; z++){
                        var $dataToBeAppended1 = `<option value=`+data[z].id+`>`+data[z].description+`</option>`;
                        $('.divisionsValue'+i+'').append($dataToBeAppended1);
                    }
                }
            }
        });
    });

    $(document).on('click', '.lam_remove', function(){
        var id = $(this).attr("id"); 
        $('#laminationrow'+id+'').remove();
    });

    //Closing
    $('.closing').click(function(){
        var Dataid = $(this).attr("data-id"); 
        var typee = "closing";
        i++;
        $('#closingrow'+Dataid).append(
                            '<div id="closingrow'+i+'" name="closing" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span class="w-100">'+
                                        '<input readonly id="clo_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="clo_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_description'+i+'" name="clo_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_uom'+i+'" name="clo_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="clo_division" name="clo_division[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionsValue'+i+'" onchange="getval('+i+','+typee+',this.value);" data-id="closing1">'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1" id="divisionclosing1div'+i+'">'+
                                    '<select id="clo_subdivision" name="clo_subdivision[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionclosing1'+i+'" required>'+                                    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_output" name="clo_output[]" placeholder="Output">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_cut_code" name="clo_cut_code[]" placeholder="Code">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_fac" name="clo_fac[]" placeholder="Factor">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_qty" name="clo_qty[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input step="0.1" min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_process" name="clo_process[]" placeholder="%">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_total_con" name="clo_total_con[]" placeholder="Total">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 clo_remove w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');

        $.ajax({
            type: 'GET',
            url: 'GetDivision',
            dataType: "json",
            success: function(data){
                if(data){
                    for(z=0; z<data.length; z++){
                        var $dataToBeAppended1 = `<option value=`+data[z].id+`>`+data[z].description+`</option>`;
                        $('.divisionsValue'+i+'').append($dataToBeAppended1);
                    }
                }
            }
        });
    });

    $(document).on('click', '.clo_remove', function(){
        var id = $(this).attr("id"); 
        $('#closingrow'+id+'').remove();
    });

    //Lasting
    $('.lasting').click(function(){
        var Dataid = $(this).attr("data-id"); 
        var typee = "lasting";
        i++;
        $('#lastingrow'+Dataid).append(
                            '<div id="lastingrow'+i+'" name="lasting" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span class="w-100">'+
                                        '<input readonly id="last_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="last_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_description'+i+'" name="last_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_uom'+i+'" name="last_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="last_division" name="last_division[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionsValue'+i+'" onchange="getval('+i+','+typee+',this.value);" data-id="lasting1">'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1" id="divisionlasting1div'+i+'">'+
                                    '<select id="last_subdivision" name="last_subdivision[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionlasting1'+i+'" required>'+                                    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_output" name="last_output[]" placeholder="Output">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_cut_code" name="last_cut_code[]" placeholder="Code">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_fac" name="last_fac[]" placeholder="Factor">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_qty" name="last_qty[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input step="0.1" min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_process" name="last_process[]" placeholder="%">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_total_con" name="last_total_con[]" placeholder="Total">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 last_remove w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');

        $.ajax({
            type: 'GET',
            url: 'GetDivision',
            dataType: "json",
            success: function(data){
                if(data){
                    for(z=0; z<data.length; z++){
                        var $dataToBeAppended1 = `<option value=`+data[z].id+`>`+data[z].description+`</option>`;
                        $('.divisionsValue'+i+'').append($dataToBeAppended1);
                    }
                }
            }
        });
    });

    $(document).on('click', '.last_remove', function(){
        var id = $(this).attr("id"); 
        $('#lastingrow'+id+'').remove();
    });

    //Packing
    $('.packing').click(function(){
        var Dataid = $(this).attr("data-id"); 
        var typee = "packing";
        i++;
        $('#packingrow'+Dataid).append(
                            '<div id="packingrow'+i+'" name="packing" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span class="w-100">'+
                                        '<input readonly id="p_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="p_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_description'+i+'" name="p_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_uom'+i+'" name="p_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="p_division" name="p_division[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionsValue'+i+'" onchange="getval('+i+','+typee+',this.value);" data-id="packing1">'+  
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1" id="divisionpacking1div'+i+'">'+
                                    '<select id="p_subdivision" name="p_subdivision[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionpacking1'+i+'" required>'+                                    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_output" name="p_output[]" placeholder="Output">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_cut_code" name="p_cut_code[]" placeholder="Code">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_fac" name="p_fac[]" placeholder="Factor">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_qty" name="p_qty[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input step="0.1" min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_process" name="p_process[]" placeholder="%">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1" hidden>'+
                                    '<input min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_total_con" name="p_total_con[]" placeholder="Total">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 p_remove w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');

        $.ajax({
            type: 'GET',
            url: 'GetDivision',
            dataType: "json",
            success: function(data){
                if(data){
                    for(z=0; z<data.length; z++){
                        var $dataToBeAppended1 = `<option value=`+data[z].id+`>`+data[z].description+`</option>`;
                        $('.divisionsValue'+i+'').append($dataToBeAppended1);
                    }
                }
            }
        });
    });

    $(document).on('click', '.p_remove', function(){
        var id = $(this).attr("id"); 
        $('#packingrow'+id+'').remove();
    });

    //Manual
    $('#manual').click(function(){
        i++;
        $('#manualrow').append(
                            '<div id="manualrow'+i+'" name="manual" class="form-group row mb-3">'+
                                '<div class="col-sm-5">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="manualtext" name="manualtext[]" placeholder="Manual">'+
                                '</div>'+
                                '<div class="col-sm-1">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 m_remove w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                                '<div class="col-sm-6">'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.m_remove', function(){
        var id = $(this).attr("id"); 
        $('#manualrow'+id+'').remove();
    });

    $("#cut_componentaz").on('change', function() {
        alert( this.value );
    });

    $('.division11111').on('change', function(){
        var value = $(this).val();
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'getSubDivision/'+value,
                dataType: "json",
                success: function(data){
                    if(data){
                        $("#division"+id+"1div").find('select').find('option').remove();
                        for(i=0; i<data.length; i++){
                            var $dataToBeAppended = `<option>`+data[i].description+`</option>`;
                            $(".division"+id+"1").append($dataToBeAppended);
                        }
                    }
                }
            });
    });
});