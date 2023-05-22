<?php 
include '../common/useful_stuff.php';

if(!db_connect())
die();

$caller_fname = getvar("caller_fname");


if ($_uid == 0){
	header("location:login.php");
	die();
	}
	
	  
if ($_uid == 0){
	header("location:login.php");
	die();
	}

	$thispage = "user reports list";
$user_id=getvar("user_id");	

//get responsible name 
$result=mysql_query("select * from error_log 
								inner join users on error_log.responsible = users.user_id
								where responsible=$user_id");
$row=mysql_fetch_assoc($result);


	
echo"	<div class='span12'>
<h3 align='center'>{$row['user_fname']} {$row['user_lname']} User Call List</h3>

<table border='0' cellpadding='6' align='center'>
<tr><th span='2'>error</th><th scope='col'> calls assigned</th></tr>

<a name='user_report'>";


//user reports
$result=mysql_query("select * from error_log 
									inner join caller_log on error_log.caller_id = caller_log.caller_id
								where responsible={$user_id}");
	while($row=mysql_fetch_assoc($result)){
		
		echo"
		
		<tr>
		<td><a href='../error_profile.php?error_id={$row['error_id']}'>{$row['error_id']}</td>
		<td>{$row['support_id']}</td></tr>";
	}




	