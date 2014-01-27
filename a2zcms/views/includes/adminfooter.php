 <?php
	$sitetheme = $this->session->userdata('sitetheme');
	$copyright = $this->session->userdata('copyright');
?>
	<footer>
		<div class="row">
		  	<div class="collapse navbar-collapse navbar-ex1-collapse col-lg-12">
		      	<ul class="nav navbar-nav navbar-left">					
				</ul>
			</div>			        
		</div>
		<div class="row">
			 <div class="col-lg-12">
				<span style="text-align:left;float:left">
					&copy; 2014 <a class="a2zcms" href="#">A2Z CMS</a></span>
				<span style="text-align: center;padding-left: 30%"><?php echo $copyright?></span>
				<span style="text-align:right;float:right">
					Powered by: <a class="a2zcms" href="http://ellislab.com/codeigniter" alt="Codeigniter 2.1.4">Codeigniter 2.1.4</a></span>
			</div>
		</div>
	</footer>
	<!-- start: JavaScript-->
	<!--[if !IE]>-->
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/jquery-2.0.3.min.js"></script>
	<!--<![endif]-->
	<!--[if IE]>
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/jquery-1.10.2.min.js"></script>
	<![endif]-->
	<!--[if !IE]>-->
	<script type="text/javascript">
		window.jQuery || document.write("<script src='<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/jquery-2.0.3.min.js')}}'>" + "<" + "/script>");
	</script>
	<!--<![endif]-->
	<!--[if IE]>
	<script type="text/javascript">
	window.jQuery || document.write("<script src='<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
	</script>
	<![endif]-->
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/bootstrap.js"></script>
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/theme.js"></script>
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/jquery.validate.js"></script>
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/select2.js"></script>
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/jquery.multiselect.js"></script>
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/prettify.js"></script>
	<script src="<?php echo ASSETS_PATH.'/'.$sitetheme; ?>/js/summernote.js"></script>
	<!-- end: JavaScript-->
		
	</body>
</html>