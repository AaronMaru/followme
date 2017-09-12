$(function() {
    var province_id;
    var district_id;
    $(".prvin_id").change(function() {

        province_id = $('.prvin_id').val()
        $.post(base_url + 'gps-syn/maps/commune/listDistrict/',  { id: province_id}, function(result) {
            var opt = '<option value="0"> [Select Districts] </option>';
            var data = jQuery.parseJSON(result);
            $.each(data.district, function(index, value) {
                opt += '<option value="' + value.distr_id + '">';
                opt += value.distr_desc_en;
                opt += '</option>';
            });

            $('select.distr_id').html(opt);
        });

    });

    $(".distr_id").change(function() {
        district_id = $('.distr_id').val()
        $('#result').text('');

        var table = '';
        $.post(base_url + 'gps-syn/maps/commune/listCommune/', {id: district_id}, function(result) {
            var data = jQuery.parseJSON(result);
             $.each(data.commune, function(index, value) {
                table += '<tr><td>' + value.commu_desc_en + '</td>';
                table += '<td>' + value.commu_desc + '</td>';
                table += '<td>' + value.commu_nu_latitude + '</td>';
                table += '<td>' + value.commu_nu_longitude + '</td>';
                table += '<td><a href="' + base_url + 'gps-syn/maps/commune/edit/' + value.commu_id + '/' + district_id + '/' + province_id + '" class="fa fa-pencil-square-o" aria-hidden="true"/></td>';
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
            $('#err_lat').text("Latitude contain text or secial character");
            return false;
        }
        if (!newLng.match(/^-?\d+\.?\d*$/)) {
            $('#err_lng').text("Longitude contain text or secial character");
            return false;
        }
        var url = $(this).attr('action');
        var commune_id = $('#commune_id').val();

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
                    $.post(url, { commune_id: commune_id, commu_nu_latitude: newLat, commu_nu_longitude: newLng }, function(result) {
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
