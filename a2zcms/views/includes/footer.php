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
					&copy; 2013 - <?=date('Y')?> <a class="a2zcms" href="#">A2Z CMS</a></span>
				<span style="text-align: center;padding-left: 30%"><?php echo $copyright?></span>
				<span style="text-align:right;float:right">
					Powered by: <a class="a2zcms" href="http://ellislab.com/codeigniter" alt="Codeigniter 2.1.4">Codeigniter 2.1.4</a></span>
			</div>
		</div>
	</footer>
	
	</body>
</html>