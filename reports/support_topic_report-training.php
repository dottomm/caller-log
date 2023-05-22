<h3 align='center'>Support Topic Count for Training Support </h3>
	
	<table border='0' cellpadding='6' align='center'>
<tr>
	<th>Support Type</th><th>Count</th>
</tr><a name='supporttopic'>	
<?php
$result=mysql_query("select  error_log.support_id, support_log.support_type, 
count(support_type) as support_count from error_log 
inner join support_log on error_log.support_id=support_log.support_id where calltype='2' group by support_type order by support_type");

while ($row = mysql_fetch_assoc($result)){

		
	echo"<tr >
	<td><a href='topic_summary.php?support_id={$row['support_id']}'> {$row['support_type']}</a></td>
	<td> {$row['support_count']}</td></tr>";

}

			echo "</table>";