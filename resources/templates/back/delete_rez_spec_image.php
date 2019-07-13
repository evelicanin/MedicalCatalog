
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		 {
            $query = query("UPDATE rez_specijalizacije SET image='' WHERE spec_id = " . escape_string($_GET['id']) . " ");
            confirm($query);

            set_message("Brisanje uspješno!");			
            redirect("../../../public/rez_specijalizacije.php");
		}
		else 
		{
			redirect("../../../public/rez_specijalizacije.php");
		}
	 ?>