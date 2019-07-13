
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		{		 
			$query = query("DELETE FROM strani_jezici WHERE l_id = " . escape_string($_GET['id']) . " ");
			confirm($query);

			set_message("Brisanje uspješno!");			
			redirect("../../../public/strani_jezici.php");			
		}
		else 
		{
			redirect("../../../public/strani_jezici.php");
		}
	 ?>