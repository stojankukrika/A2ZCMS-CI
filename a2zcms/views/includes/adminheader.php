<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		$sitetheme = $this->session->userdata('sitetheme');
		$titlecopyright = $this->session->userdata('title');		
		$copyright = $this->session->userdata('copyright');
		$metadesc = $this->session->userdata('description');
		$metakey = $this->session->userdata('keywords');
		$metaauthor = $this->session->userdata('metaauthor');
		$analytics = $this->session->userdata('analytics');		
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title><?php echo $titlecopyright?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- @todo: fill with your company info or remove -->
		<meta name="description" content="<?php echo $metadesc;?>">
		<meta name="keywords" content="<?php echo $metakey;?>">
		<meta name="author" content="<?php echo $metaauthor;?>">
		<link rel="stylesheet" type="text/css"  href="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/css/bootstrap.css">	
		<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/css/jquery-ui-1.10.3.custom.css">		
		<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/css/jquery.multiselect.css">	
		<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/css/a2zcms.css">				
		<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/css/summernote.css">	
		<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/css/summernote-bs3.css">				
		<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/css/font-awesome.min.css">	
		<link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/css/prettify.css">			
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/html5.js"></script>
		<![endif]-->
		<?php echo $analytics;?>
		<link rel="shortcut icon" href="<?php echo ASSETS_PATH;?>/../ico/favicon.ico">
	</head>
	<body>