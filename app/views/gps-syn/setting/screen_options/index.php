<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title; ?></h5>

                    <div class="ibox-tools">

                        <a class="collapse-link" href="<?php echo base_url('gps-syn/setting/screen_options/create'); ?>"><i class="fa fa-plus-circle"></i> Create New Screen option</a>

                    </div>
                </div>

                <div class="ibox-content">

                    <?php if (!empty($this->session->flashdata('removed'))) {?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('removed'); ?>
                        </div>
                    <?php }?>
<?php if (!empty($this->session->flashdata('success'))) {?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php }?>
<?php if (!empty($this->session->flashdata('failure'))) {?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('failure'); ?>
                        </div>
                    <?php }?>

                    <input type="text" class="form-control input-sm m-b-xs" id="filter"
                           placeholder="Search in table">

                    <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Province</th>
                                <th>Zoom</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th data-hide="phone,tablet">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (count($query)): ?>
<?php $i = 1;?>
<?php foreach ($query as $row): ?>
                                <tr class="gradeX">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo ucfirst($row->first_name); ?></td>
                                    <td><?php echo ucfirst($row->prvin_desc_en); ?></td>
                                    <td><?php echo ucfirst($row->zoom); ?></td>
                                    <td><?php echo ucfirst($row->opt_latitude); ?></td>
                                    <td><?php echo ucfirst($row->opt_longitude); ?></td>

                                    <td class="center">
                                        <a class='delete-confirm' data-href="<?php echo base_url('gps-syn/setting/screen_options/delete/' . $row->opt_id); ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <?php //echo anchor('gps-syn/setting/screen_options/delete/' . $row->opt_id , '<i class="fa fa-trash" aria-hidden="true"></i>') ;;;;;;;;;;;;?> &nbsp;
                                        <?php echo anchor('gps-syn/setting/screen_options/edit/' . $row->opt_id, '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>'); ?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
<?php endif;?>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
