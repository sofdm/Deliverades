<?php

	session_name("client");
	session_start();
	
	if(session_destroy()) {
	  header("Location: ./login.php");
	}
	
?>