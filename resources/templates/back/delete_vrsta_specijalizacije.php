
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		{		 
			$query = query("DELETE FROM vrste_specijalizacija WHERE vs_id = " . escape_string($_GET['id']) . " ");
			confirm($query);

			set_message("Brisanje uspješno!");			
			redirect("../../../public/vrste_specijalizacija.php");			
		}
		else 
		{
			redirect("../../../public/vrste_specijalizacija.php");
		}
	 ?>