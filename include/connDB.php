<?php
	// MySQL connection string
	$connString = mysql_connect("localhost", "root", "password_here") or 
		die("Sorry! You lack proper authentication to the database.");
	
	// USE MySQL database
	mysql_select_db("classicmodels") or
		die(mysql_error());
?>