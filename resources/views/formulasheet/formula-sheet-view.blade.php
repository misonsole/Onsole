@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
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
                        <div class="form-group row py-0 mb-0">
                            <div class="col-sm-12 col-md-12">
                                <span id="StrengthDisp3" style="font-size: 15px !important;" class="badge displayBadgess text-light py-3 mt-2"></span> 
                            </div>
                        </div>
                        <div class="form-group row py-0">
                        <form action="{{url('formula-sheet-update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                            @if(!$cuttingData)
                            @else
                            @foreach($cuttingData as $data)
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
                                            <input readonly type="text" value="{{$data->pcpd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="cutting" id="cut_pcpd_cutting" name="cut_pcpd_cutting">
                                            <input type="text" value="Cutting" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_cutting" name="cut_dep_cutting" hidden>
                                            <input type="text" value="{{$id}}" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="id" name="id" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->noe}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="cutting" id="cut_noe_cutting" name="cut_noe_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->aspd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="cutting" id="cut_aspd_cutting" name="cut_aspd_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input readonly type="number" value="{{$data->nowd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="cutting" id="cut_nowd_cutting" name="cut_nowd_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly type="text" value="{{$data->pds}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_cutting" name="cut_pds_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_cutting" name="cut_dlo_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input readonly type="number" value="{{$data->ilo}}" class="form-control py-2 yourclass text-center calculate1" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="cutting" id="cut_ilo_cutting" name="cut_ilo_cutting">  
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_cutting" name="cut_cilo_cutting">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input readonly type="number" value="{{$data->foh}}" class="form-control py-2 yourclass text-center calculate2" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="cutting" id="cut_foh_cutting" name="cut_foh_cutting">    
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                    
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_cutting" name="cut_ilOh_b_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_cutting" name="cut_t_oh_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" value="{{$data->capacity}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_cutting" name="cut_cap_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_cutting" name="cut_dlo_a_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_cutting" name="cut_ilo_a_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_cutting" name="cut_dlo_b_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_cutting" name="cut_toh_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->un_a_oh}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_cutting" name="cut_uaOh_cutting">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Cutting" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endforeach
                            @endif

                            @if(!$StitchingData)
                            @else
                            @foreach($cuttingData as $data)
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
                                            <input readonly type="number" value="{{$data->pcpd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="sti" id="cut_pcpd_sti" min="0" oninput="this.value = Math.abs(this.value)" name="cut_pcpd_sti">
                                            <input type="text" value="Stitching" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_sti" name="cut_dep_sti" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->noe}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="sti" id="cut_noe_sti" name="cut_noe_sti">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->aspd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="sti" id="cut_aspd_sti" name="cut_aspd_sti">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input readonly type="number" value="{{$data->nowd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="sti" id="cut_nowd_sti" name="cut_nowd_sti">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly value="{{$data->pds}}"  type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_sti" name="cut_pds_sti">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_sti" name="cut_dlo_sti">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" value="{{$data->ilo}}" class="form-control py-2 yourclass text-center calculate1" data-id="sti" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_sti" name="cut_ilo_sti">  
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_sti" name="cut_cilo_sti">
                                        </td>
                                        <td style="border-top: none; padding-top: 2%; width: 10%" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input readonly type="number" value="{{$data->foh}}"  class="form-control py-2 yourclass text-center calculate2" data-id="sti" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_foh_sti" name="cut_foh_sti">    
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                         
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text"  value="{{$data->idloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_sti" name="cut_ilOh_b_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_sti" name="cut_t_oh_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" value="{{$data->capacity}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_sti" name="cut_cap_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_sti" name="cut_dlo_a_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_sti" name="cut_ilo_a_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_sti" name="cut_dlo_b_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_sti" name="cut_toh_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->un_a_oh}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_sti" name="cut_uaOh_sti">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Stitching" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endforeach
                            @endif

                            @if(!$LastingData)
                            @else
                            @foreach($LastingData as $data)
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
                                            <input readonly type="number" value="{{$data->pcpd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="last" id="cut_pcpd_last" min="0" oninput="this.value = Math.abs(this.value)" name="cut_pcpd_last">
                                            <input type="text" value="Lasting" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_last" name="cut_dep_last" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->noe}}"  class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="last" id="cut_noe_last" name="cut_noe_last">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input readonly type="number"  value="{{$data->aspd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="last" id="cut_aspd_last" name="cut_aspd_last">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input readonly type="number" value="{{$data->nowd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="last" id="cut_nowd_last" name="cut_nowd_last">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly type="text" value="{{$data->pds}}"  class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_last" name="cut_pds_last">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_last" name="cut_dlo_last">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input readonly type="number" value="{{$data->ilo}}" class="form-control py-2 yourclass text-center calculate1" data-id="last" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_last" name="cut_ilo_last">  
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_last" name="cut_cilo_last">
                                        </td>
                                        <td style="border-top: none; padding-top: 2%; width: 10%" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input readonly type="number" value="{{$data->foh}}" class="form-control py-2 yourclass text-center calculate2" data-id="last" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_foh_last" name="cut_foh_last">    
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                            
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_last" name="cut_ilOh_b_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_last" name="cut_t_oh_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" value="{{$data->capacity}}"  class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_last" name="cut_cap_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text"  value="{{$data->dloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_last" name="cut_dlo_a_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_last" name="cut_ilo_a_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh3}}"  class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_last" name="cut_dlo_b_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text"  value="{{$data->t_oh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_last" name="cut_toh_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->un_a_oh}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_last" name="cut_uaOh_last">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Lasting" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endforeach
                            @endif

                            @if(!$ClosingData)
                            @else
                            @foreach($ClosingData as $data)
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
                                            <input readonly type="number" value="{{$data->pcpd}}"  class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="clo" id="cut_pcpd_clo" min="0" oninput="this.value = Math.abs(this.value)" name="cut_pcpd_clo">
                                            <input type="text" value="Closing" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_clo" name="cut_dep_clo" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->noe}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="clo" id="cut_noe_clo" name="cut_noe_clo">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->aspd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="clo" id="cut_aspd_clo" name="cut_aspd_clo">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input readonly type="number" value="{{$data->nowd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="clo" id="cut_nowd_clo" name="cut_nowd_clo">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly type="text" value="{{$data->pds}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_clo" name="cut_pds_clo">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_clo" name="cut_dlo_clo">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input type="number" value="{{$data->ilo}}" class="form-control py-2 yourclass text-center calculate1" data-id="clo" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_clo" name="cut_ilo_clo">  
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_clo" name="cut_cilo_clo">
                                        </td>
                                        <td style="border-top: none; padding-top: 2%; width: 10%" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input readonly type="number" value="{{$data->foh}}" class="form-control py-2 yourclass text-center calculate2" data-id="clo" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_foh_clo" name="cut_foh_clo">    
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                         
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_clo" name="cut_ilOh_b_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_clo" name="cut_t_oh_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" value="{{$data->capacity}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_clo" name="cut_cap_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_clo" name="cut_dlo_a_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_clo" name="cut_ilo_a_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_clo" name="cut_dlo_b_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_clo" name="cut_toh_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->un_a_oh}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_clo" name="cut_uaOh_clo">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Closing" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endforeach
                            @endif

                            @if(!$LaminationData)
                            @else
                            @foreach($LaminationData as $data)
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
                                            <input readonly type="number" value="{{$data->pcpd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="lam" id="cut_pcpd_lam" min="0" oninput="this.value = Math.abs(this.value)" name="cut_pcpd_lam">
                                            <input type="text" value="Lamination" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_lam" name="cut_dep_lam" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->noe}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="lam" id="cut_noe_lam" name="cut_noe_lam">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->aspd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="lam" id="cut_aspd_lam" name="cut_aspd_lam">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input readonly type="number" value="{{$data->nowd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="lam" id="cut_nowd_lam" name="cut_nowd_lam">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly value="{{$data->pds}}" type="text" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_lam" name="cut_pds_lam">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh1}}"  class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_lam" name="cut_dlo_lam">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input readonly type="number" value="{{$data->ilo}}"  class="form-control py-2 yourclass text-center calculate1" data-id="lam" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_lam" name="cut_ilo_lam">  
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;" >
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_lam" name="cut_cilo_lam">
                                        </td>
                                        <td style="border-top: none; padding-top: 2%; width: 10%" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input readonly type="number"  value="{{$data->foh}}" class="form-control py-2 yourclass text-center calculate2" data-id="lam" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_foh_lam" name="cut_foh_lam">    
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                            
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_lam" name="cut_ilOh_b_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_lam" name="cut_t_oh_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" value="{{$data->capacity}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_lam" name="cut_cap_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_lam" name="cut_dlo_a_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_lam" name="cut_ilo_a_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_lam" name="cut_dlo_b_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_lam" name="cut_toh_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->un_a_oh}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_lam" name="cut_uaOh_lam">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Lamination" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endforeach
                            @endif

                            @if(!$PackingData)
                            @else
                            @foreach($PackingData as $data)
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
                                            <input readonly type="number" value="{{$data->pcpd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="p" id="cut_pcpd_p" min="0" oninput="this.value = Math.abs(this.value)" name="cut_pcpd_p">
                                            <input type="text" value="Packing" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf;" id="cut_dep_p" name="cut_dep_p" hidden>
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->noe}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="p" id="cut_noe_p" name="cut_noe_p">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Avg. Salary Per <br> Employee</b></label>
                                            <input readonly type="number" value="{{$data->aspd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="p" id="cut_aspd_p" name="cut_aspd_p">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">No. of <br> Working Days</b></label>
                                            <input readonly type="number" value="{{$data->nowd}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" data-id="p" id="cut_nowd_p" name="cut_nowd_p">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Dept. Per Day <br> Salary</b></label>
                                            <input readonly type="text" value="{{$data->pds}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_pds_p" name="cut_pds_p">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Direct Labor <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_p" name="cut_dlo_p">
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>                                     
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input readonly type="number" value="{{$data->ilo}}" class="form-control py-2 yourclass text-center calculate1" data-id="p" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_p" name="cut_ilo_p">  
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                               
                                        </td>
                                        <td style="border-top: none; width: 10%; padding-top: 2%;">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cilo_p" name="cut_cilo_p">
                                        </td>
                                        <td style="border-top: none; padding-top: 2%; width: 10%" class="pr-4">
                                            <label><b style="color: #ffffff;">FOH</b> <br> <b style="color: #1c2d41;">D </b> </label>
                                            <div class="form-group mb-0"> 
                                                <div class="input-group">
                                                    <input readonly type="number" value="{{$data->foh}}" class="form-control py-2 yourclass text-center calculate2" data-id="p" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_foh_p" name="cut_foh_p">    
                                                    <span class="input-group-append">
                                                        <button style="box-shadow: none; border: 1px solid white; background: #1c2d41;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                    </span>
                                                </div>                                                    
                                            </div>                                          
                                        </td>
                                    </tr>                                  
                                    <tr id="ccolorDivtr" class="bg-dark">                                                                            
                                        <td style="border-top: none; padding-bottom: 2%;" class="pl-4">
                                            <label><b style="color: #ffffff;">Indirect Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilOh_b_p" name="cut_ilOh_b_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh1}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_t_oh_p" name="cut_t_oh_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Capacity <br> <b style="color: #1c2d41;">D </b> </b></label>
                                            <input readonly type="text" value="{{$data->capacity}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_cap_p" name="cut_cap_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_a_p" name="cut_dlo_a_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">In-Direct <br> Lab OH</b></label>
                                            <input readonly type="text" value="{{$data->idloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_ilo_a_p" name="cut_ilo_a_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Direct Lab <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->dloh3}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_dlo_b_p" name="cut_dlo_b_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;">
                                            <label><b style="color: #ffffff;">Total <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->t_oh2}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_toh_p" name="cut_toh_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #ffffff;">Un-Absorbed <br> OH</b></label>
                                            <input readonly type="text" value="{{$data->un_a_oh}}" class="form-control py-2 yourclass text-center calculate" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: bold;" id="cut_uaOh_p" name="cut_uaOh_p">
                                        </td>
                                        <td style="border-top: none; padding-bottom: 2%;" class="pr-4">
                                            <label><b style="color: #1c2d41;">D</b><br><b style="color: #1c2d41;">D</b></label>
                                            <input readonly value="Packing" class="form-control py-2 yourclass text-center" style="border: 1px solid #bfbfbf; background: round; color: white; font-weight: 400;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @endforeach
                            @endif
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