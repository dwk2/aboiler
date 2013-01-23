<?php
	// set path, and strip off left-most character
	$pathFull = substr($_SERVER["REQUEST_URI"], 1);
	// explode url into array as per delimiter
	$arrayPathBits = explode("/", $pathFull);

	
	// display contents of array
	$tmpPath = "";
	echo "Location: ";
	foreach ($arrayPathBits as $thisBit) {
		$tmpPath = $tmpPath . '/' . $thisBit;
		echo " / <a href=\"$tmpPath\" title=\"title here\">$thisBit</a>";
	};

	
	/*
	# another comment
	echo "<pre>";
	print_r($_SERVER);
	echo "</pre>";
	
	echo '$pathFull\n'; // $pathFull\n
	echo "$pathFull\n"; // foo/bar/baz
	*/

?>

