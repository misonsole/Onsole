$(document).ready(function(){
    var i = 1;
    $('#addJobOrder').click(function(){
        i++;
        var Len = i-1;
        var numArray = [];
        for(z=0; z<Len; z++){
            numArray.push(i);
        }
        window.sessionStorage.setItem("items", JSON.stringify(numArray.length));
        $.ajax({
            type: 'GET',
            url: 'joborderdata',
            dataType: "json",
            success: function(data){
                if(data){
                    console.log("Data");
                    console.log(data);
                    for(j=1; j<=data.color.length; j++){
                        var $dataToBeAppended = `<option>`+data.color[j]+`</option>`;
                        $("#seasonyes"+i).append($dataToBeAppended);
                    }
                    for(j=1; j<=data.last.length; j++){
                        var $dataToBeAppended1 = `<option>`+data.last[j]+`</option>`;
                        $("#seasonyes1"+i).append($dataToBeAppended1);
                    }
                }
            }
        });
        $('#JobOrderDiv').append(
                        '<div id="row2'+i+'" class="form-group row py-2 px-2 mb-5 bg-dark">'+
                            '<div class="col-sm-12 col-md-12 py-0 mt-3">'+
                                '<div class="form-group row mb-0">'+
                                    '<div class="col-sm-2 text-center">'+
                                        '<div class="alert alert-light border-0 py-2 mb-0" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">'+
                                            '<label class="mb-0 text-white" style="font-weight: 500;">Size Breakup</label>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-sm-9 text-center">'+
                                    '</div>'+
                                    '<div class="col-sm-1 text-center">'+
                                        '<button style="box-shadow: none; margin-top: -3px;" id="'+i+'" type="button" class="btn btn-danger btn-round px-4 w-100 upper_remove"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group row py-0">'+
                                    '<table class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">'+
                                        '<thead class="bg-dark text-white">'+
                                            '<tr id="colorDivtr1'+i+'">'+
                                                '<th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Status</b></label></th>'+
                                                '<th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Color</b></label></th>'+
                                                '<th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Last No.</b></label></th>'+
                                                '<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">36</b></label></th>'+
                                                '<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">37</b></label></th>'+
                                                '<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">38</b></label></th>'+
                                                '<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">39</b></label></th>'+
                                                '<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">40</b></label></th>'+
                                                '<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">41</b></label></th>'+
                                                '<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Total</b></label></th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>'+
                                            '<tr id="colorDivtr'+i+'">'+
                                                '<td style="border-top: none; width: 12%;">'+
                                                    '<select id="season" name="season" style="border: 1px solid #bfbfbf; text-transform: capitalize; width: -webkit-fill-available;" class="form-control custom-select"" required>'+
                                                        '<option selected disabled>Status</option> '+
                                                        '<option value="On Hold" style="color: red;">On Hold</option>'+
                                                        '<option value="Good To Go" selected="selected">Good To Go</option>'+                                                    
                                                    '</select>'+
                                                '</td>'+
                                                '<td style="border-top: none; width: 12%;">'+
                                                    '<select id="seasonyes'+i+'" name="season" style="border: 1px solid #bfbfbf; text-transform: capitalize; width: -webkit-fill-available;" class="form-control custom-select"" required>'+
                                                        '<option selected disabled>Select color</option>'+
                                                    '</select>'+
                                                '</td>'+
                                                '<td style="border-top: none; width: 12%;">'+
                                                    '<select id="seasonyes1'+i+'" name="season" style="border: 1px solid #bfbfbf; text-transform: capitalize; width: -webkit-fill-available;" class="form-control custom-select"" required>'+
                                                        '<option selected disabled>Select Last No</option> '+
                                                    '</select>'+
                                                '</td>'+
                                                '<td class="tdDiv1" style="border-top: none;">'+
                                                    '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence">'+
                                                '</td>'+
                                                '<td class="tdDiv1" style="border-top: none;">'+
                                                   ' <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence">'+
                                                ' </td>'+
                                                '<td class="tdDiv1" style="border-top: none;">'+
                                                    '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence">'+
                                                '</td>'+
                                                '<td class="tdDiv1" style="border-top: none;">'+
                                                    '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence">'+
                                                '</td>'+
                                                '<td class="tdDiv1" style="border-top: none;">'+
                                                    '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence">'+
                                                '</td>'+
                                                '<td class="tdDiv1" style="border-top: none;">'+
                                                    '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence">'+
                                                '</td>'+
                                                '<td class="tdDiv1" style="border-top: none;">'+
                                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence" readonly>'+
                                                '</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>'+
                                '</div>'+
                                '<div class="form-group row mb-0">'+
                                    '<div class="col-sm-2 text-center">'+
                                        '<div class="alert alert-light border-0 py-2 mb-0" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">'+
                                           ' <label class="mb-0 text-white" style="font-weight: 500;">Select Color</label>'+
                                        '</div>  '+
                                    '</div>'+
                                    '<div class="col-sm-9 text-center">'+
                                    '</div>'+
                                    '<div class="col-sm-1 text-center">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group row py-0">'+
                                    '<table class="table dt-responsive nowrap text-center mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">'+
                                        '<thead class="bg-dark text-white">'+
                                            '<tr>'+
                                                '<th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">RM Code</b></label></th>'+
                                                '<th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Location</b></label></th>'+
                                                '<th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Tool</b></label></th>'+
                                                '<th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Die No</b></label></th>'+
                                                '<th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Quantity</b></label></th>'+
                                                '<th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Remarks</b></label></th>'+
                                                '<th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: transparent;">Total</b></label></th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody id="colorDiv'+i+'">'+                  
                                            '<tr>'+
                                                '<td style="border-top: none;">'+
                                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="rmcode" placeholder="Select RM Code" name="rmcode[]">'+
                                                '</td>'+
                                                '<td style="border-top: none;">'+
                                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="location" placeholder="Location" name="location[]">'+
                                                '</td>'+
                                                '<td style="border-top: none; width: 12%;">'+
                                                    '<select id="tool" name="tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                                        '<option selected disabled>Select Tool</option>'+
                                                        '<option value="DYE">Dye</option>'+
                                                        '<option value="LASER">Laser</option>'+
                                                    '</select>'+
                                                '</td>'+
                                                '<td style="border-top: none;">'+
                                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Die No" id="dieno" name="dieno[]">'+
                                                '</td>'+
                                                '<td style="border-top: none;">'+
                                                    '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Quantity" id="qty" name="qty[]">'+
                                                '</td>'+
                                                '<td style="border-top: none;">'+
                                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Remarks" id="remarks" name="remarks[]">'+
                                                '</td>'+
                                                '<td style="border-top: none; width: 8%;">'+
                                                    '<button id="'+i+'" style="box-shadow: none; margin-top: -3px;" type="button" class="btn btn-success btn-round px-4 w-100 addColor99"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>'+
                                                '</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>'+
                                '</div>'+
                            '</div>'+
                        '</div>');
    });
    $(document).on('click', '.upper_remove', function(){
        var id = $(this).attr("id"); 
        $('#row2'+id+'').remove();
    });
    var color = 1; 
    $(document).on('click', '.addColor99', function(){
        var color1 = $(this).attr("id"); 
        color++;
        $('#colorDiv'+color1+'').append(
                            '<tr id="row3'+color+'">'+
                                '<td style="border-top: none;">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="rmcode'+i+'" placeholder="Select RM Code" name="rmcode[]">'+
                                '</td>'+
                                ' <td style="border-top: none;">'+
                                    '  <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="location'+i+'" placeholder="Location" name="location[]">'+
                                '</td>'+
                                '<td style="border-top: none; width: 12%;">'+
                                    '<select id="tool" name="tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected disabled>Select Tool</option>'+
                                        '<option value="DYE">Dye</option>'+
                                        '<option value="LASER">Laser</option>'+
                                    '</select>'+
                                '</td>'+
                                '<td style="border-top: none;">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Die No" id="dieno'+i+'" name="dieno[]">'+
                                '</td>'+
                                '<td style="border-top: none;">'+
                                    '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Quantity" id="qty'+i+'" name="qty[]">'+
                                '</td>'+
                                '<td style="border-top: none;">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Remarks" id="remarks'+i+'" name="remarks[]">'+
                                '</td>'+
                                '<td style="border-top: none; width: 8%;">'+
                                    '<button style="box-shadow: none; margin-top: -3px;" type="button" class="btn btn-danger btn-round px-4 w-100 remove3" id="'+color+'"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</td>'+
                            '</tr>');
    });
    $(document).on('click', '.remove3', function(){
        var id = $(this).attr("id"); 
        $('#row3'+id).remove();
    });
});