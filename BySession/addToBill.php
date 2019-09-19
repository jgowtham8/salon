<?php
session_start();
$_SESSION["allRows"];
if($_SESSION["allRows"] == null){
	$_SESSION["allRows"] = array();
}
else{
	$row = array($_POST["name"],$_POST["price"],$_POST["rowQty"]);
	array_push($_SESSION["allRows"],$row);
}
echo '<pre>'; print_r($_SESSION["allRows"]); echo '</pre>';
//header("location: bill.php");

/*foreach ($_SESSION["allRows"] as $row) {
    foreach ($row as $data) {
    	echo "$data <br>";
	}
	echo "<br><br>";
}*/





?>