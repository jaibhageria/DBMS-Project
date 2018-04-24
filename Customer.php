<?php   //Can I change php sessions through JS
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
 b {color: #6699ff;}
    h3 { font-family: Bodoni;}





body { background-color: #333333;}
}
   </style>
 </head>
 <body>
 
   <?php 
      $servername = "localhost";
      $username = "root";
      $password = "";
      $conn = mysqli_connect($servername, $username, $password, "touristagency");
	  
	  
	  
	  $query = "SELECT city,country from tourist_destination";

      $res =  (mysqli_query($conn, $query));
	  $dest = (mysqli_fetch_assoc($res));
	  
	  $Destination = @$_GET["Destination"];
	  $_SESSION["Destination"] = $Destination;
	  if($Destination!=NULL){
		  $query1 = "SELECT DISTINCT Tour_Operator_Name FROM tour_operator as t, tourist_destination as d, operates_in as o where o.Destination_ID = d.Destination_ID and o.TourOperator_ID = t.Tour_operator_ID and d.city = '$Destination' ";
	      /*$query1 = "SELECT DISTINCT Tour_Operator_Name FROM tour_operator";*/
		  $query2 = "SELECT ratings,best_visit_time FROM tourist_destination where city='$Destination' ";
		  $query3 = "SELECT P_ID FROM package where City='$Destination' ";
		  $query4 = "SELECT DISTINCT Accomodation_Name,Ratings,Reviews FROM accomodation WHERE city='$Destination' ";
		  $res1 =  (mysqli_query($conn, $query1));
		  $res2 = (mysqli_query($conn, $query2));
		  $res3 = (mysqli_query($conn, $query3));
		  $res4 = (mysqli_query($conn, $query4));
          $tour_ops = (mysqli_fetch_assoc($res1));
		  $res2 = (mysqli_fetch_assoc($res2));
		  $res3 = (mysqli_fetch_assoc($res3));
		  $accomo = (mysqli_fetch_assoc($res4));
		  $_SESSION["P_ID"] = $res3["P_ID"];
	  }
	  $TourOperator = @$_GET["tour_operator"];
	  $_SESSION["TourOperator"] = $TourOp;
	  $tr = $_SESSION["Transport"];
	  $transport = explode(",",$tr);
	  
	?>

    <br/><br/>
   <div class = "search">
   <form method="GET" action = "Customer.php" target="_self">
     <br />
     <br />
     <label style= " color: #ff9900;">Select your Destination : <select name="Destination">
                   <!--<option selected="selected">Choose one</option>-->
				   <!--<option value="NULL" selected></option>-->
				   <option value="<?php if($Destination!=NULL){echo $Destination; } else{echo NULL;} ?>"><?php if($Destination!=NULL){echo $Destination; } else{echo NULL;} ?></option>
                   <?php
                      while($dest!=NULL) { ?>
                      <option value="<?php echo $dest["city"] ?>"><?php echo $dest["city"].','.$dest["country"] ?></option>
                   <?php
                    $dest = (mysqli_fetch_assoc($res));} ?>
     </select>
   <?php
       if($res2["ratings"]!=NULL and $res2["best_visit_time"]!=NULL){
		   echo "Your chosen destination has a rating of ".$res2["ratings"]." and the best time to visit there is ".$res2["best_visit_time"].".";
		   $res2["ratings"]=NULL;
		   $res2["best_visit_time"]=NULL;
       }   
   ?>
	 <br/><br/><br/><br/>
	 </label>
     <label style= " color: #ff9900;">Select tour operator : <select name="tour_operator">
                   <option value="NULL" selected></option>
                
                   <?php
                      while($tour_ops!=NULL) { ?>
                      <option value="<?php echo $tour_ops["Tour_Operator_Name"] ?>"><?php echo $tour_ops["Tour_Operator_Name"] ?></option>
                   <?php
                    $tour_ops = (mysqli_fetch_assoc($res1));} ?>
     </select>
	 <label style= " color: #ff9900;"><input type="submit" value="GO" /></label>
	 <label style= " color: #ff9900;"><input type="submit" value="RESET" onclick = "reset();"/></label>
	 <br/><br/><br/><br/>
	 
	 <?php 
	    if($TourOperator!="NULL"){
			echo "Your selected operator ".$TourOperator." has a package to ".$Destination." with the package ID : ".$res3["P_ID"];
			echo "</br></br></br>";
			echo "<label style= \" color: #ff9900;\"><input type=\"submit\" value=\"Check All Accomodations\" name=\"but1\" onclick = \"redirect();\"/></label>";
			echo "</br></br></br>";
			$accomodation = $_SESSION["Accomodation"];
			if($accomodation!=NULL){
				echo "You have selected Accomodation in ".$accomodation;
				echo "</br></br></br>";
			    echo "<label style= \" color: #ff9900;\"><input type=\"submit\" value=\"Check All Transportations\" name=\"but2\" onclick = \"redirect2();\"/></label>";
				echo "</br></br></br>";
				//echo $_GET["Transport"];
			    if($transport[0]!=NULL){
					echo "You have selected ".$transport[1]." as your mode of transport with Transport_ID : ".$transport[0]." and cost ".$transport[2];
				}
			}
				}
	  
	?>
	 </label>
	 <br/><br/>
 
     
   </form>
 </div>
 
 </body>
</html>
<script>

 function redirect(){
    var ele = document.querySelector("form");
	ele.setAttribute("action","Accomodation.php");
 }
 function redirect2(){
    var ele = document.querySelector("form");
	ele.setAttribute("action","Transportations.php");
 }
 function reset(){
    var ele = document.querySelector("form");
	ele.setAttribute("action","reset.php");
 }
</script>
<?php
    /*error_reporting(0);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = mysqli_connect($servername, $username, $password, "touristagency");
    $Destination = @$_GET["Destination"];
    $query = "select DISTINCT Tour_operator_name from tour_operator as t, tourist_destination as d, operates_in as o where o.Destination_ID = d.Destination_ID and o.TourOperator_ID = t.TourOperator_ID and d.city = '$Destination' ";

    $res =  (mysqli_query($conn, $query));
    $k = (mysqli_fetch_assoc($res));
    $main_arr = array(array( ));
    $count = 0;
    while ($k!= NULL)
    {
      if($Movie!=NULL){
        $query = "SELECT * from movies WHERE Title LIKE '%$Movie%'";
        $result =  (mysqli_query($conn, $query));
        $Result = mysqli_fetch_assoc($result);
        while($Result!=NULL){
        /*$main_arr[$count]["Title"] = $Result["Title"];
        $main_arr[$count]["Rating"] = $Result["Rating"];
        $main_arr[$count]["Year"] = $Result["Year"];
        $Result = mysqli_fetch_assoc($result);
        $count++;
        if($Rating != 0 && $Year == 0)
        {
              if($Result["Rating"] >= $Rating && $Result["Rating"] < $Rating+1)
              {
                $main_arr[$count]["Title"] = $Result["Title"];
                $main_arr[$count]["Rating"] = $Result["Rating"];
                $main_arr[$count]["Year"] = $Result["Year"];
                  $count++;
                }
        }
        if($Rating == 0 && $Year != 0)
        {
          if($Result["Year"] == $_GET["year"])
              {
                $main_arr[$count]["Title"] = $Result["Title"];
                $main_arr[$count]["Rating"] = $Result["Rating"];
                $main_arr[$count]["Year"] = $Result["Year"];
                  $count++;
                }
        }
        if($Rating != 0 && $Year != 0)
        {
            if($Result["Year"] == $_GET["year"] && ($Result["Rating"] >=  $Rating && $Result["Rating"] <  $Rating+1))
            {
              $main_arr[$count]["Title"] = $Result["Title"];
              $main_arr[$count]["Rating"] = $Result["Rating"];
              $main_arr[$count]["Year"] = $Result["Year"];
                $count++;
              }
          }
        if($Rating == 0 && $Year == 0)
          {
            $main_arr[$count]["Title"] = $Result["Title"];
            $main_arr[$count]["Rating"] = $Result["Rating"];
            $main_arr[$count]["Year"] = $Result["Year"];
                  $count++;
          }
          $Result = mysqli_fetch_assoc($result);
      }
      break;
      }
      else if($Rating != 0 && $Year == 0 && $Genre=="NULL")
      {
            if($k["Rating"] >= $Rating && $k["Rating"] < $Rating+1)
            {
                $main_arr[$count]["Title"] = $k["Title"];
                $main_arr[$count]["Rating"] = $k["Rating"];
                $main_arr[$count]["Year"] = $k["Year"];
                $count++;
              }
      }
      else if($Rating == 0 && $Year != 0 && $Genre=="NULL")
      {
        if($k["Year"] == $_GET["year"])
            {
                $main_arr[$count]["Title"] = $k["Title"];
                $main_arr[$count]["Rating"] = $k["Rating"];
                $main_arr[$count]["Year"] = $k["Year"];
                $count++;
              }
      }
      else if($Rating != 0 && $Year != 0 && $Genre=="NULL")
      {
          if($k["Year"] == $_GET["year"] && ($k["Rating"] >=  $Rating && $k["Rating"] <  $Rating+1))
          {
              $main_arr[$count]["Title"] = $k["Title"];
              $main_arr[$count]["Rating"] = $k["Rating"];
              $main_arr[$count]["Year"] = $k["Year"];
              $count++;
            }
        }
      else if($Rating == 0 && $Year == 0 && $Genre=="NULL")
        {
                $main_arr[$count]["Title"] = $k["Title"];
                $main_arr[$count]["Rating"] = $k["Rating"];
                $main_arr[$count]["Year"] = $k["Year"];
                $count++;
        }
        else if($Rating == 0 && $Year == 0 && $Genre!=NULL)
          {
            $arr = explode(",",$k["Genre"]);
            if(in_array($Genre,$arr)){
                  $main_arr[$count]["Title"] = $k["Title"];
                  $main_arr[$count]["Rating"] = $k["Rating"];
                  $main_arr[$count]["Year"] = $k["Year"];
                  $count++;
                }
          }
          else if($Rating == 0 && $Year != 0 && $Genre!=NULL)
            {
              $arr = explode(",",$k["Genre"]);
              if(in_array($Genre,$arr) && $k["Year"] == $_GET["year"]){
                    $main_arr[$count]["Title"] = $k["Title"];
                    $main_arr[$count]["Rating"] = $k["Rating"];
                    $main_arr[$count]["Year"] = $k["Year"];
                    $count++;
                  }
            }
            else if($Rating != 0 && $Year == 0 && $Genre!=NULL)
              {
                $arr = explode(",",$k["Genre"]);
                if(in_array($Genre,$arr) && ($k["Rating"] >=  $Rating && $k["Rating"] <  $Rating+1)){
                      $main_arr[$count]["Title"] = $k["Title"];
                      $main_arr[$count]["Rating"] = $k["Rating"];
                      $main_arr[$count]["Year"] = $k["Year"];
                      $count++;
                    }
              }
              else if($Rating != 0 && $Year != 0 && $Genre!=NULL)
                {
                  $arr = explode(",",$k["Genre"]);
                  if(in_array($Genre,$arr) && ($k["Rating"] >=  $Rating && $k["Rating"] <  $Rating+1) && $k["Year"] == $_GET["year"]){
                        $main_arr[$count]["Title"] = $k["Title"];
                        $main_arr[$count]["Rating"] = $k["Rating"];
                        $main_arr[$count]["Year"] = $k["Year"];
                        $count++;
                      }
                }
      $k = (mysqli_fetch_assoc($res));
    }



    foreach ($main_arr as $key)
    {
      echo "<div><b>".$key["Title"]."</b>: This is rated <b>".$key["Rating"]."</b> and was released in the year <b>".$key["Year"]."</b></div><br><br>";
    }

    echo "<div><h3> >>>>>><b>".$count."</b> Results have been found<<<<<<< </h3></div>";*/
 ?>
