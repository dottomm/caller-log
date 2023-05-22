<?php
include 'common/useful_stuff.php';
if(!db_connect())
die();



if ($_uid == 0){
	header("location:login.php");
	die();
	}
	
	$caller_id=getvar("caller_id");
	$caller_title = getvar("caller_title");
	$caller_fname=getvar("caller_fname");
	$caller_lname=getvar("caller_lname");
	$caler_areacode=getvar("caller_areacode");
	$caller_email=getvar("caller_email");
	$selpa_name =getvar("selpa_name");
	$ds_name=getvar("ds_name");
	$urgent=getvar("urgent");
	$status=getvar("status");
	
	include 'common/header.php';
	
	
$result=mysql_query("select 
						caller_title, caller_fname,caller_lname,
							caller_email, selpa, selpa_name, 
								district, ds_name,caller_areacode, 
									caller_phone, status 
						from caller_log 
							inner join selpa_codes on caller_log.selpa=selpa_codes.selpa_name
								inner join district_codes on caller_log.district=district_codes.cid 
									inner join error_log on caller_log.caller_id=error_log.caller_id where caller_log.caller_id={$caller_id}");
if (mysql_num_rows($result)==0){$result=mysql_query("select * from caller_log 
												inner join selpa_codes on caller_log.selpa=selpa_codes.code
								inner join district_codes on caller_log.district=district_codes.cid	 where caller_id={$caller_id}");
}

while ($row = mysql_fetch_assoc($result)){

if($row['caller_title']==""){
$caller_title = "NA";

}


echo"
  	<div class='row-fluid'>
		<!--dashboard-->
		<div class='span4'>
	
<h2>{$row['caller_title']} <br /> {$row['caller_fname']} {$row['caller_lname']} </h2>
<div class='btn'><a href='edit_caller.php?caller_id={$caller_id}'><i class='icon-pencil'></i> Edit Caller Info</a></div>
<hr/>
<p><label for='selpa'><strong>SELPA</label></strong> {$row['selpa_name']}</p>

<p><label for='district'><strong>District</strong></label> {$row['ds_name']}</p>
<p><label for='phone'><strong>Phone:</strong> ({$row['caller_areacode']}) {$row['caller_phone']}<br />
<a href='mailto:{$row['caller_email']}'>{$row['caller_email']}</a> </p>
<p><label for='notes'><strong>Notes</strong></label>
{$row['caller_notes']}</p>


";

//query unresolved calls
//$result=mysql_query("select * from error_log where caller_id={$caller_id}");
$result=mysql_query("select *
from error_log inner join support_log on error_log.support_id=support_log.support_id where caller_id={$caller_id} AND status>=2");
$num_rows = mysql_num_rows($result);
if (mysql_num_rows($result)==0){	
	echo"<div class='alert alert-success'> No Un-resolved Calls for {$row['caller_fname']} {$row['caller_lname']}</div>";
}
else{ echo"<p class='alert'>{$row['caller_fname']} {$row['caller_lname']}'s <span class='badge badge-important'>$num_rows</span> Unresolved Calls</p>

	";
}
	
while ($row = mysql_fetch_assoc($result)){


echo"<li><a href='error_profile.php?error_id={$row['error_id']}&caller_id={$row['caller_id']}'>{$row['support_type']}</a>
<br> <span style='font-size:small; margin-left:1em;'>{$row['call_datetime']}</span><img src='images/flag_red.png'></li>";
}
}
echo"<hr />";
//query caller's name
$res=mysql_query("select caller_fname, caller_lname from caller_log where caller_id={$caller_id}");
 ($row = mysql_fetch_assoc($res));

//query resolved calls

$result=mysql_query("select *
from error_log inner join support_log on error_log.support_id=support_log.support_id where caller_id={$caller_id} AND status=1");
$num_rows = mysql_num_rows($result);
if (mysql_num_rows($result)==0){	echo"<div id='resolved'>
	<p class='alert'>No resolved Calls for this {$row['caller_fname']} {$row['caller_lname']}</p>";
}
else{
echo"<div id='resolved'><p class='alert'>{$row['caller_fname']} {$row['caller_lname']}'s <span class='badge badge-info'>$num_rows</span> Resolved Calls </p>";
}
	
while ($row = mysql_fetch_assoc($result)){


echo"<li><a href='error_profile.php?error_id={$row['error_id']}&caller_id={$row['caller_id']}'>{$row['support_type']}</a>
<br><span style='font-size:small; margin-left:1em;'>{$row['call_datetime']}</span> </li>";
}

echo"</div>
</div>
<div class='span8'>
      <!--Body content-->
    <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
 <div class='btn-toolbar center'>
  <div class='btn-group'>
<a href='submitt_error_form.php?caller_id={$caller_id}' class='btn'><i class='icon-file'></i> Add Record</a> </p>
</div>
<hr />"
;
?>


