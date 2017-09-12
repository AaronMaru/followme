var markers = [];

function initAutocomplete() {

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 7,
        center: {
            lat: 11.5793558,
            lng: 104.8137736
        },
        zoomControl: true,
        mapTypeControl: true,
        scaleControl: true,
        streetViewControl: true,
        rotateControl: true,
        fullscreenControl: true
    });

    var gm = google.maps;
    var iw = new gm.InfoWindow();

    comment();
    list_comment();
    setInterval(comment, 10000);

    function comment() {
        $.ajax({
            dataType: "json",
            async: false,
            type: "POST",
            url: base_url + "maps/lessee_comment",
            success: function(data) {
                $.each(data.comments, function(i, item) {

                    markers = new google.maps.Marker({
                        position: new google.maps.LatLng(item.lesse_comment_latitue, item.lesse_comment_longtitue),
                        map: map,
                        icon: base_url + '/assets/images/icons/markers/comment.png'
                    });
                    google.maps.event.addListener(markers, 'click', function() {


                        var li = '<div class="itm-lst fco-wrapper">'
                        li += '<div class="img-fco col-md-6">';

                        $.each(data.pictures, function(i, img) {
                            if (img.lesse_comment_id == item.lesse_comment_id) {
                                li += '<a class="fancybox" rel="" data-fancybox="gallery" href="' + Image_Server_URL + img.path + '"><img class="img-left" src="' + Image_Server_URL + img.path + '" ></a>';
                            }
                        });
                        var date = item.dt_cre;
                        li += '</div>';
                        li += '<div class="copost-right  col-md-6">';
                        li += '<h6>' + item.civil_code + '. ' + item.perso_va_firstname_en + ' ' + item.perso_va_lastname_en + '</h6>';
                        li += '<p><b>Comment</b> : ' + item.comme_va_desc + ' </p> ';
                        li += '<p><b>Location</b> : ' + item.lesse_comment_location + ' </p> ';
                        li += '<p><b>Posted by</b> : ' + item.sec_usr_desc + ' </p>';
                        li += '<p><b>Posted Date</b> : ' + item.post_date + ' </p>';
                        li += '</div>';
                        li += '</div>';


                        iw.setContent(li);

                        iw.open(map, this);
                    });
                });
            }
        });
    }

    function list_comment() {
        table = $('#comment').DataTable({
            ajax: {
                url: base_url + 'maps/lessee_comment',
                type: 'POST',
                dataSrc: 'comments',
            },
            columns: [
                { title: 'ID', data: 'id' },
                { title: 'Lessee Name', data: 'lessee_name' },
                { title: 'Description', data: 'comme_va_desc' },
                { title: 'Location', data: 'lesse_comment_location' },
                { title: 'Post By', data: 'sec_usr_desc' },
                { title: 'Post Date', data: 'post_date' }
            ],
            responsive: true

        });
    }
}
