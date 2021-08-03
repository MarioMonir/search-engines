<?php 

/*
   Functions in this file


1-function websites($folder) ----------------> return Array $arr = ($pages , $websites_links)
2-function adj_Matrix($arr) -----------------> return Adjacency Matrix
4-function Trans_matrix($adj_matrix) --------> return Transpose to The Matrix 
3-function print_matrix($adj_matrix) --------> Print  The Matrix
5-function Normalize($vector) ---------------> return The Normal The authorties and hubs after every iteration            
6-function Multiply($adj_matrix,$vector) ----> return Multiplication The Matrix by VEcor
7-function rank_view($auth,$hub,$arr) -------> return Rank The authorities and hubs

*/

 //assign the name of the directory in a varaible
   $folder = "websites";

//************************************************************************************
//************************************************************************************ 

function websites($folder)
   {
	//Get an array of documetns names 
	  $websites_links = scandir($folder);

  
	// Delete the hidden files from the array   
	  array_shift($websites_links); //arr[0] = .
	  array_shift($websites_links); //arr[1] = ..
      
    // print_r($websites_links);

    //change directory (to the folder of websites)
	  chdir($folder);
   
    //declare 2d adjacency matrix
	$arr1 = array_fill(0,count($websites_links),0);  
    $adj_Matrix =  array_fill(0, count($websites_links),$arr1);
  
    $pages = implode("", $websites_links);
    $pages= str_replace(".txt"," ","$pages");
    $pages=trim($pages);
    $pages=explode(" ", $pages);
    $arr = array($pages , $websites_links);
    //echo getcwd() ."<br>";
    //chdir("../");
    //echo getcwd();
    return $arr;
   }   
//************************************************************************************
//************************************************************************************ 
function adj_Matrix($arr)
{  
     $pages =$arr[0];
     $websites_links = $arr[1];

     //declare 2d adjacency matrix
	 $arr1 = array_fill(0,count($websites_links),0);  
     $adj_Matrix =  array_fill(0, count($websites_links),$arr1);

//==============================================================
	for ($i=0; $i < count($websites_links) ; $i++) { 

        // open file (webpage) 
		$page = fopen("$websites_links[$i]", 'r');
        
        //Read file as a text
		$txt = fread($page, filesize($websites_links[$i]));
		$txt = trim($txt);
        
        //Convert files as a Text to Array 
		$txt = explode(" ", $txt);
		$txt = array_unique($txt);
		//--------------------------------------------------
		 // Naive algorithm to fill the Adjacency Matrix
	        for ($j=0; $j <count($txt) ; $j++) { 
	        	   $index=array_search("$txt[$j]",$pages);
	        	if($txt[$j]==$pages[$i]){
	        		$index =array_search("$txt[$j]", $pages);
	        		$adj_Matrix[$i][$index]=0;
	  		      }else{
	  		      	$index =array_search("$txt[$j]", $pages);
	        		$adj_Matrix[$i][$index]=1;
	  		      }
	       		}
		//---------------------------------------------------
	  }
//==============================================================	            
  return $adj_Matrix;             
}

//************************************************************************************
//************************************************************************************ 
// Function That Transpose adjacency Matrix
function Trans_matrix($adj_matrix)
{    
   
	$trans_matrix;
    for ($i=0; $i < count($adj_matrix) ; $i++) {
    	for ($j=0; $j < count($adj_matrix) ; $j++) { 
    		   $trans_matrix[$i][$j]=$adj_matrix[$j][$i];
    	}
    }
    return $trans_matrix;
}

//************************************************************************************ 
//************************************************************************************
  //Function That Print The Adjacency Matrix -> paramter the Adjacency Matrix
	function print_matrix($adj_matrix)
	{

		      echo "&nbsp&nbsp&nbsp&nbsp ";
		      for ($i=0; $i < count($adj_matrix) ; $i++) { 
		      	    echo "&nbsp&nbsp&nbsp";
		      }echo "<br>";
			    for ($i=0; $i < count($adj_matrix) ; $i++) { 
	    	    echo "    [ &nbsp  ";
	         	for ($j=0; $j < count($adj_matrix) ; $j++) { 
	    	     	echo $adj_matrix[$i][$j] ."&nbsp | ";
	    	        }
	    	      echo " ] <br> ";
	              }
	         return;
	}

//************************************************************************************ 
//************************************************************************************   

  // Function That Normalize Vector 
       function Normalize($vector)
       { 
       	 $sum=0;

       	 for ($i=0; $i < count($vector) ; $i++) { 
       	 	   $sum+=($vector[$i]*$vector[$i]);
       	 }
       	 for ($i=0; $i < count($vector) ; $i++) { 
       	 	  $vector[$i]= round(( $vector[$i] / sqrt($sum)) , 17) ;
       	 }
       	 return $vector;
       }
 

//************************************************************************************ 
//************************************************************************************
     //Function That Multiply Matrix by Vector
     function Multiply($adj_matrix,$vector)
     {  

     	if (count($adj_matrix)==count($vector)) {
     		for ($i=0; $i < count($vector) ; $i++) { 
     			   $result[$i]=0;
     		    for ($j=0; $j < count($vector) ; $j++) { 
     		    		$result[$i]+=($adj_matrix[$i][$j]*$vector[$j]);
     		    }
     	     }
     	}else{
     		echo "Dimensions are not Equal";
     	}
     	return $result;
     }
//************************************************************************************ 
//************************************************************************************

  function rank_view($auth,$hub,$arr)
  {   

     $pages =$arr[0];
     $a=array_combine($auth,$pages);
     $h=array_combine($hub,$pages);
   
     for ($i=0; $i < count($pages) ; $i++) { 

           $max = max($auth);
           $idx = array_search($max, $auth);
           unset($auth[$idx]);
           $ranked_a[$i] = $pages[$idx];  

           $max2 = max($hub);
           $idx2 = array_search($max2,$hub);
           unset($hub[$idx2]);
           $ranked_h[$i] = $pages[$idx2];      	 
     }
     $rank = array($ranked_a,$ranked_h);
     return $rank;
    // print_r($ranked_a);
    // echo "<br>";
    // print_r($ranked_h);
  }
 
 ?>