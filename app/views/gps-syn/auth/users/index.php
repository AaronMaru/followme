<?php
    if($check->list != 1) {
        redirect('gps-syn/dashboard?page=no_permission');
    }
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title; ?></h5>

                    <div class="ibox-tools">

                        <a class="collapse-link <?php echo ($check->add != 1)?'hidden':''; ?>" href="<?php echo base_url('gps-syn/auth/user/create') ?>"><i class="fa fa-plus-circle"></i> Create New User</a>

                    </div>
                </div>

                <div class="ibox-content">

                    <?php if(!empty($this->session->flashdata('removed'))) {?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('removed'); ?>
                        </div>
                    <?php } ?>
                    <?php if(!empty($this->session->flashdata('success'))) {?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php } ?>
                    <?php if(!empty($this->session->flashdata('failure'))) {?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('failure'); ?>
                        </div>
                    <?php } ?>

                    <input type="text" class="form-control input-sm m-b-xs" id="filter"
                           placeholder="Search in table">
                    <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th data-hide="phone,tablet">Province</th>

                                <?php if($check->rol_id == 1){ ?>
                                    <th data-hide="phone,tablet">See Group Role</th>
                                <?php } ?>

                                <th data-hide="phone,tablet">Role</th>

                                <th data-hide="phone,tablet">Change password</th>
                                <th data-hide="phone,tablet">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (count($query)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($query as $row): ?>
                                <tr class="gradeX">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row->first_name.' '.$row->last_name; ?></td>
                                    <td><?php echo $row->email; ?></td>
                                    <td><?php echo ( $row->prvin_desc_en );?></td>

                                    <?php if($check->rol_id == 1){ ?>
                                        <td class="center"><?php echo anchor('gps-syn/auth/user_role/list/' .$row->usr_id , '<i class="fa fa-group"></i>') ?></td>
                                    <?php } ?>
                                    <td><?php echo ( $row->rol_name );?></td>
                                    <td class="center"><?php echo anchor('gps-syn/auth/user/change_password/' .$row->usr_id , '<i class="fa fa-key"></i>') ?></td>
                                    <td class="center">
                                        <a class='delete-confirm <?php echo ($check->delete != 1)?'hidden':''; ?>' data-href="<?php echo base_url('gps-syn/auth/user/delete/'.$row->usr_id); ?>">
                                        <i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <?php $edit = ($check->update != 1)?'hidden':''; ?>
                                        <?php echo anchor('gps-syn/auth/user/edit/' . $row->usr_id , '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'class="'.$edit.'"') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <ul class="pagination pull-right"></ul>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
