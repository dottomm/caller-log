<?php
include 'common/useful_stuff.php';
if(!db_connect())
die();


$support_id=getvar("support_id");


if ($_uid == 0){
	header("location:login.php");
	die();
	}
	
	include 'common/header.php';
	
	echo"
	<div class='span12'>
	<p align='right' style='font-size:small;'><a href='reports.php'>Back to Reports</a>
	<h3 >Topic Summary</h3>
	<table border='0' cellpadding='6' align='center'>

	<tr><th>ID</th><th >Supprt_topic</th><th>Caller Name</th></tr>
";
	
	
	$result=mysql_query("select *  from error_log e 
		inner join caller_log c on e.caller_id=c.caller_id
		inner join support_log s on e.support_id=s.support_id
	where e.support_id={$support_id}");
	
			while ($row = mysql_fetch_assoc($result)){
	
	echo"
	<tr><td><a href='error_profile.php?error_id={$row['error_id']}'>{$row['error_id']}</td><td>{$row['support_type']}</td><td><a href='caller_profile.php?caller_id={$row['caller_id']}'>{$row['caller_fname']} {$row['caller_lname']}</a></td></tr>
	</div>
	
	";
}
	
	?>
	