<?php include "/include/connDB.php"; ?>
<?php
	$paramProductCode = $_GET["pc"];
	$queryProducts = "
		#Fetch single product info
		SELECT
			*
		FROM
			products
		WHERE
			productCode = '$paramProductCode'
		LIMIT
			0, 500
	";
	$resultsProducts = mysql_query($queryProducts) or 
		die(mysql_error());
	$numRows = mysql_num_rows($resultsProducts);
	// echo "success! (" . $numRows . " rows)";
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

					<table class="stripeMe">
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
							</tr>
						</thead>
						<?php
							$row = mysql_fetch_array($resultsProducts);
						
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
							echo "<td>" . $productCode . "</td>";
							echo "<td>" . $productName . "</td>";
							echo "<td>" . $productLine . "</td>";
							echo "<td>" . $productScale . "</td>";
							echo "<td>" . $productVendor . "</td>";
							echo "<td>" . $productDescription . "</td>";
							echo "<td>" . $quantityInStock . "</td>";
							echo "<td>" . $buyPrice . "</td>";
							echo "<td>" . $MSRP . "</td>";
							echo "</tr>";
						?>
					</table>
					
				</section>
			</article>

		</div> <!-- #main -->
	</div> <!-- #main-container -->

	<?php include "/include/pagefooter.php"; ?>

<script type="text/javascript">
	$(document).ready(function(){
		$(".stripeMe tr:even").addClass("alt");
		$(".stripeMe tr").mouseover(function(){$(this).addClass("over");}).mouseout(function(){$(this).removeClass("over");});
	});
</script>

</body>
</html>
