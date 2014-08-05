<?php 

mysql_connect("localhost","root","root");
mysql_select_db("payments");
$sql = "SELECT * from payment_log";
$result=mysql_query($sql);

 $resultArray = array();

while($row = mysql_fetch_object($result))
{
// Add each row into our results array
$resultArray[] = $row;
}
echo json_encode($resultArray);

?>
