<?php
	// MySQL connection string
	$connString = mysql_connect("localhost", "root", "loc$4242!pn") or 
		die("Sorry! You lack proper authentication to the database.");
	
	// USE MySQL database
	mysql_select_db("classicmodels") or
		die(mysql_error());
?>