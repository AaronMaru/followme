



<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Overdue 1 - 30 days</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="close-link"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Overdue 31 - 60 days</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="close-link"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <canvas id="myChart3"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Overdue 61 - 90 days</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="close-link"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <canvas id="myChart4"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Overdue over 90 days</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="close-link"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <canvas id="myChart5"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>No Overdue Day</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        <a class="close-link"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $open_role = '';
    if (!$this->session->userdata('permission')) {
        $open_role = (count($user_role) > 1 ? 'open-choose-role' : '');
    }
    ;
?>
<?php if ($open_role != '') {
    ?>
<!-- Modal -->
<div class="modal fade                                                                                                                                                                                                                                                                                                                     <?php echo $open_role; ?>" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Choose a role </h4>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <?php
                        if ($user_role) {
                            foreach ($user_role as $ur): ?>
                            <a href="<?php echo base_url('/gps-syn/dashboard/log_as/' . $ur->rol_id . '/' . $ur->rol_name); ?>" class="list-group-item">
                            <i class="fa fa-user"></i> &nbsp; Log in as <strong><?php echo @$ur->rol_name; ?></strong></a>
                    <?php endforeach;}?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>
<script type="text/javascript">
    $(function () {

        var overdue = [];
        var province = [];
        $.post('<?php echo base_url(); ?>' + 'maps/province_overdue/',  { start: 0, branch_province :<?php echo $this->session->userdata('prvin_id'); ?>}, function(result) {
            var data = jQuery.parseJSON(result);
            $.each(data.province_overdue, function(index, value) {
                overdue.push(value.overdue);
                province.push(value.prvin_desc_en);
            });
            var data = {
              labels: province,
              datasets: [
                    {
                        label: "No Overdue days",
                        backgroundColor: '#6fe312',
                        data: overdue
                    }
                ]
            };
            var ctx = document.getElementById("myChart").getContext("2d");
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {barValueSpacing: 20}
            });
        });


        var overdue2 = [];
        var province2 = [];
        $.post('<?php echo base_url(); ?>' + 'maps/province_overdue/',  { start: 1, branch_province :<?php echo $this->session->userdata('prvin_id'); ?> }, function(result) {
            var data = jQuery.parseJSON(result);
            $.each(data.province_overdue, function(index, value) {
                overdue2.push(value.overdue);
                province2.push(value.prvin_desc_en);
            });
            var data = {
              labels: province2,
              datasets: [
                    {
                        label: "Overdue 1 - 30 days",
                        backgroundColor: '#f8d11a',
                        data: overdue2
                    }
                ]
            };
            var ctx = document.getElementById("myChart2").getContext("2d");
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {barValueSpacing: 20}
            });
        });

        var overdue3 = [];
        var province3 = [];
        $.post('<?php echo base_url(); ?>' + 'maps/province_overdue/',  { start: 31, branch_province :<?php echo $this->session->userdata('prvin_id'); ?> }, function(result) {
            var data = jQuery.parseJSON(result);
            $.each(data.province_overdue, function(index, value) {
                overdue3.push(value.overdue);
                province3.push(value.prvin_desc_en);
            });
            var data = {
              labels: province3,
              datasets: [
                    {
                        label: "Overdue 31 - 60 days",
                        backgroundColor: '#9c00ff',
                        data: overdue3
                    }
                ]
            };
            var ctx = document.getElementById("myChart3").getContext("2d");
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {barValueSpacing: 20}
            });
        });


        var overdue4 = [];
        var province4 = [];
        $.post('<?php echo base_url(); ?>' + 'maps/province_overdue/',  { start: 61, branch_province :<?php echo $this->session->userdata('prvin_id'); ?>}, function(result) {
            var data = jQuery.parseJSON(result);
            $.each(data.province_overdue, function(index, value) {
                overdue4.push(value.overdue);
                province4.push(value.prvin_desc_en);
            });
            var data = {
              labels: province4,
              datasets: [
                    {
                        label: "Overdue 61 - 90 days",
                        backgroundColor: '#ff0000',
                        data: overdue4
                    }
                ]
            };
            var ctx = document.getElementById("myChart4").getContext("2d");
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {barValueSpacing: 20}
            });
        });


        var overdue5 = [];
        var province5 = [];
        $.post('<?php echo base_url(); ?>' + 'maps/province_overdue/',  { start: 91, branch_province :<?php echo $this->session->userdata('prvin_id'); ?>}, function(result) {
            var data = jQuery.parseJSON(result);
            $.each(data.province_overdue, function(index, value) {
                overdue5.push(value.overdue);
                province5.push(value.prvin_desc_en);
            });
            var data = {
              labels: province5,
              datasets: [
                    {
                        label: "Overdue Over 90 days",
                        backgroundColor: '#e10000',
                        data: overdue5
                    }
                ]
            };
            var ctx = document.getElementById("myChart5").getContext("2d");
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {barValueSpacing: 20}
            });
        });

        $('.open-choose-role').modal('show');
    });
</script>
