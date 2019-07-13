
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

                    <?php if(isset($_GET['id'])) 
                        {

                            $query = query("SELECT * FROM rez_specijalizacije WHERE spec_id = " . escape_string($_GET['id']) . " ");
                            confirm($query);
                            while($row = fetch_array($query))
                            {
                                                    
                                $drzava           = escape_string($row['d_id']);                         
                                $fak              = escape_string($row['fak_id']);                         
                                $ust              = escape_string($row['u_id']);                         
                                $spec             = escape_string($row['vs_id']);                         
                                $jez              = escape_string($row['l_id']); 
                                
                                $broj_evid        = escape_string($row['broj_evid_godina']);                         
                                $ime              = escape_string($row['ime_prezime']);                         
                                $jmbg             = escape_string($row['jmbg']);                         
                                $adresa           = escape_string($row['adresa']);                         
                                $broj_diplome     = escape_string($row['fak_broj_diplome']);                                                     
                                
                                $fak_datum        = escape_string($row['fak_datum']);                            
                                if ($fak_datum == '1970-01-01'){ $fak_datum = '';
                                } else {
                                    $fak_datum = date("d.m.Y", strtotime($fak_datum));
                                }                                                                 
                                $fak_rjesenje     = escape_string($row['fak_nostro_rjesenje']);                         
                                $fak_izdato       = escape_string($row['fak_nostro_izdato']);                         
                                
                                $str_mjesto       = escape_string($row['strucni_ispit_mjesto']);                                                    
                                $str_datum        = escape_string($row['strucni_ispit_datum']);                            
                                if ($str_datum == '1970-01-01'){
                                    $str_datum = '';
                                } else {
                                    $str_datum = date("d.m.Y", strtotime($str_datum));
                                }                                
                                $str_broj         = escape_string($row['strucni_ispit_broj']);                         
                                
                                $dokaz            = escape_string($row['radni_staz_dokaz']);                            
                                $broj_rjesenja    = escape_string($row['broj_rjesenja_godina']);                              
                                $datum_poc_staza  = escape_string($row['datum_poc_staza']);                        
                                if ($datum_poc_staza == '1970-01-01'){
                                    $datum_poc_staza = '';
                                } else {
                                    $datum_poc_staza = date("d.m.Y", strtotime($datum_poc_staza));
                                }                                 
                                
                                $upl_1            = escape_string($row['uplata_prva_rata']);                                                
                                $dat_up1          = escape_string($row['datum_prva_rata']);                                                                
                                if ($dat_up1 == '1970-01-01'){
                                    $dat_up1 = '';
                                } else {
                                    $dat_up1 = date("d.m.Y", strtotime($dat_up1));
                                }                                    
                                
                                $upl_2            = escape_string($row['uplata_druga_rata']);                                               
                                $dat_up2          = escape_string($row['datum_druga_rata']);                         
                                if ($dat_up2 == '1970-01-01'){
                                    $dat_up2 = '';
                                } else {
                                    $dat_up2 = date("d.m.Y", strtotime($dat_up2));
                                }    
                                
                                $broj_rj_datum    = escape_string($row['broj_rjesenja_datum']);                                                                
                                $dat_pre_staza    = escape_string($row['datum_pres_staza']);                                               
                                if ($dat_pre_staza == '1970-01-01'){
                                    $dat_pre_staza = '';
                                } else {
                                    $dat_pre_staza = date("d.m.Y", strtotime($dat_pre_staza));
                                }                                  
                                
                                $povrat           = escape_string($row['povrat_sredstava']);            
         
                            }
                             
                            $query2 = query("SELECT * FROM drzavljanstva WHERE d_id = ". $drzava ." ");
                            confirm($query2);
                            while($row2 = fetch_array($query2))
                            {
                                $d_title    = escape_string($row2['d_title']);
                            } 
                            
                            $query3 = query("SELECT * FROM ustanove WHERE u_id = ". $ust ." ");
                            confirm($query3);
                            while($row3 = fetch_array($query3))
                            {
                                $u_title    = escape_string($row3['u_title']);
                                $u_city     = escape_string($row3['u_city']);
                            }                    
                            
                            $query4 = query("SELECT * FROM fakulteti WHERE fak_id = ". $fak ." ");
                            confirm($query4);
                            while($row4 = fetch_array($query4))
                            {
                                $fak_title    = escape_string($row4['fak_title']);
                                $fak_city     = escape_string($row4['fak_city']);
                            } 
                            
                            $query5 = query("SELECT * FROM strani_jezici WHERE l_id = ". $jez ." ");
                            confirm($query5);
                            while($row5 = fetch_array($query5))
                            {
                                $l_title    = escape_string($row5['l_title']);
                            } 

                            $query6 = query("SELECT * FROM vrste_specijalizacija WHERE vs_id = ". $spec ." ");
                            confirm($query6);
                            while($row6 = fetch_array($query6))
                            {
                                $vs_title    = escape_string($row6['vs_title']);
                            }                     
                        }   
                    ?>                            
                    <div class="row">
                        <form action="" method="post" class="card" enctype="multipart/form-data">
                            <div class="col-12">                              
                                <div class="card-header">
                                   <h3 class="card-title">Izmjena specijalizacije broj : <b> <?php echo $broj_evid; ?> </b></h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">                                   
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label">Broj evidencije / godina</label>
                                                <input value="<?php echo $broj_evid; ?>" type="text" class="form-control" name="broj_evid" placeholder="Broj evidencije / godina">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Ime (ime oca) i prezime</label>
                                                <input value="<?php echo $ime; ?>" type="text" class="form-control" name="ime" placeholder="Ime (ime oca) i prezime..">
                                            </div>                                  
                                            <div class="form-group">
                                                <label class="form-label">JMBG</label>
                                                <input value="<?php echo $jmbg; ?>" type="text" class="form-control" name="jmbg" placeholder="JMBG">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Mjesto i adresa prebivališta</label>
                                                <input value="<?php echo $adresa; ?>" type="text" class="form-control" name="adresa" placeholder="Mjesto i adresa">
                                            </div>     
                                            <div class="form-group">
                                                <label class="form-label">Državljanstvo</label>
                                                <select name="drzava" class="form-control custom-select"> 
                                                    <option value="<?php echo $drzava; ?>"><?php echo $d_title; ?></option>
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
                                                    <option value="<?php echo $fak; ?>"><?php echo $fak_title . ' ' . $fak_city; ?>  </option>
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
                                                <input value="<?php echo $broj_diplome; ?>" type="text" class="form-control" name="broj_diplome" placeholder="Broj diplome">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Fakultet : datum</label>
                                                <input value="<?php echo $fak_datum; ?>" type="text" class="form-control" name="fak_datum" data-select="datepicker" placeholder="Datum">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Fakultet : nostrifikacija : rješenje broj :</label>
                                                <input value="<?php echo $fak_rjesenje; ?>"  type="text" class="form-control" name="fak_rjesenje" placeholder="Broj rješenja">
                                            </div>                              
                                            <div class="form-group">
                                                <label class="form-label">Fakultet : nostrifikacija : izdato od :</label>
                                                <input value="<?php echo $fak_izdato; ?>" type="text" class="form-control" name="fak_izdato" placeholder="Izdato od">
                                            </div>                           
                                        </div>
                                        
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label">Stručni ispit : mjesto</label>
                                                <input value="<?php echo $str_mjesto; ?>" type="text" class="form-control" name="str_mjesto" placeholder="Mjesto">
                                            </div>    
                                            <div class="form-group">
                                                <label class="form-label">Stručni ispit : datum</label>
                                                <input value="<?php echo $str_datum; ?>"  type="text" class="form-control" name="str_datum" data-select="datepicker" placeholder="Datum">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Stručni ispit : broj uvjerenja</label>
                                                <input value="<?php echo $str_broj; ?>" type="text" class="form-control" name="str_broj" placeholder="Broj uvjerenja">
                                            </div>   
                                             <div class="form-group">
                                                <label class="form-label">Strani jezik</label>
                                                <select name="jezik" class="form-control custom-select"> 
                                                    <option value="<?php echo $jez; ?>"><?php echo $l_title; ?></option>
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
                                                    <option value="<?php echo $spec; ?>"><?php echo $vs_title; ?></option>
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
                                                    <option value="<?php echo $ust; ?>"><?php echo $u_title . ' ' .$u_city; ?>  </option>
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
                                                <input value="<?php echo $dokaz; ?>"  type="text" class="form-control" name="dokaz" placeholder="Dokaz">
                                            </div>  
                                            <div class="form-group">
                                                <label class="form-label">Broj rješenja / godina</label>
                                                <input value="<?php echo $broj_rjesenja; ?>" type="text" class="form-control" name="broj_rjesenja" placeholder="Broj rješejna / godina">
                                            </div> 
                                            <div class="form-group">
                                                <label class="form-label">Datum početka staža</label>
                                                <input value="<?php echo $datum_poc_staza; ?>"  type="text" class="form-control" name="datum_poc_staza" data-select="datepicker" placeholder="Datum početka staža">
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
                                                    <input value="<?php echo $upl_1; ?>"  type="text" class="form-control" name="upl_1" placeholder="Uplata I. rate">
                                                </div>                                                      
                                            </div>                                                          
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Datum uplate I. rate</label>
                                                    <input value="<?php if ($dat_up1 === NULL and $dat_up1 != '') { echo '';} else { echo $dat_up1; } ?>"  type="text" class="form-control" name="dat_up1" data-select="datepicker" placeholder="Datum uplate I. rate">
                                                </div>                                
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Uplata II. rate (iznos)</label>
                                                    <input value="<?php echo $upl_2; ?>"  type="text" class="form-control" name="upl_2" placeholder="Uplata II. rate">
                                                </div>                                
                                            </div>                    
                                            <div class="col-md-6 col-lg-3">                                                                        
                                                <div class="form-group">
                                                    <label class="form-label">Datum uplate II. rate</label>
                                                    <input value="<?php if (!is_null($dat_up2)) { echo $dat_up2;} else { echo ''; }  ?>" type="text" class="form-control" name="dat_up2"  data-select="datepicker" placeholder="Datum uplate II. rate">
                                                </div>                                            
                                            </div>                              
                                        </div>
                                    </div>
                                    
                                    <div class="card-header">
                                        <h3 class="card-title">Evidencija o prestanke specijalizacije prije isteka rješenja</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">                               
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Broj rješenja / datum</label>
                                                    <input value="<?php echo $broj_rj_datum; ?>" type="text" class="form-control" name="broj_rj_datum" placeholder="Broj rješenja / datum">
                                                </div>                                                      
                                            </div>                                                          
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Datum prestanka staža</label>
                                                    <input value="<?php echo $dat_pre_staza; ?>" type="text" class="form-control" name="dat_pre_staza" data-select="datepicker" placeholder="Datum prestanka staža">
                                                </div>                                
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Povrat sredstava (iznos)</label>
                                                    <input value="<?php echo $povrat; ?>"  type="text" class="form-control" name="povrat" placeholder="Povrat sredstava (iznos">
                                                </div>                                
                                            </div>                    
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer text-right">
                                        <div class="d-flex">
                                          <button type="submit"  id="submit" name="update_rez_specijalizacija" class="btn btn-primary ml-auto"><i class="fa fa-database"></i> Spasi</button>                                      
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </form>
                        
                        <?php update_rez_specijalizacija();  ?>
                        
                    </div>
                </div>
            </div>
    

            
        </div>
      
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->