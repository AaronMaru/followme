var markers = [];

function initAutocomplete() {
    
    /*var map = new google.maps.Map(document.getElementById('map'), {
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
    var iw = new gm.InfoWindow();*/

    // paid();
    // table.destroy();
    list_overdue();
    // setInterval(paid,10000);


    // function paid() {
    //     $.ajax({
    //         dataType: "json",
    //         async: false,
    //         type: "POST",
    //         url: base_url + "maps/get_paid_today",
    //         success: function(data) {
    //             $.each(data.items, function(i, item) {

    //                 markers = new google.maps.Marker({
    //                     position: new google.maps.LatLng(item.lesse_map_latitue, item.lesse_map_longtitue),
    //                     map: map,
    //                     icon: base_url + '/assets/images/icons/markers/fco.png'
    //                 });
    //                 google.maps.event.addListener(markers, 'click', function() {
    //                         var li = '<div class="itm-lst fco-wrapper">'
    //                         li += '<div class="img-fco col-md-6">';

    //                         $.each(data.images, function(i, img) {
    //                             if (img.lesse_id == item.lesse_id) {
    //                                 li += '<a class="fancybox" rel="" data-fancybox="gallery" href="http://192.168.7.8:8080/images/' + img.path + '"><img class="list-paid-img img-left" src="http://192.168.7.8:8080/images/' + img.path + '" ></a>';
    //                             }
    //                         });
    //                         var date = item.dt_cre;
    //                         li += '</div>';
    //                         li += '<div class="copost-right col-md-6">';
    //                         li += '<h6>' + item.civil_code + '. ' + item.perso_va_firstname_en + ' ' + item.perso_va_lastname_en + '</h6>';
    //                         li += '<p><b>Paid</b> : ' + item.lesse_paid + ' </p> ';
    //                         li += '<p><b>Location</b> : ' + item.lesse_location + ' </p> ';
    //                         li += '<p><b>Posted by</b> : ' + item.sec_usr_desc + ' </p>';
    //                         li += '<p><b>Posted Date</b> : ' + item.post_date + ' </p>';
    //                         li += '</div>';
    //                         li += '</div>';

    //                     iw.setContent(li);

    //                     iw.open(map, this);
    //                 });
    //             });
    //         }
    //     });
    // }

    function list_overdue(){
        table = $('#overdue').DataTable({
            ajax: {
                url: base_url + 'maps/province_overdue',
                type: 'POST',
                data: {
                    start: $('#startdate').val(),
                    branch_province: '12'
                },
                dataSrc: 'province_overdue'
            },
            columns:[
              
                { title: 'Province', data: 'prvin_desc_en' },
                { title: 'Overdue', data: 'overdue' },
            ],
            bDestroy: true,
            dom: 'Bfrtip',
            buttons: [
                { extend: 'excel', className: 'btn btn-info btn-lg fa fa-file-excel-o' },
                { extend: 'print', className: 'btn btn-primary btn-lg fa fa-print' }
            ]

        });
    }
}
