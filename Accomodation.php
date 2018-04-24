<?php 
  error_reporting(0);
  session_start();
  ?>
<html>
 <head>
   <title> Search Page </title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <style>
    .search { position: relative; left: 200px;}

    div {position: relative; left: 450px; color: white;}
@font-face {
  font-family: "Bodoni";
  src: url('Bodoni 72.ttc');
}
 b,th {color: orange;}
    h3 { font-family: Bodoni;}

table{ 
   color: #6699ff;
}



body { background-color: #333333;}
}
   </style>
 </head>
 
 <?php 
      $servername = "localhost";
      $username = "root";
      $password = "";
      $conn = mysqli_connect($servername, $username, $password, "touristagency");
	  $Destination = $_SESSION["Destination"];
	  $_SESSION["Accomodation"] = @$_GET["Accomodation"];
	  $query4 = "SELECT DISTINCT Accomodation_Name,Ratings,Reviews FROM accomodation WHERE city='$Destination' ";
	  $res4 = (mysqli_query($conn, $query4));
	  $accomo = (mysqli_fetch_assoc($res4));
	?>
 <body>
<?php 
			echo "<form method=\"GET\" action = \"Accomodation.php\" target=\"_self\">";
			echo "<b>Here is a list of available accomodations with their details, select any one  : </b>";
			echo "<input type=\"submit\" value=\"Select\" name=\"but1\" />";
			echo "<input type=\"submit\" value=\"Go\" name=\"but1\" onclick = \"redirect();\" />";
			echo "</br></br>";
			echo "<table border='1'>
			           <tr>
					     <th>Select</th>
					     <th>Name</th>
						 <th>Ratings</th>
						 <th>Reviews</th>
					    </tr>";
			while($accomo!=NULL){
				$ac = $accomo["Accomodation_Name"];
			   echo "<tr><td><input type=\"radio\" name=\"Accomodation\" value=\"$ac\" ></td><td>".$accomo["Accomodation_Name"]."</td><td>".$accomo["Ratings"]."</td><td>".$accomo["Reviews"]."</td></tr>";
			   $accomo = (mysqli_fetch_assoc($res4));
			}
			echo "</table></form>";
		
	  
	?>
 </body>
 <script>

 function redirect(){
    var ele = document.querySelector("form");
	ele.setAttribute("action","Customer.php");
 }
 
</script>

 </html>