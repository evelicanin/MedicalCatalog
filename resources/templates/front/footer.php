     <footer class="footer">
     
        <!-- Modal
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Prijava problema</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          
                        </button>
                    </div>
                    <div class="modal-body">
                      Poštovani, došlo je do problema.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                        <button type="button" class="btn btn-primary">Prijavi problem</button>
                    </div>
                </div>
            </div>
        </div>  
        -->        
     
     
        <div class="container">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
              <div class="row align-items-center">
                <!--
                <div class="col-auto">
                  <a href="" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">Fix it!</a>
                </div>
                -->
              </div>
            </div>

            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
              Copyright © 2018 <a href="http://www.fixit.ba" target="_blank"><b>FiXiT</b></a> All rights reserved.
            </div>

          </div>
        </div>
      </footer>
      
    </div> <!-- zatvara <div class="page"> -->
    
    <!-- jquery -->
    <script src="./assets/js/jquery-2.1.3.min.js"></script>
    <script src="./assets/js/jquery.datepicker.js"></script>
 	<!-- live search -->
	<script src="./assets/js/jquery.quicksearch.js"></script>
	<script>
		$(document).ready(function () {
			$("#id_search").quicksearch("table tbody tr", {
				noResults: '#noresults',
				stripeRows: ['odd', 'even'],
				loader: 'span.loading',
				minValLength: 2               
			});
            
            $("form").attr('autocomplete', 'off');
            
		});
        $(document).keypress(function(e) {
            if(e.which == 13) {
                e.preventDefault();
            }
        });
	</script>
    
  </body>
</html>