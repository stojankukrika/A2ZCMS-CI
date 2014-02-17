 <?php
	$copyright = $this->session->userdata('copyright');
?>
<div class="clearfix"></div>
		<footer>
			<p>
				<span style="text-align:left;float:left">&copy; 2013 - <?=date('Y')?><a href="#">A2Z CMS</a></span>
				<span style="text-align: center;padding-left: 30%"><?php echo $copyright?></span>
				<span class="hidden-phone" style="text-align:right;float:right">Powered by: <a class="a2zcms" href="http://ellislab.com/codeigniter" alt="Codeigniter 2.1.4">Codeigniter 2.1.4</a></span>
			</p>
		</footer>
		
	</body>
</html>