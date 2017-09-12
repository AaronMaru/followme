$(function() {

    var table, start, end;

    $("a.item_in_day").click(function(e) {

        $('#province_tab').addClass('active');
        $('#tab_province').addClass('active');
        start = $(this).attr('data-start');
        end = $(this).attr('data-end');
        if(start < 1){
            $('#myModalLabel').text('Leasee overdue over 90');
        }else if(start < 90){
            $('#myModalLabel').text('Leasee overdue in ' + start + '-' + end + ' day');
        }else{
            $('#myModalLabel').text('Leasee overdue over 90');
        }
        province_overdue(start, $('#branch_province').val());
    });

    $('#overduemodal').on('hidden.bs.modal', function () {
        $('.nav-tabs li').removeClass('active');
        $('.tab-pane').removeClass('active');
        $('#districtoverdue').empty();
        $('#communeoverdue').empty();
        table.destroy();
    });

    $('#searchmodal').on('hidden.bs.modal', function () {
        $('.nav-tabs li').removeClass('active');
        $('.tab-pane').removeClass('active');
        table.destroy();
    });

    $('#province_tab').click(function(){
        table.destroy();
        province_overdue(start);
    });

    $('#district_tab').click(function(){

        $('select.prvin_id').val($('#branch_province').val());
        table.destroy();
        district_overdue($('#branch_province').val(), start);
        if (parseInt($('#branch_province').val()) != 12) {
            $('#tab_district .prvin_id').attr("disabled", "disabled");
        }
    });

    $('#commune_tab').click(function(){
        $('select.prvin_id').val($('#branch_province').val());
        $('select.distr_id').val('');
        if (parseInt($('#branch_province').val()) != 12) {
            $('select.prvin_id').val($('#branch_province').val());
            $('select.prvin_id').attr("disabled", "disabled");
            $.post(base_url + 'maps/listDistrict/',  { id: $('#branch_province').val()}, function(result) {
            var opt = '<option value="0"> [Select Districts] </option>';
            var data = jQuery.parseJSON(result);
            $.each(data.district, function(index, value) {
                opt += '<option value="' + value.distr_id + '">';
                opt += value.distr_desc_en;
                opt += '</option>';
            });

            $('select.distr_id').html(opt);
        });
        }else{
            $('select.prvin_id').val('');
            $('select.distr_id').val('');
        }

    });

    $('#tab_district .prvin_id').change(function(){
        table.destroy();
        district_overdue($(this).val(), start);
    });

    $("#tab_commune .distr_id").change(function() {
        table.destroy();
        commune_overdue($(this).val(), start);

    });

    $("#tab_commune .prvin_id").change(function() {

        $.post(base_url + 'maps/listDistrict/',  { id: $(this).val()}, function(result) {
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

    $('.btn_search').click(function(){
        $('#province_tab_search').addClass('active');
        $('#tab_province_search').addClass('active');
        $('#provinceoverduesearch').empty();
    });

    $("#searchprovince").submit(function(e) {
        e.preventDefault();
        // table.destroy();
        $('#provinceoverduesearch').empty();
        var startdate = $('input[name=startdate_p]').val();
        var enddate = $('input[name=enddate_p]').val();
        $('#err_start_p').text('');
        $('#err_end_p').text('');

        if(parseInt(startdate) >= parseInt(enddate)){
            $('#err_start_p').html('Error! Please check again, Start date cannot greater than end date');
            return false;
        }

        table = $('#provinceoverduesearch').DataTable({
            ajax: {
                url: base_url + 'maps/searchprovince',
                type: 'POST',
                data: {
                    startdate: startdate,
                    enddate: enddate
                },
                dataSrc: 'search'
            },
            columns:[

                { title: 'Province', data: 'prvin_desc_en' },
                { title: 'Overdue', data: 'overdue' },
            ],
            bDestroy: true

        });


    }); //search



    $("#searchdistrict").submit(function(e) {
        e.preventDefault();
        // table.destroy();
        $('#districtoverduesearch').text('');
        var startdate = $('input[name=startdate_d]').val();
        var enddate = $('input[name=enddate_d]').val();
        var province_id = $('#province_select').val();
        $('#err_start_d').text('');
        $('#err_end_d').text('');

        if(parseInt(startdate) >= parseInt(enddate)){
            $('#err_start_d').text('Error! Please check again, Start date cannot greater than end date');
            return false;
        }
        table = $('#districtoverduesearch').DataTable({
            ajax: {
                url: base_url + 'maps/searchdistrict',
                type: 'POST',
                data: {
                    startdate: startdate,
                    enddate: enddate,
                    province_id: province_id
                },
                dataSrc: 'search'
            },
            columns:[

                { title: 'District', data: 'distr_desc_en' },
                { title: 'Overdue', data: 'overdue' },
            ],
            bDestroy: true

        });


    }); //SEARCH

    $("#tab_commune_search .prvin_id").change(function() {
        $.post(base_url + 'maps/listDistrict/',  { id: $(this).val()}, function(result) {
            var opt = '<option value> [Select Districts] </option>';
            var data = jQuery.parseJSON(result);
            $.each(data.district, function(index, value) {
                opt += '<option value="' + value.distr_id + '">';
                opt += value.distr_desc_en;
                opt += '</option>';
            });

            $('select.distr_id').html(opt);
        });

    });

    $("#searchcommune").submit(function(e) {
        e.preventDefault();
        // table.destroy();
        $('#communeoverduesearch').text('');
        var startdate = $('input[name=startdate_c]').val();
        var enddate = $('input[name=enddate_c]').val();
        var district_id = $('#district_select').val();
        $('#err_start_c').text('');
        $('#err_end_c').text('');

        if(parseInt(startdate) >= parseInt(enddate)){
            $('#err_start_c').text('Error! Please check again, Start date cannot greater than end date');
            return false;
        }
        table = $('#communeoverduesearch').DataTable({
            ajax: {
                url: base_url + 'maps/searchcommnue',
                type: 'POST',
                data: {
                    startdate: startdate,
                    enddate: enddate,
                    district_id: district_id
                },
                dataSrc: 'search'
            },
            columns:[

                { title: 'Commune', data: 'commu_desc_en' },
                { title: 'Overdue', data: 'overdue' },
            ],
            bDestroy: true

        });


    }); //SEARCH

    $("a.btn_fco_item").click(function(e) {
        e.preventDefault();
        var rec = '';
        $.post(base_url + 'maps/get_paid_today/', function(result) {
            var data = jQuery.parseJSON(result);

            var txt = '';
            var len = data.items.length - 1;
            if(data.items.length == 0){
                rec += '<h5 class="text-center"> No Lessee Paid Yet Today! </h5>';
            }
            $('#commentpaid').html('</a> Lessee Paid Today<a>(' + data.items.length+ ')</a>');
            $.each(data.items, function(i, item) {
                rec += '<div class="row">';
                rec += '<div class="col-md-4">';
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
                rec += '<div class="col-md-8">';

                rec += '<h5 style="margin-top: 0;">' + item.civil_code + '. ' + item.perso_va_firstname_en + ' ' + item.perso_va_lastname_en + '</h5>';
                rec += '<p>ID : ' + item.lesse_reference + ' </p>';
                rec += '<p>Paid : ' + item.lesse_paid + ' </p>';
                rec += '<p>Location : ' + location + ' </p> ';
                rec += '<p>Posted by : ' + item.sec_usr_desc + ' </p>';
                rec += '<p>Posted Date : ' + item.humantime + ' </p>';
                rec += '</div>';
                rec += '</div>';
                if(i != len){
                    rec += '<hr/>';
                }
            });

            $('#comment').html(rec);
        });
    }); //FCO

    $("a.btn_leasee_comment").click(function(e) {
        e.preventDefault();

        var rec = '';

        $.post(base_url + 'maps/lessee_comment/', function(result) {
            var data = jQuery.parseJSON(result);
            var txt = '';
            var len = data.comments.length - 1;
            if(data.comments.length == 0){
                rec += '<h5 class="text-center"> No Lessee Comment Yet Today! </h5>';
            }
            $('#commentpaid').html('</a> Lessee Comment Today<a>(' + data.comments.length+ ')</a>');
            $.each(data.comments, function(i, comment) {

                rec += '<div class="row">';
                rec += '<div class="col-md-4">';
                rec += '<div class="carousel slide" id="carousel-example-captions-'+i+'" data-ride="carousel">';
                rec += '<div class="carousel-inner" role="listbox">';
                var x = 0;
                var location = (comment.lesse_comment_location == null) ? '' : comment.lesse_comment_location;
                $.each(data.pictures, function(j, picture) {
                    var active = '';
                    if (comment.lesse_comment_id == picture.lesse_comment_id) {
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
                rec += '<div class="col-md-8">';

                rec += '<h5 style="margin-top: 0;">' + comment.civil_code + '. ' + comment.perso_va_firstname_en + ' ' + comment.perso_va_lastname_en + '</h5>';
                rec += '<p>ID : ' + comment.lesse_comment_reference + ' </p>';
                rec += '<p>Comment : ' + comment.comme_va_desc + ' </p>';
                rec += '<p>Location : ' + location + ' </p> ';
                rec += '<p>Posted by : ' + comment.sec_usr_desc + ' </p>';
                rec += '<p>Posted Date : ' + comment.humantime + ' </p>';
                rec += '</div>';
                rec += '</div>';
                rec += '<hr/>';
            });

            $('#comment').html(rec);
        });

    }); //Comment

    $('a.btn_fresh').click(function(e) {
        e.preventDefault();
        location.reload();
    }); // REFRESH


    function province_overdue(start, branch_province){
        table = $('#provinceoverdue').DataTable({
            ajax: {
                url: base_url + 'maps/province_overdue',
                type: 'POST',
                data: {
                    start: start,
                    branch_province: branch_province
                },
                dataSrc: 'province_overdue'
            },
            columns:[

                { title: 'District', data: 'prvin_desc_en' },
                { title: 'Overdue', data: 'overdue' },
            ]

        });
    }

    function district_overdue(province,start){
        table = $('#districtoverdue').DataTable({
            ajax: {
                url: base_url + 'maps/district_overdue',
                type: 'POST',
                data: {
                    province_id: province,
                    start: start
                },
                dataSrc: 'district_overdue'
            },
            columns:[

                { title: 'District', data: 'distr_desc_en' },
                { title: 'Overdue', data: 'overdue' },
            ]

        });
    }

    function commune_overdue(district, start){
        table = $('#communeoverdue').DataTable({
            ajax: {
                url: base_url + 'maps/commune_overdue',
                type: 'POST',
                data: {
                    district_id: district,
                    start: start
                },
                dataSrc: 'commune_overdue'
            },
            columns:[

                { title: 'Commune', data: 'commu_desc_en' },
                { title: 'Overdue', data: 'overdue' },
            ]

        });
    }
});
