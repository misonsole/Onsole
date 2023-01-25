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
    input::-webkit-outer-spin-button, input::-webkit-inner-spin-button{
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number]{
        -moz-appearance: textfield;
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
                    <div class="form-group row py-0 mb-0">
                        <div class="col-sm-12 col-md-12">
                            <span id="StrengthDisp3" style="font-size: 15px !important;" class="badge displayBadgess text-light py-3 mt-2"></span> 
                        </div>
                    </div>
                    <div class="form-group row py-0">
                        <form id="myForm">
                        @csrf
                            <table class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <tbody style="border-bottom: 20px solid white;">
                                    <tr>                                    
                                        <div class="alert alert-secondary border-0 py-1 text-center" style="width: 10%; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Cutting</label>
                                        </div>  
                                    </tr> 
                                    <tr id="ccolorDivtr" class="bg-dark">                                  
                                        <td style="border-top: none; width: 10%; padding-top: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Production Capacity <br> Per Day</b></label>
                                            <input type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="cutting" id="cut_pcpd_cutting" name="cut_pcpd_cutting">
                                            <input type="text" value="Cutting" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_cutting" name="cut_dep_cutting" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="cutting" id="cut_noe_cutting" name="cut_noe_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="cutting" id="cut_aspd_cutting" name="cut_aspd_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="cutting" id="cut_nowd_cutting" name="cut_nowd_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_cutting" name="cut_pds_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_cutting" name="cut_dlo_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate1" style="border: 1px solid #bfbfbf;" data-id="cutting" id="cut_ilo_cutting" name="cut_ilo_cutting">  
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_cutting" name="cut_cilo_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate2" style="border: 1px solid #bfbfbf;" data-id="cutting" id="cut_foh_cutting" name="cut_foh_cutting">    
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                    
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_cutting" name="cut_ilOh_b_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_cutting" name="cut_t_oh_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_cutting" name="cut_cap_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_cutting" name="cut_dlo_a_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_cutting" name="cut_ilo_a_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_cutting" name="cut_dlo_b_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_cutting" name="cut_toh_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_cutting" name="cut_uaOh_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Cutting" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">                            
                                <tbody style="border-bottom: 20px solid white;">
                                    <tr>                                    
                                        <div class="alert alert-secondary border-0 py-1 text-center" style="width: 10%; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Stitching</label>
                                        </div>  
                                    </tr> 
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                      
                                        <td style="border-top: none; width: 10%; padding-top: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Production Capacity <br> Per Day</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="sti" id="cut_pcpd_sti" min="0" oninput="this.value = Math.abs(this.value)" name="cut_pcpd_sti">
                                            <input type="text" value="Stitching" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_sti" name="cut_dep_sti" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="sti" id="cut_noe_sti" name="cut_noe_sti">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="sti" id="cut_aspd_sti" name="cut_aspd_sti">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="sti" id="cut_nowd_sti" name="cut_nowd_sti">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_sti" name="cut_pds_sti">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_sti" name="cut_dlo_sti">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate1" data-id="sti" style="border: 1px solid #bfbfbf;" id="cut_ilo_sti" name="cut_ilo_sti">  
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_sti" name="cut_cilo_sti">
                                        </td>
                                        <td style="border-top: none; padding-top: 2%; width: 10%" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate2" data-id="sti" style="border: 1px solid #bfbfbf;" id="cut_foh_sti" name="cut_foh_sti">    
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                         
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_sti" name="cut_ilOh_b_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_sti" name="cut_t_oh_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_sti" name="cut_cap_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_sti" name="cut_dlo_a_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_sti" name="cut_ilo_a_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_sti" name="cut_dlo_b_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_sti" name="cut_toh_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_sti" name="cut_uaOh_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Stitching" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <tbody style="border-bottom: 20px solid white;">
                                    <tr>                                    
                                        <div class="alert alert-secondary border-0 py-1 text-center" style="width: 10%; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Lasting</label>
                                        </div>  
                                    </tr> 
                                    <tr id="ccolorDivtr" class="bg-dark">                               
                                        <td style="border-top: none; width: 10%; padding-top: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Production Capacity <br> Per Day</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="last" id="cut_pcpd_last" min="0" oninput="this.value = Math.abs(this.value)" name="cut_pcpd_last">
                                            <input type="text" value="Lasting" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_last" name="cut_dep_last" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="last" id="cut_noe_last" name="cut_noe_last">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="last" id="cut_aspd_last" name="cut_aspd_last">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="last" id="cut_nowd_last" name="cut_nowd_last">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_last" name="cut_pds_last">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_last" name="cut_dlo_last">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate1" data-id="last" style="border: 1px solid #bfbfbf;" id="cut_ilo_last" name="cut_ilo_last">  
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_last" name="cut_cilo_last">
                                        </td>
                                        <td style="border-top: none; padding-top: 2%; width: 10%" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate2" data-id="last" style="border: 1px solid #bfbfbf;" id="cut_foh_last" name="cut_foh_last">    
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                            
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_last" name="cut_ilOh_b_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_last" name="cut_t_oh_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_last" name="cut_cap_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_last" name="cut_dlo_a_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_last" name="cut_ilo_a_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_last" name="cut_dlo_b_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_last" name="cut_toh_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_last" name="cut_uaOh_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Lasting" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">                                
                                <tbody style="border-bottom: 20px solid white;">
                                    <tr>                                    
                                        <div class="alert alert-secondary border-0 py-1 text-center" style="width: 10%; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Closing</label>
                                        </div>  
                                    </tr> 
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                          
                                        <td style="border-top: none; width: 10%; padding-top: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Production Capacity <br> Per Day</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="clo" id="cut_pcpd_clo" min="0" oninput="this.value = Math.abs(this.value)" name="cut_pcpd_clo">
                                            <input type="text" value="Closing" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_clo" name="cut_dep_clo" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="clo" id="cut_noe_clo" name="cut_noe_clo">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="clo" id="cut_aspd_clo" name="cut_aspd_clo">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="clo" id="cut_nowd_clo" name="cut_nowd_clo">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_clo" name="cut_pds_clo">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_clo" name="cut_dlo_clo">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate1" data-id="clo" style="border: 1px solid #bfbfbf;" id="cut_ilo_clo" name="cut_ilo_clo">  
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_clo" name="cut_cilo_clo">
                                        </td>
                                        <td style="border-top: none; padding-top: 2%; width: 10%" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate2" data-id="clo" style="border: 1px solid #bfbfbf;" id="cut_foh_clo" name="cut_foh_clo">    
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                         
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_clo" name="cut_ilOh_b_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_clo" name="cut_t_oh_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_clo" name="cut_cap_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_clo" name="cut_dlo_a_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_clo" name="cut_ilo_a_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_clo" name="cut_dlo_b_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_clo" name="cut_toh_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_clo" name="cut_uaOh_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Closing" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <tbody style="border-bottom: 20px solid white;">
                                    <tr>                                    
                                        <div class="alert alert-secondary border-0 py-1 text-center" style="width: 10%; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Lamination</label>
                                        </div>  
                                    </tr> 
                                    <tr id="ccolorDivtr" class="bg-dark">                         
                                        <td style="border-top: none; width: 10%; padding-top: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Production Capacity <br> Per Day</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="lam" id="cut_pcpd_lam" min="0" oninput="this.value = Math.abs(this.value)" name="cut_pcpd_lam">
                                            <input type="text" value="Lamination" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_lam" name="cut_dep_lam" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="lam" id="cut_noe_lam" name="cut_noe_lam">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="lam" id="cut_aspd_lam" name="cut_aspd_lam">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="lam" id="cut_nowd_lam" name="cut_nowd_lam">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_lam" name="cut_pds_lam">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_lam" name="cut_dlo_lam">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate1" data-id="lam" style="border: 1px solid #bfbfbf;" id="cut_ilo_lam" name="cut_ilo_lam">  
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;" >
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_lam" name="cut_cilo_lam">
                                        </td>
                                        <td style="border-top: none; padding-top: 2%; width: 10%" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate2" data-id="lam" style="border: 1px solid #bfbfbf;" id="cut_foh_lam" name="cut_foh_lam">    
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                            
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_lam" name="cut_ilOh_b_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_lam" name="cut_t_oh_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_lam" name="cut_cap_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_lam" name="cut_dlo_a_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_lam" name="cut_ilo_a_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_lam" name="cut_dlo_b_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_lam" name="cut_toh_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_lam" name="cut_uaOh_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Lamination" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <tbody>
                                    <tr>                                    
                                        <div class="alert alert-secondary border-0 py-1 text-center" style="width: 10%; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Packing</label>
                                        </div>  
                                    </tr> 
                                    <tr id="ccolorDivtr" class="bg-dark">                    
                                        <td style="border-top: none; width: 10%; padding-top: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Production Capacity <br> Per Day</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="p" id="cut_pcpd_p" min="0" oninput="this.value = Math.abs(this.value)" name="cut_pcpd_p">
                                            <input type="text" value="Packing" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_p" name="cut_dep_p" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="p" id="cut_noe_p" name="cut_noe_p">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="p" id="cut_aspd_p" name="cut_aspd_p">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input type="number" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf;" data-id="p" id="cut_nowd_p" name="cut_nowd_p">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_p" name="cut_pds_p">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_p" name="cut_dlo_p">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate1" data-id="p" style="border: 1px solid #bfbfbf;" id="cut_ilo_p" name="cut_ilo_p">  
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_p" name="cut_cilo_p">
                                        </td>
                                        <td style="border-top: none; padding-top: 2%; width: 10%" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" class="form-control py-2 yourclass text-center calculate2" data-id="p" style="border: 1px solid #bfbfbf;" id="cut_foh_p" name="cut_foh_p">    
                                                    <span class="input-group-append">
                                                        <button disabled style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                            
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_p" name="cut_ilOh_b_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_p" name="cut_t_oh_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_p" name="cut_cap_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_p" name="cut_dlo_a_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_p" name="cut_ilo_a_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_p" name="cut_dlo_b_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_p" name="cut_toh_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_p" name="cut_uaOh_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Packing" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group row mt-5">
                                <div class="col-sm-4 mb-1 mb-sm-0">
                                </div>
                                <div class="col-sm-4">
                                    <a id="Check" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer;" class="btn px-5 py-1 btn-lg btn-block text-white">Submit</a>
                                </div>
                                <div class="col-sm-4">
                                </div>
                            </div>
                        </from>
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
    $("#Check").on('click',function(){
        var count1 = $("#cut_pcpd_cutting").val();
        var count2 = $("#cut_pcpd_sti").val();
        var count3 = $("#cut_pcpd_last").val();
        var count4 = $("#cut_pcpd_clo").val();
        var count5 = $("#cut_pcpd_lam").val();
        var count6 = $("#cut_pcpd_p").val();
        if(count1 == '' && count2 == '' && count3 == '' && count4 == '' && count5 == '' && count6 == ''){
            Swal.fire({
                icon: 'warning',
                text: "Add Atleast one Material",
            });
        }
        else{
            $("#myForm").attr("method", "post");
            $("#myForm").attr("enctype", "multipart/form-data");
            $("#myForm").attr("action", "formula-sheet-create");
            document.getElementById("myForm").submit();
        }
    }); 
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
<script>
    let strengthBadge3 = document.getElementById('StrengthDisp3');
    $(".calculate").keyup(function(){
        var id = $(this).attr("data-id");
        var cut_pcpd = $('#cut_pcpd_'+id).val();
        var cut_noe = $('#cut_noe_'+id).val();
        var cut_aspd = $('#cut_aspd_'+id).val();
        var cut_nowd = $('#cut_nowd_'+id).val();
        if(cut_noe.length == 0 && cut_aspd.length == 0 && cut_nowd.length == 0 && cut_pcpd.length == 0){
            strengthBadge3.style.display = 'block'
            strengthBadge3.style.backgroundColor = '#cd3f3f'
            strengthBadge3.textContent = 'Please Add Production Capacity Per Day, No. of Employee, Avg Salary Per Employee, No. of Working Days for Calculate Per Day Salary'
            var timer;
            clearTimeout(timer);
            var cut_noe1 = $('#cut_noe_'+id);
            var cut_aspd1 = $('#cut_aspd_'+id);
            var cut_nowd1 = $('#cut_nowd_'+id);
            var cut_pcpd1 = $('#cut_pcpd_'+id);

            cut_noe1.css('border-color', 'red');
            cut_aspd1.css('border-color', 'red');
            cut_nowd1.css('border-color', 'red');
            cut_pcpd1.css('border-color', 'red');

            timer = setTimeout(function(){
                cut_noe1.css('border-color', '#bfbfbf');
                cut_aspd1.css('border-color', '#bfbfbf');
                cut_nowd1.css('border-color', '#bfbfbf');
                cut_pcpd1.css('border-color', '#bfbfbf');
            }, 4000);
        }
        else if(cut_pcpd.length == 0){
            var timer;
            clearTimeout(timer);
            var self = $('#cut_pcpd_'+id);
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(cut_noe.length == 0){
            var timer;
            clearTimeout(timer);
            var self = $('#cut_noe_'+id);
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(cut_aspd.length == 0){
            var timer;
            clearTimeout(timer);
            var self = $('#cut_aspd_'+id);
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(cut_nowd.length == 0){
            var timer;
            clearTimeout(timer);
            var self = $('#cut_nowd_'+id);
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(cut_nowd && cut_aspd && cut_noe && cut_pcpd){
            var cut_noe = $('#cut_noe_'+id).val();
            var cut_aspd = $('#cut_aspd_'+id).val();
            var cut_nowd = $('#cut_nowd_'+id).val();
            var cut_pcpd = $('#cut_pcpd_'+id).val();
            var result = 0; 
            result = cut_aspd / cut_nowd;
            result1 = result * cut_noe;
            var number = Math.trunc(result1);
            var final = number.toLocaleString();
            $("#cut_pds_"+id).val(final);
            var final1 = number / cut_pcpd;
            var final1nUm = Math.trunc(final1);
            $("#cut_dlo_"+id).val(final1nUm);
        }
        $('#StrengthDisp3').delay(4000).fadeOut(600); 
    });
    $(".calculate1").keyup(function(){
        var id = $(this).attr("data-id");
        var ilo = $('#cut_ilo_'+id).val();
        if(ilo.length == 0){
            var timer;
            clearTimeout(timer);
            var ilo = $('#cut_ilo_'+id);
            ilo.css('border-color', 'red');
            timer = setTimeout(function(){
                ilo.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(ilo){
            var ilo = $('#cut_ilo_'+id).val();
            var dlo = $('#cut_dlo_'+id).val();
            if(dlo.length>0){
                var final2 = dlo * ilo / 100;
                $("#cut_cilo_"+id).val(final2);
            }
            else{
                var self = $('#cut_dlo_'+id);
                self.css('border-color', 'red');
                timer = setTimeout(function(){
                    self.css('border-color', '#bfbfbf');
                }, 3000);
            }
        }
        $('#StrengthDisp3').delay(4000).fadeOut(600); 
    });
    $(".calculate2").keyup(function(){
        var id = $(this).attr("data-id");
        var foh = $('#cut_foh_'+id).val();
        if(foh.length == 0){
            var timer;
            clearTimeout(timer);
            var foh = $('#cut_foh_'+id);
            foh.css('border-color', 'red');
            timer = setTimeout(function(){
                foh.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(foh){
            var foh = $('#cut_foh_'+id).val();
            var dlo = $('#cut_dlo_'+id).val();
            if(dlo.length>0){
                var final3 = 0;
                var final4 = 0;
                var final2 = dlo * foh / 100;
                $("#cut_ilOh_b_"+id).val(final2); 
                
                var cut_dlo = $('#cut_dlo_'+id).val();
                var cut_cilo = $('#cut_cilo_'+id).val();
                var cut_ilOh_b = $('#cut_ilOh_b_'+id).val();
                var final3 = parseInt(cut_cilo)+parseInt(cut_dlo)+parseInt(cut_ilOh_b);
                $("#cut_t_oh_"+id).val(final3);
            }
            else{
                var self = $('#cut_cilo_'+id);
                self.css('border-color', 'red');
                timer = setTimeout(function(){
                    self.css('border-color', '#bfbfbf');
                }, 3000);
            }
        }
        $('#StrengthDisp3').delay(4000).fadeOut(600); 
    // });
    // $("#cut_foh").keyup(function(){
        var id = $(this).attr("data-id");
        var ilo = $('#cut_t_oh_'+id).val();
        var temp = 2500; 
        if(ilo.length == 0){
            var timer;
            clearTimeout(timer);
            var ilo = $('#cut_t_oh_'+id);
            ilo.css('border-color', 'red');
            timer = setTimeout(function(){
                ilo.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(ilo.length>0){
            $("#cut_cap_"+id).val(temp);

            var cut_cap = $("#cut_cap_"+id).val();
            var cut_pds = $("#cut_pds_"+id).val();
            var cut_pds1 = cut_pds.replace(/,/g, '');
            var cal = cut_pds1 / cut_cap;
            $("#cut_dlo_a_"+id).val(Math.trunc(cal));

            var cut_dlo_a = $("#cut_dlo_a_"+id).val();
            var cut_ilo = $("#cut_ilo_"+id).val();         
            var final2 = cut_dlo_a * cut_ilo / 100;
            $("#cut_ilo_a_"+id).val(final2);

            var cut_dlo_a = $("#cut_dlo_a_"+id).val();
            var cut_foh = $("#cut_foh_"+id).val();          
            var final22 = cut_dlo_a * cut_foh / 100;
            $("#cut_dlo_b_"+id).val(final22);

            var cut_dlo_a = $("#cut_dlo_a_"+id).val();
            var cut_ilo_a = $("#cut_ilo_a_"+id).val();
            var cut_dlo_b = $("#cut_dlo_b_"+id).val();
            var final222 = parseInt(cut_dlo_a)+parseInt(cut_ilo_a)+parseInt(cut_dlo_b);
            $("#cut_toh_"+id).val(final222);

            var cut_t_oh = $("#cut_t_oh_"+id).val();
            var cut_toh = $("#cut_toh_"+id).val();
            var final2222 = parseInt(cut_toh) - parseInt(cut_t_oh);
            $("#cut_uaOh_"+id).val(final2222);
        }
        $('#StrengthDisp3').delay(4000).fadeOut(600); 
    });
</script>
@endsection