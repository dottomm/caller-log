<!--//Support by Date-->
echo"<h3>Support Topic Count for Program Support</h3>
	
	<table border='0' cellpadding='6'>
<tr>
	<th>Support Type</th><th>Count</th>
</tr><a name='support_date'>	
";
<?php

$result=mysql_query("SELECT * 
FROM  `error_log` 
INNER JOIN caller_log ON error_log.caller_id = caller_log.caller_id
INNER JOIN selpa_codes ON error_log.code = selpa_codes.code
INNER JOIN support_log ON error_log.support_id = support_log.support_id
where callmonth between 1 AND 3 and callyear=2011");

while ($row = mysql_fetch_assoc($result)){
	
	echo"<tr >
	<td>{$row['support_type']}</td><td> {$row['support_count']}</td></tr>";
}

echo"
</table>";