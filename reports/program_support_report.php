<!--//Program Support Query Count-->
echo"<h3>Support Topic Count for Program Support</h3>
	
	<table border='0' cellpadding='6'>
<tr>
	<th>Support Type</th><th>Count</th>
</tr><a name='programsupport'>	
";
<?php

$result=mysql_query("select  error_log.support_id, support_log.support_type, 
count(support_type) as support_count from error_log 
inner join support_log on error_log.support_id=support_log.support_id where calltype='2' 
group by support_type order by support_type");

while ($row = mysql_fetch_assoc($result)){
	
	echo"<tr >
	<td>{$row['support_type']}</td><td> {$row['support_count']}</td></tr>";
}

echo"
</table>";