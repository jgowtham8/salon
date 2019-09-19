<?php
include 'session.php';
echo '<pre>'; print_r($_SESSION["allRows"]); echo '</pre>';
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
$searchKey2 = $searchKey."%";

/*if(isset($_POST["finish"])){
    //session_unset(); 
    //session_destroy(); 
}*/

?>

<html>
<head>
	<meta charset="UTF-8">
    <title>Billing</title>
    <link rel="stylesheet" type="text/css" href="css/billCSS.css">
    <script type="text/javascript">
        function addQty(x) {
            var qty = document.getElementsByName(x)[0].value;
            qty++;

            if(qty<1){
                document.getElementsByName(x)[0].value = "0";
            }
            else{
                document.getElementsByName(x)[0].value = qty;
            }
                                          
        }

        function removeQty(x) {
            var qty = document.getElementsByName(x)[0].value;
            qty--;
            if(qty<1){
                document.getElementsByName(x)[0].value = "0";
            }
            else{
                document.getElementsByName(x)[0].value = qty;
            }
        }   
    
</script>
</head>
<body>
	<h2 align="center">Billing</h2>
    <div class="head">
    <form method="post" action="bill.php">
        <label>Search Item/Code :</label>
        <input type="text" name="txtSearch" id="txtSearch">
        <input type="submit" name="search" value="Search">
    </form>
    <object align="right"><input type="text" name="txtInvoiceNp" value="<?php echo $newBillNo2; ?>" disabled></object>
    <object align="right"><label>Invoice No. :</label></object>
    
    </div>
    <br><br>

	<div id="outPopUp" class="tableContainer">
    <table border="1" cellpadding="0" cellspacing="0" align="left" width="100%" id="itemTable" style="background-color: bisque">
    <thead>
    <tr>
        <th>Code</th>
        <th>Item Name</th>
        <th>Price</th>
        <th>Qty</th>
        <th>+</th>
        <th>-</th>
        <th>Add</th>
    </tr>
    </thead>
    <tbody>
        <?php
            if(isset($_POST["search"])){
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
                        <td><?php echo $r[2]; ?></td>
                        <td><input type="text" name="name" value="<?php echo $r[4]; ?>" readonly></td>
                        <td><input type="number" name="price" value="<?php echo $r[8]; ?>" style="text-align: center;"></td>
                        
                        <td><input type="number" name="rowQty" value="0" style="text-align: center;"></td>
                        
                        <td><button class="btnr" name="<?php echo $btnNameAdd; ?>" 
                            onclick="addQty('<?php echo $txtQty;?>')">+</button></td>
                        
                        <td><button class="btnr" name="<?php echo $btnRemove; ?>" 
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

    <div id="outPopUp" class="tableContainer">
                        <table border="1" cellpadding="0" cellspacing="0" align="right" width="98%" id="billTable" style="background-color: yellow">
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
                                    $x = 0;
                                    while ($x < sizeof($_SESSION["allRows"])) {                                        
                                        $no = $x + 1;
                                        $name = $_SESSION["allRows"][$x][0];
                                        $price = $_SESSION["allRows"][$x][1];
                                        $qty = $_SESSION["allRows"][$x][2];
                                        $lineTotal = $qty*$price;

                                        echo "<tr>";
                                            echo "<td>$no</td>";
                                            echo "<td>$name</td>";
                                            echo "<td>$price</td>";
                                            echo "<td>$qty</td>";
                                            echo "<td>$lineTotal</td>";
                                            echo "<td><input type='submit' name='Add' value='Remove' class='btnr'></td>";
                                        echo "</tr>";                                          
                                        
                                        $x++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div>
                    <form action="" method="post">
                    <table width=50% border="0">
                        <tr>
                            <td width=50%><label>Total :</label></td>
                            <td width=50%><input type="text" name="total"></td>
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
                <br><br>
                    <input type="button" name="finish" value="Finish">
                </form>
                </div>

</body>
</html>