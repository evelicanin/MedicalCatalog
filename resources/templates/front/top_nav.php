        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand animated fadeIn" href="./index.php">
                <img src="./demo/brand/writing.svg" class="header-brand-img" alt="tabler logo">
                Specialist
              </a>
              <div class="d-flex order-lg-2 ml-auto">

                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <i class="fa fa-user-circle-o fa-2x"></i>
                    
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default"><?php echo $_SESSION['username']; ?></span>
                      <small class="text-muted d-block mt-1">Logovani korisnik</small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="logout.php">
                      <i class="dropdown-icon fe fe-log-out"></i> Odjava
                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-3 ml-auto">
                <!--
                <form class="input-icon my-3 my-lg-0">
                  <input type="search" class="form-control header-search" placeholder="Search&hellip;" tabindex="1">
                  <div class="input-icon-addon">
                    <i class="fe fe-search"></i>
                  </div>
                </form>
                -->
              </div>
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                    <li class="nav-item">
                      <a href="./index.php" class="nav-link"><i class="fe fe-home"></i> Početna</a>
                    </li>                  
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fa fa-flag-o"></i> Rezidenti</a>
                        <div class="dropdown-menu dropdown-menu-arrow">
                            <a href="./rez_specijalizacije.php" class="dropdown-item"><i class="fa fa-address-book"></i> Specijalizacije državljana BiH</a>                      
                            <a href="./rez_subspecijalizacije.php" class="dropdown-item"><i class="fa fa-address-book-o"></i> Subspecijalizacije državljana BiH</a>                      
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fa fa-flag"></i> Nerezidenti</a>
                        <div class="dropdown-menu dropdown-menu-arrow">
                            <a href="./nerez_specijalizacije.php" class="dropdown-item"><i class="fa fa-address-card"></i> Specijalizacije stranih državljana</a>                      
                            <a href="./nerez_subspecijalizacije.php" class="dropdown-item"><i class="fa fa-address-card-o"></i> Subspecijalizacije stranih državljana</a>                      
                        </div>
                    </li>                       
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-list"></i> Šifarnici</a>
                        <div class="dropdown-menu dropdown-menu-arrow">
                           <a href="./vrste_specijalizacija.php" class="dropdown-item"><i class="fa fa-file"></i> Tipovi specijalizacija</a>
                           <a href="./vrste_subspecijalizacija.php" class="dropdown-item"><i class="fa fa-file-text"></i> Tipovi subspecijalizacija</a>
                           <a href="./fakulteti.php" class="dropdown-item"><i class="fa fa-graduation-cap"></i> Fakulteti</a>
                           <a href="./ustanove.php" class="dropdown-item"><i class="fa fa-bank"></i> Ustanove</a>
                           <a href="./drzavljanstva.php" class="dropdown-item"><i class="fa fa-flag"></i> Državljanstva</a>
                           <a href="./strani_jezici.php" class="dropdown-item"><i class="fa fa-weixin"></i> Strani jezici</a>
                        </div>
                    </li>

                </ul>
              </div>
            </div>
          </div>
        </div>
        