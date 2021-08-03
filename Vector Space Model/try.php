<?php 
//=============================================================
   //The Calculations of weights of Query 
    $QUERY = array_count_values($QUERY);
    $Query_freqs = array_values($QUERY);
    $q_max = max($Query_freqs);
  
    $q_weight=array();
    $q_word_t = array();
    $q_weights=array();
 
    	foreach ($QUERY as $key => $value) {
    		$w = ($value/$q_max)*(log(($N/$QUERY[$key]),2));
		    
		    array_push($q_word_t, $key);
 	        array_push($q_weight, $w);
    	}
    	   $q_weights=array_combine($q_word_t, $q_weight);

 print_r($q_weights);
//===================================================================== 

 // Cosine Simillarity 
 
 ?>