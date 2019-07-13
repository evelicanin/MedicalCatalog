
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
                       
                <div class="col-lg-12">
                               
                    <div class="page-header">
                        <h1 class="page-title">Specijalizacije državljana BiH</h1>                       
                    </div>  
                                     
                    <div class="btn-list text-right mb-2 mr-3" style="margin-top:-60px;">                  
                        <a href="#" class="btn btn-indigo btn-lg"><i class="fa fa-wpforms"></i> &nbsp;&nbsp;Dodaj specijalizaciju</a>
                    </div> 
                                      
                    <div class="col-sm-12 col-md-12 mb-2">                                                                            
                        <input type="text" class="form-control header-search search_input" name="search" id="id_search" placeholder="Pretraga&hellip;" tabindex="1">
                        <div class="input-icon-addon mr-2">
                          <i class="fe fe-search"></i>
                        </div>                                           
                    </div> 
                    
                    <div class="card">
                        <table class="table card-table table-vcenter">
                        <tr>
                            <td><img src="demo/products/apple-iphone7-special.jpg" alt="" class="h-8"></td>
                            <td>
                              Apple iPhone 7 Plus 256GB Red Special Edition
                            </td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">98 reviews</td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">38 offers</td>
                            <td class="text-right">
                              <strong>$499</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="demo/products/apple-macbook-pro.jpg" alt="" class="h-8"></td>
                            <td>
                              Apple MacBook Pro i7 3,1GHz/16/512/Radeon 560 Space Gray
                              <div class="badge badge-default badge-md">New</div>
                            </td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">97 reviews</td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">13 offers</td>
                            <td class="text-right">
                              <strong>$1499</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="demo/products/apple-iphone7.jpg" alt="" class="h-8"></td>
                            <td>
                              Apple iPhone 7 32GB Jet Black
                            </td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">48 reviews</td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">38 offers</td>
                            <td class="text-right">
                              <strong>$499</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="demo/products/gopro-hero.jpg" alt="" class="h-8"></td>
                            <td>
                              GoPro HERO6 Black
                              <div class="badge badge-default badge-md">New</div>
                            </td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">66 reviews</td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">47 offers</td>
                            <td class="text-right">
                              <strong>$599</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="demo/products/msi.jpg" alt="" class="h-8"></td>
                            <td>
                              MSI GV62 i5-7300HQ/8GB/1TB/Win10X GTX1050
                            </td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">59 reviews</td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">26 offers</td>
                            <td class="text-right">
                              <strong>$1599</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="demo/products/xiaomi-mi.jpg" alt="" class="h-8"></td>
                            <td>
                              Xiaomi Mi A1 64GB Black
                              <div class="badge badge-default badge-md">New</div>
                            </td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">63 reviews</td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">43 offers</td>
                            <td class="text-right">
                              <strong>$269</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="demo/products/huawei-mate.jpg" alt="" class="h-8"></td>
                            <td>
                              Huawei Mate 10 Pro Dual SIM Gray
                            </td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">71 reviews</td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">12 offers</td>
                            <td class="text-right">
                              <strong>$999</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="demo/products/sony-kd.jpg" alt="" class="h-8"></td>
                            <td>
                              Sony KD-49XE7005
                              <div class="badge badge-default badge-md">New</div>
                            </td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">54 reviews</td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">14 offers</td>
                            <td class="text-right">
                              <strong>$799</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="demo/products/samsung-galaxy.jpg" alt="" class="h-8"></td>
                            <td>
                              Samsung Galaxy A5 A520F 2017 LTE Black Sky
                            </td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">37 reviews</td>
                            <td class="text-right text-muted d-none d-md-table-cell text-nowrap">40 offers</td>
                            <td class="text-right">
                              <strong>$399</strong>
                            </td>
                        </tr>
                        </table>
                    </div>
                </div>            
            </div>            
            
        </div>            

      
 <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>  <!-- poziv footer.php fajla iz TEMPLATE_FRONT -->