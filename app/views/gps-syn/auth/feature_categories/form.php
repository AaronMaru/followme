<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title;?></h5>

                    <div class="ibox-tools">
 
                        <a href="<?php echo base_url('gps-syn/auth/feature_category')?>" class="close-link">
                            <i class="fa fa-list"></i> Back to list
                        </a>

                    </div>
                </div>
                <div class="ibox-content">

                    <form action="<?php $url = ($action == 'edit'?'update_validate':'save_validate'); echo base_url($module.'/'. $url); ?>" method="POST">
                        <input type="hidden" name="ft_cate_id" value="<?php echo @$row[0]->ft_cate_id; ?>">
                        <div class="form-group">
                            <label>Feature category name</label>
                            <input class="form-control input-sm" type="text" name="ft_cate_name" id="ft_cate_name" placeholder="Feature category name" 
                            value="<?php echo (@$row[0]->ft_cate_name != ''? @$row[0]->ft_cate_name : set_value('ft_cate_name')); ?>" />
                            <?php echo form_error('ft_cate_name', '<span class="text-danger">', '</span>'); ?>
                        </div><!--/form-group-->  
                        <div class="form-group">
                            <label>Feature category icon </label>
                            <input class="form-control input-sm" type="text" name="ft_icon" id="ft_icon" placeholder="Feature category icon" 
                            value="<?php echo (@$row[0]->ft_icon != ''? @$row[0]->ft_icon : set_value('ft_icon')); ?>" />
                            <?php echo form_error('ft_icon', '<span class="text-danger">', '</span>'); ?>
                            <span>Ex:fa fa-<b>music</b></span>
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
