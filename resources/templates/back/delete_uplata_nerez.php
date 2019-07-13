
	<?php require_once("../../config.php");?>
	
	<?php 
		if(isset($_GET['id']))
		{
            // prvo dohvatiti id ustanove čiju uplatu brisemo
            $query2 = query("SELECT us_id from ustanove_uplate_nerez WHERE upl_id=" . escape_string($_GET['id']) . " ");
            confirm($query2);
            
 		    while($row = fetch_array($query2)) 
            {
                $go_back_id = $row["us_id"];          
            }            
            
            $query = query("DELETE FROM ustanove_uplate_nerez WHERE upl_id = " . escape_string($_GET['id']) . " ");
            confirm($query);
            
            // DELETE gotov, sada idemo nazad na ustanovu kojoj je pripadala izbrisana uplata                               
            set_message("Brisanje uspješno!");	
            redirect('../../../public/ustanove_uplate_nerez.php?id='.$go_back_id.''); // idemo nazad           
		}
		else 
		{
			set_message("Došlo je do greške. Brisanje neuspješno!");	
            // DELETE nije dobro prošao, idemo nazad, sada idemo nazad          
            $query2 = query("SELECT us_id from ustanove_uplate_nerez WHERE upl_id=" . escape_string($_GET['id']) . " ");
            confirm($query2);
                          
 		    while($row = fetch_array($query2)) 
            {
                $go_back_id = $row["us_id"];     
                redirect('../../../public/ustanove_uplate_nerez.php?id='.$go_back_id.''); // idemo nazad                           
            }           
		}
	?>