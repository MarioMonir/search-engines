<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
	
	<style>
	 body
	 {
	 	background-image: url(images/b2.jpg);
	 	font-size: 20px;
	 	font-weight: 100;
	 }
	</style>
<body>


<?php 
 include "functions.php";
//--------------------------------------------------------------------------  
	 
	$arr=websites($folder); 
    $A  = adj_Matrix($arr);               // Adjacency Matrix  A
    $AT = Trans_matrix($A);               // It's Transpose    AT
    #print_matrix($A);
    #print_matrix($AT);

    $authority = array_fill(0,count($arr[0]), 1); //a0 = [1,1,1,....]
    $hub = array_fill(0,count($arr[0]),1); //h0 = [1,1,1,....]
     
     $i=0;
     ${"h_$i"} = $hub;
     ${"a_$i"} = $authority;

    // Iterations  
    $iterations = 2 ;
    
	 for ($i=0; $i < $iterations ; $i++) { 
	        $j=$i+1;
	        ${"a_$j"} = Multiply($AT,${"h_$i"});
	        ${"h_$j"} = Multiply($A,${"a_$j"});
	        ${"a_$j"} = Normalize(${"a_$j"});
	        ${"h_$j"} = Normalize(${"h_$j"});

	        	   $a = ${"a_$j"} ;
				   $h = ${"h_$j"} ;
				  # echo $i+1 . " - ";
				  # print_r($a);
				  #echo "<br><br>";
				  # print_r($h);
	  }
    
	   $a = ${"a_$j"} ;
	   $h = ${"h_$j"} ;

  #print_r($arr[1]);
  $at = array_combine($arr[1],$a);
  $hu = array_combine($arr[1],$h);	
  #print_r($hu);
  $rank = rank_view($a , $h ,$arr);
  //echo"The Authorities";print_r($rank[0]);echo "<br>";
  //echo"The Hubs       ";print_r($rank[1]);echo "<br>";

	echo("<center>");
	echo "<h1>Link Analaysis</h1>";
	echo "The Authorities <br>";
	$a=$rank[0];
	echo "<table border=1>";
	echo "<th>Number</th>";
	echo "<th>Link</th>";
	echo "<th>Score</th>";

	for ($i=0; $i < count($a) ; $i++) {
	       $link="$a[$i].txt" ;
		   echo  "<tr  style='text-align:center'> 
		          <td>".($i+1)."</td> 
		          <td style='width: 100px'> <a  href='websites/$link' >$link</a> </td>  
		          <td style='width: 200px'>$at[$link]</td>
		          </tr> ";
	}
	echo "</table><br><br>";


	echo "<br>The Hubs <br>";
	$a=$rank[1];
	echo "<table border=1>";
	echo "<th>Number</th>";
	echo "<th>Link</th>";
	echo "<th>Score</th>";
	for ($i=0; $i < count($a) ; $i++) {
	       $link="$a[$i].txt" ;
		   # echo  "<br>".($i+1)." - <a href='$link'>$link</a> <br>";
		      echo  "<tr  style='text-align:center'> 
		          <td>".($i+1)."</td> 
		          <td style='width: 100px'> <a  href='websites/$link' >$link</a> </td>
		           <td style='width: 200px'>$hu[$link]</td> 
		          </tr> ";
	}
	echo "</table><br><br>";
//--------------------------------------------------------------------------
 ?>


 </body>
</html>