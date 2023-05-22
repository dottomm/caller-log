<?php include '../common/useful_stuff.php';

if(!db_connect())
die();

$user_id = getvar("user_id");
$support_type= getvar("support_type");
//get username
$result=mysql_query("select user_fname, user_lname from users where user_id = {$user_id}");
$row=mysql_fetch_assoc($result);
echo"<h2 style=font-family:sans-serif;>{$row['user_fname']} {$row['user_lname']}'s Calls</h2>
<hr />";


$result=mysql_query("select * from error_log 
									inner join users on error_log.responsible=users.user_id
									inner join caller_log on error_log.caller_id = caller_log.caller_id
									inner join support_log on error_log.support_id=support_log.support_id
								where responsible={$user_id}");
	while($row=mysql_fetch_assoc($result)){
		echo"
		
		<li style='font-family:sans-serif; color:#ccc; padding-top:6px;'><a href='../error_profile.php?error_id={$row['error_id']}' target='_new'>{$row['error_id']} {$row['support_type']}</li>
		";
	}