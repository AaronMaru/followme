<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title; ?></h5>

                    <div class="ibox-tools">

                        <a class="collapse-link" href="<?php echo base_url('gps-syn/auth/user_role/create/'.@$user[0]->usr_id) ?>">
                        <i class="fa fa-plus-circle"></i> Assign New User Role</a>

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

                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" class="form-control" disabled="" value="<?php echo @$user[0]->first_name. ' ' .@$user[0]->last_name; ?>">
                    </div>
                    <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th data-hide="phone,tablet">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (count($result)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($result as $row): ?>
                                <tr class="gradeX">
                                    <td><?php echo $i++; ?></td>
                                    <!-- <td><?php //echo $row->first_name; ?></td> -->
                                    <td><?php echo $row->rol_name; ?></td>
                                    <td class="center">
                                        <a class='delete-confirm' data-href="<?php echo base_url('gps-syn/auth/user_role/delete/' . $row->usr_rol_id.'/'.@$user[0]->usr_id); ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <?php //echo anchor('gps-syn/auth/user_role/delete/' . $row->usr_rol_id , '<i class="fa fa-trash" aria-hidden="true"></i>') ?> &nbsp;
                                        <?php //echo anchor('gps-syn/auth/user_role/edit/' . $row->usr_rol_id , '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
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
