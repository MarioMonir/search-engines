<?php 


 include "functions.php";

//--------------------------------------------------------------------------  
	 
	$arr=websites($folder); 
    $A  = adj_Matrix($arr);               // Adjacency Matrix  A
    $AT = Trans_matrix($A);               // It's Transpose    AT
    //print_matrix($A);
    //print_matrix($AT);



    $authority = array_fill(0,count($arr[0]), 1); //a0 = [1,1,1,....]
    $hub = array_fill(0,count($arr[0]),1); //h0 = [1,1,1,....]
     
     $i=0;
     ${"h_$i"} = $hub;
     ${"a_$i"} = $authority;


    // Iterations  
    $iterations = 14 ;
    
	 for ($i=0; $i < $iterations ; $i++) { 
	        $j=$i+1;
	        ${"a_$j"} = Multiply($A,${"h_$i"});
	        ${"h_$j"} = Multiply($AT,${"a_$j"});
	        ${"a_$j"} = Normalize(${"a_$j"});
	        ${"h_$j"} = Normalize(${"h_$j"});

	        	   $a = ${"a_$j"} ;
				   $h = ${"h_$j"} ;
				   //echo $i+1 . " - ";
				   //print_r($a);
				   //echo "<br><br>";
	  }
    
	   $a = ${"a_$j"} ;
	   $h = ${"h_$j"} ;
	
  $rank = rank_view($a , $h ,$arr);
  //echo"The Authorities";print_r($rank[0]);echo "<br>";
  //echo"The Hubs       ";print_r($rank[1]);echo "<br>";

echo "The Authorities <br>";
$a=$rank[0];
for ($i=0; $i < count($a) ; $i++) {
       $link="$a[$i].txt" ;
	   echo  "<br>".($i+1)." - <a href='$link'>$link</a> <br>";
}
echo "<br>The Hubs <br>";
$a=$rank[1];
for ($i=0; $i < count($a) ; $i++) {
       $link="$a[$i].txt" ;
	   echo  "<br>".($i+1)." - <a href='$link'>$link</a> <br>";
}


//--------------------------------------------------------------------------
 ?>