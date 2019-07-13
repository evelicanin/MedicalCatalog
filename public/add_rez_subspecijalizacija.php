
<?php require_once("../resources/config.php"); ?>      <!-- konekcija na bazu i funkcije -->
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>  <!-- poziv header.php fajla iz TEMPLATE_FRONT -->
<?php user_is_logged();?> <!-- ako user nije logovan, vrati ga nazad na login -->

<?php $fakulteti_set        = select_fakultet();         ?>
<?php $ustanove_set         = select_ustanova();         ?>
<?php $languages_set        = select_jezik();            ?>
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
            
            <?php if (isset($_GET['id'])) {
             
                $spec_id = $_GET['id']; // id specijalizacije kojoj dodajemo subspecijalizaciju
                
            }          
            ?>
            
            <?php
                if (isset($_POST['submit'])) {

                // Obrada forme	    
                $drzava           = (int)$_POST['drzava'];
                $fakultet         = (int)$_POST['fakultet'];
                $ustanova         = (int)$_POST['ustanova'];
                $spec             = (int)$_POST['spec'];
                $jezik            = (int)$_POST['jezik'];
                
                $broj_evid        = mysql_prep($_POST["broj_evid"]);
                $ime              = mysql_prep($_POST["ime"]);
                $jmbg             = mysql_prep($_POST["jmbg"]);
                $adresa           = mysql_prep($_POST["adresa"]);
                $broj_diplome     = mysql_prep($_POST["broj_diplome"]);
                
                $fak_dat          = $_POST['fak_datum'];
                $fak_datum        = date('Y-m-d',strtotime($fak_dat));   
                
                $fak_rjesenje     = mysql_prep($_POST["fak_rjesenje"]);
                $fak_izdato       = mysql_prep($_POST["fak_izdato"]);
                $str_mjesto       = mysql_prep($_POST["str_mjesto"]);
                
                $str_dat          = $_POST['str_datum'];
                $str_datum        = date('Y-m-d',strtotime($str_dat));       
                
                $str_broj         = mysql_prep($_POST["str_broj"]);
                $dokaz            = mysql_prep($_POST["dokaz"]);
                $broj_rjesenja    = mysql_prep($_POST["broj_rjesenja"]);
                
                $staz_dat         = $_POST['datum_poc_staza'];
                $datum_poc_staza  = date('Y-m-d',strtotime($staz_dat)); 
               
                $upl_1            = mysql_prep($_POST["upl_1"]);    
                $d_up1            = $_POST['dat_up1'];
                $dat_up1          = date('Y-m-d',strtotime($d_up1)); 
                
                $upl_2            = mysql_prep($_POST["upl_2"]);
                $d_up2            = $_POST['dat_up2'];
                $dat_up2          = date('Y-m-d',strtotime($d_up2)); 
                
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
                    redirect("add_rez_specijalizacija.php");
                }

                    
                    $query  = "INSERT INTO rez_subspecijalizacije (";
                    $query .= " spec_id, fak_id, u_id, l_id, d_id, vs_id, broj_evid_godina, ime_prezime, jmbg, adresa,";
                    $query .= " fak_broj_diplome, fak_datum, fak_nostro_rjesenje, fak_nostro_izdato,";
                    $query .= " strucni_ispit_mjesto, strucni_ispit_datum, strucni_ispit_broj, radni_staz_dokaz,";
                    $query .= " broj_rjesenja_godina, datum_poc_staza, uplata_prva_rata, datum_prva_rata, ";
                    $query .= " uplata_druga_rata, datum_druga_rata, broj_rjesenja_datum, povrat_sredstava, datum_pres_staza, user_unio, image ";
                    $query .= ") VALUES (";
                    $query .= "  '{$spec_id}', '{$fakultet}', '{$ustanova}', '{$jezik}', '{$drzava}', '{$spec}', '{$broj_evid}', '{$ime}', '{$jmbg}', '{$adresa}',";
                    $query .= "  '{$broj_diplome}', '{$fak_datum}', '{$fak_rjesenje}', '{$fak_izdato}', '{$str_mjesto}', '{$str_datum}', '{$str_broj}', '{$dokaz}', '{$broj_rjesenja}',";
                    $query .= "  '{$datum_poc_staza}', '{$upl_1}', '{$dat_up1}', '{$upl_2}', '{$dat_up2}', '{$broj_rj_datum}', '{$povrat}', '{$dat_pre_staza}', '{$user_unio}', '{$image}' ";
                    $query .= ")";
                    $result = mysqli_query($connection, $query);
                    
                    if ($result)
                    {
                        // Success
                        set_message("Subspecijalizacija je uspješno evidentirana.");
                        redirect("add_rez_subspecijalizacija.php");
                    } else {
                        // Failure
                        set_message("Došlo je do greške prilikom spašavanja podataka! Molimo ponovite unos.");
                        redirect("add_rez_subspecijalizacija.php");
                    }
                           
            } else {}
            ?>                 
                    <div class="row">
                        <form action="" method="post" class="card bg-blue-lighter" enctype="multipart/form-data">
                            <div class="col-12">                              
                                <div class="card-header">
                                   <h3 class="card-title">Unos subspecijalizacije državljana BiH</h3>
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
                                                <label class="form-label">JMBG</label>
                                                <input type="text" class="form-control" name="jmbg" placeholder="JMBG">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Mjesto i adresa prebivališta</label>
                                                <input type="text" class="form-control" name="adresa" placeholder="Mjesto i adresa">
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
                                                <label class="form-label">Stručni ispit : mjesto</label>
                                                <input type="text" class="form-control" name="str_mjesto" placeholder="Mjesto">
                                            </div>    
                                            <div class="form-group">
                                                <label class="form-label">Stručni ispit : datum</label>
                                                <input type="text" class="form-control" name="str_datum" data-select="datepicker" placeholder="Datum">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Stručni ispit : broj uvjerenja</label>
                                                <input type="text" class="form-control" name="str_broj" placeholder="Broj uvjerenja">
                                            </div>   
                                             <div class="form-group">
                                                <label class="form-label">Strani jezik</label>
                                                <select name="jezik" class="form-control custom-select"> 
                                                    <option>Izaberite strani jezik</option>
                                                    <?php
                                                        while($language = mysqli_fetch_assoc($languages_set))
                                                        {
                                                            echo '<option value="'.$language["l_id"].'">'.$language["jezik"].'</option>';
                                                        }
                                                    ?>
                                                </select>                                         
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
                                        </div>
                                        
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label">Radni staž : ustanova</label>
                                                <select name="ustanova" class="form-control custom-select"> 
                                                    <option>Izaberite ustanovu</option>
                                                    <?php
                                                        while($ustanova = mysqli_fetch_assoc($ustanove_set))
                                                        {
                                                            echo '<option value="'.$ustanova["u_id"].'">'.$ustanova["naziv_ustanove"].'</option>';                                                                                                                     
                                                        }
                                                    ?>
                                                </select>                                       
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Radni staž : dokaz</label>
                                                <input type="text" class="form-control" name="dokaz" placeholder="Dokaz">
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
                                                    <label class="form-label">Uplata I. rate (iznos)</label>
                                                    <input type="text" class="form-control" name="upl_1" placeholder="Uplata I. rate">
                                                </div>                                                      
                                            </div>                                                          
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Datum uplate I. rate</label>
                                                    <input type="text" class="form-control" name="dat_up1" data-select="datepicker" placeholder="Datum uplate I. rate">
                                                </div>                                
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Uplata II. rate (iznos)</label>
                                                    <input type="text" class="form-control" name="upl_2" placeholder="Uplata II. rate">
                                                </div>                                
                                            </div>                    
                                            <div class="col-md-6 col-lg-3">                                                                        
                                                <div class="form-group">
                                                    <label class="form-label">Datum uplate II. rate</label>
                                                    <input type="text" class="form-control" name="dat_up2" data-select="datepicker" placeholder="Datum uplate II. rate">
                                                </div>                                            
                                            </div>                              
                                        </div>                                       
                                    </div>

                                    <div class="card-header">
                                        <h3 class="card-title">Evidencija o prestanku subspecijalizacije prije isteka rješenja</h3>
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