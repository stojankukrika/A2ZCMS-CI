 <?php
	$copyright = $this->session->userdata('copyright');
?>
<div class="clearfix"></div>
		<footer>
			<p>
				<span style="text-align:left;float:left">&copy; 2014 <a href="#">A2Z CMS</a></span>
				<span style="text-align: center;padding-left: 30%"><?php echo $copyright?></span>
				<span class="hidden-phone" style="text-align:right;float:right">Powered by: <a class="a2zcms" href="http://ellislab.com/codeigniter" alt="Codeigniter 2.1.4">Codeigniter 2.1.4</a></span>
			</p>
		</footer>
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
		<script src="<?=ASSETS_PATH_ADMIN?>/js/bootstrap-dataTables-paging.js"></script>
		<script src="<?=ASSETS_PATH_ADMIN?>/js/select2.js"></script>		
		<script src="<?=ASSETS_PATH_ADMIN?>/js/jquery.multiselect.js"></script>
		<!-- end: JavaScript-->
	</body>
</html>