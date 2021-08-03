
<!DOCTYPE html>
<html>
<head>
  <title>Search Engine</title>
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
header
{
  margin-top: 0; 
  text-align: center;
}
.h1
{
  font-size: 30px;
}
.h2
{
  font-size: 40px;
}
/*========================================*/
form
{
  margin-top:  12%;
  margin-left: 0%;
}
/*========================================*/
fieldset
{
  border:0;
}
/*========================================*/
.src
{
  width: 33%;
  height: 50px;
  border-radius: 50px;
}
/*========================================*/
.submit
{
    background: #0066A2;
    margin-left:33%;
    color: white;
    border-style: outset;
    border-radius: 50px;
    border-color: #0066A2;
    height: 50px;
    width: 100px;
    font: bold 15px arial, sans-serif;
    text-shadow:none; 
    font-family: 'Orbitron', sans-serif; "   

}

</style>

<body>

           


<!-- ================================================= --> 

<header >
    <h1  class="h1">Statistical Model Search</h1>
</header>


<fieldset>
  <form action=""   method="POST" >
    
      <center>       
              <h1 class="h2">The Mario</h1>
            <input class="src" type="text" name="query" required="" > 
            
         
            <br><br>
            <input  class="submit" value="Search" type="submit" name="Search"></input>  
       </center>
  
 </form>
</fieldset> 
</body>
</html>
<!-- ================================================= --> 

 <?php 

   if(empty($_POST["query"])){
          //echo "*Required";
          //echo($_POST["query"]);
          $action = "";
        }else{

          echo($_POST["query"]);
          $url = "vmodel2.php";
          
          session_start();
          $_SESSION['query']=$_POST["query"];

           header("Location:$url");
            exit;
          
      
        }




?>
