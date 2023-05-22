<?php
include 'common/useful_stuff.php';
if(!db_connect())
die();

if ($_uid == 0){
	header("location:login.php");
	die();
	}
	
	$user_id=$_uid;
	$caller_id=getvar("caller_id");
	$caller_fname=getvar("caller_fname");
	$caller_lname=getvar("caller_lname");
	$caler_areacode=getvar("caller_areacode");
	$caller_email=getvar("caller_email");
	$calltype=getvar("calltype");
	$contact = getvar("contact");
	$formtype=getvar("formtype");
	$method="";
	$type="";
	$ds_code=getvar("ds_code");
	$ds_name=getvar("ds_name");
	$selpa_name=getvar("selpa_name");
	$error_id=getvar("error_id");
	$notes=getvar("notes");
	$comment=getvar("comment");
	$urgent=getvar("urgent");
	$status=getvar("status");
	$stat=getvar("stat");
	$error=getvar("error");
	$errmsg="";
	$mailmsg="Hi . <br/>
A  call has been marked as urgent and needs your attention 
Please log in at http://www.draccess.org/sedrs_log/ to view the issues. 
Thank you!
";

$result=mysql_query("select * from error_log where caller_id={$caller_id}");
	
	$doit=getvar("doit");
	
	if($doit == "yes"){
		if($status=="0"){
	$errmsg="Please select the status";
	}else{
	mysql_query ("update error_log set  lastupdated=NOW(), updateduser='$user_id'
	where error_id='{$error_id}'");
	if($comment!=""){
					mysql_query("insert into comments (error_id,user_id,comment,datetime) Values
					('{$error_id}','{$_uid}','{$comment}',NOW() )");	
				}
				
			if($status>=3){
				mail("info@draccess.org, tom.tranfaglia@draccess.org", "Urgent SEDRS Call", $mailmsg,"FROM:admin@draccess.org");
							}

		header("LOCATION:caller_profile.php?caller_id={$caller_id}");
			
			die();				
	}
}
	include 'common/header.php';

	$res=mysql_query("select * from error_log as e
						inner join selpa_codes on e.code=selpa_codes.code
								inner join district_codes on e.cid=district_codes.cid 
						 			inner join caller_log on e.caller_id=caller_log.caller_id where error_id={$error_id}");

	
while ($row = mysql_fetch_assoc($res)){
	if($row['calltype']=="1"){
		$formtype="edit_error_form";
	}
	if($row['calltype']=="2"){
		$formtype="edit_training_call";
	}

if($row['caller_notes'] ==""){
	$caller_notes="Not Available";
}

echo"

<p><div class='text-error'><strong>{$errmsg}&nbsp;</strong></div></p>

  	<div class='row-fluid'>

		<!--dashboard-->
		<div class='span4'>
 		

	<h2><em>{$row['caller_title']}</em> <a href='caller_profile.php?caller_id={$row['caller_id']}'> 
		<br />{$row['caller_fname']} {$row['caller_lname']}</a></h2>
	<div class='btn'><a href='edit_caller.php?caller_id={$row['caller_id']}'><i class='icon-pencil'></i> Edit Caller Info</a></div>
	<hr/>
	<label for='selpa'><strong>SELPA</strong></label> {$row['selpa_name']}

	<label ><strong>District</strong></label> {$row['ds_name']}
	<label><strong>Phone:</strong></label> {$row['caller_areacode']} {$row['caller_phone']} 
<label><strong>Fax:</strong></label> {$row['fax_area']} {$row['caller_fax']}
<label><strong>Email:</strong> </label><a href='mailto:{$row['caller_email']}'>{$row['caller_email']}</a>
<label><strong>Notes:</strong></label>{$row['caller_notes']}

</div>


<div class='span8'>
<p>&nbsp;</p>
      <!--Body content-->
      <div class='btn-toolbar'>
  <div class='btn-group'>
<div class='btn'><a href='edit_error_form.php?error_id={$row['error_id']}&&caller_id={$row['caller_id']}' > <i class='icon-edit'></i>  Edit Record</a> </div>
 <div class='btn'><a href='delete.php?error_id={$row['error_id']}'  onClick=\"return confirm('Are you sure you want to delete this record?');return true\")> <i class='icon-trash'></i> Delete Record</a></div>
</div>
</div>";

//call assigned
	$result=mysql_query("select * from error_log inner join users
	 on error_log.responsible=users.user_id where error_id='{$error_id}'");
	 if (mysql_num_rows($result)==0){echo "<img src='images/folder_star.png'> No support person added to this call <a href='assign_response.php?error_id={$error_id}'>Assign?</a>";
}else{
$row=mysql_fetch_assoc($result);
	
	echo"	
<p class='text-warning'> This call is currently assigned to: 
{$row['user_fname']} {$row['user_lname']}</p>
 <div class='btn-toolbar'>
  <div class='btn-group'>
<div class='btn'><a href='assign_response.php?error_id={$error_id}'> <i class='icon-share-alt'></i> Re-Assign this record</a> </div>

<div class='btn'><a href='share_record.php?error_id={$error_id}&caller_id={$row['caller_id']}'> <i class='icon-share'></i> Share this Record</a></div>
</div>
</div>";




$result = mysql_query("select caller_id,contact,calltype,status,call_datetime from error_log where error_id={$error_id}");

while ($row = mysql_fetch_assoc($result)){


if ($row['contact']=="0"){
$method="No Record";
}
 if ($row['contact']=="1"){
$method="Phone";
}
if ($row['contact']=="2"){
$method="Email";
}
if ($row['contact']=="3"){
$method="Phone & Email";
}

if($row['calltype']=="1"){
		$type="Help Call";
	}
	if($row['calltype']=="2"){
		$type="Program Training";
	}
	
	if ($row['status']=="1"){
	$stat="<p class='alert alert-success'>Resolved</p>";
	}
	if($row['status']=="2"){
		$stat="<p class='alert alert-error'>Not Resolved</p>";
	}
	if($row['status']=="3"){
		$stat="<p class='alert alert-error'>Notify SCOE</p>";
	}
	if($row['status']=="4"){
		$stat="<p class='alert alert-error'>Notify CDE</p>";
}
echo"
<!--status -->
{$stat}



<!--Contact Method-->
<p><label for='method'>Method of Contact:</label> <div class='input-xlarge uneditable-input'>{$method} </div></p>";
}


	//query selpa code
$result=mysql_query("select *
from error_log inner join selpa_codes on error_log.code=selpa_codes.code where error_log.error_id={$error_id}");

$row = mysql_fetch_assoc($result);
	
echo"


<p><label>Selpa:</label> <div class='input-xlarge uneditable-input'>{$row['selpa_name']} </div></p>";

	

//query distric code
$res=mysql_query("select * from district_codes inner join error_log on district_codes.cid=error_log.cid where error_log.error_id={$error_id}");
$row = mysql_fetch_assoc($res);

echo"<p><label>District: </label> <div class='input-xlarge uneditable-input'>{$row['ds_code']} {$row['ds_name']}</div></p>";



//query support type
$result=mysql_query("select * 
from error_log 
inner join support_log on error_log.support_id=support_log.support_id where error_log.error_id={$error_id}");
if($row['notes'] ==""){
	$notes = "Not Available";

}
$row = mysql_fetch_assoc($result);
	
echo"
		<p><label>Support:</label> 
		<div class='input-xlarge uneditable-input'>{$row['support_id']} {$row['support_type']}</div></p>
		
		<p><label for='notes'>Notes: </label>{$row['notes']}</p>
		

		<form action='{$_SERVER['PHP_SELF']}' method='post'>
		
		<input type='hidden' name='doit' value='yes'>
		
		<input type='hidden' name='error' value='{$row['error_id']}'>
		<input type='hidden' name='caller_id' value='{$row['caller_id']}'>
		
				<!--status-->
			 
			
			<p><b>Comments</b></p>
		";
											
}
	
//query comments
$result=mysql_query("select * from comments inner join users on comments.user_id=users.user_id where error_id={$error_id} order by comment_id DESC");
if (mysql_num_rows($result)==0){echo "<div class='text-info'>No comments have been made</div>";
}
while ($row = mysql_fetch_assoc($result)){
//echo comments
echo"
<div class='alert alert-info'><img src='images/comment.png' align='left'>{$row['comment']} </span><br />
<span style='color:#666;font-size:xx-small;'>Comment by: {$row['user_lname']} </span>
<div class='text-info'>{$row['datetime']}</div></div>";
}

		
//leave a comment-->
$result=mysql_query("select * 
from error_log 
inner join support_log on error_log.support_id=support_log.support_id where error_log.error_id={$error_id}");
$row = mysql_fetch_assoc($result);

echo"
<!-- comment form -->
			<form action='{$_SERVER['PHP_SELF']}' method='post'>
			<input type='hidden' name='doit' value='yes'>
		
		<input type='hidden' name='error_id' value='{$row['error_id']}'>
		<input type='hidden' name='caller_id' value='{$row['caller_id']}'>
		<div class='text-info'><label for='comment'>Leave a comment: </label></div>
	<p><textarea name='comment' cols='8' rows='10' >
		{$comment}
		</textarea></p>
		
	
			<p><input type='submit' name='submit' class='btn' value='submit'></p>
			
			</form>";
			


//query last update

$result=mysql_query("SELECT * FROM error_log inner join users on 
							error_log.updateduser=users.user_id where error_id={$error_id}");

while ($row = mysql_fetch_assoc($result)){
 
	if ($row['status']=="1"){
	$stat="<p class='alert alert-success'>Resolved</p>";
	}
	if($row['status']=="2"){
		$stat="<p class='alert alert-error'>Not Resolved</p>";
	}
	if($row['status']=="3"){
		$stat="<p class='alert alert-error'>Notify SCOE</p>";
	}
	if($row['status']=="4"){
		$stat="<p class='alert alert-error'>Notify CDE</p>";
}

echo"
<p >Last Updated {$row['lastupdated']} by {$row['user_fname']} {$row['user_lname']} {$stat}</p>
";

}


//query users
$result=mysql_query("SELECT * FROM error_log inner join users on error_log.user_id=users.user_id where error_id={$error_id}");

$row = mysql_fetch_assoc($result);

echo"
<p>Entered by {$row['user_fname']} {$row['user_lname']} <br /><span style='font-size:x-small;'> {$row['date_entered']}</span> </p>
</div>";


}


?>