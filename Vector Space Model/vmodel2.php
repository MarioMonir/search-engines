<?php 
// Get The Session and process the query
session_start();
$query=$_SESSION['query'];
$query=trim($query);
$Query = array();
$Query = preg_split("/ /", $query);
$QUERY=$Query;
//***********************************************************
   function doc_optimizer($Query,$doc)
  { 
    $words=array();
  	$freqs=array();
  	//$doc=array_unique($doc);
    $doc_keys=array_keys($doc);
  	
  	   for ($i=0; $i < count($Query) ; $i++) 
  	   { 
  		  if( in_array("$Query[$i]",$doc_keys) )
  		  {   
  		  	  array_push($words, $Query[$i]);
  		  	  array_push($freqs, $doc[$Query[$i]]);
  		  } 
  	   }
  	   $document = array_combine($words, $freqs);
       return $document;   
   }
//***********************************************************

//=====================================================================
 //Processing Folder of Documents 
/*----------------------------------*/

 //assign the name of the directory in a varaible
  $docs_folder = "documents";
 
 //Get an array of documetns names 
    $files_names = scandir("$docs_folder");
  
 // Delete the hidden files from the array 
    array_shift($files_names); //arr[0] = .
    array_shift($files_names); //arr[1] = ..
  
//=====================================================================    
  //Processing Documetns  
/*------------------------*/ 
 // Array holding documetns arrays of keys and values
    $Docuemnts =array();
    $max_freq = array();

 //change directory (to the folder of documents)
    chdir("$docs_folder");
    
     $words =""; 
//=====================================================================
for ($i=0; $i <count($files_names)  ; $i++) { 

   $doc = fopen("$files_names[$i]", "r")or die("opening $files_names[$i] failed");  
 // Get all document as  one string
     $txt=fread($doc,filesize("$files_names[$i]"));
    
 // remove the spaces , get keys in array w values in onther
   $Doc =array();
   $Doc = explode(" ", $txt);
   $Doc = array_count_values($Doc);
   $doc_keys=array_keys($Doc);
   $doc_values=array_values($Doc);
   //print_r($Doc);
   //echo "<br>";
   //print_r($doc_values);
   $max_freqs[$i]=max($doc_values);
 
 //call the function doc optmizer 
    // take paramters $Doc w $Query and return array words and freqs
    $Doc_temp=$Doc;
    $Doc = doc_optimizer($Query,$Doc);        
    $Documents[$i]= $Doc; 
//=============================================================
	 
 //make an string from array  $files_name[$i] keys (words)  
   $words_temp = implode(" ",array_keys($Doc_temp)) ;
   $words.=$words_temp; //concatenate words of diffrent docs
   $words.=" ";         //seperate by space 
}
//=============================================================
  // Number of Documents
	$N = count($files_names)+1;
  
  // Numbers of words i in document j	
	$words=trim($words); 

  // Make an Array From STring	
    $words = explode(" ", $words);
    $words = array_count_values($words);
    $words_values=array_values($words);

// increment df by 1 for words got in query
for ($i=0; $i < count($Query) ; $i++) { 
	  $words["$Query[$i]"]++;
}

//foreach ($words as $key => $value) {
//	$words[$key]++;
//}
//echo "<br>words<br>";
//print_r($words);
//echo "<br><br><br>";
//=============================================================   
  //The Calculations of weights of Documents 
    $QUERY = array_count_values($QUERY);
    $Query_freqs = array_values($QUERY);
    $q_max = max($Query_freqs);
  
    $weight=array();
    $word_t = array();
    $weights=array();
    $weighted_docs=array();

 for ($i=0; $i < count($Documents) ; $i++) {
 		$d = $Documents[$i];
 		$dk = array_keys($d);
	foreach ($QUERY as $key => $value) {
		if(in_array("$key", $dk)){
		    $w = ($d[$key] / $max_freqs[$i])*(log($N/($words[$key]),2));
		   // echo "word = $key => weight = $w <br> ";
	        array_push($word_t, $key);
	        array_push($weight, $w);
        }else{
	        array_push($word_t, $key);
	        array_push($weight, 0); 
        }
	   }
	      $weights=array_combine($word_t, $weight);
		  array_push($weighted_docs, $weights);  
		  $weighted_docs[$i]=$weights;
		  //echo("Doc ".($i+1)."  weights  : ");
	      //print_r($weights);
	      //echo("<br><Br>");	 
}
 //echo("<br>weighted docs<br>");
 //print_r($weighted_docs);
 //echo("<br><br>");

//=====================================================================
   //The Calculations of weights of Query   
    $q_weight=array();
    $q_word_t = array();
    $q_weights=array();
 
    	foreach ($QUERY as $key => $value) {
    		 //echo(" $key =  $value/ $q_max  * log($N/$words[$key])  ");
    		$w = ($value/$q_max)*(log(($N/$words[$key]),2));
    		// echo(" = $w <br>");
		    array_push($q_word_t, $key);
 	        array_push($q_weight, $w);
    	}
    	   $q_weights=array_combine($q_word_t, $q_weight);
 
//print_r($q_weights);
// echo("<br><br>");

//=====================================================================
//simllarity (inner product)
  $Sim = array();
 for ($i=0; $i < count($weighted_docs) ; $i++) {
 	    $x = $weighted_docs[$i];
 		$c=0; 
	 foreach ($x as $key => $value) {
	 	// echo(" $key =  $q_weights[$key] * $x[$key]");
	   	 $c+=($q_weights[$key]*$x[$key]);
        // echo(" = $c <br>");
     }
    // echo "<br><br>";
     array_push($Sim, $c);
  }  
   // print_r($Sim);

//=====================================================================
// norm of query
      $q=0;
     for ($i=0; $i < count($q_weight) ; $i++) {
     	  //echo(" qw  =  ($q_weights[$i])^2 "); 
     	  $q+=($q_weight[$i]*$q_weight[$i]);
     	  //echo("  =  $q_weight[$i]*$q_weight[$i] <br>");
     }
      $query_norm = sqrt($q);
      //echo($query_norm);
      //echo "<br><br>";
//=====================================================================  
      $docs_norms=array();
      for ($i=0; $i < count($weighted_docs) ; $i++) { 
      	$x = $weighted_docs[$i];
      	$xv = array_values($x);
 		$ds=0; 
	    for ($j=0; $j < count($x) ; $j++) { 
	    	 $ds+= $xv[$j] * $xv[$j] ; 
	    }
     //echo "<br><br>";
    array_push($docs_norms, sqrt($ds) );
    }  
 	 //print_r($docs_norms);
	//echo "<br><br>";
//===================================================================== 
 $score=array();
for ($i=0; $i < count($weighted_docs) ; $i++) { 
	    $norm=$docs_norms[$i]*$query_norm;
 	   if($norm > 0){
         $score[$i]=$Sim[$i]/$norm;
 	   }
 	   else{
 	   	$score[$i]=-1;
 	   }
 } 
//print_r($score); 
//echo("<br><br><br>");

//=======================================================================
   
   //sorting and ranking
    $retreival = array();
    $DocV=array_keys($Doc);
    $DOCUMENTS=array_combine($score,$files_names);
     //print_r($DOCUMENTS);
     //echo("<br><br><br>");
  	 
  	 sort($score);
     //print_r($score);
     //echo("<br><br><br>");

     $ranked = array_reverse($score);
     //print_r($ranked);
     //echo("<br><br><br>"); 

     for ($i=0; $i < count($ranked) ; $i++) { 
     	    $retreival[$i]=$DOCUMENTS["$ranked[$i]"];
     }
    // print_r($retreival);
    
 ?>   

 <!DOCTYPE html>
 <html>
 <head>
   <title>Results</title> 
 </head>
 <style type="text/css">

@import url('https://fonts.googleapis.com/css?family=Orbitron');
 
/*========================================*/
body
{
  color: white;  
  background-image: url(bk7.jpg);
  background-repeat: no-repeat;
  background-size: 2080px 1080px; 

  font-family: 'Orbitron', sans-serif;

}
/*========================================*/
fieldset
{
  border:0;
}
/*========================================*/
form
{
  margin-top: 3%;
}
.src
{
  width: 20%;
  height: 20px;
  border-radius: 50px;
}

</style>

 <body>

 <fieldset> 
    <form  action="<?php $_PHP_SELF ?>"  method="get" >
              <span>The Mario</span><br><br>
       <!-- <input class="src" type="text" name="query" >
        <input  class="submit" value="Search" type="submit" name="Search"></input>   -->
    </form>
</fieldset>

<div style="padding: 2%;">
     <?php 
            //$retreival=array_unique($retreival); 
         for ($i=0; $i < count($retreival) ; $i++) {
               $x=$i+1; 
         	//echo "<br> ".$i+1."  -  <a style='color: white' href=''>"."$retreival[$i]"."</a> <br>";
         	 echo "<br> $x  -  <a style='color: white' href=''>".$retreival[$i]."</a> <br>";

            //echo("$retreival[$i] <BR><BR>");

         }
       ?>
</div>

 </body>
 </html>