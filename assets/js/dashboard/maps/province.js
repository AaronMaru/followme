$(function() {
    $('#latLng').submit(function(event) {
        event.preventDefault();
        var newLat = $('#newLat').val();
        var newLng = $('#newLng').val();
        if (!newLat.match(/^-?\d+\.?\d*$/)) {
            $('#err_lat').text("Latitude contain text or secial character");
            return false;
        }
        if (!newLng.match(/^-?\d+\.?\d*$/)) {
            $('#err_lng').text("Longitude contain text or secial character");
            return false;
        }
        var url = $(this).attr('action');
        var province_id = $('#province_id').val();

        bootbox.confirm({
            title: "Location Update!",
            message: "Do you wish to change?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'No',
                    className: 'default'
                }
            },
            callback: function(result) {
                if (result == true) {
                    $.post(url, { province_id: province_id, prvin_nu_latitude: newLat, prvin_nu_longitude: newLng }, function(result) {
                        var data = jQuery.parseJSON(result);
                        $('#suc_update_text').text(data.message);
                        $("#suc_update").show();
                        $("#suc_update").fadeOut(3000);
                    });
                }
            }
        });
    });
});
