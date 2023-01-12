$(document).ready(function(){
    var i = 1;
    //Cutting
    $('#cutting').click(function(){
        var typee = "cutting";
        i++;
        $('#cuttingrow').append(
                            '<div id="cuttingrow'+i+'" name="cutting" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input id="cut_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="cut_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description'+i+'" name="cut_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_uom'+i+'" name="cut_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="cut_component" name="cut_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+
                                        '<option style="text-transform: capitalize" value="Back">Back</option>'+
                                        '<option style="text-transform: capitalize" value="Back Counter">Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Back Inner">Back Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Back Linning">Back Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Back Upper">Back Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle">Buckle</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle Covering">Buckle Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Collar">Collar</option>'+
                                        '<option style="text-transform: capitalize" value="Cording String">Cording String</option>'+
                                        '<option style="text-transform: capitalize" value="Elastic">Elastic</option>'+
                                        '<option style="text-transform: capitalize" value="Filler">Filler</option>'+
                                        '<option style="text-transform: capitalize" value="Folding Tape">Folding Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Front Inner">Front Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Front Upper">Front Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Heel">Heel</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Covering">Heel Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Grip">Heel Grip</option>'+
                                        '<option style="text-transform: capitalize" value="Inner">Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 1">Inner 1</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 2">Inner 2</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 3">Inner 3</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 4">Inner 4</option>'+
                                        '<option style="text-transform: capitalize" value="Inner Foam">Inner Foam</option>'+
                                        '<option style="text-transform: capitalize" value="Insocks">Insocks</option>'+
                                        '<option style="text-transform: capitalize" value="Insole">Insole</option>'+
                                        '<option style="text-transform: capitalize" value="Leg Pin">Leg Pin</option>'+
                                        '<option style="text-transform: capitalize" value="Linning">Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 1">Linning 1</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 2">Linning 2</option>'+
                                        '<option style="text-transform: capitalize" value="Linning Back Counter">Linning Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Loop">Loop</option>'+
                                        '<option style="text-transform: capitalize" value="Outsole">Outsole</option>'+
                                        '<option style="text-transform: capitalize" value="Plug">Plug</option>'+
                                        '<option style="text-transform: capitalize" value="Quarter">Quarter</option>'+
                                        '<option style="text-transform: capitalize" value="Randal">Randal</option>'+
                                        '<option style="text-transform: capitalize" value="Reinforcement Tape">Reinforcement Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Strap">Strap</option>'+
                                        '<option style="text-transform: capitalize" value="Strap Linning">Strap Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Stud">Stud</option>'+
                                        '<option style="text-transform: capitalize" value="Tie">Tie</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 1">Tie 1</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 2">Tie 2</option>'+
                                        '<option style="text-transform: capitalize" value="Toe">Toe</option>'+
                                        '<option style="text-transform: capitalize" value="Toe Covering">Toe Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Top Piece">Top Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Upper">Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 1">Upper 1</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 2">Upper 2</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 3">Upper 3</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp">Vamp</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp Piece">Vamp Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Velcro">Velcro</option>'+                                          
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_output" name="cut_output[]" placeholder="Output">'+
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
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 cutting_remove" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.cutting_remove', function(){
        var id = $(this).attr("id"); 
        $('#cuttingrow'+id+'').remove();
    });

    //Insole
    $('#insole').click(function(){
        var typee = "insole";
        i++;
        $('#insolerow').append(
                            '<div id="insolerow'+i+'" name="insole" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input id="i_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="i_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description'+i+'" name="i_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_uom'+i+'" name="i_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="i_component" name="i_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+
                                        '<option style="text-transform: capitalize" value="Back">Back</option>'+
                                        '<option style="text-transform: capitalize" value="Back Counter">Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Back Inner">Back Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Back Linning">Back Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Back Upper">Back Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle">Buckle</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle Covering">Buckle Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Collar">Collar</option>'+
                                        '<option style="text-transform: capitalize" value="Cording String">Cording String</option>'+
                                        '<option style="text-transform: capitalize" value="Elastic">Elastic</option>'+
                                        '<option style="text-transform: capitalize" value="Filler">Filler</option>'+
                                        '<option style="text-transform: capitalize" value="Folding Tape">Folding Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Front Inner">Front Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Front Upper">Front Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Heel">Heel</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Covering">Heel Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Grip">Heel Grip</option>'+
                                        '<option style="text-transform: capitalize" value="Inner">Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 1">Inner 1</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 2">Inner 2</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 3">Inner 3</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 4">Inner 4</option>'+
                                        '<option style="text-transform: capitalize" value="Inner Foam">Inner Foam</option>'+
                                        '<option style="text-transform: capitalize" value="Insocks">Insocks</option>'+
                                        '<option style="text-transform: capitalize" value="Insole">Insole</option>'+
                                        '<option style="text-transform: capitalize" value="Leg Pin">Leg Pin</option>'+
                                        '<option style="text-transform: capitalize" value="Linning">Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 1">Linning 1</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 2">Linning 2</option>'+
                                        '<option style="text-transform: capitalize" value="Linning Back Counter">Linning Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Loop">Loop</option>'+
                                        '<option style="text-transform: capitalize" value="Outsole">Outsole</option>'+
                                        '<option style="text-transform: capitalize" value="Plug">Plug</option>'+
                                        '<option style="text-transform: capitalize" value="Quarter">Quarter</option>'+
                                        '<option style="text-transform: capitalize" value="Randal">Randal</option>'+
                                        '<option style="text-transform: capitalize" value="Reinforcement Tape">Reinforcement Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Strap">Strap</option>'+
                                        '<option style="text-transform: capitalize" value="Strap Linning">Strap Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Stud">Stud</option>'+
                                        '<option style="text-transform: capitalize" value="Tie">Tie</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 1">Tie 1</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 2">Tie 2</option>'+
                                        '<option style="text-transform: capitalize" value="Toe">Toe</option>'+
                                        '<option style="text-transform: capitalize" value="Toe Covering">Toe Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Top Piece">Top Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Upper">Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 1">Upper 1</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 2">Upper 2</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 3">Upper 3</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp">Vamp</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp Piece">Vamp Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Velcro">Velcro</option>'+   
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_output" name="i_output[]" placeholder="Output">'+
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
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 insole_remove" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.insole_remove', function(){
        var id = $(this).attr("id"); 
        $('#insolerow'+id+'').remove();
    });

    //Lamination
    $('#lamination').click(function(){
        var typee = "lamination";
        i++;
        $('#laminationrow').append(
                            '<div id="laminationrow'+i+'" name="lamination" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input id="lam_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="lam_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_description'+i+'" name="lam_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_uom'+i+'" name="lam_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="lam_component" name="lam_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+
                                        '<option style="text-transform: capitalize" value="Back">Back</option>'+
                                        '<option style="text-transform: capitalize" value="Back Counter">Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Back Inner">Back Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Back Linning">Back Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Back Upper">Back Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle">Buckle</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle Covering">Buckle Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Collar">Collar</option>'+
                                        '<option style="text-transform: capitalize" value="Cording String">Cording String</option>'+
                                        '<option style="text-transform: capitalize" value="Elastic">Elastic</option>'+
                                        '<option style="text-transform: capitalize" value="Filler">Filler</option>'+
                                        '<option style="text-transform: capitalize" value="Folding Tape">Folding Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Front Inner">Front Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Front Upper">Front Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Heel">Heel</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Covering">Heel Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Grip">Heel Grip</option>'+
                                        '<option style="text-transform: capitalize" value="Inner">Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 1">Inner 1</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 2">Inner 2</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 3">Inner 3</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 4">Inner 4</option>'+
                                        '<option style="text-transform: capitalize" value="Inner Foam">Inner Foam</option>'+
                                        '<option style="text-transform: capitalize" value="Insocks">Insocks</option>'+
                                        '<option style="text-transform: capitalize" value="Insole">Insole</option>'+
                                        '<option style="text-transform: capitalize" value="Leg Pin">Leg Pin</option>'+
                                        '<option style="text-transform: capitalize" value="Linning">Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 1">Linning 1</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 2">Linning 2</option>'+
                                        '<option style="text-transform: capitalize" value="Linning Back Counter">Linning Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Loop">Loop</option>'+
                                        '<option style="text-transform: capitalize" value="Outsole">Outsole</option>'+
                                        '<option style="text-transform: capitalize" value="Plug">Plug</option>'+
                                        '<option style="text-transform: capitalize" value="Quarter">Quarter</option>'+
                                        '<option style="text-transform: capitalize" value="Randal">Randal</option>'+
                                        '<option style="text-transform: capitalize" value="Reinforcement Tape">Reinforcement Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Strap">Strap</option>'+
                                        '<option style="text-transform: capitalize" value="Strap Linning">Strap Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Stud">Stud</option>'+
                                        '<option style="text-transform: capitalize" value="Tie">Tie</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 1">Tie 1</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 2">Tie 2</option>'+
                                        '<option style="text-transform: capitalize" value="Toe">Toe</option>'+
                                        '<option style="text-transform: capitalize" value="Toe Covering">Toe Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Top Piece">Top Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Upper">Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 1">Upper 1</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 2">Upper 2</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 3">Upper 3</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp">Vamp</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp Piece">Vamp Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Velcro">Velcro</option>'+ 
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_output" name="lam_output[]" placeholder="Output">'+
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
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 lam_remove" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.lam_remove', function(){
        var id = $(this).attr("id"); 
        $('#laminationrow'+id+'').remove();
    });

    //Closing
    $('#closing').click(function(){
        var typee = "closing";
        i++;
        $('#closingrow').append(
                            '<div id="closingrow'+i+'" name="closing" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input id="clo_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="clo_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_description'+i+'" name="clo_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_uom'+i+'" name="clo_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="clo_component" name="clo_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+
                                        '<option style="text-transform: capitalize" value="Back">Back</option>'+
                                        '<option style="text-transform: capitalize" value="Back Counter">Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Back Inner">Back Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Back Linning">Back Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Back Upper">Back Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle">Buckle</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle Covering">Buckle Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Collar">Collar</option>'+
                                        '<option style="text-transform: capitalize" value="Cording String">Cording String</option>'+
                                        '<option style="text-transform: capitalize" value="Elastic">Elastic</option>'+
                                        '<option style="text-transform: capitalize" value="Filler">Filler</option>'+
                                        '<option style="text-transform: capitalize" value="Folding Tape">Folding Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Front Inner">Front Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Front Upper">Front Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Heel">Heel</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Covering">Heel Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Grip">Heel Grip</option>'+
                                        '<option style="text-transform: capitalize" value="Inner">Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 1">Inner 1</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 2">Inner 2</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 3">Inner 3</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 4">Inner 4</option>'+
                                        '<option style="text-transform: capitalize" value="Inner Foam">Inner Foam</option>'+
                                        '<option style="text-transform: capitalize" value="Insocks">Insocks</option>'+
                                        '<option style="text-transform: capitalize" value="Insole">Insole</option>'+
                                        '<option style="text-transform: capitalize" value="Leg Pin">Leg Pin</option>'+
                                        '<option style="text-transform: capitalize" value="Linning">Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 1">Linning 1</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 2">Linning 2</option>'+
                                        '<option style="text-transform: capitalize" value="Linning Back Counter">Linning Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Loop">Loop</option>'+
                                        '<option style="text-transform: capitalize" value="Outsole">Outsole</option>'+
                                        '<option style="text-transform: capitalize" value="Plug">Plug</option>'+
                                        '<option style="text-transform: capitalize" value="Quarter">Quarter</option>'+
                                        '<option style="text-transform: capitalize" value="Randal">Randal</option>'+
                                        '<option style="text-transform: capitalize" value="Reinforcement Tape">Reinforcement Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Strap">Strap</option>'+
                                        '<option style="text-transform: capitalize" value="Strap Linning">Strap Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Stud">Stud</option>'+
                                        '<option style="text-transform: capitalize" value="Tie">Tie</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 1">Tie 1</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 2">Tie 2</option>'+
                                        '<option style="text-transform: capitalize" value="Toe">Toe</option>'+
                                        '<option style="text-transform: capitalize" value="Toe Covering">Toe Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Top Piece">Top Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Upper">Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 1">Upper 1</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 2">Upper 2</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 3">Upper 3</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp">Vamp</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp Piece">Vamp Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Velcro">Velcro</option>'+   
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_output" name="clo_output[]" placeholder="Output">'+
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
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 clo_remove" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.clo_remove', function(){
        var id = $(this).attr("id"); 
        $('#closingrow'+id+'').remove();
    });

    //Lasting
    $('#lasting').click(function(){
        var typee = "lasting";
        i++;
        $('#lastingrow').append(
                            '<div id="lastingrow'+i+'" name="lasting" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input id="last_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="last_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_description'+i+'" name="last_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_uom'+i+'" name="last_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="last_component" name="last_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+
                                        '<option style="text-transform: capitalize" value="Back">Back</option>'+
                                        '<option style="text-transform: capitalize" value="Back Counter">Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Back Inner">Back Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Back Linning">Back Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Back Upper">Back Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle">Buckle</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle Covering">Buckle Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Collar">Collar</option>'+
                                        '<option style="text-transform: capitalize" value="Cording String">Cording String</option>'+
                                        '<option style="text-transform: capitalize" value="Elastic">Elastic</option>'+
                                        '<option style="text-transform: capitalize" value="Filler">Filler</option>'+
                                        '<option style="text-transform: capitalize" value="Folding Tape">Folding Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Front Inner">Front Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Front Upper">Front Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Heel">Heel</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Covering">Heel Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Grip">Heel Grip</option>'+
                                        '<option style="text-transform: capitalize" value="Inner">Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 1">Inner 1</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 2">Inner 2</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 3">Inner 3</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 4">Inner 4</option>'+
                                        '<option style="text-transform: capitalize" value="Inner Foam">Inner Foam</option>'+
                                        '<option style="text-transform: capitalize" value="Insocks">Insocks</option>'+
                                        '<option style="text-transform: capitalize" value="Insole">Insole</option>'+
                                        '<option style="text-transform: capitalize" value="Leg Pin">Leg Pin</option>'+
                                        '<option style="text-transform: capitalize" value="Linning">Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 1">Linning 1</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 2">Linning 2</option>'+
                                        '<option style="text-transform: capitalize" value="Linning Back Counter">Linning Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Loop">Loop</option>'+
                                        '<option style="text-transform: capitalize" value="Outsole">Outsole</option>'+
                                        '<option style="text-transform: capitalize" value="Plug">Plug</option>'+
                                        '<option style="text-transform: capitalize" value="Quarter">Quarter</option>'+
                                        '<option style="text-transform: capitalize" value="Randal">Randal</option>'+
                                        '<option style="text-transform: capitalize" value="Reinforcement Tape">Reinforcement Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Strap">Strap</option>'+
                                        '<option style="text-transform: capitalize" value="Strap Linning">Strap Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Stud">Stud</option>'+
                                        '<option style="text-transform: capitalize" value="Tie">Tie</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 1">Tie 1</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 2">Tie 2</option>'+
                                        '<option style="text-transform: capitalize" value="Toe">Toe</option>'+
                                        '<option style="text-transform: capitalize" value="Toe Covering">Toe Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Top Piece">Top Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Upper">Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 1">Upper 1</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 2">Upper 2</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 3">Upper 3</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp">Vamp</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp Piece">Vamp Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Velcro">Velcro</option>'+   
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_output" name="last_output[]" placeholder="Output">'+
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
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 last_remove" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.last_remove', function(){
        var id = $(this).attr("id"); 
        $('#lastingrow'+id+'').remove();
    });

    //Packing
    $('#packing').click(function(){
        var typee = "packing";
        i++;
        $('#packingrow').append(
                            '<div id="packingrow'+i+'" name="packing" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input id="p_item_code'+i+'" type="text" style="border: 1px solid #bfbfbf;" name="p_item_code[]" class="form-control py-2 yourclass" placeholder="Item Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_description'+i+'" name="p_description[]" placeholder="Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_uom'+i+'" name="p_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="p_component" name="p_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+
                                        '<option style="text-transform: capitalize" value="Back">Back</option>'+
                                        '<option style="text-transform: capitalize" value="Back Counter">Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Back Inner">Back Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Back Linning">Back Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Back Upper">Back Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle">Buckle</option>'+
                                        '<option style="text-transform: capitalize" value="Buckle Covering">Buckle Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Collar">Collar</option>'+
                                        '<option style="text-transform: capitalize" value="Cording String">Cording String</option>'+
                                        '<option style="text-transform: capitalize" value="Elastic">Elastic</option>'+
                                        '<option style="text-transform: capitalize" value="Filler">Filler</option>'+
                                        '<option style="text-transform: capitalize" value="Folding Tape">Folding Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Front Inner">Front Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Front Upper">Front Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Heel">Heel</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Covering">Heel Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Heel Grip">Heel Grip</option>'+
                                        '<option style="text-transform: capitalize" value="Inner">Inner</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 1">Inner 1</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 2">Inner 2</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 3">Inner 3</option>'+
                                        '<option style="text-transform: capitalize" value="Inner 4">Inner 4</option>'+
                                        '<option style="text-transform: capitalize" value="Inner Foam">Inner Foam</option>'+
                                        '<option style="text-transform: capitalize" value="Insocks">Insocks</option>'+
                                        '<option style="text-transform: capitalize" value="Insole">Insole</option>'+
                                        '<option style="text-transform: capitalize" value="Leg Pin">Leg Pin</option>'+
                                        '<option style="text-transform: capitalize" value="Linning">Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 1">Linning 1</option>'+
                                        '<option style="text-transform: capitalize" value="Linning 2">Linning 2</option>'+
                                        '<option style="text-transform: capitalize" value="Linning Back Counter">Linning Back Counter</option>'+
                                        '<option style="text-transform: capitalize" value="Loop">Loop</option>'+
                                        '<option style="text-transform: capitalize" value="Outsole">Outsole</option>'+
                                        '<option style="text-transform: capitalize" value="Plug">Plug</option>'+
                                        '<option style="text-transform: capitalize" value="Quarter">Quarter</option>'+
                                        '<option style="text-transform: capitalize" value="Randal">Randal</option>'+
                                        '<option style="text-transform: capitalize" value="Reinforcement Tape">Reinforcement Tape</option>'+
                                        '<option style="text-transform: capitalize" value="Strap">Strap</option>'+
                                        '<option style="text-transform: capitalize" value="Strap Linning">Strap Linning</option>'+
                                        '<option style="text-transform: capitalize" value="Stud">Stud</option>'+
                                        '<option style="text-transform: capitalize" value="Tie">Tie</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 1">Tie 1</option>'+
                                        '<option style="text-transform: capitalize" value="Tie 2">Tie 2</option>'+
                                        '<option style="text-transform: capitalize" value="Toe">Toe</option>'+
                                        '<option style="text-transform: capitalize" value="Toe Covering">Toe Covering</option>'+
                                        '<option style="text-transform: capitalize" value="Top Piece">Top Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Upper">Upper</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 1">Upper 1</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 2">Upper 2</option>'+
                                        '<option style="text-transform: capitalize" value="Upper 3">Upper 3</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp">Vamp</option>'+
                                        '<option style="text-transform: capitalize" value="Vamp Piece">Vamp Piece</option>'+
                                        '<option style="text-transform: capitalize" value="Velcro">Velcro</option>'+   
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_output" name="p_output[]" placeholder="Output">'+
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
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 p_remove" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.p_remove', function(){
        var id = $(this).attr("id"); 
        $('#packingrow'+id+'').remove();
    });

    //Manual
    $('#manual').click(function(){
        console.log("Hyeeee");
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
});