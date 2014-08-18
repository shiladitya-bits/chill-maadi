<?php
$conn=mysql_connect("localhost","root","root") or die("Could not connect");
mysql_select_db("payments",$conn) or die("could not connect database");
?>