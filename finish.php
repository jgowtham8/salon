<?php
	include 'session.php';
	$userID = $userid;
	$billCode = $_POST["billCode"];
	//$date = date("Y-m-d");
	//$time = date("h:i:s");
	$total = $_POST["total"];
	$cash = $_POST["cash"];
	$card = $_POST["card"];
	$cardNote = $_POST["cardNote"];
	$cheque = $_POST["cheque"];
	$chequeNo = $_POST["chequeNo"];
	$chequeDate = $_POST["chequeDate"];
	$bank = $_POST["bank"];

	$s3 = "INSERT INTO bill (UserID,BillCode,BillDate,BillTime,BillStatus,Total,CashPaid,CheqPaid,CheqNo,CheqDate,CheqStatus,CardPaid,CardNote,Status) VALUES ('$userID','$billCode',CURDATE(),CURTIME(),'Finished','$total','$cash','$cheque','$chequeNo','$chequeDate','Pending','$card','$cardNote','Active')";
	
	mysqli_query($db,$s3);
	
	
	$s1 = "SELECT * from temp";
	$res = mysqli_query($db, $s1);
    if(mysqli_num_rows($res) > 0){
        
        while($r = mysqli_fetch_array($res)){
        	$itemID = $r[1];
        	$name = $r[2];
        	$price = $r[3];
        	$qty = $r[4];
        	$lineTotal = $price*$qty;

        	$s2 = "INSERT into billdetail (BillCode,ItemID,Price,Qty,LineTotal) values ('$billCode','$itemID','$price','$qty','$lineTotal');";
        	
        	mysqli_query($db, $s2);

        }
    }
   	
    $s4 = "delete from temp;";
    if(mysqli_query($db, $s4)){
        header("location:bill.php?mes=Success..!");
    }
?>