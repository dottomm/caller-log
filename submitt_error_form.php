<?php
include 'common/useful_stuff.php';
if(!db_connect())
die();

if ($_uid == 0){
	header("location:login.php");
	die();
	}

$user_id=$_uid;
$selpa_disctrict=getvar("selpa_disctrict");
$district=getvar("district");
$selpa_name=getvar("selpa_name");
$caller=getvar("caller");
$caller_id=getvar("caller_id");
$caller_fname=getvar("caller_fname");
$caller_lname=getvar("caller_lname");
$caller_email=getvar("caller_email");
$caller_areacode=getvar("caller_areacode");
$caller_phone=getvar("caller_phone");
$call_datetime =  getvar("call_datetime");
$callmonth=getvar("month");	
$callday=getvar("day");
$cid=getvar("cid");
$code=getvar("code");
$contact=getvar("contact");
$date_entered=getvar("date_entered");
$ds_name=getvar("ds_name");
$responsible=getvar("responsible");
$support_id=getvar("support_id");
$support_type=getvar("support_type");
$selpa_name=getvar("selpa_name");
$status=getvar("status");
$option2 ="";
$notes=getvar("notes");
$lastupdated=getvar("lastupdated");
$theDate = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";

//$callmonth=getvar("callmonth");
//$callday=getvar("callday");
$calltype=getvar("calltype");
$updateduser=getvar("updateduser");
$errmsg ="";
$errors = "";
$errorString = getvar("errorString");

$doit=getvar("doit");

$mailmsg="Hi Sonya. <br/>
A SEDRS call has been marked as urgent and needs your attention 
Please log in at http://www.draccess.org/DR_Caller_Log/ to view the issues. 
Thank you!
";




if($doit == "yes"){
	$errors = array();

 if($code==""){
	$errors[]="Please select a Selpa District";
	}
 if($contact=="0"){
	$errors[]="Please specify contact method";
	}
 if($cid==""){
	$errors[]="Please select a school district";
	}
 if($support_id=="0"){
	$errors[]="Please choose the support type";
	}
 if($status=="0"){
	$errors[]="Please select the status";
}
else if($theDate==""){
		$errors[]="What date did the new call occur?";
}
	
	 if($responsible=="1"){
		$errmsg="Tom is not permitted to handle support calls.<br> Please select another user";
	}

		if ((count($errors) > 0)) {
		$errorString = '<div class="alert alert-error" style="background-color:#fff;"><p> <a href="javascript:history.go(-1)">Go back</a> <br />There was an error processing the form. </p>';
		$errorString .= '<ul>';
		foreach($errors as $error)
				$errorString .= "<li>$error</li>";
					
		$errorString .= '</ul></div>';
		$errorString .=  "<p style='color:#D42222; font-size:.8em;'>Please correct the above error(s) and try again </p>";
	
	

}else{


mysql_query ("INSERT INTO error_log
(user_id, caller_id,  code,
	contact, cid, support_id, 
		notes, date_entered,status, 
			lastupdated, updateduser,call_datetime,
				calltype, responsible)
VALUES('{$user_id}','{$caller_id}','{$code}',
	'{$contact}','{$cid}','{$support_id}',
		'{$notes}', NOW(), '{$status}',
			NOW(), '{$user_id}','{$theDate}',
				1,'{$_uid}')");
					
					header("location:caller_profile.php?caller_id={$caller_id}");

	
		}
	
	}	


	include 'common/header.php';
 
 //Get user name from $_uid
$result=mysql_query("Select * from users where user_id=$_uid");
					while($row=mysql_fetch_assoc($result)){

echo"<div class='row-fluid'>
	    <div class='span4'>
	    <p>&nbsp;</p>
<div class='alert'>Administrator is {$row['user_fname']} {$row['user_lname']}<br/>
Not {$row['user_fname']} {$row['user_lname']}? <a href='logout.php'>Log out</a></div>



";}
 
 
$result=mysql_query("select * from caller_log 
						inner join district_codes on caller_log.district=district_codes.cid 
							inner join selpa_codes on caller_log.selpa=selpa_codes.code
								where caller_id={$caller_id}");
	while($row=mysql_fetch_assoc($result)){
echo"

<h3> {$row['caller_fname']} {$row['caller_lname']}</h3> 
<div class='btn'><a href='edit_caller.php?caller_id={$row['caller_id']}' ><i class='icon-pencil'></i> Edit Caller Info</a></div>
<hr />
<p>({$row['caller_areacode']}) {$row['caller_phone']}<br/>

<a href='mailto:{$row['caller_email']}'>{$row['caller_email']}</a></p>
<p><label for='selpa'><strong>SELPA</strong></label>{$row['selpa_name']}</p>
<p><label for='district'><strong>District</strong></label> {$row['ds_name']}</p>
<hr />
</div>
<div class='span8'>
<font color='red'><b>{$errmsg}&nbsp;</b></font>
 $errorString
<form action='{$_SERVER['PHP_SELF']}' method='post'>
<input type='hidden' name='doit' value='yes'>
<input type='hidden' name='caller_id' value='{$row['caller_id']}'>
<input type='hidden' name='caller_fname' value='{$row['caller_fname']}'>
<input type='hidden' name='caller_distirct' value='{$row['cid']}'>

<p><label for='date'>Date of Call</label><br />";

//* Going to try to set the calendar function here*/

//get class into the page
require_once('classes/tc_calendar.php');

//instantiate class and set properties
$myCalendar = new tc_calendar('date1', true);
$myCalendar->setIcon('images/iconCalendar.gif');
$myCalendar->setDate(1, 1, 2012);
$myCalendar->setDate(date('d'), date('m'), date('Y'));
$myCalendar->setYearInterval(2012, 2015);

//output the calendar
$myCalendar->writeScript();	

echo
"
<!--Contact Method-->
<p><label for='contact'>Method of contact ?</label> 
		<select name='contact'>
			<option value='0' default>Select Method</option>
			<option value='1'>Phone</option>
			<option value='2'>Email</option>
			<option value='3'>Both Phone/Email</option>
			
			</select>
			</p>
<p><label for='code'>Selpa </lable><br />";
//SELPA Select 
	$selpaquery=mysql_query("select code, selpa_name from selpa_codes order by selpa_name");
	$options="";
	while($selparow=mysql_fetch_array($selpaquery)){
	if($row['selpa']==$selparow['code']){
	$sel=' selected ="selected"';
}else{
		$sel='';
		}
	$options .="<option value=\"{$selparow['code']}\" {$sel} >{$selparow['code']} {$selparow['selpa_name']}</option>";
	
		}
?>

	<select name='code' id='selpa'>
	<?php echo"$options";?>
		</select>
		
		<p><label for='cid'>Select A District</label></p>
			
<?php	
//District Select 
	$districtquery=mysql_query("select cid,ds_code,ds_name from district_codes order by ds_name ASC");
	while($districtrow=mysql_fetch_array($districtquery)){
	if($row['district']==$districtrow['cid']){
		$sel=' selected = "selected" ';
		}else{
			$sel='';
			}
			$option2 .="<option value=\"{$districtrow['cid']}\" {$sel} > {$districtrow['ds_name']}</option>";
			
			
		}
	?>

	<select name='cid' id='cid'>
<option value='0' >Please select District...</option>
	<?php echo" $option2";?>
	</select>
<?php 
	echo"
		<p><label for='support_type'>Support Types</label>
<select name='support_id'><option value='0'>Please Specify Support Type...";
	$result=mysql_query("select support_id, support_type from support_log  order by support_id ASC");
	while($row=mysql_fetch_assoc($result)){
	if($row['support_id']==$support_id){
	echo"<option value='{$row['support_id']}' selected>{$row['support_id']}  {$row['support_type']}";
	}
	else{
		echo"
		<option value='{$row['support_id']}' >{$row['support_id']} {$row['support_type']}";
		}
	}
	
	echo"</select>
</p>


<p class='status'><label for='status'>Status ?</label> 
		<select name='status'>
			<option value='0' default>Select Status</option>
			<option value='1'>Resolved</option>
			<option value='2'>Not Resolved</option>
			<option value='3'>Notify SCOE</option>
			<option value='4'>Notify CDE</option>
			</select>
			</p>
<p><label for='notes'>Comments</label>
<textarea name='notes' style='height:10px; width: 420px;'>
{$notes}
</textarea></p>
<p>
	<input type='submit' name='submit' value='submit' class='btn'></p>
	
	</form></p></div></div>";
}


	?>
	
	</body>
	</html>