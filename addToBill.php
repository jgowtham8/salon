<?php
include 'session.php';
$searchKey = $_POST["searchKey"];
$itemID = $_POST["itemID"];
$name = $_POST["name"];
$price = $_POST["price"];
$qty = $_POST["rowQty"];

$sql="INSERT into temp (ItemID,Name,Price,Qty) values ('$itemID','$name','$price','$qty');";

if($db->query($sql))
{
	header("location:bill.php?search=$searchKey");
}
else
{
	echo "Fail".$db->error;
}



?>