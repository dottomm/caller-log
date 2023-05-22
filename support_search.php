<?php

	
$caller_fname=getvar("caller_fname");
$caller_lname=getvar("caller_lname");
$support_id=getvar("support_id");
$support_type=getvar("support_type");
$title=getvar("title");
$bgcolor=#fff;
$errmsg="";

$support = getvar("support");
$metode = getvar("metode");
$support_id=getvar("support_id");
$support_type=getvar("support_type");


$doit=getvar("doit");



	echo "<a name='search'></a>
<h3>Search Desired Results <i>access</i> Call Log by Support Type</h3>

<form method='post' action='{$_SERVER["PHP_SELF"]}#support' name='support'>
	<input type='hidden' name='doit' value='yes'>
	
<p><select name='support' value={$support}>";

	$result=mysql_query("select * from support_log ");
		while ($d=mysql_fetch_assoc($result)){
			echo"<option value='{$d['support_id']}'>{$d['support_type']}</option>";
} 
echo"</select>
<input type='submit'   value ='Search by Support Type' class='btn'>

			<p class='text-info'>Please specify criteria before submitting a search</p>
</form>";


if($doit="yes"){	
if ($support !="") {
// shoot off query
$res = mysql_query ("select *  from error_log e 
		inner join caller_log c on e.caller_id=c.caller_id
		inner join support_log s on e.support_id=s.support_id
	where e.support_id=$support");
 				 $count=mysql_num_rows($res);
 				 	if(mysql_num_rows($res)==0){
	 				 	echo"<p class='text-error'>Sorry. No Support Records match that criteria.</p>";
 				 	}else{
	 				 	echo"<p class='text-success'>We've found <span class='badge badge-info'>$count</span> matches to your search criteria</p>";
 				 	}
 				 while ($row=mysql_fetch_assoc($res)){
 		  
			echo"  
			<pre>
{$row['error_id']} <a href='error_profile.php?error_id={$row['error_id']}&caller_id={$row['caller_id']}'>{$row['support_type']}</a> &nbsp; <a href='caller_profile.php?caller_id={$row['caller_id']}'>{$row['caller_fname']} {$row['caller_lname']}</a>
</pre>";

;
}

		}
	}


?>