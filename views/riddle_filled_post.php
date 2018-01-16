<?php
	$i=1;
	
	//var_dump( $wpdb );
	//  echo $delId = $_POST['d_id'];
	global $wpdb;
	if(isset($_POST['d_id'])){ $delId = $_POST['d_id'];	 
				echo $delId;
		exit;	} 
	
	if(!empty($res)){
	 foreach($res as $row)
	 {
		$j=1;
	?>
	<div class="quesBlock" style="border:solid medium; margin:10px;padding:10px;min-height:50px" >	
			<div class="outer"><h1 class="acf-label">Clue Question</h1><img class="upArrow" src="<?php echo plugins_url();?>/riddle-quest/images/up-arrow-circle-hi.png" style="float:right;width:30px;height:30px" />
			<img class="downArrow" src="<?php echo plugins_url(); ?>/riddle-quest/images/down-arrow-circle-hi.png" style="float : right;width:30px;height:30px;display:none;" />
			</div>
			<div class="questions">
					<div class="enterText">
                    <textarea name="question[]"  placeholder="add question for riddle" ><?php if($row->question) { echo $row->question; } ?></textarea></div>
                    <?php if($row->ques_img !=''){
						$temp = explode(".", $row->ques_img);
						if(end($temp) == 'mp3' || end($temp)=='mp4'){
							// echo "audio";
							?>
						<div class="imageBox" style="">
						<img  title ="Previous image" src="" style="display:none;width:300px;height:250px">
						<!--input id="Qaud" value="<?php echo $row->ques_img;?>" style=""-->
						<embed id="Qaud" type="audio/midi" src="<?php echo plugins_url(); ?>/riddle-quest/upload/QestImg/<?php echo $row->ques_img;?>" style="width:300px;height:250px" volume="60" loop="false" autostart="false" />
						</div>	
							
						<?php } else{ 
							//echo "image";  ?>
							<div class="imageBox">
							<img  title ="Previous image" src="<?php echo plugins_url(); ?>/riddle-quest/upload/QestImg/<?php echo $row->ques_img;?>" style="width:300px;height:250px">
							<!--input id="Qaud" src="" style="display:none;"-->
							<embed id="Qaud" type="audio/midi" src="" style="width:0px;height:0px" volume="60" loop="false" autostart="false" />
							</div>
					<?php		}
						?>
                    
						<?php } else{ ?>
						<div class="imageBox" style="display:none;"><img  title ="Previous image" src="" style="width:300px;height:250px"><embed id="Qaud" type="audio/midi" src="" style="width:300px;height:250px" volume="60" loop="false" autostart="false" /></div>
							<?php }?>
                     
                    <div class="moreQuest">
					<img id="Qimg" title="new image to be upload" src="" style="display:none;width:300px;height:250px">
					<input type="text" name="ques_file[]" value="<?php if($row->ques_img) { echo $row->ques_img; } ?>" style="display:none">
					<input type="hidden" name="question_id[]" value ="<?php if($row->id) { echo $row->id; } ?>" placeholder="add question for riddle" ><span class="box" style="float:right"><i class="close">x</i></span>
					<input type="file" style="display:none" placeholder="choose a file" class="clue_ques" id="clue_ques_<?php echo $i;?>" name="clue_ques">
                    <span class="qFile"><img src="<?php echo plugins_url(); ?>/riddle-quest/images/camera.png" style="width:50px; height:50px;"></span>	
                    </div>
					
			</div>
		
		<div class="Answers">
			<div class ="correct">
				<div class="input_field">
				<h1 class="acf-label" >Right Answers</h1>
				<?php $options=fetch_riddle_options($row->id); 
					foreach($options as $op){
						if($op->qa_type =='right_answer'){?>
					<input type="text" class="acf-input-wrap" name="Right_answers_<?php echo $i;?>[]" value = "<?php echo $op->ans; ?>" placeholder="right answer for riddle" >
					<input type="hidden" class="acf-input-wrap" name="Right_answers_id<?php echo $i;?>[]" value = "<?php echo $op->id; ?>" placeholder="right answer for riddle" >
				<?php }
				}
				?>
			
				</div>
				
			 
					<ul class="acf-actions acf-hl">
					<li>
						<a class="acf-button button button-primary rightAnswers" data-event="add-row">Add Next Answer</a>
					</li>
					</ul>
		 
			</div>
			<div class ="wrong">
				<div class="input_field">
					<h1 class="acf-label">Wrong Answers Message</h1> 
					<?php $options=fetch_riddle_options($row->id); 
						foreach($options as $op){
							if($op->qa_type == 'wrong_answer'){ 
					?>
					<input type="text" class="acf-input-wrap" name="wrong_answers_<?php echo $i;?>[]" value = "<?php echo $op->ans; ?>" placeholder="Wrong answer message for riddle" >
					<input type="hidden" class="acf-input-wrap" name="wrong_answers_id<?php echo $i;?>[]" value = "<?php echo $op->id; ?>" placeholder="Wrong answer message for riddle" >
					<?php }
					} ?>
				</div> 
					<ul class="acf-actions acf-hl">
						<li>
							<a class="acf-button button button-primary wrongAnswers" data-event="add-row">Add Another Wrong Message</a>
						</li>
					</ul>
			 
			</div>
		</div>
		
		<div class="cluesPurchaced">
			<div class="input_field">
				 <h1 class="acf-label">Hints For Clues</h1>
				 <h2>Enter question Or Upload Image/Audio for clues</h2>
				<?php $options=fetch_riddle_options($row->id);
				$imgid = fetch_clueImg_id($row->id);
			 				
				foreach($options as $op){
				
					if($op->qa_type == 'clues'){
				
				?>
				<div class="onclickadd">
				<textarea class="acf-input-wrap" name="purchase_clue_<?php echo $i;?>[]"  placeholder="clue for riddle" ><?php echo $op->ans; ?></textarea>
				
				<input type="hidden" class="acf-input-wrap" name="purchase_clue_id<?php echo $i;?>[]" value = "<?php echo $op->id; ?>" placeholder="clue for riddle" >
				<input type="hidden" class="acf-input-wrap" name="purchase_clue_img<?php echo $i;?>[]" value = "<?php  echo $imgid[$j-1]->id; ?>" placeholder="clue for riddle" >
				
				<?php  if($imgid[$j-1]->ans !=''){
					$temp = explode(".", $imgid[$j-1]->ans);
					if(end($temp) == 'mp3' || end($temp)=='mp4'){
					 ?>
					<img id="" class="clueImage<?php echo $j;?>" src=""  style="display:none;width:250px; height:100px;">
					<embed id="" class="clueImage<?php echo $j;?>" name="" src="<?php echo plugins_url(); ?>/riddle-quest/upload/QestImg/<?php echo $imgid[$j-1]->ans;?>" type="audio/midi" style="width:300px;height:250px" volume="60" loop="false" autostart="false" />
				<?php } else{ ?>
					<img id="" class="clueImage<?php echo $j;?>" src="<?php echo plugins_url(); ?>/riddle-quest/upload/QestImg/<?php echo $imgid[$j-1]->ans;?>" style="width:250px; height:100px;">
					<embed id="" class="clueImage<?php echo $j;?>" name="" src="" type="audio/midi" style="width:0px;height:0px" volume="60" loop="false" autostart="false" />
				<?php } }
					else{?>
					<img id="" class="clueImage<?php echo $j;?>" src=""  style="display:none;width:250px; height:100px;">
					<embed id="" class="clueImage<?php echo $j;?>" name="" src="" type="audio/midi" style="width:0px;height:0px" volume="60" loop="false" autostart="false" />
				<?php	}?>
				
				<input type="hidden" class="clue_img fileclue<?php echo $j;?>" name="clue_img_<?php echo $i?>[]" value="<?php echo $imgid[$j-1]->ans;?>">
				<input type="file" name="clue_file" id='clue_file_<?php echo $i;?>_<?php echo $j;?>' class='clue_file files<?php echo $i;?>' placeholder="choose a file" style='display:none'>
				<span class="upload"><img src="<?php echo plugins_url(); ?>/riddle-quest/images/camera.png" style="width:50px; height:50px;"></span>
				</div>
				<?php 
				$j=$j+1;
				}
					
				
			} ?>
			
			</div>
		 
				<ul class="acf-actions acf-hl">
					<li>
						<a class="acf-button button button-primary clues" data-event="add-row">Add Next Clue</a>
					</li>
				</ul>
	 
		<input type="hidden" id="jVal" value="<?php echo $j ?>">
			
		</div>
	
	</div> <!---main block ------->
	
<?php 	$i++;
 }
}else{ $j=1;?>
	<div class="quesBlock" style="border:solid medium; margin:10px;padding:10px;min-height:50px" >	
			<div class="outer"><h1 class="acf-label">Clue Question</h1><img class="upArrow" src="<?php echo plugins_url(); ?>/riddle-quest/images/up-arrow-circle-hi.png" style="float : right;width:30px;height:30px" />
			<img class="downArrow" src="<?php echo plugins_url(); ?>/riddle-quest/images/down-arrow-circle-hi.png" style="float : right;width:30px;height:30px;display:none;" /></i>
			</div>
			<div class="questions">
					<textarea name="question[]" value ="" placeholder="add question for riddle" ></textarea>
					<input type="text" name="ques_file[]" value="" style="display:none">
					<input type="hidden" name="question_id[]" value ="" placeholder="add question for riddle" >
					<img id="Qimg" src="" style="display:none;width:300px;height:250px">
					<!--input id="Qaud" src="" style="display:none;"-->
					<embed id="Qaud" type="audio/midi" src="" style="display:none;width:0px;height:0px" volume="60" loop="false" autostart="false" />
					<input type="file" style="display:none" placeholder="choose a file" class="clue_ques" id="clue_ques_<?php echo $i;?>" name="clue_ques">
					<span class="qFile"><img src="<?php echo plugins_url(); ?>/riddle-quest/images/camera.png" style="width:50px; height:50px;"></span>
			</div>
		
		<div class="Answers">
			<div class ="correct">
				<div class="input_field">
				<h1 class="acf-label" >Right Answers</h1>
				<input type="text" class="acf-input-wrap" name="Right_answers_<?php echo $i; ?>[]" value = "" placeholder="right answer for riddle" >
				<input type="hidden" class="acf-input-wrap" name="Right_answers_id<?php echo $i;?>[]" value = "" placeholder="right answer for riddle" >
				</div>
				
			 
					<ul class="acf-actions acf-hl">
					<li>
						<a class="acf-button button button-primary rightAnswers" data-event="add-row">Add Next Answer</a>
					</li>
					</ul>
	 
			</div>
			<div class ="wrong">
				<div class="input_field">
					<h1 class="acf-label">Wrong Answers Message</h1> 
					<input type="text" class="acf-input-wrap" name="wrong_answers_<?php echo $i; ?>[]" value = "" placeholder="Wrong answer message for riddle" >
					<input type="hidden" class="acf-input-wrap" name="wrong_answers_id<?php echo $i;?>[]" value = "" placeholder="Wrong answer message for riddle" >
				</div>
				 
					<ul class="acf-actions acf-hl">
						<li>
							<a class="acf-button button button-primary wrongAnswers" data-event="add-row">Add Another Wrong Message</a>
						</li>
					</ul>
			 
			</div>
		</div>
		
		<div class="cluesPurchaced">
			<div class="input_field">
				<h1 class="acf-label">Hints For Clues</h1>
				<h2>Enter question Or Upload Image/Audio for clues</h2>
				<div class="onclickadd">
				<textarea class="acf-input-wrap" name="purchase_clue_<?php echo $i; ?>[]" placeholder="clue for riddle" ></textarea>
				
				<input type="hidden" class="acf-input-wrap" name="purchase_clue_id<?php echo $i;?>[]" value = "" placeholder="clue for riddle" >
				<input type="hidden" class="acf-input-wrap" name="purchase_clue_img<?php echo $i;?>[]" value = "s" placeholder="clue for riddle" >	
				<img id="" src="" class="clueImage<?php echo $j;?>" style="display:none;width:250px; height:100px;">
				<embed id="" class="clueImage<?php echo $j;?>" name="" src="" type="audio/midi" style="width:0px;height:0px" volume="60" loop="false" autostart="false" />	
				<input type="hidden" class="clue_img fileclue<?php echo $j;?>" name="clue_img_<?php echo $i?>[]" value="">	
				<input type="file" name="clue_file" id='clue_file_<?php echo $i;?>_<?php echo $j;?>' class='clue_file files<?php echo $i;?>' placeholder="choose a file" style='display:none'>
				<span class="upload"><img src="<?php echo plugins_url(); ?>/riddle-quest/images/camera.png" style="width:50px; height:50px;"></span>
				</div>
			</div>
		 
				<ul class="acf-actions acf-hl">
					<li>
						<a class="acf-button button button-primary clues" data-event="add-row">Add Next Clue</a>
					</li>
				</ul>
		 	<input type="hidden" id="jVal" value="<?php echo $j+1; ?>">
		</div>
	
	</div> <!---main block ------->

<?php $i++; //$j++;
	}		
 ?>
		<!--input type="hidden" name="uploadedfile" id="uploaded_file" value=""-->
<script> 
	var x = '<?php echo $i; ?>';
	var y = '<?php echo $j; ?>'; 
	var templateUrl = '<?= get_bloginfo("siteurl"); ?>';
	//alert('z'+y);
</script>
