
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		 {
            $query = query("DELETE FROM fakulteti WHERE fak_id = " . escape_string($_GET['id']) . " ");
            confirm($query);

            set_message("Brisanje uspješno!");			
            redirect("../../../public/fakulteti.php");
		}
		else 
		{
			redirect("../../../public/fakulteti.php");
		}
	 ?>