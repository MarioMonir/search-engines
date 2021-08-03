<?php 

session_start();
$query=$_SESSION['query'];
$query=trim($query)


//============================================================================
 //Processing Folder of Documents 
/*----------------------------------*/

 //assign the name of the directory in a varaible
  $docs_folder = "documents";
 
 //Get an array of documetns names 
    $files_names = scandir("$docs_folder");
  
 // Delete the hidden files from the array 
    array_shift($files_names); //arr[0] .
    array_shift($files_names); //arr[1] ..

  
//============================================================================     
  //Processing Documetns  
/*------------------------*/ 

 // Array holding documetns arrays of keys and values
    $documents =array();

 //change directory (to the folder of documents)
    chdir("$docs_folder");
    
     $words =""; 
 
 for ($i=0; $i <count($files_names)  ; $i++) { 

 $doc = fopen("$files_names[$i]", "r")or die("opening $files_names[$i] failed");  
 // Get all document as  one string
     $txt=fread($doc,filesize("$files_names[$i]"));
    

 // remove the spaces from the documents
   $word_doc =array();
   $word_doc = preg_split("/ /", $txt);
  
 // return values only of array in a new array 
   ${"$files_names[$i]"} = array();
   ${"$files_names[$i]"} =array_count_values($word_doc);


//********************************************************* 
	   
	 //---------------------
		 //make Documetns array contains arrays of the documents (words => freq )
		   $doc = array();
		   $doc= ${"$files_names[$i]"}; // just for make it easy to use
		 
		 //make an string from array  $files_name[$i] keys (words)  
		   $words_temp = implode(" ",array_keys(${"$files_names[$i]"})) ;
		   $words.=$words_temp; //concatenate words of diffrent docs
		   $words.=" ";         //seperate by space 
		   
		   $docuemnts = array();
		   $documents[$i] = $doc;
	 //-----------------------
}

//============================================================================  
  //	$N = count($files_names);
 $N=3000;
 
    $words=trim($words); 
    $words = explode(" ", $words);
    $words = array_count_values($words);

    $temp=array();
    $temp=array_fill(0,count($words), 0);
   
    $words_values=array_keys($words);
    $max_freq_inDocs=array_combine($words_values, $temp);
    

//============================================================================   
     
     //Naive Algortihm to get array if max freqs

	//********************************************************************	  
	   $doc_keys=array();       
	   $doc_values=array();   

	   $word_max=array_keys($words);      //words
	   $freq_max=array_values($words);    //freqs
		   
		for ($k=0; $k < count($documents) ; $k++) 
		{ 
			  $doc_keys=array_keys($documents[$k]);
			  $doc_values=array_values($documents[$k]);
			  for ($u=0; $u < count($doc_keys) ; $u++) 
			  { 
			  	  if (in_array("$word_max[$u]", $doc_keys)) 
			  	  {
			  	  	  $index =array_search($word_max[$u], $doc_keys);
			  	  	  if ($freq_max[$u]<$doc_values[$index]) 
			  	  	  { $freq_max[$index]=$doc_values[$index]; }
			  	  }
			  }
		}

	   $max_freq_inDocs = array_combine($word_max, $freq_max);

    //********************************************************************
    
    //for loop by $i
    //$doc_keys=array_keys($documetns[$i])           //words
	//$doc_values=array_values($documetns[$i]);      //freqs
    //$words['$doc_keys[$i]'] = no of documents contain term 'word'
	//$N = count($files_names);                      // total number of docs 



    $weight=array();
    $word_t = array();
    $weights=array();
    $weighted_docs=array();

for ($i=0; $i < count($documents); $i++) { 
	foreach ($documents[$i] as $key => $value) {
 	   $w = ($value/$max_freq_inDocs[$key]) * (log (($N/$words[$key]), 2));
 	   array_push($word_t, $key);
 	   array_push($weight, $w);
 }
   $weights=array_combine($word_t, $weight);
   array_push($weighted_docs, $weights);

}
/*
for ($i=0; $i < count($documents); $i++) { 
	foreach ($documents[$i] as $key => $value) {
 	   $w = ($value/$max_freq_inDocs['$key']) * (log (($N/$words['$key']), 2));
 	   array_push($word_t, $key);
 	   array_push($weight, $w);
 }
   $weights=array_combine($word_t, $weight);
   array_push($weighted_docs, $weights);

}
*/

for ($b=0; $b < count($weighted_docs) ; $b++) { 
	foreach ($weighted_docs[$b] as $key => $value) {
		    echo("key = $key , value = $value <br>");
	}
	echo("<br><br><BR>");
}
 
   
?>