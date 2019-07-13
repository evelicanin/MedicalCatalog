
<?php require_once("../resources/config.php"); ?>      <!-- konekcija na bazu i funkcije -->
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>  <!-- poziv header.php fajla iz TEMPLATE_FRONT -->
<?php user_is_logged();?> <!-- ako user nije logovan, vrati ga nazad na login -->

<?php $fakulteti_set        = select_fakultet();         ?>
<?php $drzave_set           = select_drzavljanstvo();    ?>
<?php $specijalizacije_set  = select_specijalizacija();  ?>

    <div class="page"> <!-- zatvoren div u footer.php -->
    
        <div class="page-main">
        
            <?php include(TEMPLATE_FRONT . DS . "top_nav.php"); ?> 

            <div class="my-3 my-md-5">
                 <div class="container">
		    <?php  	
                if (isset($_SESSION['message']))
                {
					echo '<div class="animated fadeInUp alert alert-primary alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"></button>';			
					        display_message();                                                       
					echo '</div>';				
				}							
			?>

            <?php
                if (isset($_POST['submit'])) {

                // Obrada forme	    
                $drzava           = (int)$_POST['drzava'];
                $fakultet         = (int)$_POST['fakultet'];
                $spec             = (int)$_POST['spec'];
                               
                $broj_evid        = mysql_prep($_POST["broj_evid"]);
                $ime              = mysql_prep($_POST["ime"]);
                
                $dat_rodj         = $_POST['datum_rodjenja'];
                $datum_rodjenja   = date('Y-m-d',strtotime($dat_rodj)); 
               
                $doz_broj      = mysql_prep($_POST["doz_broj"]);        
                $doz_dat       = $_POST['doz_datum'];
                $doz_datum     = date('Y-m-d',strtotime($doz_dat));                       
                $doz_izdata    = mysql_prep($_POST["doz_izdata"]);                
                
                $broj_diplome     = mysql_prep($_POST["broj_diplome"]);               
                $fak_dat          = $_POST['fak_datum'];
                $fak_datum        = date('Y-m-d',strtotime($fak_dat));                   
                $fak_rjesenje     = mysql_prep($_POST["fak_rjesenje"]);
                $fak_izdato       = mysql_prep($_POST["fak_izdato"]);
                
                $jezik            = $_POST['jezik']; 
                $broj_rjesenja    = mysql_prep($_POST["broj_rjesenja"]);
                
                $izj_broj      = mysql_prep($_POST["izj_broj"]);        
                $izj_dat       = $_POST['izj_datum'];
                $izj_datum     = date('Y-m-d',strtotime($izj_dat));                       
                $izj_izdata    = mysql_prep($_POST["izj_izdata"]); 
                                
                $staz_dat         = $_POST['datum_poc_staza'];
                $datum_poc_staza  = date('Y-m-d',strtotime($staz_dat)); 
               
                $upl_1            = mysql_prep($_POST["upl_1"]);    
                $d_up1            = $_POST['dat_up1'];
                $dat_up1          = date('Y-m-d',strtotime($d_up1)); 
                
                $broj_rj_datum    = mysql_prep($_POST["broj_rj_datum"]);
                $d_pre_staza      = $_POST["dat_pre_staza"];
                $dat_pre_staza    = date('Y-m-d',strtotime($d_pre_staza)); 
                $povrat           = mysql_prep($_POST["povrat"]);
                
                $user_unio        = $_SESSION['username'];
 
                $image                = $_FILES['file']['name'];
                $image_temp_location  = $_FILES['file']['tmp_name'];
                move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $image);
                     
                if (!empty($errors)) {
                    $_SESSION["errors"] = $errors;
                    redirect("add_nerez_specijalizacija.php");
                }

                    
                    $query  = "INSERT INTO nerez_specijalizacije (";
                    $query .= " fak_id, d_id, vs_id, broj_evid_godina, ime_prezime, datum_rodjenja,";
                    $query .= " dozvola_broj, dozvola_datum, dozvola_izdato,";
                    $query .= " fak_broj_diplome, fak_datum, fak_nostro_rjesenje, fak_nostro_izdato, sluzbeni_jezik, broj_rjesenja_godina, ";
                    $query .= " izjava_broj, izjava_datum, izjava_izdato,";
                    $query .= " datum_poc_staza, uplata_prva_rata, datum_prva_rata,";
                    $query .= " broj_rjesenja_datum, povrat_sredstava, datum_pres_staza, user_unio, image ";
                    $query .= ") VALUES (";
                    $query .= "  '{$fakultet}', '{$drzava}', '{$spec}', '{$broj_evid}', '{$ime}', '{$datum_rodjenja}', ";
                    $query .= "  '{$doz_broj}', '{$doz_datum}', '{$doz_izdata}', ";
                    $query .= "  '{$broj_diplome}', '{$fak_datum}', '{$fak_rjesenje}', '{$fak_izdato}', '{$jezik}', '{$broj_rjesenja}', ";
                    $query .= "  '{$izj_broj}', '{$izj_datum}', '{$izj_izdata}', ";
                    $query .= "  '{$datum_poc_staza}', '{$upl_1}', '{$dat_up1}', '{$broj_rj_datum}', '{$povrat}', '{$dat_pre_staza}', '{$user_unio}', '{$image}' ";
                    $query .= ")";
                    $result = mysqli_query($connection, $query);
                    
                    if ($result)
                    {
                        // Success
                        set_message("Specijalizacija za nerezidenta je uspješno evidentirana.");
                        redirect("add_nerez_specijalizacija.php");
                    } else {
                        // Failure
                        set_message("Došlo je do greške prilikom spašavanja podataka! Molimo ponovite unos.");
                        redirect("add_nerez_specijalizacija.php");
                    }
                           
            } else {}
            ?>                 
                    <div class="row">
                        <form action="" method="post" class="card" enctype="multipart/form-data">
                            <div class="col-12">                              
                                <div class="card-header">
                                   <h3 class="card-title">Strani državljani | Unos specijalizacije</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">                                   
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label">Broj evidencije / godina</label>
                                                <input type="text" class="form-control" name="broj_evid" placeholder="Broj evidencije / godina">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Ime (ime oca) i prezime</label>
                                                <input type="text" class="form-control" name="ime" placeholder="Ime (ime oca) i prezime..">
                                            </div>                                  
                                            <div class="form-group">
                                                <label class="form-label">Datum rođenja</label>
                                                <input type="text" class="form-control" name="datum_rodjenja" data-select="datepicker" placeholder="Datum rodjenja">
                                            </div>      
                                            <div class="form-group">
                                                <label class="form-label">Poznavanje jednog od službenih jezika</label>
                                                <select name="jezik" class="form-control custom-select"> 
                                                    <option>Izaberite jezik</option>
                                                    <option>Bosanski jezik</option>
                                                    <option>Hrvatski jezik</option>
                                                    <option>Srpski jezik</option>
                                                </select>                                         
                                            </div>   
                                            <div class="form-group">
                                                <label class="form-label">Državljanstvo</label>
                                                <select name="drzava" class="form-control custom-select"> 
                                                    <option>Izaberite državljanstvo</option>
                                                    <?php
                                                        while($drzavljanstvo = mysqli_fetch_assoc($drzave_set))
                                                        {
                                                            echo '<option value="'.$drzavljanstvo["d_id"].'">'.$drzavljanstvo["drzavljanstvo"].'</option>';
                                                        }
                                                    ?>
                                                </select>  
                                            </div>                                             
                                        </div>
                                                               
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label">Završeni fakultet</label>   
                                                <select name="fakultet" class="form-control custom-select"> 
                                                    <option>Izaberite fakultet</option>
                                                    <?php
                                                        while($fakultet = mysqli_fetch_assoc($fakulteti_set))
                                                        {
                                                            echo '<option value="'.$fakultet["fak_id"].'">'.$fakultet["naziv_fakulteta"].'</option>';
                                                        }
                                                    ?>
                                                </select>                                        
                                            </div>   
                                            
                                            <div class="form-group">
                                                <label class="form-label">Fakultet : broj diplome</label>
                                                <input type="text" class="form-control" name="broj_diplome" placeholder="Broj diplome">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Fakultet : datum</label>
                                                <input type="text" class="form-control" name="fak_datum" data-select="datepicker" placeholder="Datum">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Fakultet : nostrifikacija : rješenje broj :</label>
                                                <input type="text" class="form-control" name="fak_rjesenje" placeholder="Broj rješenja">
                                            </div>                              
                                            <div class="form-group">
                                                <label class="form-label">Fakultet : nostrifikacija : izdato od :</label>
                                                <input type="text" class="form-control" name="fak_izdato" placeholder="Izdato od">
                                            </div>                           
                                        </div>
                                        
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label">Dozvola : broj</label>
                                                <input type="text" class="form-control" name="doz_broj" placeholder="Broj dozvole">
                                            </div>    
                                            <div class="form-group">
                                                <label class="form-label">Dozvola : datum</label>
                                                <input type="text" class="form-control" name="doz_datum" data-select="datepicker" placeholder="Datum dozvole">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Dozvola : izdata od</label>
                                                <input type="text" class="form-control" name="doz_izdata" placeholder="Dozvola izdata od . . .">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Izjava : broj</label>
                                                <input type="text" class="form-control" name="izj_broj" placeholder="Broj izjave">
                                            </div>    
                                            <div class="form-group">
                                                <label class="form-label">Izjava : datum</label>
                                                <input type="text" class="form-control" name="izj_datum" data-select="datepicker" placeholder="Datum izjave">
                                            </div>                         
                                        </div>
                                        
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label">Izjava : izdata od</label>
                                                <input type="text" class="form-control" name="izj_izdata" placeholder="Izjava izdata od . . .">
                                            </div>                                         
                                            <div class="form-group">
                                                <label class="form-label">Vrsta specijalizacije</label>
                                                <select name="spec" class="form-control custom-select"> 
                                                    <option>Izaberite vrstu specijalizacije</option>
                                                    <?php
                                                        while($specijalizacija = mysqli_fetch_assoc($specijalizacije_set))
                                                        {
                                                            echo '<option value="'.$specijalizacija["vs_id"].'">'.$specijalizacija["specijalizacija"].'</option>';                                                          
                                                        }
                                                    ?>
                                                </select>                           
                                            </div>   
                                            <div class="form-group">
                                                <label class="form-label">Broj rješeja / godina</label>
                                                <input type="text" class="form-control" name="broj_rjesenja" placeholder="Broj rješejna / godina">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Datum početka staža</label>
                                                <input type="text" class="form-control" name="datum_poc_staza" data-select="datepicker" placeholder="Datum početka staža">
                                            </div>      
                                            <div class="form-group">
                                                <div class="form-label">Slika dokumenta</div>  
                                                <div class="custom-file">                                  
                                                    <input type="file" name="file" class="custom-file-input">
                                                    <label class="custom-file-label">Izaberite sliku</label>
                                                </div>   
                                            </div> 
                                            
                                        </div>
                                    
                                  </div>
                                </div>

                                <div class="col-12">                              
                                    <div class="card-header">
                                        <h3 class="card-title">Uplate</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">                               
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Uplata rate (iznos)</label>
                                                    <input type="text" class="form-control" name="upl_1" placeholder="Uplata I. rate">
                                                </div>                                                      
                                            </div>                                                          
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Datum uplate rate</label>
                                                    <input type="text" class="form-control" name="dat_up1" data-select="datepicker" placeholder="Datum uplate I. rate">
                                                </div>                                
                                            </div>                            
                                        </div>                                       
                                    </div>

                                    <div class="card-header">
                                        <h3 class="card-title">Evidencija o prestanku specijalizacije prije isteka rješenja</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">                               
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Broj rješenja / datum</label>
                                                    <input type="text" class="form-control" name="broj_rj_datum" placeholder="Broj rješenja / datum">
                                                </div>                                                      
                                            </div>                                                          
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Datum prestanka staža</label>
                                                    <input type="text" class="form-control" name="dat_pre_staza" data-select="datepicker" placeholder="Datum prestanka staža">
                                                </div>                                
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Povrat sredstava (iznos)</label>
                                                    <input type="text" class="form-control" name="povrat" placeholder="Datum prestanka staža">
                                                </div>                                
                                            </div>                    
                                        </div>
                                    </div>
                                   
                                    <div class="card-footer text-right">
                                        <div class="d-flex">
                                          <button type="submit"  id="submit" name="submit" class="btn btn-primary ml-auto"><i class="fa fa-database"></i> Spasi</button>                                      
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                           
                        </form>
                        
                    </div>
                </div>
            </div>
    

            
        </div>
      
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->