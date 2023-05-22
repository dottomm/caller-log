<h3 >Support Topic Count </h3>
	
	<table border='0' cellpadding='6' width='100%'>
<tr>
	<th>Support Type</th><th>Count</th>
</tr><a name='supporttopic'>	
<?php
$result=mysql_query("select  error_log.support_id, support_log.support_type, 
count(support_type) as support_count from error_log 
inner join support_log on error_log.support_id=support_log.support_id  group by support_type order by support_id");

while ($row = mysql_fetch_assoc($result)){

		
	echo"<tr >
	<td>{$row['support_id']}</td>
	<td><a href='topic_summary.php?support_id={$row['support_id']}'> {$row['support_type']}</a></td>
	<td> {$row['support_count']}</td></tr>";

}

			echo "</table>";