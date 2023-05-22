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
$user_email=getvar("user_email");
$responsible=getvar("responsible");
$errmsg="";
$email=getvar("email");
$error_id=getvar("error_id");
$doit=getvar("doit");


$mailmsg="Hi {$row['user_fname']} {$row['user_lname']}. 
A  call {$error_id} has been assigned to you. Please log-in and take care of this issue as soon as possible'
Please log in at http://www.draccess.org/DR_Caller_Log/ to view the issues. 
http://www.draccess.org/DR_Caller_Log/error_profile.php?error_id={$error_id}
Thank you!
";

$res=mysql_query("select * from users  inner join
	error_log on users.user_id=error_log.responsible where error_id={$error_id}");


while($row=mysql_fetch_assoc($res)){

	
if($doit == "yes"){

	if($responsible=="0"){
		$errmsg="Tom is not permitted to handle support calls.<br> Please select another user";
	}else{
		
	

	
mysql_query ("update error_log
		set responsible='$responsible' where error_id={$error_id}")
		or die(error);
	

		//mail("{$row['user_email']}", "Call Assigned to You", $mailmsg,"FROM:admin@draccess.org");
}
	
header("LOCATION:assign_email.php?error_id={$error_id}");
		
//header("LOCATION:assign_confirm.php?user_email={$row['user_email']}");
		}

	}


	include 'common/header.php';

	$result=mysql_query("Select user_id, user_fname, user_lname, username, user_email from users where user_id=$_uid");
	while($row=mysql_fetch_assoc($result)){

echo" 	
<div class='row-fluid'>
<div class='span4'>

Administrator is {$row['user_fname']} {$row['user_lname']}
<span class='small'><br> Not {$row['user_fname']} {$row['user_lname']}? <a href='logout.php'>Log out</a></span>
	
	<hr>
";
}

$res2=mysql_query("Select * from error_log 
	inner join support_log on error_log.support_id=support_log.support_id 
	 where error_id={$error_id}");

while($r=mysql_fetch_assoc($res2)){
echo"</div>
<div class='span8'>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class='hero-unit'>
<h3>Assign Responsibility for call {$r['error_id']} <br />&ldquo;<span class='highlight'>{$r['support_type']}</span>&rdquo;</h3>

<p><font color='red'><b>{$errmsg}&nbsp;</b></font></p>
</div>
<form action='{$_SERVER['PHP_SELF']}' method='post'>

<input type='hidden' name='doit' value='yes'>
<input type='hidden' name='error_id' value='{$error_id}'>
<input type='hidden' name='email' value='{$user_email}'>


<select name='responsible'>
<option value='0' default>Please Specify Support Person...</option>";
	$result=mysql_query("select user_id, user_fname, user_lname,user_email from users order by user_id ASC");
	while($row=mysql_fetch_assoc($result)){
	
	if($row['user_id']==$user_id){
	echo"<option value='{$row['user_id']} ' selected>{$row['user_id']}  {$row['user_fname']} {$row['user_lname']} ";
	}
	else{
		echo"
		<option value='{$row['user_id']}' >{$row['user_id']} {$row['user_fname']} {$row['user_lname']}
		
		";
		
	}
}
	echo"</select> 
</p>

<p>
	<input type='submit' name='submit' value='Assign Responsiblity' class='btn'></p>

</form>

</div>


";
}





?>