<?php

include 'common/useful_stuff.php';
if (!db_connect())
	die();

	
	
$error_id=getvar("error_id");
$support_id = getvar("support_id");



$result =mysqL_query("select * from error_log 
inner join support_log on error_log.support_id=support_log.support_id where error_id=$error_id");
$row = mysql_fetch_assoc($result);

$query="delete from error_log where error_id={$error_id}";
mysql_query($query);

include 'common/header.php';
echo " <div class='span12'><p><b>{$row['support_type']}</b>  Record: {$row['error_id']}, <br>has been deleted <a href='index.php'>Go Home</a></p></div>
";



?>