<?php


?>


<h3 >Support Topic Count </h3>
	
	<table border='0' cellpadding='6' width='100%'>
<tr>
	<th>Support Type</th><th>Count</th>
</tr><a name='supporttopic'></a>
<?php
echo"
<input type='hidden' name='doit' value='yes'>
<p>Choose a start and end date for reports</p>
<form action='{$_SERVER['PHP_SELF']}' method='post' name='#support'>
<input type='hidden' name='doit' value='yes'>


<div>";

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

$result=mysql_query("select  error_log.support_id, support_log.support_type, 
count(support_type) as support_count from error_log 
inner join support_log on error_log.support_id=support_log.support_id  
where call_datetime >= '$fromtime' and call_datetime <= '$totime'
group by support_type order by support_count DESC");

//get number of records
	$num_rows = mysql_num_rows($result);
	
		if (mysql_num_rows($result)!=0)
		{echo "
		<table cellpadding='6px' border='1' width='100%'>
	<caption><p><span class='badge badge-info'>
		$num_rows records returned for date range $fromtime to $totime</span></p></caption>
	<thead >
	<th >Support Id</th> <th>Support Type</th> <th>Support Count</th>
";
		}
		else
		{
		echo"<div class='alert'>No Records Match your Search Criteria</div>";	
		}

while ($row = mysql_fetch_assoc($result)){

		
	echo"<tr >
	<td>{$row['support_id']}</td>
	<td><a href='topic_summary.php?support_id={$row['support_id']}'> {$row['support_type']}</a></td>
	<td> {$row['support_count']}</td></tr>";

}

			echo "</table>";