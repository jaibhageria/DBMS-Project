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
	  $P_ID = $_SESSION["P_ID"];
	  $_SESSION["Transport"] = @$_GET["Transport"];
	  $query4 = "SELECT DISTINCT Transportation_ID,Source,Destination,Mode_Of_Transport,Class,Cost FROM transportation as t,package_has_transport as pt WHERE pt.Package_ID = '$P_ID' and t.Transportation_ID = pt.Transport_ID ";
	  $res4 = (mysqli_query($conn, $query4));
	  $transport = (mysqli_fetch_assoc($res4));
	  
	?>
 <body>
<?php 
			echo "<form method=\"GET\" action = \"Transportations.php\" target=\"_self\">";
			echo "<b>Here is a list of available transportations with their details, select any one  : </b>";
			echo "<input type=\"submit\" value=\"Select\" name=\"but1\" />";
			echo "<input type=\"submit\" value=\"Go\" name=\"but1\" onclick = \"redirect();\" />";
			echo "</br></br>";
			echo "<table border='1'>
			           <tr>
					     <th>Select</th>
						 <th>Transportation_ID</th>
					     <th>Source</th>
						 <th>Destination</th>
						 <th>Mode_Of_Transport</th>
						 <th>Class</th>
						 <th>Cost</th>
					    </tr>";
			while($transport!=NULL){
				$tr = $transport["Transportation_ID"];
				$mode = $transport["Mode_Of_Transport"];
				$cost = $transport["Cost"];
			   echo "<tr><td><input type=\"radio\" name=\"Transport\" value=\"$tr,$mode,$cost\" ></td><td>".$tr."</td><td>".$transport["Source"]."</td><td>".$transport["Destination"]."</td><td>".$mode."</td><td>".$transport["Class"]."</td><td>".$cost."</td></tr>";
			   $transport = (mysqli_fetch_assoc($res4));
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