<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lessee Overdue</h5>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <!-- <div class="row">
                        <div class="col-sm-12">
                            <div id="map"></div>
                        </div>
                    </div> -->
                    <input type="hidden" value="<?php echo $start; ?>" id="startdate">
                    <div style="height: 20px;"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="overdue" class="table table-hover" cellspacing="0" width="100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = "<?php echo base_url(); ?>"
</script>
<script src="<?php echo base_url('assets/js/dashboard/searchmap.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dashboard/overdue/inday.js'); ?>"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSAzeLH2hBV3O7FOKbHmwd9jKn8fCQPXs&callback=initAutocomplete&libraries=places"></script>
