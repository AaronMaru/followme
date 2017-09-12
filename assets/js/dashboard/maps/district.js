$(function() {
    $(".prvin_id").change(function() {

        var id = $('.prvin_id').val();
        $('#result').text('');
        var table = '';
        $.post(base_url + 'gps-syn/maps/district/prvin/', { id: id }, function(result) {
            var data = jQuery.parseJSON(result);
            $.each(data.district, function(index, value) {
                table += '<tr><td>' + value.distr_desc_en + '</td>';
                table += '<td>' + value.distr_desc + '</td>';
                table += '<td>' + value.distr_nu_latitude + '</td>';
                table += '<td>' + value.distr_nu_longitude + '</td>';
                table += '<td><a href="' + base_url + 'gps-syn/maps/district/edit/' + value.distr_id + '/' + id + '" class="fa fa-pencil-square-o" aria-hidden="true"/></td>';
                table += '</tr>';
            });
            $('#result').append(table);
        });
    });

    $('#latLng').submit(function(event) {
        event.preventDefault();
        var newLat = $('#newLat').val();
        var newLng = $('#newLng').val();
        if (!newLat.match(/^-?\d+\.?\d*$/)) {
            $('#err_lat').text("Latitude is empty or contain text or special characters");
            return false;
        }
        if (!newLng.match(/^-?\d+\.?\d*$/)) {
            $('#err_lng').text("Longitude is empty or contain text or special characters");
            return false;
        }
        var url = $(this).attr('action');
        var district_id = $('#district_id').val();

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
                    $.post(url, { district_id: district_id, distr_nu_latitude: newLat, distr_nu_longitude: newLng }, function(result) {
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
