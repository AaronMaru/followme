


        <div class="footer">
            <div class="pull-right">
                GL Finance First, Fast & Forword.
            </div>
            <div>
                <strong> GL finance </strong> &copy; 2016-<?php echo date('Y'); ?>
            </div>
        </div>

    </div>
</div>

<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title notify-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row notify">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- datatable -->

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.responsive.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.tableTools.min.js'); ?>"></script>


<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js'); ?>"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script> -->
<!-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script> -->
<!-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script> -->







<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>

<!-- Chosen -->
<script src="<?php echo base_url('assets/js/plugins/chosen/chosen.jquery.js'); ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/js/plugins/iCheck/icheck.min.js'); ?>"></script>
<!-- Boobbox js -->
<script src="<?php echo base_url('assets/js/bootbox.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/jquery.fancybox.js'); ?>"></script>
<!-- FooTable -->
<script src="<?php echo base_url('assets/js/plugins/footable/footable.all.min.js'); ?>"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url('assets/js/inspinia.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/pace/pace.min.js'); ?>"></script>
<!-- for map -->


<script type="text/javascript">
/*    inactivityTimeout = false;
    resetTimeout();
    function onUserInactivity() {
       window.location.href = "onUserInactivity.php";
    }
    function resetTimeout() {
       clearTimeout(inactivityTimeout);
       inactivityTimeout = setTimeout(onUserInactivity, 1000 * 180); // 2 minutes
    }
    window.onmousemove = resetTimeout;*/
</script>


<!-- Page-Level Scripts -->
<script>

    var base_url = "<?php echo base_url(); ?>";
    var Image_Server_URL = "<?php echo Image_Server_URL; ?>";
    $(function(){

        $("a.fancybox").fancybox();

        $('.paid-notify').click(function(){

            var paid_id = $(this).attr('data-href');

            $.post(base_url+ '/maps/le_paid_notification', {paid_id:paid_id} ,function(result){
                var data = jQuery.parseJSON(result);
                var rec = '';
                $.each(data.paid, function(i, item) {
                    rec += '<div class="row">';
                    rec += '<div class="col-md-6">';
                    rec += '<div class="carousel slide" id="carousel-example-captions-'+i+'" data-ride="carousel">';
                    rec += '<div class="carousel-inner" role="listbox">';
                    var x = 0;
                    var location = (item.lesse_location == null) ? '' : item.lesse_location;
                    $.each(data.images, function(j, picture) {
                        var active = '';
                        if (item.lesse_id == picture.lesse_id) {
                            if(x == 0) active = 'active';
                            rec += '<div class="item '+active+'">';
                            rec += '<img alt="" data-src="'+Image_Server_URL + picture.path  + '" src="'+Image_Server_URL + picture.path  + '" data-holder-rendered="true">';
                            rec += '</div>';
                            x++;
                        }
                    });
                    rec += '</div>';
                    rec += '<a href="#carousel-example-captions-'+i+'" class="left carousel-control" role="button" data-slide="prev">';
                    rec += '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>';
                    rec += '<a href="#carousel-example-captions-'+i+'" class="right carousel-control" role="button" data-slide="next"> ';
                    rec += '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
                    rec += '<span class="sr-only">Next</span> </a>';
                    rec += '</div>';
                    rec += '</div>';

                    rec += '<div class="col-md-6">';
                    rec += '<h5 style="margin-top: 0;">' + item.civil_code + '. ' + item.perso_va_lastname_en + ' ' + item.perso_va_firstname_en + '</h5>';
                    rec += '<p>Paid : ' + item.lesse_paid + ' </p>';
                    rec += '<p>Location : ' + location + ' </p> ';
                    rec += '<p>Posted by : ' + item.sec_usr_desc + ' </p>';
                    rec += '<p>Posted Date : ' + item.post_date + ' </p>';
                    rec += '</div>';
                    rec += '</div>';

                });
                $('.notify-title').text('Lessee Paid');
                $('.notify').html(rec);

            });
        });

        $('.comment-notify').click(function(){
            var coment_id = $(this).attr('data-href');
            $.post(base_url+ '/maps/le_comment_notification', {coment_id:coment_id} ,function(result){
                var data = jQuery.parseJSON(result);
                var rec = '';
                $.each(data.comments, function(i, item) {
                    rec += '<div class="row">';
                    rec += '<div class="col-md-6">';
                    rec += '<div class="carousel slide" id="carousel-example-captions-'+i+'" data-ride="carousel">';
                    rec += '<div class="carousel-inner" role="listbox">';
                    var x = 0;
                    var location = (item.lesse_location == null) ? '' : item.lesse_location;
                    $.each(data.images, function(j, picture) {
                        var active = '';
                        if (item.lesse_id == picture.lesse_id) {
                            if(x == 0) active = 'active';

                            rec += '<div class="item '+active+'">';
                            rec += '<img alt="" data-src="'+Image_Server_URL + picture.path  + '" src="'+Image_Server_URL + picture.path  + '" data-holder-rendered="true">';
                            rec += '</div>';

                            x++;
                        }
                    });
                    rec += '</div>';
                    rec += '<a href="#carousel-example-captions-'+i+'" class="left carousel-control" role="button" data-slide="prev">';
                    rec += '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>';
                    rec += '<a href="#carousel-example-captions-'+i+'" class="right carousel-control" role="button" data-slide="next"> ';
                    rec += '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
                    rec += '<span class="sr-only">Next</span> </a>';
                    rec += '</div>';
                    rec += '</div>';
                    rec += '<div class="col-md-6">';

                    rec += '<h5 style="margin-top: 0;">' + item.civil_code + '. ' + item.perso_va_lastname_en + ' ' + item.perso_va_firstname_en + '</h5>';
                    rec += '<p>Paid : ' + item.lesse_paid + ' </p>';
                    rec += '<p>Location : ' + location + ' </p> ';
                    rec += '<p>Posted by : ' + item.sec_usr_desc + ' </p>';
                    rec += '<p>Posted Date : ' + item.post_date + ' </p>';
                    rec += '</div>';
                    rec += '</div>';

                });
                $('.notify-title').text('Lessee Comment');
                $('.notify').html(rec);

            });
        });
    });

    var _URL = window.URL || window.webkitURL;
    $(function() {

        $(".metismenu>li.menu").addClass('hidden');
        $(".metismenu li ul li").parents('.metismenu li').removeClass('hidden');

        $('.footable').footable();
        var config = {
            '.chosen-select'           : {width:"100%"},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
            };
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        $('.btn-reset-chosen').click(function() {
        	$('.chosen-select option').each(function(){
			     $(this)[0].selected = false;
			});
			$(".chosen-select").trigger("chosen:updated");
        });
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('input[name="profilepicture"]').change(function(){

        $('#size_err').removeClass("text-danger");
        $('#width_err').removeClass("text-danger");
        $('#height_err').removeClass("text-danger");
        var f = this;
        if(this.files[0].size > 2048000 ){
            $('#size_err').addClass("text-danger");
            return false;
        }
        if ((file = this.files[0])) {
            image = new Image();
            image.onload = function() {
                // alert("The image width is " +this.width + " and image height is " + this.height);
                if(this.width > 1024){
                    $('#width_err').addClass("text-danger");
                    return false;
                }

                readURL(f);
            };
            image.src = _URL.createObjectURL(file);
        }
    });

    $(document).on("click", ".delete-confirm", function(e) {
        var res = false;
        var url = $(this).attr('data-href');
        bootbox.confirm({
            message: "Are you sure want to delete?",
             buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function(result){
                if(result == true) {
                    window.location.href = url;
                }
            }
        });
    });


</script>




</body>

</html>
