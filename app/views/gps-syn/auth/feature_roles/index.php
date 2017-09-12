<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title; ?></h5>

                    <div class="ibox-tools">

                        <a class="collapse-link" href="<?php echo base_url('gps-syn/auth/feature_role/create') ?>">
                        <i class="fa fa-plus-circle"></i> Assign Features to Group Role</a>

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

                    <table class="footable table table-stripped table-hover" data-page-size="8" data-filter=#filter>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Feature</th>
                                <th data-hide="phone,tablet">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (count($result)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($result as $row): ?>
                                <tr class="gradeX">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row->rol_name; ?></td>
                                    <td><?php echo $row->ft_name; ?></td>
                                    <td class="center">
                                        <?php echo anchor('gps-syn/auth/user_role/delete/' . $row->ft_rol_id , '<i class="fa fa-trash" aria-hidden="true"></i>',array('class' => 'delete-confirm')) ?> &nbsp;
                                        <?php echo anchor('gps-syn/auth/user_role/edit/' . $row->ft_rol_id , '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>') ?>
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
