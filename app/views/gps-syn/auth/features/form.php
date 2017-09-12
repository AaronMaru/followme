<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title;?></h5>

                    <div class="ibox-tools">
 
                        <a href="<?php echo base_url('gps-syn/auth/feature')?>" class="close-link">
                            <i class="fa fa-list"></i> Back to list
                        </a>

                    </div>
                </div>
                <div class="ibox-content">

                    <form action="<?php $url = ($action == 'edit'?'update_validate':'save_validate'); echo base_url($module.'/'. $url); ?>" method="POST">
                        <input type="hidden" name="ft_id" value="<?php echo @$row[0]->ft_id; ?>">
                        
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="ft_cate_id">
                                <?php foreach($category as $cate) { ?>
                                    <option value="<?php echo $cate->ft_cate_id; ?>" <?php echo (@$row[0]->ft_cate_id == $cate->ft_cate_id)?'selected':'';  ?>><?php echo $cate->ft_cate_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Feature Url</label>
                            <input class="form-control input-sm" type="text" name="ft_name" id="ft_name" placeholder="Feature url name" 
                            value="<?php echo (@$row[0]->ft_name != ''? @$row[0]->ft_name : set_value('ft_name')); ?>" />
                            <?php echo form_error('ft_name', '<span class="text-danger">', '</span>'); ?>
                        </div><!--/form-group-->  
                        <div class="form-group">
                            <label>Display Name</label>
                            <input class="form-control input-sm" type="text" name="ft_display" id="ft_name" placeholder="Feature display name" 
                            value="<?php echo (@$row[0]->ft_display != ''? @$row[0]->ft_display : set_value('ft_display')); ?>" />
                            <?php echo form_error('ft_display', '<span class="text-danger">', '</span>'); ?>
                        </div>
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
