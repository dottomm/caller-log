<?php
include 'common/useful_stuff.php';
if(!db_connect())
die();

$count=getvar("count");


if ($_uid == 0){
	header("location:login.php");
	die();
	}
	$urgent=getvar("urgent");
	
	
include 'common/header.php';
	
	echo"

  	<div class='row-fluid'>
	    <div class='span4'>
		";

	//query user info 
	$res=mysql_query("Select * from users where user_id=$_uid");
			while ($row=mysql_fetch_assoc($res)){
			echo"
	<p>&nbsp;</p>
			<div class='alert alert-info'>
Administrator is {$row['user_fname']} {$row['user_lname']}
<br><small> Not {$row['user_fname']} {$row['user_lname']}? <br /><a href='logout.php'><em>Log out</em></a></span></small></div>
	
	<hr>
";

//Get calls assigned to user
$result=mysql_query("select
	error_id,
	support_type,
caller_fname,
caller_lname,
	responsible,
	date_entered
	 from error_log as e 
	inner join 
			caller_log on e.caller_id = caller_log.caller_id
		inner join
			support_log on e.support_id=support_log.support_id 
				where
				e.responsible='$_uid' and e.status >=2");
echo"<p class='alert'>{$row['user_fname']} {$row['user_lname']}&#8217;s Calls </p>";
	if (mysql_num_rows($result)===0){
//if no records say so
		echo "<p class='muted'><img src='images/folder_star.png'> No Calls have been assigned to you.</p>";
}else{
//echo number of records assigned
	echo"<p class='alert alert-error'>	{$row['user_fname']} {$row['user_lname']} is responsible for the following outstanding calls!!!</p>
		
		<table border='0' cellpadding='3' width='100%' class='table' id='example'>
<caption>	</caption>
<thead>
<tr>
	<th>Error Id</th><th>Support Topic</th> <th>Caller Name</th>
</tr>
</thead>
<tbody>
";
}

while ($row = mysql_fetch_assoc($result)){
	//display records assigned to user
	echo"		
<tr>
<td> <img src='images/flag_red.png'> {$row['error_id']}</td>
<td><a href='error_profile.php?error_id={$row['error_id']}'>{$row['support_type']}</a></td> 

<td>{$row['caller_fname']} {$row['caller_lname']}</span></td>
</tr>

 ";
	}

}

//calls marked as urgent
	$result=mysql_query("SELECT * FROM error_log 
	inner join support_log on error_log.support_id=support_log.support_id AND error_log.status >='3'
group by error_id");
if (mysql_num_rows($result)==0){echo "<p class='muted'><img src='images/folder_star.png'> No Calls marked as urgent</p>";

}else{
	//close first table //Open Second
echo"</tbody></table>
<p class='alert'>Urgent Calls</p>
		<table border='0' cellpadding='3' width='100%' class='table' id='example2'>
<caption> </caption>
<thead>
<tr>
	<th>Error Id</th><th>Support Topic</th> <th>Date/Time</th>
</tr>
</thead>
<tbody>";
while ($row = mysql_fetch_assoc($result)){

echo"
<tr>
<td><img src='images/flag_red.png'>{$row['error_id']} </td> 
<td><a href='error_profile.php?error_id={$row['error_id']}&caller_id={$row['caller_id']}'>{$row['support_type']} 
{$row['support_type']}</a> </td>
<td>{$row['date_entered']}</td>
</tr>";

	}
}
//close second table //Open Third
echo"</tbody></table>

		<table  class='table' id='example3'>
<thead>
<tr>
	<th>Error Id</th><th>Support Topic</th> <th>Caller Name</th>
</tr>
</thead>
<tbody>
";
//count unresolved calls
$result=mysql_query("Select (select count(*) from error_log where status >=2 ) as unresolved_count");

while ($row = mysql_fetch_assoc($result)){

echo"

	<div class='alert alert-error'><span class='badge badge-warning'>{$row['unresolved_count']}</span> Unresolved Calls  
	</div>";
}
//query unresolved calls
	$result=mysql_query("SELECT * FROM error_log as e
inner join 
			caller_log on e.caller_id = caller_log.caller_id
			inner join support_log on e.support_id=support_log.support_id AND e.status >='2'
group by error_id");
if (mysql_num_rows($result)===0){echo "
	<p class='muted'><img src='images/folder_star.png'> No Calls marked as unresolved</p>";
}else{
while ($row = mysql_fetch_assoc($result)){

echo"
<tr>
<td><img src='images/flag_red.png'>{$row['error_id']}</td>
<td> <a href='error_profile.php?error_id={$row['error_id']}&caller_id={$row['caller_id']}'>{$row['support_type']}</a></td>
<td> {$row['caller_fname']} {$row['caller_lname']}</td>
</tr>
";

	}
}
//# of calls recorded
$result=mysql_query("Select (select count(*) from error_log) as error_count");	
	
	while($row = mysql_fetch_array($result)){
echo"	
</tbody>
</table>
			<p class='alert alert-block'><span class='badge badge-info'>{$row['error_count']}</span> Calls recorded</p>
			<hr />
</div>";
}
 
	

/* Close log for DB Modifications */
//if ($_uid >= 2){
//	 echo "I'm sorry but you can not enter data into the caller log. Database under construction";
//}else{
echo"
<div class='span8'>
      <!--Body content-->
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
   <div class='btn-toolbar'>
  <div class='btn-group'>
<a href='search_tool.php' class='btn'><i class='icon-search'></i>Search Callers</a>
<a href='submitt_caller.php' class='btn'><i class='icon-user'></i>Submit New Caller</a>
</div>
</div>";
//}


?>