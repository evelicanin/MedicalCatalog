
<?php require_once("../resources/config.php"); ?>      <!-- konekcija na bazu i funkcije -->

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>  <!-- poziv header.php fajla iz TEMPLATE_FRONT -->
 
<?php user_is_logged();?> <!-- ako user nije logovan, vrati ga nazad na login -->

	<?php 
	
		if(isset($_GET['id'])) 
		{

			$query = query("SELECT * FROM vrste_specijalizacija WHERE vs_id = " . escape_string($_GET['id']) . " ");
			confirm($query);

			while($row = fetch_array($query))
			{
				$vs_id       = escape_string($row['vs_id']);
				$vs_title    = escape_string($row['vs_title']);		 
			}
		}
		
	 ?>
     
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
                                      
                    <div class="page-header">                
                        <h1 class="page-title">
                            Tipovi specijalizacija
                        </h1>                  
                    </div>

                    <div class="row row-cards row-deck">
                        <div class="col-12">
                            <form class="card" action="" method="post">
                                <div class="card-body">
                                  <h3 class="card-title">Editovanje šifarnika specijalizacija</h3>
                                  <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                      <div class="form-group">
                                        <label class="form-label">Tip specijalizacije</label>
                                        <input type="text" name="naziv" class="form-control" placeholder="Naziv" value="<?php echo $vs_title; ?>">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="card-footer text-right">
                                  <button type="submit" name="update_vrsta_specijalizacije" class="btn btn-primary"><i class="fe fe-database"></i> Spasi</button>
                                </div>
                            </form>          

                            <?php update_vrsta_specijalizacije();  ?>
     
                        </div>
                    </div>
                            

        
                </div>
            </div>
        </div>
      
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->