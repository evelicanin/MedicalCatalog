
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		{		 
			$query = query("DELETE FROM vrste_subspecijalizacija WHERE vss_id = " . escape_string($_GET['id']) . " ");
			confirm($query);

			set_message("Brisanje uspješno!");			
			redirect("../../../public/vrste_subspecijalizacija.php");			
		}
		else 
		{
			redirect("../../../public/vrste_subspecijalizacija.php");
		}
	 ?>