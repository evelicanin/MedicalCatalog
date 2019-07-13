
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		{		 
			$query = query("DELETE FROM drzavljanstva WHERE d_id = " . escape_string($_GET['id']) . " ");
			confirm($query);

			set_message("Brisanje uspješno!");			
			redirect("../../../public/drzavljanstva.php");			
		}
		else 
		{
			redirect("../../../public/drzavljanstva.php");
		}
	 ?>