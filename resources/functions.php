<?php

// global
$upload_directory = "uploads";

/**************************************************************************************************************************************************/ 
/**** HELPER FUNCTIONS ****************************************************************************************************************************/ 
/**************************************************************************************************************************************************/ 

    // funkcija za preusmjeravanje korisnika
	function redirect($location)
	{
		return header("Location: $location");
	}
 
    // funkcija za setovanje poruke za sesiju
	function set_message($msg)
	{
		if(!empty($msg)) 
		{
			$_SESSION['message'] = $msg;
		}
		else 
		{
			$msg = "";
		}
	}
 
	// funkcija za prikaz poruke
	function display_message() 
	{
		if(isset($_SESSION['message'])) 
		{
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		}
	}
		
	// funkcija za ciscenje stringova koje korisnik unese
	function escape_string($string)
	{
        global $connection;         		
		return mysqli_real_escape_string($connection, $string);
	}
    
    function confirm_query($result_set) {
        if (!$result_set) {
            die("Database query failed.");
        }
	}

	function mysql_prep($string) {
		global $connection;

		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
/**************************************************************************************************************************************************/ 	
/**** HELPER FUNCTIONS ****************************************************************************************************************************/ 
/**************************************************************************************************************************************************/

/**************************************************************************************************************************************************/ 	
/**** DATABASE FUNCTIONS **************************************************************************************************************************/ 
/**************************************************************************************************************************************************/
	
	// funkcija koja vraca ID posljednjeg inserta
	function last_id()
	{
		global $connection;
		return mysqli_insert_id($connection);
	} 
	
	// funkcija za izvrsavanje sql upita
	function query($sql)
	{
        global $connection;		
		return mysqli_query($connection, $sql);		
	}
	
    // funkcija za dohvatanje slogova izvrsenog upita
	function fetch_array($result)
	{
		return mysqli_fetch_array($result);	
	}
	
    // funkcija za provjeru ispravnosti izvrsenog upita
	function confirm($result)
	{
	    global $connection;         		
        if(!$result)
		    {
				die("DATABASE QUERY FAILED " . mysqli_error($connection));
            }		
	}
	
/**************************************************************************************************************************************************/ 	
/**** DATABASE FUNCTIONS **************************************************************************************************************************/ 
/**************************************************************************************************************************************************/ 
    	
/**************************************************************************************************************************************************/ 
/**** LOGIN FUNCTIONS *****************************************************************************************************************************/ 
/**************************************************************************************************************************************************/ 

	function login_user()
	{
		if(isset($_POST['submit']))
		{
			$username = escape_string($_POST['username']);
			$password = escape_string($_POST['password']);
			
            // ovo je sql upit kojeg zelimo izvrsiti na nasoj bazi	
			$query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password }' ");
			confirm($query);

			// ukoliko user postoji u bazi, rezultat je = 1, ukoliko ne postoji takav user, rezultat je = 0
			if(mysqli_num_rows($query) == 0) 
			{
				set_message("Pogrešni podaci!");
				redirect("login.php"); // ostajemo na istoj stranici
			} 
			else 
			{
				$_SESSION['username'] = $username;
				redirect("index.php"); // preusmjeravamo korisnika na pocetni page
			}
		}
	}
	
	// funkcija koja provjerava da li je logovan korisnik   
	function user_is_logged()
	{
		if(!isset($_SESSION['username']))
		{
		    set_message("Morate se prijaviti!");
		    redirect("login.php"); // ne ovako, izbjeci koristenje / ili \, koristiti DS
		    //redirect ("..' . DS . '..' . DS . 'public"); // vracamo iz indexa administracije na index shopa 
		}
	}
	
/**************************************************************************************************************************************************/ 
/**** LOGIN FUNCTIONS *****************************************************************************************************************************/
/**************************************************************************************************************************************************/ 
/**************************************************************************************************************************************************/  
/**** ŠIFARNICI ***********************************************************************************************************************************/ 
/**************************************************************************************************************************************************/ 

    
    // fakulteti ////////////////////////////////////////////////////////////////////////////////////////////////////
	// funkcija za prikaz svih fakulteta u dropdown listi
    function select_fakultet() {
        global $connection;
        $query  = "SELECT fak_id, concat(fak_title,', ',fak_city)naziv_fakulteta ";
        $query .= "FROM fakulteti ";
        $query .= "ORDER BY fak_id ASC";
        $fakulteti_set = mysqli_query($connection, $query);
        confirm_query($fakulteti_set);
        return $fakulteti_set;
	}
    
    // funkcija za prikaz svih fakulteta u tabeli
	function lista_fakulteta()
	{
		$category_query = query("SELECT fak_id, fak_title, fak_city FROM fakulteti");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{

			$fak_id = $row['fak_id'];
			$fak_title = $row['fak_title'];
			$fak_city = $row['fak_city'];
                                                  
			echo '		
					<tr>
						<td>'.htmlentities($row["fak_title"]).'</td>
						<td>'.htmlentities($row["fak_city"]).'</td>						
						<td class="text-right">
                            <a class="btn btn-cyan" href="edit_fakultet.php?id='.htmlentities($row["fak_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$fak_id.')" style="color: #fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_fakultet.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>                   
                    ';
		}
	}
    
 	// funkcija za dodavanje novog fakulteta
	function add_fakultet() 
	{
		if(isset($_POST['add_fakultet'])) 
		{
			$naziv = escape_string($_POST['naziv']);
			$grad  = escape_string($_POST['grad']);

		
			$insert_user = query("INSERT INTO fakulteti(fak_title, fak_city) VALUES ('{$naziv}', '{$grad}') ");
			confirm($insert_user);
			set_message( $naziv . " uspješno dodan u šifarnik.");
            redirect("fakulteti.php");
        }
	}
    
	// funkcija za update šifarnika fakulteta
	function update_fakultet()
	{
		if(isset($_POST['update_fakultet']))
		{					
			$fak_title          = escape_string($_POST['naziv']);
			$fak_city           = escape_string($_POST['grad']);
			
			$query = "UPDATE fakulteti SET ";
			$query .= "fak_title                = '{$fak_title}'        , ";
			$query .= "fak_city                 = '{$fak_city}'           ";
			$query .= "WHERE fak_id=" . escape_string($_GET['id']);

			$send_update_query = query($query);
			confirm($send_update_query);
			
			set_message("Fakultet je uspješno izmjenjen.");
			redirect("fakulteti.php");

		}
	}	


    // ustanove ////////////////////////////////////////////////////////////////////////////////////////////////////
	// funkcija za prikaz svih ustanova u dropdown listi
    function select_ustanova(){
        global $connection;
        $query  = "SELECT u_id, concat(u_title,', ',u_city)naziv_ustanove ";
        $query .= "FROM ustanove ";
        $query .= "ORDER BY u_id ASC";
        $ustanove_set = mysqli_query($connection, $query);
        confirm_query($ustanove_set);
        return $ustanove_set;
	}
  	
    // funkcija za prikaz svih ustanova
	function lista_ustanova()
	{
		$category_query = query("SELECT u_id, u_title, u_city FROM ustanove ORDER BY u_title ASC");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{

			$u_id = $row['u_id'];
			$u_title = $row['u_title'];
			$u_city = $row['u_city'];
                                                  
			echo '		
					<tr>
						<td>'.htmlentities($row["u_title"]).'</td>
						<td>'.htmlentities($row["u_city"]).'</td>						
						<td class="text-right">
                            <a class="btn btn-cyan" href="edit_ustanova.php?id='.htmlentities($row["u_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$u_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_ustanova.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>  
                    ';
		}
	}
    
 	// funkcija za dodavanje nove ustanove
	function add_ustanova() 
	{
		if(isset($_POST['add_ustanova'])) 
		{
			$naziv = escape_string($_POST['naziv']);
			$grad  = escape_string($_POST['grad']);

		
			$insert_user = query("INSERT INTO ustanove(u_title, u_city) VALUES ('{$naziv}', '{$grad}') ");
			confirm($insert_user);
			set_message( $naziv . " uspješno dodana u šifarnik.");
            redirect("ustanove.php");
        }
	}
    
	// funkcija za update šifarnika ustanova
	function update_ustanova()
	{
		if(isset($_POST['update_ustanova']))
		{					
			$u_title          = escape_string($_POST['naziv']);
			$u_city           = escape_string($_POST['grad']);
			
			$query = "UPDATE ustanove SET ";
			$query .= "u_title                = '{$u_title}'        , ";
			$query .= "u_city                 = '{$u_city}'           ";
			$query .= "WHERE u_id=" . escape_string($_GET['id']);

			$send_update_query = query($query);
			confirm($send_update_query);
			
			set_message("Ustanova je uspješno izmjenjena.");
			redirect("ustanove.php");

		}
	}	

    // strani jezici ////////////////////////////////////////////////////////////////////////////////////////////////////
	// funkcija za prikaz svih stranih jezika u dropdown listi
    function select_jezik(){
        global $connection;
        $query  = "SELECT l_id, concat(l_title)jezik ";
        $query .= "FROM strani_jezici ";
        $query .= "ORDER BY l_title ASC";
        $languages_set = mysqli_query($connection, $query);
        confirm_query($languages_set);
        return $languages_set;
	}	
    
    // funkcija za prikaz svih stranih jezika u tabeli
	function lista_stranih_jezika()
	{
		$category_query = query("SELECT l_id, l_title FROM strani_jezici ORDER BY l_title ASC");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{

			$l_id = $row['l_id'];
			$l_title = $row['l_title'];
                                                  
			echo '		
					<tr>
						<td>'.htmlentities($row["l_title"]).'</td>					
						<td class="text-right">
                            <a class="btn btn-cyan" href="edit_strani_jezik.php?id='.htmlentities($row["l_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$l_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_strani_jezik.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>  
                    ';
		}
	}
    
 	// funkcija za dodavanje novog stranog jezika
	function add_strani_jezik() 
	{
		if(isset($_POST['add_strani_jezik'])) 
		{
			$naziv = escape_string($_POST['naziv']);
	
			$insert_user = query("INSERT INTO strani_jezici(l_title) VALUES ('{$naziv}') ");
			confirm($insert_user);
			set_message( $naziv . " uspješno dodan u šifarnik.");
            redirect("strani_jezici.php");
        }
	}
    
	// funkcija za update stranih jezika
	function update_strani_jezik()
	{
		if(isset($_POST['update_strani_jezik']))
		{					
			$l_title = escape_string($_POST['naziv']);
			
			$query = "UPDATE strani_jezici SET ";
			$query .= "l_title                = '{$l_title}'";
			$query .= "WHERE l_id=" . escape_string($_GET['id']);

			$send_update_query = query($query);
			confirm($send_update_query);
			
			set_message("Naziv stranog jezika je uspješno izmjenjen.");
			redirect("strani_jezici.php");

		}
	}		

    
    // državljanstva ////////////////////////////////////////////////////////////////////////////////////////////////////
    // funkcija za prikaz svih drzavljanstava u dropdown listi
    function select_drzavljanstvo(){
        global $connection;
        $query  = "SELECT d_id, concat(d_title)drzavljanstvo ";
        $query .= "FROM drzavljanstva ";
        $query .= "ORDER BY d_title ASC";
        $drzave_set = mysqli_query($connection, $query);
        confirm_query($drzave_set);
        return $drzave_set;
    }
    
    // funkcija za prikaz svih drzavljanstava u tabeli
	function lista_drzavljanstava()
	{
		$category_query = query("SELECT d_id, d_title FROM drzavljanstva ORDER BY d_title ASC");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{

			$d_id = $row['d_id'];
			$d_title = $row['d_title'];
                                                  
			echo '		
					<tr>
						<td>'.htmlentities($row["d_title"]).'</td>					
						<td class="text-right">
                            <a class="btn btn-cyan" href="edit_drzavljanstvo.php?id='.htmlentities($row["d_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$d_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_drzavljanstvo.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>  
                    ';
		}
	}
    
 	// funkcija za dodavanje novog drzavljanstva
	function add_drzavljanstvo() 
	{
		if(isset($_POST['add_drzavljanstvo'])) 
		{
			$naziv = escape_string($_POST['naziv']);
	
			$insert_user = query("INSERT INTO drzavljanstva(d_title) VALUES ('{$naziv}') ");
			confirm($insert_user);
			set_message( $naziv . " uspješno dodan u šifarnik.");
            redirect("drzavljanstva.php");
        }
	}
    
	// funkcija za update drzavljanstva
	function update_drzavljanstvo()
	{
		if(isset($_POST['update_drzavljanstvo']))
		{					
			$d_title = escape_string($_POST['naziv']);
			
			$query = "UPDATE drzavljanstva SET ";
			$query .= "d_title                = '{$d_title}'";
			$query .= "WHERE d_id=" . escape_string($_GET['id']);

			$send_update_query = query($query);
			confirm($send_update_query);
			
			set_message("Državlujanstvo je uspješno editovano.");
			redirect("drzavljanstva.php");

		}
	}	


    // vrste specijalizacija ////////////////////////////////////////////////////////////////////////////////////////////////////
    // funkcija za prikaz svih specijalizacija u dropdown listi
    function select_specijalizacija(){
        global $connection;
        $query  = "SELECT vs_id, concat(vs_title)specijalizacija ";
        $query .= "FROM vrste_specijalizacija ";
        $query .= "ORDER BY vs_title ASC";
        $specijalizacije_set = mysqli_query($connection, $query);
        confirm_query($specijalizacije_set);
        return $specijalizacije_set;
    }	
    
    // funkcija za prikaz svih vrsta specijalizacija u tabeli
	function lista_vrsta_specijalizacija()
	{
		$category_query = query("SELECT vs_id, vs_title FROM vrste_specijalizacija ORDER BY vs_title ASC");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{

			$vs_id = $row['vs_id'];
			$vs_title = $row['vs_title'];
                                                  
			echo '		
					<tr>
						<td>'.htmlentities($row["vs_title"]).'</td>					
						<td class="text-right">
                            <a class="btn btn-cyan" href="edit_vrsta_specijalizacije.php?id='.htmlentities($row["vs_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$vs_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_vrsta_specijalizacije.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>                     
                    ';
		}
	}
    
 	// funkcija za dodavanje nove vrste specijalizacije
	function add_vrsta_specijalizacije() 
	{
		if(isset($_POST['add_vrsta_specijalizacije'])) 
		{
			$naziv = escape_string($_POST['naziv']);
	
			$insert_user = query("INSERT INTO vrste_specijalizacija(vs_title) VALUES ('{$naziv}') ");
			confirm($insert_user);
			set_message("Vrsta specijalizacije uspješno dodana u šifarnik.");
            redirect("vrste_specijalizacija.php");
        }
	}
    
 	// funkcija za dodavanje nove vrste subspecijalizacije
	function add_vrsta_subspecijalizacije()
	{
		if(isset($_POST['add_vrsta_subspecijalizacije'])) 
		{
			$naziv = escape_string($_POST['naziv']);
	
			$insert_user = query("INSERT INTO vrste_subspecijalizacija(vss_title) VALUES ('{$naziv}') ");
			confirm($insert_user);
			set_message("Vrsta subpecijalizacije uspješno dodana u šifarnik.");
            redirect("vrste_subspecijalizacija.php");
        }
	}
    
	// funkcija za update vrste specijalizacije
	function update_vrsta_specijalizacije()
	{
		if(isset($_POST['update_vrsta_specijalizacije']))
		{					
			$vs_title = escape_string($_POST['naziv']);
			
			$query = "UPDATE vrste_specijalizacija SET ";
			$query .= "vs_title                = '{$vs_title}' ";
			$query .= "WHERE vs_id=" . escape_string($_GET['id']);

			$send_update_query = query($query);
			confirm($send_update_query);
			
			set_message("Šifarnik je uspješno editovan.");
			redirect("vrste_specijalizacija.php");

		}
	}	

	// funkcija za update vrste subpecijalizacije
	function update_vrsta_subpecijalizacije()
	{
		if(isset($_POST['update_vrsta_subspecijalizacije']))
		{					
			$vss_title = escape_string($_POST['naziv']);
			
			$query = "UPDATE vrste_subspecijalizacija SET ";
			$query .= "vss_title                = '{$vss_title}' ";
			$query .= "WHERE vss_id=" . escape_string($_GET['id']);

			$send_update_query = query($query);
			confirm($send_update_query);
			
			set_message("Šifarnik je uspješno editovan.");
			redirect("vrste_subpecijalizacija.php");

		}
	}	
/**************************************************************************************************************************************************/  
/**** REZIDENTI SPECIJALIZACIJE *******************************************************************************************************************/ 
/**************************************************************************************************************************************************/ 

    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // BIH specijalizacije //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // funkcija racuna broj specijalizacija rezidenata u tabeli
	function count_specijalizacije()
	{
		$category_query = query("SELECT count(*) as broj_specijalizacija FROM rez_specijalizacije");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$broj_specijalizacija = $row['broj_specijalizacija'];                                                  
			echo $broj_specijalizacija;           
		}
	}

    // funkcija racuna broj uplata za sve specijalizacije rezidenata
	function count_uplate_spec()
	{
		$category_query = query("SELECT count(*) as broj_uplata_spec FROM ustanove_uplate WHERE us_id in ( SELECT us_id FROM ustanove_staz WHERE oznaka = 'RS')");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$broj_uplata_spec = $row['broj_uplata_spec'];                                                  
			echo $broj_uplata_spec;           
		}
	}
    
    // funkcija za prikaz svih specijalizacija rezidenata u tabeli
	function lista_bh_specijalizacija()
	{
		$category_query = query("SELECT spec_id, broj_evid_godina, ime_prezime, jmbg FROM rez_specijalizacije ORDER BY spec_id DESC");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$spec_id          = $row['spec_id'];
			$broj_evid_godina = $row['broj_evid_godina'];
			$ime_prezime      = $row['ime_prezime'];
			$jmbg             = $row['jmbg'];
                                                  
			echo '		
					<tr>			
						<td>'.htmlentities($row["broj_evid_godina"]).'</td>					
						<td>'.htmlentities($row["ime_prezime"]).'</td>					
						<td>'.htmlentities($row["jmbg"]).'</td>					
						<td>
                            <a class="btn btn btn-outline-primary btn-sm" href="add_rez_subspecijalizacija.php?id='.htmlentities($row["spec_id"]).'">
						    <i class="fe fe-plus"></i> Subspecijalizacija
                            </a>
                        </td>					
						<td class="text-right">
                            <a class="btn btn-gray-dark btn-sm" href="view_rez_specijalizacija.php?id='.htmlentities($row["spec_id"]).'">
						    <i class="fe fe-search"></i> Pregled
                            </a>                            
                            <a class="btn btn-cyan btn-sm" href="edit_rez_specijalizacija.php?id='.htmlentities($row["spec_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger btn-sm" onClick="deleteme('.$spec_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_specijalizacija.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>   
                    ';           
		}
	}
    
	// funkcija za update specijalizacije 'nekog/bilo kojeg' rezidenta
	function update_rez_specijalizacija()
	{
		if(isset($_POST['update_rez_specijalizacija']))
		{					
            //error_reporting(E_ALL);
            // Obrada forme	    
            
            $drzava           = (int)$_POST['drzava'];
            $fakultet         = (int)$_POST['fakultet'];
            $ustanova         = (int)$_POST['ustanova'];
            $spec             = (int)$_POST['spec'];
            $jezik            = (int)$_POST['jezik'];
            
            $broj_evid        = mysql_prep($_POST["broj_evid"]);
            $ime              = mysql_prep($_POST["ime"]);
            $jmbg             = mysql_prep($_POST["jmbg"]);
            $adresa           = mysql_prep($_POST["adresa"]);
            $broj_diplome     = mysql_prep($_POST["broj_diplome"]);
            
            $fak_dat          = $_POST['fak_datum'];
            $fak_datum        = date('Y-m-d',strtotime($fak_dat));   
            
            $fak_rjesenje     = mysql_prep($_POST["fak_rjesenje"]);
            $fak_izdato       = mysql_prep($_POST["fak_izdato"]);
            $str_mjesto       = mysql_prep($_POST["str_mjesto"]);
            
            $str_dat          = $_POST['str_datum'];
            $str_datum        = date('Y-m-d',strtotime($str_dat));       
            
            $str_broj         = mysql_prep($_POST["str_broj"]);
            $dokaz            = mysql_prep($_POST["dokaz"]);
            $broj_rjesenja    = mysql_prep($_POST["broj_rjesenja"]);
            
            $staz_dat         = $_POST['datum_poc_staza'];
            $datum_poc_staza  = date('Y-m-d',strtotime($staz_dat)); 
      
            $upl_1            = mysql_prep($_POST["upl_1"]);    
            $d_up1            = $_POST['dat_up1'];
            $dat_up1          = date('Y-m-d',strtotime($d_up1)); 
            
            $upl_2            = mysql_prep($_POST["upl_2"]);
            $d_up2            = $_POST['dat_up2'];
            $dat_up2          = date('Y-m-d',strtotime($d_up2)); 
 
            $broj_rj_datum    = mysql_prep($_POST["broj_rj_datum"]);
            $d_pre_staza      = $_POST["dat_pre_staza"];
            $dat_pre_staza    = date('Y-m-d',strtotime($d_pre_staza)); 
            $povrat           = mysql_prep($_POST["povrat"]);
                
            $user_unio        = $_SESSION['username'];          

            $image                = $_FILES['file']['name'];
            $image_temp_location  = $_FILES['file']['tmp_name'];
            
			if(empty($image))
			{
				$get_pic = query("SELECT image FROM rez_specijalizacije WHERE spec_id =" .escape_string($_GET['id']). " ");
				confirm($get_pic);

				while($pic = fetch_array($get_pic)) 
				{
					$image = $pic['image'];
				}
			}
            
            move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $image);
                     
            // $destination_path = getcwd().DIRECTORY_SEPARATOR .'/uploads/';
            // $target_path = $destination_path . basename( $_FILES["file"]["name"]);
            // @move_uploaded_file($_FILES['file']['tmp_name'], $target_path);
                      
                
                    $query = "UPDATE rez_specijalizacije SET ";
                    $query .= "d_id                 = '{$drzava}', ";
                    $query .= "fak_id               = '{$fakultet}', ";
                    $query .= "u_id                 = '{$ustanova}', ";
                    $query .= "vs_id                = '{$spec}', ";
                    $query .= "l_id                 = '{$jezik}', ";
                    $query .= "broj_evid_godina     = '{$broj_evid}', ";
                    $query .= "ime_prezime          = '{$ime}', ";
                    $query .= "jmbg                 = '{$jmbg}', ";
                    $query .= "adresa               = '{$adresa}', ";
                    $query .= "fak_broj_diplome     = '{$broj_diplome}', ";
                    $query .= "fak_datum            = '{$fak_datum}', ";
                    $query .= "fak_nostro_rjesenje  = '{$fak_rjesenje}', ";
                    $query .= "fak_nostro_izdato    = '{$fak_izdato}', ";
                    $query .= "strucni_ispit_mjesto = '{$str_mjesto}', ";
                    $query .= "strucni_ispit_datum  = '{$str_datum}', ";
                    $query .= "strucni_ispit_broj   = '{$str_broj}', ";
                    $query .= "radni_staz_dokaz     = '{$dokaz}', ";
                    $query .= "broj_rjesenja_godina = '{$broj_rjesenja}', ";
                    $query .= "datum_poc_staza      = '{$datum_poc_staza}', ";
                    $query .= "uplata_prva_rata     = '{$upl_1}', ";
                    $query .= "datum_prva_rata      = '{$dat_up1}', ";
                    $query .= "uplata_druga_rata    = '{$upl_2}', ";
                    $query .= "datum_druga_rata     = '{$dat_up2}', ";
                    $query .= "broj_rjesenja_datum  = '{$broj_rj_datum}', ";
                    $query .= "datum_pres_staza     = '{$dat_pre_staza}', ";
                    $query .= "povrat_sredstava     = '{$povrat}', ";
                    $query .= "image                = '{$image}', ";
                    $query .= "user_unio            = '{$user_unio}' ";
                    $query .= "WHERE spec_id=" . escape_string($_GET['id']);

                    $send_update_query = query($query);
                    confirm($send_update_query);
                    
                    set_message("Specijalizacija : <b>" . $broj_evid  . "</b> uspješno izmjenjena ");
                    redirect("rez_specijalizacije.php");

		}
	}  
 
    // funkcija za prikaz svih ustanova staziranja koji pripadaju nekoj specijalizaciji rezidenta
	function lista_ustanova_staziranja($specid, $oznaka)
	{
        // $query = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.spec_id =". $specid ." ");                                    
        // $query  = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos, sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo FROM ustanove_staz us, ustanove u, ustanove_uplate up WHERE us.u_id = u.u_id  AND us.us_id = up.us_id AND us.spec_id = ". $specid . " GROUP BY us.us_id, u.u_title, us.iznos");                                    
        // confirm($query);
        
		$firstquery  = "SELECT us.us_id as id, u.u_title as title, us.iznos as iznos, ";
		$firstquery .= "sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo ";
		$firstquery .= "FROM ustanove_staz us, ustanove u, ustanove_uplate up ";
		$firstquery .= "WHERE us.u_id = u.u_id  AND us.us_id = up.us_id ";
		$firstquery .= "AND us.spec_id = '{$specid}' ";
		$firstquery .= "AND us.oznaka = '{$oznaka}' ";
		$firstquery .= "GROUP BY us.us_id, u.u_title, us.iznos ";
        
        $query = query($firstquery);
        confirm($query);
  
        
		while($row = fetch_array($query)) 
		{
            $us_id      = escape_string($row['id']);
            $us_title   = escape_string($row['title']);
            $iznos      = escape_string($row['iznos']);
            $suma       = escape_string($row['suma_uplata']);
            $preostalo  = escape_string($row['preostalo']);
                                          
			echo '		
					<tr>
						<td>'. $us_title .'</td>					
						<td>'. $iznos .'</td>					
						<td>'. $suma .'</td>					
						<td>'. $preostalo .'</td>					
						<td class="text-right">
                            <a class="btn btn-lime" href="ustanove_uplate.php?id='. $us_id .'">
						    <i class="fe fe-dollar-sign"></i> Uplate
                            </a>                            
                            <a class="btn btn-cyan" href="edit_ustanova_staziranja.php?id='. $us_id .'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$us_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>   
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                                window.location.href="../resources/templates/back/delete_ustanova_staza.php?id=" + delid;
                                return true;
                            }
                        } 
                    </script>                     
                    ';
		}
        
        // $query2 = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.us_id not in ( select us_id from ustanove_uplate ) AND us.spec_id =". $specid ." ");                                    
        
		$secondquery  = "SELECT us.us_id as id, u.u_title as title, us.iznos as iznos ";
		$secondquery .= "FROM ustanove_staz us, ustanove u ";
		$secondquery .= "WHERE us.u_id = u.u_id ";
		$secondquery .= "AND us.us_id not in ( SELECT us_id FROM ustanove_uplate ) ";
		$secondquery .= "AND us.spec_id = '{$specid}' ";
		$secondquery .= "AND us.oznaka = '{$oznaka}' ";
		$secondquery .= "GROUP BY us.us_id, u.u_title, us.iznos ";
        
        $query2 = query($secondquery);
        confirm($query2);
               
		while($row = fetch_array($query2)) 
		{
            $us_id_2      = escape_string($row['id']);
            $us_title_2   = escape_string($row['title']);
            $iznos_2      = escape_string($row['iznos']);
            $suma_2       = '0';
            $preostalo_2  = $iznos_2;
                                          
			echo '		
					<tr>
						<td>'. $us_title_2 .'</td>					
						<td>'. $iznos_2 .'</td>					
						<td>'. $suma_2 .'</td>					
						<td>'. $preostalo_2 .'</td>					
						<td class="text-right">
                            <a class="btn btn-lime" href="ustanove_uplate.php?id='. $us_id_2 .'">
						    <i class="fe fe-dollar-sign"></i> Uplate
                            </a>                            
                            <a class="btn btn-cyan" href="edit_ustanova_staziranja.php?id='. $us_id_2 .'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleterow('.$us_id_2.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleterow(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_ustanova_staza.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>                     
                    ';
		}        
        
	} 
   
    // funkcija za prikaz svih ustanova staziranja koji pripadaju nekoj subspecijalizaciji rezidenta
	function lista_ustanova_staziranja_sub($specid, $oznaka)
	{
        // $query = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.spec_id =". $specid ." ");                                    
        // $query  = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos, sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo FROM ustanove_staz us, ustanove u, ustanove_uplate up WHERE us.u_id = u.u_id  AND us.us_id = up.us_id AND us.spec_id = ". $specid . " GROUP BY us.us_id, u.u_title, us.iznos");                                    
        // confirm($query);
        
		$firstquery  = "SELECT us.us_id as id, u.u_title as title, us.iznos as iznos, ";
		$firstquery .= "sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo ";
		$firstquery .= "FROM ustanove_staz us, ustanove u, ustanove_uplate up ";
		$firstquery .= "WHERE us.u_id = u.u_id  AND us.us_id = up.us_id ";
		$firstquery .= "AND us.spec_id = '{$specid}' ";
		$firstquery .= "AND us.oznaka = '{$oznaka}' ";
		$firstquery .= "GROUP BY us.us_id, u.u_title, us.iznos ";
        
        $query = query($firstquery);
        confirm($query);
  
        
		while($row = fetch_array($query)) 
		{
            $us_id      = escape_string($row['id']);
            $us_title   = escape_string($row['title']);
            $iznos      = escape_string($row['iznos']);
            $suma       = escape_string($row['suma_uplata']);
            $preostalo  = escape_string($row['preostalo']);
                                          
			echo '		
					<tr>
						<td>'. $us_title .'</td>					
						<td>'. $iznos .'</td>					
						<td>'. $suma .'</td>					
						<td>'. $preostalo .'</td>					
						<td class="text-right">
                            <a class="btn btn-lime" href="ustanove_uplate_sub.php?id='. $us_id .'">
						    <i class="fe fe-dollar-sign"></i> Uplate
                            </a>                            
                            <a class="btn btn-cyan" href="edit_ustanova_staziranja_sub.php?id='. $us_id .'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$us_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>   
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                                window.location.href="../resources/templates/back/delete_ustanova_staza_sub.php?id=" + delid;
                                return true;
                            }
                        } 
                    </script>                     
                    ';
		}
        
        // $query2 = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.us_id not in ( select us_id from ustanove_uplate ) AND us.spec_id =". $specid ." ");                                    
        
		$secondquery  = "SELECT us.us_id as id, u.u_title as title, us.iznos as iznos ";
		$secondquery .= "FROM ustanove_staz us, ustanove u ";
		$secondquery .= "WHERE us.u_id = u.u_id ";
		$secondquery .= "AND us.us_id not in ( SELECT us_id FROM ustanove_uplate ) ";
		$secondquery .= "AND us.spec_id = '{$specid}' ";
		$secondquery .= "AND us.oznaka = '{$oznaka}' ";
		$secondquery .= "GROUP BY us.us_id, u.u_title, us.iznos ";
        
        $query2 = query($secondquery);
        confirm($query2);
               
		while($row = fetch_array($query2)) 
		{
            $us_id_2      = escape_string($row['id']);
            $us_title_2   = escape_string($row['title']);
            $iznos_2      = escape_string($row['iznos']);
            $suma_2       = '0';
            $preostalo_2  = $iznos_2;
                                          
			echo '		
					<tr>
						<td>'. $us_title_2 .'</td>					
						<td>'. $iznos_2 .'</td>					
						<td>'. $suma_2 .'</td>					
						<td>'. $preostalo_2 .'</td>					
						<td class="text-right">
                            <a class="btn btn-lime" href="ustanove_uplate_sub.php?id='. $us_id_2 .'">
						    <i class="fe fe-dollar-sign"></i> Uplate
                            </a>                            
                            <a class="btn btn-cyan" href="edit_ustanova_staziranja_sub.php?id='. $us_id_2 .'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleterow('.$us_id_2.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleterow(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_ustanova_staza_sub.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>                     
                    ';
		}        
        
	} 
    
    
	// funkcija za update zdravstvene ustanove specijalizacije rezidenta
	function update_zdravstvena_ustanova()
	{
		if(isset($_POST['update_zdravstvena_ustanova']))
		{					
			$ustanova = escape_string($_POST['ustanova']);
			$iznos = escape_string($_POST['iznos']);
			
			$query = "UPDATE ustanove_staz SET ";
			$query .= "u_id                 = '{$ustanova}', ";
			$query .= "iznos                = '{$iznos}' ";
			$query .= "WHERE us_id=" . escape_string($_GET['id']);
            
			$send_update_query = query($query);
			confirm($send_update_query);
            set_message("Ustanova stažiranja je uspješno editovana.");
            
            // UPDATE gotov, sada idemo nazad na specijalizaciju kojoj ta ustanova staziranja i pripada            
            $query2 = query("SELECT spec_id from ustanove_staz WHERE us_id=" . escape_string($_GET['id']) . " ");
            confirm($query2);
                          
		    while($row = fetch_array($query2)) {
                redirect('view_rez_specijalizacija.php?id='.htmlentities($row["spec_id"]).''); // idemo nazad
            }
		}
		if(isset($_POST['update_zdravstvena_ustanova_sub']))
		{					
			$ustanova = escape_string($_POST['ustanova']);
			$iznos = escape_string($_POST['iznos']);
			
			$query = "UPDATE ustanove_staz SET ";
			$query .= "u_id                 = '{$ustanova}', ";
			$query .= "iznos                = '{$iznos}' ";
			$query .= "WHERE us_id=" . escape_string($_GET['id']);
            
			$send_update_query = query($query);
			confirm($send_update_query);
            set_message("Ustanova stažiranja je uspješno editovana.");
            
            // UPDATE gotov, sada idemo nazad na specijalizaciju kojoj ta ustanova staziranja i pripada            
            $query2 = query("SELECT spec_id from ustanove_staz WHERE us_id=" . escape_string($_GET['id']) . " ");
            confirm($query2);
                          
		    while($row = fetch_array($query2)) {
                redirect('view_rez_subspecijalizacija.php?id='.htmlentities($row["spec_id"]).''); // idemo nazad
            }
		}
	}	  


    // funkcija za prikaz svih uplata u tabeli - REZIDENTI
	function lista_uplata($id, $oznaka)
	{
          
 	    $query  = "SELECT up.upl_id as upl_id, up.us_id as us_id, up.broj_fakture as broj_fakture, up.datum_uplate as datum_uplate, up.iznos_uplate as iznos_uplate ";
 	    // $query  = "us.spec_id ";
	    $query .= "FROM ustanove_uplate up, ustanove_staz us, ustanove u ";
	    $query .= "WHERE up.us_id = us.us_id ";
	    $query .= "AND us.u_id = u.u_id ";
	    $query .= "AND us.oznaka = '{$oznaka}' ";
	    $query .= "AND up.us_id = '{$id}' ";
 
		$select_query = query($query);
		confirm($select_query);
               
		while($row = fetch_array($select_query)) 
		{
			$upl_id         = $row['upl_id'];
			$us_id          = $row['us_id'];
			$broj_fakture   = $row['broj_fakture'];
			$datum_uplate   = $row['datum_uplate'];
			$iznos_uplate   = $row['iznos_uplate'];
 
            if ($datum_uplate == '1970-01-01'){
                $du = '';
            } else {
                $du = date("d.m.Y", strtotime($datum_uplate));
            }  
              
            if( $oznaka=='RS' )
            {
                echo '		
                        <tr>
                            <td>'.htmlentities($row["broj_fakture"]).'</td>
                            <td>'.$du.'</td>	
                            
                            <td class="text-right">'.htmlentities($row["iznos_uplate"]).'</td>						
                            <td class="text-right">
                                <a class="btn btn-cyan" href="edit_ustanove_uplate.php?id='.htmlentities($row["upl_id"]).'">
                                <i class="fe fe-edit"></i> Izmjeni
                                </a>
                                <a class="btn btn-danger" onClick="deleteme('.$upl_id.')" style="color: #fff;">
                                <i class="fe fe-trash-2"></i> Izbriši
                                </a>
                            </td>
                        </tr> 
                        <script language="javascript">
                            function deleteme(delid)
                            {
                                if(confirm("Jeste li sigurni?"))
                                {
                                window.location.href="../resources/templates/back/delete_uplata.php?id=" + delid;
                                return true;
                                }
                            } 
                        </script>                   
                        ';            
            }
            
            if($oznaka=='RSS') 
			echo '		
					<tr>
						<td>'.htmlentities($row["broj_fakture"]).'</td>
						<td>'.$du.'</td>	
                        
						<td class="text-right">'.htmlentities($row["iznos_uplate"]).'</td>						
						<td class="text-right">
                            <a class="btn btn-cyan" href="edit_ustanove_uplate_sub.php?id='.htmlentities($row["upl_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$upl_id.')" style="color: #fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_uplata_sub.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>                   
                    ';
		}
	}
 
	// funkcija za update uplata ustanova - REZIDENTI
	function update_uplata()
	{
		if(isset($_POST['update_uplata']))
		{					
            
            $broj_fakture  = escape_string($_POST['broj_fakture']); 
            $datum_upl     = $_POST['datum_fakture'];
            $datum_uplate  = date('Y-m-d',strtotime($datum_upl)); 
            $iznos_uplate  = escape_string($_POST['iznos_uplate']);
			
			$query = "UPDATE ustanove_uplate SET ";
			$query .= "broj_fakture  = '{$broj_fakture}', ";
			$query .= "datum_uplate  = '{$datum_uplate}', ";
			$query .= "iznos_uplate  = '{$iznos_uplate}' ";
            $query .= "WHERE upl_id=" . escape_string($_GET['id']);

			$send_update_query = query($query);
			confirm($send_update_query);
			
			set_message("Uplata je uspješno izmjenjena.");
			header("Refresh:0");

		}
	}
 
    // funkcija za print prikaz svih ustanova staziranja koji pripadaju nekoj specijalizaciji REZIDENTI
	function print_lista_ustanova_staziranja($specid, $oznaka)
	{
        // $query = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.spec_id =". $specid ." ");                                    
        // $query  = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos, sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo FROM ustanove_staz us, ustanove u, ustanove_uplate up WHERE us.u_id = u.u_id  AND us.us_id = up.us_id AND us.spec_id = ". $specid . " GROUP BY us.us_id, u.u_title, us.iznos");                                    
        // confirm($query);
        
		$firstquery  = "SELECT us.us_id as id, u.u_title as title, us.iznos as iznos, ";
		$firstquery .= "sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo ";
		$firstquery .= "FROM ustanove_staz us, ustanove u, ustanove_uplate up ";
		$firstquery .= "WHERE us.u_id = u.u_id  AND us.us_id = up.us_id ";
		$firstquery .= "AND us.spec_id = '{$specid}' ";
		$firstquery .= "AND us.oznaka = '{$oznaka}' ";
		$firstquery .= "GROUP BY us.us_id, u.u_title, us.iznos ";
        
        $query = query($firstquery);
        confirm($query);
  
        
		while($row = fetch_array($query)) 
		{
            $us_id      = escape_string($row['id']);
            $us_title   = escape_string($row['title']);
            $iznos      = escape_string($row['iznos']);
            $suma       = escape_string($row['suma_uplata']);
            $preostalo  = escape_string($row['preostalo']);
                                          
			echo '		
					<tr>
						<td>'. $us_title .'</td>					
						<td>'. $iznos .'</td>					
						<td>'. $suma .'</td>					
						<td>'. $preostalo .'</td>					
					</tr>                    
                    ';
		}
        
        // $query2 = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.us_id not in ( select us_id from ustanove_uplate ) AND us.spec_id =". $specid ." ");                                    
        
		$secondquery  = "SELECT us.us_id as id, u.u_title as title, us.iznos as iznos ";
		$secondquery .= "FROM ustanove_staz us, ustanove u ";
		$secondquery .= "WHERE us.u_id = u.u_id ";
		$secondquery .= "AND us.us_id not in ( SELECT us_id FROM ustanove_uplate ) ";
		$secondquery .= "AND us.spec_id = '{$specid}' ";
		$secondquery .= "AND us.oznaka = '{$oznaka}' ";
		$secondquery .= "GROUP BY us.us_id, u.u_title, us.iznos ";
        
        $query2 = query($secondquery);
        confirm($query2);
               
		while($row = fetch_array($query2)) 
		{
            $us_id_2      = escape_string($row['id']);
            $us_title_2   = escape_string($row['title']);
            $iznos_2      = escape_string($row['iznos']);
            $suma_2       = '0';
            $preostalo_2  = $iznos_2;
                                          
			echo '		
					<tr>
						<td>'. $us_title_2 .'</td>					
						<td>'. $iznos_2 .'</td>					
						<td>'. $suma_2 .'</td>					
						<td>'. $preostalo_2 .'</td>					
					</tr>                 
                    ';
		}               
	} 


   
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // BIH sub - specijalizacije //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // funkcija racuna broj subpecijalizacija u tabeli - REZIDENTI
	function count_subspecijalizacije()
	{
		$category_query = query("SELECT count(*) as broj_subspecijalizacija FROM rez_subspecijalizacije");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$broj_subspecijalizacija = $row['broj_subspecijalizacija'];                                                  
			echo $broj_subspecijalizacija;           
		}
	}

    // funkcija racuna broj uplata za sve subpecijalizacije - REZIDENTI
	function count_uplate_subspec()
	{
		$category_query = query("SELECT count(*) as broj_uplata_subspec FROM ustanove_uplate WHERE us_id in ( SELECT us_id FROM ustanove_staz WHERE oznaka = 'RSS')");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$broj_uplata_subspec = $row['broj_uplata_subspec'];                                                  
			echo $broj_uplata_subspec;           
		}
	}
    
    // funkcija za prikaz svih bh. subspecijalizacija u tabeli
	function lista_bh_subspecijalizacija()
	{
		$category_query = query("SELECT subspec_id, spec_id, broj_evid_godina, ime_prezime, jmbg FROM rez_subspecijalizacije ORDER BY subspec_id DESC");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$subspec_id       = $row['subspec_id'];
			$spec_id          = $row['spec_id'];
			$broj_evid_godina = $row['broj_evid_godina'];
			$ime_prezime      = $row['ime_prezime'];
			$jmbg             = $row['jmbg'];

                $query  = "SELECT broj_evid_godina ";
                $query .= "FROM rez_specijalizacije ";
                $query .= "WHERE spec_id = '{$spec_id}' ";
                
                $select_query = query($query);
                confirm($select_query);
                while($row2 = fetch_array($select_query)) 
                {
                    $specijalizacija = $row2['broj_evid_godina'];
                }
        
			echo '		
					<tr>								
						<td>'.htmlentities($row["broj_evid_godina"]).'</td>	
						<td>'.$specijalizacija.'</td>                        
						<td>'.htmlentities($row["ime_prezime"]).'</td>					
						<td>'.htmlentities($row["jmbg"]).'</td>					
						<td class="text-right">
                            <a class="btn btn-gray-dark btn-sm" href="view_rez_subspecijalizacija.php?id='.htmlentities($row["subspec_id"]).'">
						    <i class="fe fe-search"></i> Pregled
                            </a>                            
                            <a class="btn btn-cyan btn-sm" href="edit_rez_subspecijalizacija.php?id='.htmlentities($row["subspec_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger btn-sm" onClick="deleteme('.$subspec_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_subspecijalizacija.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>   
                    ';           
		}
	}
    
	// funkcija za update specijalizacije 'nekog/bilo kojeg' rezidenta
	function update_rez_subspecijalizacija()
	{
		if(isset($_POST['update_rez_subspecijalizacija']))
		{					
            // error_reporting(E_ALL);
            // Obrada forme	    
            
            $drzava           = (int)$_POST['drzava'];
            $fakultet         = (int)$_POST['fakultet'];
            $ustanova         = (int)$_POST['ustanova'];
            $spec             = (int)$_POST['spec'];
            $jezik            = (int)$_POST['jezik'];
            
            $broj_evid        = mysql_prep($_POST["broj_evid"]);
            $ime              = mysql_prep($_POST["ime"]);
            $jmbg             = mysql_prep($_POST["jmbg"]);
            $adresa           = mysql_prep($_POST["adresa"]);
            $broj_diplome     = mysql_prep($_POST["broj_diplome"]);
            
            $fak_dat          = $_POST['fak_datum'];
            $fak_datum        = date('Y-m-d',strtotime($fak_dat));   
            
            $fak_rjesenje     = mysql_prep($_POST["fak_rjesenje"]);
            $fak_izdato       = mysql_prep($_POST["fak_izdato"]);
            $str_mjesto       = mysql_prep($_POST["str_mjesto"]);
            
            $str_dat          = $_POST['str_datum'];
            $str_datum        = date('Y-m-d',strtotime($str_dat));       
            
            $str_broj         = mysql_prep($_POST["str_broj"]);
            $dokaz            = mysql_prep($_POST["dokaz"]);
            $broj_rjesenja    = mysql_prep($_POST["broj_rjesenja"]);
            
            $staz_dat         = $_POST['datum_poc_staza'];
            $datum_poc_staza  = date('Y-m-d',strtotime($staz_dat)); 
      
            $upl_1            = mysql_prep($_POST["upl_1"]);    
            $d_up1            = $_POST['dat_up1'];
            $dat_up1          = date('Y-m-d',strtotime($d_up1)); 
            
            $upl_2            = mysql_prep($_POST["upl_2"]);
            $d_up2            = $_POST['dat_up2'];
            $dat_up2          = date('Y-m-d',strtotime($d_up2)); 
 
            $broj_rj_datum    = mysql_prep($_POST["broj_rj_datum"]);
            $d_pre_staza      = $_POST["dat_pre_staza"];
            $dat_pre_staza    = date('Y-m-d',strtotime($d_pre_staza)); 
            $povrat           = mysql_prep($_POST["povrat"]);
                
            $user_unio        = $_SESSION['username'];          

            $image                = $_FILES['file']['name'];
            $image_temp_location  = $_FILES['file']['tmp_name'];
            
			if(empty($image))
			{
				$get_pic = query("SELECT image FROM rez_subspecijalizacije WHERE subspec_id =" .escape_string($_GET['id']). " ");
				confirm($get_pic);

				while($pic = fetch_array($get_pic)) 
				{
					$image = $pic['image'];
				}
			}
            
            move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $image);
                     
            // $destination_path = getcwd().DIRECTORY_SEPARATOR .'/uploads/';
            // $target_path = $destination_path . basename( $_FILES["file"]["name"]);
            // @move_uploaded_file($_FILES['file']['tmp_name'], $target_path);
                      
                
                    $query = "UPDATE rez_subspecijalizacije SET ";
                    $query .= "d_id                 = '{$drzava}', ";
                    $query .= "fak_id               = '{$fakultet}', ";
                    $query .= "u_id                 = '{$ustanova}', ";
                    $query .= "vs_id                = '{$spec}', ";
                    $query .= "l_id                 = '{$jezik}', ";
                    $query .= "broj_evid_godina     = '{$broj_evid}', ";
                    $query .= "ime_prezime          = '{$ime}', ";
                    $query .= "jmbg                 = '{$jmbg}', ";
                    $query .= "adresa               = '{$adresa}', ";
                    $query .= "fak_broj_diplome     = '{$broj_diplome}', ";
                    $query .= "fak_datum            = '{$fak_datum}', ";
                    $query .= "fak_nostro_rjesenje  = '{$fak_rjesenje}', ";
                    $query .= "fak_nostro_izdato    = '{$fak_izdato}', ";
                    $query .= "strucni_ispit_mjesto = '{$str_mjesto}', ";
                    $query .= "strucni_ispit_datum  = '{$str_datum}', ";
                    $query .= "strucni_ispit_broj   = '{$str_broj}', ";
                    $query .= "radni_staz_dokaz     = '{$dokaz}', ";
                    $query .= "broj_rjesenja_godina = '{$broj_rjesenja}', ";
                    $query .= "datum_poc_staza      = '{$datum_poc_staza}', ";
                    $query .= "uplata_prva_rata     = '{$upl_1}', ";
                    $query .= "datum_prva_rata      = '{$dat_up1}', ";
                    $query .= "uplata_druga_rata    = '{$upl_2}', ";
                    $query .= "datum_druga_rata     = '{$dat_up2}', ";
                    $query .= "broj_rjesenja_datum  = '{$broj_rj_datum}', ";
                    $query .= "datum_pres_staza     = '{$dat_pre_staza}', ";
                    $query .= "povrat_sredstava     = '{$povrat}', ";
                    $query .= "image                = '{$image}', ";
                    $query .= "user_unio            = '{$user_unio}' ";
                    $query .= "WHERE subspec_id=" . escape_string($_GET['id']);

                    $send_update_query = query($query);
                    confirm($send_update_query);
                    
                    set_message("Subpecijalizacija : <b>" . $broj_evid  . "</b> uspješno izmjenjena ");
                    redirect("rez_subspecijalizacije.php");

		}
	}     
/**************************************************************************************************************************************************/  
/**** REZIDENTI SPECIJALIZACIJE *******************************************************************************************************************/ 
/**************************************************************************************************************************************************/ 
/**************************************************************************************************************************************************/ 
/**************************************************************************************************************************************************/  
/**** NEREZIDENTI SPECIJALIZACIJE *****************************************************************************************************************/ 
/**************************************************************************************************************************************************/ 

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // NS specijalizacije //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // funkcija racuna broj specijalizacija u tabeli - NEREZIDENTI
	function count_nerez_specijalizacije()
	{
		$category_query = query("SELECT count(*) as broj_specijalizacija FROM nerez_specijalizacije");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$broj_specijalizacija = $row['broj_specijalizacija'];                                                  
			echo $broj_specijalizacija;           
		}
	}

    // funkcija racuna broj uplata za sve subpecijalizacije
	// function count_nerez_uplate_spec()
	// {
	// 	$category_query = query("SELECT count(*) as broj_uplata_spec FROM ustanove_uplate WHERE us_id in ( SELECT us_id FROM ustanove_staz WHERE oznaka = 'NS')");
	// 	confirm($category_query);
    //            
	// 	while($row = fetch_array($category_query)) 
	// 	{
	// 		$broj_uplata_spec = $row['broj_uplata_spec'];                                                  
	// 		echo $broj_uplata_spec;           
	// 	}
	// }
    
    // funkcija za prikaz svih specijalizacija nerezidenata u tabeli
	function lista_nerez_specijalizacija()
	{
		$category_query = query("SELECT spec_id, broj_evid_godina, ime_prezime, datum_rodjenja, dozvola_broj FROM nerez_specijalizacije ORDER BY spec_id DESC");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$spec_id          = $row['spec_id'];
			$broj_evid_godina = $row['broj_evid_godina'];
			$ime_prezime      = $row['ime_prezime'];
			$datum_rodjenja   = $row['datum_rodjenja'];
			$dozvola_broj     = $row['dozvola_broj'];
                                                  
			echo '		
					<tr>			
						<td>'.htmlentities($row["broj_evid_godina"]).'</td>					
						<td>'.htmlentities($row["ime_prezime"]).'</td>						
                        <td>'.date("d.m.Y", strtotime($row["datum_rodjenja"])).'</td>                        
						<td>'.htmlentities($row["dozvola_broj"]).'</td>					
						<td>
                            <a class="btn btn btn-outline-primary btn-sm" href="add_nerez_subspecijalizacija.php?id='.htmlentities($row["spec_id"]).'">
						    <i class="fe fe-plus"></i> Subspecijalizacija
                            </a>
                        </td>					
						<td class="text-right">
                            <a class="btn btn-gray-dark btn-sm" href="view_nerez_specijalizacija.php?id='.htmlentities($row["spec_id"]).'">
						    <i class="fe fe-search"></i> Pregled
                            </a>                            
                            <a class="btn btn-cyan btn-sm" href="edit_nerez_specijalizacija.php?id='.htmlentities($row["spec_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger btn-sm" onClick="deleteme('.$spec_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_nerez_specijalizacija.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>   
                    ';           
		}
	}

	// funkcija za update specijalizacije 'nekog/bilo kojeg' nerezidenta
	function update_nerez_specijalizacija()
	{
		if(isset($_POST['update_nerez_specijalizacija']))
		{					
            //error_reporting(E_ALL);
            // Obrada forme	    
            
            $drzava           = (int)$_POST['drzava'];
            $fakultet         = (int)$_POST['fakultet'];
            $spec             = (int)$_POST['spec'];
                       
            $broj_evid        = mysql_prep($_POST["broj_evid"]);
            $ime              = mysql_prep($_POST["ime"]);
            
            $datum_ro         = $_POST['datum_rodjenja'];
            $datum_rodjenja   = date('Y-m-d',strtotime($datum_ro)); 

            $jezik            = mysql_prep($_POST["jezik"]);
            $broj_diplome     = mysql_prep($_POST["broj_diplome"]);  
            
            $fak_dat          = $_POST['fak_datum'];
            $fak_datum        = date('Y-m-d',strtotime($fak_dat));             
            $fak_rjesenje     = mysql_prep($_POST["fak_rjesenje"]);
            $fak_izdato       = mysql_prep($_POST["fak_izdato"]);
            
            $doz_broj         = mysql_prep($_POST["doz_broj"]);      
            $doz_dat          = $_POST['doz_datum'];
            $doz_datum        = date('Y-m-d',strtotime($doz_dat));                 
            $doz_izdata       = mysql_prep($_POST["doz_izdata"]);
            
            $izj_broj         = mysql_prep($_POST["izj_broj"]);      
            $izj_dat          = $_POST['izj_datum'];
            $izj_datum        = date('Y-m-d',strtotime($izj_dat));                 
            $izj_izdata       = mysql_prep($_POST["izj_izdata"]);
            
            $broj_rjesenja    = mysql_prep($_POST["broj_rjesenja"]);
            
            $staz_dat         = $_POST['datum_poc_staza'];
            $datum_poc_staza  = date('Y-m-d',strtotime($staz_dat)); 
      
            $upl_1            = mysql_prep($_POST["upl_1"]);    
            $d_up1            = $_POST['dat_up1'];
            $dat_up1          = date('Y-m-d',strtotime($d_up1)); 
             
            $broj_rj_datum    = mysql_prep($_POST["broj_rj_datum"]);
            $d_pre_staza      = $_POST["dat_pre_staza"];
            $dat_pre_staza    = date('Y-m-d',strtotime($d_pre_staza)); 
            $povrat           = mysql_prep($_POST["povrat"]);
                
            $user_unio        = $_SESSION['username'];          

            $image                = $_FILES['file']['name'];
            $image_temp_location  = $_FILES['file']['tmp_name'];
            
			if(empty($image))
			{
				$get_pic = query("SELECT image FROM nerez_specijalizacije WHERE spec_id =" .escape_string($_GET['id']). " ");
				confirm($get_pic);

				while($pic = fetch_array($get_pic)) 
				{
					$image = $pic['image'];
				}
			}
            
            move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $image);
                     
            // $destination_path = getcwd().DIRECTORY_SEPARATOR .'/uploads/';
            // $target_path = $destination_path . basename( $_FILES["file"]["name"]);
            // @move_uploaded_file($_FILES['file']['tmp_name'], $target_path);
                      
                
                    $query = "UPDATE nerez_specijalizacije SET ";
                    $query .= "d_id                 = '{$drzava}', ";
                    $query .= "fak_id               = '{$fakultet}', ";
                    $query .= "vs_id                = '{$spec}', ";
                    $query .= "broj_evid_godina     = '{$broj_evid}', ";
                    $query .= "ime_prezime          = '{$ime}', ";
                    $query .= "datum_rodjenja       = '{$datum_rodjenja}', ";
                    $query .= "sluzbeni_jezik       = '{$jezik}', ";
                    $query .= "fak_broj_diplome     = '{$broj_diplome}', ";
                    $query .= "fak_datum            = '{$fak_datum}', ";
                    $query .= "fak_nostro_rjesenje  = '{$fak_rjesenje}', ";
                    $query .= "fak_nostro_izdato    = '{$fak_izdato}', ";
                    $query .= "dozvola_broj         = '{$doz_broj}', ";
                    $query .= "dozvola_datum        = '{$doz_datum}', ";
                    $query .= "dozvola_izdato       = '{$doz_izdata}', ";
                    $query .= "izjava_broj          = '{$izj_broj}', ";
                    $query .= "izjava_datum         = '{$izj_datum}', ";
                    $query .= "izjava_izdato        = '{$izj_izdata}', ";
                    $query .= "broj_rjesenja_godina = '{$broj_rjesenja}', ";
                    $query .= "datum_poc_staza      = '{$datum_poc_staza}', ";
                    $query .= "uplata_prva_rata     = '{$upl_1}', ";
                    $query .= "datum_prva_rata      = '{$dat_up1}', ";
                    $query .= "broj_rjesenja_datum  = '{$broj_rj_datum}', ";
                    $query .= "datum_pres_staza     = '{$dat_pre_staza}', ";
                    $query .= "povrat_sredstava     = '{$povrat}', ";
                    $query .= "image                = '{$image}', ";
                    $query .= "user_unio            = '{$user_unio}' ";
                    $query .= "WHERE spec_id=" . escape_string($_GET['id']);

                    $send_update_query = query($query);
                    confirm($send_update_query);
                    
                    set_message("Specijalizacija stranog državljanina : <b>" . $broj_evid  . "</b> uspješno izmjenjena ");
                    redirect("nerez_specijalizacije.php");

		}
	}      
    
    // funkcija za prikaz svih ustanova staziranja koji pripadaju nekoj specijalizaciji - NEERZIDENTI
	function lista_ustanova_staziranja_nerez($specid, $oznaka)
	{
        // $query = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.spec_id =". $specid ." ");                                    
        // $query  = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos, sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo FROM ustanove_staz us, ustanove u, ustanove_uplate up WHERE us.u_id = u.u_id  AND us.us_id = up.us_id AND us.spec_id = ". $specid . " GROUP BY us.us_id, u.u_title, us.iznos");                                    
        // confirm($query);
        
		$firstquery  = "SELECT us.us_id as id, u.u_title as title, us.period_staza as period, us.iznos as iznos, ";
		$firstquery .= "sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo ";
		$firstquery .= "FROM ustanove_staz_nerez us, ustanove u, ustanove_uplate_nerez up ";
		$firstquery .= "WHERE us.u_id = u.u_id  AND us.us_id = up.us_id ";
		$firstquery .= "AND us.spec_id = '{$specid}' ";
		$firstquery .= "AND us.oznaka = '{$oznaka}' ";
		$firstquery .= "GROUP BY us.us_id, u.u_title, us.period_staza, us.iznos ";
        
        $query = query($firstquery);
        confirm($query);
  
        
		while($row = fetch_array($query)) 
		{
            $us_id      = escape_string($row['id']);
            $us_title   = escape_string($row['title']);
            $iznos      = escape_string($row['iznos']);
            $period     = escape_string($row['period']);
            $suma       = escape_string($row['suma_uplata']);
            $preostalo  = escape_string($row['preostalo']);
                                          
			echo '		
					<tr>
						<td>'. $us_title .'</td>					
						<td>'. $period .'</td>					
						<td>'. $iznos .'</td>					
						<td>'. $suma .'</td>					
						<td>'. $preostalo .'</td>					
						<td class="text-right">
                            <a class="btn btn-lime" href="ustanove_uplate_nerez.php?id='. $us_id .'">
						    <i class="fe fe-dollar-sign"></i> Uplate
                            </a>                            
                            <a class="btn btn-cyan" href="edit_ustanova_staziranja_nerez.php?id='. $us_id .'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$us_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>   
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                                window.location.href="../resources/templates/back/delete_ustanova_staza_nerez.php?id=" + delid;
                                return true;
                            }
                        } 
                    </script>                     
                    ';
		}
        
        // $query2 = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.us_id not in ( select us_id from ustanove_uplate ) AND us.spec_id =". $specid ." ");                                    
        
		$secondquery  = "SELECT us.us_id as id, u.u_title as title, us.period_staza as period, us.iznos as iznos ";
		$secondquery .= "FROM ustanove_staz_nerez us, ustanove u ";
		$secondquery .= "WHERE us.u_id = u.u_id ";
		$secondquery .= "AND us.us_id not in ( SELECT us_id FROM ustanove_uplate_nerez ) ";
		$secondquery .= "AND us.spec_id = '{$specid}' ";
		$secondquery .= "AND us.oznaka = '{$oznaka}' ";
		$secondquery .= "GROUP BY us.us_id, u.u_title, us.period_staza, us.iznos ";
        
        $query2 = query($secondquery);
        confirm($query2);
               
		while($row = fetch_array($query2)) 
		{
            $us_id_2      = escape_string($row['id']);
            $us_title_2   = escape_string($row['title']);
            $iznos_2      = escape_string($row['iznos']);
            $period_2      = escape_string($row['period']);
            $suma_2       = '0';
            $preostalo_2  = $iznos_2;
                                          
			echo '		
					<tr>
						<td>'. $us_title_2 .'</td>					
						<td>'. $period_2 .'</td>					
						<td>'. $iznos_2 .'</td>					
						<td>'. $suma_2 .'</td>					
						<td>'. $preostalo_2 .'</td>					
						<td class="text-right">
                            <a class="btn btn-lime" href="ustanove_uplate_nerez.php?id='. $us_id_2 .'">
						    <i class="fe fe-dollar-sign"></i> Uplate
                            </a>                            
                            <a class="btn btn-cyan" href="edit_ustanova_staziranja_nerez.php?id='. $us_id_2 .'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleterow('.$us_id_2.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleterow(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_ustanova_staza_nerez.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>                     
                    ';
		}        
        
	} 
    
	// funkcija za update zdravstvene ustanove koja pripada nekoj specijalizaciji ili subspecijalizaciji - NEREZIDENTI
	function update_zdravstvena_ustanova_nerez()
	{
        // edit ustanove specijalizacije
		if(isset($_POST['update_zdravstvena_ustanova_nerez']))
		{					
			$ustanova = escape_string($_POST['ustanova']);
 			$period   = escape_string($_POST['period']);           
			$iznos    = escape_string($_POST['iznos']);
			
			$query  = "UPDATE ustanove_staz_nerez SET ";
			$query .= "u_id                 = '{$ustanova}', ";
			$query .= "period_staza         = '{$period}', ";
			$query .= "iznos                = '{$iznos}' ";
			$query .= "WHERE us_id=" . escape_string($_GET['id']);
            
			$send_update_query = query($query);
			confirm($send_update_query);
            set_message("Ustanova stažiranja je uspješno editovana.");
            
            // UPDATE gotov, sada idemo nazad na specijalizaciju kojoj ta ustanova staziranja i pripada            
            $query2 = query("SELECT spec_id from ustanove_staz_nerez WHERE us_id=" . escape_string($_GET['id']) . " ");
            confirm($query2);
                          
		    while($row = fetch_array($query2)) {
                redirect('view_nerez_specijalizacija.php?id='.htmlentities($row["spec_id"]).''); // idemo nazad
            }
            
		}
        
        // edit ustanove subspecijalizacije
		if(isset($_POST['update_zdravstvena_ustanova_nerez_sub']))
		{					
			$ustanova = escape_string($_POST['ustanova']);
			$period = escape_string($_POST['period']);            
			$iznos = escape_string($_POST['iznos']);

			
			$query = "UPDATE ustanove_staz_nerez SET ";
			$query .= "u_id                 = '{$ustanova}', ";
			$query .= "period_staza         = '{$period}', ";            
			$query .= "iznos                = '{$iznos}' ";
			$query .= "WHERE us_id=" . escape_string($_GET['id']);
            
			$send_update_query = query($query);
			confirm($send_update_query);
            set_message("Ustanova stažiranja je uspješno editovana.");
            
            // UPDATE gotov, sada idemo nazad na subspecijalizaciju kojoj ta ustanova staziranja i pripada            
            $query2 = query("SELECT spec_id from ustanove_staz_nerez WHERE us_id=" . escape_string($_GET['id']) . " ");
            confirm($query2);
                          
		    while($row = fetch_array($query2)) {
                redirect('view_nerez_subspecijalizacija.php?id='.htmlentities($row["spec_id"]).''); // idemo nazad
            }
		}
	}	
 
    // funkcija za prikaz svih uplata u tabeli - NEREZIDENTI
	function lista_uplata_nerez($id, $oznaka)
	{
          
 	    $query  = "SELECT up.upl_id as upl_id, up.us_id as us_id, up.broj_fakture as broj_fakture, up.datum_uplate as datum_uplate, up.iznos_uplate as iznos_uplate ";
 	    // $query  = "us.spec_id ";
	    $query .= "FROM ustanove_uplate_nerez up, ustanove_staz_nerez us, ustanove u ";
	    $query .= "WHERE up.us_id = us.us_id ";
	    $query .= "AND us.u_id = u.u_id ";
	    $query .= "AND us.oznaka = '{$oznaka}' ";
	    $query .= "AND up.us_id = '{$id}' ";
 
		$select_query = query($query);
		confirm($select_query);
               
		while($row = fetch_array($select_query)) 
		{
			$upl_id         = $row['upl_id'];
			$us_id          = $row['us_id'];
			$broj_fakture   = $row['broj_fakture'];
			$datum_uplate   = $row['datum_uplate'];
			$iznos_uplate   = $row['iznos_uplate'];
 
            if ($datum_uplate == '1970-01-01'){
                $du = '';
            } else {
                $du = date("d.m.Y", strtotime($datum_uplate));
            }  
              
            if( $oznaka=='NS' )
            {
                echo '		
                        <tr>
                            <td>'.htmlentities($row["broj_fakture"]).'</td>
                            <td>'.$du.'</td>	
                            
                            <td class="text-right">'.htmlentities($row["iznos_uplate"]).'</td>						
                            <td class="text-right">
                                <a class="btn btn-cyan" href="edit_ustanove_uplate_nerez.php?id='.htmlentities($row["upl_id"]).'">
                                <i class="fe fe-edit"></i> Izmjeni
                                </a>
                                <a class="btn btn-danger" onClick="deleteme('.$upl_id.')" style="color: #fff;">
                                <i class="fe fe-trash-2"></i> Izbriši
                                </a>
                            </td>
                        </tr> 
                        <script language="javascript">
                            function deleteme(delid)
                            {
                                if(confirm("Jeste li sigurni?"))
                                {
                                window.location.href="../resources/templates/back/delete_uplata_nerez.php?id=" + delid;
                                return true;
                                }
                            } 
                        </script>                   
                        ';            
            }
            
            if($oznaka=='NSS') 
			echo '		
					<tr>
						<td>'.htmlentities($row["broj_fakture"]).'</td>
						<td>'.$du.'</td>	
                        
						<td class="text-right">'.htmlentities($row["iznos_uplate"]).'</td>						
						<td class="text-right">
                            <a class="btn btn-cyan" href="edit_ustanove_uplate_nerez_sub.php?id='.htmlentities($row["upl_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$upl_id.')" style="color: #fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_uplata_nerez_sub.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>                   
                    ';
		}
	} 
    
	// funkcija za update uplata ustanova - NEREZIDENTI
	function update_uplata_nerez()
	{
		if(isset($_POST['update_uplata_nerez']))
		{					
            
            $broj_fakture  = escape_string($_POST['broj_fakture']); 
            $datum_upl     = $_POST['datum_fakture'];
            $datum_uplate  = date('Y-m-d',strtotime($datum_upl)); 
            $iznos_uplate  = escape_string($_POST['iznos_uplate']);
			
			$query = "UPDATE ustanove_uplate_nerez SET ";
			$query .= "broj_fakture  = '{$broj_fakture}', ";
			$query .= "datum_uplate  = '{$datum_uplate}', ";
			$query .= "iznos_uplate  = '{$iznos_uplate}' ";
            $query .= "WHERE upl_id=" . escape_string($_GET['id']);

			$send_update_query = query($query);
			confirm($send_update_query);
			
			set_message("Uplata je uspješno izmjenjena.");
			header("Refresh:0");

		}
	}
    
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // NS subspecijalizacije /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   
    // funkcija za prikaz svih specijalizacija u tabeli
	function lista_nerez_subspecijalizacija()
	{
		$category_query = query("SELECT subspec_id, spec_id, ime_prezime, broj_evid_godina, datum_rodjenja, dozvola_broj FROM nerez_subspecijalizacije ORDER BY subspec_id DESC");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$subspec_id       = $row['subspec_id'];
			$spec_id          = $row['spec_id'];
			$broj_evid_godina = $row['broj_evid_godina'];
			$ime_prezime      = $row['ime_prezime'];
			$datum_rodjenja   = $row['datum_rodjenja'];
			$dozvola_broj     = $row['dozvola_broj'];

                $query  = "SELECT broj_evid_godina ";
                $query .= "FROM nerez_specijalizacije ";
                $query .= "WHERE spec_id = '{$spec_id}' ";
                
                $select_query = query($query);
                confirm($select_query);
                while($row2 = fetch_array($select_query)) 
                {
                    $specijalizacija = $row2['broj_evid_godina'];
                }
                                     
			echo '		
					<tr>								
						<td>'.htmlentities($row["broj_evid_godina"]).'</td>	
						<td>'.$specijalizacija.'</td>                        
						<td>'.htmlentities($row["ime_prezime"]).'</td>					
						<td>'.date("d.m.Y", strtotime($row["datum_rodjenja"])).'</td>					
						<td>'.htmlentities($row["dozvola_broj"]).'</td>					
						<td class="text-right">
                            <a class="btn btn-gray-dark btn-sm" href="view_nerez_subspecijalizacija.php?id='.htmlentities($row["subspec_id"]).'">
						    <i class="fe fe-search"></i> Pregled
                            </a>                            
                            <a class="btn btn-cyan btn-sm" href="edit_nerez_subspecijalizacija.php?id='.htmlentities($row["subspec_id"]).'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger btn-sm" onClick="deleteme('.$subspec_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_nerez_subspecijalizacija.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>   
                    ';           
		}
	}
    
    
	// funkcija za update specijalizacije 'nekog/bilo kojeg' nerezidenta
	function update_nerez_subspecijalizacija()
	{
		if(isset($_POST['update_nerez_subspecijalizacija']))
		{					
            //error_reporting(E_ALL);
            // Obrada forme	    
            
            $drzava           = (int)$_POST['drzava'];
            $fakultet         = (int)$_POST['fakultet'];
            $spec             = (int)$_POST['spec'];
                       
            $broj_evid        = mysql_prep($_POST["broj_evid"]);
            $ime              = mysql_prep($_POST["ime"]);
            
            $datum_ro         = $_POST['datum_rodjenja'];
            $datum_rodjenja   = date('Y-m-d',strtotime($datum_ro)); 

            $jezik            = mysql_prep($_POST["jezik"]);
            $broj_diplome     = mysql_prep($_POST["broj_diplome"]);  
            
            $fak_dat          = $_POST['fak_datum'];
            $fak_datum        = date('Y-m-d',strtotime($fak_dat));             
            $fak_rjesenje     = mysql_prep($_POST["fak_rjesenje"]);
            $fak_izdato       = mysql_prep($_POST["fak_izdato"]);
            
            $doz_broj         = mysql_prep($_POST["doz_broj"]);      
            $doz_dat          = $_POST['doz_datum'];
            $doz_datum        = date('Y-m-d',strtotime($doz_dat));                 
            $doz_izdata       = mysql_prep($_POST["doz_izdata"]);
            
            $izj_broj         = mysql_prep($_POST["izj_broj"]);      
            $izj_dat          = $_POST['izj_datum'];
            $izj_datum        = date('Y-m-d',strtotime($izj_dat));                 
            $izj_izdata       = mysql_prep($_POST["izj_izdata"]);
            
            $broj_rjesenja    = mysql_prep($_POST["broj_rjesenja"]);
            
            $staz_dat         = $_POST['datum_poc_staza'];
            $datum_poc_staza  = date('Y-m-d',strtotime($staz_dat)); 
      
            $upl_1            = mysql_prep($_POST["upl_1"]);    
            $d_up1            = $_POST['dat_up1'];
            $dat_up1          = date('Y-m-d',strtotime($d_up1)); 
             
            $broj_rj_datum    = mysql_prep($_POST["broj_rj_datum"]);
            $d_pre_staza      = $_POST["dat_pre_staza"];
            $dat_pre_staza    = date('Y-m-d',strtotime($d_pre_staza)); 
            $povrat           = mysql_prep($_POST["povrat"]);
                
            $user_unio        = $_SESSION['username'];          

            $image                = $_FILES['file']['name'];
            $image_temp_location  = $_FILES['file']['tmp_name'];
            
			if(empty($image))
			{
				$get_pic = query("SELECT image FROM nerez_subspecijalizacije WHERE spec_id =" .escape_string($_GET['id']). " ");
				confirm($get_pic);

				while($pic = fetch_array($get_pic)) 
				{
					$image = $pic['image'];
				}
			}
            
            move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $image);
                     
            // $destination_path = getcwd().DIRECTORY_SEPARATOR .'/uploads/';
            // $target_path = $destination_path . basename( $_FILES["file"]["name"]);
            // @move_uploaded_file($_FILES['file']['tmp_name'], $target_path);
                      
                
                    $query = "UPDATE nerez_subspecijalizacije SET ";
                    $query .= "d_id                 = '{$drzava}', ";
                    $query .= "fak_id               = '{$fakultet}', ";
                    $query .= "vs_id                = '{$spec}', ";
                    $query .= "broj_evid_godina     = '{$broj_evid}', ";
                    $query .= "ime_prezime          = '{$ime}', ";
                    $query .= "datum_rodjenja       = '{$datum_rodjenja}', ";
                    $query .= "sluzbeni_jezik       = '{$jezik}', ";
                    $query .= "fak_broj_diplome     = '{$broj_diplome}', ";
                    $query .= "fak_datum            = '{$fak_datum}', ";
                    $query .= "fak_nostro_rjesenje  = '{$fak_rjesenje}', ";
                    $query .= "fak_nostro_izdato    = '{$fak_izdato}', ";
                    $query .= "dozvola_broj         = '{$doz_broj}', ";
                    $query .= "dozvola_datum        = '{$doz_datum}', ";
                    $query .= "dozvola_izdato       = '{$doz_izdata}', ";
                    $query .= "izjava_broj          = '{$izj_broj}', ";
                    $query .= "izjava_datum         = '{$izj_datum}', ";
                    $query .= "izjava_izdato        = '{$izj_izdata}', ";
                    $query .= "broj_rjesenja_godina = '{$broj_rjesenja}', ";
                    $query .= "datum_poc_staza      = '{$datum_poc_staza}', ";
                    $query .= "uplata_prva_rata     = '{$upl_1}', ";
                    $query .= "datum_prva_rata      = '{$dat_up1}', ";
                    $query .= "broj_rjesenja_datum  = '{$broj_rj_datum}', ";
                    $query .= "datum_pres_staza     = '{$dat_pre_staza}', ";
                    $query .= "povrat_sredstava     = '{$povrat}', ";
                    $query .= "image                = '{$image}', ";
                    $query .= "user_unio            = '{$user_unio}' ";
                    $query .= "WHERE subspec_id = " . escape_string($_GET['id']);

                    $send_update_query = query($query);
                    confirm($send_update_query);
                    
                    set_message("Subspecijalizacija stranog državljanina : <b>" . $broj_evid  . "</b> uspješno izmjenjena ");
                    redirect("nerez_subspecijalizacije.php");

		}
	}  
    
    // funkcija za prikaz svih ustanova staziranja koji pripadaju nekoj specijalizaciji - NEERZIDENTI
	function lista_ustanova_staziranja_nerez_sub($specid, $oznaka)
	{
        // $query = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.spec_id =". $specid ." ");                                    
        // $query  = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos, sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo FROM ustanove_staz us, ustanove u, ustanove_uplate up WHERE us.u_id = u.u_id  AND us.us_id = up.us_id AND us.spec_id = ". $specid . " GROUP BY us.us_id, u.u_title, us.iznos");                                    
        // confirm($query);
        
		$firstquery  = "SELECT us.us_id as id, u.u_title as title, us.period_staza as period, us.iznos as iznos, ";
		$firstquery .= "sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo ";
		$firstquery .= "FROM ustanove_staz_nerez us, ustanove u, ustanove_uplate_nerez up ";
		$firstquery .= "WHERE us.u_id = u.u_id  AND us.us_id = up.us_id ";
		$firstquery .= "AND us.spec_id = '{$specid}' ";
		$firstquery .= "AND us.oznaka = '{$oznaka}' ";
		$firstquery .= "GROUP BY us.us_id, u.u_title, us.period_staza, us.iznos ";
        
        $query = query($firstquery);
        confirm($query);
  
        
		while($row = fetch_array($query)) 
		{
            $us_id      = escape_string($row['id']);
            $us_title   = escape_string($row['title']);
            $iznos      = escape_string($row['iznos']);
            $period     = escape_string($row['period']);
            $suma       = escape_string($row['suma_uplata']);
            $preostalo  = escape_string($row['preostalo']);
                                          
			echo '		
					<tr>
						<td>'. $us_title .'</td>					
						<td>'. $period .'</td>					
						<td>'. $iznos .'</td>					
						<td>'. $suma .'</td>					
						<td>'. $preostalo .'</td>					
						<td class="text-right">
                            <a class="btn btn-lime" href="ustanove_uplate_nerez_sub.php?id='. $us_id .'">
						    <i class="fe fe-dollar-sign"></i> Uplate
                            </a>                            
                            <a class="btn btn-cyan" href="edit_ustanova_staziranja_nerez_sub.php?id='. $us_id .'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleteme('.$us_id.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>   
						</td>
					</tr> 
                    <script language="javascript">
                        function deleteme(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                                window.location.href="../resources/templates/back/delete_ustanova_staza_nerez_sub.php?id=" + delid;
                                return true;
                            }
                        } 
                    </script>                     
                    ';
		}
        
        // $query2 = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.us_id not in ( select us_id from ustanove_uplate ) AND us.spec_id =". $specid ." ");                                    
        
		$secondquery  = "SELECT us.us_id as id, u.u_title as title, us.period_staza as period, us.iznos as iznos ";
		$secondquery .= "FROM ustanove_staz_nerez us, ustanove u ";
		$secondquery .= "WHERE us.u_id = u.u_id ";
		$secondquery .= "AND us.us_id not in ( SELECT us_id FROM ustanove_uplate_nerez ) ";
		$secondquery .= "AND us.spec_id = '{$specid}' ";
		$secondquery .= "AND us.oznaka = '{$oznaka}' ";
		$secondquery .= "GROUP BY us.us_id, u.u_title, us.period_staza, us.iznos ";
        
        $query2 = query($secondquery);
        confirm($query2);
               
		while($row = fetch_array($query2)) 
		{
            $us_id_2      = escape_string($row['id']);
            $us_title_2   = escape_string($row['title']);
            $iznos_2      = escape_string($row['iznos']);
            $period_2      = escape_string($row['period']);
            $suma_2       = '0';
            $preostalo_2  = $iznos_2;
                                          
			echo '		
					<tr>
						<td>'. $us_title_2 .'</td>					
						<td>'. $period_2 .'</td>					
						<td>'. $iznos_2 .'</td>					
						<td>'. $suma_2 .'</td>					
						<td>'. $preostalo_2 .'</td>					
						<td class="text-right">
                            <a class="btn btn-lime" href="ustanove_uplate_nerez_sub.php?id='. $us_id_2 .'">
						    <i class="fe fe-dollar-sign"></i> Uplate
                            </a>                            
                            <a class="btn btn-cyan" href="edit_ustanova_staziranja_nerez_sub.php?id='. $us_id_2 .'">
						    <i class="fe fe-edit"></i> Izmjeni
                            </a>
                            <a class="btn btn-danger" onClick="deleterow('.$us_id_2.')" style="color:#fff;">
						    <i class="fe fe-trash-2"></i> Izbriši
                            </a>
						</td>
					</tr> 
                    <script language="javascript">
                        function deleterow(delid)
                        {
                            if(confirm("Jeste li sigurni?"))
                            {
                            window.location.href="../resources/templates/back/delete_ustanova_staza_nerez_sub.php?id=" + delid;
                            return true;
                            }
                        } 
                    </script>                     
                    ';
		}        
        
	} 
    
    
    // funkcija za prikaz svih ustanova staziranja koji pripadaju nekoj specijalizaciji - NEERZIDENTI
	function print_lista_ustanova_staziranja_nerez($specid, $oznaka)
	{
        // $query = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.spec_id =". $specid ." ");                                    
        // $query  = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos, sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo FROM ustanove_staz us, ustanove u, ustanove_uplate up WHERE us.u_id = u.u_id  AND us.us_id = up.us_id AND us.spec_id = ". $specid . " GROUP BY us.us_id, u.u_title, us.iznos");                                    
        // confirm($query);
        
		$firstquery  = "SELECT us.us_id as id, u.u_title as title, us.period_staza as period, us.iznos as iznos, ";
		$firstquery .= "sum(up.iznos_uplate) as suma_uplata, us.iznos - sum(up.iznos_uplate) as preostalo ";
		$firstquery .= "FROM ustanove_staz_nerez us, ustanove u, ustanove_uplate_nerez up ";
		$firstquery .= "WHERE us.u_id = u.u_id  AND us.us_id = up.us_id ";
		$firstquery .= "AND us.spec_id = '{$specid}' ";
		$firstquery .= "AND us.oznaka = '{$oznaka}' ";
		$firstquery .= "GROUP BY us.us_id, u.u_title, us.period_staza, us.iznos ";
        
        $query = query($firstquery);
        confirm($query);
  
        
		while($row = fetch_array($query)) 
		{
            $us_id      = escape_string($row['id']);
            $us_title   = escape_string($row['title']);
            $iznos      = escape_string($row['iznos']);
            $period     = escape_string($row['period']);
            $suma       = escape_string($row['suma_uplata']);
            $preostalo  = escape_string($row['preostalo']);
                                          
			echo '		
					<tr>
						<td>'. $us_title .'</td>					
						<td>'. $period .'</td>					
						<td>'. $iznos .'</td>					
						<td>'. $suma .'</td>					
						<td>'. $preostalo .'</td>					
					</tr>';
		}
        
        // $query2 = query("SELECT us.us_id as id, u.u_title as title, us.iznos as iznos FROM ustanove_staz us, ustanove u WHERE us.u_id = u.u_id AND us.us_id not in ( select us_id from ustanove_uplate ) AND us.spec_id =". $specid ." ");                                    
        
		$secondquery  = "SELECT us.us_id as id, u.u_title as title, us.period_staza as period, us.iznos as iznos ";
		$secondquery .= "FROM ustanove_staz_nerez us, ustanove u ";
		$secondquery .= "WHERE us.u_id = u.u_id ";
		$secondquery .= "AND us.us_id not in ( SELECT us_id FROM ustanove_uplate_nerez ) ";
		$secondquery .= "AND us.spec_id = '{$specid}' ";
		$secondquery .= "AND us.oznaka = '{$oznaka}' ";
		$secondquery .= "GROUP BY us.us_id, u.u_title, us.period_staza, us.iznos ";
        
        $query2 = query($secondquery);
        confirm($query2);
               
		while($row = fetch_array($query2)) 
		{
            $us_id_2      = escape_string($row['id']);
            $us_title_2   = escape_string($row['title']);
            $iznos_2      = escape_string($row['iznos']);
            $period_2      = escape_string($row['period']);
            $suma_2       = '0';
            $preostalo_2  = $iznos_2;
                                          
			echo '		
					<tr>
						<td>'. $us_title_2 .'</td>					
						<td>'. $period_2 .'</td>					
						<td>'. $iznos_2 .'</td>					
						<td>'. $suma_2 .'</td>					
						<td>'. $preostalo_2 .'</td>					
					</tr>';
		}        
        
	}     
    
    // funkcija racuna broj specijalizacija nerezidenata u tabeli
	function count_specijalizacije_nerez()
	{
		$category_query = query("SELECT count(*) as broj_specijalizacija FROM nerez_specijalizacije");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$broj_specijalizacija = $row['broj_specijalizacija'];                                                  
			echo $broj_specijalizacija;           
		}
	}

    // funkcija racuna broj uplata za sve specijalizacije nerezidenata
	function count_uplate_spec_nerez()
	{
		$category_query = query("SELECT count(*) as broj_uplata_spec FROM ustanove_uplate_nerez WHERE us_id in ( SELECT us_id FROM ustanove_staz_nerez WHERE oznaka = 'NS')");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$broj_uplata_spec = $row['broj_uplata_spec'];                                                  
			echo $broj_uplata_spec;           
		}
	}
    
    // funkcija racuna broj subpecijalizacija u tabeli - NEREZIDENTI
	function count_subspecijalizacije_nerez()
	{
		$category_query = query("SELECT count(*) as broj_subspecijalizacija FROM nerez_subspecijalizacije");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$broj_subspecijalizacija = $row['broj_subspecijalizacija'];                                                  
			echo $broj_subspecijalizacija;           
		}
	}

    // funkcija racuna broj uplata za sve subpecijalizacije - NEREZIDENTI
	function count_uplate_subspec_nerez()
	{
		$category_query = query("SELECT count(*) as broj_uplata_subspec FROM ustanove_uplate_nerez WHERE us_id in ( SELECT us_id FROM ustanove_staz_nerez WHERE oznaka = 'NSS')");
		confirm($category_query);
               
		while($row = fetch_array($category_query)) 
		{
			$broj_uplata_subspec = $row['broj_uplata_subspec'];                                                  
			echo $broj_uplata_subspec;           
		}
	}
/**************************************************************************************************************************************************/  
/**** NEREZIDENTI SPECIJALIZACIJE *****************************************************************************************************************/ 
/**************************************************************************************************************************************************/ 

?>