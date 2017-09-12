<div id="map_canvas"></div>
<a class="btn btn-default btn-gps" target="_blank" href="http://203.217.171.133:8082">
    GPS Tracker
</a>
<aside id="color-helper">
    <input type="hidden" name="province" value="<?php echo $this->session->userdata('prvin_id'); ?>" id="branch_province">
    <ul>
        <li>
            <a href="#" class="entypo-overdue_in_30_days item_in_day" data-start="1" data-end="30" data-toggle="modal" data-target="#overduemodal"> 30 <span>Overdue 1-30 days</span>
            </a>
        </li>
        <li>
            <a href="#" class="entypo-overdue_in_60_days item_in_day" data-start="31" data-end="60" data-toggle="modal" data-target="#overduemodal"> 60 <span> Overdue 31-60 days</span>
            </a>
        </li>
        <li>
            <a href="#" class="entypo-overdue_in_90_days item_in_day" data-start="61" data-end="90" data-toggle="modal" data-target="#overduemodal"> 90 <span> Overdue 61-90 days</span>
            </a>
            </li>
        <li>
            <a href="#" class="entypo-overdue_over_91_days item_in_day" data-start="91" data-toggle="modal" data-target="#overduemodal">
            91 <span> Overdue Over 90 days</span>
            </a>
        </li>
        <li>
            <a href="#" class="entypo-no_overdue item_in_day" data-start="0" data-toggle="modal" data-target="#overduemodal"> 0 <span> No Overude </span>
            </a>
        </li>
        <li>
            <a href="#" class="entypo-search btn_search" data-toggle="modal" data-target="#searchmodal"> <i class="fa fa-search-plus" aria-hidden="true"></i> <span> Advance search </span>
            </a>
        </li>
        <li>
            <a href="#" class="entypo-fcc-o btn_fco_item" data-toggle="modal" data-target="#commentmodal"> <i class="fa fa-money" aria-hidden="true"></i> <span> Lessee Paid </span>
            </a>
        </li>
        <li>
            <a href="#" class="entypo-leasee-comment btn_leasee_comment" data-toggle="modal" data-target="#commentmodal"> <i class="fa fa-comment-o" aria-hidden="true"></i> <span> Lessee Commnent </span>
            </a>
        </li>
        <li><a href="#" class="entypo-refrash btn_fresh"> <i class="fa fa-refresh"></i> <span> Refresh </span></a></li>
        <li><a href="<?php echo base_url('gps-syn/dashboard'); ?>" class="entypo-dashboard"> <i class="fa fa-th-large"></i> <span> Dashboard </span></a></li>
        <li><a href="<?php echo base_url('gps-syn/auth/user/logout'); ?>" class="entypo-logout"> <i class="fa fa-sign-out"></i> <span> Logout </span></a></li>
    
    </ul>
</aside>

<!-- Modal  Overdue -->
<div class="modal fade" id="overduemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div class="row m-t-lg">
                    <div class="col-lg-12">
                        <div class="tabs-container">

                            <div class="tabs-left">
                                <ul class="nav nav-tabs">
                                    <li id="province_tab" class="active"><a data-toggle="tab" href="#tab_province">Province</a></li>
                                    <li id="district_tab" class=""><a data-toggle="tab" href="#tab_district">District</a></li>
                                    <li id="commune_tab" class=""><a data-toggle="tab" href="#tab_commune">Commune</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab_province" class="tab-pane active">
                                        <div class="panel-body">
                                                <table id="provinceoverdue" class="table table-hover" cellspacing="0" width="100%">

                                                </table>
                                        </div>
                                    </div>
                                    <div id="tab_district" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="col-xs-12">
                                                <?php
                                                    $prvin = listData('tu_province', 'prvin_id', 'prvin_desc_en', '[ Select Province ]');
                                                    echo form_dropdown('prvin', $prvin, set_value('prvin'), 'class="form-control input-sm prvin_id"  required = "required"');
                                                ?>
                                                <table id="districtoverdue" class="table table-hover" cellspacing="0" width="100%">

                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tab_commune" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="col-xs-6">
                                                <?php
                                                    $prvin = listData('tu_province', 'prvin_id', 'prvin_desc_en', '[ Select Province ]');
                                                    echo form_dropdown('prvin', $prvin, set_value('prvin'), 'class="form-control input-sm prvin_id"  required = "required" datase');
                                                ?>
                                            </div>
                                            <div class="col-xs-6">
                                                <?php
                                                    echo form_dropdown('distr', ['' => '[Select District]'], set_value('distr'), 'class="form-control input-sm distr_id"');
                                                ?>
                                            </div>
                                            <div class="col-xs-12">
                                                <table id="communeoverdue" class="table table-hover" cellspacing="0" width="100%">

                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="searchmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Search Lessee Overdue</h4>
            </div>
            <div class="modal-body">
                <div class="row m-t-lg">
                    <div class="col-lg-12">
                        <div class="tabs-container">

                            <div class="tabs-left">
                                <ul class="nav nav-tabs">
                                    <li id="province_tab_search" class="active"><a data-toggle="tab" href="#tab_province_search">Province</a></li>
                                    <li id="district_tab_search" class=""><a data-toggle="tab" href="#tab_district_search">District</a></li>
                                    <li id="commune_tab_search" class=""><a data-toggle="tab" href="#tab_commune_search">Commune</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab_province_search" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="col-xs-12">
                                                <span id="err_start_p" class="text-danger"></span>
                                                <form id="searchprovince">
                                                    <div class="row">
                                                    <div class="form-group col-xs-5">
                                                        <input type="number" class="form-control" name="startdate_p" placeholder="Start Date" required="reuired">
                                                    </div>
                                                    <div class="form-group col-xs-5">
                                                        <input type="number" class="form-control" name="enddate_p" placeholder="End Date" required="reuired">
                                                    </div>
                                                    <button type="submit" class="btn btn-default col-xs-2">Submit</button>
                                                </div>
                                                </form>
                                            <table id="provinceoverduesearch" class="table table-hover" cellspacing="0" width="100%">

                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab_district_search" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="col-xs-12">
                                                <span id="err_start_d" class="text-danger"></span>
                                                <form id="searchdistrict">
                                                    <div class="row">
                                                    <div class="form-group col-xs-12">
                                                    <?php
                                                        $prvin = listData('tu_province', 'prvin_id', 'prvin_desc_en', '[ Select Province ]');
                                                        echo form_dropdown('prvin', $prvin, set_value('prvin'), 'class="form-control input-sm prvin_id" id="province_select"  required = "required"');
                                                    ?>
                                                    </div>
                                                    </div><!--/row-->
                                                    <div class="row">
                                                    <div class="form-group col-xs-5">
                                                        <input type="number" class="form-control input-sm" name="startdate_d" placeholder="Start Date" required="reuired">
                                                    </div>
                                                    <div class="form-group col-xs-5">
                                                        <input type="number" class="form-control input-sm" name="enddate_d" placeholder="End Date" required="reuired">
                                                    </div>
                                                    <button type="submit" class="btn btn-default btn-sm">Submit</button>
                                                    </div><!--/row-->
                                                </form>

                                                <table id="districtoverduesearch" class="table table-hover" cellspacing="0" width="100%">

                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tab_commune_search" class="tab-pane">
                                        <div class="panel-body">
                                            <span id="err_start_c" class="text-danger"></span>
                                            <form id="searchcommune">
                                                <div class="row">
                                                    <div class="form-group  col-xs-6">
                                                        <?php
                                                            $prvin = listData('tu_province', 'prvin_id', 'prvin_desc_en', '[ Select Province ]');
                                                            echo form_dropdown('prvin', $prvin, set_value('prvin'), 'class="form-control input-sm prvin_id" id="province_select"  required = "required"');
                                                        ?>
                                                    </div>
                                                    <div class="form-group  col-xs-6">
                                                        <?php
                                                            echo form_dropdown('distr', ['' => '[Select District]'], set_value('distr'), 'class="form-control input-sm distr_id" id="district_select" required = "required"');
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                        <div class="form-group col-xs-5">
                                                            <input type="number" class="form-control input-sm" name="startdate_c" placeholder="Start Date" required="reuired">
                                                        </div>
                                                        <div class="form-group col-xs-5">
                                                            <input type="number" class="form-control input-sm" name="enddate_c" placeholder="End Date" required="reuired">
                                                        </div>
                                                        <button type="submit" class="btn btn-default btn-sm">Submit</button>
                                                    </div>
                                                </form>

                                                <table id="communeoverduesearch" class="table table-hover" cellspacing="0" width="100%">

                                                </table>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Comment-->
<div class="modal fade" id="commentmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="commentpaid"></h4>
            </div>
            <div id="comment" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>


<ul class="dialog itm-wrpper warining" title="Color Helper"></ul>
<!--
<ul class="dialog_addr_sort_id" title="Color Helper">
    <button class="btn_sort_addr_by_id">OK</button>
</ul>
-->

