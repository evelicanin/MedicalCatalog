
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

                <?php if(isset($_GET['id'])) 
                    {
                    
                        $spec_id = $_GET['id'];
                        
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
                            $fak_rjesenje     = escape_string($row['fak_nostro_rjesenje']);                         
                            $fak_izdato       = escape_string($row['fak_nostro_izdato']);                         
                            $str_mjesto       = escape_string($row['strucni_ispit_mjesto']);                                                    
                            $str_datum        = escape_string($row['strucni_ispit_datum']);                            
                            $str_broj         = escape_string($row['strucni_ispit_broj']);                         
                            $dokaz            = escape_string($row['radni_staz_dokaz']);                            
                            $broj_rjesenja    = escape_string($row['broj_rjesenja_godina']);                              
                            $datum_poc_staza  = escape_string($row['datum_poc_staza']);                        
                            $upl_1            = escape_string($row['uplata_prva_rata']);                                                
                            $dat_up1          = escape_string($row['datum_prva_rata']);                                                                
                            $upl_2            = escape_string($row['uplata_druga_rata']);                                               
                            $dat_up2          = escape_string($row['datum_druga_rata']);                         
                            $image            = escape_string($row['image']);                         
       
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
                        
                        <div class="page-header">
                          <h1 class="page-title">
                            <?php echo 'Specijalizacija broj : <b>' . $broj_evid . '</b>'; ?>
                          </h1>
                        </div>
                   
                        <div class="row mt-3">  
                               
                            <div class="col-md-6 col-xl-4">
                                <div class="card animated slideInUp">
                                    <div class="card-status card-status-left bg-blue"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Lični podaci</h3>
                                        <div class="card-options">
                                          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php echo 'Ime (ime oca) i prezime : <b><span style="color:blue;">' . $ime . '</span></b></br>';  ?>
                                        <?php echo 'JMBG : <b><span style="color:blue;">' . $jmbg . '</span></b></br>'; ?>
                                        <?php echo 'Mjesto i adresa prebivališta : <b><span style="color:blue;">' . $adresa . '</span></b></br>'; ?>
                                        <?php echo 'Državljanstvo : <b><span style="color:blue;">' . $d_title . '</span></b></br></br>'; ?>       
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card animated slideInUp">
                                    <div class="card-status card-status-left bg-purple"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Podaci o fakultetu</h3>
                                        <div class="card-options">
                                          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php echo 'Završen fakultet : <b><span style="color:purple;">' . $fak_title . '</span></b></br>';  ?>
                                        <?php echo 'Broj diplome : <b><span style="color:purple;">' . $jmbg . '</span></b></br>'; ?>
                                        <?php //echo 'Datum : <b><span style="color:purple;">' . $fak_datum . '</span></b></br>'; ?>                                     
                                        <?php 
                                            if ($fak_datum == '1970-01-01'){
                                            echo 'Datum  : <b><span style="color:purple;"> / ' . '</span></b></br>';
                                            } else {
                                            echo 'Datum  : <b><span style="color:purple;">' . date("d.m.Y", strtotime($fak_datum)) . '</span></b></br>' ;                                            
                                            }    
                                        ?>                                          
                                        <?php echo 'Nostrifikacija : rješenje broj : <b><span style="color:purple;">' . $fak_rjesenje . '</span></b></br>'; ?>       
                                        <?php echo 'Nostrifikacija : izdato od : <b><span style="color:purple;">' . $fak_izdato . '</span></b>'; ?>       
                                    
                                    </div>
                                </div>
                            </div>       
                            <div class="col-md-6 col-xl-4">
                                <div class="card animated slideInUp">
                                    <div class="card-status card-status-left bg-teal"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Podaci o stručnosti</h3>
                                        <div class="card-options">
                                          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php echo 'Stručni ispit : mjesto: <b><span style="color:teal;">' . $str_mjesto . '</span></b></br>';  ?>                                         
                                        <?php 
                                            if ($str_datum == '1970-01-01'){
                                            echo 'Stručni ispit : datum  : <b><span style="color:teal;"> / ' . '</span></b></br>';
                                            } else {
                                            echo 'Stručni ispit : datum  : <b><span style="color:teal;">' . date("d.m.Y", strtotime($str_datum)) . '</span></b></br>' ;                                            
                                            }    
                                        ?>                                                                                 
                                        <?php echo 'Stručni ispit : broj uvjerenja : <b><span style="color:teal;">' . $str_broj . '</span></b></br>'; ?>
                                        <?php echo 'Strani jezik : <b><span style="color:teal;">' . $l_title . '</span></b></br>'; ?>       
                                        <?php echo 'Vrsta specijalizacije : <b><span style="color:teal;">' . $vs_title . '</span></b>'; ?>       
                                    
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-6 col-xl-4">
                                <div class="card animated slideInUp">
                                    <div class="card-status card-status-left bg-orange"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Podaci o stažu</h3>
                                        <div class="card-options">
                                          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php echo 'Radni staž - ustanova : <b><span style="color:orange;">' . $ust . '</span></b></br>';  ?>
                                        <?php echo 'Radni staž - dokaz : <b><span style="color:orange;">' . $dokaz . '</span></b></br>'; ?>
                                        <?php echo 'Broj rješenja / godina : <b><span style="color:orange;">' . $broj_rjesenja . '</span></b></br>'; ?>
                                        <?php // echo 'Datum početka staža : <b><span style="color:orange;">' . $datum_poc_staza . '</span></b></br>'; ?>                                          
                                        <?php 
                                            if ($datum_poc_staza == '1970-01-01'){
                                            echo 'Datum : <b><span style="color:orange;"> / ' . '</span></b></br>';
                                            } else {
                                            echo 'Datum : <b><span style="color:orange;">' . date("d.m.Y", strtotime($datum_poc_staza)) . '</span></b></br>' ;                                            
                                            }    
                                        ?>                                        
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-6 col-xl-4">
                                <div class="card animated slideInUp">
                                    <div class="card-status card-status-left bg-red"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Podaci o uplatama</h3>
                                        <div class="card-options">
                                          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php echo 'Uplata I. rate (iznos) : <b><span style="color:red;">' . $upl_1 . '</span></b></br>';  ?>
                                        <?php 
                                            if ($dat_up1 == '1970-01-01'){
                                            echo 'Datum uplate I. rate  : <b><span style="color:red;"> / ' . '</span></b></br>';
                                            } else {
                                            echo 'Datum uplate I. rate  : <b><span style="color:red;">' . date("d.m.Y", strtotime($dat_up1)) . '</span></b></br>' ;                                            
                                            }    
                                        ?>                                             
                                        <?php echo 'BUplata II. rate (iznos) : <b><span style="color:red;">' . $upl_2 . '</span></b></br>'; ?>
                                        <?php 
                                            if ($dat_up2 == '1970-01-01'){
                                            echo 'Datum uplate I. rate  : <b><span style="color:red;"> / ' . '</span></b></br>';
                                            } else {
                                            echo 'Datum uplate I. rate  : <b><span style="color:red;">' . date("d.m.Y", strtotime($dat_up2)) . '</span></b></br>' ;                                            
                                            }    
                                        ?>                                      
                                    </div>
                                </div>
                            </div>                             
                        </div>
                  
                    </div>
                </div>
 
                <div class="my-3 my-md-5">
                    <div class="container">

                        <div class="page-header">
                          <h1 class="page-title">
                            <?php echo 'Zdravstvene ustanove u koijma se  obavlja stažiranje'; ?>
                          </h1>
                        </div>
                                                                  
                           
                        <div class="row row-cards row-deck">
                            <div class="col-12">
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table card-table table-vcenter text-nowrap">
                                            <thead>
                                                <tr>
                                                  <th>Naziv ustanove</th>
                                                  <th>Iznos</th>
                                                  <th>Suma uplata</th>
                                                  <th>Preostalo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php print_lista_ustanova_staziranja($spec_id, 'RS');?>
                                            </tbody>
                                        </table>                                   
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                                                
                    </div>
                </div>
                
        </div>
      
