<!-- ================================================= -->            
  <?php 
/*     
        if(empty($_GET["query"])){
         // $err="*Required";
        }else{
          echo "accepted;";
          $query=$_GET["query"];
        }
*/     session_start();
       $query=$_SESSION['query'];

//============================================================================    
    //echo "<br> Name = echo $query <br><br>";
  

//============================================================================
 //Processing Folder of Documents 
/*----------------------------------*/

 //assign the name of the directory in a varaible
  $docs_folder = "documents";
 
 //Get an array of documetns name 
    $files = scandir("$docs_folder");

 // Delete the hidden files from the array 
    array_shift($files);
    array_shift($files);
 
 /*
    foreach ($files as $key => $value) {
     echo "key = $key  ,  value = $value <br>";
   }
  */

//============================================================================     

  //Processing Documetns  
/*------------------------*/ 

 // Array holding documetns arrays of keys and values
    $documents =array();
   
   //change directory (to the folder of documents)
    chdir("$docs_folder");
   

   // print cuurent working directory  
     /* echo  "<br>". getcwd() . "<br><br>";*/

 for ($i=0; $i <count($files)  ; $i++) { 

    $doc = fopen("$files[$i]", "r")or die("opening $files[$i] failed");   
    $txt = "" ;    
         
    //concatenate doc to a string    
     //=======================
     // while(!feof($doc)) {
     //    $txt.=fgetc($doc); 
     //   }
     //=======================  

  // fread is better than fgetc because it handle the new line
     $txt=fread($doc,filesize("$files[$i]"));
     //=======================   
    
    // remove the spaces from the documents
      $word_doc =array();
      $word_doc = preg_split("/ /", $txt);
    
    //
      $words = implode("", $word_doc);
       // echo  "word = $words <br>"; 
      $word_cont = strlen($words); 
      //echo "count = $word_cont <br>";        


    // return count of repeated element in a new array 
      ${"doc$i"} = array();
      ${"doc$i"} =array_count_values($word_doc);
      
    //remove repeated element in the array 
      $word_doc=array_unique($word_doc);
      $Wvalues = array_values($word_doc); 
      $word_doc=$Wvalues;
    
    // return values only of array in a new array 
      $freq_doc = array();
      $freq_doc=array_values(${"doc$i"});

      for ($l=0; $l < count($freq_doc) ; $l++) { 
            $freq_doc[$l]/=$word_cont;
        }  
    
    //combine two arrays one to be keys anothe to be values
      ${"doc$i"}=array_combine($word_doc, $freq_doc);
      $DOC = array(""=>"");
      $DOC = ${"doc$i"};
   
        /*
         foreach ($DOC as $key => $value) {
             echo "$key => $value <br>" ;
           }
        */
         
    //put the document in array of documents then close it  
          $documents[$i]=$DOC;
          fclose($doc);    
        
         /*
            echo("doc Words : <br>");
            print_r($word_doc);
            echo "<br><br><br>" ;

            echo("doc freq : <br>");
            print_r($freq_doc);
            echo "<br><br><br>" ;
        */
 }
  
//============================================================================
    // Processing Query
   /*-------------------------*/

    //build in function alternative to the naive algorithm 
     
    $Query=array();
    $query = str_replace(";"," ", $query);   //replace ; with space
    $query = str_replace(":"," ", $query);   //reolace : with space
    $query =trim($query);
    
    //echo($query);

   //make an array from string  (new element after every space)
    $Query = preg_split("/ /",$query); 
    
   //make an string from array 
    $query = implode("", $Query);

    //print_r($Query);

    $Qword=array();
    $Qfreq=array();
         
         $j=1; $k=0;
    for ($i=0; $i <count($Query)/2 ; $i++) { 
         $Qword[$i]=$Query[$k];
         $Qfreq[$i]=$Query[$j];
         $j+=2;
         $k+=2;
    }
      
      /*
        echo("Q Words : <br>"); 
        print_r($Qword);
        echo "<br><br><br>" ;

        echo("Q freq : <br>");
        print_r($Qfreq);
      */

//============================================================================
  // Modeling The Statistical model 
    //Naive Algorithm that process the Statitical Model
        $process=array();
        $counter = 0;
     for ($i=0; $i < count($documents) ; $i++) { 
          $process[$i]=0;
          $keys = array_keys($documents[$i]);       //words of document
          $values = array_values($documents[$i]);   // freq of document
        /*  echo "<br>";
           var_dump($values);
        */
          for ($j=0 ; $j < count($Qword) ; $j++) { 
               if( in_array( "$Qword[$j]" , $keys) ){
                    //echo "found";
                     $index =array_search($Qword[$j],$keys);
                     //echo "<br> it's  index  = $index";
                     $process[$i] += ($Qfreq[$j]*$values[$index]);
                     $counter++;
                  }
              }
          }
  /*
    print_r($process);  
  */     
//============================================================================
   // Ranking the Documetns according to the score

if($counter>0){
    $rank = $process;

    sort($rank);

    $rank = array_reverse($rank);
         /*
          echo "<br> <br> Ranks : ";
           var_dump($rank);
        */

    $doc_index_arr=array();
    for ($m=0; $m < count($process) ; $m++) {
        $doc_index_arr[$m] = array_search($rank[$m], $process);  
    }

    //var_dump($doc_index_arr);
    //var_dump($files);
    //echo("<br><br>");   

    $ranked = array();

    for ($n=0; $n < count($files) ; $n++) { 
         $v=$n+1;
        //echo " $v - ".$files[$doc_index_arr[$n]] . "<br>";
        $ranked[$n]=$files[$doc_index_arr[$n]];
    }
     
     $links = array();
     
     for ($e=0; $e < count($ranked) ; $e++) { 
              $links[$e]="$ranked[$e]";
     }


    //var_dump($links);

     //var_dump($ranked);
}

//============================================================================

  
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
     if ($counter>0) {
       # code...
   
       for ($o=0; $o < count($links) ; $o++) { 
            $x=$o+1;
           echo "<br> $x  -  <a style='color: white' href=''>".$links[$o]."</a> <br>";
           echo "<br><br>";
          }
        }
        else{
           echo("no Such a documetns contain your Query : $query ");
        }
       ?>
</div>

 </body>
 </html>