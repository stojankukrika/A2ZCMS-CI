<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		$titlecopyright = $this->session->userdata('title');		
		$copyright = $this->session->userdata('copyright');
		$metadesc = $this->session->userdata('description');
		$metakey = $this->session->userdata('keywords');
		$metaauthor = $this->session->userdata('metaauthor');
		$analytics = $this->session->userdata('analytics');		
		?>
	<head>
		<meta charset="UTF-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title> Administration :: <?=$titlecopyright?> </title>

		<meta name="keywords" content="<?=$metakey?>" />
		<meta name="author" content="<?=$metaauthor?>" />
		<!-- Google will often use this as its description of your page/site. Make it good. -->
		<meta name="description" content="<?=$metadesc?>" />
		<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
		<meta name="google-site-verification" content="">
		<!-- Dublin Core Metadata : http://dublincore.org/ -->
		<meta name="DC.title" content="A2ZCMS">
		<meta name="DC.subject" content="<?=$metadesc?>">
		<meta name="DC.creator" content="<?=$metaauthor?>">
		<!--  Mobile Viewport Fix -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<!-- start: CSS -->
		<link rel="stylesheet" type="text/css" href="<?=ASSETS_PATH_ADMIN?>/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?=ASSETS_PATH_ADMIN?>/css/jquery.dataTables.css">
		<link rel="stylesheet" type="text/css" href="<?=ASSETS_PATH_ADMIN?>/css/colorbox.css">
		<link rel="stylesheet" type="text/css" href="<?=ASSETS_PATH_ADMIN?>/css/style.min.css">
		<link rel="stylesheet" type="text/css" href="<?=ASSETS_PATH_ADMIN?>/css/jquery-ui-1.10.3.custom.css">		
		<link rel="stylesheet" type="text/css" href="<?=ASSETS_PATH_ADMIN?>/css/bootstrap-dataTables.css">
		<!-- end: CSS -->
		<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="<?=ASSETS_PATH_ADMIN?>/js/html5.js"></script>
		<script src="<?=ASSETS_PATH_ADMIN?>/js/respond.min.js"></script>
		<![endif]-->
		<!-- start: Favicon and Touch Icons -->
		<link rel="shortcut icon" href="<?=ASSETS_PATH_ADMIN?>/ico/favicon.ico">
		<!-- end: Favicon and Touch Icons -->
		
		<!-- start: JavaScript-->
		<!--[if !IE]>-->
		<script src="<?=ASSETS_PATH_ADMIN?>/js/jquery-2.0.3.min.js"></script>
		<!--<![endif]-->
		<!--[if IE]>
		<script src="<?=ASSETS_PATH_ADMIN?>/js/jquery-1.10.2.min.js"></script>
		<![endif]-->
		<script src="<?=ASSETS_PATH_ADMIN?>/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="<?=ASSETS_PATH_ADMIN?>/js/bootstrap.min.js"></script>
		<!-- page scripts -->
		<script src="<?=ASSETS_PATH_ADMIN?>/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="<?=ASSETS_PATH_ADMIN?>/js/jquery.ui.touch-punch.min.js"></script>
		<!--[if lte IE 8]>
			<script language="javascript" type="text/javascript" src="<?=ASSETS_PATH_ADMIN?>/js/excanvas.min.js"></script>
		<![endif]-->		
		<script src="<?=ASSETS_PATH_ADMIN?>/js/jquery.dataTables.min.js"></script>
		<script src="<?=ASSETS_PATH_ADMIN?>/js/dataTables.bootstrap.min.js"></script>
		<!-- theme scripts -->
		<script src="<?=ASSETS_PATH_ADMIN?>/js/custom.min.js"></script>
		<script src="<?=ASSETS_PATH_ADMIN?>/js/core.min.js"></script>
		<script src="<?=ASSETS_PATH_ADMIN?>/js/jquery.colorbox.js"></script>
		<script src="<?=ASSETS_PATH_ADMIN?>/js/select2.js"></script>		
		<script src="<?=ASSETS_PATH_ADMIN?>/js/jquery.multiselect.js"></script>
		<!-- end: JavaScript-->
	</head>
	<body>
		