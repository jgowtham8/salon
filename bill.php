<?php
include 'session.php';
if(isset($_GET["mes"])){
    echo "<script type='text/javascript'> alert('{$_GET['mes']}'); </script>";
}

$s1 = "select BillCode from bill order by id desc limit 1";
$res=$db->query($s1);
    $newBillNo2 = "0";
    if($res->num_rows>0){
        $res=$db->query($s1);
        $r = mysqli_fetch_array($res);
        $billNo = $r[0];
        $newBillNo = (int)$billNo + 2;
        $newBillNo2 = "0000".$newBillNo;
       
    }

$searchKey = "";

if(isset($_POST["txtSearch"])){
    $searchKey = $_POST["txtSearch"];
}

if(isset($_GET["search"])){
    $searchKey = $_GET["search"];
}

?>

<html>
<head>
<meta charset="UTF-8">
<title>Billing</title>
<link rel="stylesheet" type="text/css" href="css/billCSS.css">
<script type="text/javascript">
    function addQty(x) {
        try{
            var qty = document.getElementById(x).value;
            qty++;

            if(qty<1){
                document.getElementById(x).value = 0;
            }
            else{
                document.getElementById(x).value = qty;
            }
        }
        catch(err) {
            alert(err.message);
        }
                                      
    }

    function removeQty(x) {
        var qty = document.getElementById(x).value;
        qty--;
        if(qty<1){
            document.getElementById(x).value = 1;
        }
        else{
            document.getElementById(x).value = qty;
        }
    }

    function showBillTotal() {
        var myTab = document.getElementById('billTable');

        // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
        var total = 0;
        for (i = 1; i < myTab.rows.length; i++) {
            
            var objCells = myTab.rows.item(i).cells;            
            var lineTotal = objCells.item(4).innerHTML;
            var lineTotal2 = Number(lineTotal);
            var total = total + lineTotal2;
            
        }
        var total2 = total.toFixed(2);
        //alert(total2);
        document.getElementById("txtTotal").value = total2;
        
    }   

</script>
</head>
<body onload="showBillTotal();">
	<h2 align="center">Billing</h2>
    <div class="head">
    <form method="post" action="bill.php">
        <label>Search Item/Code :</label>
        <input type="text" name="txtSearch" id="txtSearch" value="<?php echo $searchKey; ?>">
        <input type="submit" name="search" value="Search">
    </form>
    <object align="right"><label><?php echo $newBillNo2; ?></label></object>
    <object align="right"><label>Invoice No :</label></object>
    
    </div>
    <br><br>

	<div class="tableContainer">
    <table border="1" cellpadding="0" cellspacing="0" align="left" width="100%" id="itemTable" style="background-color: #eee">
    <thead>
    <tr>
        <th width=10%>Code</th>
        <th width=26%>Item Name</th>
        <th width=10%>Price</th>
        <th width=10%>Qty</th>
        <th width=14%>+</th>
        <th width=14%>-</th>
        <th width=16%>Add</th>
    </tr>
    </thead>
    <tbody>
        <?php
        if(isset($_POST["search"])) {   //to show searched results after the Search button is pressed
            $searchKey = $_POST["txtSearch"];
            $searchKey2 = $searchKey."%";
            $sql = "SELECT * FROM item WHERE Name LIKE '$searchKey2' OR Code LIKE '$searchKey2'";
            $res=$db->query($sql);
            if($res->num_rows>0){
                $res=$db->query($sql);

                $i=0;
                while($r = mysqli_fetch_array($res)){
                    ++$i;                 
                    $itemID = $r[0];
                    $btnNameAdd = "btnAdd".$i;
                    $btnRemove = "btnRemove".$i;
                    $txtQty = "txtQty".$i;
                    $btnAddToBill = "btnBill".$i;
                    ?>
                    <tr>
                    <form action="addToBill.php" method="post">
                        <input type="hidden" name="searchKey" value="<?php echo $searchKey; ?>">
                        <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">
                        <td><?php echo $r[2]; ?></td>
                        <td><?php echo $r[4]; ?><input type="hidden" name="name" value="<?php echo $r[4]; ?>"></td>
                        <td><input type="number" class="input" name="price" value="<?php echo $r[8]; ?>" style="text-align: center;"></td>
                        
                        <td><input type="number" class="input" name="rowQty" id="<?php echo $txtQty; ?>" value="1" style="text-align: center;"></td>
                        
                        <td><button type="button" class="btnr" name="<?php echo $btnNameAdd; ?>" 
                            onclick="addQty('<?php echo $txtQty;?>')">+</button></td>
                        
                        <td><button type="button" class="btnr" name="<?php echo $btnRemove; ?>" 
                            onclick="removeQty('<?php echo $txtQty;?>')">-</button></td>

                        <td><input type="submit" name="Add" value="Add" class="btnr"></td>
                    </form>
                    </tr>
                <?php
                }
            }
            else{
                echo "No records..!";
            }
        }
        else if(isset($_GET["search"])){    //to show searched results again when this page gets redirection from others
            $searchKey2 = $searchKey."%";
            $sql = "SELECT * FROM item WHERE Name LIKE '$searchKey2' OR Code LIKE '$searchKey2'";
            $res=$db->query($sql);
            if($res->num_rows>0){
                $res=$db->query($sql);

                $i=0;
                while($r = mysqli_fetch_array($res)){
                    ++$i;                 
                    $itemID = $r[0];
                    $btnNameAdd = "btnAdd".$i;
                    $btnRemove = "btnRemove".$i;
                    $txtQty = "txtQty".$i;
                    $btnAddToBill = "btnBill".$i;
                    ?>
                    <tr>
                    <form action="addToBill.php" method="post">
                        <input type="hidden" name="searchKey" value="<?php echo $searchKey; ?>">
                        <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">
                        <td><?php echo $r[2]; ?></td>
                        <td><?php echo $r[4]; ?><input type="hidden" name="name" value="<?php echo $r[4]; ?>"></td>
                        <td><input type="number" class="input" name="price" value="<?php echo $r[8]; ?>" style="text-align: center;" step="any" min="0"></td>
                        
                        <td><input type="number" class="input" name="rowQty" id="<?php echo $txtQty; ?>" value="1" style="text-align: center;"></td>
                        
                        <td><button type="button" class="btnr" name="<?php echo $btnNameAdd; ?>" 
                            onclick="addQty('<?php echo $txtQty;?>')">+</button></td>
                        
                        <td><button type="button" class="btnr" name="<?php echo $btnRemove; ?>" 
                            onclick="removeQty('<?php echo $txtQty;?>')">-</button></td>

                        <td><input type="submit" name="Add" value="Add" class="btnr"></td>
                    </form>
                    </tr>
                <?php
                }
            }                   
        }
        else if($searchKey == ""){  //to show all results when this page is loaded initially..
            $sql = "SELECT * FROM item;";
            $res=$db->query($sql);
            if($res->num_rows>0){
                $res=$db->query($sql);

                $i=0;
                while($r = mysqli_fetch_array($res)){
                    ++$i;                 
                    $itemID = $r[0];
                    $btnNameAdd = "btnAdd".$i;
                    $btnRemove = "btnRemove".$i;
                    $txtQty = "txtQty".$i;
                    $btnAddToBill = "btnBill".$i;
                    ?>
                    <tr>
                    <form action="addToBill.php" method="post">
                        <input type="hidden" name="searchKey" value="<?php echo $searchKey; ?>">
                        <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">
                        <td><?php echo $r[2]; ?></td>
                        <td><?php echo $r[4]; ?><input type="hidden" name="name" value="<?php echo $r[4]; ?>"></td>
                        <td><input type="number" class="input" name="price" value="<?php echo $r[8]; ?>" style="text-align: center;"></td>
                        
                        <td><input type="number" class="input" name="rowQty" id="<?php echo $txtQty; ?>" value="1" style="text-align: center;"></td>
                        
                        <td><button type="button" class="btnr" name="<?php echo $btnNameAdd; ?>" 
                            onclick="addQty('<?php echo $txtQty;?>')">+</button></td>
                        
                        <td><button type="button" class="btnr" name="<?php echo $btnRemove; ?>" 
                            onclick="removeQty('<?php echo $txtQty;?>')">-</button></td>

                        <td><input type="submit" name="Add" value="Add" class="btnr"></td>
                    </form>
                    </tr>
                <?php
                }
            }
            else{
                echo "No records..!";
            }

        }
            ?>
        
        
                                
    </tbody>
    </table>
    </div>
    <br><br>
    <div class="tableContainer">
        <table border="1" cellpadding="0" cellspacing="0" align="right" width="98%" id="billTable" style="background-color: bisque">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Line Total</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql3 = "SELECT * FROM temp;";
                    $res3=$db->query($sql3);
                    if($res3->num_rows>0){
                        $res3=$db->query($sql3);

                        $i=0;
                        while($r3 = mysqli_fetch_array($res3)){
                            ++$i;            
                            $no = $i;
                            $rowId = $r3[0];
                            $name = $r3[2];
                            $price = $r3[3];
                            $qty = $r3[4];
                            //$lineTotal = number_format($price*$qty,2); 
                            $lineTotal = $price*$qty;               

                            echo "<tr><form action='removeRow.php' method='post'>";
                                echo "<td>$no<input type='hidden' name='rowId' value='$rowId'><input type='hidden' name='searchKey' value='$searchKey'></td>";
                                echo "<td>$name</td>";
                                echo "<td>$price</td>";
                                echo "<td>$qty</td>";
                                echo "<td>$lineTotal</td>";
                                echo "<td><input type='submit' name='remove' value='Remove' class='btnr'></td>";
                            echo "</form></tr>"; 
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

    <br>
    <div>
    <form action="finish.php" method="post">
    <table width=50% border="0">
        <tr>
            <td width=50%><label>Total :</label></td>
            <td width=50%><input type="text" name="total" id="txtTotal"></td>
        </tr>

        <tr>
            <td><label>Cash :</label></td>
            <td><input type="text" name="cash"></td>
        </tr>
        <tr>
            <td><label>Card :</label></td>
            <td><input type="text" name="card"></td>
        </tr>

        <tr>
            <td><label>Card Note :</label></td>
            <td><input type="text" name="cardNote"></td>
        </tr>

        <tr>
            <td><label>Card Type :</label></td>
            <td>
                <select name="cardType">
                    <option value="VISA">VISA</option>
                    <option value="MASTER CARD">MASTER CARD</option>
                    <option value="OTHER">OTHER</option>
                </select>
            </td>
        </tr>
    <tr><td><label>Cheque :</label></td>
    <td><input type="text" name="cheque"></td></tr>

    <tr><td><label>Cheque No. :</label></td>
    <td><input type="text" name="chequeNo"></td></tr>

    <tr><td><label>Bank :</label></td>
    <td><select name="bank">
        <option value="BOC">BOC</option>
        <option value="HNB">HNB</option>
        <option value="OTHER">OTHER</option>
    </select></td></tr>
    <tr><td><label>Cheque Date :</label></td>
    <td><input type="Date" name="chequeDate"></td></tr>
</table>
<input type="hidden" name="billCode" value="<?php echo $newBillNo2; ?>">
<br><br>
    <input type="submit" name="finish" value="Finish">
</form>
</div>

</body>
</html>