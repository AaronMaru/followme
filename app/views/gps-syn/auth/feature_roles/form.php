<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $main_title;?></h5>

                    <div class="ibox-tools">
 
                        <a href="<?php echo base_url('gps-syn/auth/role')?>" class="close-link">
                            <i class="fa fa-list"></i> Back to role list
                        </a>

                    </div>
                </div>
                <div class="ibox-content">

                    <form action="<?php $url = ($action == 'edit'?'update_validate':'save_validate'); echo base_url($module.'/'. $url); ?>" method="POST">
                        
                        <input type="hidden" name="rol_id" value="<?php echo @$roles[0]->role_id; ?>">
                        
                        <div class="form-group">
                            <label>Group Role name</label>
                            <input type="text" class="form-control" disabled="" name="" value="<?php echo @$roles[0]->rol_name; ?>">
                        </div>
                        <!-- <label class="checkbox-inline i-checks"> <input id="select_all" type="checkbox" name="" value="1"> Select All </label> -->
                        <div class="col-md-12">
                            <table class="table table-borderd table-hover">
                                <thead>
                                    <tr>
                                        <th>Feature</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($ftr as $fr) : ?>
                                    <input type="hidden" class="ft-rol-id" name="ft_rol_id[]" value="<?php echo @$fr->ft_rol_id; ?>">
                                <?php endforeach;

                                foreach($features as $f) : ?>
                                    <tr>
                                    <?php 
                                        $add = '';
                                        $update = '';
                                        $delete = '';
                                        $list = '';
                                        foreach($row as $r) :
                                            if($r->ft_id == $f->ft_id){
                                                $add = ($r->add == 1?'checked':'');
                                                $update = ($r->update == 1?'checked':'');
                                                $delete = ($r->delete == 1?'checked':'');
                                                $list = ($r->list == 1?'checked':'');
                                            }
                                        endforeach;
                                    ?>
                                        <input type="hidden" name="ft_id[]" value="<?php echo $f->ft_id; ?>">

                                        <td><?php echo ucfirst($f->ft_display); ?></td>
                                        <td><label class="checkbox-inline i-checks"> <input type="checkbox" <?= $add; ?> name="action[<?= $f->ft_id; ?>][i]" value="1"> Add </label></td>
                                        <td><label class="checkbox-inline i-checks"> <input type="checkbox" <?= $update; ?> name="action[<?= $f->ft_id; ?>][u]" value="1"> Update </label></td>
                                        <td><label class="checkbox-inline i-checks"> <input type="checkbox" <?= $delete; ?> name="action[<?= $f->ft_id; ?>][d]" value="1"> Delete </label></td>
                                        <td><label class="checkbox-inline i-checks"> <input type="checkbox" <?= $list; ?> name="action[<?= $f->ft_id; ?>][l]" value="1"> List </label></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <br/>
                        <div class="clearfix"></div>
                    
                        <div class="row">
                            <div class="col-sm-3 pull-right text-right">
                                <a href="<?php echo base_url('gps-syn/auth/role')?>" class="close-link btn btn-default">
                                    <i class="fa fa-list"></i> Back to role list
                                </a>

                                <button class="btn btn-primary"> <?php echo ($action == 'edit'?'Update':'Save'); ?> </button>
                            </div>
                        </div>
                    </form>

                </div><!--/ibox-content-->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#select_all').click(function(event) {
            if(this.checked) {
              // Iterate each checkbox
              $(':checkbox').each(function() {
                  this.checked = true;
              });
            }
            else {
            $(':checkbox').each(function() {
                  this.checked = false;
              });
            }
        });
    });
</script>

<div class="footer">
