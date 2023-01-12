$(document).ready(function(){
    var i = 1;
    //Cutting
    $('#cutting2').click(function(){
        var typee = "cutting";
        i++;
        $('#cuttingrow2').append(
                            '<div id="cuttingrow'+i+'2" name="cutting2" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_value_o" name="cut_value_o[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description_o" name="cut_description_o[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_remarks_o" name="cut_remarks_o[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_rate_o" name="cut_rate_o[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 cutting_remove2" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.cutting_remove2', function(){
        var id = $(this).attr("id"); 
        $('#cuttingrow'+id+'2').remove();
    });

    //Insole
    $('#insole2').click(function(){
        var typee = "insole";
        i++;
        $('#insolerow2').append(
                            '<div id="insolerow'+i+'2" name="insole2" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_value_o" name="i_value_o[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description_o" name="i_description_o[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_remarks_o" name="i_remarks_o[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_rate_o" name="i_rate_o[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 insole_remove2" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.insole_remove2', function(){
        var id = $(this).attr("id"); 
        $('#insolerow'+id+'2').remove();
    });

    //Lamination
    $('#lamination2').click(function(){
        var typee = "lamination";
        i++;
        $('#laminationrow2').append(
                            '<div id="laminationrow'+i+'2" name="lamination2" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_value_o" name="lam_value_o[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_description_o" name="lam_description_o[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_remarks_o" name="lam_remarks_o[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_rate_o" name="lam_rate_o[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 lam_remove2" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.lam_remove2', function(){
        var id = $(this).attr("id"); 
        $('#laminationrow'+id+'2').remove();
    });

    //Closing
    $('#closing2').click(function(){
        var typee = "closing";
        i++;
        $('#closingrow2').append(
                            '<div id="closingrow'+i+'2" name="closing2" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_value_o" name="clo_value_o[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_description_o" name="clo_description_o[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_remarks_o" name="clo_remarks_o[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_rate_o" name="clo_rate_o[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 clo_remove2" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.clo_remove2', function(){
        var id = $(this).attr("id"); 
        $('#closingrow'+id+'2').remove();
    });

    //Lasting
    $('#lasting2').click(function(){
        var typee = "lasting";
        i++;
        $('#lastingrow2').append(
                            '<div id="lastingrow'+i+'2" name="lasting2" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_value_o" name="last_value_o[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_description_o" name="last_description_o[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_remarks_o" name="last_remarks_o[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_rate_o" name="last_rate_o[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 last_remove2" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.last_remove2', function(){
        var id = $(this).attr("id"); 
        $('#lastingrow'+id+'2').remove();
    });

    //Packing
    $('#packing2').click(function(){
        var typee = "packing";
        i++;
        $('#packingrow2').append(
                            '<div id="packingrow'+i+'2" name="packing2" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_value_o" name="p_value_o[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_description_o" name="p_description_o[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_remarks_o" name="p_remarks_o[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_rate_o" name="p_rate_o[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 p_remove2" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.p_remove2', function(){
        var id = $(this).attr("id"); 
        $('#packingrow'+id+'2').remove();
    });
});