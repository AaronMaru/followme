<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo $main_title; ?> </h5>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
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
                        <br/>
                    </div>
                        <table id="communeData" class="table table-hover" width="100%" height="100%" style="margin-top: 20px">
                            <thead>
                                <tr>
                                    <th width="25%">Communce_EN</th>
                                    <th width="25%">Communce</th>
                                    <th width="25%">Latitude</th>
                                    <th width="25%">Longitude</th>
                                    <th width="25%">Edit</th>
                                </tr>
                            </thead>
                            <tbody id="result">

                            </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

<script>
    var base_url = "<?php echo base_url(); ?>"
</script>
<script src="<?php echo base_url('assets/js/dashboard/maps/commune.js'); ?>"></script>
