<?php 

include 'common/useful_stuff.php';
if(!db_connect())
die();

if ($_uid == 0){
	header("location:login.php");
	die();
	}

//get date of thirty days previous
$today = date('Y-m-d');
$today30 = strtotime(date("Y-m-d", strtotime($today)) . "-30 day");
$todayminus30 = date('Y-m-d', $today30);


$user_fname = getvar("user_fname");
$user_lname = getvar("user_lname");
$count = getvar("count");
include 'common/header.php';
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class='span12'>
<div class='graph' id='graph'>Loading graph...

	
<?php
$result=mysql_query("SELECT count( responsible ) error_id,e.user_id , user_fname, user_lname, call_datetime ,status ,responsible from error_log e
inner join users on e.user_id=users.user_id

where status ='1' group by users.user_id"); 

while ($row = mysql_fetch_assoc($result)){		
echo" <p>{$count} {$row['error_id']} {$row['user_fname']} {$row['user_lname']}</p>";
}