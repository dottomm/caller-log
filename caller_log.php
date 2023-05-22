<?php
include 'common/useful_stuff.php';
if(!db_connect())
die();
	include 'common/header.php';



if ($_uid == 0){
	header("location:login.php");
	die();
	}
$caller_id=getvar("caller_id");	
$count=getvar("count");

$result=mysql_query("Select (select count(*) from caller_log) as caller_count");	
	
$row = mysql_fetch_array($result);
		echo"

	<caption>Caller Log <span style='font-size:small; color:#000;'>{$row['caller_count']} callers recorded</span></caption>
	";

	

echo"
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table border='0' cellpadding='3' class='display' id='example' >
<thead>
<tr>
	<th>Caller  Name</th><th>Caller Email</th>  <th>SELPA</th> <th>Caller Phone</th> <th>Call Count</th>
</tr>
	</thead>
	<tbody>";
	

	
	
	
//	$result=mysql_query("SELECT * FROM caller_log order by caller_lname DESC ");
$result=mysql_query("SELECT 
(select count(*) FROM error_log e1 where e1.caller_id=c.caller_id) as post_count,
c.caller_id,
c.caller_fname,
c.caller_lname,
c.caller_email,
c.caller_areacode,
c.caller_phone,
selpa_codes.code,
selpa_codes.selpa_name
from caller_log c
left outer join 
error_log e 
on c.caller_id=e.caller_id 

 join selpa_codes on c.selpa=selpa_codes.code
group by c.caller_id order by caller_lname ASC
");


while ($row = mysql_fetch_assoc($result)){



echo"
<tr>
<td><a href='caller_profile.php?caller_id={$row['caller_id']}'>{$row['caller_fname']} {$row['caller_lname']}</a></td>
<td><a href='mailto:{$row['caller_email']}'>{$row['caller_email']}</a></td>
<td>{$row['selpa_name']}</td>
<td>  ({$row['caller_areacode']}) {$row['caller_phone']}</td> 
<td> <span style='color:#666'>{$row['post_count']} calls received</span> </td>
</tr>


";



}
echo"</tbody>
</table>";

?>