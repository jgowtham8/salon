<?php
   include('config.php');
   session_start();
   $userid = $_SESSION['userid'];

   if(!isset($_SESSION['userid'])){
      header("location:index.php");

   }

?>