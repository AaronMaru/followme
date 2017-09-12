<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <?php echo link_tag(['href' => 'assets/images/icons/gle-log.ico', 'rel' => 'shortcut icon']); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $main_title; ?> </title>
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet">
    <!-- FooTable -->
    <link href="<?php echo base_url('assets/css/plugins/footable/footable.core.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/chosen/chosen.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/iCheck/custom.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/gps/animate.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/gps/style.css'); ?>" rel="stylesheet">

    <link type="text/css" href="<?php echo base_url('assets/css/jquery.fancybox.css'); ?>" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <link href="<?php echo base_url('assets/css/toggle.css'); ?>" rel="stylesheet">
    <!-- datatable -->
    <link href="<?php echo base_url('assets/css/plugins/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/datatables/dataTables.responsive.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/datatables/dataTables.tableTools.min.css'); ?>" rel="stylesheet">

    <!-- customize styling here -->
    <link href="<?php echo base_url('assets/css/gps/custom.css'); ?>" rel="stylesheet">

    <!-- ChartJS-->
    <script src="<?php echo base_url('assets/js/plugins/chartJs/Chart.min.js'); ?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

</head>

<body>



<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">

            <?php
                $uri_3 = $this->uri->segment(3);
                $uri_2 = $this->uri->segment(2);
                $menu = [
                    'maps'    => ['province', 'district', 'commune'],
                    'overdue' => ['one_month', 'two_month', 'three_month', 'over_three_month', 'no_overdue'],
                    'lessee'  => ['paid', 'comment'],
                    'auth'    => ['user', 'role', 'user_role', 'feature_category', 'feature', 'feature_role']
                ];

                //$maps = ['province', 'district', 'commune'];
                //$overdue = ['one_month', 'two_month', 'three_month', 'over_three_month', 'no_overdue'];
                //$security = ['user', 'role', 'user_role', 'feature_category', 'feature', 'feature_role'];
            ?>

            <?php
                $user_id = $auth->usr_id;
                $file_name = $auth->file_name;
                $fname = $auth->first_name;
                $lname = $auth->last_name;
            ?>
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span>
                        <?php if ($file_name) {?>
                            <img alt="image" class="img-circle" src="<?php echo base_url('assets/images/uploads/profile/' . $file_name); ?>" width="70px" height="65px"/>
                        <?php } else {?>
                            <img alt="image" class="img-circle" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTxGgJNLXyrAl-FoH4EOENTTqIxqdD5bUwUHuF_H04EV6HawkPH3g" width="70px" height="65px"/>
                        <?php }?>
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs"><strong class="font-bold">
                                <?php echo @$fname . ' ' . $lname; ?> </strong></span>
                                <span class="text-muted text-xs block">
                                <?php echo @($this->session->userdata('permission')[0]->rol_name); ?> <b class="caret"></b></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="<?php echo base_url('/gps-syn/auth/user/edit/' . $user_id); ?>">Profile</a></li>
                            <li><a href="<?php echo base_url('gps-syn/auth/user/change_password'); ?>">Change password </a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url('gps-syn/auth/user/logout'); ?>">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        GL
                    </div>
                </li>
                <li class="">
                    <a href="<?php echo base_url('/'); ?>"><i class="fa fa-eye"></i> <span class="nav-label"> View Site </span></a>
                </li>
                <li class="<?php echo ($uri_2 == 'dashboard' ? 'active' : ''); ?>">
                    <a href="<?php echo base_url('gps-syn/dashboard'); ?>"><i class="fa fa-th-large"></i> <span class="nav-label"> Dashboard </span></a>
                </li>
                <?php
                    if ($per_cate) {
                        foreach ($per_cate as $cate):
                            if ($cate->ft_cate_name != null) {
                            ?>

								<li class="<?php echo (in_array($uri_3, $menu[$cate->ft_cate_name]) == true ? 'active' : ''); ?> menu">
								    <a><i class="fa fa-<?php echo $cate->ft_icon; ?>"></i> <span class="nav-label">
								    <?php echo ucfirst($cate->ft_cate_name); ?> </span>
								    <span class="fa arrow"></span></a>

					               <ul class="nav nav-second-level collapse"><?php
                                                                                     foreach ($permission as $sub):
                                                                                                 if ($cate->ft_cate_name == $sub->ft_cate_name
                                                                                         && ($sub->add == 1 || $sub->update == 1 || $sub->delete == 1 || $sub->list == 1)) {
                                                                                                 ?><li class="<?php echo ($uri_3 == $sub->ft_name ? 'active' : ''); ?>">
				                                    <a href="<?php echo base_url('gps-syn/' . $sub->ft_cate_name . '/' . $sub->ft_name); ?>">
				                                    <i class="fa fa-th-large hidden"></i>
				                                    <?php echo $sub->ft_display; ?></a></li>
												<?php }
                                                            endforeach;?>
		                            </ul>
						        </li>

						<?php }
                            endforeach;}?>


            </ul>
        </div>
    </nav>






    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                    <ul class="nav navbar-top-links navbar-right">

                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-money"></i>  <span class="label label-danger                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo (count($paid) <= 0) ? 'hidden' : ''; ?>"><?php echo count($paid); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo (count($paid) <= 0) ? 'hidden' : ''; ?>">

                                <?php foreach ($paid as $p) {?>

                                    <li>
                                        <a class="paid-notify" data-href="<?php echo $p->lesse_id; ?>" data-toggle="modal" href="#modal-form">
                                            <div><?php echo $p->civil_code . '. ' . $p->perso_va_lastname_en . ' ' . $p->perso_va_firstname_en; ?>  (<strong>$<?php echo $p->lesse_paid; ?></strong>) :<?php echo $p->lesse_location; ?>
                                                <span class="pull-right text-muted small"><?php echo time_elap_str($p->dt_cre); ?></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <div class="clearfix"></div>

                                <?php }?>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-comments"></i>  <span class="label label-warning                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo (count($comments) <= 0) ? 'hidden' : ''; ?>"><?php echo count($comments); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo (count($comments) <= 0) ? 'hidden' : ''; ?>">

                                <?php foreach ($comments as $c) {?>

                                    <li>
                                        <a class="comment-notify" data-href="<?php echo $c->lesse_comment_id; ?>" data-toggle="modal" href="#modal-form">
                                            <div><?php echo $c->civil_code . '. ' . $c->perso_va_lastname_en . ' ' . $c->perso_va_firstname_en; ?> :<?php echo $c->comme_va_desc; ?>
                                                <span class="pull-right text-muted small"><?php echo time_elap_str($c->dt_cre); ?></span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>


                                <?php }?>
                            </ul>
                        </li>



                        <li>
                            <a href="<?php echo base_url('gps-syn/auth/user/logout'); ?>">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>

                    </ul>
            </nav>
        </div>

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2><?php echo $main_title; ?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a><?php echo ucfirst($this->uri->segment(2)); ?></a>
                    </li>
                    <li class="active">
                        <strong><?php echo $main_title; ?></strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>

