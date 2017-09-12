<div id="suc_update" class="modalmaru" style="display:none">

  <!-- Modal content -->
  <div class="modalmaru-content" style="width:200px">
    <span class="close">&times;</span>
    <p id="suc_update_text"></p>
  </div>

</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $query->prvin_desc_en; ?></h5>

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
                    <input id="pac-input" type="textbox" class="form-control col-md-2" style="width:20%; margin-top: 5px" placeholder="search place here...">

                    <div id="map"></div>


                    <div style="height: 15px;"></div>
                    <?php echo form_open('gps-syn/maps/province/update/', ['id' => 'latLng', 'data-user' => 'province']); ?>
                        <input type="hidden" name="province_id" id="province_id" value="<?php echo $query->prvin_id; ?>">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Latitude</label>
                            <input type="text" name="prvin_nu_latitude" class="form-control" id="newLat" value="<?php echo $query->prvin_nu_latitude; ?>">

                            <span id="err_lat"class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">longitude </label>
                            <input type="text" name="prvin_nu_longitude" class="form-control" id="newLng" value="<?php echo $query->prvin_nu_longitude; ?>">
                            <span id="err_lng"class="text-danger"></span>
                        </div>

                        <button type="button" id="getLocation" class="btn btn-default">Get Location</button>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-default">Update</button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = "<?php echo base_url(); ?>"
</script>
<script src="<?php echo base_url('assets/js/dashboard/searchmap.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dashboard/maps/province.js'); ?>"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSAzeLH2hBV3O7FOKbHmwd9jKn8fCQPXs&callback=initAutocomplete&libraries=places"></script>
