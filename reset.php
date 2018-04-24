<?php 
  /*session_start();
  //session_destroy();
  session_unset($_SESSION["Accomodation"]);
  session_unset($_SESSION["Transport"]);
  //$_GET["Accomodation"] = NULL;
  //$_GET["Transport"] = NULL;*/
  /*session_start();
  session_unset();
  session_destroy();
  session_write_close();
  setcookie(session_name(),'',0,'/');
  session_regenerate_id(true);*/
  //foreach(array_keys($_SESSION) as $k) unset($_SESSION[$k]);
  $_SESSION["Accomodation"] = Array();
  $_SESSION["Transport"] = Array();
  header("location:Customer.php");
?>