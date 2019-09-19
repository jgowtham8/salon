<?php
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = $_POST['txtUsername'];
      $mypassword = $_POST['txtPassword']; 
      
      $sql = "SELECT id FROM staff WHERE username = '$myusername' and password = '$mypassword'";

      $result = mysqli_query($db,$sql);
      
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($row = mysqli_fetch_array($result)) {
      	$_SESSION['userid'] = $row[0];
         header("location: bill.php");
      }
      else {
         $error = "Your Login Name or Password is invalid";
         echo $error;
      }
   }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Saloon</title>
    <link rel="stylesheet" type="text/css" href="css/indexCSS.css">
  </head>
<body>
<!--
<table width="96%">

<h2>Login</h2>

<form action="" method="post">
  
    <label for="uname"><b>Username : </b></label>
    <input type="text" placeholder="Enter Username" name="username" value="gowtham"><br><br>

    <label for="psw"><b>Password : </b></label>
    <input type="password" placeholder="Enter Password" name="password" value="123"><br><br>

    <button type="submit">Login</button>
      
</form>
</table>
-->


<div>
      <h1 class="heading">Admin Login</h1>
      <div class="log">    
        <form method="post" action="">
          <label>User Name</label><br>
          <input type="text" name="txtUsername" class="input" value="gowtham"><br><br>
          <label>Password </label><br>
          <input type="password" name="txtPassword" class="input" value="123"><br>
          <button type="submit" class="btn" name="login">Login Here</button>
        </form>
      </div>
</div>

</body>
</html>
