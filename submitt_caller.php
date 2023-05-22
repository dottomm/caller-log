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
$caller=getvar("caller");
$caller_id=getvar("caller_id");
$caller_title=getvar("caller_title");
$caller_fname=getvar("caller_fname");
$caller_lname=getvar("caller_lname");
$caller_email=getvar("caller_email");
$caller_areacode=getvar("caller_areacode");
$caller_phone=getvar("caller_phone");
$caller_fax=getvar("caller_fax");
$caller_notes=getvar("caller_notes");
$fax_area=getvar("fax_area");
$cid=getvar("cid");
$contact =getvar("contact");
$code=getvar("code");
$ds_name=getvar("ds_name");
$support_id=getvar("support_id");
$support_type=getvar("support_type");
$selpa_name=getvar("selpa_name");

$errmsg ="";
$doit  =getvar("doit");




if($doit == "yes"){


if($caller_fname==""){
	$errmsg="Please Enter the Caller's First Name";
	}
	else if($caller_lname==""){
	$errmsg="Please Enter the Caller's Last Name";
	}
	
	
	else if($contact=="0"){
	$errmsg="Please specify method of contact";
	
	} 
	else if($code==""){
		$errmsg="Please Select a SELPA";
	}
	else if($cid==""){
		$errmsg="Please Select a District";
	}
	
	
	else	
		if(mysql_num_rows(mysql_query("SELECT caller_fname,caller_lname, caller_email FROM caller_log WHERE caller_lname = '{$caller_lname}' AND caller_fname='{$caller_fname}' and caller_email='{$caller_email}'"))){
echo"<p class='text-alert'>caller already exists!</p>";// Code inside if block if userid is already there
}
else{

$sql=mysql_query ("INSERT INTO caller_log
		(user_id,caller_title,caller_fname,caller_lname, 
			caller_email,caller_areacode,
			 	caller_phone,fax_area,caller_fax,
			 		 caller_notes,selpa,district)

		VALUES('{$_uid}','{$caller_title}','{$caller_fname}','{$caller_lname}',
		'{$caller_email}','{$caller_areacode}','{$caller_phone}',
		'{$fax_area}','{$caller_fax}','{$caller_notes}',
		'{$code}','{$cid}')");
				
	
				
				
				
header("LOCATION:caller_added.php");
	
	
		}
	}


?>
<html>
<head>

</head>
<body  OnLoad="document.caller.caller_title.focus();">
<?php				
					include 'common/header.php';
					//Get user name from $_uid
$result=mysql_query("Select * from users where user_id=$_uid");
					while($row=mysql_fetch_assoc($result)){

echo"<div class='container-fluid'>
  	<div class='row-fluid'>
		<!--dashboard-->
		<div class='span12'>
 		<!--sidebar-->
<p>&nbsp;</p>
			<div class='alert alert-info'>Administrator is {$row['user_fname']} {$row['user_lname']}<br />
Not {$row['user_fname']} {$row['user_lname']}? <a href='logout.php'>Log out</a></div>
";
}
echo"
	
 		

<p><font color='red'><b>{$errmsg}&nbsp;</b></font></p>

<form action='{$_SERVER['PHP_SELF']}' method='post' name='caller'>

<input type='hidden' name='doit' value='yes'>
<input type='hidden' name='caller_id' value='{$caller_id}'>

<p><label for='caller_title'>Title/Role</label>
<input type='text' name='caller_title' value='{$caller_title}' placeholder='Title or Role'></p>

<p><label for='caller_fname'>Caller First Name</label>
<input type='text' name='caller_fname' value='{$caller_fname}' placeholder='Caller First Name'></p>

<p><label for='caller_fname'>Caller Last Name</label>
<input type='text' name='caller_lname' value='{$caller_lname}' placeholder='Caller Last Name'></p>

<p><label for='caller_email'>Caller E-Mail</label>
<input type='email' name='caller_email' value='{$caller_email}' placeholder='Caller Email'>

<p>
<label for='caller_areacode'>Area Code/Phone</label>
<input type ='text' name='caller_areacode' value='{$caller_areacode}' class='span2' placeholder='Area Code'> 
<input type='text' name='caller_phone' value='{$caller_phone}'  class='span5' placeholder='Caller Phone Number'>
<label for='caller_fax'>Fax</label>
<input type='text' name='fax_area' value='{$fax_area}' class='span2' placeholder='Fax Area Code'>
<input type='text' name='caller_fax' value='{$caller_fax}' class='span5' placeholder='Fax Number'></p>

<p>			<select name='code'><option value='0' >Please select SELPA...";
	$result=mysql_query("select code, selpa_name from selpa_codes order by selpa_name ASC");
	while($row=mysql_fetch_assoc($result)){
	if($row['code']==$code){
	echo"<option value='{$row['code']}' selected>{$row['code']}  {$row['selpa_name']}";
	}
	else{
		echo"
		<option value='{$row['code']}' > {$row['code']} {$row['selpa_name']}</p>";
			}
		}

		echo"</select>
		
		<p>
			<select name='cid'><option value='0' >Please select District...";

	$result=mysql_query("select cid,ds_name from district_codes order by ds_name ASC");
	while($row=mysql_fetch_assoc($result)){
	if($row['cid']==$cid){
	echo"<option value='{$row['cid']}' selected> {$row['cid']} {$row['ds_name']} ";
	}
	else{
		echo"
		<option value='{$row['cid']}'>{$row['cid']} {$row['ds_name']}";
		}
	}
	echo"</select></p>
		

<p><label for='caller_notes'>Notes</label><br/>
<textarea style='height:10px;
width: 420px;' name='caller_notes' >{$caller_notes}</textarea>

<p>&nbsp;</p>

 <button type='submit' class='btn '>Submit Caller Info</button>
  <button type='button' class='btn'>Cancel</button>
	
	</form>
	</div>
	";

	?>
	</body>
	</html>