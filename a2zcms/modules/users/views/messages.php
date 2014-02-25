<?php $this->load->view('includes/header'); ?>

<div class="container">
	<div class="row">
		
		<?php $this->load->module('menu/menu');
		echo $this->menu->mainmenu('top');
		if(!empty($content['left_content'])) {
		 	echo '<div class="col-xs-6 col-lg-4"><br><br>';
		 	foreach ($content['left_content'] as $item)
			 {
			 	if($item['content']!="")
			 	echo '<div class="well">'.$item['content'].'</div>';
			 }
			 echo "</div>"; 
		}
		if(empty($content['right_content']) && empty($content['left_content'])) {
		echo '<div class="col-xs-12 col-sm-12 col-lg-12"><br>';
		}
		else {
			echo '<div class="col-xs-12 col-sm-6 col-lg-8"><br>';
		}
		?>
<div class="page-header">
		<h3>Messages</h3>
	</div>
	<div class="row">
		<ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#service-one" data-toggle="tab">Received</a></li>
            <li><a href="#service-two" data-toggle="tab">Send</a></li>
            <li><a href="#service-three" data-toggle="tab">New message</a></li>
          </ul>
            <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="service-one">           
              <?php foreach  ($received as $item) { ?>
                <div class="panel panel-default">
	              <div class="panel-heading">
	                <h4 class="panel-title">
	                  <a class="accordion-toggle" id="msg-<?=$item->id?>" data-toggle="collapse" data-parent="#accordion" href="#<?=$item->id?>">
	                   <b><?=$item->subject?></b>
	                  </a>
	                </h4><span><?=$item->name.' '.$item->surname?></span> 
	                ( <?= date("d.m.Y H:i", strtotime($item->created_at))?> ) 
	                <a class="btn btn-sm btn-danger" id="delmsgr-<?=$item->id?>"><i class="glyphicon glyphicon-remove"></i></a>
	              </div>
	              <div id="<?=$item->id?>" class="panel-collapse collapse">
	                <div class="panel-body">
	                  <?=$item->content?>
	                </div>
	              </div>
	            </div>
	         <? } ?>
          </div>
           <div class="tab-pane fade in" id="service-two">             
          <?php foreach  ($send as $item) { ?>
              	 <div class="panel panel-default">
	              <div class="panel-heading">
	                <h4 class="panel-title">
	                  <a class="accordion-toggle" id="" data-toggle="collapse" data-parent="#accordion" href="#<?=$item->id?>">
	                    <b><?=$item->subject?></b>
	                  </a>
	                </h4><span><?=$item->name.' '.$item->surname;?></span> 
 					( <?= date("d.m.Y H:i", strtotime($item->created_at))?>)
 					<a class="btn btn-sm btn-danger" id="delmsgs-<?=$item->id?>"><i class="glyphicon glyphicon-remove"></i></a>
	              </div>
	              <div id="<?=$item->id?>" class="panel-collapse collapse">
	                <div class="panel-body">
	                  <?=$item->content?>
	                </div>
	              </div>
	            </div>
	         <? } ?>
          </div>
          <div class="tab-pane fade in" id="service-three">             
             <form role="form" method="POST" action="users/sendmessage">
	             <div class="form-group col-lg-4">
	                <label for="input1">Subject</label>
	              	<input class="form-control" type="text" name="subject" id="subject" >
	              </div>
	               <div class="clearfix"></div>
	               <div class="form-group col-lg-4">
	                <label for="input1">Receivers</label>
	               <select name="recipients[]" multiple="multiple" id="recipients">
	                     <?php foreach($allUsers as $usr) { ?>
	                        <option value="<?=$usr->id?>"><?=$usr->surname.' '.$usr->name ?></option>
	                     <?php } ?>    
	                </select>     
	              </div>
	               <div class="clearfix"></div>
	              <div class="form-group col-lg-12">
	                <label for="input4">Message</label>
	                <textarea name="message" class="form-control" rows="6" id="message"></textarea>
	                <label id="characterLeft"></label>
	              </div>
	              <div class="form-group col-lg-12">
	                <button type="submit" class="btn btn-primary">Submit</button>
	              </div>
            </form>
          </div>
       </div>
       </div>
       <?php	echo '</div>';
		if(!empty($content['right_content'])) {
			echo '<div class="col-xs-6 col-lg-4"><br><br>';
			foreach ($content['right_content'] as $item)
			 {
			 	if($item['content']!="")
			 	echo '<div class="well">'.$item['content'].'</div>';
			 }
			  echo "</div>"; 
			}
		?>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>	
<script>
	$( document ).ready(function() {		
		/*set a multiselect users for sending a message*/
		$("#recipients").multiselect();	
		/*mark message as read*/
		$("[id^='msg-']").click(function() {
			var values = $(this).attr("id");
			var value = values.split('-')[1];
				$.ajax({
					url: 'users/readmessage/'+value,
					type: "GET",							
				})
		})
		$("[id^='delmsgr-']").click(function() {
			var values = $(this).attr("id");
			var value = values.split('-')[1];
				$.ajax({
					url: 'users/deletereceiver/'+value,
					type: "GET",							
				})
			$(this).parent().parent().remove();
		})
		$("[id^='delmsgs-']").click(function() {
			var values = $(this).attr("id");
			var value = values.split('-')[1];
				$.ajax({
					url: 'users/deletesender/'+value,
					type: "GET",							
				})
			$(this).parent().parent().remove();
		})
			
	});
	
</script>