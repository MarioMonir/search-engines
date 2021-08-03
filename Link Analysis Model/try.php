<?php



$i=0;

$get=" ";

echo "Enter card name to get<br />";

?>

<form action="cards.php" method="post">

<input type="textbox" name="get" />

<input type="submit" value="Get Card" />

</form>

<?php

$get = $_POST['get'];

if (isset($_POST['get']))

{

    while ($i < 10)

    {

        $card[$i] = new getCard($get,$i);

        $i++;

    }
}

?>
