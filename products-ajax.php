<?php
	# Connection String
	include "/include/connDB.php";

	// ------------------------------------------------------
	// BEGIN: Validation Routines
	// ------------------------------------------------------
	# takes: a string
	# returns: a cleaned version of that string, in theory safe for use in queries
	function quote_smart($value)
	{
		// Stripslashes
		if (get_magic_quotes_gpc())
		{
			$value = stripslashes($value);
		}
		// Quote if not integer
		if (!is_numeric($value) || $value[0] == '0')
		{
			$value = "'" . mysql_real_escape_string($value) . "'";
		}
		return $value;
	}

	# takes: an array BY REFERENCE (i.e. sorce var is modified) and the name of the input parameter
	# does: cleans and stores te contents of the input data in _REQUEST into the array
	# NOTE: special input value ANY returns sets the array to empty
	function processArrayInput(&$toArray,$webParamName)
	{
		if (isset($_REQUEST[$webParamName]))
		{
			$toArray = array();
			//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
			if (is_array($_REQUEST[$webParamName]))
			{
				foreach ($_REQUEST[$webParamName] as $webVal)
				{
					$toArray[] = quote_smart($webVal);
				}
			} else {
				$toArray[] = quote_smart($_REQUEST[$webParamName]);
			}
		}
	}
	// END: Validation Routines
	// ------------------------------------------------------

	//echo "<pre>" . print_r($_POST) . "</pre>";


	# AJAX Form: Fetch value
	if (isset($_POST["UpdateSUG"])) {
		$strUpdateSUG = quote_smart(intval($_POST["UpdateSUG"]));
	} else {
		// default value
		$strUpdateSUG = 20;
	}


	$queryProducts = "
		#Fetch single product info
		SELECT
			*
		FROM
			products
		WHERE
			Quantity >= $strUpdateSUG
		LIMIT
			0, 500
	";
	$resultsProducts = mysql_query($queryProducts) or 
		die(mysql_error());
	$numRows = mysql_num_rows($resultsProducts);

	//echo "success! (" . $numRows . " rows)";

	//echo $resultsProducts;
	//exit;
?>


