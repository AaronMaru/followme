<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title;?></h5>

                    <div class="ibox-tools">
                        <a href="<?php echo base_url('gps-syn/auth/user')?>" class="close-link <?php echo ($check->list != 1)?'hidden':''; ?>">
                            <i class="fa fa-list"></i> Back to list
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                     
                    <?php if(!empty(validation_errors())) { ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo validation_errors(); ?>
                        </div>
                    <?php }
                    ?>
                    <?php if(!empty($this->session->flashdata('success'))) { ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php } ?>
                    <?php if(!empty($this->session->flashdata('failure'))) { ?>
                           <div class="alert alert-danger">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                 <?php echo $this->session->flashdata('failure'); ?>
                           </div>
                    <?php } ?>

                    <?php echo form_open();?>
                        <div class="form-group">
                            <label> Password </label>
                             <input class="form-control input-sm" type="password" name="password" id="password" placeholder="Password">
                        </div><!--/form-group--> 
                        <div class="form-group">
                            <label> Confirm Password </label>
                            <input class="form-control input-sm" type="password" name="conf_password" id="conf_password" placeholder="Confirm Password">
                        </div><!--/form-group--> 
                        <div class="row">
                            <div class="col-sm-3 pull-right text-right">
                                <button class="btn btn-default" type="reset">Reset</button>
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>

                </div><!--/ibox-content-->
            </div>
        </div>
    </div>
</div>
<div class="footer">
