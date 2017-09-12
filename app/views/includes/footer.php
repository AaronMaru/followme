
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <!--
    <script src="<?php echo base_url('assets/js/plugins/jqGrid/i18n/grid.locale-en.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/jqGrid/jquery.jqGrid.min.js'); ?>"></script>
    -->
    <script src="<?php echo base_url('assets/js/jquery.fancybox.js'); ?>"></script>

    <script src="<?php echo base_url('assets/js/jquery-ui.js'); ?>"></script>
    <script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
        var Image_Server_URL = "<?php echo Image_Server_URL; ?>";
    </script>
    <script src="<?php echo base_url('assets/js/oms.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/markerclusterer.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/map_config.js'); ?>"></script>

    <script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.responsive.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.tableTools.min.js'); ?>"></script>


    <script src="<?php echo base_url('assets/js/plugins/addr_id.js'); ?>"></script>
    <!-- Boobbox js -->
    <script src="<?php echo base_url('assets/js/bootbox.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/scripts.js'); ?>"></script>


    <script>
        //var base_url = "<?php echo base_url(); ?>";
        $( function() {
            $( "#menu" ).menu();
            $("a.fancybox").fancybox();
        } );
    </script>


</body>
</html>







