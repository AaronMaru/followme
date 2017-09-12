<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title;?></h5>

                    <div class="ibox-tools">
 
                        <a href="<?php echo base_url('gps-syn/auth/user')?>" class="close-link">
                            <i class="fa fa-list"></i> Back to list
                        </a>

                    </div>
                </div>
                <div class="ibox-content">

                    <form action="<?php $url = ($action == 'edit'?'update_validate':'save_validate'); echo base_url($module.'/'. $url); ?>" method="POST">
                        
                            <input type="hidden" name="usr_rol_id" value="<?php echo @$row[0]->usr_rol_id; ?>">

                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control" disabled="" value="<?php echo @$user[0]->first_name; ?>">
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo @$user[0]->usr_id; ?>">
                        <div class="form-group">
                            <label>Role Name</label>
                            <select name="role_id[]" data-placeholder="Choose a user..." class="chosen-select" multiple="" tabindex="2" >
                                <option value=""> -- Select roles -- </option>
                                <?php foreach($roles as $r) : ?>
                                <option value="<?php echo $r->role_id; ?>" <?php echo (set_value('role_id[]') == $r->role_id || $r->role_id == @$row[0]->role_id ?'selected':''); ?>><?php echo $r->rol_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('role_id[]', '<span class="text-danger">', '</span>'); ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 pull-right text-right">
                                <button class="btn btn-default btn-reset-chosen" type="reset">Reset</button>
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
