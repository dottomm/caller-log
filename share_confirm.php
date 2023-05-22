<?php
include 'common/useful_stuff.php';
if(!db_connect())
die();


if ($_uid == 0){
	header("location:login.php");
	die();
	}
	
	
$user_id=$_uid;
$user_fname=getvar("user_fname");
$user_lname=getvar("user_lname");
$user_email = getvar("user_email");
$responsible=getvar("responsible");
$error_id=getvar("error_id");
$caller_id = getvar("caller_id");
$doit=getvar("doit");
$reciever = getvar("receiver");

include 'common/header.php';
//  $result=mysql_query("Select * from error_log where error_id={$error_id}");

//  while($row=mysql_fetch_assoc($result)){



echo"<div class='row-fluid'>
	    <div class='span12'><h3 class='highlight'>Share Complete!</h3> 

<p><a href='index.php'>Go Home >></a></p>

</div>";


?>