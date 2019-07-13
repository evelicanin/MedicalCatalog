<?php
    
	ob_start();             // output buffering
	session_start();        // otvaranje sesije
	// session_destroy();   // ubijanje sesije
	
    defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
     
    defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates"  . DS . "front");
   
    defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS ."templates"  . DS . "back");

   
   
      defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS . "uploads");

		
		
    // parametri za konekciju na bazu
	    // host
		defined("DB_HOST") ? null : define("DB_HOST", "localhost");
        // user
		defined("DB_USER") ? null : define("DB_USER", "root");
        // password
		defined("DB_PASS") ? null : define("DB_PASS", "");
        // naziv baze
		defined("DB_NAME") ? null : define("DB_NAME", "db_specialist");
     
	// konekcija na bazu
	$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);   
    
    // VAŽNO -- postavi konekciju na utf-8, inace se nasa slova neće rendat kad se čita iz baze
    mysqli_set_charset($connection,"utf8");
	
	require_once("functions.php");

?>