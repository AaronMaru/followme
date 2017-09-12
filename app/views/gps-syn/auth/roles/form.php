<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title;?></h5>

                    <div class="ibox-tools">
 
                        <a href="<?php echo base_url('gps-syn/auth/role')?>" class="close-link">
                            <i class="fa fa-list"></i> Back to list
                        </a>

                    </div>
                </div>
                <div class="ibox-content">

                    <form action="<?php $url = ($action == 'edit'?'update_validate':'save_validate'); echo base_url($module.'/'. $url); ?>" method="POST">
                        <input type="hidden" name="role_id" value="<?php echo @$row[0]->role_id; ?>">
                        <div class="form-group">
                            <label>Role Name</label>
                            <input class="form-control input-sm" type="text" name="rol_name" id="rol_name" placeholder="Role Name" 
                            value="<?php echo (@$row[0]->rol_name != ''? @$row[0]->rol_name : set_value('rol_name')); ?>" />
                            <?php echo form_error('rol_name', '<span class="text-danger">', '</span>'); ?>
                        </div><!--/form-group-->  
                    
                        <div class="row">
                            <div class="col-sm-3 pull-right text-right">
                                <button class="btn btn-default" type="reset">Reset</button>
                                <button class="btn btn-primary"> <?php echo ($action == 'edit'?'Update':'Save'); ?> </button>
                            </div>
                        </div>
                    </form>

                </div><!--/ibox-content-->
            </div>
        </div>
    </div>
</div>
<div class="footer">
