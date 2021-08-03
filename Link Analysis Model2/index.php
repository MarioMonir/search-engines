

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
	<style>
		body
		{
			background-image: url(images/bk2.jpg);
		}
	</style>
<body>
<center>
	


			<?php 

			header('Location:model.php');
			exit;
            /*  

             
          
	<form method="post" action="">
		<!--<fieldset> -->
			<legend>The Link Analysis</legend>

	<?php  
			$folder = "websites";
 			 $websites_links = scandir($folder);
 			 array_shift($websites_links); //arr[0] = .
	  		 array_shift($websites_links); //arr[1] = ..
	  		 chdir($folder);
             for ($i=0; $i < count($websites_links) ; $i++) { 
				$page = fopen("$websites_links[$i]", 'r+') or die("Unable to Open File!");
				$txt = fread($page,filesize($websites_links[$i]) );
				$txt = trim($txt);
				$texts[$i]=$txt;
                fclose($page);     
             } 

	?>
	
			<form method='post' action="">
				 <br>
			     <input type='text' name='n0' value='<?php echo $texts[0] ?>' required><br><br>
			     <input type='text' name='n1' value='<?php echo $texts[1] ?>' required><br><br>
			     <input type='text' name='n2' value='<?php echo $texts[2] ?>' required><br><br>
			     <input type='text' name='n3' value='<?php echo $texts[3] ?>' required><br><br>
			     <input type='text' name='n4' value='<?php echo $texts[4] ?>' required><br><br>
  				 <input type='submit' name='s' value='save'>
			</form>

			<?php 
				$n0=$_POST['n0'];
				$n1=$_POST['n1'];
				$n2=$_POST['n2'];
				$n3=$_POST['n3']; 
				$n4=$_POST['n4'];
                 


				 for ($i=0; $i < count($websites_links) ; $i++) { 
				 $page = fopen("$websites_links[$i]", 'w') or die("Unable to Open File!");
				 $t = ${"n$i"};
				 //echo "${"n$i"}";
				 fwrite($page, $t);
				 //fclose($page);
				}
				//header("Refresh");







			 ?>
		

*/
			 ?>
	
		<!--</fieldset>-->
	
</center>
</body>
</html>
