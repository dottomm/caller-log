<?php
include 'common/useful_stuff.php';
if(!db_connect())
die();



if ($_uid == 0){
	header("location:login.php");
	die();
	}
$caller_id=getvar("caller_id");	
	
	include 'common/header.php';
	echo"
	<div class='span12'>
	<h2>Last Caller Added</h2>";

	
	
	$result=mysql_query("SELECT * FROM caller_log where user_id=$_uid  order by caller_id DESC limit 1");



while ($row = mysql_fetch_assoc($result)){



echo"
<p><a href='caller_profile.php?caller_id={$row['caller_id']}'>{$row['caller_fname']} {$row['caller_lname']}</a>  ({$row['caller_areacode']}) {$row['caller_phone']}    </p>


";



}
echo"
<p><a href='index.php'>Go Home</a></p>
</div>";

?>