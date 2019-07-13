
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		{
            // prvo dohvatiti broj specijalizacije čiju ustanovu staziranja brisemo
            $query2 = query("SELECT spec_id from ustanove_staz_nerez WHERE us_id=" . escape_string($_GET['id']) . " ");
            confirm($query2);
            
 		    while($row = fetch_array($query2)) {
                $go_back_id = $row["spec_id"];          
            }            
            
            $query = query("DELETE FROM ustanove_staz_nerez WHERE us_id = " . escape_string($_GET['id']) . " ");
            confirm($query);
            
            // DELETE gotov, sada idemo nazad na specijalizaciju kojoj je pripadala izbrisana ustanova staziranja                               
            set_message("Brisanje uspješno!");	
            redirect('../../../public/view_nerez_specijalizacija.php?id='.$go_back_id.''); // idemo nazad
            
		}
		else 
		{
			set_message("Došlo je do greške. Brisanje neuspješno!");	
            // DELETE nije dobro prošao, idemo nazad, sada idemo nazad          
            $query2 = query("SELECT spec_id from ustanove_staz_nerez WHERE us_id=" . escape_string($_GET['id']) . " ");
            confirm($query2);
                          
		    while($row = fetch_array($query2)) {
                redirect('../../../public/view_nerez_specijalizacija.php?id='.htmlentities($row["spec_id"]).''); // idemo nazad
            }
		}
	?>