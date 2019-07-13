<?php require_once("../resources/config.php"); ?>      <!-- konekcija na bazu i funkcije -->
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>  <!-- poziv header.php fajla iz TEMPLATE_FRONT -->
 
<?php user_is_logged();?> <!-- ako user nije logovan, vrati ga nazad na login -->
 
<?php $ustanove_set = select_ustanova();?>
 
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
                    
	                <?php // add_zdravstvena_ustanova(); 
                        if(isset($_POST['add_zdravstvena_ustanova_nerez'])) 
                        {
                            $ustanova  = (int)$_POST['ustanova'];
                            $period    = escape_string($_POST['period']);
                            $iznos     = escape_string($_POST['iznos']);
                            $user_unio = $_SESSION['username'];
                            
                            if(isset($_GET['id'])) 
                            {
                                $spec_id = $_GET['id']; // ID SPECIJALIZACIJE --> spec_id
                                
                                // proslijedjujemo RS jer je SUBspecijalizacija u pitanju
                                $insert_user = query("INSERT INTO ustanove_staz_nerez(spec_id, u_id, iznos, period_staza, oznaka, user_unio) VALUES ('{$spec_id}', '{$ustanova}', '{$iznos}', '{$period}', 'NS', '{$user_unio}') ");
                                confirm($insert_user);
                                set_message( "Ustanova uspješno dodana."); 
                                header("Refresh:0");                                
                            }
                            else {
                                set_message( "Došlo je do greške prilikom dodavanja Ustanove");                           
                                header("Refresh:0");
                            }                            
                        }                                       
                    ?>      
                    
                    
                    <div class="page-header">                
                      <h1 class="page-title">
                        Strani državljani | Dodavanje zdravstvenih ustanova u kojima se obavlja specijalizacija
                      </h1>                  
                    </div>
                    <div class="btn-list text-right mb-2 mr-3" style="margin-top:-60px;">                  
                        <?php    
                            echo '<a class="btn btn-lg btn-secondary" href="view_nerez_specijalizacija.php?id='. $_GET['id'] .'">
						    <i class="fe fe-chevron-left"></i> Nazad na specijalizaciju
                            </a>';
                        ?>
                    </div> 
                        
                    <div class="row row-cards row-deck">
                        <div class="col-12">
                            <form class="card" action="" method="post">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                      <div class="form-group">
                                        <label class="form-label">Naziv ustanove</label>
                                        <!-- <input type="text" name="naziv" class="form-control" placeholder="Naziv"> -->
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
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                      <div class="form-group">
                                        <label class="form-label">Period trajanaj staža (u mjesecima)</label>
                                        <input type="text" name="period" class="form-control" placeholder="Period trajanja staža">
                                      </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                      <div class="form-group">
                                        <label class="form-label">Iznos</label>
                                        <input type="text" name="iznos" class="form-control" placeholder="Iznos">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="card-footer text-right">
                                  <button type="submit" name="add_zdravstvena_ustanova_nerez" class="btn btn-primary"><i class="fe fe-database"></i> Spasi</button>
                                </div>
                            </form>                    
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
      
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->