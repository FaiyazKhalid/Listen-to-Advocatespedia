<?php
require_once('dbconfig.php');

//counter of our real table
$query1 = mysqli_query($con, 'SELECT SUM(page_counter) AS c FROM wiki_hit_counter');
$array1 = mysqli_fetch_array($query1);

//value stored in the secondary table
$query2 = mysqli_query($con, 'SELECT currentvalue AS cv FROM counter WHERE currentvalue IS NOT NULL');
$array2 = mysqli_fetch_array($query2);

//compare the two values
if($array1['c'] > $array2['cv']) {
    echo "true";
    $counter = $array1['c'];
    $update=mysqli_query($con, "UPDATE `counter` SET `currentvalue` = '$counter' WHERE currentvalue IS NOT NULL;");

}
else {
    echo $array1['c'];
    echo "false";
    echo $array2['cv'];
}
?>
