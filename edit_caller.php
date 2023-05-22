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
$selpa_disctrict=getvar("selpa_disctrict");
$district=getvar("district");
$selpa_name=getvar("selpa_name");
$caller_title=getvar("caller_title");
$caller=getvar("caller");
$caller_id=getvar("caller_id");
$caller_fname=getvar("caller_fname");
$caller_lname=getvar("caller_lname");
$caller_email=getvar("caller_email");
$caller_areacode=getvar("caller_areacode");
$caller_phone=getvar("caller_phone");
$caller_fax=getvar("caller_fax");
$caller_notes=getvar("caller_notes");
$fax_area=getvar("fax_area");
$cid=getvar("cid");
$code=getvar("code");
$ds_name=getvar("ds_name");

$support_id=getvar("support_id");
$support_type=getvar("support_type");
$selpa=getvar("selpa");

$errmsg ="";
$doit  =getvar("doit");




if($doit == "yes"){


if($caller_fname==""){
	$errmsg="Please Enter the Caller's First Name";
	}
	else if($caller_lname==""){
	$errmsg="Please Enter the Caller's Last Name";
	}
	 else	{


	mysql_query ("update  caller_log
			set caller_title='$caller_title', caller_fname='$caller_fname',caller_lname='$caller_lname', 
				caller_email='$caller_email', caller_areacode='$caller_areacode',caller_phone='$caller_phone', 
				fax_area='$fax_area', caller_fax='$caller_fax', caller_notes='$caller_notes', 
					selpa='$selpa', district='$cid'
		 			 	where caller_id={$caller_id}");
				
header("LOCATION:caller_profile.php?caller_id={$caller_id}");
	
	
	}
}


			
					include 'common/header.php';
					//Get user name from $_uid
$result=mysql_query("Select * from users where user_id=$_uid");
					while($row=mysql_fetch_assoc($result)){

echo"

  	<div class='row-fluid'>
		<!--dashboard-->
		<div class='span4'>
 		<!--sidebar-->
Administrator is {$row['user_fname']} {$row['user_lname']}
<p>Not {$row['user_fname']} {$row['user_lname']}? <a href='logout.php'>Log out</a></p>
</div>";
}
$result=mysql_query("Select * from caller_log where caller_id={$caller_id}");

$row=mysql_fetch_assoc($result);
echo"
<div class='span8'>
      <!--Body content-->
<p><font color='red'><b>{$errmsg}&nbsp;</b></font></p>
<h3>Edit {$row['caller_title']} <br/>{$row['caller_fname']} {$row['caller_lname']} Info</h3>

<form action='{$_SERVER['PHP_SELF']}' method='post'>

<input type='hidden' name='doit' value='yes'>
<input type='hidden' name='caller_id' value='{$caller_id}'>

<p><label for='caller_title'>Title/Role</label>
<input type='text' name='caller_title' value='{$row['caller_title']}'></p>


<p><label for='caller_fname'>Caller First Name</label>
<input type='text' name='caller_fname' value='{$row['caller_fname']}'><br />

<label for='caller_fname'>Caller Last Name</label>
<input type='text' name='caller_lname' value='{$row['caller_lname']}'></p>

<p><label for='caller_email'>Caller E-Mail</label>
<input type='text' name='caller_email' value='{$row['caller_email']}'>

<p><label for='caller_areacode'>Area Code/Phone</label>
<input type ='text' name='caller_areacode' value='{$row['caller_areacode']}' class='span2'> 

<input type='text' name='caller_phone' value='{$row['caller_phone']}'  class='span3'>

<label for='caller_fax'>Fax</label>
<input type='text' name='fax_area' value='{$row['fax_area']}'  class='span2'>
<input type='text' name='caller_fax' value='{$row['caller_fax']}' class='span3'></p>
<p><label for='selpa'>Select caller's SELPA</label>";

	$r=mysql_query("select code, selpa_name from selpa_codes ");
	$options="";
	while($d=mysql_fetch_array($r)){
	if($row['selpa']==$d['code']){
	$sel=' selected ="selected"';
}else{
		$sel='';
	}
	$options .="<option value=\"{$d['code']}\" {$sel} >{$d['code']} {$d['selpa_name']}</option>";
}

?>	
		
	<select name='selpa' id='selpa'>
	<?php echo"$options";?>
	
	</select>

		
		<p><label for='cid'>Select A District</label>
		
			
<?php

	$r=mysql_query("select * from district_codes");
		$option2="";

	while($a=mysql_fetch_array($r)){
	if($row['district']==$a['cid']){
		$sel=' selected ="selected"';
	}else{
		$sel='';
	}
	$option2 .="<option value=\"{$a['cid']}\" {$sel} >{$a['ds_name']}</option>";
}
?>
	<select name='cid' id='cid'>
	<?php echo" $option2";?>
	</select>
<?php
echo"

<p><label for='caller_notes'>Notes</label>
<textarea name='caller_notes' cols='40' rows='10'>{$row['caller_notes']}</textarea>

<p>&nbsp;</p>
  <button type='submit' class='btn'>update caller info</button>
  <button type='button' class='btn'>Cancel</button>


	
	</form>
	</div>";

	?>
	</body>
	</html>