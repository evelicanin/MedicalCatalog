
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
                    
	                <?php add_vrsta_specijalizacije(); ?>      
                    
                    <div class="page-header">                
                      <h1 class="page-title">
                        Tipovi specijalizacija
                      </h1>                  
                    </div>
                    
                    <div class="row row-cards row-deck">
                            <div class="col-12">
                                <div class="card">
                                  <div class="card-header">
                                  

                                        <div class="col-sm-12 col-md-12">                                                                            
                                            <input type="text" class="form-control header-search search_input" name="search" id="id_search" placeholder="Pretraga&hellip;" tabindex="1">
                                            <div class="input-icon-addon mr-2">
                                              <i class="fe fe-search"></i>
                                            </div>                                           
                                        </div>
                  
                                  </div>
                                  <div class="table-responsive">
                                    <table class="table card-table table-vcenter text-nowrap">
                                      <thead>
                                        <tr>
                                          <th>Naziv</th>
                                          <th></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      	    <?php lista_vrsta_specijalizacija();?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        
                        </div>
  
                    <div class="row row-cards row-deck">
                        <div class="col-12">
                            <form class="card" action="" method="post">
                                <div class="card-body">
                                  <h3 class="card-title">Dodavanje vrste specijalizacije u šifarnik</h3>
                                  <div class="row">
                                    <div class="col-sm-8 col-md-8">
                                      <div class="form-group">
                                        <label class="form-label">Naziv</label>
                                        <input type="text" name="naziv" class="form-control" placeholder="Naziv">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="card-footer text-right">
                                  <button type="submit" name="add_vrsta_specijalizacije" class="btn btn-primary"><i class="fe fe-database"></i> Spasi</button>
                                </div>
                            </form>                    
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
      
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->