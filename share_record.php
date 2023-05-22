<?php

include 'common/useful_stuff.php';
if(!db_connect())
die();


if ($_uid == 0){
	header("location:login.php");
	die();
	}

$user_id=getvar("user_id");;
$user_fname=getvar("user_fname");
$user_lname=getvar("user_lname");
$user_email=getvar("user_email");
$responsible=getvar("responsible");
$user_email = getvar("user_email");
$email=getvar("email");
$errmsg="";
$error_id=getvar("error_id");
$caller_id = getvar("caller_id");
$receiver = getvar("receiver");
$doit=getvar("doit");



if($doit == "yes"){	
header("LOCATION:share_confirm.php?user_email=$receiver");

}

include 'common/header.php';
//get dashboard info//
	$result=mysql_query("Select * from users where user_id=$_uid");

		while($row=mysql_fetch_assoc($result)){
			
			$mailmsg="Hi {$row['user_fname']} {$row['user_lname']}. 
A  call has been shared with you. A user has requested you view the details of this call. Please log in at: http://www.draccess.org/DR_Caller_Log/ 
and view the record  at http://www.draccess.org/DR_Caller_Log/error_profile.php?error_id={$error_id}&&caller_id={$caller_id} with your username and password to view the issues. 
Thank you!	";
	
//display dashboard info//
	echo"

<div class='span4'>

Administrator is {$row['user_fname']} {$row['user_lname']}
<span class='small'><br> Not {$row['user_fname']} {$row['user_lname']}? <a href='logout.php'>Log out</a></span>
	
	<hr>
	</div>";
		}

//define support type//
$result=mysql_query("Select * from error_log 
	inner join support_log on error_log.support_id=support_log.support_id 
		 where error_id={$error_id}");
		$row=mysql_fetch_assoc($result);
		

	echo"

	<div class=span8'>
<h4>Share  call Details for {$row['error_id']} <br>&ldquo;<span class='highlight'>{$row['support_type']}</span>
&rdquo;</h4>
<p><font color='red'><b>{$errmsg}&nbsp;</b></font></p>

<form action='{$_SERVER['PHP_SELF']}' method='post'>

<input type='hidden' name='doit' value='yes'>
<input type='hidden' name='error_id' value='{$error_id}'>
<input type='hidden' name='caller_id' value='{$row['caller_id']}'>

<select name='receiver' class='span4'><option value='0' default>Please Specify Support Person...</option>";
	$result=mysql_query("select user_id, user_fname, user_lname, user_email  from users order by user_id ASC");
	while($row=mysql_fetch_assoc($result)){
	
	if($row['user_id']==$user_id){
	echo"<option value='{$row['user_email']} ' selected>{$row['user_id']}  {$row['user_fname']} {$row['user_lname']} ";
	}
	else{
		echo"
		<option value='{$row['user_email']}' >{$row['user_id']} {$row['user_fname']} {$row['user_lname']}
		
		";
		
	}
}
		mail("$receiver", "DR Call Record Shared with You", $mailmsg,"FROM:admin@draccess.org");

	echo"</select> 
	
</p>

<p>
	<input type='submit' name='submit' value='Share Call Details' class='btn'></p>

</form>

</div>


";






?>