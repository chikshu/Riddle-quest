jQuery(document).ready(function($) {
	
var fileVal='';
var fileid='';
//if(y > 1){var n=y-1;}else{ var n =1;}
var m='';
//add new question
	jQuery('body').on('click','.new-question', function(){
		  jQuery.ajax({
				url:'' ,
				type: 'post',
				dataType: 'html',
				success: function(html){
					var i = x;
					n =1;
					var inc=n+1;
					x = parseInt(x)+1;
					var loc = document.location.origin;
					jQuery('.main-div').append('<div class="quesBlock" style="border:solid medium; margin:10px;padding:10px;min-height:50px" ><div class="outer"><h1 class="acf-label">Clue Question</h1><img style="float: right; width: 30px; height: 30px;" src="'+templateUrl+'/wp-content/plugins/riddle-quest/images/up-arrow-circle-hi.png" class="upArrow">			<img style="float: right; width: 30px; height: 30px; display: none;" src="'+templateUrl+'/wp-content/plugins/riddle-quest/images/down-arrow-circle-hi.png" class="downArrow"></div><div class="questions"><textarea name="question[]" value ="" placeholder="add question for riddle" ></textarea><input type="text" name="ques_file[]" value="" style="display:none"><img id="Qimg" src="" style="display:none;width:300px;height:250px"/><embed id="Qaud" type="audio/midi" src="" style="display:none;width:300px;height:250px" volume="60" loop="false" autostart="false" /><input type="hidden" name="question_id[]" value ="" placeholder="add question for riddle" ><span class="box" style="float:right"><i class="close">x</i></span><input type="file" style="display:none" placeholder="choose a file" class="clue_ques" id="clue_ques_'+i+'" name="clue_ques"><span class="qFile"><img src="'+templateUrl+'/wp-content/plugins/riddle-quest/images/camera.png" style="width:50px;height:50px;"></span></div><div class="Answers"><div class ="correct"><div class="input_field"><h1 class="acf-label" >Right Answers</h1><input class="acf-input-wrap" type="hidden" placeholder="right answer for riddle" value="" name="Right_answers_id'+i+'[]"><input type="text" class="acf-input-wrap" name="Right_answers_'+i+'[]" value = "" placeholder="right answer for riddle" ></div><ul class="acf-actions acf-hl"><li><a class="acf-button button button-primary rightAnswers" data-event="add-row">Add Next Answer</a></li></ul></div><div class ="wrong"><div class="input_field"><h1 class="acf-label">Wrong Answers Message</h1><input class="acf-input-wrap" type="hidden" placeholder="Wrong answer message for riddle" value="" name="wrong_answers_id'+i+'[]"><input type="text" class="acf-input-wrap" name="wrong_answers_'+i+'[]" value = "" placeholder="Wrong answer message for riddle" ></div><ul class="acf-actions acf-hl"><li><a class="acf-button button button-primary wrongAnswers" data-event="add-row">Add Another Wrong Message</a></li></ul></div></div><div class="cluesPurchaced"><div class="input_field"><h1 class="acf-label">Hints for Clues</h1><div class="onclickadd"><textarea class="acf-input-wrap" name="purchase_clue_'+i+'[]"  placeholder="clue for riddle" ></textarea><input class="acf-input-wrap" type="hidden" placeholder="clue for riddle" value="" name="purchase_clue_id'+i+'[]"><input type="hidden" class="acf-input-wrap" name="purchase_clue_img'+i+'[]" value = "" placeholder="clue for riddle" ><img id="" src="" class="clueImage'+n+'" style="display:none;width:250px; height:100px;"><embed id="" class="clueImage'+n+'" name="" src="" type="audio/midi" style="width:0px;height:0px" volume="60" loop="false" autostart="false" /><input type="hidden" class="clue_img fileclue'+n+'" name="clue_img_'+i+'[]" value=""><input type="file" style="display:none" placeholder="choose a file" class="clue_file files'+i+'" id="clue_file_'+i+'_'+n+'" name="clue_file"><span class="upload"><img style="width:50px; height:50px;" src="'+templateUrl+'/wp-content/plugins/riddle-quest/images/camera.png"></span></div></div><ul class="acf-actions acf-hl"><li><a class="acf-button button button-primary clues" data-event="add-row">Add Next Clue</a></li></ul><input type="hidden" id="jVal" value="'+inc+'"></div></div>');
					
					n=1;
				}
			});
			
	});

	//add right answer
	jQuery('body').on('click','.rightAnswers', function(){
		
		var nearELE = jQuery(this).closest('.correct');
		var name = nearELE.find('input[type=text]').attr('name');
		var i = name.split("_");
		
		nearELE.find('.input_field').append('<input type="text" class="acf-input-wrap" name="'+name+'" value = "" placeholder="right answer for riddle" ><input type="hidden" class="acf-input-wrap" name="Right_answers_id'+i[2]+'" value = "" placeholder="right answer for riddle" >');
		});
		
	// add wrong answer	
	jQuery('body').on('click','.wrongAnswers', function(){
		var nearELE = jQuery(this).closest('.wrong');
		var name = nearELE.find('input[type=text]').attr('name');
		var i = name.split("_");
		nearELE.find('.input_field').append('<input type="text" class="acf-input-wrap" name="'+name+'" value = "" placeholder="Wrong answer message for riddle" ><input type="hidden" class="acf-input-wrap" name="wrong_answers_id'+i[2]+'" value = "" placeholder="Wrong answer message for riddle" >');
		});
		
	//add clues
	jQuery('body').on('click','.clues', function(){
		var nearELE = jQuery(this).closest('.cluesPurchaced');
		var name = nearELE.find('textarea').attr('name');
		var jval = nearELE.find('#jVal').val();
		//alert(jval);
		var i = name.split("_");
		var In = i[2].split("[]");
		inc = parseInt(jval);
		
		nearELE.find('#jVal').val(parseInt(inc)+1);
		nearELE.find('.input_field').append('<div class="onclickadd"><textarea class="acf-input-wrap" name="'+name+'" placeholder="clue for riddle" ></textarea><input type="hidden" class="acf-input-wrap" name="purchase_clue_id'+i[2]+'" value = "" placeholder="clue for riddle" ><input type="hidden" class="acf-input-wrap" name="purchase_clue_img'+i[2]+'" value = "" placeholder="clue for riddle" ><img id="" src="" class="clueImage'+inc+'" style="display:none;width:250px; height:50px;"><embed id="" class="clueImage'+inc+'" name="" src="" type="audio/midi" style="width:0px;height:0px" volume="60" loop="false" autostart="false" /><input type="hidden" class="clue_img fileclue'+inc+'" name="clue_img_'+i[2]+'" value=""><input type="file" style="display:none" placeholder="choose a file" class="clue_file files'+In[0]+'" id="clue_file_'+In[0]+'_'+inc+'" name="clue_file"><span class="upload"><img style="width:50px; height:50px;" src="'+templateUrl+'/wp-content/plugins/riddle-quest/images/camera.png"></span></div>');
		});
		
		
	// block remove
	jQuery('body').on('click','.close', function(){
		var n = jQuery(this).closest('span');
		var idval = n.prev('input[type=hidden]').val();
		 var data = {
			action: 'del_action',
			did: idval
			};
		if(idval == ''){
			jQuery(this).closest('.quesBlock').remove();
			i = x--;
			console.log('only block removed');
		}else{
			//alert(url);
			  if (confirm('Are you sure ?')) {
						jQuery.post(ajaxurl, data, function(response) {
							alert('Selected Question has been deleted!!');
							window.location.reload();
						});
					jQuery(this).closest('.quesBlock').remove();
				
				}else{
						console.log('not deleted'); 
					} 
			  
			}
		
	});
	
	
	//file upload clues hints
	jQuery('body').on('click','.upload', function(){
		var file = jQuery(this).prev('input[type=file]').attr('name');
		fileid = jQuery(this).prev('input[type=file]').attr('id');
		console.log(fileid+'------------'+file);
			if(file == 'clue_file' ){
				console.log('file click');
				jQuery("#"+fileid).click();
				}
			else{
					console.log('not file click');
			}
	});
	// image select hints
		jQuery('body').on('change','.clue_file',function(){
			var parent= jQuery(this).parent();
			var i = fileid.split("_");

			var fileName = jQuery('#'+fileid).prop('files')[0];
			
			if(fileName != ''){
			
			var form_data = new FormData(); 
			form_data.append('file', fileName);
		
			console.log('uploading...........');
			 jQuery.ajax({
				  url: imgUrl,
				  type: 'POST',
				  processData: false, // important
				  contentType: false, // important
				  dataType : 'text',
				  data: form_data,
				  success: function(datares){
					datares = datares.trim();
					datares= datares.split('$$');

					var imgStatus =datares['0'];
					fileVal = datares['1'];
					var src = templateUrl+'/wp-content/plugins/riddle-quest/upload/QestImg/'+fileVal;
						if(imgStatus=="uploaded")				 
						{
							if(datares['2'] == 'mp3' || datares['2'] == 'mp4')
							{
								console.log('audio tagv ID > fileclue'+i[3]);
								parent.find('.fileclue'+i[3]).val(fileVal);
								parent.find('embed.clueImage'+i[3]).attr('src',src);
								parent.find('embed.clueImage'+i[3]).removeClass('hide');
								parent.find('embed.clueImage'+i[3]).addClass('fileAdd');
								parent.find('img.clueImage'+i[3]).hide();
								
							}
							else
							{
								console.log('audio tagv ID > clueImage'+i[3]);
								
								parent.find('.fileclue'+i[3]).val(fileVal);
								parent.find('img.clueImage'+i[3]).attr('src',src);
								parent.find('img.clueImage'+i[3]).show();
								parent.find('embed.clueImage'+i[3]).addClass("hide");
								parent.find('embed.clueImage'+i[3]).removeClass('fileAdd');
								
							}
							
						}
					}
					});
				}
			});
		
	
	// hide/ show ques 
	jQuery('body').on('click','.upArrow',function(){
		
		jQuery(this).hide();
		jQuery(this).next('.downArrow').show();
		var drpClass = $(this).parent();
		var parent = drpClass.parent();
		parent.find('.questions').hide();
		parent.find('.Answers').hide();
		parent.find('.cluesPurchaced').hide();

		});
	
	jQuery('body').on('click','.downArrow',function(){
		
		jQuery(this).hide();
		jQuery(this).prev('.upArrow').show();
		var drpClass = $(this).parent();
		var parent = drpClass.parent();
		parent.find('.questions').show();
		parent.find('.Answers').show();
		parent.find('.cluesPurchaced').show();
		});
	//-----------------------------------------
	
	//ques image upload
	jQuery('body').on('click','.qFile', function(){
		var file = jQuery(this).prev('input[type=file]').attr('name');
		fileid = jQuery(this).prev('input[type=file]').attr('id');
		console.log(fileid+'------------'+file);
			if(file == 'clue_ques' ){
				console.log('file click');
				jQuery("#"+fileid).click();
				}
			else{
					console.log('not file click');
			}
	});
	
	jQuery('body').on('change','.clue_ques',function(){
		var parentclass= jQuery(this).parent().attr('class');
		var parent= jQuery(this).parent();
		
		
			var i = fileid.split("_");
			
			var fileName = jQuery('#'+fileid).prop('files')[0];
			
			if(fileName != ''){
			
			var form_data = new FormData(); 
			form_data.append('file', fileName);
		
			console.log('uploading...........');
			 jQuery.ajax({
				  url: imgUrl,
				  type: 'POST',
				  processData: false, // important
				  contentType: false, // important
				  dataType : 'text',
				  data: form_data,
				  success: function(datares){
					datares = datares.trim();
					datares= datares.split('$$');

					var imgStatus =datares['0'];
					if(imgStatus=="uploaded")				 
						{
						fileVal = datares['1'];
							parent.find('input[type=text]').val(fileVal);
							var src = templateUrl+'/wp-content/plugins/riddle-quest/upload/QestImg/'+fileVal;
							
							if(parentclass == "questions"){
								if(datares['2'] == 'mp3' || datares['2'] == 'mp4'){
									//alert('file');
									parent.find('img#Qimg').hide();
									parent.find('embed#Qaud').attr('src',src);
									parent.find('embed#Qaud').show();
								}else{
								parent.find('img#Qimg').attr("src", src);
								parent.find('img#Qimg').show();
								parent.find('embed#Qaud').hide();
								}
							}else{
								if(datares['2'] == 'mp3' || datares['2'] == 'mp4'){
									//alert('file');
									parent.prev('div').show();
									parent.prev('div').find('img').hide();
									parent.prev('div').find('embed#Qaud').attr('src',src);
									parent.prev('div').find('embed#Qaud').show();
									parent.prev('div').css('width:300px;height:50px');
								
								}else{
								parent.prev('div').find('img').attr('src',src);
								parent.prev('div').find('img').attr('title','new image to be upload');
								parent.prev('div').find('img').show();
								parent.prev('div').find('embed#Qaud').hide();
								parent.prev('div').css('width:300px;height:200px');
								parent.prev('div').show();
								}
								}
							//parent.append('<img title="new uploaded image" style="width:300px; height:250px" src="'+templateUrl+'/wp-content/plugins/riddle-quest/upload/'+fileVal+'">');
						}
					}
					});
				}
		
		});
		
		//validation
		jQuery('#publish').click(function(){
			
			var rv=true;
			jQuery(".quesBlock ").each(function() {
				var q = jQuery(this).find('input[type=text]').val();
				var f = jQuery(this).find('textarea').val();
				if(q == '' && f == ''){
					rv= false;
				}
				else{
				    	
				}	
				
				});
			if(rv == false){
				alert('please fill question field as text or atleast choose file');
				}
			return rv;
			});
			
});

