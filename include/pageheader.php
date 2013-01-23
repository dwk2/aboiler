<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php
	// Create pretty page title based on filepath
	$pageLocation = $_SERVER["REQUEST_URI"];

	if (strpos($pageLocation, "index.php")) {
		$pageHeader = "Boilers, Inc.";
		$pageTitle = "Welcome!";
	} elseif (strpos($pageLocation, "products.php")) {
		$pageHeader = "Products";
		$pageTitle = "Products List";
	} elseif (strpos($pageLocation, "product-purchased.php")) {
		$pageHeader = "Customers";
		$pageTitle = "Who Purchased this Item";
	} elseif (strpos($pageLocation, "customers.php")) {
		$pageHeader = "Customers";
		$pageTitle = "Our Loyal Customers";
	} elseif (strpos($pageLocation, "customer-order.php")) {
		$pageHeader = "Customers";
		$pageTitle = "Customer Order | Itemized List";
	} elseif (strpos($pageLocation, "staff-directory.php")) {
		$pageHeader = "Staff Directory";
		$pageTitle = "Our Staff";
	} else
		$pageHeader = "Boilers, Inc.";
		$pageTitle = "Good Morning! or Buenos Dias!";

	echo "<title>" . $pageHeader . "</title>";
?>


	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="/aboiler/css/style.css">

	<link rel="stylesheet" href="/aboiler/jquery/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="/aboiler/jquery/tablesorter/jquery.tablesorter.min.js"></script>
<!--
	<script src="/aboiler/js/libs/modernizr-2.5.3-respond-1.1.0.min.js"></script>
-->
</head>