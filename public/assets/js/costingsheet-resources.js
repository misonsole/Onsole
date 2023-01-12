$(document).ready(function(){
    var i = 1;
    //Cutting
    $('#cutting1').click(function(){
        i++;
        $('#cuttingrow1').append(
                            '<div id="cuttingrow'+i+'1" name="cutting1" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_value_r" name="cut_value_r[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description_r" name="cut_description_r[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_remarks_r" name="cut_remarks_r[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_rate_r" name="cut_rate_r[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 cutting_remove1" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.cutting_remove1', function(){
        var id = $(this).attr("id"); 
        $('#cuttingrow'+id+'1').remove();
    });

    //Insole
    $('#insole1').click(function(){
        i++;
        $('#insolerow1').append(
                            '<div id="insolerow'+i+'1" name="insole1" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_value_r" name="i_value_r[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description_r" name="i_description_r[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_remarks_r" name="i_remarks_r[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_rate_r" name="i_rate_r[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 insole_remove1" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.insole_remove1', function(){
        var id = $(this).attr("id"); 
        $('#insolerow'+id+'1').remove();
    });

    //Lamination
    $('#lamination1').click(function(){
        i++;
        $('#laminationrow1').append(
                            '<div id="laminationrow'+i+'1" name="lamination1" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_value_r" name="lam_value_r[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_description_r" name="lam_description_r[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_remarks_r" name="lam_remarks_r[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_rate_r" name="lam_rate_r[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 lam_remove1" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.lam_remove1', function(){
        var id = $(this).attr("id"); 
        $('#laminationrow'+id+'1').remove();
    });

    //Closing
    $('#closing1').click(function(){
        i++;
        $('#closingrow1').append(
                            '<div id="closingrow'+i+'1" name="closing1" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_value_r" name="clo_value_r[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_description_r" name="clo_description_r[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_remarks_r" name="clo_remarks_r[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_rate_r" name="clo_rate_r[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 clo_remove1" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.clo_remove1', function(){
        var id = $(this).attr("id"); 
        $('#closingrow'+id+'1').remove();
    });

    //Lasting
    $('#lasting1').click(function(){
        i++;
        $('#lastingrow1').append(
                            '<div id="lastingrow'+i+'1" name="lasting1" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_value_r" name="last_value_r[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_description_r" name="last_description_r[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_remarks_r" name="last_remarks_r[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_rate_r" name="last_rate_r[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 last_remove1" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.last_remove1', function(){
        var id = $(this).attr("id"); 
        $('#lastingrow'+id+'1').remove();
    });

    //Packing
    $('#packing1').click(function(){
        i++;
        $('#packingrow1').append(
                            '<div id="packingrow'+i+'1" name="packing" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_value_r" name="p_value_r[]" placeholder="Item Code" required>'+
                                '</div>'+
                                '<div class="col-sm-5 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_description_r" name="p_description_r[]" placeholder="Description">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="text" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_remarks_r" name="p_remarks_r[]" placeholder="Remarks">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<input type="number" oninput="this.value = Math.abs(this.value)" min="0.0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_rate_r" name="p_rate_r[]" placeholder="Rate">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 p_remove1" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.p_remove1', function(){
        var id = $(this).attr("id"); 
        $('#packingrow'+id+'1').remove();
    });
});