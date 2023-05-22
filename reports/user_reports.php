
<h3>User Reports</h3>

<div class='pull-right'><iframe srcdoc='' src=reports/user_report_query.php?user_id={$row['user_id']}' name='frame' width='100%'></iframe></div>


<a name='user_report'></a>

<?php
$user_id = getvar("user_id");
$data_id = "{$row['user_id']}";
$fname="{$row['user_fname']}";
//user reports
$result=mysql_query('SELECT
						e.error_id, e.responsible,
							users.user_id,users.user_fname, users.user_lname,
								count( e.user_id ) AS u_count

					FROM error_log e INNER JOIN users ON e.responsible = users.user_id

					GROUP BY responsible
');


	while($row=mysql_fetch_assoc($result)){
	echo"<li style='padding-top:8px;'>
  <span class='badge badge-info'>{$row['u_count']}</span> <a  href='reports/user_report_query.php?user_id={$row['user_id']}' target='frame'>{$row['user_fname']} {$row['user_lname']}</a> 

"; 	}

			
		

