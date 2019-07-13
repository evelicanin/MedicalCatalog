
<?php require_once("../resources/config.php"); ?>      <!-- konekcija na bazu i funkcije -->

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>  <!-- poziv header.php fajla iz TEMPLATE_FRONT -->
 
<?php user_is_logged();?> <!-- ako user nije logovan, vrati ga nazad na login -->
 
    <div class="page"> <!-- zatvoren div u footer.php -->
    
        <div class="page-main">
        
        <?php include(TEMPLATE_FRONT . DS . "top_nav.php"); ?> 
 
        <div class="my-3 my-md-5" style="min-height:400px;">
            <div class="container">
                       
                <div class="col-lg-12">

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
                        <h1 class="page-title">Subspecijalizacije stranih državljana</h1>                       
                    </div>  
                             
                    <!--                             
                    <div class="btn-list text-right mb-2 mr-3" style="margin-top:-60px;">                  
                        <a href="add_nerez_subspecijalizacija.php" class="btn btn-indigo btn-lg"><i class="fa fa-plus"></i> &nbsp;&nbsp;Dodaj specijalizaciju</a>
                    </div> 
                    -->
                                      
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
                              <th>Subspecijalizacija</th>
                              <th>Specijalizacija</th>
                              <th>Ime (ime oca) i prezime</th>
                              <th>Datum rođenja</th>
                              <th>Dozvola o  boravku</th>
                              <th class="text-right">Pregled / Izmjena / Brisanje</th>
                            </tr>
                          </thead>
                          <tbody>
                                <?php lista_nerez_subspecijalizacija();?>
                          </tbody>                            
                        </table>
                    </div>
                </div>            
            </div>            
            
        </div>            


 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->