
<h3 >Status Reports</h3>
<table border='0' cellpadding='6' align='center'>
<tr><th>Count</th><th >STATUS</th></tr>
<tr>
<?php

$result=mysql_query("select  status, count(status) as stat_count  from error_log where status >='1' group by status");

while ($row = mysql_fetch_assoc($result)){

	//status key
		if ($row['status']=="1"){
	$stat="Resolved";
	}
	if($row['status']=="2"){
		$stat="Not Resolved";
	}
	if($row['status']=="3"){
		$stat="Notify SCOE";
	}
	if($row['status']=="4"){
		$stat="Notify CDE";
	}

	
	
	echo"
	<td>{$row['stat_count']}</td> <td style='color:red;'> {$stat}</td></tr>";
}
	
echo"
</table>";
?>