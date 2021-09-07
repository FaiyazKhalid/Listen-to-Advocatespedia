<?php
require_once('dbconfig.php');

//display the counter of the "real" table

$query = mysqli_query($con, 'SELECT SUM(page_counter) AS c FROM mw_hit_counter');
$array = mysqli_fetch_array($query);

echo $array['c'];
?>
