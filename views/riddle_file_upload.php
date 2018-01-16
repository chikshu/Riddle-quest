<?php

		 if ( 0 < $_FILES['file']['error'] ) {
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		 }
			else {
				//echo "start";
			if (!file_exists('../upload/QestImg')) {
					mkdir('../upload/QestImg/', 0777, true);
					chmod('../upload/QestImg/',0777,true);
			}else{
				chmod('../upload/QestImg/',0777,true);
			}	
			$temp = explode(".", $_FILES["file"]["name"]);
			
			$newfilename ="clue-".date("dmyhis").'.' . end($temp);
	
			chmod($_FILES['file']['tmp_name'],0777,true);
			chmod('../upload/QestImg/' . $newfilename,0777,true);
			$upload =  move_uploaded_file($_FILES['file']['tmp_name'], '../upload/QestImg/' . $newfilename);
		
			  if($upload)
				{
				  echo "uploaded";
				 echo "$$";
				 echo $newfilename;
				 echo "$$";
				 echo end($temp);
				}
			  else {
					echo "not uploaded"; 
					 $dir  = $_SERVER['SERVER_NAME'];
					echo $dir  .= $_SERVER['REQUEST_URI'];
					
					echo $_FILES['file']['tmp_name']. '../upload/QestImg/' . $newfilename;
				   }
		}

 
?>
