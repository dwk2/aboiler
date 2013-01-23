<?php
	// Required: database connection
	include "/include/connDB.php";

	$paramProductCode = $_REQUEST["pc"];
	$queryProducts = "
		#View each order that included this product
		SELECT
			c.*,
			o.*,
			p.*,
			DATE_FORMAT(o.orderDate, '%m/%d/%Y') as orderDate
		FROM
			products as p
			INNER JOIN orderDetails AS od ON p.productCode = od.productCode
			INNER JOIN orders as o ON od.orderNumber = o.orderNumber
			INNER JOIN customers as c ON o.customerNumber = c.customerNumber
		WHERE
			od.productCode = '$paramProductCode'
		ORDER BY
			o.orderDate DESC
		LIMIT
			0, 50
	";
	$resultsProducts = mysql_query($queryProducts) or 
		die(mysql_error());
	$numRows = mysql_num_rows($resultsProducts);

	// 		eg $lower, $upper
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
						echo "<h1>" . $pageTitle . "</h1>";
						echo "<p>This product has been purchased in <span class=\"fontRed italic\">" . $numRows . "</span> customer orders:</p>";
					?>

				</header>
				<section>

					<table class="stripeMe">
						<thead>
							<tr>
								<th>Order&nbsp;Date</th>
								<th>Company</th>
								<th>Full&nbsp;Name</th>
								<th>Phone</th>
								<th>Country</th>
								<th>View&nbsp;Full&nbsp;Order</th>
							</tr>
						</thead>
						<?php
						
							# takes: a string to be displayed in a table cell and an optional hash of attributes for the table cell
							# returns: a string that's the HTML for the table cell
							function tdOutput($contents, $extraAttributes='')
							{
								$res = '<td';
								if ($extraAttributes)
								{
									foreach ($extraAttributes as $attr => $val)
									{
										$res .= " $attr=\"$res\"";
									}
								}
								$res .= ">$contents</td>";
								
								return $res;
							}

							# takes: a string to be displayed in a table cell and an optional hash of attributes for the table cell
							# returns: a string that's the HTML for the table cell
							function trOutput($contentsArray, $headerArray, $extraAttributes='')
							{
								$res = '<tr';
								if ($extraAttributes)
								{
									foreach ($extraAttributes as $attr => $val)
									{
										$res .= " $attr=\"$res\"";
									}
								}
								$res .= ">$contents</td>";
								
								return $res;
							}


							while ($row = mysql_fetch_array($resultsProducts)) {
						
								$orderDate			= $row["orderDate"];
								$company			= $row["customerName"];
								$fullName			= $row["contactFirstName"] . " " . $row["contactLastName"];
								$phone				= $row["phone"];
								$country			= $row["country"];
								$orderNumber		= $row["orderNumber"];
						
								echo "<tr>";
								echo tdOutput($row["orderDate"]);


								echo "<td>" . $orderDate . "</td>";
								echo "<td>" . $company . "</td>";
								echo "<td>" . $fullName . "</td>";
								echo "<td>" . $phone . "</td>";
								echo "<td>" . $country . "</td>";
								echo "<td><a class=\"moreInfo\" href=\"/aboiler/customer-order.php?oid=" . $orderNumber . "\" title=\"View this customer's complete order\">View&nbsp;Order</a></td>";
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
