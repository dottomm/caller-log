

<?php
//enter start / end dates here
//$fromtime='2012-03-24 00:00:00';
//$totime = '2012-03-28 00:00:00';
$fromtime = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
$totime = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";

$errmsg ="";
$doit=getvar("doit");



echo"
<h3>Quarterly Reports</h3>
<form action='{$_SERVER['PHP_SELF']}' method='post' name='calendar'>
<input type='hidden' name='doit' value='yes'>
<p>Choose a start and end date for reports</p><div>";

//* Going to try to set the calendar function here*/

//get class into the page
require_once('classes/tc_calendar.php');

//get date of thirty days previous
$today = date('Y-m-d');
$today30 = strtotime(date("Y-m-d", strtotime($today)) . "-30 day");
$todayminus30 = date('Y-m-d', $today30);


//instantiate class and set properties
$myCalendar = new tc_calendar('date1', true);
$myCalendar->setIcon('images/iconCalendar.gif');
$myCalendar->setDate(1, 1, 2012);
$myCalendar->setDate(date('d', strtotime($todayminus30)), date('m', strtotime($todayminus30)), date('Y', strtotime($todayminus30)));
//$myCalendar->setDate(date('d'), date('m'), date('Y'));
$myCalendar->setYearInterval(2012, 2015);

//output the calendar
$myCalendar->writeScript();

echo"</div>	";
//get class into the page
require_once('classes/tc_calendar.php');

//instantiate class and set properties
$myCalendar = new tc_calendar('date2', true);
$myCalendar->setIcon('images/iconCalendar.gif');
$myCalendar->setDate(1, 1, 2012);
$myCalendar->setDate(date('d'), date('m'), date('Y'));
$myCalendar->setYearInterval(2012, 2015);

//output the calendar
$myCalendar->writeScript();	

echo"
<p style='text-align:right;'><input type='submit' value='submit' class='btn'>
</form>

";



$result=mysql_query("SELECT * 
FROM  `error_log` 
INNER JOIN caller_log ON error_log.caller_id = caller_log.caller_id
INNER JOIN selpa_codes ON error_log.code = selpa_codes.code
LEFT JOIN support_log ON error_log.support_id = support_log.support_id
where call_datetime >= '$fromtime' and call_datetime <= '$totime'
order by selpa_name");
	//get number of records
	$num_rows = mysql_num_rows($result);
	
		if (mysql_num_rows($result)!=0)
		{echo "
		
		
		
	<table cellpadding='6px' border='1' width='100%'>
	<caption><p><span class='badge badge-info'>
		$num_rows records returned for date range $fromtime to $totime</span></p></caption>
	<thead >
	<th >Error Id</th> <th>Support Type</th> <th >Selpa Name</th> <th >Caller Name</th><th>Call Date Time</th>
";
		}
		else
		{
		echo"<div class='alert'>No Records Match your Search Criteria</div>";	
		}
while ($row = mysql_fetch_assoc($result)){		
echo"
	<tr >
	<td>{$row['error_id']}</td><td><a href='topic_summary.php?support_id={$row['support_id']}'>{$row['support_type']}</a></td><td> {$row['selpa_name']}</td><td><a href='caller_profile.php?caller_id={$row['caller_id']}'>{$row['caller_title']} {$row['caller_fname']} {$row['caller_lname']}</a><td>{$row['call_datetime']}</td></tr>";
}

echo"
</table>
";