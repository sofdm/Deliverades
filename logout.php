<?php

	session_name("manager");
	session_start();
	
	if(session_destroy()) {
	  header("Location: ./login.php");
	}
?>