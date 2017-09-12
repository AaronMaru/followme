<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<?php 
$root = "http://".$_SERVER['HTTP_HOST'];
$root .= dirname($_SERVER['SCRIPT_NAME']);
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Not Found | Followmee </title>
    <link href="<?php echo $root; ?>/assets/images/icons/gle-log.ico">

    <link href="<?php echo $root.('/assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo $root.('/assets/font-awesome/css/font-awesome.css')?>" rel="stylesheet">

    <link href="<?php echo $root.('/assets/css/gps/animate.css')?>" rel="stylesheet">
    <link href="<?php echo $root.('/assets/css/gps/style.min.css')?>" rel="stylesheet">
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name"> GL </h1>
        </div>
        <div class="middle-box animated fadeInDown">
		    <h3 class="font-bold">Page Not Found</h3>

		    <div class="error-desc">
		        <ol class="text-left">
	  				<li>Please check your internet connection.</li>
	  				<li>Please check current URL.</li>
	  				<li>Please check your typing on searching...</li>
				</ol>
		        <a href="<?php echo $root; ?>" class="btn btn-primary m-t">Click to Home</a>
		    </div>
		</div>
	</div>
</div>
<!-- Mainly scripts -->
<script src="<?php echo base_url('assets/js/jquery-2.1.1.js')?>"></script>
<script src="<?php echo base_url('js/bootstrap.min.js')?>"></script>

</body>

</html>


