<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = 'touristagency';

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn)
{
  echo "connection failed";
}
else
{
  echo "connection established<br>";
}
?>
