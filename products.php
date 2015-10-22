<?php
	# Connection String
	include "/include/connDB.php";

	// ------------------------------------------------------
	// BEGIN: Validation Routines
	// ------------------------------------------------------
	# takes: a string. something.
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
			quantityInStock >= $strUpdateSUG
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

<!doctype html>

<?php include "/include/pageheader.php"; ?>

<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

	<div id="header-container">
		<header class="wrapper clearfix">
			<img src="/aboiler/img/steampunk-products-icon.png" alt="" style="float:left" />
	
			<?php include "/include/navtop.php"; ?>

		</header>
	</div>

	<div id="main-container">
		<div id="main" class="wrapper clearfix">
			<div id="breadCrumbs"><?php include "/include/breadcrumbs.php"; ?></div>
			<article>
				<header>
					<?php
						echo "<h1>" . $pageTitle . "</h1>";
						echo "<p>We have <span class=\"fontRed italic\">" . $numRows . "</span> product(s) in stock:</p>";
					?>

				</header>
				<section>

					<table id="SortMe" class="tablesorter">
						<thead>
							<tr>
								<th>Code</th>
								<th>Name</th>
								<th>Line</th>
								<th>Scale</th>
								<th>Vendor</th>
								<th>Description</th>
								<th>Quantity</th>
								<th>Cost</th>
								<th>MSRP</th>
								<th>View&nbsp;Purchases</th>
							</tr>
						</thead>
						<tbody>
						<?php
							while ($row = mysql_fetch_array($resultsProducts)) {
						
								$productCode		= $row["productCode"];
								$productName		= $row["productName"];
								$productLine		= $row["productLine"];
								$productScale		= $row["productScale"];
								$productVendor		= $row["productVendor"];
								$productDescription	= $row["productDescription"];
								$quantityInStock	= $row["quantityInStock"];
								$buyPrice			= $row["buyPrice"];
								$MSRP				= $row["MSRP"];
						
								echo "<tr>";
								echo "<td><a class=\"moreInfo\" href=\"/aboiler/product-info.php?pc=" . $productCode . "\" title=\"View this product\">" . $productCode . "</a></td>";
								echo "<td>" . $productName . "</td>";
								echo "<td>" . $productLine . "</td>";
								echo "<td>" . $productScale . "</td>";
								echo "<td>" . $productVendor . "</td>";
								echo "<td>" . $productDescription . "</td>";
								echo "<td>" . $quantityInStock . "</td>";
								echo "<td>" . $buyPrice . "</td>";
								echo "<td>" . $MSRP . "</td>";
								echo "<td><a class=\"moreInfo\" href=\"/aboiler/product-purchased.php?pc=" . $productCode . "\" title=\"View customers who purchased this product\">View&nbsp;Purchases</a></td>";
								echo "</tr>";
							}
						?>
						</tbody>
					</table>
					
				</section>
			</article>

		</div> <!-- #main -->
	</div> <!-- #main-container -->

	<?php include "/include/pagefooter.php"; ?>

	<script>
		$(document).ready(function(){
			// Tablesorter
			$("#SortMe").tablesorter({
				widgets: ['zebra']
			});
		});
	</script>

</body>
</html>
