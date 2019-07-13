<?php require_once("../resources/config.php"); ?>      <!-- konekcija na bazu i funkcije -->

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>  <!-- poziv header.php fajla iz TEMPLATE_FRONT -->
  
    <div class="page" 
         style="background: url(assets/images/bgimg.jpg) no-repeat center center fixed; 
               -webkit-background-size: cover;
               -moz-background-size: cover;
               -o-background-size: cover;
                background-size: cover;">
      <div class="page-single">
        <div class="container">
          <div class="row">
            <div class="col col-login">
                <div class="text-center mb-6 animated slideInDown">
                  <img src="./demo/brand/writing.svg" class="h-6" alt=""> <b>Specialist</b>
                </div>
                                     
                <form class="card animated zoomIn" action="" method="post" enctype="multipart/form-data">
                    <div class="card-body p-6 bg-blue-lightest" style="border: 1px solid #C7CCEA;">
                        <?php  	
                            if (isset($_SESSION['message']))
                            {
                                echo '<div class="animated fadeInUp alert alert-primary alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"></button>';			
                                        display_message();                                                       
                                echo '</div>';				
                            }							
                        ?>
                        
                        <?php login_user(); ?>
                        
                        <div class="card-title">Korisnička prijava</div>
                        <div class="form-group">
                          <label class="form-label">Username</label>
                          <input type="text" class="form-control" name="username" placeholder="Unesite Vaš username">
                        </div>
                        <div class="form-group">
                          <label class="form-label">
                            Password
                          </label>
                          <input type="password" class="form-control" name="password" placeholder="Unesite Vaš password">
                        </div>
                        <div class="form-footer">
                          <button type="submit" name="submit" class="btn btn-primary btn-block">Prijava</button>
                        </div>
                    </div>
                </form>
                
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </body>
</html>