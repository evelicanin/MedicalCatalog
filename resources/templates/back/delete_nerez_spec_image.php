
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		 {
            $query = query("UPDATE nerez_specijalizacije SET image='' WHERE spec_id = " . escape_string($_GET['id']) . " ");
            confirm($query);

            set_message("Brisanje uspješno!");			
            redirect("../../../public/nerez_specijalizacije.php");
		}
		else 
		{
			redirect("../../../public/nerez_specijalizacije.php");
		}
	 ?>