<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title; ?></h5>

                    <div class="ibox-tools">

                        <a href="<?php echo base_url('gps-syn/setting/screen_options'); ?>" class="close-link">
                            <i class="fa fa-list"></i> Back to list
                        </a>

                    </div>
                </div>
                <div class="ibox-content">

                    <form action="<?php $url = ($action == 'edit' ? 'update_validate' : 'save_validate');
                                  echo base_url($module . '/' . $url);?>" method="POST">
                        <input type="hidden" name="opt_id" value="<?php echo @$row[0]->opt_id; ?>">
                        <div class="form-group">
                            <label>User name</label>
                            <?php
                                $usr_id = listData('tu_gps_syn_usr', 'usr_id', 'first_name', '[ Select User ]');
                                echo form_dropdown('usr_id', $usr_id, (@$row[0]->usr_id != '' ? @$row[0]->usr_id : set_value('usr_id')), 'class="form-control input-sm prvin_id"  required = "required"');
                            ?>

                        </div><!--/form-ground-->
                        <div class="form-group">
                            <label>Province</label>
                            <?php
                                $prvin = listData('tu_province', 'prvin_id', 'prvin_desc_en', '[ Select Province ]');
                                echo form_dropdown('prvin_id', $prvin, (@$row[0]->prvin_id != '' ? @$row[0]->prvin_id : set_value('prvin_id')), 'class="form-control input-sm prvin_id"  required = "required"');
                            ?>
                        </div><!--/form-ground-->
                        <div class="form-group">

                                <label>Zoom</label>
                                <input class="form-control input-sm" type="number" name="zoom"  placeholder="Zoom" required = "required"
                                value="<?php echo (@$row[0]->zoom != '' ? @$row[0]->zoom : set_value('zoom')); ?>" />
                                <?php echo form_error('zoom', '<span class="text-danger">', '</span>'); ?>
                            </div><!--/form-group-->

                            <div class="form-group">
                                <label>Latitude</label>
                                <input class="form-control input-sm" type="text" name="opt_latitude"  placeholder="Latitude" required = "required"
                                value="<?php echo (@$row[0]->opt_latitude != '' ? @$row[0]->opt_latitude : set_value('opt_latitude')); ?>" />
                                <?php echo form_error('opt_latitude', '<span class="text-danger">', '</span>'); ?>
                            </div><!--/form-group-->
                            <div class="form-group">
                                <label>Longitude</label>
                                <input class="form-control input-sm" type="text" name="opt_longitude"  placeholder="Longitude" required = "required"
                                value="<?php echo (@$row[0]->opt_longitude != '' ? @$row[0]->opt_longitude : set_value('opt_longitude')); ?>" />

                        </div><!--/form-group-->

                        <div class="row">
                            <div class="col-sm-3 pull-right text-right">
                                <button class="btn btn-default" type="reset">Reset</button>
                                <button class="btn btn-primary">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php echo ($action == 'edit' ? 'Update' : 'Save'); ?>
                                </button>
                            </div>
                        </div>
                    </form>

                </div><!--/ibox-content-->
            </div>
        </div>
    </div>
</div>
<div class="footer">
