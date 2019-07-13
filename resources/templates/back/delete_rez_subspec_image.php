
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		 {
            $query = query("UPDATE rez_subspecijalizacije SET image='' WHERE subspec_id = " . escape_string($_GET['id']) . " ");
            confirm($query);

            set_message("Brisanje uspješno!");			
            redirect("../../../public/rez_subspecijalizacije.php");
		}
		else 
		{
			redirect("../../../public/rez_subspecijalizacije.php");
		}
	 ?>