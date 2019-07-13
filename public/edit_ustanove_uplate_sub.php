
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
                    <?php 
                    
                        if(isset($_GET['id'])) 
                        {
                            $query = query("SELECT * FROM ustanove_uplate WHERE upl_id = " . escape_string($_GET['id']) . " ");
                            confirm($query);

                            while($row = fetch_array($query))
                            {
                                $us_id         = escape_string($row['us_id']); 
                                $broj_fakture  = escape_string($row['broj_fakture']); 
                                $datum_uplate  = escape_string($row['datum_uplate']);
                                $iznos_uplate  = escape_string($row['iznos_uplate']);
                            }
                            
                            $query2 = query("SELECT spec_id FROM ustanove_staz WHERE us_id = ". $us_id ." ");
                            confirm($query2);
                            while($row2 = fetch_array($query2))
                            {
                                $spec_id = escape_string($row2['spec_id']);
                            }   
                        }
                        
                     ?>          

                                                        
                    <div class="col-lg-12">
                                   
                        <div class="page-header">
                            <h1 class="page-title">Izmjena uplate</h1>                       
                        </div>  
                                         
                        <div class="btn-list text-right mb-2 mr-3" style="margin-top:-60px;">                  
                            <?php    
                                echo '<a class="btn btn-lg btn-secondary" href="view_rez_subspecijalizacija.php?id='. $spec_id .'">
                                <i class="fe fe-chevron-left"></i> Nazad na subspecijalizaciju
                                </a>';
                            ?>                                               
                        </div> 

                        <div class="row row-cards row-deck">
                            <div class="col-12">
                                <form class="card" action="" method="post">
                                    <div class="card-body">
                                    <h3 class="card-title">Izmjena uplate</h3>
                                        <div class="row">
                                            <div class="col-sm-3 col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Broj fakture</label>
                                                    <input value="<?php echo $broj_fakture; ?>" type="text" name="broj_fakture" class="form-control" placeholder="Broj fakture">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-md-3">
                                              <div class="form-group">
                                                    <label class="form-label">Datum fakture</label>
                                                    <input value="<?php 
                                                        if ($datum_uplate == '1970-01-01'){
                                                        echo '';
                                                        } else {
                                                        echo date("d.m.Y", strtotime($datum_uplate));                                            
                                                        }?>" type="text" name="datum_fakture" data-select="datepicker" class="form-control" placeholder="Datum fakture">
                                              </div>
                                            </div>
                                            <div class="col-sm-3 col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Iznos uplate</label>
                                                    <input value="<?php echo $iznos_uplate; ?>" type="text" name="iznos_uplate" class="form-control" placeholder="Iznos uplate">
                                                </div>
                                            </div>                                    
                                            <div class="col-sm-3 col-md-3">
                                                <div class="text-right mt-5">
                                                    <button type="submit" name="update_uplata" class="btn btn-primary btn-block"><i class="fe fe-database"></i> Spasi</button>
                                                </div>
                                            </div>                                   
                                        </div>
                                    </div>
                                </form>                    
                            </div>
                        </div>
                        
                        <?php update_uplata(); ?>
                                               
                    </div>            
                </div>            
                
            </div>           

            </br>
            </br>
            </br>
            </br>

      
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->