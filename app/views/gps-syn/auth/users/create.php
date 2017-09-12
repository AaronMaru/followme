
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
                        <?php echo form_open_multipart('gps-syn/auth/user/save_validate', ['id' => 'latLng']); ?>
                        <?php $this->load->view('gps-syn/auth/users/form');?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
</div>
<div class="footer">
