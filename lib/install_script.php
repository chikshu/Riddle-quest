<?php

if(!function_exists("create_riddle_tbl"))
{
	function create_riddle_tbl()
		{
			global $wpdb;
			$table_name = riddle_quest_tbl();	
			$charset_collate = $wpdb->get_charset_collate();
				$sql = "CREATE TABLE $table_name (
					id mediumint(9) NOT NULL AUTO_INCREMENT,
					post_id int(11) NOT NULL,
					question varchar(55) NOT NULL,
					ques_img varchar(55) NOT NULL,
					date datetime,
					updated_at datetime,
					UNIQUE KEY id (id)		
				) $charset_collate;";		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
}

if(!function_exists("create_riddle_quest_options"))
{
	function create_riddle_quest_options()
		{
			global $wpdb;
			$table_name = riddle_quest_options();	
			$charset_collate = $wpdb->get_charset_collate();
				$sql = "CREATE TABLE $table_name (
					id mediumint(9) NOT NULL AUTO_INCREMENT,
					post_id int(11) NOT NULL,
					question_id int(11) NOT NULL,
					qa_type varchar(55) NOT NULL,
					ans varchar(55) NOT NULL,
					questDate datetime,
					updated_at datetime,
					UNIQUE KEY id (id)		
				) $charset_collate;";		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
}

global $wpdb;
if (count($wpdb->get_var("SHOW TABLES LIKE '" . riddle_quest_tbl() . "'")) == 0)
	{
		create_riddle_tbl();
	}
if (count($wpdb->get_var("SHOW TABLES LIKE '" . riddle_quest_options() . "'")) == 0)
	{
		create_riddle_quest_options();
	}
?>
