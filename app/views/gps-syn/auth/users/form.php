
    <div class="col-md-6 col-sm-6 col-xs-12 personal-info">
        <!-- <div class="alert alert-info alert-dismissable">
            <a class="panel-close close" data-dismiss="alert">×</a>
            <i class="fa fa-coffee"></i>
            This is an <strong>.alert</strong>. Use this to show important messages to the user.
        </div> -->
        <h3>Personal info</h3>
        <div class="form-group">
            <label class="control-label">First name:</label>
            <input class="form-control" value="<?php echo @$row[0]->first_name; ?>" type="text" name="firstname">
        </div>
        <div class="form-group">
            <label class="control-label">Last name:</label>
            <input class="form-control" value="<?php echo @$row[0]->last_name; ?>" type="text" name="lastname">
        </div>
        <div class="form-group">
            <label class="control-label">Email:</label>
                <input class="form-control" value="<?php echo @$row[0]->email; ?>" type="email" name="email"<?php echo ($action == "edit") ? 'readonly' : ''; ?> >
        </div>

        <div class="form-group">
            <label class="control-label">Username:</label>
            <input class="form-control" value="<?php echo @$row[0]->username; ?>" name="username" type="text" required="required"<?php echo ($action == "edit") ? 'readonly' : ''; ?> >
        </div>
        <?php if ($action == "create") {?>
            <div class="form-group">
                <label class="control-label">Password:</label>
                <input class="form-control" value="" name="password" type="password" required="required">
                <?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>

            </div>
            <div class="form-group">
                <label class="control-label">Confirm password:</label>
                <input class="form-control" value="" name="passwordconfirmation" type="password">
                <?php echo form_error('passwordconfirmation', '<span class="text-danger">', '</span>'); ?>
            </div>
        <?php }?>
        <div class="form-group">
            <label class="control-label">Select Branch:</label>
            <?php
                $prvin = listData('tu_province', 'prvin_id', 'prvin_desc_en', '[ Select Province ]');
                echo form_dropdown('prvin', $prvin, (isset($row[0]->prvin_id) ? $row[0]->prvin_id : set_value('prvin')), 'class="form-control input-sm prvin_id"  required = "required" datase');
            ?>
        </div>
        <div class="form-group">
            <label class="control-label"></label>
                <input class="btn btn-default" value="Cancel" type="reset">
                <span></span>
                <input class="btn btn-primary" value="<?php echo $main_title; ?>" type="submit">
        </div>
    </div><!--/col-md-8-->
