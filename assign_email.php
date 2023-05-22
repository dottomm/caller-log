<?php

include 'common/useful_stuff.php';
if(!db_connect())
die();


if ($_uid == 0){
	header("location:login.php");
	die();
	}



$error_id=getvar("error_id");
$doit=getvar("doit");

$user_id=$_uid;
$user_fname=getvar("user_fname");
$user_lname=getvar("user_lname");
$user_email=getvar("user_email");




$res=mysql_query("select * from users  inner join
	error_log on users.user_id=error_log.responsible where error_id={$error_id}");


while($row=mysql_fetch_assoc($res)){

$mailmsg="Hi {$row['user_fname']} {$row['user_lname']}. 
A  call {$error_id} has been assigned to you. Please log-in and take care of this issue as soon as possible'
Please log in at http://www.draccess.org/DR_Caller_Log/ to view the issues. 
http://www.draccess.org/DR_Caller_Log/error_profile.php?error_id={$error_id}
Thank you!
";

		mail("{$row['user_email']}", "Call Assigned to You", $mailmsg,"FROM:admin@draccess.org");


}
header("LOCATION:assign_confirm.php");
