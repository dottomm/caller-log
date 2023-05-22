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
$responsible=getvar("responsible");
$error_id=getvar("error_id");
$doit=getvar("doit");

include 'common/header.php';
//  $result=mysql_query("Select * from error_log where error_id={$error_id}");

//  while($row=mysql_fetch_assoc($result)){



echo"<div class='span12'>
<p>&nbsp;</p>
<p>&nbsp;</p>
<pre><h3 class='highlight'>Assignment Complete!</h3> 
<p>&nbsp;</p>
<p><a href='index.php'>Go Home >></a></p>
</pre>

</div>";


?>