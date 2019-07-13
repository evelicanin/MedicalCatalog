
<?php require_once("../resources/config.php"); ?>      <!-- konekcija na bazu i funkcije -->
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>  <!-- poziv header.php fajla iz TEMPLATE_FRONT -->
 
<?php user_is_logged();?> <!-- ako user nije logovan, vrati ga nazad na login -->

<?php $ustanove_set = select_ustanova();?>

	<?php 
	    
		if(isset($_GET['id'])) 
		{
            $query = query("SELECT us.us_id as id,us.spec_id as specid, u.u_id as ustanova_id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.us_id =". escape_string($_GET['id']) ." ");			
            confirm($query);

			while($row = fetch_array($query))
			{
				$us_id       = escape_string($row['id']);
				$ustanova_id = escape_string($row['ustanova_id']);
				$specid      = escape_string($row['specid']);
				$title       = escape_string($row['title']);
				$iznos       = escape_string($row['iznos']);			 
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
                        Izmjena zdravstvene ustanove u kojima se obavlja subspecijalizacija
                      </h1>                  
                    </div>
                    <div class="btn-list text-right mb-2 mr-3" style="margin-top:-60px;">                  
                        <?php    
                            echo '<a class="btn btn-lg btn-cyan" href="view_rez_subspecijalizacija.php?id='. $specid .'">
						    <i class="fe fe-chevron-left"></i> Nazad
                            </a>';
                        ?>
                    </div> 
                        
                    <div class="row row-cards row-deck">
                        <div class="col-12">
                            <form class="card" action="" method="post">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-sm-8 col-md-8">
                                      <div class="form-group">
                                        <label class="form-label">Naziv ustanove</label>
                                        <!-- <input type="text" name="naziv" class="form-control" placeholder="Naziv"> -->
                                        <select name="ustanova" class="form-control custom-select"> 
                                            <option value="<?php echo $ustanova_id; ?>"><?php echo $title; ?></option>
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
                                        <label class="form-label">Iznos</label>
                                        <input value="<?php echo $iznos; ?>" type="text" name="iznos" class="form-control" placeholder="Iznos">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="card-footer text-right">
                                  <button type="submit" name="update_zdravstvena_ustanova_sub" class="btn btn-primary"><i class="fe fe-database"></i> Spasi</button>
                                </div>
                            </form>  
                            
                            <?php update_zdravstvena_ustanova();  ?>     
                            
                        </div>
                    </div>
                    
                </div>
            </div>
      
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->