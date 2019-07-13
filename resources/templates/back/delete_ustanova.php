
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		 {
            $query = query("DELETE FROM ustanove WHERE u_id = " . escape_string($_GET['id']) . " ");
            confirm($query);

            set_message("Brisanje uspješno!");			
            redirect("../../../public/ustanove.php");
		}
		else 
		{
			redirect("../../../public/ustanove.php");
		}
	 ?>