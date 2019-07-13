
<?php require_once("../resources/config.php"); ?>      <!-- konekcija na bazu i funkcije -->

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>  <!-- poziv header.php fajla iz TEMPLATE_FRONT -->
 
<?php user_is_logged();?> <!-- ako user nije logovan, vrati ga nazad na login -->
 
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
                $us_id = $_GET['id']; // id ustanove koji smo proslijedili sa maske specijalizacije
            
                $query2 = query("SELECT spec_id FROM ustanove_staz_nerez WHERE us_id = ". $us_id ." ");
                confirm($query2);
                while($row2 = fetch_array($query2))
                {
                    $spec_id = escape_string($row2['spec_id']);
                }                
            } 
            ?>            
            <?php if (isset($_POST['add_uplata_nerez'])) 
            {
                $broj_fakture         = mysql_prep($_POST["broj_fakture"]);
                $datum_fak            = $_POST['datum_fakture'];              
                $datum_fakture        = date('Y-m-d',strtotime($datum_fak));
                $iznos_uplate         = mysql_prep($_POST["iznos_uplate"]);
                $user_unio            = $_SESSION['username'];
                
                if (!empty($errors)) {
                    $_SESSION["errors"] = $errors;
                    redirect('ustanove_uplate_nerez_sub.php?id='.$us_id.'');
                }               

                // insert u tabelu taskova
                $query  = "INSERT INTO ustanove_uplate_nerez (";
                $query .= " us_id, iznos_uplate, datum_uplate, broj_fakture, user_unio ";
                $query .= ") VALUES (";
                $query .= "  '{$us_id}', '{$iznos_uplate}', '{$datum_fakture}', '{$broj_fakture}', '{$user_unio}'";
                $query .= ")";
                $result = mysqli_query($connection, $query); 

                if ($result)
                {
                    // Success
                    set_message("Uplata je uspješno evidentirana.");
                    redirect('ustanove_uplate_nerez_sub.php?id='.$us_id.'');
                } else {
                    // Failure
                    set_message("Došlo je do greške prilikom spašavanja podataka! Molimo ponovite unos.");
                    redirect('ustanove_uplate_nerez_sub.php?id='.$us_id.'');
                               
                }               
            }
            ?>      
         
                    <div class="col-lg-12">
                                   
                        <div class="page-header">
                            <h1 class="page-title">Subspecijalizacije stranih državljana | Uplate ustanove</h1>                       
                        </div>  
                                         
                        <div class="btn-list text-right mb-2 mr-3" style="margin-top:-60px;">                  
                            <?php    
                                echo '<a class="btn btn-lg btn-secondary" href="view_nerez_subspecijalizacija.php?id='. $spec_id .'">
                                <i class="fe fe-chevron-left"></i> Nazad na subspecijalizaciju
                                </a>';
                            ?>                                               
                        </div> 

                        <div class="row row-cards row-deck">
                            <div class="col-12">
                                <form class="card" action="" method="post">
                                    <div class="card-body">
                                    <h3 class="card-title">Unos uplate</h3>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Broj fakture</label>
                                                    <input type="text" name="broj_fakture" class="form-control" placeholder="Broj fakture">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-md-3">
                                              <div class="form-group">
                                                    <label class="form-label">Datum fakture</label>
                                                    <input type="text" name="datum_fakture" data-select="datepicker" class="form-control" placeholder="Datum fakture">
                                              </div>
                                            </div>
                                            <div class="col-sm-3 col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Iznos uplate</label>
                                                    <input type="text" name="iznos_uplate" class="form-control" placeholder="Iznos uplate">
                                                </div>
                                            </div>                                    
                                            <div class="col-sm-3 col-md-3">
                                                <div class="text-right mt-5">
                                                    <button type="submit" name="add_uplata_nerez" class="btn btn-primary btn-block"><i class="fe fe-database"></i> Spasi</button>
                                                </div>
                                            </div>                                   
                                        </div>
                                    </div>
                                </form>                    
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-12 mb-2">                                                                            
                            <input type="text" class="form-control header-search search_input" name="search" id="id_search" placeholder="Pretraga&hellip;" tabindex="1">
                            <div class="input-icon-addon mr-2">
                              <i class="fe fe-search"></i>
                            </div>                                           
                        </div> 
                        
                        <div class="card">
                            <table class="table card-table table-vcenter">
                                <thead>
                                    <tr>
                                        <th><strong>Broj fakture</strong></th>
                                        <th><strong>Datum uplate</strong></th>
                                        <th class="text-right"><strong>Iznos uplate</strong></th>
                                        <th class="text-right">operacije</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    <?php lista_uplata_nerez($us_id, 'NSS');?>
                                </tbody>                                                   
                            </table>
                        </div>
                    </div>            
                </div>            
                
            </div>            

      
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->