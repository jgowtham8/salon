<?php
include 'session.php';
$searchKey = $_POST["searchKey"];
$rowId = $_POST["rowId"];

$sql="DELETE from temp where ID = '$rowId';";

if($db->query($sql))
{
	header("location:bill.php?search=$searchKey");
}
else
{
	echo "Fail".$db->error;
}



?>