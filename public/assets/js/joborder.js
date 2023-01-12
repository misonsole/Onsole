$(document).ready(function(){
    var i = 1;
    //Upper Materials
    $('#upper').click(function(){
        var typee = "upper";
        i++;
        $('#upperrow').append(
                            '<div id="upperrow'+i+'" name="upper" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input readonly id="u_item_code'+i+'" type="text" name="u_item_code[]" class="form-control py-2 yourclass" placeholder="Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_description'+i+'" name="u_description[]" placeholder="Enter Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_uom'+i+'" name="u_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="u_type" name="u_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="Local">Local</option>'+     
                                        '<option value="Imported">Imported</option>'+                                            
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="u_use" name="u_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+                                     
                                        '@foreach($location as $value)'+ 
                                        '<option value="{{ $value->location_no }}">{{ $value->location_no }}</option>'+ 
                                        '@endforeach'+       
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="u_tool" name="u_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="null">None</option>'+ 
                                        '<option value="Laser">Laser</option>'+  
                                        '<option value="Dye">Dye</option>'+     
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_quantity" name="u_quantity[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 upper_remove" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.upper_remove', function(){
        var id = $(this).attr("id"); 
        $('#upperrow'+id+'').remove();
    });

    //Upper Materials
    $('#linning').click(function(){
        var typee = "linning";
        i++;
        $('#linningrow').append(
                            '<div id="linningrow'+i+'" name="linning" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input readonly id="l_item_code'+i+'" type="text" name="l_item_code[]" class="form-control py-2 yourclass" placeholder="Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="l_description'+i+'" name="l_description[]" placeholder="Enter Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="l_uom'+i+'" name="l_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="l_type" name="l_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="Local">Local</option>'+     
                                        '<option value="Imported">Imported</option>'+    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="l_use" name="l_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+                                   
                                        '@foreach($location as $value)'+ 
                                        '<option value="{{ $value->location_no }}">{{ $value->location_no }}</option>'+ 
                                        '@endforeach'+     
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="l_tool" name="l_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="null">None</option>'+  
                                        '<option value="Laser">Laser</option>'+  
                                        '<option value="Dye">Dye</option>'+    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_quantity" name="l_quantity[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 linning_remove" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.linning_remove', function(){
        var id = $(this).attr("id"); 
        $('#linningrow'+id+'').remove();
    });

    //Stiching Materials
    $('#stiching').click(function(){
        var typee = "stiching";
        i++;
        $('#stichingrow').append(
                            '<div id="stichingrow'+i+'" name="stichingrow" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input readonly id="st_item_code'+i+'" type="text" name="st_item_code[]" class="form-control py-2 yourclass" placeholder="Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="st_description'+i+'" name="st_description[]" placeholder="Enter Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="st_uom'+i+'" name="st_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="st_type" name="st_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="Local">Local</option>'+     
                                        '<option value="Imported">Imported</option>'+  
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="st_use" name="st_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+                                      
                                        '@foreach($location as $value)'+ 
                                        '<option value="{{ $value->location_no }}">{{ $value->location_no }}</option>'+ 
                                        '@endforeach'+   +  
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="st_tool" name="st_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="null">None</option>'+ 
                                        '<option value="Laser">Laser</option>'+  
                                        '<option value="Dye">Dye</option>'+     
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_quantity" name="st_quantity[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="stiching_remove btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.stiching_remove', function(){
        var id = $(this).attr("id"); 
        $('#stichingrow'+id+'').remove();
    });

    //Insole Materials
    $('#insole').click(function(){
        var typee = "insole";
        i++;
        $('#insolerow').append(
                            '<div id="insolerow'+i+'" name="insolerow" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input readonly id="i_item_code'+i+'" type="text" name="i_item_code[]" class="form-control py-2 yourclass" placeholder="Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description'+i+'" name="i_description[]" placeholder="Enter Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_uom'+i+'" name="i_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="i_type" name="i_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="Local">Local</option>'+     
                                        '<option value="Imported">Imported</option>'+   
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="i_use" name="i_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+                                           
                                        '@foreach($location as $value)'+ 
                                        '<option value="{{ $value->location_no }}">{{ $value->location_no }}</option>'+ 
                                        '@endforeach'+      
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="i_tool" name="i_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="null">None</option>'+    
                                        '<option value="Laser">Laser</option>'+  
                                        '<option value="Dye">Dye</option>'+     
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_quantity" name="i_quantity[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="insole_remove btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.insole_remove', function(){
        var id = $(this).attr("id"); 
        $('#insolerow'+id+'').remove();
    });

    //Outsole Materials
    $('#outsole').click(function(){
        var typee = "outsole";
        i++;
        $('#outsolerow').append(
                            '<div id="outsolerow'+i+'" name="outsolerow" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input readonly id="o_item_code'+i+'" type="text" name="o_item_code[]" class="form-control py-2 yourclass" placeholder="Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="o_description'+i+'" name="o_description[]" placeholder="Enter Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="o_uom'+i+'" name="o_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="o_type" name="o_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="Local">Local</option>'+     
                                        '<option value="Imported">Imported</option>'+   
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="u_use" name="o_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+                                          
                                        '@foreach($location as $value)'+ 
                                        '<option value="{{ $value->location_no }}">{{ $value->location_no }}</option>'+ 
                                        '@endforeach'+      
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="o_tool" name="o_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="null">None</option>'+ 
                                        '<option value="Laser">Laser</option>'+  
                                        '<option value="Dye">Dye</option>'+  
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_quantity" name="o_quantity[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="outsole_remove btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.outsole_remove', function(){
        var id = $(this).attr("id"); 
        $('#outsolerow'+id+'').remove();
    });

    //Socks Materials
    $('#socks').click(function(){
        var typee = "socks";
        i++;
        $('#socksrow').append(
                            '<div id="socksrow'+i+'" name="socksrow" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input readonly id="s_item_code'+i+'" type="text" name="s_item_code[]" class="form-control py-2 yourclass" placeholder="Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="s_description'+i+'" name="s_description[]" placeholder="Enter Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="s_uom'+i+'" name="s_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="s_type" name="s_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="Local">Local</option>'+     
                                        '<option value="Imported">Imported</option>'+   
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="s_use" name="s_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+                                         
                                        '@foreach($location as $value)'+ 
                                        '<option value="{{ $value->location_no }}">{{ $value->location_no }}</option>'+ 
                                        '@endforeach'+      
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="s_tool" name="s_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="null">None</option>'+    
                                        '<option value="Laser">Laser</option>'+  
                                        '<option value="Dye">Dye</option>'+    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="s_quantity" name="s_quantity[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="socks_remove btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.socks_remove', function(){
        var id = $(this).attr("id"); 
        $('#socksrow'+id+'').remove();
    });

    //Genral Materials
    $('#genral').click(function(){
        var typee = "genral";
        i++;
        $('#genralrow').append(
                            '<div id="genralrow'+i+'" name="genralrow" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input readonly id="g_item_code'+i+'" type="text" name="g_item_code[]" class="form-control py-2 yourclass" placeholder="Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="g_description'+i+'" name="g_description[]" placeholder="Enter Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="g_uom'+i+'" name="g_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="g_type" name="g_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="Local">Local</option>'+     
                                        '<option value="Imported">Imported</option>'+   
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="g_use" name="g_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected value="null">None</option>'+                                       
                                        '@foreach($location as $value)'+ 
                                        '<option value="{{ $value->location_no }}">{{ $value->location_no }}</option>'+ 
                                        '@endforeach'+     
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<select id="g_tool" name="g_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="null">None</option>'+   
                                        '<option value="Laser">Laser</option>'+  
                                        '<option value="Dye">Dye</option>'+     
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="g_quantity" name="g_quantity[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="genral_remove btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.genral_remove', function(){
        var id = $(this).attr("id"); 
        $('#genralrow'+id+'').remove();
    });
});