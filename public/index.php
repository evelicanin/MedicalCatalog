
<?php require_once("../resources/config.php"); ?>      <!-- konekcija na bazu i funkcije -->

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>  <!-- poziv header.php fajla iz TEMPLATE_FRONT -->
 
<?php user_is_logged();?> <!-- ako user nije logovan, vrati ga nazad na login -->
 
    <div class="page"> <!-- zatvoren div u footer.php -->
    
        <div class="page-main">
        
            <?php include(TEMPLATE_FRONT . DS . "top_nav.php"); ?> 
 
		    <?php  	
                if (isset($_SESSION['message']))
                {
					echo '<div class="animated fadeInUp alert alert-primary alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"></button>';			
					        display_message();                                                       
					echo '</div>';				
				}							
			?>


        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <h1 class="page-title">
                Državljani BiH
              </h1>
            </div>
            <div class="row row-cards">
                <div class="col-6 col-sm-4 col-lg-2">
                  <div class="card">
                    <div class="card-body p-3 text-center">
                      <div class="h1 m-0"> <?php count_specijalizacije();?></div>
                      <div class="text-muted mb-4">Broj </br>specijalizacija</div>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                  <div class="card">
                    <div class="card-body p-3 text-center">
                      <div class="h1 m-0"><?php count_uplate_spec();?></div>
                      <div class="text-muted mb-4">Broj uplata za specijalizacije</div>
                    </div>
                  </div>
                </div>                
                <div class="col-6 col-sm-4 col-lg-2">
                  <div class="card">
                    <div class="card-body p-3 text-center">
                      <div class="h1 m-0"><?php count_subspecijalizacije(); ?></div>
                      <div class="text-muted mb-4">Broj </br>subspecijalizacija</div>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                  <div class="card">
                    <div class="card-body p-3 text-center">
                      <div class="h1 m-0"><?php count_uplate_subspec();?></div>
                      <div class="text-muted mb-4">Broj uplata za subspecijalizacije</div>
                    </div>
                  </div>
                </div>               
                <div class="col-6 col-sm-4 col-lg-4">

                    <a href="rez_specijalizacije.php" class="btn btn-azure btn-lg">
                      <i class="fe fe-menu"></i>
                      Specijalizacije
                    </a>        
                                        
                    <a href="rez_subspecijalizacije.php" class="mt-3 btn btn-blue btn-lg">
                      <i class="fe fe-list"></i>
                      Subspecijalizacije
                    </a>  

                </div>

            </div>
          

              <h1 class="page-title">
                Strani državljani
              </h1>

            <div class="row row-cards">
                <div class="col-6 col-sm-4 col-lg-2">
                  <div class="card bg-blue-lightest">
                    <div class="card-body p-3 text-center">
                      <div class="h1 m-0"> <?php count_specijalizacije_nerez();?></div>
                      <div class="text-muted mb-4">Broj </br>specijalizacija</div>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                  <div class="card bg-blue-lightest">
                    <div class="card-body p-3 text-center">
                      <div class="h1 m-0"><?php count_uplate_spec_nerez();?></div>
                      <div class="text-muted mb-4">Broj uplata za specijalizacije</div>
                    </div>
                  </div>
                </div>                
                <div class="col-6 col-sm-4 col-lg-2">
                  <div class="card bg-blue-lightest">
                    <div class="card-body p-3 text-center">
                      <div class="h1 m-0"><?php count_subspecijalizacije_nerez(); ?></div>
                      <div class="text-muted mb-4">Broj </br>subspecijalizacija</div>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                  <div class="card bg-blue-lightest">
                    <div class="card-body p-3 text-center">
                      <div class="h1 m-0"><?php count_uplate_subspec_nerez();?></div>
                      <div class="text-muted mb-4">Broj uplata za subspecijalizacije</div>
                    </div>
                  </div>
                </div>               
                <div class="col-6 col-sm-4 col-lg-4">

                    <a href="nerez_specijalizacije.php" class="btn btn-teal btn-lg">
                      <i class="fe fe-menu"></i>
                      Specijalizacije
                    </a>        
                                        
                    <a href="nerez_subspecijalizacije.php" class="mt-3 btn btn-cyan btn-lg">
                      <i class="fe fe-list"></i>
                      Subspecijalizacije
                    </a>  

                </div>

            </div>
                    
          </div>
        </div>
            
        
        </div>
      
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->