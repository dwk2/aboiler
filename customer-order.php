<?php include "/include/connDB.php"; ?>
<?php
	$paramOrderNumber = $_GET["oid"];
	$queryCustomerInfo = "
		#View customer info and order date (for this order number)
		SELECT
			o.*,
			c.*,
			DATE_FORMAT(o.orderDate, '%m/%d/%Y') as orderDate
		FROM
			orders as o
			INNER JOIN customers as c ON o.customerNumber = c.customerNumber
		WHERE
			o.orderNumber = '$paramOrderNumber'
	";
	$queryOrderList = "
		#View itemized list of products within this customer order
		SELECT
			o.*,
			od.*,
			p.*
		FROM
			orders as o
			INNER JOIN orderDetails AS od ON o.orderNumber = od.orderNumber
			INNER JOIN products as p ON od.productCode = p.productCode
		WHERE
			o.orderNumber = '$paramOrderNumber'
		ORDER BY
			p.productName ASC
		LIMIT
			0, 500
	";
	$resultsCustomerInfo = mysql_query($queryCustomerInfo) or 
		die(mysql_error());
	$resultsOrderList = mysql_query($queryOrderList) or 
		die(mysql_error());
	$numRows = mysql_num_rows($resultsOrderList);
?>

<!doctype html>

<?php include "/include/pageheader.php"; ?>

<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

	<div id="header-container">
		<header class="wrapper clearfix">
			<img src="/aboiler/img/steampunk-orders-icon.png" alt="" style="float:left" />
	
			<?php include "/include/navtop.php"; ?>

		</header>
	</div>

	<div id="main-container">
		<div id="main" class="wrapper clearfix">
			<div id="breadCrumbs"><?php include "/include/breadcrumbs.php"; ?></div>
			<article>
				<header>
					<?php
						$rowCI = mysql_fetch_array($resultsCustomerInfo);
						echo "<h1>" . $pageTitle . "</h1>";
						echo "<table>";
						echo "<thead>";
						echo "<tr><th style=\"width:20%\">Order Number</th><td>" . $rowCI["orderNumber"] . "</td></tr>";
						echo "<tr><th>Order&nbsp;Date</th><td>" . $rowCI["orderDate"] . "</td></tr>";
						echo "<tr><th>Company Name</th><td>" . $rowCI["customerName"] . "</td></tr>";
						echo "<tr><th>Customer Name</th><td>" . $rowCI["contactFirstName"] . " " . $rowCI["contactFirstName"] . "</td></tr>";
						echo "<tr><th>Country</th><td>" . $rowCI["country"] . "</td></tr>";
						echo "<tr><th>Status</th><td>" . $rowCI["status"] . "</td></tr>";
						echo "<tr><th>Comments</th><td>" . $rowCI["comments"] . "</td></tr>";
						echo "</thead>";
						echo "</table>";
					?>
				</header>
				<section>
					<br />
					<table class="stripeMe">
						<thead>
							<tr>
								<th>Product Code</th>
								<th>Product Name</th>
								<th>Quantity</th>
								<th>MSRP</th>
								<th>Our&nbsp;Price</th>
							</tr>
						</thead>
						<?php
							while ($rowOL = mysql_fetch_array($resultsOrderList)) {


								$productCode		= $rowOL["productCode"];
								$productName		= $rowOL["productName"];
								$quantityOrdered	= $rowOL["quantityOrdered"];
								$MSRP				= $rowOL["MSRP"];
								$priceEach			= $rowOL["priceEach"];
						
								echo "<tr>";
								echo "<td><a class=\"moreInfo\" href=\"/aboiler/product-info.php?pc=" . $productCode . "\" title=\"View this product\">" . $productCode . "</a></td>";
								echo "<td>" . $productName . "</td>";
								echo "<td>" . $quantityOrdered . "</td>";
								echo "<td>" . $MSRP . "</td>";
								echo "<td>" . $priceEach . "</td>";
								echo "</tr>";
							}
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
