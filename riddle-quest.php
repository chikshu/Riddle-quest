<?php
/* 
Plugin Name: Clues
Plugin URI: http://localhost/RiddleQuest/
Description: This plugin allows you to add Riddle and it answers.
Author: Chikshi Gupta
Version: 1.0
Author URI: http://localhost/RiddleQuest/
 */
 
 //////////////////////// Define Constants ////////////////////////
//if(isset($_POST['d_id'])){ var_dump( $wpdb );  $delId = $_POST['d_id'];	 delete_question($delId);	exit;	} 
if (!defined("WP_riddle_DIR")) define("WP_riddle_DIR", plugin_dir_path(__FILE__));

// activation Hook called for installation_for_riddle_quest
register_activation_hook(__FILE__, "plugin_install_script_for_riddle_quest");

/////////////////////// Function for add the install script //////////////
		if(!function_exists("plugin_install_script_for_riddle_quest")) {
			function plugin_install_script_for_riddle_quest() {
					if(file_exists(WP_riddle_DIR . "/lib/install_script.php"))
						{
							include WP_riddle_DIR . "/lib/install_script.php";
						}
			}
		}
//// Table Name ////
	function riddle_quest_tbl()
		{
			global $wpdb;
			return $wpdb->prefix."riddle_post_tbl";
		}
	function riddle_quest_options()
		{
			global $wpdb;
			return $wpdb->prefix."riddle_quest_options";
		}
	
	//// show value in field ///////////////

	function get_riddle_post_data($postid)
		{
			global $wpdb;
			$table_name = riddle_quest_tbl();
			$myrows = $wpdb->get_results( "SELECT * FROM ".$table_name." where `post_id` = '".$postid."'" );
			return $myrows;
		}
	function fetch_riddle_options($qid){
			global $wpdb;
			$table_name = riddle_quest_options();
			$myrows = $wpdb->get_results( "SELECT * FROM ".$table_name." where `question_id` = '".$qid."'" );
			return $myrows;
		
		}
	function fetch_clueImg_id($qid){
			global $wpdb;
			$table_name = riddle_quest_options();
			$rowsid = $wpdb->get_results( "SELECT `id`,`ans` FROM ".$table_name." where `qa_type`='clues_img' and `question_id`= '".$qid."'" );
			return $rowsid;
		
		}

		
///////////////////////////////  Riddle Post Type ////////////////////////////////

add_action( 'init', 'create_riddle_post_type' );
add_action( 'init', 'register_assets' );

/********** include stylesheets *********/

	function register_assets() {
			//js
		
			wp_enqueue_script('script', plugins_url('/riddle-quest/js/riddle-question.js') );
			//wp_enqueue_script('script', 'https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js' );
			
			// styles
			wp_enqueue_style('acf-global', plugins_url('/riddle-quest/css/riddle-global.css') );
			wp_enqueue_style('acf-input', plugins_url('/riddle-quest/css/riddle-input.css') );
			wp_enqueue_style('acf-field-group', plugins_url('/riddle-quest/css/riddle-field-group.css') );
			
			
	}
/************** register post *****************/
	function create_riddle_post_type() {
	   register_post_type( 'riddle_post',
			array(
				'labels' => array(
					'name'          => __( 'Clues', 'textdomain' ),
					'singular_name' => __( 'Riddles Post', 'All Riddles' )
				),
				'public'      => true,
				'has_archive' => true,
				'menu_icon'   => 'dashicons-welcome-widgets-menus',
				'taxonomies'  => array( 'category' )
			)
		);
		
	}

/******************************* End  *//////////////////////////////////////////

///////////////////// Add the Riddle Meta Boxes/////////////////////////////////////
function add_riddle_metaboxes() {
		add_meta_box('wpt_riddle_location', 'Clue Question', 'wpt_riddle_location', 'riddle_post', 'advanced', 'default');
	}
add_action( 'add_meta_boxes', 'add_riddle_metaboxes' );
// The Event Location Metabox

function wpt_riddle_location() {
	global $post;
	
	echo '<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>';
	echo '<script type="text/javascript">
		var url="'. plugins_url("/riddle-quest/views/riddle_filled_post.php").'"
		var imgUrl="'. plugins_url("/riddle-quest/views/riddle_file_upload.php").'"
	</script>';
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="riddlemeta_noncename" id="riddlemeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	$res = get_riddle_post_data($post->ID);
	
	include WP_riddle_DIR . "/views/riddle_quest_auto.php";
		 
}


// Save the Metabox Data
function wpt_save_events_meta($post_id, $post) {
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['riddlemeta_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
	echo $post->content;
	echo $post->title;
	die;
	$question =  $_POST['question'];
	$q_id = $_POST['question_id'];
	$q_files = $_POST['ques_file'];
	
	global $wpdb;
	$table_name=riddle_quest_tbl();
	$table_name2=riddle_quest_options();
	$dt = date("d-m-y h:i");	
	
	// Add values of $events_meta as custom fields
	$j = 1;
	for ($i = 0; $i<count($_POST['question_id']); $i++) { 
			echo "question".$question[$i].'<br>';
			
		
			$right_answers = $_POST['Right_answers_'.$j];
			$ra_id = $_POST['Right_answers_id'.$j];
			$wrong_answers = $_POST['wrong_answers_'.$j];
			$wa_id = $_POST['wrong_answers_id'.$j];
			$clues = $_POST['purchase_clue_'.$j];
			$clue_img = $_POST['clue_img_'.$j];
			$cl_id = $_POST['purchase_clue_id'.$j];
			$clue_img_id = $_POST['purchase_clue_img'.$j];
			
			
			if($q_id[$i] == '' ){
				$last_id ='';
				if($question[$i] != '' || $q_files[$i] != ''){
					$wpdb->insert( 
							$table_name, 
							array( 
									'post_id' => $post->ID,
									'question' => $question[$i], 
									'ques_img' => $q_files[$i], 
									'date' =>$dt 
								)
							);	
						echo  $last_id = $wpdb->insert_id;
						
						foreach($right_answers as $ra){
							 //right ans
							 $wpdb->insert( 
							 $table_name2, 
							 array( 
									'post_id' => $post->ID,
									'question_id' =>$last_id, 
									'qa_type' => 'right_answer', 
									'ans' => $ra, 
									'questDate' =>$dt 
								)
							 );	
							 }
						
						foreach($wrong_answers as $wa){ 
							
							//wrong ans
							 $wpdb->insert( 
							 $table_name2, 
							 array( 
									'post_id' => $post->ID,
									'question_id' =>$last_id, 
									'qa_type' => 'wrong_answer', 
									'ans' => $wa, 
									'questDate' =>$dt 
								)
							 );	
							 }
							 
						foreach($clues as $cl){
							 //clues
							 $wpdb->insert( 
							 $table_name2, 
							 array( 
									'post_id' => $post->ID,
									'question_id' =>$last_id, 
									'qa_type' => 'clues', 
									'ans' => $cl, 
									'questDate' =>$dt 
								)
							 );	
							 }
							 
						foreach($clue_img as $ci){
							 //clues
							 $wpdb->insert( 
							 $table_name2, 
							 array( 
									'post_id' => $post->ID,
									'question_id' =>$last_id, 
									'qa_type' => 'clues_img', 
									'ans' => $ci, 
									'questDate' =>$dt 
								)
							 );	
							 }
							echo "inserted";
						
						}else{
						echo "please add question";
						}
				}else{
					$wpdb->update( 
						$table_name, 
						array( 
							'question' =>  $question[$i], 
							'ques_img' =>  $q_files[$i], 
							'updated_at' => $dt 			
						), 
						array( 'id' => $q_id[$i] )			 
					);
					//update options
					$k=0;
					$n=0;
					$l=0;
					$img=0;
					foreach($ra_id as $ra){
							 //right ans
							 if($ra ==''){
								 echo "inserted";
								 $wpdb->insert( 
								$table_name2, 
									 array( 
											'post_id' => $post->ID,
											'question_id' =>$q_id[$i], 
											'qa_type' => 'right_answer', 
											'ans' => $right_answers[$k], 
											'questDate' =>$dt 
										)
									 );	
							}
							else{
								 echo "<br> right".$ra;
								 echo "<br> ans".$right_answers[$k];
								 $wpdb->update( 
								 $table_name2, 
									 array( 
											 
											'ans' => $right_answers[$k], 
											'updated_at' =>$dt 
										), 
										array( 'id' => $ra )
									 );	
							}
							$k++;
						}
					foreach($wa_id as $wa){
						if($wa ==''){
							echo "inserted";
								 $wpdb->insert( 
								 $table_name2, 
									 array( 
											'post_id' => $post->ID,
											'question_id' =>$q_id[$i], 
											'qa_type' => 'wrong_answer', 
											'ans' => $wrong_answers[$n], 
											'questDate' =>$dt 
										)
									 );	
							
							}else{
							 //wrong ans
							 echo "<br> wrong".$wa;
							 $wpdb->update( 
							 $table_name2, 
							 array( 
									 
									'ans' => $wrong_answers[$n], 
									'updated_at' =>$dt 
								), 
							array( 'id' => $wa )
							 );
						 }
							 $n++;	
						}
					foreach($cl_id as $cl){
							 //clues ans
							 if($cl == ''){
								 echo "inserted";
								 $wpdb->insert( 
								$table_name2, 
									 array( 
											'post_id' => $post->ID,
											'question_id' =>$q_id[$i], 
											'qa_type' => 'clues', 
											'ans' => $clues[$l], 
											'questDate' =>$dt 
										)
									 );	
							 }else{
							 echo "<br> clues".$cl;
							 $wpdb->update( 
							 $table_name2, 
							 array( 
									 
									'ans' => $clues[$l], 
									'updated_at' =>$dt 
								), 
							array( 'id' => $cl )
							 );	
						 }
							 $l++;
						}
					foreach($clue_img_id as $cid){
							 //clues ans
							 if($cid == ''){
								 echo "inserted";
								 $wpdb->insert( 
								$table_name2, 
									 array( 
											'post_id' => $post->ID,
											'question_id' =>$q_id[$i], 
											'qa_type' => 'clues_img', 
											'ans' => $clue_img[$img], 
											'questDate' =>$dt 
										)
									 );	
							 }else{
							 echo "<br> clues".$cid;
							 $wpdb->update( 
							 $table_name2, 
							 array( 
									 
									'ans' => $clue_img[$img], 
									'updated_at' =>$dt 
								), 
							array( 'id' => $cid )
							 );	
						 }
							 $img++;
						}
					echo "updated";
				}
				$j++;
		} //end foreach outer

}




add_action('save_post', 'wpt_save_events_meta',1,2); // save the custom fields
///////////////////////// END /////////////////////////////


/* Insert your custom functions here */

add_action('init', 'my_custom_init');
function my_custom_init() {

add_theme_support( 'post-thumbnails' );

add_post_type_support( 'riddle_post', 'thumbnail' );

post_type_supports( 'riddle_post', 'thumbnail' );

}

// delete question
add_action('wp_ajax_del_action', 'delete_ques');

function delete_ques() {
    global $wpdb; // this is how you get access to the database

    $did = intval( $_POST['did'] );

   		$table_name = riddle_quest_tbl();
		$table_name2 = riddle_quest_options();
		$qry=$wpdb->delete($table_name , array( 'id' => $did ) );
		if($qry){
			 
			 $wpdb->delete($table_name2 , array( 'question_id' => $did ) );
			}else{
				echo "fail";
			} //detele data from question table.

   // this is required to return a proper result
}
?>

