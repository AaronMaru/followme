<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo $main_title; ?></h5>

            <div class="ibox-tools">

                <a href="<?php echo base_url('gps-syn/auth/user'); ?>" class="close-link <?php echo ($check->list != 1)?'hidden':''; ?>">
                    <i class="fa fa-list"></i> Back to list
                </a>

            </div>
        </div>
        <div class="ibox-content">
            <div class="container" style="padding-top: 60px;">

                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?php echo form_open_multipart('gps-syn/auth/user/upload'); ?>

                        <input class="form-control" value="<?php echo @$row[0]->usr_id; ?>" type="hidden" name="user_id">
                        <?php if ($this->session->flashdata('error')) {?>
                            <div class="alert alert-danger alert-dismissable">
                                <a class="panel-close close" data-dismiss="alert">×</a>
                                <i class="fa fa-thumbs-down"></i>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php }?>
<?php if ($this->session->flashdata('success')) {?>
                            <div class="alert alert-success alert-dismissable">
                                <a class="panel-close close" data-dismiss="alert">×</a>
                                <i class="fa fa-thumbs-up"></i>
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        <?php }?>
                        <div class="text-center">
                            <?php $imgurl = ($action == "edit" && $row[0]->file_name != '') ? base_url('assets/images/uploads/profile/' . $row[0]->file_name) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTxGgJNLXyrAl-FoH4EOENTTqIxqdD5bUwUHuF_H04EV6HawkPH3g';?>
                            <img src="<?php echo $imgurl; ?>" class="avatar img-circle img-thumbnail" alt="avatar" id="preview" width="200px" height="200px">
                            <h6 id="size_err">Maximum file 2 MB</h6>
                            <h6 id="width_err">Maximun width 1024</h6>
                            <h6 id="height_err">Maximun height 768</h6>
                            <input type="file" class="text-center center-block well well-sm" name="profilepicture">
                            <input class="btn btn-primary" value="Upload" type="submit">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
<?php echo form_open('gps-syn/auth/user/update_validate', ['id' => 'latLng']); ?>
                        <input class="form-control" value="<?php echo @$row[0]->usr_id; ?>" type="hidden" name="user_id">
                        <input class="form-control" value="<?php echo @$row[0]->file_ext; ?>" type="hidden" name="file_ext">

                            <?php $this->load->view('gps-syn/auth/users/form');?>
<?php echo form_close(); ?>
                </div><!--row-->

            </div>
        </div>
    </div>
</div>