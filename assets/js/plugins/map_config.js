




 window.onload = function () {

    var json;
    var zoom;
    var cen_lat;
    var cen_lon;

    $.ajax({
        dataType: "json",
        url: base_url + "maps/record_locate",
        async: false, 
        success: function(data){
            json = data;
            zoom = (json[0]['zoom']);  
            cen_lat = json[0]['prvin_lat'];
            cen_lon = json[0]['prvin_lon'];
        }
    });
    

    var gm = google.maps;
    var map = new gm.Map(document.getElementById('map_canvas'), {
    mapTypeId: gm.MapTypeId.MAP,
        center: new gm.LatLng(cen_lat, cen_lon), 
        //backgroundColor: '#e10000',
        zoom: zoom, // whatevs: fitBounds will override
    });



    // var polygon = [];
    // var i;
    // $.each(json, function(index, value) {
    //     if(index != 0) {
    //         polygon += '{lat:'+value.lat+',lng:'+value.lon+'},';
    //     }
    //     ++i;
    // });
    // polygon.replace('"', '');
    // console.log(polygon);
    // //var plg = JSON.stringify(polygon);
    // //polygon = JSON.parse(polygon)

    // // Define the LatLng coordinates for the polygon's path.
    // var triangleCoords = [
    //     {lat:12.3165193,lng:105.6122045},
    //     {lat:11.9495637,lng:105.4298576},
    //     {lat:11.7511884,lng:105.0608925},
    //     {lat:11.8886287,lng:105.6816069},
    //     {lat:12.1325596,lng:105.1629345},
    //     {lat:11.8000393,lng:105.8823702},
    //     {lat:11.7795765,lng:105.821449},
    //     {lat:11.9171108,lng:105.2474568},
    // ];
    
    // // Construct the polygon.
    // var bermudaTriangle = new google.maps.Polygon({
    //     paths: triangleCoords,
    //     strokeColor: '#FF0000',
    //     strokeOpacity: 0.8,
    //     strokeWeight: 2,
    //     fillColor: '#FF0000',
    //     fillOpacity: 0.35
    // });
    // bermudaTriangle.setMap(map);


    
    var iw = new gm.InfoWindow();
    var oms = new OverlappingMarkerSpiderfier(map,
        {
        markersWontMove: true,
        markersWontHide: true,
        nudgeRadius: 0.5,
    });

    var usualColor = 'eebb22';
    var spiderfiedColor = 'ffee22';
    var iconWithColor = function (color) {
        return 'http://chart.googleapis.com/chart?chst=d_map_xpin_letter&chld=pin|+|' + color + '|f8d11a|ffff00';
    };
    
    var shadow = new gm.MarkerImage('https://www.google.com/intl/en_ALL/mapfiles/shadow50.png',
        new gm.Size(37, 34), // size   - for sprite clipping
        new gm.Point(0, 0), // origin - ditto
        new gm.Point(15, 42)  // anchor - where to meet map location
    );

    oms.addListener('click', function (marker) {
        iw.setContent(marker.desc);
            iw.open(map, marker);
    });
    
    oms.addListener('spiderfy', function (markers) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setIcon(markers[i].icon);
            markers[i].setShadow(null);
           //console.log(markers[i].icon);
        }
        iw.close();
    });

    oms.addListener('unspiderfy', function (markers) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setIcon(markers[i].icon);
            markers[i].setShadow(shadow);
            //console.log(markers[i].icon);
        }
    });

    map.addListener('zoom_changed', function() {        

        //map.addListenerOnce('idle', function() {

        // change spiderable markers to plus sign markers
        // we are lucky here in that initial map is completely clustered
        // for there is no init listener in oms :(
        // so we swap on the first zoom/idle
        // and subsequently any other zoom/idle

        var spidered = oms.markersNearAnyOtherMarker();

        for (var i = 0; i < spidered.length; i ++) {

            // this was set when we created the markers
            var url = spidered[i].icon;
            spidered[i].setIcon(url);
            // code to manipulate your spidered icon url
                            
        };

        //});

    });






    var markers_no_overdue= [];
    var markers_30= [];
    var markers_60= [];
    var markers_90= [];
    var markers_over_90= [];

    var bounds = new gm.LatLngBounds();
         
    $.each(json, function (key, data) {
        var loc = new gm.LatLng(data.lat, data.lon);

        var myIcon = {
            url: data.icon,
            origin: new google.maps.Point(0, 0),
            scaledSize: new google.maps.Size(15, 17),
            anchor: new google.maps.Point(15, 17)
        };

    
        var marker = new gm.Marker({
            position: loc,
            map: map,
            icon: myIcon,
            shadow: shadow
        });
        
        marker.desc = data.desc;
        //reigiter maker to array to do a clusting   
        switch (data.overdue_day){
            case 'No overdue':
                markers_no_overdue.push(marker);
                break;
            case 30:
                markers_30.push(marker);
                break;
            case 60:
                markers_60.push(marker);
                break;
            case 90:
                markers_90.push(marker);
                break;
            case 9168:
                markers_over_90.push(marker);
                break;
        }      
        //markers.push(marker);
        oms.addMarker(marker);
                
        });
                
        // Add a marker clusterer to manage the markers.
        var markerCluster_no_overdue = new MarkerClusterer(map, markers_no_overdue,{imagePath: base_url +'assets/images/icons/markers/no_overdue' });
        var markerCluster_30 = new MarkerClusterer(map, markers_30,{imagePath: base_url +'assets/images/icons/markers/over_in_30' });
        var markerCluster_60 = new MarkerClusterer(map, markers_60,{imagePath: base_url +'assets/images/icons/markers/over_in_60' });
        var markerCluster_90 = new MarkerClusterer(map, markers_90,{imagePath: base_url +'assets/images/icons/markers/over_in_90' });
        var markerCluster_over_90 = new MarkerClusterer(map, markers_over_90,{imagePath: base_url +'assets/images/icons/markers/overdue_over_90' });


        markerCluster_no_overdue.setMaxZoom(10);
        markerCluster_30.setMaxZoom(10);
        markerCluster_60.setMaxZoom(10);
        markerCluster_90.setMaxZoom(10);
        markerCluster_over_90.setMaxZoom(10);

    function updateMarker() {

        var n = 0;
                  
        $.ajax({

            dataType: "json",
            async: false,
            type: "GET",
            url: base_url + "maps/live_data_update",
            data: { n: n },
            success: function(data) {
             
                $.each(data, function( i,item ){

                    if( n !== item.n ){

                        markers = new google.maps.Marker({
                            position: new google.maps.LatLng(item.lat, item.lon ),
                            map: map,
                            icon: item.icon
                        });

                        google.maps.event.addListener(markers,'click', function(){
                            iw.setContent( item.desc );
                            iw.open(map, this);                        
                            //markers.setIcon(null);
                        });

                        n = item.n;

                    } // check duplicat                 
                
                });
                                        
                //console.log(markers); 
            }
        });
    }
    
    // every 10 seconds
    setInterval(updateMarker,10000);


    // function call load markers on map about leasee paid and not paid with comment.
    PaidMarker();
    comment();
    setInterval(PaidMarker,10000);
    setInterval(comment,10000);

    function PaidMarker() {
        var icon = base_url + '/assets/images/icons/markers/fco.png';
        $.ajax({
            dataType: "json",
            async: false,
            type: "POST",
            url: base_url + "maps/get_paid_today",
            success: function(data) {
                
                $.each(data.items, function( i,item ){

                    // var icon = {
                    //     path: "M-20,0a20,20 0 1,0 40,0a20,20 0 1,0 -40,0",
                    //     fillColor: '#2e40a7',
                    //     fillOpacity: .6,
                    //     anchor: new google.maps.Point(0,0),
                    //     strokeWeight: 0,
                    //     scale: 0.5
                    // }

                    markers = new google.maps.Marker({
                        position: new google.maps.LatLng(item.lesse_map_latitue, item.lesse_map_longtitue ),
                        map: map,
                        icon: icon
                    });

                    google.maps.event.addListener(markers,'click', function(){

                        var li ="";
                        li += '<div class="itm-lst fco-wrapper">';

                        
                        $.each(data.images, function(i,img){
                            if(img.lesse_id == item.lesse_id) {
                                li += '<a class="fancybox" data-fancybox="gallery" href="'+ Image_Server_URL + img.path +'"><img class="thumbnail copost-img img-left" src="'+ Image_Server_URL + img.path +'"></a>';
                            }
                        });
                        //var location = (item.lesse_location === 'null') ? item.lesse_location :'';
                        li += '<div class="copost-right">';
                        li += '<h6>'+ item.civil_code + '. ' + item.perso_va_firstname_en + ' ' + item.perso_va_lastname_en + '</h6>';
                        li += '<p><b>Paid</b> : ' + item.lesse_paid + ' </p>';
                        li += '<p><b>Location</b> : ' + item.lesse_location  +' </p> ';
                        li += '<p><b>Posted by</b> : '+ item.sec_usr_desc+ ' </p>';
                        li += '<p><b>Posted Date</b> : '+ item.post_date + ' </p>';
                        li += '</div>';
                        li += '</div>';

                        iw.setContent( li );
                        
                        iw.open(map, this);                        
                        //markers.setIcon(null);
                    });
                });
                //console.log(markers);
            }
        });
    }

    

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
                            li += '<div class="img-fco">';

                            $.each(data.pictures, function(i, img) {
                                if (img.lesse_comment_id == item.lesse_comment_id) {
                                   li += '<a class="fancybox" rel="" data-fancybox="gallery" href="'+Image_Server_URL + img.path + '"><img class="thumbnail list-paid-img img-left" src="'+ Image_Server_URL + img.path + '" ></a>';
                                }
                            });
                            var date = item.dt_cre;
                            li += '</div>';
                            li += '<div class="copost-right">';
                            li += '<h6>' + item.civil_code + '. ' + item.perso_va_firstname_en + ' ' + item.perso_va_lastname_en + '</h6>';
                            li += '<p><b>Comment</b> : ' + item.comme_va_desc + ' </p> ';
                            li += '<p><b>Location</b> : ' + item.lesse_comment_location + ' </p> ';
                            li += '<p><b>Posted by</b> : ' + item.sec_usr_desc + ' </p>';
                            li += '<p><b>Posted Date</b> : ' + item.post_date + ' </p>';
                            li += '</div>';
                            li += '</div>';
                        

                        iw.setContent(li);

                        iw.open(map, this);
                        //markers.setIcon(null);
                    });
                });
                //console.log(markers);
            }
        });
    }




};
























 
